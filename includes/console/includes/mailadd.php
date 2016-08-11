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
if(trim($_POST['mailcategoryadd']) === '')  {
		$_SESSION['errors']['mailcategoryadd'] = "Please enter a mail category to add.";
		$hasError = true;
	} else {
		$mailcategoryadd = $_POST['mailcategoryadd'];
	}
	
if(!valid_email($_POST['maildestinationadd']))  {
		$_SESSION['errors']['maildestinationadd'] = "Please enter a valid email.";
		$hasError = true;
	} else {
		$maildestinationadd = $_POST['maildestinationadd'];
	}
	
			if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else { 
	$global->sqlquery ("INSERT INTO `dd_mailtree` (`mailtree_id`, `mailtree_name`, `mailtree_email`) VALUES (NULL, '".$mailcategoryadd."', '".$maildestinationadd."')");
				        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Mail destination added.</p>';
			
                echo json_encode($resp);
		        exit;
	}

	}
	
}
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}
?>