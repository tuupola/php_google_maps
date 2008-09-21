--TEST--
Google_Maps_Mercator::LonToX()
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
include 'skipif.php';

print $x = Google_Maps_Mercator::YToLat(230704001) . "\n";
print $x = Google_Maps_Mercator::YToLat(0) . "\n";
print $x = Google_Maps_Mercator::YToLat(536870912) . "\n";

?>
--GET--
--POST--
--EXPECT--
24.5165921956
85.0511287798
-85.0511287798
