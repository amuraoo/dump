<?php
require 'config/config.php';
require 'include/login_handler.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Log In</title>
</head>
<body>
    
    <!-- logo -->
    <div class="logo">dump.</div>


    <!-- contains login form in one place -->
    <div class="container">
        <div class="login-form">

            <p class="sub-head">WELCOME!</p>

            <form action="login.php" method=POST>
    
            <input type="email" placeholder="EMAIL" name="log_email" required>

            <input type="password" placeholder="PASSWORD" name="log_pass" required>

            <input type="submit" name="log_button" value="Sign In">
            <br>
            <?php if(in_array("Invalid email or password", $error_array)) echo "Invalid email or password";?>

            </form>

            <!-- <div id="psw"><a href="#">Forgot password?</a></div> -->

            <div id="register">
                <p>Don't have an account? <a href="register.php">Sign up here!</a></p>
            </div>
                
        </div>
    </div>
            

            

    
</body>
</html>