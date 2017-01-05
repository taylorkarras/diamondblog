<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
	if ($retrive->restrictpermissionlevel('2')){
 header("HTTP/1.0 403 Forbidden");
 die();
	}
$global = new DB_global;
unset($GLOBALS['embedlink']);
unset($_SESSION["errors"]);
    if (isset($_POST))
    {
		if(isset($_POST['posttitle']) && trim($_POST['posttitle']) === '')  {
		$_SESSION['errors']['posttitle'] = "Please enter a post title.";
		$hasError = true;	
	} else {
		$posttitle = $global->real_escape_string($_POST['posttitle']);
		$GLOBALS['posttitle'] = $posttitle;
	}
	
		if(!empty($_POST['postmedialink']) or !empty($_POST['postcontent']))  {	
		$postmedialink = $_POST['postmedialink'];
		$postcontent = str_replace("'", '"', $_POST['postcontent']);
	} else {
		$_SESSION['errors']['oneortheother'] = "Please either enter a link or enter post content, you can enter both if you want.";
		$hasError = true;
	}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}}
		
		if (!empty($_SESSION['editid']['draft'])){
			$global->sqlquery("UPDATE `dd_drafts` SET `draft_link` = '".$postmedialink."', `draft_description` = '".$postcontent."', `draft_title` = '".$posttitle."', `draft_category` = '".$_POST['category']."', `draft_tags` = '".$_POST['tags']."', `draft_date` = NOW() WHERE `dd_drafts`.`draft_id` = '".$_SESSION['editid']['draft']."'");	
			
						        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Edited draft successfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
		} else {
			$global->sqlquery("INSERT INTO `dd_drafts` (`draft_id`, `draft_link`, `draft_description`, `draft_title`, `draft_category`, `draft_tags`, `draft_date`, `draft_author`) VALUES (NULL, '".$postmedialink."', '".$postcontent."', '".$posttitle."', '".$_POST['category']."', '".$_POST['tags']."', NOW(), '".$_COOKIE['userID']."')");
			
							        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resprefresh'] = true;
				$resp['url'] = 'https://'.$_SERVER['HTTP_HOST'].'/console/posts/drafts';
				$resp['message'] = '
	<p>Draft created sucessfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
		}
	}
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}
