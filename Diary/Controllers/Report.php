<?php
namespace Diary\Controllers;

class Report {
    private $studentTable;

    public function __construct($studentReportTable) {
        $this->studentTable = $studentReportTable;
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
        //already ordered by id although an order by would be better
        $students = $this->studentTable->findAll();

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

    //find and order by name for student contacts by name


}