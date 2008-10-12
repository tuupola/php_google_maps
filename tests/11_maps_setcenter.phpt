--TEST--
Google_Maps::create()
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
include 'skipif.php';

$point = new Google_Maps_Point(355500011, 230704001);
$coord = new Google_Maps_Coordinate(24.5165921956, 58.3813335747);


$map_1 = Google_Maps::create('static');
$map_2 = Google_Maps::create('static');
$map_3 = Google_Maps::create('static');

$map_1->setCenter($coord);
$map_2->setCenter($point);
$map_3->setCenter("24.5165921956, 58.3813335747");

print_r($map_1->getCenter());
print_r($map_2->getCenter());
print_r($map_3->getCenter());

?>
--GET--
--POST--
--EXPECT--
Google_Maps_Coordinate Object
(
    [lat:protected] => 24.5165921956
    [lon:protected] => 58.3813335747
)
Google_Maps_Coordinate Object
(
    [lat:protected] => 24.5165921956
    [lon:protected] => 58.3813335747
)
Google_Maps_Coordinate Object
(
    [lat:protected] => 24.5165921956
    [lon:protected] => 58.3813335747
)