<?php 
include ("include/header.php");
if(isset($_POST['post'])){
    $upload0k = 1;
    $imageName = $_FILES['fileToUpload']['name'];
    $errorMessage = "";

    if($imageName != ""){
        $targetDir = "images/posts/";
        $imageName = $targetDir . uniqid() . basename($imageName);
        $imageFileType = pathinfo($imageName, PATHINFO_EXTENSION);

        if($_FILES['fileToUpload']['size'] > 10000000){
            $errorMessage = "Sorry, your file is too large";
            $upload0k = 0;
        }

        if(strtolower($imageFileType) != "jpeg" && strtolower($imageFileType) != "png" && strtolower($imageFileType) != "jpg"){
            $errorMessage = "Sorry, only jpg, jpeg, and png files are allowed";

        }

        if($upload0k){
            if(move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $imageName)){
            }
            else{
                $upload0k = 0;
            }
        }
    }

    if($upload0k){
        $post = new Post ($con, $userLogIn);
        $post->submitPost($_POST['post_text'], 'none', $imageName);
        header("Location: index.php");//refreshes the page so that the form will not appear
    }
    else{
        echo "<div style'text-align:center;' class='alert alert-danger'> 
                $errorMessage
        </div>";
    }

     
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">  
    <title>Home</title>
</head>
<body>

    <p id="header">NEWS FEED</p>

    <!-- post feed -->
    <div class="post_feed">
        <div class="post_feed_form">
            <form class="post_form" action="index.php" method="POST" enctype="multipart/form-data">
                <textarea name="post_text" id="post_text" placeholder="What's on your mind?"></textarea>

                <input type="submit" name="post" id="post_button" value="Post">

                <input type="file" name="fileToUpload" id="fileToUpload" style="display: none; visibility: none;" onchange="getImage(this.value);">

                <label for="fileToUpload"><i class="fas fa-file-upload fa-2x"></i></label>
                
                <div id="display_image"></div>
            </form>
        </div>
    </div>

    <div class="feed">
    <!-- trend container -->
    <div class="trend_container">
        <p id="sub_head">TRENDING NOW</p>
            <?php 
                $query = mysqli_query($con, "SELECT * FROM trends ORDER BY hits DESC LIMIT 5");

                foreach($query as $row){
                    $word = $row['title'];
                    $word_dot = strlen($word) >= 14 ? "..." : "";

                    $trimmed_word = str_split($word, 14);
                    $trimmed_word = $trimmed_word[0];

                    echo "<div style'padding: 1px'>";
                    echo $trimmed_word . $word_dot;
                    echo "<br></div>";
                }
            ?>
    </div>

    <div class="news_feed">

        <div class="container">
            <div class="posts_area"></div>
            <img id="loading" src="images/load.gif" style="width: 40px;">
        </div>

        

        <script>
        var userLogIn = '<?php echo $userLogIn; ?>';

        $(document).ready(function() {

            $('#loading').show();

            //origunal ajax request for loading first post
            $.ajax({
                url: "include/ajaxloadposts.php",
                type: "POST",
                data: "page=1&userLogIn=" + userLogIn,
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
                        url: "include/ajaxloadposts.php",
                        type: "POST",
                        data: "page=" + page + "&userLogIn=" + userLogIn,
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

    <script type="text/javascript">
        function getImage(imagename){
            var newimg = imagename.replace(/^.*\\/, "");
            $('#display_image').html(newimg);
        }

    </script>
    </div>
    </div>
</body>
</html>