<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
if(isset($_POST['submit']))
{
 

    $values = [
        'firstname' => $_POST['firstname'],
        'surname' => $_POST['surname'],
        'staffid' => $_POST['staffid'],
        'courseteaching' => $_POST['course']
    ];

    save($pdo,'personaltutor',$values,'id');

    delete($pdo,'unassignedstaff','id',$_POST['id']);


    header('location: personaltutorlist.php');
    
}

$staff = find($pdo,'unassignedstaff','id',$_POST['id'])[0];
$templatevars = [
    'staff' => $staff
];
$content = loadtemplate('../templates/personaltutor.html.php',$templatevars);
$header = 'Personal Tutor';
$title = 'Personal Tutor';
require '../templates/layout.html.php';
?>