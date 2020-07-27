<?php
namespace Diary\Controllers;

class Report {
    
    public function __construct() {

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


}