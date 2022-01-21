<?php
require 'config/config.php';
require 'include/register_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Register</title>
</head>
<body>

    <!-- logo -->
    <div class="logo">dump.</div>
    
    <div class="container">

        <div class="register-form">

            <form action="register.php" method="POST">

                <input type="text" placeholder="First Name" name="first_name" value="<?php
                    if(isset($_SESSION['first_name'])) {
                        echo $_SESSION['first_name'];
                    }
                    ?>" required>
                <br>
                <?php if(in_array("Your first name must contain atleast 2 to 25 characters<br>", $error_array)) echo "Your first name must contain atleast 2 to 25 characters<br>"; ?>

                <input type="text" placeholder="Last Name" name="last_name" value="<?php
                    if(isset($_SESSION['last_name'])) {
                        echo $_SESSION['last_name'];
                    }
                    ?>" required>
                <br>    
                <?php if(in_array("Your last name must contain atleast 2 to 25 characters<br>", $error_array)) echo "Your last name must contain atleast 2 to 25 characters<br>"; ?>

                <input type="email" placeholder="Email" name="email" value="<?php
                    if(isset($_SESSION['email'])) {
                        echo $_SESSION['email'];
                    }
                    ?>" required>
                    
                <input type="email" placeholder="Confirm Email" name="conf_email" 
                    value="<?php
                    if(isset($_SESSION['conf_email'])) {
                        echo $_SESSION['conf_email'];
                    }
                    ?>"required>
                <br>
                <?php if(in_array("Email already exists<br>", $error_array)) echo "Email already exists<br>"; 
                    else if(in_array("Invalid email format<br>", $error_array)) echo "Invalid email format<br>";
                    else if(in_array("Your emails do not match<br>", $error_array)) echo "Your emails do not match<br>"; ?>

                <input type="password" placeholder="Password" name="psw" required>
                    <input type="password" placeholder="Confirm Password" name="conf_psw" required>
                <br>
                <?php if(in_array("Your passwords do not match<br>", $error_array)) echo "Your passwords do not match<br>"; 
                    else if(in_array("Your password must contain english characters only<br>", $error_array)) echo "Your password must contain english characters only<br>";
                    else if(in_array("Your password must be between 5 to 30 characters<br>", $error_array)) echo "Your password must be between 5 to 30 characters<br>"; ?>
                    
                <input type="submit" name="signup" value="Sign Up">
                <br>
                <?php if(in_array("<span style = 'color: whitesmoke;'> You're all set!</span><br>", $error_array)) echo "<span style = 'color: whitesmoke;'> You're all set!</span><br>"; ?>
            </form>

            <div id="login">
                <p>Already have an account? <a href="login.php">Sign in here!</a></p>
            </div>
                
        </div>

    </div>
            

</body>
</html>