<?php 
echo consolemenu();
echo '<div id="page"><div class="center">AdSense Settings</div>
<div id="settingslist">';
$global = new DB_global;
$datainit = $global->sqlquery("SELECT * from ddp_adsense");
$data = $datainit->fetch_assoc();
echo '<form id="pluginsettings" method="post">
<br /><label name="adsensecode1">AdSense Code Homepage</label>
<br /><textarea name="adsensecode1" class="htmlcode">'.$data['adcode_content'].'</textarea>
<br /><label name="adsensecode2">AdSense Code Post</label>
<br /><textarea name="adsensecode2" class="htmlcode">'.$data['adcode_post'].'</textarea>
<br /><br /><input class="postsubmit" name="adsensesubmit" type="submit" value="Submit">
</form>	
</div></div>';
?>