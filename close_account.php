<?php

include("include/header.php");

if(isset($_POST['cancel'])){
    header("Location: settings.php");
}

if(isset($_POST['close_account'])){
    $close_query = mysqli_query($con, "UPDATE users SET user_closed='yes' WHERE username='$userLogIn'");
    session_destroy();
    header("Location: login.php");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/request.css">
    <title>Document</title>
</head>
<body>
    <div class="friend_req">
        <div class="friend_contain">
        <p id="header">Deactivate Account</p>

        <p>Are you sure you want to deactivate your account?<br> Deactivating your account will hide your profile and all your activity from other users<br>You can re-open your account any time by simply logging in.</p>

        <form action="close_account.php" method="POST">
            <input type="submit" name="close_account" id="accept_button" value="Yes, deactivate account">
            <input type="submit" name="cancel" id="ignore_button" value="No, go back to settings">
        </form>

        </div>
    </div>
</body>
</html>