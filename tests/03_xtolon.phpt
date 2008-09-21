--TEST--
Google_Maps_Mercator::LonToX()
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
require_once 'Google/Maps/Mercator.php';

print $x = Google_Maps_Mercator::XToLon(355500011) . "\n";
print $x = Google_Maps_Mercator::XToLon(268435456) . "\n";
print $x = Google_Maps_Mercator::XToLon(0) . "\n";
print $x = Google_Maps_Mercator::XToLon(536870912) . "\n";

?>
--GET--
--POST--
--EXPECT--
58.3813335747
0
-180
180