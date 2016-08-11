<?php 
echo consolemenu();
echo '<div id="page"><div class="center">Push Notification Settings</div>
<div id="settingslist">';
$global = new DB_global;
$clientcount1 = $global->sqlquery("SELECT * FROM ddp_pushnotifications_list;");
$clientcount2 = $clientcount1->num_rows;
$datainit = $global->sqlquery("SELECT * from ddp_pushnotifications");
$data = $datainit->fetch_assoc();
echo '<br /><div class="center">There are '.number_format($clientcount2).' clients authorized to recieve notifications.</div><form id="pluginsettings" method="post">
<br /><label name="pushnotificationsname">Client Name</label>
<br /><input type="pushnotificationsname" name="pushnotificationsname" value="'.$data['clientname'].'"/>
<br /><label name="nodejsserver">Node.js server</label>
<div class="smalltext">Node.js setup required to recieve notifications. <a href="http://blog.ptapp.io/creating-real-time-applications-php/" title="Node.js tutorial" "alt="Node.js tutorial">Follow this tutorial to set one up yourself.</a></div>
<br /><input type="text" name="nodejsserver" value="'.$data['nodejs_server'].'" />
<br /><label name="gcmapiid">Firebase Cloud Messaging API ID</label>
<br /><input type="text" name="gcmapiid" value="'.$data['gcm_apiid'].'" />
<br /><label name="gcmapiid">Firebase Cloud Messaging Project Number</label>
<br /><input type="text" name="gcmprojectno" value="'.$data['gcm_projectno'].'"/>
<br /><br /><input class="postsubmit" name="pushnotificationssubmit" type="submit" value="Submit">
</form>	
</div></div>';
?>