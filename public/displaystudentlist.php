<?php
require '../loadtemplate.php';
require '../database.php';
$stmt = $pdo->prepare('SELECT * FROM students');
$stmt->execute();
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