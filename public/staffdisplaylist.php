<?php
require '../database.php';
require '../loadtemplate.php';



if(isset($_GET['submit']))
{
    $stmt = $pdo->prepare('SELECT * FROM staff WHERE staffid = :staffid');

    $values = [
        'staffid' => $_GET['search']
    ];
    $stmt->execute($values);
    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Display',
        'location' => 'displaystaff.php'
    ];
}
else{
$stmt = $pdo->prepare('SELECT * FROM staff');
$stmt->execute();
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