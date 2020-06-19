<?php
require '../database.php';


$personaltutortable = new databasetable($pdo,'personaltutor','id');

if(isset($_GET['submit']))
{

    $stmt = $personaltutortable->find('staffid',$_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => 'index.php?page=amendpersonaltutor'
    ];
}
else{

$stmt = $personaltutortable->findAll();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Select',
    'location' => 'index.php?page=amendpersonaltutor'
];
}
$content = loadtemplate('../templates/amendpersonaltutorlist.html.php',$templatevars);
$header = 'Personal Tutor List';
$title = 'Amend Personal Tutor';
?>