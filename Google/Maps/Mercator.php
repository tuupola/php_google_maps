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

    /* TODO: Clean up rest of this. */

    static function adjustLonByPixels($lon, $delta, $zoom) {
        return self::XToLon(self::LonToX($lon) + ($delta << (21 - $zoom)));
    }

    static function adjustLatByPixels($lat, $delta, $zoom) {
        return self::YToLat(self::LatToY($lat) + ($delta << (21 - $zoom)));
    }

    static function getLatLonBounds($lat_avg, $lon_avg, $map_height, $map_width, $zoom) {
        $top_left_lat      = Google_Maps::adjustLatByPixels($lat_avg, $map_height / 2 * -1, $zoom);
        $top_left_lon      = Google_Maps::adjustLonByPixels($lon_avg, $map_width / 2 * -1, $zoom);
        $bottom_right_lat  = Google_Maps::adjustLatByPixels($lat_avg, $map_height / 2, $zoom);
        $bottom_right_lon  = Google_Maps::adjustLonByPixels($lon_avg, $map_width / 2, $zoom);
        return array($top_left_lat, $top_left_lon, $bottom_right_lat, $bottom_right_lon);
    }

}
    /*
    print $x = Google_Maps::LtoX(58.38133351447725) . "\n";
    print $y = Google_Maps::LtoY(24.516592025756836) . "\n";
    print $x = Google_Maps::XtoL($x) . "\n";
    print $y = Google_Maps::YtoL($y) . "\n";
    print Google_Maps::adjustLonByPixels(58.38133351447725, 100, 10) . "\n";
    print Google_Maps::adjustLatByPixels(24.516592025756836, 100, 10) . "\n";
    */


 