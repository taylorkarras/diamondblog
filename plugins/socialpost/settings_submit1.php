<?php

$global = new DB_global;
unset($_SESSION["errors"]);

if(isset($_POST)){

if ($_POST['twitterenabled'] == '0'){
		$global->sqlquery("UPDATE `ddp_socialpost` SET `twitter_enabled` = '".$_POST['twitterenabled']."'");
						$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Twitter settings updated.</p>';
			
                echo json_encode($resp);
		        exit;} else if ($_POST['twitterenabled'] == '1'){
					
if(trim($_POST['twitterapikey']) === '' && $_POST['twitterenabled'] == '1')  {
		$_SESSION['errors']['twitterapikey'] = "You cannot leave the API key blank.";
		$hasError = true;
	} else {
		$twitterapikey = $_POST['twitterapikey'];
	}
if(trim($_POST['twitterapisecret']) === '' && $_POST['twitterenabled'] == '1')  {
		$_SESSION['errors']['twitterapisecret'] = "You cannot leave the API secret blank.";
		$hasError = true;
	} else {
		$twitterapisecret = $_POST['twitterapisecret'];
	}
if(trim($_POST['twitteraccesstoken']) === '' && $_POST['twitterenabled'] == '1')  {
		$_SESSION['errors']['twitteraccesstoken'] = "You cannot leave the Access token blank.";
		$hasError = true;
	} else {
		$twitteraccesstoken = $_POST['twitteraccesstoken'];
	}
if(trim($_POST['twitteraccesssecret']) === '' && $_POST['twitterenabled'] == '1')  {
		$_SESSION['errors']['twitteraccesssecret'] = "You cannot leave the access secret blank.";
		$hasError = true;
	} else {
		$twitteraccesssecret = $_POST['twitteraccesssecret'];
	}
	if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
			$global->sqlquery("UPDATE `ddp_socialpost` SET `twitter_apikey` = '".$twitterapikey."', `twitter_apisecret` = '".$twitterapisecret."', `twitter_accesstoken` = '".$twitteraccesstoken."', `twitter_accesstokensecret` = '".$twitteraccesssecret."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Twitter settings updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	}
}
}