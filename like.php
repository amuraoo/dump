<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/like.css">
    <title>Document</title>
</head>
<body>
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

        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
        }

        $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
        $row = mysqli_fetch_array($get_likes);
        $total_likes = $row['likes'];
        $user_liked = $row['added_by'];

        $user_details = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
        $row = mysqli_fetch_array($user_details);
        $total_user_likes = $row ['num_likes'];

        //like button
        if(isset($_POST['like_button'])){
             $total_likes++;
             $query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
             $total_user_likes++;
             $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
             $insert_user = mysqli_query($con, "INSERT INTO likes VALUES('', '$userLogIn', '$post_id')");
             
        }

        //unlike button 
        if(isset($_POST['unlike_button'])){
            $total_likes--;
            $query = mysqli_query($con, "UPDATE posts SET likes='$total_likes' WHERE id='$post_id'");
            $total_user_likes--;
            $user_likes = mysqli_query($con, "UPDATE users SET num_likes='$total_user_likes' WHERE username='$user_liked'");
            $insert_user = mysqli_query($con, "DELETE FROM likes WHERE username='$userLogIn' AND post_id='$post_id'");
       }
        //check for previous likes
        $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLogIn' AND post_id='$post_id'");
        $num_rows = mysqli_num_rows($check_query);

        if($num_rows > 0){
            echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
                    <input type="submit" class="comment_like" name="unlike_button" value="Unlike">
                    <div class="like_value">
                        '. $total_likes .' Likes
                    </div>';
        }
        else {
            echo '<form action="like.php?post_id=' . $post_id . '" method="POST">
                    <input type="submit" class="comment_like" name="like_button" value="Like">
                    <div class="like_value">
                        '. $total_likes .' Likes
                    </div>';
        }
    ?>
</body>
</html>