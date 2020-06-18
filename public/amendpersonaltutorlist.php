<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
require '../databasetable.php';

$personaltutortable = new databasetable($pdo,'personaltutor','id');

if(isset($_GET['submit']))
{

    $stmt = $personaltutortable->find('staffid',$_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => 'amendpersonaltutor.php'
    ];
}
else{

$stmt = $personaltutortable->findAll();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Select',
    'location' => 'amendpersonaltutor.php'
];
}
$content = loadtemplate('../templates/amendpersonaltutorlist.html.php',$templatevars);
$header = 'Personal Tutor List';
$title = 'Amend Personal Tutor';
require '../templates/layout.html.php';
?>