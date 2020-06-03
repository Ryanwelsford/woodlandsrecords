<?php
require '../database.php';
require '../loadtemplate.php';

if(isset($_POST['submit']))
{
    $update = $pdo->prepare('UPDATE staff SET staffstatus = :staffstatus, dormancyreason = :dormancyreason, firstname = :firstname, middlename = :middlename, surname = :surname, staffid = :staffid, address = :address, phonenumber = :phonenumber, email = :email, roles = :roles, specialistsub = :specialistsub WHERE id = :id');

    $record = [
        'id' => $_POST['id'],
        'staffstatus' => $_POST['staffstatus'],
        'dormancyreason' => $_POST['dormancy'],
        'firstname' => $_POST['firstname'],
        'middlename' => $_POST['middlename'],
        'surname' => $_POST['surname'],
        'staffid' => $_POST['staffid'],
        'address' => $_POST['address'],
        'phonenumber' => $_POST['phonenum'],
        'email' => $_POST['email'],
        'roles' => $_POST['roles'],
        'specialistsub' => $_POST['specialsub']
    ];
    $update->execute($record);
    header('location: liststaff.php');
}

$stmt = $pdo->prepare('SELECT * FROM staff WHERE id = :id');

$values = [
    'id' => $_POST['id']
];

$stmt->execute($values);
$staff = $stmt->fetch();

$templatevars = [
    'staff' => $staff
];

$content = loadtemplate('../templates/amendstaff.html.php', $templatevars);
$header = 'Amend Staff Record';
$title = 'Amend Staff Record';
require '../templates/layout.html.php';
?>