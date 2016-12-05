<?php 
if (isset($_POST)){

	$global = new DB_global;
	$check = new DB_check;
	if ($check->ifbanned()){
	}else{
		
				if(trim($_POST['commentname']) === '')  {
		$_SESSION['errors']['commentname'] = "You must enter a name.";
		$hasError = true;	
	} else {
		$commentname = $global->real_escape_string($_POST['commentname']);
	}
	
		if(empty($_POST['commentemail']))  {	
		$_SESSION['errors']['commentemail'] = "You must enter an email.";
		$hasError = true;	
	} else {
		$commentemail = $_POST['commentemail'];
	}
	
		if(empty($_POST['commentcontent']))  {	
		$_SESSION['errors']['commentcontent'] = "You must enter content.";
		$hasError = true;	
	} else {
		$commentcontent = $_POST['commentcontent'];
	}
if (!$check->isLoggedIn()){
pluginClass::hook( "captcha" );
}

		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
	
	$parsed_link = parse_url ($_SERVER['HTTP_REFERER']);
	$link = str_replace("/", "", $parsed_link['path']);
	$linkinit = $global->sqlquery("SELECT content_id FROM dd_content WHERE content_permalink = '".$link."';");
	$post_id = $linkinit->fetch_assoc();
if (isset($_POST['postid'])){
	$comment_post_id = $_POST['postid'];
} else if (is_null($post_id['content_id'])){
	$parsed_link = parse_url ($_SERVER['HTTP_REFERER']);
	$comment_post_id = str_replace("postid=", "", $parsed_link['query']);
} else {
	$comment_post_id = $post_id['content_id'];
}
	
	if (isset($_POST['userid'])){
		$userid = $_POST['userid'];
	}
	else if ($check->isLoggedIn()){
                $userid = $_COOKIE['userID'];
        }

	$userstatus = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$userid."';");
	$userstatus2 = $userstatus->fetch_assoc();
	
	if ($userstatus2['user_isadmin'] == '1'){
	$commentstatus = "'1', '0',";
	} else if ($userstatus2['user_iscontributor'] == '1'){
	$commentstatus = "'0', '1',";
	} else {
	$commentstatus = "'0', '0',";
	}
	
	$commentip = $_SERVER['REMOTE_ADDR'];

	if ($_POST['commentreply'] !== '0' & $_POST['commentreplyto'] !== '0'){
	
	$comment_id = $global->sqllastid("INSERT INTO `dd_comments` (`comment_id`, `comment_`, `comment_isreply`, `comment_replyto`, `comment_username`, `comment_email`, `comment_date`, `comment_content`, `comment_ip`, `comment_reported`, `comment_isfromadmin`, `comment_isfromcontributor`, `comment_userid`) VALUES (NULL, '".$comment_post_id."', '".$_POST['commentreply']."', '".$_POST['commentreplyto']."', '".$commentname."', '".$commentemail."', CURRENT_TIMESTAMP, '".$commentcontent."', '".$commentip."', '', ".$commentstatus." '".$userid."')");
	
	} else {
		
$comment_id = $global->sqllastid("INSERT INTO `dd_comments` (`comment_id`, `comment_postid`, `comment_isreply`, `comment_replyto`, `comment_username`, `comment_email`, `comment_date`, `comment_content`, `comment_ip`, `comment_reported`, `comment_isfromadmin`, `comment_isfromcontributor`, `comment_userid`) VALUES (NULL, '".$comment_post_id."', '0', '0', '".$commentname."', '".$commentemail."', CURRENT_TIMESTAMP, '".$commentcontent."', '".$commentip."', '', ".$commentstatus." '".$userid."')");
	
	}
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	   $_SESSION['resp']['formrefresh'] = true;
       echo json_encode($_SESSION['resp']);
       exit;
	}
	}}
}
