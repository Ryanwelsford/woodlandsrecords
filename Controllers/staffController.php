<?php
class staffController{
    private $stafftable;
    private $unassignedstafftable;

    public function __construct($stafftable, $unassignedstafftable)
    {
        $this->stafftable = $stafftable;
        $this->unassignedstafftable = $unassignedstafftable;
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

    

}
?>