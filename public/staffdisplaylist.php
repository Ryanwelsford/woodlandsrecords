<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
require '../databasetable.php';

$stafftable = new databasetable($pdo,'staff','id');

if(isset($_GET['submit']))
{

    $stmt = $stafftable->find('staffid',$_GET['search']);
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Display',
        'location' => 'displaystaff.php'
    ];
}
else{

$stmt = $stafftable->findAll();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Display',
    'location' => 'displaystaff.php'
];
}

$content = loadtemplate('../templates/liststaff.html.php',$templatevars);
$header = 'Staff List';
$title = 'Staff List';
require '../templates/layout.html.php';
?>