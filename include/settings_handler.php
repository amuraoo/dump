<?php
    if(isset($_POST['update_details'])){
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $email = $_POST['email'];

        $email_check = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
        $row = mysqli_fetch_array($email_check);
        $matched_user = $row['username'];

        if($matched_user == "" || $matched_user == $userLogIn){
            $message = "Details Updated!<br><br>";

            $query = mysqli_query($con, "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email' WHERE username='$userLogIn'");
        }
        else{
            $message = "That email is already in use <br><br>";
        }
    }
    else
        $message = "";

//For password 

if(isset($_POST['update_password'])){
    
    $old_password = strip_tags($_POST['old_password']);
    $new_password = strip_tags($_POST['new_password']);
    $confirm_password = strip_tags($_POST['confirm_password']);

    $password_query = mysqli_query($con, "SELECT password FROM users WHERE username='$userLogIn'");
    $row = mysqli_fetch_array($password_query);
    $db_password = $row['password'];

    if(md5($old_password) == $db_password){
        if($new_password == $confirm_password){

            if(strlen($new_password) <= 4){
                $password_message = "Your password must contain atleast more than 4 characters<br>";
            }
            else{
                $new_password_md5 = md5($new_password);
                $password_query = mysqli_query($con, "UPDATE users SET password='$new_password_md5' WHERE username='$userLogIn'");
                $password_message = "Your password has been changed <br>";
            }

        }else{
            $password_message = "Passwords do not match<br>";
        }
    }
    else{
        $password_message = "Old password is incorrect<br>";
    }
}
else{
    $password_message = "";
}

if(isset($_POST['close_account'])){
    header("Location: close_account.php");
}
?>