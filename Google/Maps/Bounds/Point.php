<?php

/* $Id$ $ */

require_once 'Google/Maps/Overload.php';
require_once 'Google/Maps/Point.php';

class Google_Maps_Bounds_Point extends Google_Maps_Overload {

    protected $min_x;
    protected $min_y;
    protected $max_x;
    protected $max_y;
    
    public function __construct($point_list) {
        $point = array_pop($point_list);
        $this->setMinX($point->getX());
        $this->setMinY($point->getY());
        $this->setMaxX($point->getX());
        $this->setMaxY($point->getY());

        foreach ($point_list as $point) {
            if ($point->getX() < $this->getMinX()) {
                $this->setMinX($point->getX());
            }
            if ($point->getX() > $this->getMaxX()) {
                $this->setMaxX($point->getX());
            }
            if ($point->getY() < $this->getMinY()) {
                $this->setMinY($point->getY());
            }
            if ($point->getY() > $this->getMaxY()) {
                $this->setMaxY($point->getY());
            }
        }    
    }
    
    public function getNorthEast() {
        $x = $this->getMinX();
        $y = $this->getMinY();
        return new Google_Maps_Point($x, $y);
    }
    
    public function getSouthWest() {
        $x = $this->getMaxX();
        $y = $this->getMaxY();
        return new Google_Maps_Point($x, $y);        
    }
        
}