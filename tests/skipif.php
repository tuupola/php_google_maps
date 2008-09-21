<?php

/* first one for svn */
if (@include(dirname(__FILE__)."/../Google/Maps.php")) {
    $status = ''; 
} else if (@include('Google/Maps.php')) {
    $status = ''; 
} else {
    $status = 'skip';
}
print $status;

/* first one for svn */
/*
if (@include(dirname(__FILE__)."/../Google/Maps/Mercator.php")) {
    $status = ''; 
} else if (@include('Google/Maps/Mercator.php')) {
    $status = ''; 
} else {
    $status = 'skip';
}
print $status;
*/