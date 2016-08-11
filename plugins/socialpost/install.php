<?php
$global = new DB_global;
if($_GET['uninstall'] == 'true'){
$global->sqlquery("DROP TABLE ddp_socialpost");
header('Location: '.$_SERVER['HTTP_REFERER']);
}else {
$global->sqlquery("CREATE TABLE `ddp_socialpost` (
  `plugin_enabled` int(1) NOT NULL,
  `twitter_enabled` int(1) NOT NULL,
  `facebook_enabled` int(1) NOT NULL,
  `pinterest_enabled` int(1) NOT NULL,
  `twitter_apikey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter_apisecret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter_accesstoken` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `twitter_accesstokensecret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook_apikey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook_apisecret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook_pagename` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `facebook_accesstoken` text NOT NULL,
  `pinterest_apikey` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinterest_apisecret` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinterest_token` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `pinterest_board` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
$global->sqlquery("INSERT INTO `ddp_socialpost` (`plugin_enabled`, `twitter_enabled`, `facebook_enabled`, `pinterest_enabled`, `twitter_apikey`, `twitter_apisecret`, `twitter_accesstoken`, `twitter_accesstokensecret`, `facebook_apikey`, `facebook_apisecret`, `facebook_pagename`, `facebook_accesstoken`, `pinterest_apikey`, `pinterest_apisecret`, `pinterest_token`, `pinterest_board`) VALUES ('1', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '')");
header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>