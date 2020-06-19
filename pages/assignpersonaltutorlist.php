<?php
require '../database.php';

$studenttable = new databasetable($pdo,'students','id');
$header = 'Student List';
$title = 'Assign Personal Tutor';

if(isset($_GET['submit']))
{

    $stmt = $studenttable->find('studentid',$_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Assign',
        'location' => '/assignpersonaltutor'
    ];
}
else{

$stmt = $studenttable->findAll();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Assign',
    'location' => '/assignpersonaltutor'
];
}
$content = loadtemplate('../templates/amendstudentlist.html.php',$templatevars);
?>