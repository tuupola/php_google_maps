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

    protected $lat;
    protected $lon;

    public function __construct($lat, $lon, $params = array()) {
        $this->setLat($lat);
        $this->setLon($lon);
    }

    public function __toString() {
        return $this->getLat() . ',' . $this->getLon();
    }

}