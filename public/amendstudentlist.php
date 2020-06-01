<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_GET['submit']))
{
    $search = $pdo->prepare('SELECT * FROM students WHERE studentid= :studentid');

    $values = [
        'studentid' => $_GET['search']
    ];

    $search->execute($values);
    $stmt = $search->fetchAll();

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Amend'
    ];


}
else{
$stmt = $pdo->prepare('SELECT * FROM students');
$stmt->execute();

$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Amend',
    'location' => 'amendstudent.php'
];
}
$content = loadtemplate('../templates/amendstudentlist.html.php',$templatevars);
// ob_start();
// require '../templates/amendstudentlist.html.php';
// $content = ob_get_clean();
$title = 'Student List';
$header = 'Student List';
require '../templates/layout.html.php';

?>