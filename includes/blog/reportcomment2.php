<?php
$global = new DB_global;
$check = new DB_check;
$templateinit = $global->sqlquery("SELECT * FROM dd_templates;");
$template = $templateinit->fetch_assoc();
if (isset($_GET['commentid'])){
$_SESSION['info']['comment_id'] = $_GET['commentid'];
}
$reported1 = $global->sqlquery("SELECT * FROM `dd_reports` WHERE report_ip = '".$_SERVER['REMOTE_ADDR']."'");
$reported2 = $global->sqlquery("SELECT * FROM `dd_comments` WHERE comment_reported = '1' AND comment_id = '".$_SESSION['info']['comment_id']."'");

if (isset($_POST) && isset($_SESSION['info']['comment_id']) && $reported1->num_rows === 0 && $reported2->num_rows === 0){
unset($_SESSION["errors"]);
	
		if(trim($_POST['rcname']) === '')  {
		$_SESSION['errors']['rcname'] = "You must enter a name.";
		$hasError = true;	
	}
	
		if(empty($_POST['rcemailaddress']))  {	
		$_SESSION['errors']['rcemailaddress'] = "You must enter an email.";
		$hasError = true;	
	}
	
		if(empty($_POST['rcmessage']))  {	
		$_SESSION['errors']['emailmessage'] = "You must enter a message.";
		$hasError = true;	
	}
	
		if($check->ifemailbanned($_POST['rcemailaddress']))  {	
		$_SESSION['errors']['commentemail'] = "Email is banned. Reason: \"".BANREASONEMAIL."\"";
		$hasError = true;	
	}
	
		if($check->ifnamebanned($_POST['rcname']))  {	
		$_SESSION['errors']['commentname'] = "Name is banned. Reason: \"".BANREASONNAME."\"";
		$hasError = true;	
	}
	
if (!isset($_COOKIE["userID"])){
pluginClass::hook( "captcha" );
}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
$reportid = $global->sqllastid("INSERT INTO `dd_reports` (`report_id`, `report_commentid`, `report_ip`, `report_name`, `report_email`, `report_text`) VALUES (NULL, '".$_SESSION['info']['comment_id']."', '".$_SERVER['REMOTE_ADDR']."', '".$_POST['rcname']."', '".$_POST['rcemailaddress']."', '".$_POST['rcmessage']."')");
$global->sqlquery("UPDATE `dd_comments` SET `comment_reported` = '1' WHERE `comment_id` = '".$_SESSION['info']['comment_id']."'");
 
		$reports = $global->sqlquery("SELECT * FROM dd_users WHERE user_reportsnotify = '1'");
		
		if ($reports->num_rows > 0) {
$reportinit = $global->sqlquery("SELECT * FROM dd_reports WHERE report_id = '".$reportid."'");
$report = $reportinit->fetch_assoc();
		$retrive = new DB_retrival;
		
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
  ->setSubject(''.sitename('internal').' - New comment report by "'.$report['report_name'].'" ('.$report['report_ip'].')')

  // Set the From address with an associative array
  ->setFrom(array('no-reply@'.$_SERVER['HTTP_HOST'].'' => sitename('internal')))

  // Set the To addresses with an associative array
  ->setTo($retrive->email($row['user_id']))

  // Give it a body
  ->setBody('Hi '.$retrive->realname($row['user_id']).',
	
	The site has recieved a new comment report.
	
	The report information is below.
	
	Name: '.$report['report_name'].'
	Email: '.$report['report_email'].'
	IP: '.$report['report_ip'].'
	
	Go to https://'.$_SERVER['HTTP_HOST'].'/console/reports?reportid='.$reportid.' to view detailed information and to take action.
	
	This is an automatically generated message, do not respond to it.
	
	-'.sitename('internal').'')

  // And optionally an alternative body
  ->addPart('<p>Hi '.$retrive->realname($row['user_id']).',</p>
	
	<p>The site has recieved a new comment report.</p>
	
	<p>The report information is below.</p>
	
	<p>Name: '.$report['report_name'].'
	<br />Email: '.$report['report_email'].'
	<br />IP: '.$report['report_ip'].'</p>
	
	<p><a href="https://'.$_SERVER['HTTP_HOST'].'/console/reports?reportid='.$reportid.'" title="View Report", alt="View Report">Click here to view detailed information and to take action.</a></p>

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
	<p>Comment reported; if urgent, we will get back with you shortly.</p>';
			
                echo json_encode($resp);
		        exit;
	}
}
}