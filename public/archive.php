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

    $archive = $pdo->prepare('INSERT INTO archivedstudents (studentid,firstname,middlename,surname,studentstatus,dormancyreason,termaddress,nonaddress,phonenum,email,coursecode,entryqual)
                                VALUES(:studentid, :firstname, :middlename, :surname, :studentstatus, :dormancyreason, :termaddress, :nonaddress, :phonenum, :email, :coursecode, :entryqual)');

    $values = [
        'studentid' => $check['studentid'],
        'firstname' => $check['firstname'],
        'middlename' => $check['middlename'],
        'surname' => $check['surname'],
        'studentstatus' => 'Dormant',
        'dormancyreason' => $check['dormancyreason'],
        'termaddress' => $check['termaddress'],
        'nonaddress' => $check['nonaddress'],
        'phonenum' => $check['phonenum'],
        'email' => $check['email'],
        'coursecode' => $check['coursecode'],
        'entryqual' => $check['entryqual']
    ];

    $archive->execute($values);

    $delete = $pdo->prepare('DELETE FROM students WHERE studentid = :studentid');

    $val =[
        'studentid' => $_POST['id']
    ];

    $delete->execute($val);

    // if($check['studentstatus'] == 'Live')
    // {
    //     echo '<script type="text/JavaScript">alert("The status of this student is Live")</script>';
    // }

    // if($check['studentstatus'] == 'Provisional')
    // {
    //     echo '<script type="text/JavaScript">alert("The status of this student is Provisional")</script>';
    // }
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