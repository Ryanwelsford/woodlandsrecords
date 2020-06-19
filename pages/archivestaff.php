<?php
require '../database.php';


$stafftable = new databasetable($pdo,'staff','id');
$archivestafftable = new databasetable($pdo,'archivedstaff','id');

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
    //insert the archived staff into the archived staff table
    $archivestafftable->insert($val);

    // delete from the staff table as its now archived
    $stafftable->delete('id',$move['id']);
    
}

if(isset($_GET['submit']))
{


    $stmt = $stafftable->find('staffid',$_GET['search']);

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Archive',
        'location' => 'archivestaff.php'
    ];
}
else{
$stmt = $stafftable->findAll();

$templatevars = [
    'stmt' => $stmt,
    'buttonName' => 'Archive',
    'location' => 'archivestaff.php'
];
}
$content = loadtemplate('../templates/liststaff.html.php', $templatevars);
$header = 'Archive Staff Record';
$title = 'Archive Staff Record';

?>