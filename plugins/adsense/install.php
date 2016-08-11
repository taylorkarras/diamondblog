<?php
$global = new DB_global;
if($_GET['uninstall'] == 'true'){
$global->sqlquery("DROP TABLE ddp_adsense");
header('Location: '.$_SERVER['HTTP_REFERER']);
}else {
$global->sqlquery("CREATE TABLE `ddp_adsense` (
  `adcode_content` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `adcode_post` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `plugin_enabled` int(1) NOT NULL
) CHARSET=utf8mb4;");
$global->sqlquery("INSERT INTO `ddp_adsense` (`adcode_content`, `adcode_post`, `plugin_enabled`) VALUES ('', '', '1')");
header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>