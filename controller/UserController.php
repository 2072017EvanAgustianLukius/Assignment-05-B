<?php

namespace controller;

use dao\UserDao;

class UserController
{
    private UserDao $userDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
    }
    public function index():void
    {
        $loginPressed = filter_input(INPUT_POST, 'btnLogin');
        if (isset($loginPressed)){
            $email = filter_input(INPUT_POST, 'email');
            $password = filter_input(INPUT_POST,'pwd');
            if(trim($email) == '' || trim($password) == ''){
                echo '<div>Please fill email and password</div>';
            }else{
                $user = $this->userDao->login($email, $password);
                if (!$user) {
                    echo '<div>Invalid Email or Password</div>';
                } else if ($user->getEmail() == $email){
                    $_SESSION['is_user_logged'] = true;
                    $_SESSION['user_name'] = $user->getName();
                    header('location:index.php');
                }
            }
        }
        include_once 'pages/login.php';
    }
}