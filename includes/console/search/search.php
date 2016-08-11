<?php
  if(isset($_POST)){
	  
	  $url = $_SERVER['REQUEST_URI'];
	  
			if (strpos($url,'console/posts') !== false) {
          		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['searchposts'] = true;
			
                echo json_encode($resp);
		        exit;
	}
			} else if (strpos($url,'console/users') !== false) {
          		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['searchusers'] = true;
			
                echo json_encode($resp);
		        exit;
	}
			} else if (strpos($url,'console/ban') !== false) {
          		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['searchbans'] = true;
			
                echo json_encode($resp);
		        exit;
	}
			}
  }
?>