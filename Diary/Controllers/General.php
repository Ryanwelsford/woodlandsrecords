<?php
namespace Diary\Controllers;

class General {
    //purpose of this controller is for options that do nto regularly fit into other controllers, i.e. page not found and page in construction.
    public function __construct() {

    }

    //for pages that are not built but ultimately would be in final build
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

    //for when navigating to a page that does not exist
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