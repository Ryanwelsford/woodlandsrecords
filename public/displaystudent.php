<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
$student = find($pdo,'students','id',$_POST['id'])[0];

$templatevars = [
    'student' => $student
];
$content = loadtemplate('../templates/displaystudent.html.php',$templatevars);
$title = 'Student Information';
$header = 'Student Information';
require '../templates/layout.html.php';
?>