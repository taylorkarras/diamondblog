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

		if(trim($_POST['pagetitle']) === '')  {
		$_SESSION['errors']['pagetitle'] = "Please enter a page title.";
		$hasError = true;	
	} else {
		$pagetitle = $global->real_escape_string($_POST['pagetitle']);
	}
	
		if(!empty($_POST['pagelink']) xor empty(!$_POST['pagecontent']))  {	
		$pagelink = $_POST['pagelink'];
		$postcontent = $_POST['pagecontent'];
	} else {
		$_SESSION['errors']['oneortheother'] = "Please either enter a link or enter post content, you can enter both if you want.";
		$hasError = true;
	}
				$contactform = $global->sqlquery("SELECT * FROM `dd_pages` WHERE `page_contactform` = '1';");
				$contactform2 = $contactform->fetch_assoc();

	if(isset($_POST['contactform']) && $_POST['contactform'] == '1'){			
		if (!empty($_POST['pageidtoedit']) && $contactform2['page_number'] == $_POST['pageidtoedit']){
			$cf = $_POST['contactform'];
		} else if (!empty($_POST['pageidtoedit']) && $contactform2['page_number'] !== $_POST['pageidtoedit']){
                $_SESSION['errors']['contactform'] = "You can only have one contact form at a time.";
                $hasError = true;
		} else {
			$cf = $_POST['contactform'];
		}
	}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
		
		if (empty($_POST['pagecustomlink'])) {
		$larray1 = array(',', '!', "'", ';', '&', '=', '?', ' ');
		$link1 = str_replace($larray1, '', $pagetitle);
		$link2 = strtolower($link1);
		} else {
		$link2 = $_POST['pagecustomlink'];
		}
		
		if (empty($_POST['pagelink'])) {
		
		if (!empty($_SESSION['editid']['page']) && $_SESSION['editid']['page'] !== 'new'){
			$global->sqlquery("UPDATE `dd_pages` SET `page_link` = '".$link2."', `page_content` = '".$postcontent."', `page_contactform` = '".$cf."', `page_title` = '".$pagetitle."', `page_menu_pos` = '".$_POST['pagemenupos']."' WHERE `dd_pages`.`page_number` = '".$_SESSION['editid']['page']."'");
						        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Edited page successfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
		} else {
			$global->sqlquery("INSERT INTO `dd_pages` (`page_number`, `page_title`, `page_content`, `page_author`, `page_link`, `page_external_link`, `page_contactform`, `page_menu_pos`, `page_is_link`) VALUES (NULL, '".$pagetitle."', '".$postcontent."', '".$link2."', '', '".$cf."', '', '', '".$_POST['pagemenupos']."')");
							        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resprefresh'] = true;
				$resp['url'] = 'https://vapourban.com/console/settings/categoriesandpages/2';
				$resp['message'] = '
	<p>Page created sucessfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
		}
		} else {
			if (!empty($_SESSION['editid']['page']) && $_SESSION['editid']['page'] !== 'new'){
			$global->sqlquery("UPDATE `dd_pages` SET `page_link` = '', `page_external_link` = '".$_POST['pagelink']."', `page_contactform` = '".$cf."', `page_content` = '', `page_title` = '".$pagetitle."', `page_is_link` = '1', `page_menu_pos` = '".$_POST['pagemenupos']."' WHERE `dd_pages`.`page_number` = '".$_POST['pageidtoedit']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Edited page successfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
			} else {
				$global->sqlquery("INSERT INTO `dd_pages` (`page_number`, `page_title`, `page_content`, `page_author`, `page_link`, `page_external_link`, `page_contactform`, `page_menu_pos`, `page_is_link`) VALUES (NULL, '".$pagetitle."', '', '', '', '".$pagelink."', '".$cf."', '".$_POST['pagemenupos']."', '1')");
				        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resprefresh'] = true;
				$resp['url'] = 'https://'.$_SERVER['HTTP_HOST'].'/console/settings/categoriesandpages/2';
				$resp['message'] = '
	<p>Page created sucessfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
			}
		}
	}
	}
	} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}
