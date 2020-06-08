<?php
require '../database.php';
require '../loadtemplate.php';
if(isset($_POST['submit']))
{
    $stmt = $pdo->prepare('INSERT INTO staff (staffstatus, dormancyreason, firstname, middlename, surname, staffid, address, phonenumber, email, roles, specialistsub)
                            VALUES (:staffstatus, :dormancyreason, :firstname, :middlename, :surname, :staffid, :address, :phonenumber, :email, :roles, :specialistsub)');

    $unsigned = $pdo->prepare('INSERT INTO unassignedstaff (staffstatus, dormancyreason, firstname, middlename, surname, staffid, address, phonenumber, email, roles, specialistsub)
                            VALUES (:staffstatus, :dormancyreason, :firstname, :middlename, :surname, :staffid, :address, :phonenumber, :email, :roles, :specialistsub)');

    $values = [
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

    $stmt->execute($values);
    $unsigned->execute($values);

}
$content = loadtemplate('../templates/createstaff.html.php',[]);
$header = 'Create Staff Record';
$title = 'Create Staff Record';
require '../templates/layout.html.php';
?>