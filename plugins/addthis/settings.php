<?php 
echo consolemenu();
echo '<div id="page"><div class="center">AddThis Settings</div>
<div id="settingslist">';
$global = new DB_global;
$datainit = $global->sqlquery("SELECT * from ddp_addthis");
$data = $datainit->fetch_assoc();
echo '<form id="pluginsettings" method="post">
<br /><label name="addthiscode">AddThis code</label>
<br /><textarea name="addthiscode" class="htmlcode">'.$data['addthis_code'].'</textarea>
<br /><br /><input class="postsubmit" name="addthissettingssubmit" type="submit" value="Submit">
</form>	
</div></div>';
?>