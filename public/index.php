<?php
require '../database.php';
require '../databasetable.php';
require '../loadtemplate.php';
require '../functions.php';
require '../Controllers/studentController.php';
require '../Controllers/staffController.php';
require '../Controllers/personaltutorController.php';

$studenttable = new databasetable($pdo,'students','id');
$archivestudenttable = new databasetable($pdo,'archivedstudents','id');
$stafftable = new databasetable($pdo,'staff','id');
$unassignedstafftable = new databasetable($pdo,'unassignedstaff','id');
$archivestafftable = new databasetable($pdo,'archivedstaff','id');
$unassignedstafftable = new databasetable($pdo,'unassignedstaff','id');
$personaltutortable = new databasetable($pdo,'personaltutor','id');
$tuteestable = new databasetable($pdo,'tutees','id');

$studentcontroller = new studentController($studenttable,$archivestudenttable);
$staffcontroller = new staffController($stafftable,$unassignedstafftable,$archivestafftable);
$personaltutorcontroller = new personaltutorController($unassignedstafftable,$personaltutortable,$studenttable,$tuteestable);

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
if($route == 'archivestaff')
{
    $page = $staffcontroller->archivestaff();
}
if($route == 'staffdisplaylist')
{
    $page = $staffcontroller->staffdisplaylist();
}
if($route == 'displaystaff')
{
    $page = $staffcontroller->displaystaff();
}
if($route == 'personaltutorlist')
{
    $page = $personaltutorcontroller->personaltutorlist();
}
if($route == 'personaltutor')
{
    $page = $personaltutorcontroller->personaltutor();
}
if($route == 'amendpersonaltutorlist')
{
    $page = $personaltutorcontroller->amendpersonaltutorlist();
}
if($route == 'amendpersonaltutor')
{
    $page = $personaltutorcontroller->amendpersonaltutor();
}
if($route == 'assignpersonaltutorlist')
{
    $page = $personaltutorcontroller->assignpersonaltutorlist();
}
if($route == 'assignpersonaltutor')
{
    $page = $personaltutorcontroller->assignpersonaltutor();
}
if($route == 'displaytutorlist')
{
    $page = $personaltutorcontroller->displaytutorlist();
}
if($route == 'displaypersonaltutor')
{
    $page = $personaltutorcontroller->displaypersonaltutor();
}
$content = loadtemplate('../templates/' . $page['template'], $page['variables']);
$title = $page['title'];
$header = $page['header'];
require '../templates/layout.html.php';
?>