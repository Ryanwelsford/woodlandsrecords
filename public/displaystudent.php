<?php
require '../database.php';
require '../loadtemplate.php';
$stmt = $pdo->prepare('SELECT * FROM students WHERE studentid = :studentid');
$values = [
    'studentid' => $_POST['id']
];
$stmt->execute($values);
$student = $stmt->fetch();
$templatevars = [
    'student' => $student
];
$content = loadtemplate('../templates/displaystudent.html.php',$templatevars);
$title = 'Student Information';
$header = 'Student Information';
require '../templates/layout.html.php';
?>