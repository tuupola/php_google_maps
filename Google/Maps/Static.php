<?php

/*
 * Google_Maps_Static
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

class Google_Maps_Static extends Google_Maps_Overload {
    
    protected $zoom;
    protected $type;
    protected $center;
    protected $markers;
        
    public function __construct($params) {
        $this->setProperties($params);
    }
    
    public function setProperties($params) {
        if (is_array($params)) {
            foreach ($params as $key => $value) {
                $method = 'set' . $key;
                $this->$method($value);
            }
        }        
    }
    
}