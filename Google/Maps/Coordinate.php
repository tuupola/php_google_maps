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
 
require_once 'Google/Maps/Overload.php';
require_once 'Google/Maps/Mercator.php';
require_once 'Google/Maps/Point.php';

class Google_Maps_Coordinate extends Google_Maps_Overload {

    protected $lat;
    protected $lon;
    
    public function __construct($lat, $lon) {
        $this->setLat($lat);
        $this->setLon($lon);
    }

    public function toPoint() {        
        $lat = $this->getLat();
        $lon = $this->getLon();
        $x = Google_Maps_Mercator::LonToX($lon);
        $y = Google_Maps_Mercator::LatToY($lat);
        return new Google_Maps_Point($x, $y);
    }
    
    public function __toString() {
        return $this->getLat() . ',' . $this->getLon();
    }
    
}