<?php
require '../database.php';

$unassignedstafftable = new databasetable($pdo,'unassignedstaff','id');
$personaltutortable = new databasetable($pdo,'personaltutor','id');

if(isset($_POST['submit']))
{
 

    $values = [
        'firstname' => $_POST['firstname'],
        'surname' => $_POST['surname'],
        'staffid' => $_POST['staffid'],
        'courseteaching' => $_POST['course']
    ];

    $personaltutortable->save($values);

    $unassignedstafftable->delete('id',$_POST['id']);


    header('location: /personaltutorlist');
    
}

$staff = $unassignedstafftable->find('id',$_POST['id'])[0];
$templatevars = [
    'staff' => $staff
];
$content = loadtemplate('../templates/personaltutor.html.php',$templatevars);
$header = 'Personal Tutor';
$title = 'Personal Tutor';
?>