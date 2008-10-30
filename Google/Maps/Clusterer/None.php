<?php

/*
 * Google_Maps_Clusterer_None
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

class Google_Maps_Clusterer_None extends Google_Maps_Overload {
    
    public function process(array $markers) {
        return $markers;
    }
    
}