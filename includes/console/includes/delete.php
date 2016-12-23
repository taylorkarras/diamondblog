<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
		if ($retrive->restrictpermissionlevel('2')){
 header("HTTP/1.0 403 Forbidden");
 die();
	}
$global = new DB_global;

	if (!empty($_GET['pageid'])){
		$pageid1 = $global->sqlquery("SELECT page_number FROM dd_pages WHERE page_number = '".$_GET['pageid']."' LIMIT 1");
		$pageid2 = $pageid1->fetch_assoc();
		if (is_null($pageid2['page_number'])) {
			header("Location: ".$_SERVER['HTTP_REFERER']);
	} else {
		$global->sqlquery("DELETE FROM `dd_pages` WHERE `page_number` = '".$_GET['pageid']."'");
		header("Location: /console/settings/categoriesandpages/2");
	}
	}

	if (!empty($_GET['postid'])){
		$postid1 = $global->sqlquery("SELECT content_id FROM dd_content WHERE content_id = '".$_GET['postid']."' LIMIT 1");
		$postid2 = $postid1->fetch_assoc();
		if (is_null($postid2['content_id'])) {
			header("Location: ".$_SERVER['HTTP_REFERER']);
	} else {
		$global->sqlquery("DELETE FROM `dd_content` WHERE `content_id` = '".$_GET['postid']."'");
		$global->sqlquery("DELETE FROM `dd_comments` WHERE `comment_postid` = '".$_GET['postid']."'");
		header("Location: /console/posts");
	}
	}
	
	if (!empty($_GET['draftid'])){
		$postid1 = $global->sqlquery("SELECT draft_id FROM dd_drafts WHERE draft_id = '".$_GET['draftid']."' LIMIT 1");
		$postid2 = $postid1->fetch_assoc();
		if (is_null($postid2['draft_id'])) {
			header("Location: ".$_SERVER['HTTP_REFERER']);
	} else {
		$global->sqlquery("DELETE FROM `dd_drafts` WHERE `draft_id` = '".$_GET['draftid']."'");
		header("Location: /console/posts/drafts");
	}
	}
	
	if (!empty($_GET['commentid'])){
		$global->sqlquery("DELETE FROM `dd_comments` WHERE `comment_id` = '".$_GET['commentid']."'");
		header("Location: ".$_SESSION['referral_url']['comments']);
	}
	
	if (!empty($_GET['userid'])){
		$userid1 = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$_GET['userid']."' LIMIT 1");
		$userid2 = $userid1->fetch_assoc();
		if (is_null($userid2['user_id'])) {
			header("Location: ".$_SERVER['HTTP_REFERER']);
	} else {
		$global->sqlquery("UPDATE `dd_comments` SET `comment_username` = 'Deleted User #".$userid2['user_id']."', `comment_email` = 'deleteduser@diamondblog.com' WHERE `dd_comments`.`comment_email` = '".$userid2['user_email']."'");
		$global->sqlquery("DELETE FROM `dd_users` WHERE `user_id` = '".$_GET['userid']."'");
		header("Location: /console/users/");
	}
	}
} else {
	 header("HTTP/1.0 403 Forbidden");
 die();
}
