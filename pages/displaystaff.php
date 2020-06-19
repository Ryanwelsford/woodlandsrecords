<?php
require '../database.php';
$stafftable = new databasetable($pdo,'staff','id');

$staff = $stafftable->find('id',$_POST['id'])[0];
$templatevars = [
    'staff' => $staff
];
$content = loadtemplate('../templates/displaystaff.html.php', $templatevars);
$header = 'Staff Record';
$title = 'Staff Record';

?>