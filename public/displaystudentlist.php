<?php
require '../loadtemplate.php';
require '../database.php';
require '../functions.php';

$stmt = findall($pdo,'students');
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