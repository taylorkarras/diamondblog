<?php

require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/global.php';
require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/retrival.php';

function getdir(){
$retrive = new DB_retrival;
$global = new DB_global;

$imagedir = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');

if($retrive->isftpenabled()){
	$ftpinit = $global->sqlquery("SELECT * FROM dd_storage");
$ftp = $ftpinit->fetch_assoc();
$conn_id = ftp_ssl_connect($ftp['ftp_server']);
$login_result = ftp_login($conn_id, $ftp['ftp_user'], $ftp['ftp_password']);
ftp_pasv($conn_id, true);
if (!empty($ftp['ftp_directory'])){
ftp_chdir($conn_id, $ftp['ftp_directory']);
}
$list = ftp_nlist($conn_id, ".");

echo '<a class="directorylink" href="javascript:void(0);" onclick="getfiles(\'root\')"><li class="directory">/</li></a>';
foreach ($list as $key => $value){
if(preg_match('/(.*)\.[^.]+$/', $value)){
	unset($list[$key]);}
}
foreach ($list as $value){
echo '<a class="directorylink" href="javascript:void(0);" onclick="getfiles(\''.$value.'\')"><li class="directory">/'.$value.'</li></a>';
}

}else {
$list = scandir($_SERVER['DOCUMENT_ROOT'].'/'.$imagedir['files_root']);
unset($list[0]);
unset($list[1]);
echo '<a class="directorylink" href="javascript:void(0);" onclick="getfiles(\'root\')"><li class="directory">/</li></a>';
foreach ($list as $key => $value){
if(preg_match('/(.*)\.[^.]+$/', $value)){
	unset($list[$key]);}
}
foreach ($list as $value){
echo '<a class="directorylink" href="javascript:void(0);" onclick="getfiles(\''.$value.'\')"><li class="directory">/'.$value.'</li></a>';
}
}
}
?>
