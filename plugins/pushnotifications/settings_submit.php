<?php

$global = new DB_global;

if(isset($_POST)){
			$global->sqlquery("UPDATE `ddp_pushnotifications` SET `nodejs_server` = '".$_POST['nodejsserver']."', `gcm_apiid` = '".$_POST['gcmapiid']."', `gcm_projectno` = '".$_POST['gcmprojectno']."', clientname='".$_POST['pushnotificationsname']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Push Notification settings updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
}