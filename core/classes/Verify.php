<?php


class Verify
{
protected $db;
protected $user;

 public function __construct()
 {

     $this->db = \Database::instance();
     $this->user = new Users();
 }

    /**
     * @return string
     */
 public static function generateLink(){
     return str_shuffle(substr(md5(time().mt_rand().time()),0,25));
 }

    /** verify if a code exists in db
     * @param $code
     * @return mixed
     */
 public function verifyCode($code){
     return $this->user->get('verification', array('code' => $code));
 }

 public function sendToMail($mail, $message){
     $mail = new \PHPMailer\PHPMailer\PHPMailer(true);
     $mail->isSMTP();
     $mail->SMTPAuth = true;
     $mail->SMTPDebug = 0;
     $mail->Host = M_HOST;
     $mail->Username = M_USERNAME;
     $mail->Password = M_PASSWORD;
     $mail->SMTPSecure = M_SMPTPSECURE;
     $mail->Port = M_PORT;

     if(!empty($email)){
         $mail->From = "petrisor@madball.com";
         $mail->FromName = "petrisor";
         $mail->addReplyTo("reply@petrisor.com");
         $mail->addAddress($email);
         $mail->Subject = 'verificare';
         $mail->Body = $message;
         $mail->AltBody =$message;

         if(!$mail->send()){
             return false;
         }else{
             return true;
         }

     }

 }

}