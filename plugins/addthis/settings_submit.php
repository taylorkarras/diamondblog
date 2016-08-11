<?php

$global = new DB_global;

if(isset($_POST)){
			$global->sqlquery("UPDATE `ddp_addthis` SET `addthis_code` = '".$_POST['addthiscode']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>AddThis code updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
}