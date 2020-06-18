<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
require '../databasetable.php';

$studenttable = new databasetable($pdo,'students','id');
$header = 'Student List';
$title = 'Assign Personal Tutor';

if(isset($_GET['submit']))
{

    $stmt = $studenttable->find('studentid',$_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Assign',
        'location' => 'assignpersonaltutor.php'
    ];
}
else{

$stmt = $studenttable->findAll();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Assign',
    'location' => 'assignpersonaltutor.php'
];
}
$content = loadtemplate('../templates/amendstudentlist.html.php',$templatevars);
require '../templates/layout.html.php';
?>