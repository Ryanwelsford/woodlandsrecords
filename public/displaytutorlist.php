<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';

if(isset($_GET['submit']))
{
   
    $stmt = find($pdo,'tutees','tuteeid',$_GET['search']);
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'display',
        'location' => 'displaypersonaltutor.php'
    ];
}
else{

$stmt = findAll($pdo,'tutees');
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