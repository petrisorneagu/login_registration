<?php
include '../core/init.php';

//if user is logged in

if(!$userObj->isLoggedIn()){
    $userObj->redirect('index.php');
}else{
    $userObj->logout();
}