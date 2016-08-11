<?php
$global = new DB_global;
if (strpos($_SERVER['REQUEST_URI'], "settings/pluginsettings")){ echo consolemenu();
echo '<div id="page"><div class="center">Plugin Settings</div>
<br />
<br />
<div id="settingslist">';
$pluginsdirsinit = scandir($_SERVER["DOCUMENT_ROOT"].'/plugins/');
unset($pluginsdirsinit[0]);
unset($pluginsdirsinit[1]);
foreach ($pluginsdirsinit as $option){
	$plugindirs = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/plugins/'.$option.'/info.ini');
echo'
<li><a href="/console/plugins/'.$option.'/settings" "title="'.$plugindirs['pluginname'].' settings" "alt="'.$plugindirs['pluginname'].' settings">'.$plugindirs['pluginname'].' settings</a></li>
<div class="smalltext">'.$plugindirs['settingdescription'].'</div>';
}
echo '</div></div>';}else{ echo consolemenu();
echo '<div id="page"><div class="center">Plugins</div>
<br />';
$pluginsdirsinit = scandir($_SERVER["DOCUMENT_ROOT"].'/plugins/');
unset($pluginsdirsinit[0]);
unset($pluginsdirsinit[1]);
foreach ($pluginsdirsinit as $option){
	$ss3 = $global->sqlquery("SELECT * FROM ddp_".$option."");
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
	if (empty($ss3)){
	echo '<a href="/console/settings/plugins/'.$option.'/install" alt="Install and Enable Plugin" title="Install and Enable Plugin">Install and Enable Plugin</a>';
	} else {
		$ss4 = $ss3->fetch_assoc();
		if ($ss4['plugin_enabled'] == '1') {
	echo '<a href="/console/settings/plugins/'.$option.'/activate?status=disabled" alt="Disable Plugin" title="Disable Plugin">Disable Plugin</a>';
	} else {
	echo '<a href="/console/settings/plugins/'.$option.'/activate?status=enabled" alt="Enable Plugin" title="Enable Plugin">Enable Plugin</a> | <a href="/console/settings/plugins/'.$option.'/install?uninstall=true" alt="Uninstall" title="Uninstall">Uninstall</a> ';
	}
	}
	echo '</div>';
	echo '<div class="posttitle">';
	$plugindirs = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/plugins/'.$option.'/info.ini');
	echo $plugindirs[pluginname];
	echo '</div>';
	echo '<div class="postdate">By '.$plugindirs[creator].' ('.$plugindirs[version].')</div>';
	echo '<br /><div class="themedescription">'.$plugindirs[description].'</div>';
	echo '</div>';
	}
echo '</div>';
}
?>