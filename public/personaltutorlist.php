<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
if(isset($_GET['submit']))
{

    $stmt = find($pdo,'unassignedstaff','staffid',$_GET['search']);
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => 'personaltutor.php'
    ];
}
else{

$stmt = findAll($pdo,'unassignedstaff');
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