<?php
require '../database.php';

$studenttable = new databasetable($pdo,'students','id');

if(isset($_GET['submit']))
{
    //when searching for a student find the student with the id number entered
    
    $stmt = $studenttable->find('studentid',$_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Amend',
        'location' => '/amendstudent'
    ];

}
else{
    //get all students in the students table and store it in $stmt
    $stmt = $studenttable->findAll();

$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Amend',
    'location' => '/amendstudent'
];
}
$content = loadtemplate('../templates/amendstudentlist.html.php',$templatevars);

$title = 'Student List';
$header = 'Student List';
// require '../templates/layout.html.php';

?>