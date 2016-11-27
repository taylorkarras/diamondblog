<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
		if ($retrive->restrictpermissionlevel('3')){
 header("HTTP/1.0 403 Forbidden");
 die();
	}
$global = new DB_global;

unset($_SESSION["errors"]);
    if (isset($_POST))
    {

if (isset($_POST['maildelete'])){

$global->sqlquery("DELETE FROM `dd_mailtree` WHERE `dd_mailtree`.`mailtree_name` = '".$_POST['maildelete']."'");

			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Mail destination deleted.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	
} else if ($_POST['mailenabled'] == '1'){
	
	if(trim($_POST['mailserver']) === '' && $_POST['mailenabled'] == '1')  {
		$_SESSION['errors']['mailserver'] = "You cannot leave the server field blank.";
		$hasError = true;
	} else {
		$mailserver = $_POST['mailserver'];
	}
	if(trim($_POST['mailuser']) === '' && $_POST['mailenabled'] == '1')  {
		$_SESSION['errors']['mailuser'] = "You need a user to connect.";
		$hasError = true;
	} else {
		$mailuser = $_POST['mailuser'];
	}
	if(trim($_POST['mailpassword']) === '' && $_POST['mailenabled'] == '1')  {
		$_SESSION['errors']['mailpassword'] = "You need a password to connect.";
		$hasError = true;
	} else {
		$mailpassword = $_POST['mailpassword'];
	}

			if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
		
		$mailcheckinit = $global->sqlquery("SELECT * FROM dd_mail");
		$mailcheck = $mailcheckinit->fetch_assoc();

		if(!$global->sqlquery("SELECT * FROM dd_mail WHERE EXISTS (SELECT mail_password FROM dd_mail);")){
			$global->sqlquery("INSERT INTO `dd_mail` (`mail_server`, `mail_user`, `mail_password`, `mail_inuse`) VALUES ('".$mailserver."', '".$mailuser."', '".$mailpassword."', '".$_POST['mailenabled']."')");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Mail server info updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}

		} else {
			
			$global->sqlquery("UPDATE `dd_mail` SET `mail_server` = '".$mailserver."', `mail_user` = '".$mailuser."', `mail_password` = '".$mailpassword."', `mail_inuse` = '".$_POST['storageenabled']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Mail server info updated.</p>';
			
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
	?>
