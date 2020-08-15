<?php
namespace Controllers;
class loginController{
    private $logintable;
    //public function __construct($logintable)
    public function __construct($logintable = false)
    {
        $this->logintable = $logintable;
    }

    //log user into system
    public function login($error = false)
    {
        // $content = loadtemplate('../templates/login.html.php',[]);
        // $header = 'Login';
        // $title = 'Login';
        $user = false;
        //if login submitted
        if(isset($_POST['loginsubmit'])) {
            //if logged in with correct info
            //needs updating to check against a user table at later date
            if($_POST['username'] == 'admin' && $_POST['password'] == 'test')
            {
                $_SESSION['loggedin'] = true;
                
            }
            else {
                // if not logged in display error and refill form
                $error = "Incorrect username or password";
                $user['username'] = $_POST['username'];
            }
        }
        // if user is logged send to home page, should change to dashboard concept, currently sends to student create page
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            header('location: /student/home');
        }
        $title = 'Login';

        return [
            'template' => 'login.html.php',
            'title' => $title,
            'variables' => [
                'error' => $error,
                'user' => $user
            ]
        ];
    }

    //logout user unset session plus send to login page
    public function logout() {
        if(isset($_SESSION['loggedin'])) {
            unset($_SESSION['loggedin']);
            header('location: /login');
            
        }
    }
}

?>