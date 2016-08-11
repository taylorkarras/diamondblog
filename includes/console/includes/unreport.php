<?php
$retrive = new DB_retrival;
$global = new DB_global;
if ($retrive->isLoggedIn() == true){
if (isset($_GET['id']) && isset($_GET['commentid'])){
$global->sqlquery("DELETE FROM `dd_reports` WHERE `dd_reports`.`report_id` = '".$_GET['id']."'");
$global->sqlquery("UPDATE `dd_comments` SET `comment_reported` = '0' WHERE `comment_id` = '".$_GET['commentid']."'");
		header("Location: ".$_SERVER['HTTP_REFERER']);
}
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}