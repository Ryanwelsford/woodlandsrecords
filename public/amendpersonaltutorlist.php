<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_GET['submit']))
{
    $search = $pdo->prepare('SELECT * FROM personaltutor WHERE staffid = :staffid');

    $values = [
        'staffid' => $_GET['search']
    ];
    $search->execute($values);
    $stmt = $search->fetchAll();

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => '#'
    ];
}
else{
$stmt = $pdo->prepare('SELECT * FROM personaltutor');
$stmt->execute();
$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Select',
    'location' => '#'
];
}
$content = loadtemplate('../templates/amendpersonaltutorlist.html.php',$templatevars);
$header = 'Personal Tutor List';
$title = 'Amend Personal Tutor';
require '../templates/layout.html.php';
?>