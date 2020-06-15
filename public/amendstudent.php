<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';

if(isset($_POST['submit']))
{
    //once the submit button is pressed update the selected student that needed to be amended
    save($pdo,'students',$_POST['student'], 'id');
    header('location: amendstudentlist.php');
    

}
//find the student and display it so that the info can be amended
$student = find($pdo,'students','id', $_POST['id'])[0];

$templatevars = [
    'student' => $student
];

$content = loadtemplate('../templates/amendstudent.html.php',$templatevars);
$header = 'Amend Student Record';
$title = "Amend Student Record";
require '../templates/layout.html.php';
?>