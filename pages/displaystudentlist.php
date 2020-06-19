<?php
require '../database.php';

$studenttable = new databasetable($pdo,'students','id');
//get all students and display them in the table

$stmt = $studenttable->findAll();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Display',
    'location' => 'index.php?page=displaystudent'
];

$content = loadtemplate('../templates/amendstudentlist.html.php',$templatevars);
$header = 'Student List';
$title = 'Student List';
?>