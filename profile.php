<?php 
include ("include/header.php");


if(isset($_GET['profile_username'])){
    $username = $_GET['profile_username'];
    $user_details = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
    $user_array = mysqli_fetch_array($user_details);

    $num_friends = substr_count($user_array['friend_array'], ",") - 1;
}

if(isset($_POST['remove_friend'])){
    $user = new User($con, $userLogIn);
    $user->removeFriend($username);
}

if(isset($_POST['add_friend'])){
    $user = new User($con, $userLogIn);
    $user->sendRequest($username);
}

if(isset($_POST['respond_request'])){
    header("Location: request.php");
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/profile.css">
    <title>Profile</title>
</head>
<body>

<div class="container">
    <div class="profile_container">

        <div id="profile_pic_contain">
            <img src="<?php echo $user_array['profile_pic'];?>">
        </div>
        

        <div class="profile_info">
            <p id="username">@<?php echo $username?></p>
            <p><?php echo "Posts: " . $user_array['num_post']; ?></p>
            <p><?php echo "Likes: " . $user_array['num_likes']; ?></p>
            <p><?php echo "Friends: " . $num_friends; ?></p>
        </div>

        <div class="profile_option">

        <form action="<?php echo $username; ?>" method="POST">
            <?php 
            $profile_user_obj = new User($con, $username);
            if($profile_user_obj->isClosed()){
                header("Location: user_closed.php");
            }
            $loggedin_user = new User($con, $userLogIn);
            if($userLogIn != $username){
                if($loggedin_user->isFriend($username)){
                    echo '<input type="submit" name="remove_friend" class="danger" value="Remove Friend"><br>';
                }
                else if($loggedin_user->didReceiveRequest($username)){
                    echo '<input type="submit" name="respond_request" class="warning" value="Respond to Request"<br>';
                }
                else if($loggedin_user->didSendRequest($username)){
                    echo '<input type="submit" name="" class="default" value="Request Sent"<br>';
                }
                else{
                    echo '<input type="submit" name="add_friend" class="success" value="Add Friend"<br>';
                }
            }
            ?>
        </form>
        </div>
        
        <div class="post_button">
            <input type="submit" class="deep_blue" data-bs-toggle="modal" data-bs-target="#post_form" value="Post Something">
        </div>
        

    </div>

        
        <div class="posts_area"></div>
        <img id="loading" src="images/load.gif" style="width: 40px;">
</div>   


<!-- Modal -->
<div class="modal fade" id="post_form" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Post something</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>This will appear on the user's timeline and profile page.</p>

        <form class="profile_post" action="" method="POST">
            <div class="form-group">
                <textarea class="form-control" name="post_body"></textarea>
                <input type="hidden" name="user_from" value="<?php echo $userLogIn; ?>"> 
                <input type="hidden" name="user_to" value="<?php echo $username; ?>">
            </div>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" name="post_button" id="submit_profile_post">Post</button>
      </div>
    </div>
  </div>
</div>





<script>
        var userLogIn = '<?php echo $userLogIn; ?>';
        var profileUsername = '<?php echo $username; ?>';

        $(document).ready(function() {

            $('#loading').show();

            //origunal ajax request for loading first post
            $.ajax({
                url: "include/ajaxloadprof.php",
                type: "POST",
                data: "page=1&userLogIn=" + userLogIn + "&profileUsername=" + profileUsername,
                cache: false,

                success: function(data){
                    $('#loading').hide();
                    $('.posts_area').html(data);
                }
            });

            $(window).scroll(function(){
                var height = $('.posts_area').height();
                var scroll_top = $(this).scrollTop();
                var page = $('.posts_area').find('.nextPage').val();
                var noMorePosts = $('.posts_area').find('.noMorePosts').val();

                if((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false'){
                    $('#loading').show();
                    
                    var ajaxReq = $.ajax({
                        url: "include/ajaxloadprof.php",
                        type: "POST",
                        data: "page=" + page + "&userLogIn=" + userLogIn + "&profileUsername=" + profileUsername,
                        cache: false,

                    success: function(response){
                        $('.posts_area').find('.nextPage').remove();
                        $('.posts_area').find('.noMorePosts').remove();

                        $('#loading').hide();
                        $('.posts_area').append(response);
                    }
                    });
                }
                return false;
            });
            
        });
    </script>
</body>
</html>