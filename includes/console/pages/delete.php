<?php
	$global = new DB_global;
	$retrive = new DB_retrival;
	if ($retrive->isLoggedIn() == true){
	if (strpos($_SERVER['REQUEST_URI'], "pages/delete")){
	if ($retrive->restrictpermissionlevel('2')){
	echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to perform this action!</div></div>';
	} else {
	$query = $global->sqlquery("SELECT * FROM dd_pages WHERE page_number = '".$_GET['pageid']."' LIMIT 1");
		$page_title = $query->fetch_assoc();
	if (empty($_GET['pageid']) or is_null($page_title['page_number'])){
echo consolemenu();
echo '<div id="page"><div class="center">The page you want to delete does not exist or has already been deleted.
<br /><br /><a href="javascript:history.back()" alt="Go back" title="Go back">Go back</a>
</div></div>';
	} else {
echo consolemenu();
echo '<div id="page"><div class="center">Are you sure you want to delete <i>"'.$page_title['page_title'].'"</i>?
<br /><br /><a href="/console/pages/deleteconfirm?pageid='.$_GET['pageid'].'" alt="Delete this page" title="Delete this page">Yes, I am sure.</a> | <a href="javascript:history.back()" alt="Do not delete this page" title="Do not delete this page">No, do not delete.</a></div></div>';
	}
}
	}
	
	if (strpos($_SERVER['REQUEST_URI'], "posts/delete")){
	if ($retrive->restrictpermissionlevel('2')){
	echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to perform this action!</div></div>';
	} else {
	$query = $global->sqlquery("SELECT * FROM dd_content WHERE content_id = '".$_GET['postid']."' LIMIT 1");
	$post_title = $query->fetch_assoc();

	if (empty($_GET['postid']) or is_null($post_title['content_id'])){
echo consolemenu();
echo '<div id="page"><div class="center">The article you want to delete does not exist or has already been deleted.
<br /><br /><a href="javascript:history.back()" alt="Go back" title="Go back">Go back</a>
</div></div>';
	} else if ($retrive->restrictpermissionlevel('1') && $_COOKIE['userID'] == $post_title['content_author']){ 
echo consolemenu();
echo '<div id="page"><div class="center">Are you sure you want to delete <i>"'.$post_title['content_title'].'"</i>?
<br /><br /><a href="/console/posts/deleteconfirm?postid='.$_GET['postid'].'" alt="Delete this page" title="Delete this page">Yes, I am sure.</a> | <a href="javascript:history.back()" alt="Do not delete this page" title="Do not delete this page">No, do not delete.</a></div></div>';
	} else {
	echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to perform this action!</div></div>';
	}
}
	}
	
	
		if (strpos($_SERVER['REQUEST_URI'], "posts/drafts/delete")){
	if ($retrive->restrictpermissionlevel('2')){
	echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to perform this action!</div></div>';
	} else {
	$query = $global->sqlquery("SELECT * FROM dd_drafts WHERE draft_id = '".$_GET['postid']."' LIMIT 1");
	$post_title = $query->fetch_assoc();

	if (empty($_GET['postid']) or is_null($post_title['draft_id'])){
echo consolemenu();
echo '<div id="page"><div class="center">The article you want to delete does not exist or has already been deleted.
<br /><br /><a href="javascript:history.back()" alt="Go back" title="Go back">Go back</a>
</div></div>';
	} else {
echo consolemenu();
echo '<div id="page"><div class="center">Are you sure you want to delete <i>"'.$post_title['draft_title'].'"</i>?
<br /><br /><a href="/console/posts/drafts/deleteconfirm?draftid='.$_GET['postid'].'" alt="Delete this draft" title="Delete this draft">Yes, I am sure.</a> | <a href="javascript:history.back()" alt="Do not delete this draft" title="Do not delete this draft">No, do not delete.</a></div></div>';
	}
}
	}
	

	if (strpos($_SERVER['REQUEST_URI'], "posts/comments/delete")){
	
	$query = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_id = '".$_GET['commentid']."' LIMIT 1");
	$comment = $query->fetch_assoc();

	if (is_null($comment['comment_id'])){
echo consolemenu();
echo '<div id="page"><div class="center">The comment you want to delete does not exist or has already been deleted.
<br /><br /><a href="javascript:history.back()" alt="Go back" title="Go back">Go back</a>
</div></div>';
	} else {
echo consolemenu();
echo '<div id="page"><div class="center">Are you sure you want to delete this comment from '.$comment['comment_username'].' ('.$comment['comment_ip'].')?
<br /><br /><a href="/console/posts/deleteconfirm?commentid='.$_GET['commentid'].'" alt="Delete this comment" title="Delete this comment">Yes, I am sure.</a> | <a href="javascript:history.back()" alt="Do not delete this comment" title="Do not delete this comment">No, do not delete.</a></div></div>';
	}
}

	if (strpos($_SERVER['REQUEST_URI'], "console/users/delete")){
	if ($retrive->restrictpermissionlevel('2')){
	echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to perform this action!</div></div>';
	} else {
	$query = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$_GET['userid']."' LIMIT 1");
	$userinfo = $query->fetch_assoc();

	if (empty($_GET['userid']) or is_null($userinfo['user_id'])){
echo consolemenu();
echo '<div id="page"><div class="center">The user you want to delete does not exist or has already been deleted.
<br /><br /><a href="javascript:history.back()" alt="Go back" title="Go back">Go back</a>
</div></div>';
	} else {
echo consolemenu();
echo '<div id="page"><div class="center">Are you sure you want to delete user '.$userinfo['user_username'].' ('.$userinfo['user_realname'].')?
<br /><br /><a href="/console/users/deleteconfirm?userid='.$_GET['userid'].'" alt="Delete this user" title="Delete this user">Yes, I am sure.</a> | <a href="javascript:history.back()" alt="Do not delete this user" title="Do not delete this user">No, do not delete.</a></div></div>';
	}
}
	}
} else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>
