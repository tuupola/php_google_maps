<?php

/*
 * Google_Maps_Coordinate
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
 
require_once 'Google/Maps/Location.php';
require_once 'Google/Maps/Mercator.php';
require_once 'Google/Maps/Point.php';

class Google_Maps_Coordinate extends Google_Maps_Location {

    protected $lat;
    protected $lon;
    
    /**
    * Class constructor.
    *
    * @param    float $lat Latitude
    * @param    float $lon Longitude
    * @return   object
    */
    public function __construct($lat, $lon) {
        $this->setLat($lat);
        $this->setLon($lon);
    }

    /**
    * Return coordinate as point in Google Maps.
    *
    * @return   object Google_Maps_Point
    */
    public function toPoint() {        
        $lat = $this->getLat();
        $lon = $this->getLon();
        $x = Google_Maps_Mercator::LonToX($lon);
        $y = Google_Maps_Mercator::LatToY($lat);
        return new Google_Maps_Point($x, $y);
    }
    
    /**
    * Return coordinate as coordinate. This method exists only
    * provide unified API between coordinate and point objects.
    *
    * @return   object Google_Maps_Coordinate
    */
    public function toCoordinate() {
        return $this;
    }
    
    public function __toString() {
        return $this->getLat() . ',' . $this->getLon();
    }
    
}