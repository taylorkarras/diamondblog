<?php
$global = new DB_global;
if($_GET['status'] == 'enabled'){
$global->sqlquery("UPDATE ddp_googlenews SET plugin_enabled = '1'");
header('Location: '.$_SERVER['HTTP_REFERER']);
}else if($_GET['status'] == 'disabled'){
$global->sqlquery("UPDATE ddp_googlenews SET plugin_enabled = '0'");
header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>