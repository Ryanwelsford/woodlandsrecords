<?php
require '../database.php';
require '../databasetable.php';
require '../loadtemplate.php';
require '../functions.php';

$studenttable = new databasetable($pdo,'students','id');

if(isset($_POST['submit']))
{
    //when submit button is pressed submit the information to the students table
    $studenttable->save($_POST['student']);
    
}
if(!isset($_GET['page']))
{
    $content = loadtemplate('../templates/index.html.php',[]);
    $header = 'Create Student Record';
    $title = 'Create Student Record';
}
else
{
    require '../pages/' . $_GET['page'] . '.php';
}

require '../templates/layout.html.php';
?>