<?php
require '../database.php';
$studenttable = new databasetable($pdo,'students','id');
//get the particular student and display in the input boxes
$student = $studenttable->find('id',$_POST['id'])[0];

$templatevars = [
    'student' => $student
];
$content = loadtemplate('../templates/displaystudent.html.php',$templatevars);
$title = 'Student Information';
$header = 'Student Information';
?>