<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
require '../databasetable.php';

$stafftable = new databasetable($pdo,'staff','id');
$unassignedstafftable = new databasetable($pdo,'unassignedstaff','id');
if(isset($_POST['submit']))
{
//when submit button pressed insert info in the 2 tables
    
    $stafftable->save($_POST['staff']);
    
    $unassignedstafftable->save($_POST['staff']);

}
$content = loadtemplate('../templates/createstaff.html.php',[]);
$header = 'Create Staff Record';
$title = 'Create Staff Record';
require '../templates/layout.html.php';
?>