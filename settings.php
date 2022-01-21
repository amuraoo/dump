<?php
include("include/header.php");
include("include/settings_handler.php");

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/settings.css">
    <title>Settings</title>
</head>
<body>

<div class="settings_container">
    <div class="profile_settings">
        <p id="header">Account Settings</p>

        <?php echo "<img src='" . $user['profile_pic'] . "' id='profile_pic_contain'>"; ?> 
        <br>

        <!-- <a href="upload.php">Upload new profile picture</a> -->

        <?php
            $user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE username='$userLogIn'");
            $row = mysqli_fetch_array($user_data_query);

            $first_name = $row['first_name'];
            $last_name = $row['last_name'];
            $email = $row['email'];
        ?>

        <p id="sub_header">Update Details</p>
        <form action="settings.php" method="POST">
            First Name: <input type="text" name="first_name" value="<?php echo $first_name; ?>"><br>
            Last Name: <input type="text" name="last_name" value="<?php echo $last_name; ?>"><br>
            Email: <input type="text" name="email" value="<?php echo $email; ?>"><br>
            <?php echo $message;?>
            <input type="submit" name="update_details" id="save_details" value="Update Details"><br><br>
        </form>

        <p id="sub_header">Change Password</p>
        <form action="settings.php" method="POST">
            Old Password: <input type="password" name="old_password"><br>
            New Password: <input type="password" name="new_password"><br>
            Confirm New Password: <input type="password" name="confirm_password"><br>
            <?php echo $password_message?>
            <input type="submit" name="update_password" id="save_password" value="Update Password"><br><br>
        </form>
  
        <form action="settings.php" method="POST">
            <input type="submit" name="close_account" id="close_account" value="Deactivate Account"><br>
        </form>
        <a href="include/logout.php"><button>Logout</button></a> 

    </div>
</div>
    
</body>
</html>