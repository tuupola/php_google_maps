--TEST--
Google_Maps_Mercator::LonToX()
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
require_once 'Google/Maps/Mercator.php';

print $x = Google_Maps_Mercator::LontoX(58.3813335747) . "\n";
print $x = Google_Maps_Mercator::LontoX(0) . "\n";
print $x = Google_Maps_Mercator::LontoX(-180) . "\n";
print $x = Google_Maps_Mercator::LontoX(180) . "\n";

?>
--GET--
--POST--
--EXPECT--
355500011
268435456
0
536870912

