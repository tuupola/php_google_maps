--TEST--
Google_Maps::create()
--SKIPIF--
<?php 
include 'skipif.php';
?>
--FILE--
<?php 
include 'skipif.php';

unset($params);
$params['type']    = 'hybrid';
$params['zoom']    = 13;
$params['center']  = new Google_Maps_Coordinate(24.5165921956, 58.3813335747);
$params['markers'] = 'TODO';

$map = Google_Maps::create('static', $params);
print get_class($map) . "\n";

?>
--GET--
--POST--
--EXPECT--
Google_Maps_Static
