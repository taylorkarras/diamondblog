<?php
$global = new DB_global;
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
	
if (!isset($_COOKIE["userID"])){
pluginClass::hook( "captcha" );
}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
$global->sqlquery("INSERT INTO `dd_reports` (`report_id`, `report_commentid`, `report_ip`, `report_name`, `report_email`, `report_text`) VALUES (NULL, '".$_SESSION['info']['comment_id']."', '".$_SERVER['REMOTE_ADDR']."', '".$_POST['rcname']."', '".$_POST['rcemailaddress']."', '".$_POST['rcmessage']."')");
$global->sqlquery("UPDATE `dd_comments` SET `comment_reported` = '1' WHERE `comment_id` = '".$_SESSION['info']['comment_id']."'");
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
