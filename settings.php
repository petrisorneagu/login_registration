<?php
include 'core/init.php';

//$user_id = $_SESSION['user_id'];
//$user = $userObj->userData($user_id);

if(isset($_POST['update'])){
    $required = array('firstName','lastName','username','email','password');

    foreach($_POST as $key => $value){
        if(empty($value) && in_array($key, $required)){
            $errors['allFields'] = 'All fields are required';
            break;
        }
    }
    if(empty($errors['allFields'])){


    }
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Update your account</title>
    <link rel="stylesheet" href="<?= BASE_URL;?>css/style.css"/>
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:400,700" rel="stylesheet">

</head>
<body class="body2">
<div class="home-nav">
    <a href="<?= BASE_URL;?>home.php">Home</a>
</div>
<div class="p2-wrapper">
    <div class="sign-up-wrapper">
        <div class="sign-up-inner">
            <div class="sign-up-div">
                <form method="POST">
                    <div class="name">
                        <h3>Change Name</h3>
                        <input type="text" name="firstName" placeholder="First Name"/>
                        <input type="text" name="lastName" placeholder="Last Name"/>
                    </div>
                    <!-- Name Error -->
                    <span class="error-in">Name fields error</span>

                    <div>
                        <h3>Change User Name</h3>
                        <input type="text" name="username" placeholder="UserName" />
                    </div>
                    <!-- Username Error -->
                    <span class="error-in">Username field error</span>

                    <div>
                        <h3>Change Email</h3>
                        <input type="email" name="email" placeholder="Email" />
                        <!-- Email Error -->
                        <span class="error-in">Email field error</span>
                    </div>


                    <div>
                        <h3>Enter your password to update your account</h3>
                        <input type="password" name="password" placeholder="Password"/>

                        <!-- Password Errors -->
                        <span class="error-in">Password field error</span>
                    </div>

                    <!-- Required Fields Errors -->
                    <?php if(isset($errors['allFields'])) :  ?>
                    <span class="error-in"><?=$errors['allFields'];?></span>
                    <?php endif;?>
                    <div class="btn-div">
                        <button value="sign-up" name="update">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</body>
</html>