<?php

/*
 * Google_Maps_Point
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
require_once 'Google/Maps/Mercator.php';
require_once 'Google/Maps/Coordinate.php';

class Google_Maps_Point extends Google_Maps_Overload {

    protected $x;
    protected $y;

    /**
    * Class constructor.
    *
    * @param    integer $x Pixel x coordinate in map
    * @param    integer $y Pixel y coordinate in map
    * @return   object
    */
    public function __construct($x, $y) {
        $this->setX($x);
        $this->setY($y);
    }
    
    /**
    * Return point as coordinate.
    *
    * @return   object Google_Maps_Coordinate
    */
    public function toCoordinate() {       
        $x = $this->getX();
        $y = $this->gety();
        $lat = Google_Maps_Mercator::YToLat($y);
        $lon = Google_Maps_Mercator::XToLon($x);
        return new Google_Maps_Coordinate($lat, $lon);
    }
    
    /**
    * Return point as point in Google Maps. This method
    * exists only to provide unified API between coordinate and 
    * point objects.
    *
    * @return   object Google_Maps_Point
    */
    public function toPoint() {
        return $this;
    }

}