<?php 
echo consolemenu();
echo '<div id="page"><div class="center">Google News Settings</div>
<div id="settingslist">';
$global = new DB_global;
$datainit = $global->sqlquery("SELECT * from ddp_googlenews");
$data = $datainit->fetch_assoc();
echo '<form id="pluginsettings" method="post">
<br /><label name="googlenewscategories">Categories</label>
<br /><input type="text" name="googlenewscategories" value="'.$data['googlenews_categories'].'"/>
<br /><br /><input class="postsubmit" name="googlenewssubmit" type="submit" value="Submit">
</form>	
</div></div>';
?>