<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';


if(isset($_GET['submit']))
{

    $stmt = find($pdo,'staff','staffid',$_GET['search']);
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Display',
        'location' => 'displaystaff.php'
    ];
}
else{

$stmt = findAll($pdo,'staff');
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