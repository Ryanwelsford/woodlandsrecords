<?php
require '../database.php';

$tuteestable = new databasetable($pdo,'tutees','id');

$header = 'Personal Tutor';
$title = 'Personal Tutor';

// $student = find($pdo,'tutees','id',$_POST['id'])[0];
$student = $tuteestable->find('id',$_POST['id'])[0];
$templatevars = [
    'student' => $student
];
$content = loadtemplate('../templates/personaltutordisplay.html.php',$templatevars);

?>