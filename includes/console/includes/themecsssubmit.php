<?php
if(isset($_POST)){
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.$_POST['themename'].'/styles/'.$_POST['cssname'], $_POST['cssfile']);
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>CSS updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	}


