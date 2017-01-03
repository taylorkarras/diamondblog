<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
$global = new DB_global;
if (strpos($_SERVER['REQUEST_URI'], "approve") && isset($_GET['commentid'])){

$global->sqlquery("UPDATE `dd_comments` SET `comment_approved` = '1' WHERE comment_id = '".$_GET['commentid']."'");

$postid = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_id = '".$_GET['commentid']."'");
$postidinit = $postid->fetch_assoc();
$postid2 = $global->sqlquery("SELECT * FROM dd_content WHERE content_id = '".$postidinit['comment_postid']."'");
$postid2init = $postid2->fetch_assoc();

	if ($retrive->canrecievecommentemails($postid2init['content_author']) && $postid2init['content_author'] !== $_COOKIE['userID']){
	$retrive = new DB_retrival;
	
if ($retrive->ismailenabled() == true){
	$mailinit = $global->sqlquery("SELECT * FROM dd_mail");
	$mail = $mailinit->fetch_assoc();
	
$transport = Swift_SmtpTransport::newInstance($mail['mail_server'], 25)
  ->setUsername($mail['mail_user'])
  ->setPassword($mail['mail_password'])
  ;
} else {
$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
}

$message = Swift_Message::newInstance()->setCharset('iso-8859-2')

  // Give the message a subject
  ->setSubject(''.sitename().' - Comment left on post "'.$postid2init['content_title'].'"')

  // Set the From address with an associative array
  ->setFrom(array('no-reply@'.$_SERVER['HTTP_HOST'].'' => sitename()))

  // Set the To addresses with an associative array
  ->setTo($retrive->email($postid2init['content_author']))

  // Give it a body
  ->setBody('Hi '.$retrive->realname($postid2init['content_author']).',
	
	A comment has been left on your post "'.$postid2init['content_title'].'".
	
	The comment and it\'s information is below.
	
	Name: '.$postidinit['comment_username'].'
	Email: '.$postidinit['comment_email'].'
	IP: '.$postidinit['comment_ip'].'
	Comment:
	
	'.strip_tags($postidinit['comment_content']).'
	
	Go to https://'.$_SERVER['HTTP_HOST'].'/console/posts/comments?postid='.$postid2init['content_id'].' for comment moderation options.
	
	This is an automatically generated message, do not respond to it.
	
	-'.sitename().'')

  // And optionally an alternative body
  ->addPart('<p>Hi '.$retrive->realname($postid2init['content_author']).',</p>
	
	<p>A comment has been left on your post "'.$postid2init['content_title'].'".</p>
	
	<p>The comment and it\'s information is below.</p>
	
	<p>	Name: '.$commentinit['comment_username'].'
	<br />Email: '.$commentinit['comment_email'].'
	<br />IP: '.$commentinit['comment_ip'].'
	<br />Comment:</p>
	
	'.$commentinit['comment_content'].'
	
	<p>Go to <a href="https://'.$_SERVER['HTTP_HOST'].'/console/posts/comments?postid='.$postid2init['content_id'].'" title="Comments", alt="Comments">https://'.$_SERVER['HTTP_HOST'].'/console/posts/comments?postid='.$postid2init['content_id'].'</a> for comment moderation options.</p>
	
	<p>This is an automatically generated message, do not respond to it.</p>
	
	<p>-'.sitename().'</p>', 'text/html');

$mailer = Swift_Mailer::newInstance($transport);

$mailer->send($message);

	}
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console/reports/approval/');
}
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
	$global->sqlquery("UPDATE `dd_comments` SET `comment_username` = '".$commentname."', `comment_email` = '".$commentemail."', `comment_content` = '".$commentcontent."' WHERE `comment_id` = '".$_SESSION['editid']['comment']."'");
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