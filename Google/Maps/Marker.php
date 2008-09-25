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
    
    public function __construct($location, $params = array()) {
        $this->setCoordinate($location);
        $this->setProperties($params);
    }
    
    public function setCoordinate($location) {
        $this->coordinate = $location->toCoordinate();
    }

    /* TODO: this is an kludge. */
    public function toCoordinate() {
        return $this->getCoordinate();
    }
    
    public function toPoint() {
        return $this->getCoordinate()->toPoint();
    }
    
    public function getLat() {
        return $this->getCoordinate()->getLat();
    }

    public function getLon() {
        return $this->getCoordinate()->getLon();
    }
    
    public function __toString() {
        return $this->getLat() . ',' . $this->getLon() . ','. $this->getColor() . $this->getSize() . $this->getCharacter();
    }
        
}