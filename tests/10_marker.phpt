--TEST--
Google_Maps_Marker
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
require_once 'Google/Maps/Marker.php';

$params['color'] = 'blue';

$coord  = new Google_Maps_Coordinate(24.5165921956, 58.3813335747);
$marker = new Google_Maps_Marker($coord, $params);

print_r($marker->getCoordinate());
print $marker->getLat();
print "\n";
print $marker->getLon();
print "\n";
print $marker->getColor();

?>
--GET--
--POST--
--EXPECT--
Google_Maps_Coordinate Object
(
    [lat:protected] => 24.5165921956
    [lon:protected] => 58.3813335747
)
24.5165921956
58.3813335747
blue

