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
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
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
            'layout' => 'layout',
            'header' => 'Staff List',
            'variables' => [
                'stmt' => $stmt,
                'buttonName' => 'Select',
                'location' => '/personaltutor'
        ]
        ];
    }
    else{
        return [
            'template' => 'login.html.php',
            'title' => 'Login',
            'layout' => 'loginlayout',
            'header' => 'Login',
            'variables' => []
        ];
    }

    }

    public function personaltutor()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
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
            'layout' => 'layout',
            'header' => 'Personal Tutor',
        'variables' => [
                'staff' => $staff
            ]
            ];
        }
        else{
            return [
                'template' => 'login.html.php',
                'title' => 'Login',
                'layout' => 'loginlayout',
                'header' => 'Login',
                'variables' => []
            ];
        }
    }


    public function amendpersonaltutorlist()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
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
    'layout' => 'layout',
    'header' => 'Personal Tutor List',
    'variables' => [
        'stmt' => $stmt,
        'buttonName' => 'Select',
        'location' => '/amendpersonaltutor'
    ]
    ];
}
else{
    return [
        'template' => 'login.html.php',
        'title' => 'Login',
        'layout' => 'loginlayout',
        'header' => 'Login',
        'variables' => []
    ];
}

    }

    public function amendpersonaltutor()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
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
                'layout' => 'layout',
                'header' => 'Amend Personal Tutor',
                'variables' => [
                    'staff' => $staff
                ]
                ];
            }
            else{
                return [
                    'template' => 'login.html.php',
                    'title' => 'Login',
                    'layout' => 'loginlayout',
                    'header' => 'Login',
                    'variables' => []
                ];
            }
    }

    public function assignpersonaltutorlist()
    {
        session_start();

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
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
            'layout' => 'layout',
            'header' => 'Student List',
            'variables' => [
                'stmt' => $stmt,
                'buttonName' => 'Assign',
                'location' => '/assignpersonaltutor'
            ]
            ];
        }
        else{
            return [
                'template' => 'login.html.php',
                'title' => 'Login',
                'layout' => 'loginlayout',
                'header' => 'Login',
                'variables' => []
            ];
        }
    }

    public function assignpersonaltutor()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
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
            'layout'=> 'layout',
            'header' => 'Assign Personal Tutor',
            'variables' => [
                'stmt' => $stmt,
                'student' => $student
            ]
            ];
        }
        else{
            return [
                'template' => 'login.html.php',
                'title' => 'Login',
                'layout' => 'loginlayout',
                'header' => 'Login',
                'variables' => []
            ];
        }

    }

    public function displaytutorlist()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
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
            'layout'=> 'layout',
            'header' => 'Personal Tutor List',
            'variables' => [
                'stmt' => $stmt,
                'buttonName' => 'Display',
                'location' => '/displaypersonaltutor'
            ]
            ];
        }
        else{
            return [
                'template' => 'login.html.php',
                'title' => 'Login',
                'layout' => 'loginlayout',
                'header' => 'Login',
                'variables' => []
            ];
        }
    }

    public function displaypersonaltutor()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        $student = $this->tuteestable->find('id',$_POST['id'])[0];
        return [
            'template' => 'personaltutordisplay.html.php',
            'title' => 'Personal Tutor',
            'layout'=>'layout',
            'header' => 'Personal Tutor',
            'variables' => [
                'student' => $student
            ]
            ];
        }
        else{
            return [
                'template' => 'login.html.php',
                'title' => 'Login',
                'layout' => 'loginlayout',
                'header' => 'Login',
                'variables' => []
            ];
        }
    }

}

?>