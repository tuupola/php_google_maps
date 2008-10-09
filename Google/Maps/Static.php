<?php

/*
 * Google_Maps_Static
 *
 * Copyright (c) 2008 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/google_maps
 *
 * Revision: $Id$
 *
 */
 
require_once 'Google/Maps/Overload.php';
require_once 'Google/Maps/Bounds.php';

class Google_Maps_Static extends Google_Maps_Overload {
    
    protected $center;
    protected $zoom = 8;
    protected $size;
    protected $format;
    protected $maptype;
    protected $markers = array();
    protected $path;
    protected $span;
    protected $frame;
    protected $language;
    protected $key;
    protected $controls = array();
    protected $min_zoom = 1;
    protected $max_zoom = 21;
    
    /**
    * Class constructor.
    *
    * @param    array $params Optional parameters.
    * @return   object Google_Maps_Static
    */
    public function __construct($params) {
        $this->setProperties($params);
    }

    /**
    * Return center of the map. If center is not set is it calculated from markers.
    * If map has no markers return default center (which is Tallinn).
    *
    * @return   object Google_Maps_Coordinate
    */
    public function getCenter() {
        $retval = $this->center;
        if ('Google_Maps_Coordinate' != get_class($this->center)) {
            if (count($this->getMarkers())) {
                $retval = $this->calculateCenter();                
            } else {
                return new Google_Maps_Coordinate(59.439000, 24.750100);
            }
        }
        return $retval;
    }

    /**
    * Set center of the map. Converts lat,lon string to Google_Maps_Coordinate
    * when needed.
    *
    * @param    mixed lat,lon string or Google_Maps_Coordinate
    */
    public function setCenter($location) {
        if ('Google_Maps_Coordinate' != get_class($this->center)) {
            list($lat, $lon) = explode(',', $location);
            $this->center = new Google_Maps_Coordinate($lat, $lon);
        } else {
            $this->center = $location;
        }
    }

    /**
    * Return calculated center of the map.
    *
    * @return   object Google_Maps_Coordinate
    */
    public function calculateCenter() {
        /* Calculate average lat and lon of markers. */
        $lat_sum = $lon_sum = 0;
        foreach ($this->getMarkers() as $marker) {
           $lat_sum += $marker->getLat();
           $lon_sum += $marker->getLon();
        }
        $lat_avg = $lat_sum / count($this->getMarkers());
        $lon_avg = $lon_sum / count($this->getMarkers());
        
        return new Google_Maps_Coordinate($lat_avg, $lon_avg);
    }
    
    /**
    * Set and return zoom of the map so all markers fit to screen. Takes map 
    * center into account when it is set. 
    *
    * @return   integer New zoom level.
    */
    public function zoomToFit() {
        $zoom    = 21;
        $found   = false;
        while ($found == false) {
            $this->setZoom($zoom);
            $map_bounds = $this->getBounds();
            $found = true;
            foreach ($this->getMarkers() as $marker) {
                if ($map_bounds->contains($marker)) {
                } else {
                    $found = false;
                    break;
                }
            }
            $zoom--;
        }
        
        return $zoom;
    }
    
    /**
    * Return smallest possible bounds where all markers fit in.
    *
    * @return   object Google_Maps_Bounds
    */
    public function getMarkerBounds() {
        return new Google_Maps_Bounds($this->getMarkers());
    }

    /**
    * Draw marker bounds to map. Useful for debugging.
    *
    */
    public function showMarkerBounds() {
        $marker_bounds = $this->getMarkerBounds();
        $bounds_path   = $marker_bounds->getPath();
        $this->setPath($bounds_path);
    }
    
    /**
    * Return map width in pixels.
    *
    * @return   integer Map width in pixels
    */
    public function getWidth() {
        list($width, $height) = explode('x', $this->getSize());
        return $width;
    }
    
    /**
    * Return map height in pixels.
    *
    * @return   integer Map height in pixels
    */
    public function getHeight() {     
        list($width, $height) = explode('x', $this->getSize());
        return $height;
    }

    /**
    * Return bounds of current map.
    *
    * @return   object Google_Maps_Bounds
    */
    public function getBounds($zoom = '') {
        $old_zoom = $this->getZoom();
        if ($zoom) {
            $this->setZoom($zoom);
        }
        $delta_x  = round($this->getWidth() / 2);
        $delta_y  = round($this->getHeight() / 2);

        $lat      = $this->getCenter()->getLat();
        $lon      = $this->getCenter()->getLon();
        $zoom     = $this->getZoom();
        
        $north    = Google_Maps_Mercator::adjustLatByPixels($lat, $delta_y * -1, $zoom);
        $south    = Google_Maps_Mercator::adjustLatByPixels($lat, $delta_y, $zoom);
        $west     = Google_Maps_Mercator::adjustLonByPixels($lon, $delta_x * -1, $zoom);
        $east     = Google_Maps_Mercator::adjustLonByPixels($lon, $delta_x, $zoom);
        
        $north_west = new Google_Maps_Coordinate($north, $west);
        $north_east = new Google_Maps_Coordinate($north, $east);
        $south_west = new Google_Maps_Coordinate($south, $west);
        $south_east = new Google_Maps_Coordinate($south, $east);

        $this->setZoom($old_zoom);
        
        return new Google_Maps_Bounds(array($north_west, $south_east));       
    }
    
