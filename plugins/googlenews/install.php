<?php
$global = new DB_global;
if($_GET['uninstall'] == 'true'){
$global->sqlquery("DROP TABLE ddp_googlenews");
header('Location: '.$_SERVER['HTTP_REFERER']);
}else {
$global->sqlquery("CREATE TABLE `ddp_googlenews` (
  `plugin_enabled` int(1) NOT NULL,
  `googlenews_categories` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) DEFAULT CHARSET=utf8mb4;");
$global->sqlquery("INSERT INTO `ddp_googlenews` (`plugin_enabled`, `googlenews_categories`) VALUES ('1', '')");
header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>