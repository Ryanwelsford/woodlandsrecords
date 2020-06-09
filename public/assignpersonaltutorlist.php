<?php
require '../database.php';
require '../loadtemplate.php';
$header = 'Personal Tutor List';
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
$stmt = $pdo->prepare('SELECT * FROM students');
$stmt->execute();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Assign',
    'location' => 'assignpersonaltutor.php'
];
}
$content = loadtemplate('../templates/amendpersonaltutorlist.html.php',$templatevars);
require '../templates/layout.html.php';
?>