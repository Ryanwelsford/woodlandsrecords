<?php
namespace Controllers;
class staffController{
    private $stafftable;
    private $unassignedstafftable;
    private $archivestafftable;

    public function __construct($stafftable, $unassignedstafftable,$archivestafftable)
    {
        $this->stafftable = $stafftable;
        $this->unassignedstafftable = $unassignedstafftable;
        $this->archivestafftable = $archivestafftable;
    }

    public function createstaff()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        if(isset($_POST['submit']))
        {
        //when submit button pressed insert info in the 2 tables
    
            $this->stafftable->save($_POST['staff']);
    
            $this->unassignedstafftable->save($_POST['staff']);

        }
            return[
                'template' => 'createstaff.html.php',
                'title' => 'Create Staff Record',
                'layout' => 'layout',
                'header' => 'Create Staff Record',
                'variables' => []
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


    public function liststaff()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        if(isset($_GET['submit']))
        {

            $stmt = $this->stafftable->find('staffid',$_GET['search']);

        }
        else{

        $stmt = $this->stafftable->findAll();

    }


    return [
        'template' => 'liststaff.html.php',
        'title' => 'Staff List',
        'layout' => 'layout',
        'header' => 'Staff List',
        'variables' => [
            'stmt' => $stmt,
            'buttonName' => 'Amend',
            'location' => '/amendstaff'
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

    public function amendstaff()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        if(isset($_POST['submit']))
        {
            $this->stafftable->update($_POST['staff']);
            //ONCE THE TABLES ARE EMPTY MAKE SURE TO ALSO ADD THE FUNCTION TO 
            //UPDATE THE UNASSIGNEDSTAFF TABLE AS THEY WORK HAND IN HAND
            header('location: /liststaff');
        }



        $staff = $this->stafftable->find('id',$_POST['id'])[0];

        return [
            'template' => 'amendstaff.html.php',
            'title' => 'Amend Staff Record',
            'layout' => 'layout',
            'header' => 'Amend Staff Record',
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


    public function archivestaff()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        if(isset($_POST['archive']))
{
    
    $move = $this->stafftable->find('id',$_POST['id'])[0];

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
    $this->archivestafftable->insert($val);

    // delete from the staff table as its now archived
    $this->stafftable->delete('id',$move['id']);
    
}

if(isset($_GET['submit']))
{


            $stmt = $this->stafftable->find('staffid',$_GET['search']);

            
        }
        else{
        $stmt = $this->stafftable->findAll();

        
        }

        return [
            'template' => 'liststaff.html.php',
            'title' => 'Archive Staff Record',
            'layout' => 'layout',
            'header' => 'Archive Staff Record',
            'variables' => [
                'stmt' => $stmt,
                'buttonName' => 'Archive',
                'location' => '/archivestaff'
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


    public function staffdisplaylist()
    {
        session_start();
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        if(isset($_GET['submit']))
{

    $stmt = $this->stafftable->find('staffid',$_GET['search']);
    
}
else{

$stmt = $this->stafftable->findAll();

}



return [
    'template' => 'liststaff.html.php',
    'title' => 'Staff List',
    'layout' => 'layout',
    'header' => 'Staff List',
    'variables' => [
        'stmt' => $stmt,
        'buttonName' => 'Display',
        'location' => '/displaystaff'
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


    public function displaystaff()
    {
        session_start();

        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true)
        {
        $staff = $this->stafftable->find('id',$_POST['id'])[0];


return [
    'template' => 'displaystaff.html.php',
    'title' => 'Staff Record',
    'layout' => 'layout',
    'header' => 'Staff Record',
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

}
?>