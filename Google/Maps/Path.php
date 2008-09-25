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
        return $this->getLat() . ',' . $this->getLon();
    }

}