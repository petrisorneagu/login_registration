<?php


class Verify
{
protected $db;
protected $user;

 public function __construct(){
     $this->db = \Database::instance();
     $this->user = new Users();
 }

    /**
     * @return string
     */
 public static function generateLink(){
     return str_shuffle(substr(md5(time().mt_rand().time()),0,25));
 }

 public function generateCode(){
     return mb_strtoupper(substr(md5(mt_rand().time()), 0, 5));
 }

    /** verify if a code exists in db
     * @param $code
     * @return mixed
     */
 public function verifyCode($code){
     return $this->user->get('verification', array('code' => $code));
 }


 public function authOnly(){
     $user_id = $_SESSION['user_id'];
     $stmt = $this->db->prepare("SELECT * FROM verification WHERE `user_id` = :user_id ORDER BY `createdAt` DESC");
     $stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT); //bind only integers
     $stmt->execute();
     $user = $stmt->fetch(PDO::FETCH_OBJ);
     $files = array('verification.php', 'verifyCode.php');

     if(!$this->user->isLoggedIn()){
         $this->user->redirect('index.php');
     }

     if(!empty($user)){
//             if user is not verified
         if($user->status === '0' && in_array(basename($_SERVER['SCRIPT_NAME']), $files)){
             $this->user->redirect('verification.php');
         }

//         if user in verified
         if($user->status === '1' && in_array(basename($_SERVER['SCRIPT_NAME']), $files)){
             $this->user->redirect('home.php');
         }else if(!in_array(basename($_SERVER['SCRIPT_NAME']), $files)){
             $this->user->redirect('verification.php');
         }
     }
 }


 public function sendToMail($email, $message){
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

 public function sendToPhone($number, $message){
     $username = 'petrisor@madball.ro';

//     this is from "text local" api documentation
     $apiHash = "e16e12ae606a712724ee37f216c93644a16d49f69481c95b4c6443a90674be3d";
     $apiUrl = "https://api.txtlocal.com/send/";
     $test = "0";
//     post username api hash and sms
     $data = "username={$username}&hash={$apiHash}&message={$message}&numbers={$number}&test={$test}";

     if(!empty($number)){
         $ch = curl_init($apiUrl);
         curl_setopt($ch, CURLOPT_POST, true);
         curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $response  =curl_exec($ch);

         $result = json_decode($response);

//         var_dump($response);
         if($result->status === 'success'){
             return true;
         }else{
             return false;
         }

     }
 }

}