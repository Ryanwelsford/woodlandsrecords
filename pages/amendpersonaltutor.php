<?php
require '../database.php';

$personaltutortable = new databasetable($pdo,'personaltutor','id');

if(isset($_POST['submit']))
{
    $update = $pdo->prepare('UPDATE personaltutor SET courseteaching = :courseteaching WHERE staffid = :staffid');

    $record = [
        'courseteaching' => $_POST['course'],
        'staffid' => $_POST['staffid']
    ];
    $update->execute($record);
    header('location: index.php?page=amendpersonaltutorlist');
}
else{


$staff = $personaltutortable->find('id',$_POST['id'])[0];
$templatevars = [
    'staff' => $staff
];
}
$content = loadtemplate('../templates/amendpersonaltutor.html.php',$templatevars);
$header = 'Amend Personal Tutor';
$title = 'Amend Personal Tutor';
?>