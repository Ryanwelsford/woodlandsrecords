<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
if(isset($_POST['submit']))
{
//when submit button pressed insert info in the 2 tables
    save($pdo,'staff',$_POST['staff'],'id');
    save($pdo,'unassignedstaff', $_POST['staff'],'id');

}
$content = loadtemplate('../templates/createstaff.html.php',[]);
$header = 'Create Staff Record';
$title = 'Create Staff Record';
require '../templates/layout.html.php';
?>