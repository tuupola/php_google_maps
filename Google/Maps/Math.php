<?php

/*
 * Google_Maps_Math
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

require_once 'Google/Maps.php';

class Google_Maps_Math {
    
    static public function distance($location_1, $location_2) {
        return Google_Maps_Math::HaversineDistance($location_1, $location_2);
    }
    
    static public function GreatCirleDistance($location_1, $location_2) {
      $lat1 = $location_1->getLat();
      $lon1 = $location_1->getLon();
      $lat2 = $location_2->getLat();
      $lon2 = $location_2->getLon();
      $d = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + 
           cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($lon1) - deg2rad($lon2));
      return 6371.0 * acos($d);
    }
    
    static public function HaversineDistance($location_1, $location_2) {
    /*
        var R = 6371; // km
        var dLat = (lat2-lat1).toRad();
        var dLon = (lon2-lon1).toRad(); 
        var a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                Math.cos(lat1.toRad()) * Math.cos(lat2.toRad()) * 
                Math.sin(dLon/2) * Math.sin(dLon/2); 
        var c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a)); 
    var d = R * c;
    */
      $lat1 = $location_1->getLat();
      $lon1 = $location_1->getLon();
      $lat2 = $location_2->getLat();
      $lon2 = $location_2->getLon();
      $latd = deg2rad($lat2 - $lat1);
      $lond = deg2rad($lon2 - $lon1);
      $a = sin($latd / 2) * sin($latd / 2) +
           cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
           sin($lond / 2) * sin($lond / 2);
      $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
      return 6371.0 * $c;
    }
    
}

/*
$coord_1 = new Google_Maps_Coordinate('58.378700', '26.731110');
$coord_2 = new Google_Maps_Coordinate('58.379646', '26.764090');

print Google_Maps_Math::GreatCirleDistance($coord_1, $coord_2);
print "\n";
print Google_Maps_Math::HaversineDistance($coord_1, $coord_2);
print "\n";
print Google_Maps_Math::distance($coord_2, $coord_1);
print "\n";
*/
