<?php
require '../database.php';
require '../databasetable.php';
require '../loadtemplate.php';
require '../functions.php';

$studenttable = new databasetable($pdo,'students','id');


if($_SERVER['REQUEST_URI'] !== '/')
{
    // require '../pages/' . $_GET['page'] . '.php';
    require '../pages/' .ltrim(explode('?', $_SERVER['REQUEST_URI'])[0], '/') . '.php';
}
else
{
    if(isset($_POST['submit']))
    {
    //when submit button is pressed submit the information to the students table
    $studenttable->save($_POST['student']);
    }
    $content = loadtemplate('../templates/index.html.php',[]);
    $header = 'Create Student Record';
    $title = 'Create Student Record';   
}

require '../templates/layout.html.php';
?>