<?php
require '../loadtemplate.php';
require '../database.php';
require '../functions.php';
require '../databasetable.php';

$studenttable = new databasetable($pdo,'students','id');
//get all students and display them in the table

$stmt = $studenttable->findAll();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Display',
    'location' => 'displaystudent.php'
];

$content = loadtemplate('../templates/amendstudentlist.html.php',$templatevars);
$header = 'Student List';
$title = 'Student List';
require '../templates/layout.html.php';
?>