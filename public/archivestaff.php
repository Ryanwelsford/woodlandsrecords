<?php
require '../database.php';
require '../loadtemplate.php';
if(isset($_GET['submit']))
{
    $search = $pdo->prepare('SELECT * FROM staff WHERE staffid = :staffid');

    $values = [
        'staffid' => $_GET['search']
    ];
    $search->execute($values);
    $stmt = $search->fetchAll();

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Archive',
        'location' => 'amendstaff.php'
    ];
}
else{
$stmt = $pdo->prepare('SELECT * FROM staff');
$stmt->execute();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Archive',
    'location' => '#'
];
}
$content = loadtemplate('../templates/liststaff.html.php', $templatevars);
$header = 'Archive Staff Record';
$title = 'Archive Staff Record';
require '../templates/layout.html.php';

?>