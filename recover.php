<?php
include 'core/init.php';

if(isset($_POST['recover'])){
    $email = Validate::escape($_POST['email']);
    if(!empty($email)){
//        email not valid
        if(!Validate::filterEmail($email)){
            $errors['email'] = "Invalid email format!";
        }else{
//            if email exist in db
            if($user = $userObj->emailExist($email)){

                $link = $verifyObj->generateLink();
                $message = "{$user->firstName}, Someone requested for a new pass. If you didn't , ignore the email. If you did, here is your reset link <a href='http://localhost/OOP_login_registration/recover.php/{$link}'>Reset pass</a>";
                $subject  = "Reset pass";
                $verifyObj->sendToMail($user->email, $message ,$subject);
                $userObj->insert('recovery', array('user_id' => $user->user_id, 'code' => $link));
                $userObj->redirect('recover.php?mail=sent'); 
            }else{
//                 error
                $errors['reset'] = "Email doesn't exist in the database";
            }
        }
    }else{
        $errors['reset'] = "Enter your email to reset your pass.";
    }
}


if(isset($_GET['verify'])){
    $code = Validate::escape($_GET['verify']);
    $verify = $verifyObj->verifyResetPassword($code);

    if($verify){
//        if verif code is expired
        if($verify->createdAt < date('Y-m-d')){
            $errors['verify'] = "Your verification link is expired";
        }else{
//                update user account
            $userObj->redirect('password.php?password=true&verify='. $verify->code);
        }
    }else{
        $errors['verify'] = 'Invalid verification link';
    }
}


?>
<!DOCTYPE html>
<html>
<head>
    <title>Reset your account password</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>
<div class="home-nav">
    <a href="home.php">Home</a>
</div>
<body class="body">
<div class="wrapper">
    <div class="header-wrapper">
        <h1>Reset Password</h1>
    </div>
    <div class="sign-div">
        <div class="sign-in">
            <?php if(isset($errors['verify'])):?>
                <div class="success-message"><?= $errors['verify'];?></div>
            <?php else:?>
                <?php if(isset($_GET['mail']) || (!empty($_GET['mail']))){
                    echo '<div class="success-message">An email has been sent to your email addr. with pass link</div>';
                }else{

                    ?>
                    <div class="signIn-inner">
                        <form method="POST">
                            <div class="input-div">
                                <input type="email" name="email" placeholder="Email">
                                <button type="submit" name="recover">Send Link</button>
                            </div>
                        </form>
                    </div>

                <?php } if(isset($errors['reset'])) : ?>
                    <div class="sign-in-error">
                        <?= $errors['reset'];?>
                    </div>
                <?php endif;?>
            <?php endif;?>
        </div>
    </div>
    <div class="footer-wrapper">
        <div class="inner-footer-wrap">

        </div>
    </div>
</div>
</body>
</html>
