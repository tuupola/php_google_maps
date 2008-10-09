<?php

/*
 * Google_Maps_Control_Zoom
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
    
class Google_Maps_Control_Zoom extends Google_Maps_Overload {
    
    protected $zoom_in_image = 'http://www.google.com/intl/en_ALL/mapfiles/zoom-plus-mini.png';
    protected $zoom_in_id    = 'zoom_in';
    protected $zoom_in_alt   = 'Zoom In';

    protected $zoom_out_image = 'http://www.google.com/intl/en_ALL/mapfiles/zoom-minus-mini.png';
    protected $zoom_out_id    = 'zoom_out';
    protected $zoom_out_alt   = 'Zoom Out';
    
    public function toHtml(Google_Maps_Static $map) {
        $original = $map->getZoom();
        $map->zoomIn();
        $zoom_in  = sprintf('<a rel="nofollow" href="%s"><img src="%s" id="%s" alt="%s" /></a>',
                     $_SERVER['PHP_SELF'] . '?' . $map->toQueryString(), $this->getZoomInImage(), $this->getZoomInId(), $this->getZoomInAlt());
        $map->setZoom($original);
        $map->zoomOut();
        $zoom_out = sprintf('<a rel="nofollow" href="%s"><img src="%s" id="%s" alt="%s" /></a>',
                    $_SERVER['PHP_SELF'] . '?' . $map->toQueryString(), $this->getZoomOutImage(), $this->getZoomOutId(), $this->getZoomOutAlt());
        $map->setZoom($original);
        return $zoom_in . $zoom_out;
    }
 
}