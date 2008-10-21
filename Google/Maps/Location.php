<?php

/*
 * Google_Maps_Location
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

abstract class Google_Maps_Location extends Google_Maps_Overload {

    /**
    * Return point as coordinate.
    *
    * @return   object Google_Maps_Coordinate
    */
    abstract public function toCoordinate();
    
    /**
    * Return coordinate as point.
    *
    * @return   object Google_Maps_Point
    */
    abstract public function toPoint();
        
    public function getContainerX(Google_Maps_Static $map) {
        $zoom     = $map->getZoom();
        $target_x = $this->toPoint()->getX();
        $center_x = $map->getCenter()->toPoint()->getX();        
        $delta_x  = ($target_x - $center_x) >> (21 - $zoom);
        
        $center_offset_x = round($map->getWidth() / 2);
        
        return $center_offset_x + $delta_x;
    }

    public function getContainerY(Google_Maps_Static $map) {
        $zoom     = $map->getZoom();
        $target_y = $this->toPoint()->getY();
        $center_y = $map->getCenter()->toPoint()->getY();        
        $delta_y  = ($target_y - $center_y) >> (21 - $zoom);
        
        $center_offset_y = round($map->getHeight() / 2);
        
        return $center_offset_y + $delta_y;
    }

}