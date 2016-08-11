<?php
$global = new DB_global;
$reported1 = $global->sqlquery("SELECT * FROM `dd_reports` WHERE report_ip = '".$_GET['ip']."'");
$reported2 = $global->sqlquery("SELECT * FROM `dd_comments` WHERE comment_reported = '1' AND comment_id = '".$_GET['id']."'");
if (isset($_GET['id']) && isset($_GET['ip']) && $reported1->num_rows === 0 && $reported2->num_rows === 0){
$global->sqlquery("INSERT INTO `dd_reports` (`report_id`, `report_commentid`, `report_ip`) VALUES (NULL, '".$_GET['id']."', '".$_GET['ip']."')");
$global->sqlquery("UPDATE `dd_comments` SET `comment_reported` = '1' WHERE `comment_id` = '".$_GET['id']."'");
		        exit;
}
else {
		exit;
}