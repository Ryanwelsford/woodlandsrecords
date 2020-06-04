<?php
require '../database.php';
require '../loadtemplate.php';
$stmt = $pdo->prepare('SELECT * FROM staff WHERE id=:id');
$values = [
    'id' => $_POST['id']
];
$stmt->execute($values);
$staff = $stmt->fetch();
$templatevars = [
    'staff' => $staff
];
$content = loadtemplate('../templates/displaystaff.html.php', $templatevars);
$header = 'Staff Record';
$title = 'Staff Record';
require '../templates/layout.html.php';
?>