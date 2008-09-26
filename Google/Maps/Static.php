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
    protected $zoom;
    protected $size;
    protected $format;
    protected $maptype;
    protected $markers;
    protected $path;
    protected $span;
    protected $frame;
    protected $language;
    protected $key;
        
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
    * Return center of the map. If center is not set is it calculated.
    *
    * @return   object Google_Maps_Coordinate
    */
    public function getCenter() {
        $retval = $this->center;
        if ('Google_Maps_Coordinate' != get_class($this->center)) {
            $retval = $this->calculateCenter();
        }
        return $retval;
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
    * Return image URL for current map.
    * 
    * @return   string Static map image URL.
    */
    public function toUrl() {        
        $url['center'] = $this->getCenter()->__toString();
        $url['zoom'] = $this->getZoom();
        $url['markers'] = $this->getMarkers('string');
        $url['path'] = $this->getPath('string');
        $url['size'] = $this->getSize();
        $url['key'] = $this->getKey();
        
        return 'http://maps.google.com/staticmap?' .  http_build_query($url);
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
    
    public function __toString() {
        return $this->toUrl();
    }
    
}