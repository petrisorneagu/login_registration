<?php
        include 'config.php';
        include 'classes/PHPMailer.php';
        include 'classes/SMTP.php';
        include 'classes/Exception.php';

//        autoloader - includes classes
        spl_autoload_register(function($class){
            require_once "classes/{$class}.php";
        });

        $userObj = new Users;

        session_start();