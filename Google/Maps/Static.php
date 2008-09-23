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
require_once 'Net/URL.php';

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
    
    public function setProperties($params) {
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $method = 'set' . $key;
                $this->$method($value);
            }
        }        
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

        $lat      = $this->center->getLat();
        $lon      = $this->center->getLon();
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
        if ('string' == $type) {
            $retval = '';
            foreach ($this->path as $coordinate) {
                $retval .= $coordinate;
                $retval .= '|';
            }
        }
        return $retval;
    }
    
    public function __toString() {
        /* Build the URL's for Static Maps API. */
        $url = new Net_URL('http://maps.google.com/staticmap');
        $url->addQueryString('center',  $this->getCenter());
        $url->addQueryString('zoom',    $this->getZoom());
        $url->addQueryString('markers', $this->getMarkers('string'));
        $url->addQueryString('path',    $this->getPath('string'));
        $url->addQueryString('size',    $this->getSize());
        $url->addQueryString('key',     $this->getKey());
        return $url->getUrl();
    }
    
}