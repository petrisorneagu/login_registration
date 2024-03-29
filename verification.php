<?php
//echo 'verification';
include 'core/init.php';


    $user_id = $_SESSION['user_id'] ;
    $user = $userObj->userData($user_id);
//    echo $user->user_id;

    //$user_id = 8;

if(isset($_POST['email'])){
    $link = Verify::generateLink();
    $message = "{$user->firstName}, Your acc has been created. Visit this link to verify your account : <a href='{$link}'>Verify link</a>";
    $subject = "Account verification";
    $verifyObj->sendToMail($user->email, $message, $subject);
    $userObj->insert('verification', array('user_id' => 8, 'code' => $link));
    $userObj->redirect('verification.php?mail=sent');
}

if(isset($_GET['verify'])){
    $code = Validate::escape($_GET['verify']);
    $verify = $verifyObj->verifyCode($code);

    if($verify){
//        if verif code is expired
            if(date('Y-m-d', strtotime($verify->createdAt)) < date('Y-m-d')){
                $errors['verify'] = "Your verification link is expired";
            }else{
//                update user account
                $userObj->update('verification', array('status' => '1'), array('user_id' => $user_id, 'code' => $code));
                $userObj->redirect('home.php');
            }
    }else{
        $errors['verify'] = 'Invalid verification link';
    }
}

if(isset($_POST['phone'])){
    $number = Validate::escape($_POST['number']);

    if(!empty($number)){
            if(preg_match("/(^[0-9]+)$/", $number)){
                $number = urlencode($number);
                $code = $verifyObj->generateCode();
                $message = "$user->firstName, your account has been created, this is your verification code: {$code}";
                $result = $verifyObj->sendToPhone($number, $message);
                $userObj->insert('verification', array('user_id'=>$user_id, 'code' => $code));
                if($result){
//                    update the phone nr. in user table
                    $userObj->update('users', array('phone'=>$number), array('user_id' => $user_id));
//                    $userObj->redirect('verification.php');
                }else{
                    $errors['phone'] = "Something went wrong. Try again or other method.";
                }

            }else{
                $errors['phone'] = "Only valid numbers are allowed";
            }
    }else{
        $errors['phone'] = 'Enter your mobile phone to get verification code';
    }

}

//echo $userObj->userData($user_id);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Verification</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">
</head>
<body class="body2">
<div class="p2-wrapper">
    <div class="sign-up-wrapper">
        <div class="sign-up-inner">
            <div class="sign-up-div">
                <div class="name">
                <?php if(isset($_GET['verify']) || !empty($_GET['verify'])){
                    if(isset($errors['verify'])){
                        echo "<h4>" .$errors['verify']. "</h4>";
                    }
                }else{
//                    display the form
                ?>
                    <fieldset>
                        <h4>Your account has been created, you need to activate your account by following methods:</h4>
                        <legend>Method 1</legend>
                        <?php if(isset($_GET['mail'])) :?>
                            <h4>A verification mail has been sent to your email.</h4>
                        <?php else :?>
                            <h3>Email verification</h3>
                            <form method="POST">
                                <input type="email" name="email"  placeholder="" value=""/>
                                <button type="submit" class="suc">Send me verification email</button>
                            </form>
                        <?php endif;?>
                    </fieldset>
                </div>
                <!-- Email error field -->
                <?php if(isset($errors['email'])) :?>
                <span class="error-in"><b><?=$errors['email'];?></b></span>
                <?php endif;?>
                <fieldset>
                    <legend>Method 2</legend>
                    <div>
                        <h3>Phone verification</h3>
                        <form method="POST">
                            <input type="tel" name="number" placeholder="" value=""/>
                            <button type="submit" name="phone" class="suc">Send verification code via SMS</button>
                        </form>
                    </div>
                </fieldset>
                <!-- Phone error field -->
                <?php if(isset($errors['phone'])) :?>
                    <span class="error-in"><b><?=$errors['phone'];?></b></span>
                <?php endif;?>
            </div>
            <?php } ?>
        </div>
    </div>
</div>
</body>
</html>

