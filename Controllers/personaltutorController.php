<?php
namespace Controllers;
class personaltutorController{
    private $unassignedstafftable;
    private $personaltutortable;
    private $studenttable;
    private $tuteestable;

    public function __construct($unassignedstafftable,$personaltutortable,$studenttable,$tuteestable)
    {
        $this->unassignedstafftable = $unassignedstafftable;
        $this->personaltutortable = $personaltutortable;
        $this->studenttable = $studenttable;
        $this->tuteestable = $tuteestable;
    }

    public function personaltutorlist()
    {
        if(isset($_GET['submit']))
        {

            $stmt = $this->unassignedstafftable->find('staffid',$_GET['search']);
 
        }
        else{

        $stmt = $this->unassignedstafftable->findAll();

        }


        return [
            'template' => 'liststaff.html.php',
            'title' => 'Personal Tutor',
            'header' => 'Staff List',
            'variables' => [
                'stmt' => $stmt,
                'buttonName' => 'Select',
                'location' => '/personaltutor'
        ]
        ];


    }

    public function personaltutor()
    {
        if(isset($_POST['submit']))
        {
 

            $values = [
                'firstname' => $_POST['firstname'],
                'surname' => $_POST['surname'],
                'staffid' => $_POST['staffid'],
                'courseteaching' => $_POST['course']
            ];

            $this->personaltutortable->save($values);

            $this->unassignedstafftable->delete('id',$_POST['id']);


            header('location: /personaltutorlist');
    
        }

        $staff = $this->unassignedstafftable->find('id',$_POST['id'])[0];


        return [
            'template' => 'personaltutor.html.php',
            'title' => 'Personal Tutor',
            'header' => 'Personal Tutor',
        'variables' => [
                'staff' => $staff
            ]
            ];
    }


    public function amendpersonaltutorlist()
    {
        if(isset($_GET['submit']))
{

    $stmt = $this->personaltutortable->find('staffid',$_GET['search']);


}
else{

$stmt = $this->personaltutortable->findAll();

}

return [
    'template' => 'amendpersonaltutorlist.html.php',
    'title' => 'Amend Personal Tutor',
    'header' => 'Personal Tutor List',
    'variables' => [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => '/amendpersonaltutor'
    ]
    ];

    }

    public function amendpersonaltutor()
    {
        $pdo = new \PDO('mysql:dbname=woodlands;host=127.0.0.1', 'student', 'student', [\PDO::ATTR_ERRMODE =>  \PDO::ERRMODE_EXCEPTION ]);
        if(isset($_POST['submit']))
        {
            $update = $pdo->prepare('UPDATE personaltutor SET courseteaching = :courseteaching WHERE staffid = :staffid');

            $record = [
                'courseteaching' => $_POST['course'],
                'staffid' => $_POST['staffid']
            ];
            $update->execute($record);
            header('location: /amendpersonaltutorlist');
        }
        else{
            $staff = $this->personaltutortable->find('id',$_POST['id'])[0];

        }

            return [
                'template' => 'amendpersonaltutor.html.php',
                'title' => 'Amend Personal Tutor',
                'header' => 'Amend Personal Tutor',
                'variables' => [
                    'staff' => $staff
                ]
                ];
    }

    public function assignpersonaltutorlist()
    {


        if(isset($_GET['submit']))
        {

            $stmt = $this->studenttable->find('studentid',$_GET['search']);

        }
        else{

        $stmt = $this->studenttable->findAll();

        }

        return [
            'template' => 'amendstudentlist.html.php',
            'title' => 'Assign Personal Tutor',
            'header' => 'Student List',
            'variables' => [
                'stmt' => $stmt,
                'buttonName' => 'Assign',
                'location' => '/assignpersonaltutor'
            ]
            ];
    }

    public function assignpersonaltutor()
    {

        $stmt = $this->personaltutortable->findAll();

        if(isset($_POST['submit']))
        {
            $pdo = new \PDO('mysql:dbname=woodlands;host=127.0.0.1', 'student', 'student', [\PDO::ATTR_ERRMODE =>  \PDO::ERRMODE_EXCEPTION ]);
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
            header('location: /assignpersonaltutorlist');
        }
        else{

        $student = $this->studenttable->find('id',$_POST['id'])[0];

        }

        return [
            'template' => 'assignpersonaltutor.html.php',
            'title' => 'Assign Personal Tutor',
            'header' => 'Assign Personal Tutor',
            'variables' => [
                'stmt' => $stmt,
                'student' => $student
            ]
            ];

    }

    public function displaytutorlist()
    {
        if(isset($_GET['submit']))
        {
   
            $stmt = $this->tuteestable->find('tuteeid',$_GET['search']);
        }
        else{


        $stmt = $this->tuteestable->findAll();

        }

        return [
            'template' => 'displaypersonaltutor.html.php',
            'title' => 'Display Personal Tutor',
            'header' => 'Personal Tutor List',
            'variables' => [
                'stmt' => $stmt,
                'buttonName' => 'Display',
                'location' => '/displaypersonaltutor'
            ]
            ];
    }

    public function displaypersonaltutor()
    {

        $student = $this->tuteestable->find('id',$_POST['id'])[0];
        return [
            'template' => 'personaltutordisplay.html.php',
            'title' => 'Personal Tutor',
            'header' => 'Personal Tutor',
            'variables' => [
                'student' => $student
            ]
            ];
    }

}

?>