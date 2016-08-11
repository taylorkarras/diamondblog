<?php
  if(isset($_POST)){
          		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['search'] = true;
			
                echo json_encode($resp);
		        exit;
	}
  }
?>