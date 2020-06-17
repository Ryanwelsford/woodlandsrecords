<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
if(isset($_GET['submit']))
{

    $stmt = find($pdo,'personaltutor','staffid',$_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => 'amendpersonaltutor.php'
    ];
}
else{

$stmt = findAll($pdo,'personaltutor');
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