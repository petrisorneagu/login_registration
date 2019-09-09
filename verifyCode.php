<?php
include 'core/init.php';
$user_id = $_SESSION['user_id'];
$verifyObj->authOnly();

if(isset($_POST['verify'])) {
    $code = Validate::escape($_POST['verifyCode']);

    $verify = $verifyObj->verifyCode($code);

    if (!empty($code)) {
        if ($verify) {
//        if verif code is expired
            if ($verify->createdAt < date('Y-m-d')) {
                $errors['verify'] = "Your verification code is expired";
            } else {
//                update user account
                $userObj->update('verification', array('status' => '1'), array('user_id' => $user_id, 'code' => $code));
                $userObj->redirect('home.php');
            }
        } else {
            $errors['verify'] = 'Invalid verification code';
        }
    }else{
        $errors['verify'] = 'Enter your verification code';
    }
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Phone Verification</title>
    <link rel="stylesheet" href="css/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>

<body class="body">
<div class="wrapper">
    <div class="header-wrapper">
        <h1>Verify your code</h1>
        <h3>A verification code has been sent to your mobile number, Verify your code below.</h3>
    </div>
    <div class="sign-div">
        <div class="sign-in">
            <div class="signIn-inner">
                <div class="input-div">
                    <form method="POST">
                        <input type="tel" name="verifyCode" placeholder="Enter Code">
                        <button type="submit" name="verify">Verify</button>
                    </form>
                </div>
            </div>
            <?php if(isset($errors['verify'])) :?>
                <div class="sign-in-error">
                    <?= $errors['verify'];?>
                </div>

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
