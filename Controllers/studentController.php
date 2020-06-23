<?php
namespace Controllers;
require '../database.php';
class studentController {
    private $studenttable;
    private $archivedstudenttable;

    public function __construct($studenttable, $archivestudenttable)
    {
        $this->studenttable = $studenttable;
        $this->archivedstudenttable = $archivestudenttable;

    }

    public function home()
    {
        session_start();
        if(isset($_POST['loginsubmit']))
        {
            if($_POST['username'] == 'admin' && $_POST['password'] == 'test')
            {
                $_SESSION['loggedin'] = true;
            }
        }
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        if(isset($_POST['submit']))
        {
            //when submit button is pressed submit the information to the students table
            $this->studenttable->save($_POST['student']);
        }
            // $content = loadtemplate('../templates/index.html.php',[]);
            // $header = 'Create Student Record';
            // $title = 'Create Student Record';
            
            return [
                'template' => 'index.html.php',
                'layout' => 'layout',
                'title' => 'Create Student Record',
                'header' => 'Create Student Record',
                'variables' => []
            ];
        }
        else{
            return [
                'template' => 'login.html.php',
                'layout' => 'loginlayout',
                'title' => 'Login',
                'header' => 'Login',
                'variables' => []
            ];
        }
    }


    public function amendstudentlist()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        if(isset($_GET['submit']))
        {
            //when searching for a student find the student with the id number entered
    
            $stmt = $this->studenttable->find('studentid',$_GET['search']);

            

        }
        else{
            //get all students in the students table and store it in $stmt
            $stmt = $this->studenttable->findAll();

            }

        return [
            'template' => 'amendstudentlist.html.php',
            'title' => 'Student List',
            'layout' => 'layout',
            'header' => 'Student List',
            'variables' => [
                'stmt' => $stmt,
                'buttonName' => 'Amend',
                'location' => '/amendstudent'
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


    public function amendstudent()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        if(isset($_POST['submit']))
        {
            //once the submit button is pressed update the selected student that needed to be amended

            $this->studenttable->update($_POST['student']);
            header('location: /amendstudentlist');
    

        }
        //find the student and display it so that the info can be amended

        $student = $this->studenttable->find('id',$_POST['id'])[0];

    

        return [
            'template' => 'amendstudent.html.php',
            'title' => 'Amend Student Record',
            'layout' => 'layout',
            'header' => 'Amend Student Record',
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
                'variables'=> []
            ];
        }
    }


    public function archive()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
        if(isset($_POST['archive']))
{
    $check = $this->studenttable->find('studentid',$_POST['id'])[0];


    $values = [
        'studentid' => $check['studentid'],
        'firstname' => $check['firstname'],
        'middlename' => $check['middlename'],
        'surname' => $check['surname'],
        'studentstatus' => 'Dormant',
        'dormancyreason' => $check['dormancyreason'],
        'termaddress' => $check['termaddress'],
        'nonaddress' => $check['nonaddress'],
        'phonenum' => $check['phonenum'],
        'email' => $check['email'],
        'coursecode' => $check['coursecode'],
        'entryqual' => $check['entryqual']
    ];

   

    //insert into the archived student table
    $this->archivedstudenttable->insert($values);
    // then delete it from the student table
    $this->studenttable->delete('studentid',$_POST['id']);

}

if(isset($_GET['submit']))
{
//find the student with the student id entered
    $stmt = $this->studenttable->find('studentid',$_GET['search']);

}
else{
//get all students in the students table
$stmt = $this->studenttable->findAll();

}

        return [
            'template' => 'archive.html.php',
            'title' => 'Archive Student',
            'layout' => 'layout',
            'header' => 'Archive Student',
            'variables' => [
                'stmt' => $stmt
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



public function displaystudentlist()
{
    session_start();
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
    {
    $stmt = $this->studenttable->findAll();

return [
    'template' => 'amendstudentlist.html.php',
    'title' => 'Student List',
    'layout' => 'layout',
    'header' => 'Student List',
    'variables' => [
        'stmt' => $stmt,
        'buttonName' => 'Display',
        'location' => '/displaystudent'
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

public function displaystudent()
{
    session_start();
    if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
    {
    $student = $this->studenttable->find('id',$_POST['id'])[0];


    return [
        'template' => 'displaystudent.html.php',
        'title' => 'Student Information',
        'layout' => 'layout',
        'header' => 'Student Information',
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