<?php
        include 'config.php';

//        autoloader - includes classes
        spl_autoload_register(function($class){
            require_once "classes/{$class}.php";
        });

        session_start();