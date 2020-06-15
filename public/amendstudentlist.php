<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';

if(isset($_GET['submit']))
{
    //when searching for a student find the student with the id number entered
    $stmt = find($pdo, 'students', 'studentid', $_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Amend',
        'location' => 'amendstudent.php'
    ];

}
else{
    //get all students in the students table and store it in $stmt
    $stmt = findAll($pdo, 'students');

$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Amend',
    'location' => 'amendstudent.php'
];
}
$content = loadtemplate('../templates/amendstudentlist.html.php',$templatevars);

$title = 'Student List';
$header = 'Student List';
require '../templates/layout.html.php';

?>