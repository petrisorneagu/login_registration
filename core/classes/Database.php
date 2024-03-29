<?php

class Database
{
    protected $pdo;
    protected static $instance;

    protected function __construct(){
        try{
            $dsn = 'mysql:host='.DB_HOST.';dbname='.DB_NAME ;
            $this->pdo = new PDO('mysql:host='.DB_HOST.';dbname='.DB_NAME, DB_USER, DB_PASS,array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
//            die(json_encode(array('outcome' => true)));

        }catch (PDOException $e){
//            message for debug
            echo $e->getMessage();
        }
    }

//    make DB accessible without instantiation
    public static function instance(){
        if(self::$instance === null){
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function __call($method, $args){
        return call_user_func_array(array($this->pdo, $method ), $args);
    }
}