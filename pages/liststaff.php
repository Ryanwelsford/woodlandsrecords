<?php
require '../database.php';



$stafftable = new databasetable($pdo,'staff','id');

if(isset($_GET['submit']))
{

    $stmt = $stafftable->find('staffid',$_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Amend',
        'location' => 'index.php?page=amendstaff'
    ];
}
else{

$stmt = $stafftable->findAll();

$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Amend',
    'location' => 'index.php?page=amendstaff'
];
}
$content = loadtemplate('../templates/liststaff.html.php',$templatevars);
$header = 'Staff List';
$title = 'Staff List';
?>