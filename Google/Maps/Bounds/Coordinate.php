<?php

/*
 * Google_Maps_Bounds_Coordinate
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

class Google_Maps_Bounds_Coordinate extends Google_Maps_Overload {

    protected $min_lon;
    protected $min_lat;
    protected $max_lon;
    protected $max_lat;
    
    public function __construct($location_list) {

        /* Make sure everything is a coordinate. */
        $coordinate_list = array();
        foreach ($location_list as $location) {
            if ('Google_Maps_Point' == get_class($location)) {
                $coordinate_list[] = $location->toCoordinate();
            } else {
                $coordinate_list[] = $location;
            }
        }

        $coordinate = array_pop($coordinate_list);
        $this->setMinLon($coordinate->getLon());
        $this->setMinLat($coordinate->getLat());
        $this->setMaxLon($coordinate->getLon());
        $this->setMaxLat($coordinate->getLat());

        foreach ($coordinate_list as $coordinate) {
            if ($coordinate->getLon() < $this->getMinLon()) {
                $this->setMinLon($coordinate->getLon());
            }
            if ($coordinate->getLon() > $this->getMaxLon()) {
                $this->setMaxLon($coordinate->getLon());
            }
            if ($coordinate->getLat() < $this->getMinLat()) {
                $this->setMinLat($coordinate->getLat());
            }
            if ($coordinate->getLat() > $this->getMaxLat()) {
                $this->setMaxLat($coordinate->getLat());
            }
        }
        
    }
    
    public function getNorthEast() {
        $lon = $this->getMinLon();
        $lat = $this->getMinLat();
        return new Google_Maps_Coordinate($lat, $lon);
    }
    
    public function getSouthWest() {
        $lon = $this->getMaxLon();
        $lat = $this->getMaxLat();
        return new Google_Maps_Coordinate($lat, $lon);
    }
    
    public function contains($location) {
        $retval     = false;
        $coordinate = $location->toCoordinate();
        if ($coordinate->getLon() < $this->getMaxLon() && $coordinate->getLon() > $this->getMinLon() &&
            $coordinate->getLat() < $this->getMaxLat() && $coordinate->getLat() > $this->getMinLat()) {
                $retval = true;
        }
        
        return $retval;
        
    }
    
    public function getBoundsPath() {
        return array(new Google_Maps_Path($this->getMinLat(), $this->getMinLon()),
                     new Google_Maps_Path($this->getMinLat(), $this->getMaxLon()),
                     new Google_Maps_Path($this->getMaxLat(), $this->getMaxLon()),
                     new Google_Maps_Path($this->getMaxLat(), $this->getMinLon()),
                     new Google_Maps_Path($this->getMinLat(), $this->getMinLon()));
    }
        
}