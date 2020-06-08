<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_POST['submit']))
{
    $stmt = $pdo->prepare('INSERT INTO personaltutor (firstname, surname, staffid, courseteaching)
                            VALUES(:firstname, :surname, :staffid, :courseteaching)');

    $values = [
        'firstname' => $_POST['firstname'],
        'surname' => $_POST['surname'],
        'staffid' => $_POST['staffid'],
        'courseteaching' => $_POST['course']
    ];

    $stmt->execute($values);
}

$stmt = $pdo->prepare('SELECT * FROM staff WHERE id = :id');
$value = [
    'id' => $_POST['id']
];
$stmt->execute($value);
$staff = $stmt->fetch();
$templatevars = [
    'staff' => $staff
];
$content = loadtemplate('../templates/personaltutor.html.php',$templatevars);
$header = 'Personal Tutor';
$title = 'Personal Tutor';
require '../templates/layout.html.php';
?>