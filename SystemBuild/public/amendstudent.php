<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_POST['submit']))
{
    $update = $pdo->prepare('UPDATE students SET studentid= :studentid, firstname= :firstname, middlename= :middlename, surname = :surname, studentstatus= :studentstatus, dormancyreason = :dormancyreason, termaddress = :termaddress, nonaddress = :nonaddress, phonenum = :phonenum, email = :email, coursecode = :coursecode, entryqual = :entryqual WHERE studentid = :studentid');
    $record = [
        'studentid' => $_POST['studentid'],
        'firstname' => $_POST['firstname'],
        'middlename' => $_POST['middlename'],
        'surname' => $_POST['surname'],
        'studentstatus' => $_POST['studentstatus'],
        'dormancyreason' => $_POST['dormancy'],
        'termaddress' => $_POST['termaddress'],
        'nonaddress' => $_POST['nontermaddress'],
        'phonenum' => $_POST['number'],
        'email' => $_POST['email'],
        'coursecode' => $_POST['coursecode'],
        'entryqual' => $_POST['entryqual']
    ];
    $update->execute($record);

}

$stmt = $pdo->prepare('SELECT * FROM students WHERE studentid= :studentid');
$values = [
    'studentid' => $_POST['id']
];
$stmt->execute($values);
$student = $stmt->fetch();

$templatevars = [
    'student' => $student
];

$content = loadtemplate('../templates/amendstudent.html.php',$templatevars);
$header = 'Amend Student Record';
$title = "Amend Student Record";
require '../templates/layout.html.php';
?>