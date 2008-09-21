<?php

/* $Id$ */

require_once 'Google/Maps/Overload.php';
require_once 'Google/Maps/Coordinate.php';

class Google_Maps_Bounds extends Google_Maps_Overload {
        
    public function create($location_list) {
        $class_name  = get_class($location_list[0]);
        $type        = array_pop(explode("_", $class_name));
        
        unset($class_name);
        $class_name = 'Google_Maps_Bounds_' . ucfirst($type);
        $file_name  = str_replace('_', DIRECTORY_SEPARATOR, $class_name).'.php';
        require_once $file_name;
        
        return new $class_name($location_list);        
    }
    
}