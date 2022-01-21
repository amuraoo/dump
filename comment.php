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
    <link rel="stylesheet" href="css/comment.css">
    <title>Comment</title>
</head>
<body>
    <script>
        function toggle(){
            var element = document.getElementById("comment_section");

            if(element.style.display == "block")
                element.style.display = "none";
            else
                element.style.display = "block";
        }
    </script>

    <?php
        if(isset($_GET['post_id'])){
            $post_id = $_GET['post_id'];
        }

        $user_query = mysqli_query($con, "SELECT added_by, user_to FROM posts WHERE id='$post_id'");
        $row = mysqli_fetch_array($user_query);
        $posted_to = $row['added_by'];

        if(isset($_POST['postComment' . $post_id])) {
            $post_body = $_POST['post_body'];
            $post_body = mysqli_escape_string($con, $post_body);
            $date_time_now = date("Y-m-d H:i:s");
            $insert_post = mysqli_query($con, "INSERT INTO comments VALUES ('', '$post_body', '$userLogIn', '$posted_to', '$date_time_now', 'no', '$post_id' )");

            echo "<p id='comment_posted'>Comment Posted</p>";
        }
    ?>

    <form action="comment.php?post_id=<?php echo $post_id; ?>" id="comment_form" name="postComment<?php echo $post_id; ?>" method="POST">

    <textarea name="post_body"></textarea>
    <input type="submit" name="postComment<?php echo $post_id; ?>" value="Post">
        
    </form>

    <!-- loading comment -->

    <?php
        $get_comments = mysqli_query($con, "SELECT * FROM comments WHERE post_id='$post_id' ORDER BY id ASC"); 
        $count = mysqli_num_rows($get_comments);

        if($count != 0){

            while($comment = mysqli_fetch_array($get_comments)){

                $comment_body = $comment['post_body'];
                $posted_to = $comment['posted_to'];
                $posted_by = $comment['posted_by'];
                $date_added = $comment['date_added'];
                $removed = $comment['removed'];

                //timeframe
                $date_time_now = date ("Y-m-d H:i:s");
                $start_date = new DateTime($date_added); //time of post 
                $end_date = new DateTime($date_time_now); //current time 
                $interval = $start_date->diff($end_date); //difference between dates

                if($interval->y >1){
                    if($interval == 1)
                        $time_message = $interval->y . " year ago";
                    else
                        $time_message = $interval->y . " years ago";
                }
                else if($interval-> m >1){
                    if($interval->d == 0){
                        $days = " ago";
                    }
                    else if($interval->d ==1){
                        $days = $interval->d . " day ago";
                    }
                    else {
                        $days = $interval->d . " days ago";
                    }


                    if($interval->m == 1){
                        $time_message = $interval->m . " month" . $days;
                    }
                    else{
                        $time_message = $interval->m. " months" . $days;
                    }
                }

                else if($interval->d >= 1){
                    if($interval->d ==1){
                        $time_message = "Yesterday";
                    }
                    else {
                        $time_message = $interval->d . " days ago";
                    }
                }

                else if($interval->h >=1){
                    if($interval->h ==1){
                        $time_message = $interval->h . " hour ago";
                    }
                    else {
                        $time_message = $interval->h . " hours ago";
                    }

                }

                else if($interval->i >=1){
                    if($interval->i ==1){
                        $time_message = $interval->i . " minute ago";
                    }
                    else {
                        $time_message = $interval->i . " minutes ago";
                    }
                }

                else{
                    if($interval->s < 30){
                        $time_message = "Just now";
                    }
                    else{
                        $time_message = $interval->s . " seconds ago";
                    }
                }

                $user_obj = new User($con, $posted_by); 

                ?>
                <div class="comment_section">
                    <a href="<?php echo $posted_by?>" target="_parent"><img src="<?php echo $user_obj->getProfilePic();?>" title="<?php echo $posted_by;?>" style="float:left" height="30"></a>

                    <a href="<?php echo $posted_by?>" target="_parent"><b><?php echo $user_obj->getFirstandLastname();?></b></a>

                    &nbsp; 
                    <?php echo $time_message . "<br>" . $comment_body; ?>
                </div>
                <?php
            }
        }
        else{
            echo "<p id='comment_posted'>No comments yet</p>";
        }
    ?>
    

</body>
</html>