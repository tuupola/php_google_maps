<?php

/*
 * Google_Maps_Mercator
 *
 * Copyright (c) 2008 Mika Tuupola, Bratliff
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/google_maps
 *
 * Based on adjust.js by Bratliff:
 *   http://www.polyarc.us/adjust.js
 *
 * Revision: $Id$
 *
 */
 
class Google_Maps_Mercator {

    public static $offset = 268435456;
    public static $radius = 85445659.44705395; /* $offset / pi(); */
    
    static function LonToX($lon) {
        return round(self::$offset + self::$radius * $lon * pi() / 180);        
    }

    static function LatToY($lat) {
        return round(self::$offset - self::$radius * log((1 + sin($lat * pi() / 180)) / (1 - sin($lat * pi() / 180))) / 2);
    }

    static function XToLon($x) {
        return ((round($x) - self::$offset) / self::$radius) * 180/ pi(); 
    }

    static function YToLat($y) {
        return (pi() / 2 - 2 * atan(exp((round($y) - self::$offset) / self::$radius))) * 180 / pi(); 
    }

    static function adjustLonByPixels($lon, $delta, $zoom) {
        return self::XToLon(self::LonToX($lon) + ($delta << (21 - $zoom)));
    }

    static function adjustLatByPixels($lat, $delta, $zoom) {
        return self::YToLat(self::LatToY($lat) + ($delta << (21 - $zoom)));
    }


}
