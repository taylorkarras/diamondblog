<?php

$global = new DB_global;

if(isset($_POST)){
			$global->sqlquery("UPDATE `ddp_googlenews` SET `googlenews_categories` = '".$_POST['googlenewscategories']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Google News categories updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
}