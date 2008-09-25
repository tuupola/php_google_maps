<?php

/*
 * Google_Maps_Bounds_Point
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

class Google_Maps_Bounds_Point extends Google_Maps_Overload {

    protected $min_x;
    protected $min_y;
    protected $max_x;
    protected $max_y;
    
    public function __construct($location_list) {
        
        /* Make sure everything is a point. */
        $point_list = array();
        foreach ($location_list as $location) {
            if ('Google_Maps_Coordinate' == get_class($location)) {
                $point_list[] = $location->toPoint();
            } else {
                $point_list[] = $location;
            }
        }
        
        $point = array_pop($point_list);
        $this->setMinX($point->getX());
        $this->setMinY($point->getY());
        $this->setMaxX($point->getX());
        $this->setMaxY($point->getY());

        foreach ($point_list as $point) {
            if ($point->getX() < $this->getMinX()) {
                $this->setMinX($point->getX());
            }
            if ($point->getX() > $this->getMaxX()) {
                $this->setMaxX($point->getX());
            }
            if ($point->getY() < $this->getMinY()) {
                $this->setMinY($point->getY());
            }
            if ($point->getY() > $this->getMaxY()) {
                $this->setMaxY($point->getY());
            }
        }    
    }
    
    public function getNorthEast() {
        $x = $this->getMinX();
        $y = $this->getMinY();
        return new Google_Maps_Point($x, $y);
    }
    
    public function getSouthWest() {
        $x = $this->getMaxX();
        $y = $this->getMaxY();
        return new Google_Maps_Point($x, $y);        
    }
    
    public function contains($location) {
        $retval = false;
        /*
        $point = $location;
        if ('Google_Maps_Coordinate' == get_class($location)) {
            $point = $location->toPoint();
        }
        */
        $point = $location->toPoint();
        
        if ($point->getX() < $this->getMaxX() && $point->getX() > $this->getMinX() &&
            $point->getY() < $this->getMaxY() && $point->getY() > $this->getMinY()) {
                $retval = true;
        }
        
        return $retval;      
    }

        
}