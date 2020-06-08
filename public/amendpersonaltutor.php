<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_POST['submit']))
{
    $update = $pdo->prepare('UPDATE personaltutor SET courseteaching = :courseteaching WHERE staffid = :staffid');

    $record = [
        'courseteaching' => $_POST['course'],
        'staffid' => $_POST['staffid']
    ];
    $update->execute($record);
    header('location: amendpersonaltutorlist.php');
}
else{
$stmt = $pdo->prepare('SELECT * FROM personaltutor WHERE id=:id');
$values = [
    'id' => $_POST['id']
];
$stmt->execute($values);
$staff = $stmt->fetch();
$templatevars = [
    'staff' => $staff
];
}
$content = loadtemplate('../templates/amendpersonaltutor.html.php',$templatevars);
$header = 'Amend Personal Tutor';
$title = 'Amend Personal Tutor';
require '../templates/layout.html.php';
?>