<?php
if ($retrive->isLoggedIn() == true){
		if ($retrive->restrictpermissionlevel('3')){
 header("HTTP/1.0 403 Forbidden");
 die();
	}
$global = new DB_global;

unset($_SESSION["errors"]);
    if (isset($_POST))
    {
if(isset($_POST['categoryadd'])){

if(trim($_POST['categoryadd']) === '')  {
		$_SESSION['errors']['categoryadd'] = "Please enter a category to add.";
		$hasError = true;
	} else if (str_word_count($_POST['categoryadd']) > '1'){
		$_SESSION['errors']['categoryadd'] = "It cannot be more than one word.";
		$hasError = true;
	} else if (preg_match('/[^a-zA-Z]/', $_POST['categoryadd'])){
		$_SESSION['errors']['categoryadd'] = "Must not contain anything except letters.";
	$hasError = true;}
	else {
		$categoryadd = $_POST['categoryadd'];
	}
	
			if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else { 
	$global->sqlquery ("INSERT INTO `dd_categories` (`category_id`, `category_name`) VALUES (NULL, '".$categoryadd."')");
				        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Category added.</p>';
			
                echo json_encode($resp);
		        exit;
	}

	}
	
} else if (isset($_POST['categorydeletedistinguish'])){

$global->sqlquery("DELETE FROM `dd_categories` WHERE `dd_categories`.`category_name` = '".$_POST['categorydelete']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Category deleted.</p>';
			
                echo json_encode($resp);
		        exit;
	}

	
} else if (isset($_POST['tagdeletedistinguish'])){

$global->sqlquery("DELETE FROM `dd_tags` WHERE `dd_tags`.`tag_name` = '".$_POST['tagdelete']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Tag deleted.</p>';
			
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