<?php
require '../database.php';
require '../databasetable.php';
require '../loadtemplate.php';
require '../functions.php';
require '../Controllers/studentController.php';
require '../Controllers/staffController.php';

$studenttable = new databasetable($pdo,'students','id');
$archivestudenttable = new databasetable($pdo,'archivedstudents','id');
$stafftable = new databasetable($pdo,'staff','id');
$unassignedstafftable = new databasetable($pdo,'unassignedstaff','id');

$studentcontroller = new studentController($studenttable,$archivestudenttable);
$staffcontroller = new staffController($stafftable,$unassignedstafftable);
$route = ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');

if($route == '')
{
    $page = $studentcontroller->home();
}
if($route == 'amendstudentlist')
{
    $page = $studentcontroller->amendstudentlist();
}
if($route == 'amendstudent')
{
    $page = $studentcontroller->amendstudent();
}
if($route == 'archive')
{
    $page = $studentcontroller->archive();
}
if($route == 'displaystudentlist')
{
    $page = $studentcontroller->displaystudentlist();
}
if($route == 'displaystudent')
{
    $page = $studentcontroller->displaystudent();
}
if($route == 'createstaff')
{
    $page = $staffcontroller->createstaff();
}
if($route == 'liststaff')
{
    $page = $staffcontroller->liststaff();
}
if($route == 'amendstaff')
{
    $page = $staffcontroller->amendstaff();
}

// if($_SERVER['REQUEST_URI'] !== '/')
// {
//     $functionname = ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/');
//     $page = $studentcontroller->$functionname();
// }
// else
// { 
//     $page = $studentcontroller->home();  
// }
$content = loadtemplate('../templates/' . $page['template'], $page['variables']);
$title = $page['title'];
$header = $page['header'];
require '../templates/layout.html.php';
?>