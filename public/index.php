<?php
require '../Classes/databasetable.php';
require '../loadtemplate.php';
require '../autoloader/autoloader.php';

$routes = new \Diary\routes();
$entrypoint = new \RWCSY2028\EntryPoint($routes);
$entrypoint->run();
?>