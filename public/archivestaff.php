<?php
require '../database.php';
require '../loadtemplate.php';
require 

if(isset($_POST['archive']))
{
    $check = $pdo->prepare('SELECT * FROM staff WHERE id= :id');
    $values = [
        'id' => $_POST['id']
    ];
    $check->execute($values);
    $move = $check->fetch();

    $archive = $pdo->prepare('INSERT INTO archivedstaff (staffstatus, dormancyreason, firstname, middlename, surname, staffid, address, phonenumber, email, roles, specialistsub)
                                VALUES(:staffid, :dormancyreason, :firstname, :middlename, :surname, :staffid, :address, :phonenumber, :email, :roles, :specialistsub)');

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
    $archive->execute($val);

    $delete = $pdo->prepare('DELETE FROM staff WHERE id = :id');

    $record = [
        'id' => $move['id']
    ];

    $delete->execute($record);
    
}

if(isset($_GET['submit']))
{
    $search = $pdo->prepare('SELECT * FROM staff WHERE staffid = :staffid');

    $values = [
        'staffid' => $_GET['search']
    ];
    $search->execute($values);
    $stmt = $search->fetchAll();

    $templatevars = [
        'stmt' => $stmt,
        'buttonName' => 'Archive',
        'location' => 'archivestaff.php'
    ];
}
else{
$stmt = $pdo->prepare('SELECT * FROM staff');
$stmt->execute();
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