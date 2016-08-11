<?php
$global = new DB_global;
if($_GET['uninstall'] == 'true'){
$global->sqlquery("DROP TABLE ddp_ganalytics");
header('Location: '.$_SERVER['HTTP_REFERER']);
}else {
$global->sqlquery("CREATE TABLE `ddp_ganalytics` (
  `analytics_code` text NOT NULL,
  `plugin_enabled` int(1) NOT NULL
) DEFAULT CHARSET=utf8mb4;");
$global->sqlquery("INSERT INTO `ddp_ganalytics` (`analytics_code`, `plugin_enabled`) VALUES ('', '1')");
header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>