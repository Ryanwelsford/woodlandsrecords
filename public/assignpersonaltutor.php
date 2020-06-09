<?php
require '../database.php';
require '../loadtemplate.php';
$stmt = $pdo->prepare('SELECT * FROM personaltutor');
$stmt->execute();

if(isset($_POST['submit']))
{
    $stmt = $pdo->prepare('INSERT INTO tutees (tutorname,tutorsurname,tutorid,tuteename,tuteesurname,tuteeid,course)
                            VALUES (:tutorname, :tutorsurname, :tutorid, :tuteename, :tuteesurname, :tuteeid, :course)');

    $tutor = $pdo->prepare('SELECT * FROM personaltutor WHERE id = :id');

    $record = [
        'id' => $_POST['personaltutor']
    ];

    $tutor->execute($record);
    $staff = $tutor->fetch();
    
    $values = [
        'tutorname' => $staff['firstname'],
        'tutorsurname'=> $staff['surname'],
        'tutorid' => $staff['staffid'],
        'tuteename' => $_POST['studentfirstname'],
        'tuteesurname' => $_POST['studentsurname'],
        'tuteeid' => $_POST['studentid'],
        'course' => $_POST['course']
    ];
    $stmt->execute($values);
    header('location: assignpersonaltutorlist.php');
}
else{
$st = $pdo->prepare('SELECT * FROM students WHERE studentid= :studentid');
$values = [
    'studentid' => $_POST['id']
];
$st->execute($values);
$student = $st->fetch();
$templatevars = [
    'stmt' => $stmt,
    'student' => $student
];
}
$content = loadtemplate('../templates/assignpersonaltutor.html.php',$templatevars);
$header = 'Assign Personal Tutor';
$title = 'Assign Personal Tutor';
require '../templates/layout.html.php';
?>