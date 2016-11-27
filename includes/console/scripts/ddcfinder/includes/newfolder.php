<?php

require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/global.php';
require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/retrival.php';

$retrive = new DB_retrival;
$global = new DB_global;
$imagedir = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');
    if (isset($_POST))
    {

if(empty($_POST['foldername']))  {
$_SESSION['errors']['uploaderror'] = 'Please enter a folder name.';
 echo json_encode($_SESSION['errors']);
exit;
} else if($retrive->isftpenabled()){
	$ftpinit = $global->sqlquery("SELECT * FROM dd_storage");
$ftp = $ftpinit->fetch_assoc();
$conn_id = ftp_ssl_connect($ftp['ftp_server']);
$login_result = ftp_login($conn_id, $ftp['ftp_user'], $ftp['ftp_password']);
ftp_pasv($conn_id, true);

$directory = $ftp['ftp_directory'];

ftp_chdir($conn_id, $directory);

if (ftp_mkdir($conn_id, $_POST['foldername'])){

$resp = array();
				$resp['newfolder'] = true;
                echo json_encode($resp);
		        exit;
} else {
	$_SESSION['errors']['uploaderror'] = 'There was a problem creating the folder.';
 echo json_encode($_SESSION['errors']);
 exit;
}
}else {
if (mkdir($_SERVER['DOCUMENT_ROOT'].$imagedir['files_root'].'/'.$_POST['foldername'], 0755, true)){

$resp = array();
				$resp['newfolder'] = true;
                echo json_encode($resp);
		        exit;
} else {
	$_SESSION['errors']['uploaderror'] = 'There was a problem creating the folder.';
 echo json_encode($_SESSION['errors']);
 exit;
}
	}
	}
?>
