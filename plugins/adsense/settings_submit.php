<?php

$global = new DB_global;

if(isset($_POST)){
			$global->sqlquery("UPDATE `ddp_adsense` SET `adcode_content` = '".$_POST['adsensecode1']."', adcode_post = '".$_POST['adsensecode2']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>AdSense code updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
}