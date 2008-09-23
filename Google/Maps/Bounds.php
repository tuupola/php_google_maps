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
        
    public function create($location_list, $type='') {
        $class_name  = get_class($location_list[0]);
        
        if (trim($type)) {
            $type = ucfirst($type);
        } else {
            $type = array_pop(explode("_", $class_name));    
        }
        
        if ('Marker' == $type) {
            $type = 'Coordinate';
        }
        
        unset($class_name);
        $class_name = 'Google_Maps_Bounds_' . ucfirst($type);
        $file_name  = str_replace('_', DIRECTORY_SEPARATOR, $class_name).'.php';
        require_once $file_name;
        
        return new $class_name($location_list);        
    }
    
}