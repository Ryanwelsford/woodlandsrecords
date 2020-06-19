<?php
require '../database.php';


$unassignedstafftable = new databasetable($pdo,'unassignedstaff','id');
if(isset($_GET['submit']))
{

    $stmt = $unassignedstafftable->find('staffid',$_GET['search']);
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => 'index.php?page=personaltutor'
    ];
}
else{

$stmt = $unassignedstafftable->findAll();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Select',
    'location' => 'index.php?page=personaltutor'
];
}
$content = loadtemplate('../templates/liststaff.html.php',$templatevars);
$header = 'Staff List';
$title = 'Personal Tutor';
?>