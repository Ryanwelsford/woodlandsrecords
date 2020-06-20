<?php
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
        if(isset($_POST['submit']))
        {
        //when submit button pressed insert info in the 2 tables
    
            $this->stafftable->save($_POST['staff']);
    
            $this->unassignedstafftable->save($_POST['staff']);

        }
            return[
                'template' => 'createstaff.html.php',
                'title' => 'Create Staff Record',
                'header' => 'Create Staff Record',
                'variables' => []
            ];
    }


    public function liststaff()
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
        'header' => 'Staff List',
        'variables' => [
            'stmt' => $stmt,
            'buttonName' => 'Amend',
            'location' => '/amendstaff'
        ]
        ];


    }

    public function amendstaff()
    {
        if(isset($_POST['submit']))
        {
            $this->stafftable->save($_POST['staff']);
            //ONCE THE TABLES ARE EMPTY MAKE SURE TO ALSO ADD THE FUNCTION TO 
            //UPDATE THE UNASSIGNEDSTAFF TABLE AS THEY WORK HAND IN HAND
            header('location: /liststaff');
        }



        $staff = $this->stafftable->find('id',$_POST['id'])[0];

        return [
            'template' => 'amendstaff.html.php',
            'title' => 'Amend Staff Record',
            'header' => 'Amend Staff Record',
            'variables' => [
                'staff' => $staff
            ]
            ];
    }


    public function archivestaff()
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
            'header' => 'Archive Staff Record',
            'variables' => [
                'stmt' => $stmt,
                'buttonName' => 'Archive',
                'location' => '/archivestaff'
            ]
            ];

    }


    public function staffdisplaylist()
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
    'header' => 'Staff List',
    'variables' => [
        'stmt' => $stmt,
        'buttonName' => 'Display',
        'location' => '/displaystaff'
    ]
    ];
    }


    public function displaystaff()
    {
        $staff = $this->stafftable->find('id',$_POST['id'])[0];


return [
    'template' => 'displaystaff.html.php',
    'title' => 'Staff Record',
    'header' => 'Staff Record',
    'variables' => [
        'staff' => $staff
    ]
    ];
    }

}
?>