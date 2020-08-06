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
    // allow for the creation of custom reports, these reports would allow you to view say grades and attendance of a student
    public function custom() {
        //first step would be select type i.e. staff/student

        //second step select aspects to be in report i.e. grades
    }
    //display all reports in tabbed format 
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

    //display all reports in tabbed formats, but each report opens in new tab and in print format
    public function print() {
        $title = "Select Printout";
        //set get var
        $linkAddition = "?print=true";
        //target blank within an anchor opens in a new tab
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

    //report displaying all students contact information ordered by their id
    public function studentContactsId() {
        $title = "Student Contacts by Id";
        $heading = "Student Contacts by Id";
        //find all ordered takes in an array, the key is used as the field, the value used is the way it is ordered
        $orderby = [
            'studentid' => "ASC"
        ];
        $students = $this->studentTable->findAllOrdered($orderby);
        //setting a heading enables the reuse of the template
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

    //reports displaying all students contact information ordered by the surname, then by firstname 
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

    //report displays staff contact information ordered by there staff id
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

    //report for all staff contact information ordered by the staff surname and firstname
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

    //display all modules ordered by year then name
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



}