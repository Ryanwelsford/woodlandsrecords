<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
$header = 'Student List';
$title = 'Assign Personal Tutor';

if(isset($_GET['submit']))
{
    $stmt = $pdo->prepare('SELECT * FROM students WHERE studentid= :studentid');
    $values = [
        'studentid' => $_GET['search']
    ];

    $stmt->execute($values);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Assign',
        'location' => 'assignpersonaltutor.php'
    ];
}
else{

$stmt = findAll($pdo,'students');
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Assign',
    'location' => 'assignpersonaltutor.php'
];
}
$content = loadtemplate('../templates/amendstudentlist.html.php',$templatevars);
require '../templates/layout.html.php';
?>