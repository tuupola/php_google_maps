<?php

/*
 * Google_Maps_Bounds
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
require_once 'Google/Maps/Coordinate.php';
require_once 'Google/Maps/Point.php';

class Google_Maps_Bounds extends Google_Maps_Overload {

    protected $min_lon;
    protected $min_lat;
    protected $max_lon;
    protected $max_lat;
    
    /**
    * Class constructor.
    *
    * @param    array which can be mix of Google_Maps_Coordinate|Point objects.
    * @return   object
    */
    
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

    /**
      * Return north-west corner of bounds.
      *
      * @return mixed Google_Maps_Coordinate or Google_Maps_Point
      */
          
    public function getNorthWest($type='') {
        $lat = $this->getMaxLat();
        $lon = $this->getMinLon();
        $retval =  new Google_Maps_Coordinate($lat, $lon);
        if ('point' == $type) {
            $retval = $retval->toPoint();
        }
        return $retval;
    }

    /**
      * Return north-east corner of bounds.
      *
      * @return mixed Google_Maps_Coordinate or Google_Maps_Point
      */
      
    public function getNorthEast($type='') {
        $lat = $this->getMaxLat();
        $lon = $this->getMaxLon();
        $retval =  new Google_Maps_Coordinate($lat, $lon);
        if ('point' == $type) {
            $retval = $retval->toPoint();
        }
        return $retval;
    }
    
    /**
      * Return souts-east corner of bounds.
      *
      * @return mixed Google_Maps_Coordinate or Google_Maps_Point
      */
      
    public function getSouthEast($type='') {
        $lat = $this->getMinLat();
        $lon = $this->getMaxLon();
        $retval = new Google_Maps_Coordinate($lat, $lon);
        if ('point' == $type) {
            $retval = $retval->toPoint();
        }
        return $retval;
    }

    /**
      * Return south-west corner of bounds.
      *
      * @return mixed Google_Maps_Coordinate or Google_Maps_Point
      */
      
    public function getSouthWest($type='') {
        $lat = $this->getMinLat();
        $lon = $this->getMinLon();
        $retval = new Google_Maps_Coordinate($lat, $lon);
        if ('point' == $type) {
            $retval = $retval->toPoint();
        }
        return $retval;
    }

    /**
      * Check if given coordinate, point or bounds is inside bounds
      *
      * @return boolean
      */

    public function contains($bounds_or_location) {
        if ($bounds_or_location instanceof Google_Maps_Bounds) {
            $retval = $this->containsBounds($bounds_or_location); 
        } else {
            $retval = $this->containsLocation($bounds_or_location);             
        }
        return $retval;
    }

    /**
      * Check if given coordinate or point is inside bounds
      *
      * @return boolean
      */

    public function containsLocation(Google_Maps_Location $location) {
        $retval     = false;
        $coordinate = $location->toCoordinate();
        if ($coordinate->getLon() < $this->getMaxLon() && $coordinate->getLon() > $this->getMinLon() &&
            $coordinate->getLat() < $this->getMaxLat() && $coordinate->getLat() > $this->getMinLat()) {
                $retval = true;
        }
        return $retval;
    }
    
    /**
      * Check if given bounds is inside bounds
      *
      * @return boolean
      */
    
    public function containsBounds(Google_Maps_Bounds $bounds) {
        $retval = false;
        if ($this->containsLocation($bounds->getNorthEast()) && 
            $this->containsLocation($bounds->getSouthWest())) {
              $retval = true;
        }
        return $retval;
    }

    /**
      * Returns array of path objects which can be used for drawing
      * borders of current bounds object into the static map. Can be
      * used for debugging.
      *
      * @return array of Google_Maps_Path
      */
    
    public function getPath() {
        return array(new Google_Maps_Path($this->getNorthWest()),
                     new Google_Maps_Path($this->getNorthEast()),
                     new Google_Maps_Path($this->getSouthEast()),
                     new Google_Maps_Path($this->getSouthWest()),
                     new Google_Maps_Path($this->getNorthWest()));
    }
        
}