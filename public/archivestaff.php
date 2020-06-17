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