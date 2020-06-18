<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
require '../databasetable.php';

$stafftable = new databasetable($pdo,'staff','id');
if(isset($_POST['submit']))
{
    $stafftable->save($_POST['staff']);
    //ONCE THE TABLES ARE EMPTY MAKE SURE TO ALSO ADD THE FUNCTION TO 
    //UPDATE THE UNASSIGNEDSTAFF TABLE AS THEY WORK HAND IN HAND
    header('location: liststaff.php');
}



$staff = $stafftable->find('id',$_POST['id'])[0];
$templatevars = [
    'staff' => $staff
];

$content = loadtemplate('../templates/amendstaff.html.php', $templatevars);
$header = 'Amend Staff Record';
$title = 'Amend Staff Record';
require '../templates/layout.html.php';
?>