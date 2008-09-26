<?php

/*
 * Google_Maps_Path
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
 
class Google_Maps_Path extends Google_Maps_Overload {

    protected $coordinate;

    /**
    * Class constructor.
    *
    * @param    object $location Google_Maps_Coordinate|Point 
    * @param    array $params Optional parameters (not supported at the moment).
    * @return   object
    */
    public function __construct($location, $params = array()) {
        $this->setCoordinate($location);
        $this->setProperties($params);
    }
    
    /**
    * Set the coordinate of current path object.
    *
    * @param    object $location Google_Maps_Coordinate|Point 
    */
    public function setCoordinate($location) {
        $this->coordinate = $location->toCoordinate();
    }

    /**
    * Return path as coordinate in Google Maps.
    *
    * @return   object Google_Maps_Coordinate
    */
    public function toCoordinate() {
        return $this->getCoordinate();
    }

    /**
    * Return path as pixel point in Google Maps.
    *
    * @return   object Google_Maps_Point
    */
    public function toPoint() {
        return $this->getCoordinate()->toPoint();
    }
    
    /**
    * Return latitude of path coordinate.
    *
    * @return   float Latitude
    */
    public function getLat() {
        return $this->getCoordinate()->getLat();
    }

    /**
    * Return longitude of path coordinate.
    *
    * @return   float Longitude
    */
    public function getLon() {
        return $this->getCoordinate()->getLon();
    }

    public function __toString() {
        return $this->getLat() . ',' . $this->getLon();
    }

}