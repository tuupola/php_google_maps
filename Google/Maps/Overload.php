<?php

/*
 * Google_Maps_Overload
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

class Google_Maps_Overload {

    public function __call($method, $params) {

        $var     = get_object_vars($this);
        $retval = false;

        if (strpos($method, 'get') === 0) {
            $property = Google_Maps_Overload::underscore(substr($method, 3));
            if (array_key_exists($property, $var)) {
                $retval = $this->$property;
            }
        } elseif (strpos($method, 'set') === 0) {
            $property = Google_Maps_Overload::underscore(substr($method, 3));
            if (array_key_exists($property, $var)) {
                $this->$property = $params[0];
                $retval = null;
            }
        }
        return $retval;  
    }

    public function setProperties($params) {
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $method = 'set' . $key;
                $this->$method($value);
            }
        }        
    }
    
    protected static function underscore($word) {
        $underscored = strtolower(preg_replace('/(?<=\\w)([A-Z])/', '_\\1', $word));
        $underscored = strtolower(preg_replace('/([0-9])([a-z])/', '\\1_\\2', $underscored));        
        $underscored = strtolower(preg_replace('/([a-z])([0-9])/', '\\1_\\2', $underscored));        
        $underscored = preg_replace('/__/', '_', $underscored);        
        return $underscored;
    }

}