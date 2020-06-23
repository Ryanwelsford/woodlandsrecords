<?php

class loginController{
    private $logintable;

    public function __construct($logintable)
    {
        $this->logintable = $logintable;
    }

    public function login()
    {
        // $content = loadtemplate('../templates/login.html.php',[]);
        // $header = 'Login';
        // $title = 'Login';
        return [
            'template' => 'login.html.php',
            'title' => 'Login',
            'layout'=>'loginlayout',
            'header' => 'Login',
            'variables' => []
        ];
    }
}

?>