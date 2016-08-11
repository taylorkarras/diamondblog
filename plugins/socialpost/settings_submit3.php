<?php
$global = new DB_global;
unset($_SESSION["errors"]);

if(isset($_POST)){

if ($_POST['pinterestenabled'] == '0'){
		$global->sqlquery("UPDATE `ddp_socialpost` SET `pinterest_enabled` = '".$_POST['pinterestenabled']."'");
						$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Pinterest settings updated.</p>';
			
                echo json_encode($resp);
		        exit;} else if ($_POST['pinterestenabled'] == '1'){
					
if(trim($_POST['pinterestapikey']) === '' && $_POST['pinterestenabled'] == '1')  {
		$_SESSION['errors']['pinterestapikey'] = "You cannot leave the API key blank.";
		$hasError = true;
	} else {
		$pinterestapikey = $_POST['pinterestapikey'];
	}
if(trim($_POST['pinterestapisecret']) === '' && $_POST['pinterestenabled'] == '1')  {
		$_SESSION['errors']['pinterestapisecret'] = "You cannot leave the API secret blank.";
		$hasError = true;
	} else {
		$pinterestapisecret = $_POST['facebookapisecret'];
	}
if(trim($_POST['pinterestaccesstoken']) === '' && $_POST['pinterestenabled'] == '1')  {
		$_SESSION['errors']['pinterestaccesstoken'] = "You cannot leave the Access token blank.";
		$hasError = true;
	} else {
		$pinterestaccesstoken = $_POST['pinterestaccesstoken'];
	}
if(trim($_POST['pinterestboard']) === '' && $_POST['pinterestenabled'] == '1')  {
		$_SESSION['errors']['pinterestboard'] = "You cannot leave the board name blank.";
		$hasError = true;
	} else {
		$pinterestboard = $_POST['pinterestboard'];
	}
	if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
			$global->sqlquery("UPDATE `ddp_socialpost` SET `pinterest_apikey` = '".$pinterestapikey."', `pinterest_apisecret` = '".$pinterestapisecret."', `pinterest_token` = '".$pinterestaccesstoken."', `pinterest_board` = '".$pinterestboard."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Pinterest settings updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	}
}
}
?>