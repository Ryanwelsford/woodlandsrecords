<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
require '../databasetable.php';

$unassignedstafftable = new databasetable($pdo,'unassignedstaff','id');
if(isset($_GET['submit']))
{

    $stmt = $unassignedstafftable->find('staffid',$_GET['search']);
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => 'personaltutor.php'
    ];
}
else{

$stmt = $unassignedstafftable->findAll();
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