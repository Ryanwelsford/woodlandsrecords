<?php
require '../Classes/databasetable.php';
require '../loadtemplate.php';
require '../autoloader/autoloader.php';

//test test test

$routes = new \Diary\routes();
$entrypoint = new \RWCSY2028\EntryPoint($routes);
$entrypoint->run();
?>