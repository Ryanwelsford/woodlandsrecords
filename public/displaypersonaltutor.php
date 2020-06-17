<?php
require '../database.php';
require '../loadtemplate.php';
$header = 'Personal Tutor';
$title = 'Personal Tutor';
$stmt = $pdo->prepare('SELECT * FROM tutees WHERE id=:id');
$values = [
    'id' => $_POST['id']
];
$stmt->execute($values);
$student = $stmt->fetch();
$templatevars = [
    'student' => $student
];
$content = loadtemplate('../templates/personaltutordisplay.html.php',$templatevars);
require '../templates/layout.html.php';
?>