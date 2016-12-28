<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
$global = new DB_global;
	if ($retrive->restrictpermissionlevel('3')){
 header("HTTP/1.0 403 Forbidden");
 die();
	}
if ($_GET['position'] == 'on'){

$global->sqlquery("UPDATE `dd_settings` SET `pages_on` = '1', `menu_on` = '1'");
header('Location: https://'.$_SERVER['HTTP_HOST'].'/console/settings/categoriesandpages/2');
}

if ($_GET['position'] == 'off'){

$global->sqlquery("UPDATE `dd_settings` SET `pages_on` = '0', `menu_on` = '0'");
header('Location: https://'.$_SERVER['HTTP_HOST'].'/console/settings/categoriesandpages/2');
}
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}
