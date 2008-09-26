<?php

/*
 * Google_Maps_Marker
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
 
require_once 'Google/Maps/Coordinate.php';
 
class Google_Maps_Marker extends Google_Maps_Overload {
    
    protected $coordinate;
    protected $color;
    protected $size;
    protected $character;
    
    /**
    * Class constructor.
    *
    * @param    object $location Google_Maps_Coordinate|Point 
    * @param    array $params Optional parameters for color, size and character.
    * @return   object
    */
    public function __construct($location, $params = array()) {
        $this->setCoordinate($location);
        $this->setProperties($params);
    }
    
    /**
    * Set the coordinate of current marker object.
    *
    * @param    object $location Google_Maps_Coordinate|Point 
    */
    public function setCoordinate($location) {
        $this->coordinate = $location->toCoordinate();
    }

    /**
    * Return marker as coordinate in Google Maps.
    *
    * @return   object Google_Maps_Coordinate
    */
    public function toCoordinate() {
        return $this->getCoordinate();
    }
    
    /**
    * Return marker as pixel point in Google Maps.
    *
    * @return   object Google_Maps_Point
    */
    public function toPoint() {
        return $this->getCoordinate()->toPoint();
    }
    
    /**
    * Return latitude of marker coordinate.
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
        return $this->getLat() . ',' . $this->getLon() . ','. $this->getColor() . $this->getSize() . $this->getCharacter();
    }
        
}