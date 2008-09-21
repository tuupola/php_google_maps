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
if (@include(dirname(__FILE__)."/../Google/Maps/Mercator.php")) {
    $status = ''; 
} else if (@include('Google/Maps/Mercator.php')) {
    $status = ''; 
} else {
    $status = 'skip';
}
print $status;

/* first one for svn */
if (@include(dirname(__FILE__)."/../Google/Maps/Bounds.php")) {
    $status = ''; 
} else if (@include('Google/Maps/Bounds.php')) {
    $status = ''; 
} else {
    $status = 'skip';
}
print $status;

/* first one for svn */
if (@include(dirname(__FILE__)."/../Google/Maps/Point.php")) {
    $status = ''; 
} else if (@include('Google/Maps/Point.php')) {
    $status = ''; 
} else {
    $status = 'skip';
}
print $status;

/* first one for svn */
if (@include(dirname(__FILE__)."/../Google/Maps/Static.php")) {
    $status = ''; 
} else if (@include('Google/Maps/Static.php')) {
    $status = ''; 
} else {
    $status = 'skip';
}
print $status;