    /**
    * Return markers of current map in either array or as a string
    * which can be used in image URL.
    *
    * @param    string $type Either 'array' of 'string'.
    * @return   mixed Array or string.
    */
    public function getMarkers($type = 'array') {
        $retval = $this->markers;
        if ('string' == $type) {
            $retval = '';
            if (is_array($this->markers)) {
                foreach ($this->markers as $marker) {
                    $retval .= $marker;
                    $retval .= '|';
                }                
            }
        }
        return $retval;
    }

    /**
    * Return path of current map in either array or as a string
    * which can be used in image URL.
    *
    * @param    string $type Either 'array' of 'string'.
    * @return   mixed Array or string.
    */
    public function getPath($type = 'array') {
        $retval = $this->path;
        if ('string' == $type && is_array($this->path)) {
            $retval = '';
            foreach ($this->path as $coordinate) {
                $retval .= $coordinate;
                $retval .= '|';
            }
        }
        return $retval;
    }
    
    /**
    * Add marker to map. 
    * 
    * @param    object Google_Maps_Marker
    * @return   integer Total number of markers in map.
    */
    public function addMarker($marker) {
        $this->markers[] = $marker;
        return count($this->getMarkers());
    }
    
    /**
    * Remove marker from map.
    * 
    * @param    object Google_Maps_Marker
    * @return   integer Total number of markers in map.
    */
    public function removeMarker() {
        
    }

    /**
    * Add control to map. 
    * 
    * @param    object Google_Maps_Control
    * @return   integer Total number of controls in map.
    */
    public function addControl($control) {
        $this->controls[] = $control;
        return count($this->getControls());
    }
    
    /**
    * Remove controls from map.
    * 
    * @param    object Google_Maps_Control
    * @return   integer Total number of controls in map.
    */
    public function removeControl() {
        
    }   
    
    /**
    * Zoom out one level
    * 
    * @return   integer New zoom level.
    */
    public function zoomOut() {
        $new_zoom = max($this->getMinZoom(), $this->getZoom() - 1);
        $this->setZoom($new_zoom);
        return $new_zoom;
    }

    /**
    * Zoom in one level
    * 
    * @return   integer New zoom level.
    */
    public function zoomIn() {
        $new_zoom = min($this->getMaxZoom(), $this->getZoom() + 1);
        $this->setZoom($new_zoom);
        return $new_zoom;
    }

    /**
    * Pan north by pixels
    * 
    * @return   object Google_Maps_Coordinate
    */
    public function panNorth($pixels) {
        $center = $this->getCenter();    
        $new_lat = Google_Maps_Mercator::adjustLatByPixels($center->getLat(), $pixels * -1,  $this->getZoom());
        $center->setLat($new_lat);
        $this->setCenter($center);
        return $center;
    }

    /**
    * Pan south by pixels
    * 
    * @return   object Google_Maps_Coordinate
    */
    public function panSouth($pixels) {
        $center = $this->getCenter();    
        $new_lat = Google_Maps_Mercator::adjustLatByPixels($center->getLat(), $pixels,  $this->getZoom());
        $center->setLat($new_lat);
        $this->setCenter($center);
        return $center;
    }

    /**
    * Pan west by pixels
    * 
    * @return   object Google_Maps_Coordinate
    */
    public function panWest($pixels) {
        $center = $this->getCenter();    
        $new_lon = Google_Maps_Mercator::adjustLonByPixels($center->getLon(), $pixels * -1,  $this->getZoom());
        $center->setLon($new_lon);
        $this->setCenter($center);
        return $center;
    }
    
    /**
    * Pan east by pixels
    * 
    * @return   object Google_Maps_Coordinate
    */
    public function panEast($pixels) {
        $center = $this->getCenter();    
        $new_lon = Google_Maps_Mercator::adjustLonByPixels($center->getLon(), $pixels, $this->getZoom());
        $center->setLon($new_lon);
        $this->setCenter($center);
        return $center;
    }


    /**
    * Return image URL query string for current map.
    * 
    * @return   string Static map image URL querystring.
    */
    public function toQueryString($include_key = false) {        
        $url['center'] = $this->getCenter()->__toString();
        $url['zoom'] = $this->getZoom();
        $url['markers'] = $this->getMarkers('string');
        $url['path'] = $this->getPath('string');
        $url['size'] = $this->getSize();
        
        if ($include_key) {
            $url['key'] = $this->getKey();            
        }
        
        return http_build_query($url);
    }

    /**
    * Return image URL for current map.
    * 
    * @return   string Static map image URL.
    */
    public function toUrl() {                
        return 'http://maps.google.com/staticmap?' . $this->toQueryString(true);
    }
        
    /**
    * Return image tag for current map.
    * 
    * @return   string Static map image URL.
    */
    public function toImgTag() {
        return sprintf('<img src="%s" width="%d" height="%d" alt="" />',
                        $this->toUrl(), $this->getWidth(), $this->getHeight());
    }
    
    /**
    * Return full HTML for current map. Including controls and markers.
    * 
    * @return   string Static map HTML.
    */
    public function toHtml() {
        $retval  = sprintf('<div id="map" style="width:%dpx; height:%dpx">', 
                           $this->getWidth(), $this->getHeight());
        $retval .= $this->toImgTag();
        $retval .= '<div id="controls">';
        foreach ($this->getControls() as $control) {
            $retval .= $control->toHtml($this);
        }
        $retval .= '</div>';
        $retval .= '</div>';


        return $retval;
    }
    
    public function __toString() {
        return $this->toUrl();
    }
    
}