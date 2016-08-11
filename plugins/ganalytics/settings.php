<?php 
echo consolemenu();
echo '<div id="page"><div class="center">Google Analytics Settings</div>
<div id="settingslist">';
$global = new DB_global;
$datainit = $global->sqlquery("SELECT * from ddp_ganalytics");
$data = $datainit->fetch_assoc();
echo '<form id="pluginsettings" method="post">
<br /><label name="googleanalyticscode">Analytics Code</label>
<br /><textarea name="googleanalyticscode" class="htmlcode">'.$data['analytics_code'].'</textarea>
<br /><br /><input class="postsubmit" name="analyticssubmit" type="submit" value="Submit">
</form>	
</div></div>';
?>