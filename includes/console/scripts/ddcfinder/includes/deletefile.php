<?php

require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/global.php';
require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/retrival.php';

$retrive = new DB_retrival;
$global = new DB_global;

$imagedir = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');

if($retrive->isftpenabled()){
	$ftpinit = $global->sqlquery("SELECT * FROM dd_storage");
$ftp = $ftpinit->fetch_assoc();
$conn_id = ftp_ssl_connect($ftp['ftp_server']);
$login_result = ftp_login($conn_id, $ftp['ftp_user'], $ftp['ftp_password']);
ftp_pasv($conn_id, true);

if (isset($_GET['dir'])){
if ($_GET['dir'] !== 'root'){
$directory = $ftp['ftp_directory'].$_GET['dir'].'/';
} else {
$directory = $ftp['ftp_directory'];
}} else {
$directory = $ftp['ftp_directory'];
}

ftp_chdir($conn_id, $directory);

if (ftp_delete($conn_id, $_GET['file'])){

$resp = array();
				$resp['uploadsuccess'] = true;
                echo json_encode($resp);
		        exit;
}
}else {
if (isset($_GET['dir'])){
if ($_GET['dir'] !== 'root'){
$directory = $imagedir['files_root'].'/'.$_GET['dir'];
} else {
$directory = $imagedir['files_root'];
}} else {
$directory = $imagedir['files_root'];
}
if (unlink($_SERVER["DOCUMENT_ROOT"].$directory.'/'.$_GET['file'])){

$resp = array();
				$resp['uploadsuccess'] = true;
                echo json_encode($resp);
		        exit;
}
}
?>
