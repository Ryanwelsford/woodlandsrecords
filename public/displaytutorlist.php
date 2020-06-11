<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_GET['submit']))
{
    $stmt = $pdo->prepare('SELECT * FROM tutees WHERE tuteeid= :tuteeid');

    $values=[
        'tuteeid' => $_GET['search']
    ];

    $stmt->execute($values);
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'display',
        'location' => 'displaypersonaltutor.php'
    ];
}
else{
$stmt = $pdo->prepare('SELECT * FROM tutees');
$stmt->execute();
$templatevars = [
    'stmt' => $stmt,
    'buttonName'=> 'display',
    'location'=> 'displaypersonaltutor.php'
];
}
$content = loadtemplate('../templates/displaypersonaltutor.html.php',$templatevars);
$header = 'Personal Tutor List';
$title = 'Display Personal Tutor';
require '../templates/layout.html.php';
?>