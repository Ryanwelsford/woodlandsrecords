<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
require '../databasetable.php';

$tuteestable = new databasetable($pdo,'tutees','id');

$header = 'Personal Tutor';
$title = 'Personal Tutor';

// $student = find($pdo,'tutees','id',$_POST['id'])[0];
$student = $tuteestable->find('id',$_POST['id'])[0];
$templatevars = [
    'student' => $student
];
$content = loadtemplate('../templates/personaltutordisplay.html.php',$templatevars);
require '../templates/layout.html.php';
?>