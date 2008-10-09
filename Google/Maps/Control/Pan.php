<?php

/*
 * Google_Maps_Control_Pan
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

class Google_Maps_Control_Pan extends Google_Maps_Overload {

    protected $pan_north_image = 'http://www.google.com/intl/en_ALL/mapfiles/north-mini.png';
    protected $pan_north_id    = 'pan_north';
    protected $pan_north_alt   = 'Pan north';

    protected $pan_west_image = 'http://www.google.com/intl/en_ALL/mapfiles/west-mini.png';
    protected $pan_west_id    = 'pan_west';
    protected $pan_west_alt   = 'Pan west';

    protected $pan_east_image = 'http://www.google.com/intl/en_ALL/mapfiles/east-mini.png';
    protected $pan_east_id    = 'pan_east';
    protected $pan_east_alt   = 'Pan east';

    protected $pan_south_image = 'http://www.google.com/intl/en_ALL/mapfiles/south-mini.png';
    protected $pan_south_id    = 'pan_south';
    protected $pan_south_alt   = 'Pan south';

    public function toHtml(Google_Maps_Static $map) {
        $map->panNorth(60);
        $pan_north  = sprintf('<a rel="nofollow" href="%s"><img src="%s" id="%s" alt="%s" /></a>',
                      $_SERVER['PHP_SELF'] . '?' . $map->toQueryString(), $this->getPanNorthImage(), $this->getPanNorthId(), $this->getPanNorthAlt());
        $map->panSouth(60);
  
        $map->panWest(100);
        $pan_west  = sprintf('<a rel="nofollow" href="%s"><img src="%s" id="%s" alt="%s" /></a>',
                      $_SERVER['PHP_SELF'] . '?' . $map->toQueryString(), $this->getPanWestImage(), $this->getPanWestId(), $this->getPanWestAlt());
        $map->panEast(100);

        $map->panEast(100);
        $pan_east  = sprintf('<a rel="nofollow" href="%s"><img src="%s" id="%s" alt="%s" /></a>',
                      $_SERVER['PHP_SELF'] . '?' . $map->toQueryString(), $this->getPanEastImage(), $this->getPanEastId(), $this->getPanEastAlt());
        $map->panWest(100);

        $map->panSouth(60);
        $pan_south  = sprintf('<a rel="nofollow" href="%s"><img src="%s" id="%s" alt="%s" /></a>',
                      $_SERVER['PHP_SELF'] . '?' . $map->toQueryString(), $this->getPanSouthImage(), $this->getPanSouthId(), $this->getPanSouthAlt());
        $map->panNorth(60);

        return $pan_north . $pan_west . $pan_east . $pan_south;
    }
    
}