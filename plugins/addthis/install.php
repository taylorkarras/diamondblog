<?php
$global = new DB_global;
if($_GET['uninstall'] == 'true'){
$global->sqlquery("DROP TABLE ddp_addthis");
header('Location: '.$_SERVER['HTTP_REFERER']);
}else {
$global->sqlquery("CREATE TABLE `ddp_addthis` (
  `addthis_code` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plugin_enabled` int(1) NOT NULL
) DEFAULT CHARSET=utf8mb4;");
$global->sqlquery("INSERT INTO `ddp_addthis` (`addthis_code`, `plugin_enabled`) VALUES ('', '1')");
header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>