<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
$global = new DB_global;

unset($_SESSION["errors"]);
    if (isset($_POST))
    {

		if(trim($_POST['commentname']) === '')  {
		$_SESSION['errors']['commentname'] = "You cannot leave the name blank.";
		$hasError = true;	
	} else {
		$commentname = $_POST['commentname'];
	}
	
		if(empty($_POST['commentemail']))  {	
		$_SESSION['errors']['commentemail'] = "You cannot leave the email blank.";
		$hasError = true;	
	} else {
		$commentemail = $_POST['commentemail'];
	}
	
		if(empty($_POST['commentcontent']))  {	
		$_SESSION['errors']['commentcontent'] = "You cannot leave the comment blank.";
		$hasError = true;	
	} else {
		$commentcontent = $_POST['commentcontent'];
	}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
	$global->sqlquery("UPDATE `dd_comments` SET `comment_username` = '".$commentname."', `comment_email` = '".$commentemail."', `comment_content` = '".$commentcontent."' WHERE `comment_id` = '".$_POST['commentid']."'");
				        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Edited comment.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	}
	}
} else {
	 header("HTTP/1.0 403 Forbidden");
 die();
}