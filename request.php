<?php
include("include/header.php");

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/request.css">
    <title>Request</title>
</head>
<body>
    <div class="friend_req">
        <div class="friend_contain">
        <p id="header">Friend Requests</p>

        <div class="accept_reject">
        <?php
            $query = mysqli_query($con, "SELECT * FROM friend_requests WHERE user_to='$userLogIn'");
            if(mysqli_num_rows($query) == 0)
                echo "You have no friend requests";
            else{
                while($row = mysqli_fetch_array($query)){
                    $user_from = $row['user_from'];
                    $user_from_obj = new User($con, $user_from);

                    echo $user_from_obj->getFirstandLastname() . " sent you a friend request";

                    $user_from_friend_array = $user_from_obj->getFriendArray();

                    if(isset($_POST['accept_request' . $user_from])){
                        $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$user_from,') WHERE username='$userLogIn'");
                        $add_friend_query = mysqli_query($con, "UPDATE users SET friend_array=CONCAT(friend_array, '$userLogIn,') WHERE username='$user_from'");

                        $delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLogIn' AND user_from='$user_from'");
                        echo "You are now friends!";
                        header("Location: request.php");

                    }
                    if(isset($_POST['ignore_request' . $user_from])){
                        $delete_query = mysqli_query($con, "DELETE FROM friend_requests WHERE user_to='$userLogIn' AND user_from='$user_from'");
                        echo "Request Ignored!";
                        header("Location: request.php");
                    }

                    ?>
                    
                    <div class="req_button">
                        <form action="request.php" method="POST">
                            <input type="submit" name="accept_request<?php echo $user_from; ?>" id="accept_button" value="Accept">
                            <input type="submit" name="ignore_request<?php echo $user_from; ?>" id="ignore_button" value="Ignore">
                        </form>
                    </div>
                    <?php
                }
            }
        
        ?>
        </div>

        </div>

    </div>
</body>
</html>