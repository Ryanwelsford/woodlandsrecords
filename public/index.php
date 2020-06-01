<?php
require '../database.php';
require '../databasetable.php';

$studenttable = new databasetable($pdo,'students','studentid');

if(isset($_POST['submit']))
{
    
        $parts = explode('.', $_FILES['photo']['name']);
        $extention = end($parts);
        $filename = uniqid() . '.' . $extension;
        move_uploaded_file($_FILES['photo']['tmp_name'], 'studentprofiles/' . $filename);
    $stmt = $pdo->prepare('INSERT INTO students (studentid,firstname,middlename,surname,studentstatus,dormancyreason,termaddress,nonaddress,phonenum,email,coursecode,entryqual,photo)
                            VALUES (:studentid, :firstname, :middlename, :surname, :studentstatus, :dormancyreason, :termaddress, :nonaddress, :phonenum, :email, :coursecode, :entryqual, :photo)');
    $values = [
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
        'entryqual' => $_POST['entryqual'],
        'photo' => $filename
    ];
    $stmt->execute($values);
    
    //$this->studenttable->insert($values);
}

ob_start();
require '../templates/index.html.php';
$content = ob_get_clean();
$header = 'Create Student Record';
$title = 'Create Student Record';
require '../templates/layout.html.php';
?>