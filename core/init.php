<?php
        include 'config.php';
        include 'classes/PHPMailer.php';
        include 'classes/SMTP.php';
        include 'classes/Exception.php';
        date_default_timezone_set('Europe/Bucharest');

//        autoloader - includes classes
        spl_autoload_register(function($class){
            require_once "classes/{$class}.php";
        });

        $userObj = new Users();
        $verifyObj  = new Verify();

        session_start();