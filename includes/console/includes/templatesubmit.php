<?php
$global = new DB_global;
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
if (isset($_POST)){
	if ($_POST['404distinguish'] == 'set'){
	
	$global->sqlquery("UPDATE dd_templates SET 404_message = '".$_POST['404template']."'");
	
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Templates updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	}	
}
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
}