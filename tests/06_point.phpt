--TEST--
Google_Maps_Point 
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
include 'skipif.php';

$point_1 = new Google_Maps_Point(0, 0);
$point_2 = new Google_Maps_Point(536870912, 536870912);
$point_3 = new Google_Maps_Point(355500011, 230704001);

print_r($point_1->toCoordinate());
print_r($point_2->toCoordinate());
print_r($point_3->toCoordinate());

?>
--GET--
--POST--
--EXPECT--
Google_Maps_Coordinate Object
(
    [lat:protected] => 85.0511287798
    [lon:protected] => -180
)
Google_Maps_Coordinate Object
(
    [lat:protected] => -85.0511287798
    [lon:protected] => 180
)
Google_Maps_Coordinate Object
(
    [lat:protected] => 24.5165921956
    [lon:protected] => 58.3813335747
)
