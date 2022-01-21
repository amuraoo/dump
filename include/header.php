<?php
require 'config/config.php';
include ("include/user.php");
include ("include/post.php");


// if username is not logged in, it returns back to register page
if(isset($_SESSION['username'])){
    $userLogIn = $_SESSION['username'];
    $user_details = mysqli_query($con, "SELECT * FROM users WHERE username='$userLogIn'");
    $user = mysqli_fetch_array($user_details);
}
else {
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="include/asset/js/bootstrap.js"></script>
    <script src="include/asset/js/bootbox.min.js"></script>
    <script src="include/asset/js/demo.js"></script>
    <script src="include/asset/js/jquery.Jcrop.js"></script>
    <script src="include/asset/js/jcrop_bits.js"></script>


    <link rel="stylesheet" href="include/asset/css/bootstrap.css">
    <link rel="stylesheet" href="include/asset/css/jquery.Jcrop.css">
    <link rel="stylesheet" href="css/header.css">
    <title>Dump</title>
</head>
<body>
 <!--<header>
   <div class="navbar">

         for logo 
        <a href="index.php" id="logo">dump.</a>

        <div class="nav">

                <div class="menu">
                     icon for friend 
                    <a href="request.php"><i class="fas fa-user-friends fa-2x"></i></a>

                     icon for settings 
                    <a href="settings.php"><i class="fas fa-cogs fa-2x"></i></a>

                     displays first name 
                    <a href="<?php echo $userLogIn?>"><div id="first_name"><?php echo $user['first_name']; ?></div></a>
                    
                    displays profile pic 
                    <div class="profile"><a href="<?php echo $userLogIn?>"> <img src="<?php echo $user['profile_pic']; ?>"></a></div>
                </div>

                <input type="checkbox" id="check">
                <label for="check" class="checkbtn">
                    <i class="fas fa-bars fa-2x"></i>
                </label>
                

        </div>
    </div>
</header>-->


<nav>
    <input type="checkbox" id="check">
    <label for="check" class="checkbtn">
        <i class="fas fa-bars fa-2x"></i>
    </label>

    <label for="logo"><a href="index.php" id="logo">dump.</a></label>

    <ul>

    <div class="group1">
        <li><a href="request.php"><i class="fas fa-user-friends fa-2x"></i></a></li>

        <li><a href="settings.php"><i class="fas fa-cogs fa-2x"></i></a></li>

        <div id="hidden_prof"><a href="<?php echo $userLogIn?>"><i class="fas fa-user fa-2x"></i></a></div>
    </div>


            
    <li><a href="<?php echo $userLogIn?>"><div id="first_name"><?php echo $user['first_name']; ?></div></a></li>

    <li><div class="profile"><a href="<?php echo $userLogIn?>"> <img src="<?php echo $user['profile_pic']; ?>"></a></div>
    </div></li>

    </ul>
    
</nav>
