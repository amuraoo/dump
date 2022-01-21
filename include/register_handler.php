<?php
// declaring variables to prevent errors

$f_name = ""; //first name 
$l_name = ""; //last name
$em = ""; //email
$con_em = ""; //confirm email
$pass = ""; //password
$con_pass = ""; //confirm password
$date = ""; //sign up to date 
$error_array = array(); //for error messages

if(isset($_POST['signup'])){

    //First name
    $f_name = strip_tags($_POST['first_name']); //removes unwanted tags
    $f_name = str_replace(' ', '', $f_name); //removes spaces 
    $f_name = ucfirst(strtolower($f_name)); //uppercase first letter
    $_SESSION['first_name'] = $f_name; //stores first name into session variable

    //Last name
    $l_name = strip_tags($_POST['last_name']);
    $l_name = str_replace(' ', '', $l_name);
    $l_name = ucfirst(strtolower($l_name));
    $_SESSION['last_name'] = $l_name;

    //Email
    $em = strip_tags($_POST['email']);
    $em = str_replace(' ', '', $em);
    $_SESSION['email'] = $em;

    //Confirm Email
    $con_em = strip_tags($_POST['conf_email']);
    $con_em = str_replace(' ', '', $con_em);
    $_SESSION['conf_email'] = $con_em;

    //Password
    $pass = strip_tags($_POST['psw']);
    $con_pass = strip_tags($_POST['conf_psw']);

    //Date 
    $date = date("Y-m-d");

    if($em == $con_em){
        if(filter_var($em, FILTER_VALIDATE_EMAIL)){
            $em = filter_var($em, FILTER_VALIDATE_EMAIL);

            //checks if email is already existing
            $e_check = mysqli_query($con, "SELECT email FROM users WHERE email='$em'");

            //count the number of rows returned
            $num_rows = mysqli_num_rows($e_check);

            if($num_rows > 0){
                array_push($error_array, "Email already exists<br>");
            }
        }
        else{
            array_push($error_array, "Invalid email format<br>");
        }
    }
    else {
        array_push($error_array, "Your emails do not match<br>");
    }


    if(strlen($f_name) > 25 || strlen($f_name) < 2){
        array_push($error_array, "Your first name must contain atleast 2 to 25 characters<br>");
    }

    if(strlen($l_name) > 25 || strlen($l_name) < 2){
        array_push($error_array, "Your last name must contain atleast 2 to 25 characters<br>");
    }

    if($pass != $con_pass){
        array_push($error_array, "Your passwords do not match<br>");
    }
    else{
        //checks to see if the characters in password only contains letters or numbers
        if(preg_match('[^A-Za-z0-9]', $pass )){
            array_push($error_array, "Your password must contain english characters only<br>");
        }
    }   

//insert code here later

    
    if(empty($error_array)){
        $pass = md5($pass); //encrypts password before sending to database 

        //generates username by joining first and last name
        $username = strtolower($f_name . "_" . $l_name);
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");

        //if username exists, it adds number to make it unique
        $i = 0;
        while(mysqli_num_rows($check_username_query) != 0) {
            $i++;
            $username = $username . "_" . $i;
            $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
        }

        $rand = rand(1, 2);

        if($rand == 1)
            $profile_pic = "images/prof1.jpg";
        else if($rand == 2)
            $profile_pic = "images/prof2.jpg";

        $query = mysqli_query($con, "INSERT INTO users VALUES ('', '$f_name', '$l_name', '$username', '$em', '$pass', '$date', '$profile_pic', '0', '0', 'no', ',')");

        array_push($error_array, "<span style = 'color: whitesmoke;'> You're all set!</span><br>");

        //clear variable sessions 
        $_SESSION['first_name'] = "";
        $_SESSION['last_name'] = "";
        $_SESSION['email'] = "";
        $_SESSION['conf_email'] = "";
    }

}
?>