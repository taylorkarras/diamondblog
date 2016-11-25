<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
$global = new DB_global;
	if (!$retrive->restrictpermissionlevel('2')){

$firstpincheck = $global->sqlquery("SELECT * FROM `dd_content` WHERE `content_pinned` = '1' AND `content_id` = '".$_GET['postid']."';");
$firstpincheck2 = $firstpincheck->fetch_assoc();
$secondpincheck = $global->sqlquery("SELECT * FROM `dd_content` WHERE `content_pinned` = '2' AND `content_id` = '".$_GET['postid']."';");
$secondpincheck2 = $secondpincheck->fetch_assoc();
$thirdpincheck = $global->sqlquery("SELECT content_pinned FROM `dd_content`;");
$thirdpinchek2 = array();
while($row = $thirdpincheck->fetch_assoc()){
$thirdpincheck2[] = $row['content_pinned'];
}
if (strpos($_SERVER['REQUEST_URI'], 'console/posts/pin')){
if (array_search('2', $thirdpincheck2)){
$global->sqlquery("UPDATE `dd_content` SET `content_pinned` = '0' WHERE `content_pinned` = '2';");
$global->sqlquery("UPDATE `dd_content` SET `content_pinned` = '2' WHERE `content_id` = '".$_GET['postid']."';");
header("Location: /console/posts/");
} else if (array_search('1', $thirdpincheck2)){
$global->sqlquery("UPDATE `dd_content` SET `content_pinned` = '2' WHERE `content_id` = '".$_GET['postid']."';");
header("Location: /console/posts/");
} else if (!array_search('1', $thirdpincheck2) && !array_search('2', $thirdpincheck2)){
$global->sqlquery("UPDATE `dd_content` SET `content_pinned` = '1' WHERE `content_id` = '".$_GET['postid']."';");
header("Location: /console/posts/");
}
}
if (strpos($_SERVER['REQUEST_URI'], 'console/posts/unpin')){
if($secondpincheck2['content_pinned'] == '2'){
$global->sqlquery("UPDATE `dd_content` SET `content_pinned` = '0' WHERE `content_id` = '".$_GET['postid']."';");
header("Location: /console/posts/");
} else if (array_search('2', $thirdpincheck2) && $firstpincheck2['content_pinned'] == '1'){
$global->sqlquery("UPDATE `dd_content` SET `content_pinned` = '0' WHERE `content_id` = '".$_GET['postid']."';");
$global->sqlquery("UPDATE `dd_content` SET `content_pinned` = '1' WHERE `content_pinned` = '2';");
header("Location: /console/posts/");
} else if ($firstpincheck2['content_pinned'] == '1' && !array_search('2', $thirdpincheck2)){
$global->sqlquery("UPDATE `dd_content` SET `content_pinned` = '0' WHERE `content_pinned` = '1';");
header("Location: /console/posts/");
}
}
}  else {
	 header("HTTP/1.0 403 Forbidden");
 die();
}
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}
