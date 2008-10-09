<?php

/*
 * Google_Maps_Control
 *
 * Copyright (c) 2008 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/google_maps
 *
 * Revision: $Id: Maps.php 183 2008-09-26 14:49:55Z tuupola $
 *
 */
 
require_once 'Google/Maps/Overload.php';
require_once 'Google/Maps/Coordinate.php';
require_once 'Google/Maps/Point.php';
require_once 'Google/Maps/Marker.php';
require_once 'Google/Maps/Path.php';

class Google_Maps_Control extends Google_Maps_Overload {
        
    public function create($type, $params = array()) {
        $class_name = 'Google_Maps_Control_' . ucfirst($type);
        $file_name  = str_replace('_', DIRECTORY_SEPARATOR, $class_name).'.php';
        require_once $file_name;
        return new $class_name($params);
    }
    
}