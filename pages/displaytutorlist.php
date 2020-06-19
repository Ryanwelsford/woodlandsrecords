<?php
require '../database.php';

$tuteestable = new databasetable($pdo,'tutees','id');

if(isset($_GET['submit']))
{
   
    // $stmt = find($pdo,'tutees','tuteeid',$_GET['search']);
    $stmt = $tuteestable->find('tuteeid',$_GET['search']);
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'display',
        'location' => 'index.php?page=displaypersonaltutor'
    ];
}
else{

// $stmt = findAll($pdo,'tutees');
$stmt = $tuteestable->findAll();
$templatevars = [
    'stmt' => $stmt,
    'buttonName'=> 'display',
    'location'=> 'index.php?page=displaypersonaltutor'
];
}
$content = loadtemplate('../templates/displaypersonaltutor.html.php',$templatevars);
$header = 'Personal Tutor List';
$title = 'Display Personal Tutor';
?>