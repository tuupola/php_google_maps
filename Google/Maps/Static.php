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
        
    public function __construct($params) {
        $this->setProperties($params);
    }

    public function getCenter() {
        $retval = $this->center;
        if ('Google_Maps_Coordinate' != get_class($this->center)) {
            $retval = $this->calculateCenter();
        }
        return $retval;
    }

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
    
    public function getMarkerBounds() {
        return Google_Maps_Bounds::create($this->getMarkers());
    }

    public function showMarkerBounds() {
        $marker_bounds = $this->getMarkerBounds();
        $bounds_path   = $marker_bounds->getBoundsPath();
        $this->setPath($bounds_path);
    }
    
    public function getWidth() {
        list($width, $height) = explode('x', $this->getSize());
        return $width;
    }
    
    public function getHeight() {
        
        list($width, $height) = explode('x', $this->getSize());
        return $height;
    }

    public function getBounds() {
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
        
        return Google_Maps_Bounds::create(array($north_west, $south_east), 'coordinate');       
    }
    
    public function getMarkers($type = 'array') {
        $retval = $this->markers;
        if ('string' == $type) {
            $retval = '';
            foreach ($this->markers as $marker) {
                $retval .= $marker;
                $retval .= '|';
            }
        }
        return $retval;
    }

    public function getPath($type = 'array') {
        $retval = $this->path;
        if ('string' == $type && count($this->path)) {
            $retval = '';
            foreach ($this->path as $coordinate) {
                $retval .= $coordinate;
                $retval .= '|';
            }
        }
        return $retval;
    }
    
    public function addMarker() {
        
    }
    
    public function removeMarker() {
        
    }

    public function __toString() {        
        $url['center'] = $this->getCenter()->__toString();
        $url['zoom'] = $this->getZoom();
        $url['markers'] = $this->getMarkers('string');
        $url['path'] = $this->getPath('string');
        $url['size'] = $this->getSize();
        $url['key'] = $this->getKey();
        
        return 'http://maps.google.com/staticmap?' .  http_build_query($url);
    }
    
}