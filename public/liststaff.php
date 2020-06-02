<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_GET['submit']))
{
    $search = $pdo->prepare('SELECT * FROM staff WHERE staffid= :staffid');

    $values = [
        'staffid' => $_GET['search']
    ];

    $search->execute($values);
    $stmt = $search->fetchAll();

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Amend',
        'location' => '#'
    ];
}
else{
$stmt = $pdo->prepare('SELECT * FROM staff');
$stmt->execute();

$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Amend',
    'location' => '#'
];
}
$content = loadtemplate('../templates/liststaff.html.php',$templatevars);
$header = 'Staff List';
$title = 'Staff List';
require '../templates/layout.html.php';
?>