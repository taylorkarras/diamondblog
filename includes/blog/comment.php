<?php 
if (isset($_POST)){
unset($_SESSION["errors"]);
	$global = new DB_global;
	$check = new DB_check;
	if ($check->ifbanned()){
	}else{
		
				if(trim($_POST['commentname']) === '')  {
		$_SESSION['errors']['commentname'] = "You must enter a name.";
		$hasError = true;	
	} else if (!preg_match('/[^!#$%^&*()_+|}{"?><,;\=-`~]/', $_POST['commentname'])){
		$_SESSION['errors']['commentname'] = "Names can only have letters & numbers!";
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
	
		if(isset($commentemail) && $check->ifemailbanned($commentemail))  {	
		$_SESSION['errors']['commentemail'] = "Email is banned. Reason: \"".BANREASONEMAIL."\"";
		$hasError = true;	
	}
	
		if(isset($commentname) && $check->ifnamebanned($commentname))  {	
		$_SESSION['errors']['commentname'] = "Name is banned. Reason: \"".BANREASONNAME."\"";
		$hasError = true;	
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
	$linkinit = $global->sqlquery("SELECT * FROM dd_content WHERE content_permalink = '".$link."';");
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

	if ($check->ifemailmoderated($commentemail) or $check->ifnamemoderated($commentname) or $check->ifmoderated() or $check->ifarticlemoderated($comment_post_id)){
	$approval = '0';
	} else {
	$approval = '1';
	}
	
	if ($_POST['commentreply'] !== '0' & $_POST['commentreplyto'] !== '0'){
	
	$comment_id = $global->sqllastid("INSERT INTO `dd_comments` (`comment_id`, `comment_`, `comment_isreply`, `comment_replyto`, `comment_username`, `comment_email`, `comment_date`, `comment_content`, `comment_ip`, `comment_reported`, `comment_isfromadmin`, `comment_isfromcontributor`, `comment_userid`, `comment_approved`) VALUES (NULL, '".$comment_post_id."', '".$_POST['commentreply']."', '".$_POST['commentreplyto']."', '".$commentname."', '".$commentemail."', CURRENT_TIMESTAMP, '".$commentcontent."', '".$commentip."', '', ".$commentstatus." '".$userid."', '".$approval."')");
	
	} else {
		
$comment_id = $global->sqllastid("INSERT INTO `dd_comments` (`comment_id`, `comment_postid`, `comment_isreply`, `comment_replyto`, `comment_username`, `comment_email`, `comment_date`, `comment_content`, `comment_ip`, `comment_reported`, `comment_isfromadmin`, `comment_isfromcontributor`, `comment_userid`, `comment_approved`) VALUES (NULL, '".$comment_post_id."', '0', '0', '".$commentname."', '".$commentemail."', CURRENT_TIMESTAMP, '".$commentcontent."', '".$commentip."', '', ".$commentstatus." '".$userid."', '".$approval."')");
	
	}

	if ($approval == '0'){
		$reports = $global->sqlquery("SELECT * FROM dd_users WHERE user_reportsnotify = '1' AND user_closedaccount = '0'");
if ($reports->num_rows > 0) {
		$retrive = new DB_retrival;
	$comment = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_id = '".$comment_id."'");
	$commentinit = $comment->fetch_assoc();

if ($check->ismailenabled() == true){
	$mailinit = $global->sqlquery("SELECT * FROM dd_mail");
	$mail = $mailinit->fetch_assoc();
	
$transport = Swift_SmtpTransport::newInstance($mail['mail_server'], 25)
  ->setUsername($mail['mail_user'])
  ->setPassword($mail['mail_password'])
  ;
} else {
$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
}
	    while($row = $reports->fetch_assoc()) {
$message = Swift_Message::newInstance()->setCharset('iso-8859-2')

  // Give the message a subject
  ->setSubject(''.sitename('internal').' - Comment by "'.$commentinit['comment_username'].'" on "'.$post_id['content_title'].'" requires approval')

  // Set the From address with an associative array
  ->setFrom(array('no-reply@'.$_SERVER['HTTP_HOST'].'' => sitename('internal')))

  // Set the To addresses with an associative array
  ->setTo($retrive->email($row['user_id']))

  // Give it a body
  ->setBody('Hi '.$retrive->realname($row['user_id']).',
	
	A comment is pending approval.
	
	The comment and it\'s information is below.
	
	Post Title: '.$post_id['content_title'].'
	Name: '.$commentinit['comment_username'].'
	Email: '.$commentinit['comment_email'].'
	IP: '.$commentinit['comment_ip'].'
	Comment:
	
	'.strip_tags($commentinit['comment_content']).'
	
	Go to https://'.$_SERVER['HTTP_HOST'].'/console/comments/approve?commentid='.$comment_id.' to approve.
	
	Go to https://'.$_SERVER['HTTP_HOST'].'/console/posts/comments/delete?commentid='.$comment_id.' to delete.
	
	Or...
	
	Go to https://'.$_SERVER['HTTP_HOST'].'/console/reports/approval/ to look at pending comments.
	
	This is an automatically generated message, do not respond to it.
	
	-'.sitename('internal').'')

  // And optionally an alternative body
  ->addPart('<p>Hi '.$retrive->realname($row['user_id']).',</p>
	
	<p>A comment is pending approval.</p>
	
	<p>The comment and it\'s information is below.</p>
	
	<p>Post Title: '.$post_id['content_title'].'
	<br />Name: '.$commentinit['comment_username'].'
	<br />Email: '.$commentinit['comment_email'].'
	<br />IP: '.$commentinit['comment_ip'].'
	<br />Comment:</p>
	
	'.$commentinit['comment_content'].'
	
	<p><a href="https://'.$_SERVER['HTTP_HOST'].'/console/comments/approve?commentid='.$comment_id.'" title="Approve Comment", alt="Approve Comment">Click here to approve comment.</a></p>
	
	<p><a href="https://'.$_SERVER['HTTP_HOST'].'/console/posts/comments/delete?commentid='.$comment_id.'" title="Delete Comment" alt="Delete Comment">Click here to delete comment.</a></p>
	
	<p>Or...</p>
	
	<p><a href="https://'.$_SERVER['HTTP_HOST'].'/console/reports/approval/" title="Pending Comments for Approval" alt="Pending Comments for Approval">Click here to look at pending comments.</a></p>
	
	<p>This is an automatically generated message, do not respond to it.</p>
	
	<p>-'.sitename('internal').'</p>', 'text/html');

$mailer = Swift_Mailer::newInstance($transport);

$mailer->send($message);
		}
}
        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Your comment is awaiting approval.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	}
	
$authorid = $post_id['content_author'];
	if ($check->canrecievecommentemails($authorid) && $authorid !== $_COOKIE['userID']){
	$retrive = new DB_retrival;
	$comment = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_id = '".$comment_id."'");
	$commentinit = $comment->fetch_assoc();
	
if ($check->ismailenabled() == true){
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
  ->setSubject(''.sitename('internal').' - Comment left on post "'.$post_id['content_title'].'"')

  // Set the From address with an associative array
  ->setFrom(array('no-reply@'.$_SERVER['HTTP_HOST'].'' => sitename('internal')))

  // Set the To addresses with an associative array
  ->setTo($retrive->email($authorid))

  // Give it a body
  ->setBody('Hi '.$retrive->realname($authorid).',
	
	A comment has been left on your post "'.$post_id['content_title'].'".
	
	The comment and it\'s information is below.
	
	Name: '.$commentinit['comment_username'].'
	Email: '.$commentinit['comment_email'].'
	IP: '.$commentinit['comment_ip'].'
	Comment:
	
	'.strip_tags($commentinit['comment_content']).'
	
	Go to https://'.$_SERVER['HTTP_HOST'].'/console/posts/comments?postid='.$post_id['content_id'].' for comment moderation options.
	
	This is an automatically generated message, do not respond to it.
	
	-'.sitename('internal').'')

  // And optionally an alternative body
  ->addPart('<p>Hi '.$retrive->realname($authorid).',</p>
	
	<p>A comment has been left on your post "'.$post_id['content_title'].'".</p>
	
	<p>The comment and it\'s information is below.</p>
	
	<p>Name: '.$commentinit['comment_username'].'
	<br />Email: '.$commentinit['comment_email'].'
	<br />IP: '.$commentinit['comment_ip'].'
	<br />Comment:</p>
	
	'.$commentinit['comment_content'].'
	
	<p>Go to <a href="https://'.$_SERVER['HTTP_HOST'].'/console/posts/comments?postid='.$post_id['content_id'].'" title="Comments", alt="Comments">https://'.$_SERVER['HTTP_HOST'].'/console/posts/comments?postid='.$post_id['content_id'].'</a> for comment moderation options.</p>
	
	<p>This is an automatically generated message, do not respond to it.</p>
	
	<p>-'.sitename('internal').'</p>', 'text/html');

$mailer = Swift_Mailer::newInstance($transport);

$mailer->send($message);

	}
	if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	   $_SESSION['resp']['formrefresh'] = true;
       echo json_encode($_SESSION['resp']);
       exit;
	}
	}}
}
