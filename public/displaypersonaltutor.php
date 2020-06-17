<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';

$header = 'Personal Tutor';
$title = 'Personal Tutor';

// $stmt = $pdo->prepare('SELECT * FROM tutees WHERE id=:id');
// $values = [
//     'id' => $_POST['id']
// ];
// $stmt->execute($values);
// $student = $stmt->fetch();
$student = find($pdo,'tutees','id',$_POST['id'])[0];
$templatevars = [
    'student' => $student
];
$content = loadtemplate('../templates/personaltutordisplay.html.php',$templatevars);
require '../templates/layout.html.php';
?>