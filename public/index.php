<?php
require '../database.php';
// require '../databasetable.php';
require '../loadtemplate.php';
require '../functions.php';

// $studenttable = new databasetable($pdo,'students','studentid');

if(isset($_POST['submit']))
{
    //when submit button is pressed submit the information to the students table
    save($pdo,'students', $_POST['student'], 'id');
    
}
$content = loadtemplate('../templates/index.html.php',[]);
$header = 'Create Student Record';
$title = 'Create Student Record';
require '../templates/layout.html.php';
?>