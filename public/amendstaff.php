<?php
require '../database.php';
require '../loadtemplate.php';
require '../functions.php';
if(isset($_POST['submit']))
{
    // $update = $pdo->prepare('UPDATE staff SET staffstatus = :staffstatus, dormancyreason = :dormancyreason, firstname = :firstname, middlename = :middlename, surname = :surname, staffid = :staffid, address = :address, phonenumber = :phonenumber, email = :email, roles = :roles, specialistsub = :specialistsub WHERE id = :id');

    // $record = [
    //     'id' => $_POST['id'],
    //     'staffstatus' => $_POST['staffstatus'],
    //     'dormancyreason' => $_POST['dormancy'],
    //     'firstname' => $_POST['firstname'],
    //     'middlename' => $_POST['middlename'],
    //     'surname' => $_POST['surname'],
    //     'staffid' => $_POST['staffid'],
    //     'address' => $_POST['address'],
    //     'phonenumber' => $_POST['phonenum'],
    //     'email' => $_POST['email'],
    //     'roles' => $_POST['roles'],
    //     'specialistsub' => $_POST['specialsub']
    // ];
    // $update->execute($record);
    // header('location: liststaff.php');
    save($pdo,'staff',$_POST['staff'],'id');
    //ONCE THE TABLES ARE EMPTY MAKE SURE TO ALSO ADD THE FUNCTION TO 
    //UPDATE THE UNASSIGNEDSTAFF TABLE AS THEY WORK HAND IN HAND
    header('location: liststaff.php');
}


$staff = find($pdo,'staff','id',$_POST['id'])[0];
$templatevars = [
    'staff' => $staff
];

$content = loadtemplate('../templates/amendstaff.html.php', $templatevars);
$header = 'Amend Staff Record';
$title = 'Amend Staff Record';
require '../templates/layout.html.php';
?>