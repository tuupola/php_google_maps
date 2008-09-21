--TEST--
Google_Maps_Bounds::create()
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

$bounds_1 = Google_Maps_Bounds::create(array($point_1, $point_2));
$bounds_2 = Google_Maps_Bounds::create(array($point_3, $point_1));

$coord_1 = new Google_Maps_Coordinate(-85.0511287798, 180);
$coord_2 = new Google_Maps_Coordinate(85.0511287798, -180);
$coord_3 = new Google_Maps_Coordinate(24.5165921956, 58.3813335747);

$bounds_3 = Google_Maps_Bounds::create(array($coord_1, $coord_2));
$bounds_4 = Google_Maps_Bounds::create(array($coord_3, $coord_1));



print "1 (true) - ";
print_r($bounds_1->contains($point_3));
print "\n2 (true) - ";
print_r($bounds_1->contains($coord_3));

print "\n3 (false)- ";
print_r($bounds_2->contains($point_3));
print "\n4 (false) - ";
print_r($bounds_2->contains($coord_3));

print "\n5 (true) - ";
print_r($bounds_3->contains($point_3));
print "\n6 (true) - ";
print_r($bounds_3->contains($coord_3));

print "\n7 (false) - ";
print_r($bounds_4->contains($point_3));
print "\n8 (false) - ";
print_r($bounds_4->contains($coord_3));


?>
--GET--
--POST--
--EXPECT--
1 (true) - 1
2 (true) - 1
3 (false)- 
4 (false) - 
5 (true) - 1
6 (true) - 1
7 (false) - 
8 (false) -
