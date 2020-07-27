<?php
namespace Diary\Controllers;

class General {
    
    public function __construct() {

    }

    public function construction() {
        $title = 'Under Construction';
        $h1 = "This page is currently under construction";
        $p = "Watch this space for more details";
        return [
            'template' => 'construction.html.php',
            'title' => $title,
            'variables' => [
                'h1' => $h1,
                'p' => $p
            ]
        ];
    }

    public function pageNotFound() {
        $title = 'Under Construction';
        $h1 = "This page was not found";
        $p = "If you are encountering this error please check you have accessed the correct page";
        return [
            'template' => 'construction.html.php',
            'title' => $title,
            'variables' => [
                'h1' => $h1,
                'p' => $p
            ]
        ];
    }
}