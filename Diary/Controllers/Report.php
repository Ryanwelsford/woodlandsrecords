<?php
namespace Diary\Controllers;

class Report {
    private $studentTable;
    private $staffTable;
    private $tempCourseTable;

    public function __construct($studentReportTable, $staffReportTable, $tempCourseTable) {
        $this->studentTable = $studentReportTable;
        $this->staffTable = $staffReportTable;
        $this->tempCourseTable = $tempCourseTable;
    }

    public function display() {
        $title = "Select Report";

        return [
            'template' => 'reportdisplay.html.php',
            'title' => $title,
            'variables' => 
            [ 
            ]
        ];
    }

    public function print() {
        $title = "Select Printout";
        $linkAddition = "?print=true";
        $target = "target='_blank'";
        return [
            'template' => 'reportdisplay.html.php',
            'title' => $title,
            'variables' => 
            [ 
                'linkAddition' => $linkAddition,
                'target' => $target
            ]
        ];
    }

    public function studentContactsId() {
        $title = "Student Contacts by Id";
        $heading = "Student Contacts by Id";
        $orderby = [
            'studentid' => "ASC"
        ];
        $students = $this->studentTable->findAllOrdered($orderby);
        return [
            'template' => 'reportstudentcontactsid.html.php',
            'title' => $title,
            'variables' => 
            [ 
                'students' => $students,
                'heading' => $heading
            ]
        ];
    }

    public function studentContactsName() {
        $title = "Student Contacts by Surname";
        $heading = "Student Contacts by Surname";
        $orderby = [
            'surname' => "ASC",
            'firstname' => "ASC"
        ];
        $students = $this->studentTable->findAllOrdered($orderby);
        return [
            'template' => 'reportstudentcontactsid.html.php',
            'title' => $title,
            'variables' => 
            [ 
                'students' => $students,
                'heading' => $heading
            ]
        ];
    }

    public function staffContactsId() {
        $title = "Staff Contacts by Id";
        $heading = "Staff Contacts by Id";

        
        $orderby = [
            'staffid' => "ASC"
        ];
        $staff = $this->staffTable->findAllOrdered($orderby);
        return [
            'template' => 'reportstaffcontactsid.html.php',
            'title' => $title,
            'variables' => 
            [ 
                'staff' => $staff,
                'heading' => $heading
            ]
        ];
    }

    public function staffContactsName() {
        $title = "Staff Contacts by Surname";
        $heading = "Staff Contacts by Surname";

        
        $orderby = [
            'surname' => "ASC",
            'firstname' => "ASC"
        ];
        $staff = $this->staffTable->findAllOrdered($orderby);
        return [
            'template' => 'reportstaffcontactsid.html.php',
            'title' => $title,
            'variables' => 
            [ 
                'staff' => $staff,
                'heading' => $heading
            ]
        ];
    }

    public function moduleYear() {
        $title = "Modules by Year";
        $heading = "Modules by Year";
        $orderby = [
            'year' => 'ASC',
            'name' => 'ASC'
        ];

        $courses = $this->tempCourseTable->findAllOrdered($orderby);
        
        return [
            'template' => 'reportmodulebyyear.html.php',
            'title' => $title,
            'variables' => 
            [ 
                'courses' => $courses,
                'heading' => $heading
            ]
        ];
    }

    //find and order by name for student contacts by name


}