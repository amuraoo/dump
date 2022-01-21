<?php
include("../config/config.php");
include("../include/user.php");
include("../include/post.php");

$limit = 100; //limit of posts shown in newsfeed
 
$posts = new Post($con, $_REQUEST['userLogIn']);
$posts ->loadProfilePosts($_REQUEST, $limit);

?>