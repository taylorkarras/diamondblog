<?php
$global = new DB_global;
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
	if ($retrive->restrictpermissionlevel('3')){
 header("HTTP/1.0 403 Forbidden");
 die();
	}
unset($_SESSION["errors"]);
    if (isset($_POST))
    {

if (isset($_POST['categorydelete'])){

$global->sqlquery("DELETE FROM `dd_categories` WHERE `dd_categories`.`category_name` = '".$_POST['categorydelete']."'");
	
} else if (isset($_POST['storageenabled']) && $_POST['storageenabled'] == '0'){
		$global->sqlquery("UPDATE `dd_storage` SET `ftp_inuse` = '".$_POST['storageenabled']."'");
						$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>FTP info updated.</p>';
			
                echo json_encode($resp);
		        exit;} else if(isset($_POST['storageenabled']) && $_POST['storageenabled'] == '1'){
	
	if(trim($_POST['storageserver']) === '' && $_POST['storageenabled'] == '1')  {
		$_SESSION['errors']['storageserver'] = "You cannot leave the server field blank.";
		$hasError = true;
	} else {
		$storageserver = $_POST['storageserver'];
	}
	if(trim($_POST['storageuser']) === '' && $_POST['storageenabled'] == '1')  {
		$_SESSION['errors']['storageuser'] = "You need a user to connect.";
		$hasError = true;
	} else {
		$storageuser = $_POST['storageuser'];
	}
	if(trim($_POST['storagepassword']) === '' && $_POST['storageenabled'] == '1')  {
		$_SESSION['errors']['storagepassword'] = "You need a password to connect.";
		$hasError = true;
	} else {
		$storagepassword = $_POST['storagepassword'];
	}
	if(trim($_POST['storagedirectory']) === '' && $_POST['storageenabled'] == '1')  {
		$_SESSION['errors']['storagedirectory'] = "You need a directory to place your storage in.";
		$hasError = true;
	} else if ($_POST['storagedirectory'] === '/'){
		$storagedirectory = '';
	} else {
		$storagedirector = $_POST['storagedirectory'];
	}

			if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
		
		$storagecheckinit = $global->sqlquery("SELECT * FROM dd_storage");
		$storagecheck = $storagecheckinit->fetch_assoc();

		if($global->sqlquery("INSERT INTO `dd_storage` (`ftp_server`, `ftp_user`, `ftp_password`, `ftp_directory`, `ftp_inuse`) VALUES ('".$storageserver."', '".$storageuser."', '".$storagepassword."', '".$storagedirectory."', '".$_POST['storageenabled']."') WHERE NOT EXISTS (SELECT * FROM dd_storage WHERE ftp_username = '".$storagecheck['ftp_username']."')")){;
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>FTP info updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}
		} else {
			
			$global->sqlquery("UPDATE `dd_storage` SET `ftp_server` = '".$storageserver."', `ftp_user` = '".$storageuser."', `ftp_password` = '".$storagepassword."', `ftp_directory` = '".$storagedirectory."', `ftp_inuse` = '".$_POST['storageenabled']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>FTP info updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}

		}
		
		if ($_POST['storageenabled'] == '0'){
		$global->sqlquery("UPDATE `dd_storage` SET `ftp_inuse` = '".$_POST['storageenabled']."'");}
	}
	
} else if (isset($_GET['theme'])){
$global->sqlquery("UPDATE `dd_settings` SET `default_theme` = '".$_GET['theme']."'");
		header("Location: ".$_SERVER['HTTP_REFERER']);
} else if (isset($_POST['sitesettings'])){
	
	if(trim($_POST['sitename']) === '')  {
		$_SESSION['errors']['sitename'] = "You cannot leave the site name field blank.";
		$hasError = true;
	} else {
		$sitename = $_POST['sitename'];
		$sitetitle = $_POST['sitetitle'];
	}
	if(trim($_POST['adminemail']) === '')  {
		$_SESSION['errors']['adminemail'] = "You cannot leave the admin email field blank.";
		$hasError = true;
	} else {
		$adminemail = $_POST['adminemail'];
	}
	if(strlen($_POST['metadescription']) > '200')  {
                $_SESSION['errors']['metadescription'] = "Meta description cannot be longer than 200 characters.";
                $hasError = true;
        } else {
                $metadescription = str_replace("'", '', $_POST['metadescription']);
        }
	if(trim($_POST['dateformat']) === '')  {
		$_SESSION['errors']['dateformat'] = "You cannot leave the date field field blank.";
		$hasError = true;
	} else {
		$dateformat = $_POST['dateformat'];
	}
	if(trim($_POST['timeformat']) === '')  {
		$_SESSION['errors']['timeformat'] = "You cannot leave the time field field blank.";
		$hasError = true;
	} else {
		$timeformat = $_POST['timeformat'];
	}
	if(trim($_POST['postsperpage']) === '')  {
		$_SESSION['errors']['postsperpage'] = "You cannot leave the posts per page field blank.";
		$hasError = true;
	} else {
		$postsperpage = $_POST['postsperpage'];
	}
	if(trim($_POST['commentsperpage']) === '')  {
		$_SESSION['errors']['commentsperpage'] = "You cannot leave the comments per page field blank.";
		$hasError = true;
	} else {
		$commentsperpage = $_POST['commentsperpage'];
	}

			if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
		$global->sqlquery("UPDATE `dd_settings` SET `site_name` = '".$sitename."', `site_title` = '".$sitetitle."', `admin_email` = '".$adminemail."', `site_metadescription` = '".$metadescription."', `date_format` = '".$dateformat."', `time_format` = '".$timeformat."', `site_color` = '".$_POST['sitecolor']."', `postsperpage` = '".$postsperpage."', `commentsperpage` = '".$commentsperpage."', `navigation_select` = '".$_POST['sitescrolling']."', `subtext_on` = '".$_POST['subtextenabled']."', `contact_users_on` = '".$_POST['usercontactenabled']."', `logo_on` = '".$_POST['logoenabled']."'");
			        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Settings have been updated.</p>';
			
                echo json_encode($resp);
		        exit;
	}

	}
	
}
	}
	} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}
