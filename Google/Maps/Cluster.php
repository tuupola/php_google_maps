<?php

/*
 * Google_Maps_Cluster
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
 
require_once 'Google/Maps/Coordinate.php';
 
class Google_Maps_Cluster extends Google_Maps_Marker {
    
    protected $markers;
    
    static private $counter = 1;
    
    /**
    * Class constructor.
    *
    * @param    array $markers Google_Maps_Marker 
    * @param    array $params Optional parameters for color, size and character.
    * @return   object
    */
    public function __construct($markers = array(), $params = array()) {
        $count = $this->setMarkers($markers);
        $this->setCharacter($count);
        $this->setProperties($params);
        $this->setId('cluster_' . self::$counter++);
    }
    
    /**
    * Set markers which create this cluster.
    *
    * @param    array $markers Google_Maps_Marker 
    * @return   integer number of markers in this cluster.
    */
    public function setMarkers($markers = array()) {
        $this->markers = $markers;
        return count($markers);
    }
    
    /**
    * Return coordinate for this cluster. If coordinate is not set is it 
    * average calculated from markers. 
    *
    * @return   object Google_Maps_Coordinate
    */
    public function getCoordinate() {
        $retval = $this->coordinate;
        if ('Google_Maps_Coordinate' != get_class($this->coordinate)) {
            if (count($this->getMarkers())) {
                $retval = $this->calculateCenter();                
            } else {
                /* Center was not set and could not calculate. Return default. */
                return new Google_Maps_Coordinate(59.439000, 24.750100);
            }
        }
        return $retval;
    }
    
    /**
    * Return average center of markers
    *
    * @return   object Google_Maps_Coordinate
    */
    public function calculateCenter() {
        /* Calculate average lat and lon of markers. */
        $lat_sum = $lon_sum = 0;
        foreach ($this->getMarkers() as $marker) {
           $lat_sum += $marker->getLat();
           $lon_sum += $marker->getLon();
        }
        $lat_avg = $lat_sum / count($this->getMarkers());
        $lon_avg = $lon_sum / count($this->getMarkers());
        
        return new Google_Maps_Coordinate($lat_avg, $lon_avg);
    }
            
    public function __toString() {
        $retval = $this->getLat() . ',' . $this->getLon() . ','. $this->getSize() . $this->getColor() . $this->getCharacter();
        return preg_replace('/,$/', '', $retval);
    }
        
}