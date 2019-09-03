<?php
//echo 'verification';
include 'core/init.php';

if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user = $userObj->userData($user_id);
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
                    <h4>Your account has been created, you need to activate your account by following methods:</h4>
                    <fieldset>
                        <legend>Method 1</legend>
                        <form method="POST">
                            <h3>Email verification</h3>
                            <input type="email" name="email" disabled placeholder="" value=""/>
                            <button type="submit" class="suc">Send me verification email</button>
                        </form>
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
        </div>
    </div>
</div>
</body>
</html>

