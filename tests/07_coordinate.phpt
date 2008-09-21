--TEST--
Google_Maps_Coordinate
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
include 'skipif.php';

$coord_1 = new Google_Maps_Coordinate(-85.0511287798, 180);
$coord_2 = new Google_Maps_Coordinate(85.0511287798, -180);
$coord_3 = new Google_Maps_Coordinate(24.5165921956, 58.3813335747);

print_r($coord_1->toPoint());
print_r($coord_2->toPoint());
print_r($coord_3->toPoint());

?>
--GET--
--POST--
--EXPECT--
Google_Maps_Point Object
(
    [x:protected] => 536870912
    [y:protected] => 536870912
)
Google_Maps_Point Object
(
    [x:protected] => 0
    [y:protected] => 0
)
Google_Maps_Point Object
(
    [x:protected] => 355500011
    [y:protected] => 230704001
)
