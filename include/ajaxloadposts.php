<?php
include("../config/config.php");
include("../include/user.php");
include("../include/post.php");

$limit = 100;
$posts = new Post($con, $_REQUEST['userLogIn']);
$posts->loadPostsFriends($_REQUEST, $limit);
?>