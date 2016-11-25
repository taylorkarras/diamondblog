<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
$global = new DB_global;
	if ($retrive->restrictpermissionlevel('3')){
 header("HTTP/1.0 403 Forbidden");
 die();
	}
$postid = $_GET['postid'];
if (strpos($_SERVER['REQUEST_URI'], 'console/posts/comments/close')){
$global->sqlquery("UPDATE `dd_content` SET `content_commentsclosed` = '1' WHERE `content_id` = '".$postid."';");
header("Location: /console/posts/comments?postid=".$postid);
}

if (strpos($_SERVER['REQUEST_URI'], 'console/posts/comments/open')){

$global->sqlquery("UPDATE `dd_content` SET `content_commentsclosed` = '0' WHERE `content_id` = '".$postid."';");
header("Location: /console/posts/comments?postid=".$postid);

}
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}
