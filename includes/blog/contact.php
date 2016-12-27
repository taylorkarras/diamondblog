<?php
	$global = new DB_global;
	$check = new DB_check;
	$retrive = new DB_retrival;

if (isset($_POST)){
unset($_SESSION["errors"]);
	
		if(trim($_POST['emailname']) === '')  {
		$_SESSION['errors']['emailname'] = "You must enter a name.";
		$hasError = true;	
	} else {
		$emailname = $_POST['emailname'];
	}
	
		if(trim($_POST['emailsubject']) === '')  {
		$_SESSION['errors']['emailsubject'] = "You must enter a subject.";
		$hasError = true;	
	} else {
		$emailsubject = $_POST['emailsubject'];
	}
	
		if(empty($_POST['emailaddress']))  {	
		$_SESSION['errors']['emailaddress'] = "You must enter an email.";
		$hasError = true;	
	} else {
		$emailaddress = $_POST['emailaddress'];
	}
	
		if(empty($_POST['emailmessage']))  {	
		$_SESSION['errors']['emailmessage'] = "You must enter a message.";
		$hasError = true;	
	} else {
		$emailmessage = "<p>This message was sent from IP ".$_POST['emailip']."</p>".$_POST['emailmessage'];
	}
	
if (!isset($_COOKIE["userID"])){
pluginClass::hook( "captcha" );
}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
		
		$userinfo = $global->sqlquery("SELECT * FROM dd_users WHERE user_username = '".$_POST['emaildestination']."'");
$userinfo2 = $userinfo->fetch_assoc();
		
		if ($_POST['emaildestination'] == $userinfo2['user_username']){
		$actualemaildestination = $userinfo2['user_email'];
		} else {
		$emaildestination = $global->sqlquery("SELECT mailtree_email FROM dd_mailtree WHERE mailtree_name = '".$_POST['emaildestination']."'");
		$emaildestination2 = $emaildestination->fetch_assoc();
		$actualemaildestination = $emaildestination2['mailtree_email'];
		}
		
if ($retrive->ismailenabled() == true){
	$mailinit = $global->sqlquery("SELECT * FROM dd_mail");
	$mail = $mailinit->fetch_assoc();
	
$transport = Swift_SmtpTransport::newInstance($mail['mail_server'], 587, 'tls')
  ->setUsername($mail['mail_user'])
  ->setPassword($mail['mail_password'])
  ;
} else {
$transport = Swift_SendmailTransport::newInstance('/usr/sbin/sendmail -bs');
}

$message = Swift_Message::newInstance()->setCharset('iso-8859-2')

  // Give the message a subject
  ->setSubject($emailsubject)

  // Set the From address with an associative array
  ->setFrom(array($emailaddress => $emailname))

  // Set the To addresses with an associative array
  ->setTo($actualemaildestination)

  // Give it a body
  ->setBody(strip_tags($emailmessage))

  // And optionally an alternative body
  ->addPart($emailmessage, 'text/html');

$mailer = Swift_Mailer::newInstance($transport);

if ($mailer->send($message) == true)
    {
        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Thank you for contacting us; if urgent, we will get back with you shortly.</p>';
			
                echo json_encode($resp);
		        exit;
	}
    } else {
		echo 'fail';
		exit;
	}
	}
}
