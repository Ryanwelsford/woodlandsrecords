<?php
require '../database.php';
require '../loadtemplate.php';
$stmt = $pdo->prepare('SELECT * FROM tutees');
$stmt->execute();
$templatevars = [
    'stmt' => $stmt,
    'buttonName'=> 'display',
    'location'=> '#'
];
$content = loadtemplate('../templates/displaypersonaltutor.html.php',$templatevars);
$header = 'Personal Tutor List';
$title = 'Display Personal Tutor';
require '../templates/layout.html.php';
?>