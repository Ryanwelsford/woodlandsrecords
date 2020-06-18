<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
require '../databasetable.php';

$studenttable = new databasetable($pdo,'students','id');
$archivedstudenttable = new databasetable($pdo,'archivedstudents','id');

if(isset($_POST['archive']))
{
    $checkstatus = $pdo->prepare('SELECT * FROM students WHERE studentid = :studentid');
    $values = [
        'studentid' => $_POST['id']
    ];
    $checkstatus->execute($values);
    $check = $checkstatus->fetch();


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

   

    //insert into the archived student table
    $archivedstudenttable->insert($values);
    // then delete it from the student table
    $studenttable->delete('studentid',$_POST['id']);

}

if(isset($_GET['submit']))
{
//find the student with the student id entered
    // $stmt = find($pdo,'students','studentid',$_GET['search']);
    $stmt = $studenttable->find('studentid',$_GET['search']);
    $templatevars = [
        'stmt' => $stmt
    ];

}
else{
//get all students in the students table
$stmt = $studenttable->findAll();
$templatevars = [
    'stmt' => $stmt
];
}
$content = loadtemplate('../templates/archive.html.php', $templatevars);
$title = 'Archive Student';
$header = 'Archive Student Record';
require '../templates/layout.html.php';
?>