--TEST--
Google_Maps_Bounds::create()
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
require_once 'Google/Maps/Bounds.php';

$point_1 = new Google_Maps_Point(0, 0);
$point_2 = new Google_Maps_Point(536870912, 536870912);
$point_3 = new Google_Maps_Point(355500011, 230704001);

$bounds_1 = new Google_Maps_Bounds(array($point_1, $point_2, $point_3));

print_r($bounds_1->getNorthWest());
print_r($bounds_1->getSouthEast('point'));

$coord_1 = new Google_Maps_Coordinate(-85.0511287798, 180);
$coord_2 = new Google_Maps_Coordinate(85.0511287798, -180);
$coord_3 = new Google_Maps_Coordinate(24.5165921956, 58.3813335747);

$bounds_2 = new Google_Maps_Bounds(array($coord_1, $coord_2, $coord_3));

print_r($bounds_2->getNorthWest());
print_r($bounds_2->getSouthEast('point'));


?>
--GET--
--POST--
--EXPECT--
Google_Maps_Coordinate Object
(
    [lat:protected] => 85.0511287798
    [lon:protected] => -180
)
Google_Maps_Point Object
(
    [x:protected] => 536870912
    [y:protected] => 536870912
)
Google_Maps_Coordinate Object
(
    [lat:protected] => 85.0511287798
    [lon:protected] => -180
)
Google_Maps_Point Object
(
    [x:protected] => 536870912
    [y:protected] => 536870912
)