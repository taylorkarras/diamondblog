<?php 
$userfunc = new DB_userfunctions;
$global = new DB_global;
$retrive = new DB_retrival;
$userlevel = '';
if ($retrive->isLoggedIn() == true){
unset($_SESSION["errors"]);
    if (isset($_POST))
    {

if (isset($_POST['useridtoedit'])){

		if(trim($_POST['useremail']) === '')  {
		$_SESSION['errors']['useremail'] = "You cannot leave this field blank.";
		$hasError = true;	
	} else if(!$userfunc->valid_email($_POST['useremail'])){
		$_SESSION['errors']['useremail'] = "Please enter a valid email.";
		$hasError = true;
	} else {
		$useremail = $_POST['useremail'];
	}
	
	if(!empty($_POST['userpasswordchange1']))  {
		if(!$userfunc->valid_password($_POST['userpasswordchange1'])){
		$_SESSION['errors']['userpasswordchange1'] = "The password must be 8 characters in length but no longer than 18 characters; it must also have one uppercase letter, have one lowercase letter, have one number and one special character.";
		$hasError = true;	
	} else if(!empty($_POST['userpasswordchange1']) && empty($_POST['userpasswordchange2'])){
		$_SESSION['errors']['userpasswordchange2'] = "Please repeat your new password.";
		$hasError = true;
	} else if($_POST['userpasswordchange1'] !== $_POST['userpasswordchange2']){
		$_SESSION['errors']['userpasswordchange2'] = "Passwords do not match.";
		$hasError = true;
	} else {
		$usernewpassword1 = $_POST['userpasswordchange1'];
		$usernewpassword2 = $_POST['userpasswordchange2'];
	}
	}

if (isset($_POST['userlevel'])){
	if ($_POST['userlevel'] == 'admin'){
$userlevel = "`user_isadmin` = '1', `user_iscontributor` = '0', `user_ismod` = '0'";
	} else if ($_POST['userlevel'] == 'contrib'){
$userlevel = "`user_isadmin` = '0', `user_iscontributor` = '1', `user_ismod` = '0'";
	} else if ($_POST['userlevel'] == 'mod'){
$userlevel = "`user_isadmin` = '0', `user_iscontributor` = '0', `user_ismod` = '1'";
	}
}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
if(isset($usernewpassword1) && isset($usernewpassword2)){
$userfunc->changePassword($_POST['useridtoedit'],$usernewpassword1,$usernewpassword2);

if($_POST['sendpassword'] == '1'){

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
  ->setSubject(''.sitename().' - Your password has been changed')

  // Set the From address with an associative array
  ->setFrom(array('no-reply@'.$_SERVER['HTTP_HOST'].'' => sitename()))

  // Set the To addresses with an associative array
  ->setTo($useremail)

  // Give it a body
  ->setBody('Hi,
	
	Your password has been changed.
	
	Your new password is ('.$_POST['$usernewpassword1'].').
	
	This is an automatically generated message, do not respond to it. Go ahead and sign in with your credentials at '.$_SERVER['HTTP_HOST'].'/console.
	
	Happy blogging!
	-'.sitename().'')

  // And optionally an alternative body
  ->addPart('<p>Hi,</p>
	
	<p>Your password has been changed.</p>
	
	<p>Your new password is ('.$_POST['$usernewpassword1'].').</p>
	
	<p>This is an automatically generated message, do not respond to it. Go ahead and sign in with your credentials at <a href=https://'.$_SERVER['HTTP_HOST'].'/console" title="Console", alt="Console">'.$_SERVER['HTTP_HOST'].'/console</a>.</p>
	
	<p>Happy blogging!
	<br />-'.sitename().'</p>', 'text/html');

$mailer = Swift_Mailer::newInstance($transport);

$mailer->send($message);

}
}
		
$global->sqlquery("UPDATE `dd_users` SET `user_realname` = '".$_POST['userrealname']."', `user_description` = '".$_POST['userdescription']."', `user_subtext` = '".$_POST['usersubtext']."', `user_location` = '".$_POST['userlocation']."', `user_email` = '".$useremail."' ".$userlevel." WHERE `user_id` = '".$_POST['useridtoedit']."'");

if(isset($_POST['closedaccount']) && $_POST['closedaccount'] == '1'){

$global->sqlquery("UPDATE `dd_users` SET `user_closedaccount` = '1' WHERE `user_id` = '".$_POST['useridtoedit']."'");

} else if(isset($_POST['closedaccount']) && $_POST['closedaccount'] == '0'){
	
$global->sqlquery("UPDATE `dd_users` SET `user_closedaccount` = '0' WHERE `user_id` = '".$_POST['useridtoedit']."'");
	
}

			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Edited user info successfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	}
	} else {
				if(trim($_POST['username']) === '')  {
		$_SESSION['errors']['username'] = "You must enter a username.";
		$hasError = true;	
	} else if(!$userfunc->valid_username($_POST['username'])){
		$_SESSION['errors']['username'] = "Please enter a valid username.";
		$hasError = true;
	} else if(!$userfunc->valid_username($_POST['username'])){
		$_SESSION['errors']['username'] = "Please enter a valid username.";
		$hasError = true;
	} else if($userfunc->user_exists($_POST['username'])){
		$_SESSION['errors']['username'] = "User already exists!";
	}
		else {
		$username = $_POST['username'];
	}
				if(trim($_POST['useremail']) === '')  {
		$_SESSION['errors']['useremail'] = "You must enter an email.";
		$hasError = true;	
	} else if(!$userfunc->valid_email($_POST['useremail'])){
		$_SESSION['errors']['useremail'] = "Please enter a valid email.";
		$hasError = true;
	} else if(!$userfunc->user_email_exists($_POST['useremail'])){
		$_SESSION['errors']['useremail'] = "The email you entered is already used.";
		$hasError = true;
	} else {
		$useremail = $_POST['useremail'];
	}

	if ($_POST['userlevel'] == 'admin'){
$userlevel = "'1', '0', '0'";
	} else if ($_POST['userlevel'] == 'contrib'){
$userlevel = "'0', '1', '0'";
	} else if ($_POST['userlevel'] == 'mod'){
$userlevel = "'0', '0', '1'";
	}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
		$passwordencrypt = password_hash($_POST['userpassword'], PASSWORD_DEFAULT);
		$global->sqlquery("INSERT INTO `dd_users` (`user_id`, `user_username`, `user_realname`, `user_password`, `user_picture`, `user_description`, `user_subtext`, `user_location`, `user_isadmin`, `user_iscontributor`, `user_ismod`, `user_closedaccount`, `user_email`, `user_datejoined`) VALUES (NULL, '".$username."', '', '".$passwordencrypt."', '', '', '', '', ".$userlevel.", '0', '".$useremail."', CURRENT_DATE())");

// Create the message
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
  ->setSubject(''.sitename().' - Your username & password')

  // Set the From address with an associative array
  ->setFrom(array('no-reply@'.$_SERVER['HTTP_HOST'].'' => sitename()))

  // Set the To addresses with an associative array
  ->setTo($useremail)

  // Give it a body
  ->setBody('Hi,
	
	Your username is '.$username.'.
	
	Your password is ('.$_POST['userpassword'].').
	
	This is an automatically generated message, do not respond to it. Go ahead and sign in with your credentials at '.$_SERVER['HTTP_HOST'].'/console.
	
	Happy blogging!
	-'.sitename().'')

  // And optionally an alternative body
  ->addPart('<p>Hi,</p>
	
	<p>Your username is ('.$username.').</p>
	
	<p>Your password is ('.$_POST['userpassword'].').</p>
	
	<p>This is an automatically generated message, do not respond to it. Go ahead and sign in with your credentials at <a href=https://'.$_SERVER['HTTP_HOST'].'/console" title="Console", alt="Console">'.$_SERVER['HTTP_HOST'].'/console</a>.</p>
	
	<p>Happy blogging!
	<br />-'.sitename().'</p>', 'text/html');

$mailer = Swift_Mailer::newInstance($transport);

if ($mailer->send($message) == true)
    {
        			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resprefresh'] = true;
				$resp['url'] = 'https://'.$_SERVER['HTTP_HOST'].'/console/users';
				$resp['message'] = '
	<p>User created successfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
    }
	}
	}
}
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
}
