<?php
require '../database.php';
// require '../databasetable.php';
require '../loadtemplate.php';
require '../functions.php';

// $studenttable = new databasetable($pdo,'students','studentid');

if(isset($_POST['submit']))
{

    

    // $stmt = $pdo->prepare('INSERT INTO students (studentid,firstname,middlename,surname,studentstatus,dormancyreason,termaddress,nonaddress,phonenum,email,coursecode,entryqual)
    //                         VALUES (:studentid, :firstname, :middlename, :surname, :studentstatus, :dormancyreason, :termaddress, :nonaddress, :phonenum, :email, :coursecode, :entryqual)');
    // $values = [
    //     'studentid' => $_POST['studentid'],
    //     'firstname' => $_POST['firstname'],
    //     'middlename' => $_POST['middlename'],
    //     'surname' => $_POST['surname'],
    //     'studentstatus' => $_POST['studentstatus'],
    //     'dormancyreason' => $_POST['dormancy'],
    //     'termaddress' => $_POST['termaddress'],
    //     'nonaddress' => $_POST['nontermaddress'],
    //     'phonenum' => $_POST['number'],
    //     'email' => $_POST['email'],
    //     'coursecode' => $_POST['coursecode'],
    //     'entryqual' => $_POST['entryqual']
    // ];
    save($pdo,'students', $_POST['student'], 'id');
    // $stmt->execute($values);
    
    //$this->studenttable->insert($values);
}

// ob_start();
// require '../templates/index.html.php';
// $content = ob_get_clean();
$content = loadtemplate('../templates/index.html.php',[]);
$header = 'Create Student Record';
$title = 'Create Student Record';
require '../templates/layout.html.php';
?>