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
print_r($map);

?>
--GET--
--POST--
--EXPECT--
Google_Maps_Static Object
(
    [zoom:protected] => 13
    [type:protected] => hybrid
    [center:protected] => Google_Maps_Coordinate Object
        (
            [lat:protected] => 24.5165921956
            [lon:protected] => 58.3813335747
        )

    [markers:protected] => TODO
)