<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_POST['archive']))
{
    $checkstatus = $pdo->prepare('SELECT * FROM students WHERE studentid = :studentid');
    $values = [
        'studentid' => $_POST['id']
    ];
    $checkstatus->execute($values);
    $check = $checkstatus->fetch();

    if($check['studentstatus'] == 'Live')
    {
        echo '<script type="text/JavaScript">alert("The status of this student is Live")</script>';
    }

    if($check['studentstatus'] == 'Provisional')
    {
        echo '<script type="text/JavaScript">alert("The status of this student is Provisional")</script>';
    }
}

if(isset($_GET['submit']))
{
    $search = $pdo->prepare('SELECT * FROM students WHERE studentid= :studentid');

    $values = [
        'studentid' => $_GET['search']
    ];

    $search->execute($values);
    $stmt = $search->fetchAll();

    $templatevars = [
        'stmt' => $stmt
    ];


}
else{
$stmt = $pdo->prepare('SELECT * FROM students');
$stmt->execute();

$templatevars = [
    'stmt' => $stmt
];
}
$content = loadtemplate('../templates/archive.html.php', $templatevars);
$title = 'Archive Student';
$header = 'Archive Student Record';
require '../templates/layout.html.php';
?>