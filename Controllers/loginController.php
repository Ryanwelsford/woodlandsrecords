<?php
namespace Controllers;
class loginController{
    private $logintable;
    //public function __construct($logintable)
    public function __construct($logintable = false)
    {
        $this->logintable = $logintable;
    }

    public function login($error = false)
    {
        // $content = loadtemplate('../templates/login.html.php',[]);
        // $header = 'Login';
        // $title = 'Login';
        if(isset($_POST['loginsubmit'])) {
            if($_POST['username'] == 'admin' && $_POST['password'] == 'test')
            {
                $_SESSION['loggedin'] = true;
                
            }
            else {
                $error = "Incorrect username or password";
            }
        }
        
        if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
            header('location: /student/home');
        }
        $title = 'Login';

        return [
            'template' => 'login.html.php',
            'title' => $title,
            'variables' => [
                'error' => $error
            ]
        ];
    }

    public function logout() {
        if(isset($_SESSION['loggedin'])) {
            unset($_SESSION['loggedin']);
            //change this to the login page when complete
            header('location: /login');
            
        }
    }
}

?>