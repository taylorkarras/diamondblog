<?php
$global = new DB_global;
if($_GET['uninstall'] == 'true'){
$global->sqlquery("DROP TABLE ddp_pushnotifications");
$global->sqlquery("DROP TABLE ddp_pushnotifications_list");
header('Location: '.$_SERVER['HTTP_REFERER']);
}else {
$global->sqlquery("CREATE TABLE `ddp_pushnotifications` (
  `plugin_enabled` int(1) NOT NULL,
  `clientname` varchar(256) NOT NULL,
  `nodejs_server` text NOT NULL,
  `gcm_apiid` text NOT NULL,
  `gcm_projectno` varchar(256) NOT NULL
) CHARSET=utf8mb4;");
$global->sqlquery("CREATE TABLE `ddp_pushnotifications_list` (
  `list_pos` int(11) NOT NULL,
  `list_ip` varchar(256) NOT NULL,
  `list_endpoint` text NOT NULL,
  `list_useragent` text NOT NULL
) DEFAULT CHARSET=utf8mb4; ALTER TABLE `ddp_pushnotifications_list` ADD PRIMARY KEY (`list_pos`); ALTER TABLE `ddp_pushnotifications_list`
  MODIFY `list_pos` int(11) NOT NULL AUTO_INCREMENT;");
$global->sqlquery("INSERT INTO `ddp_pushnotifications` (`plugin_enabled`, `clientname`, `nodejs_server`, `gcm_apiid`, `gcm_projectno`) VALUES ('1', '', '', '', '')");
header('Location: '.$_SERVER['HTTP_REFERER']);
}