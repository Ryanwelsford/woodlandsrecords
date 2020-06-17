<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';

if(isset($_POST['archive']))
{
    $check = $pdo->prepare('SELECT * FROM staff WHERE id= :id');
    $values = [
        'id' => $_POST['id']
    ];
    $check->execute($values);
    $move = $check->fetch();


    $val = [
        'staffstatus' => $move['staffstatus'],
        'dormancyreason' => $move['dormancyreason'],
        'firstname' => $move['firstname'],
        'middlename' => $move['middlename'],
        'surname' => $move['surname'],
        'staffid' => $move['staffid'],
        'address' => $move['address'],
        'phonenumber' => $move['phonenumber'],
        'email' => $move['email'],
        'roles' => $move['roles'],
        'specialistsub' => $move['specialistsub']
    ];
    insert($pdo,'archivedstaff',$val);

    delete($pdo,'staff','id',$move['id']);
    
}

if(isset($_GET['submit']))
{

    $stmt = find($pdo,'staff','staffid',$_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Archive',
        'location' => 'archivestaff.php'
    ];
}
else{
$stmt = findAll($pdo,'staff');

$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Archive',
    'location' => 'archivestaff.php'
];
}
$content = loadtemplate('../templates/liststaff.html.php', $templatevars);
$header = 'Archive Staff Record';
$title = 'Archive Staff Record';
require '../templates/layout.html.php';

?>