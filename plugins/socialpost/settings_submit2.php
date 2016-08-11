<?php
$global = new DB_global;
unset($_SESSION["errors"]);

if(isset($_POST)){
if ($_POST['facebookenabled'] == '0'){
		$global->sqlquery("UPDATE `ddp_socialpost` SET `facebook_enabled` = '".$_POST['facebookenabled']."'");
						$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Facebook settings updated.</p>';
			
                echo json_encode($resp);
		        exit;} else if ($_POST['facebookenabled'] == '1'){
					
if(trim($_POST['facebookapikey']) === '' && $_POST['facebookenabled'] == '1')  {
		$_SESSION['errors']['facebookapikey'] = "You cannot leave the API key blank.";
		$hasError = true;
	} else {
		$facebookapikey = $_POST['facebookapikey'];
	}
if(trim($_POST['facebookapisecret']) === '' && $_POST['facebookenabled'] == '1')  {
		$_SESSION['errors']['facebookapisecret'] = "You cannot leave the API secret blank.";
		$hasError = true;
	} else {
		$facebookapisecret = $_POST['facebookapisecret'];
	}
if(trim($_POST['facebookaccesstoken']) === '' && $_POST['facebookenabled'] == '1')  {
		$_SESSION['errors']['facebookaccesstoken'] = "You cannot leave the Access token blank.";
		$hasError = true;
	} else {
		$facebookaccesstoken = $_POST['facebookaccesstoken'];
	}
if(trim($_POST['facebookpagename']) === '' && $_POST['facebookenabled'] == '1')  {
		$_SESSION['errors']['facebookpagename'] = "You cannot leave the page name blank.";
		$hasError = true;
	} else {
		$facebookpagename = $_POST['facebookpagename'];
	}
	if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
			$global->sqlquery("UPDATE `ddp_socialpost` SET `facebook_apikey` = '".$facebookapikey."', `facebook_apisecret` = '".$facebookapisecret."', `facebook_accesstoken` = '".$facebookaccesstoken."', `facebook_pagename` = '".$facebookpagename."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Facebook settings updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	}
}
}

?>