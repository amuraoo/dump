<?php

ob_start();
session_start();

$timezone = date_default_timezone_set("Asia/Dubai");

$con = mysqli_connect("localhost", "root", "", "sm_clone");
if(mysqli_connect_errno()) 
{
    echo "Failed to connect: " . mysqli_connect_errno();
}
?>

