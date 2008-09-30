--TEST--
Google_Maps_Mercator::LonToX()
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
require_once 'Google/Maps/Mercator.php';

print $x = Google_Maps_Mercator::LatToY(24.5165921956) . "\n";
print $x = Google_Maps_Mercator::LatToY(85.0511287798) . "\n";
print $x = Google_Maps_Mercator::LatToY(0) . "\n";
print $x = Google_Maps_Mercator::LatToY(-85.0511287798) . "\n";

?>
--GET--
--POST--
--EXPECT--
230704001
0
268435456
536870912
