<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_GET['submit']))
{
    $search = $pdo->prepare('SELECT * FROM unassignedstaff WHERE staffid = :staffid');

    $values = [
        'staffid' => $_GET['search']
    ];
    $search->execute($values);
    $stmt = $search->fetchAll();
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => 'personaltutor.php'
    ];
}
else{
$stmt = $pdo->prepare('SELECT * FROM unassignedstaff');
$stmt->execute();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Select',
    'location' => 'personaltutor.php'
];
}
$content = loadtemplate('../templates/liststaff.html.php',$templatevars);
$header = 'Staff List';
$title = 'Personal Tutor';
require '../templates/layout.html.php';
?>