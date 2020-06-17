<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
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

$staff = find($pdo,'personaltutor','id',$_POST['id'])[0];
$templatevars = [
    'staff' => $staff
];
}
$content = loadtemplate('../templates/amendpersonaltutor.html.php',$templatevars);
$header = 'Amend Personal Tutor';
$title = 'Amend Personal Tutor';
require '../templates/layout.html.php';
?>