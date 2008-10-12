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

}