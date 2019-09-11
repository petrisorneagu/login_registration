<?php
include  'core/init.php';

if(isset($_GET['password']) && isset($_GET['verify'])){
    if(!empty($_GET['password']) && !empty($_GET['verify'])){
        $code = Validate::escape($_GET['verify']);
        $verify = $verifyObj->verifyResetPassword($code);

        if($verify){
//        if verif code is expired
            if($verify->createdAt < date('Y-m-d')){
                $errors['verify'] = "Your password reset link is expired";
            }else{
//                update user account
                $userObj->update('recovery', array('status' => '1'), array('user_id' => $verify->user, 'code' => $code));
            }
        }else{
            $errors['verify'] = 'Invalid password reset link';
        }

    }else{
        $userObj->redirect('index.php');
    }
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Create New Password</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>
<body class="body">
<div class="home-nav">
    <a href="home.php">Home</a>
</div>
<div class="wrapper">
    <div class="header-wrapper">
        <h1>Reset your password</h1>
        <h3>Enter your new password to change!</h3>
    </div>
    <div class="sign-div">
        <div class="sign-in">
            <?php if(isset($_GET['success'])):?>
                <div class="success-message">Your password has been changed, now you can<a href="http://dev.test.com/OOP_login-registration"></a></div> //your local path

            <?php else:?>
            <div class="signIn-inner">
                <?php if(isset($errors['verify'])) :?>
                 <center><div class="success-message"><?=$errors['verify']; ?></div></center>

                <?php else:?>
                <form method="POST">
                    <div class="input-div">
                        <input type="Password" name="rPassword"    placeholder="Password">
                        <input type="password" name="rPasswordAgain" placeholder="Cofirm Password">
                        <button type="submit" name="reset">Reset</button>
                </form>
            </div>
        <?php if(isset($errors['reset'])) :?>
            <center><div class="error shake-horizontal"><?=$errors['reset'];?></div></center>
        <?php endif;?>
        <?php endif;?>
        </div>
        <?php endif;?>
    </div>
</div>
<div class="footer-wrapper">

</div>
</div>
</body>
</html>
