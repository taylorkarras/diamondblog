<?php 
echo consolemenu();
echo '<div id="page"><div class="center">SocialPost Settings</div>
<div id="settingslist">';
$global = new DB_global;
$datainit = $global->sqlquery("SELECT * from ddp_socialpost");
$data = $datainit->fetch_assoc();
echo '<form id="pluginsettings1" method="post">';
echo '<div class="sitescrolling">
<br><input type="checkbox" name="twitterenabled" ';  if ($data['twitter_enabled'] == '1'){
	echo 'value="1" checked';
} else {
	echo 'value="0"';
}echo'> Twitter enabled<br></div>'; echo'
<br /><label name="twitterapikey">Twitter API Key</label>
<br /><input type="text" name="twitterapikey" value='.$data['twitter_apikey'].'/>
<br /><label name="twitterapisecret">Twitter API Secret</label>
<br /><input type="text" name="twitterapisecret" value="'.$data['twitter_apisecret'].'" />
<br /><label name="twitteraccesstoken">Twitter Access Token</label>
<br /><input type="text" name="twitteraccesstoken" value="'.$data['twitter_accesstoken'].'"/>
<br /><label name="twitteraccesssecret">Twitter Access Secret</label>
<br /><input type="text" name="twitteraccesssecret" value="'.$data['twitter_accesstokensecret'].'"/>
<input type="hidden" name="twitterdistinguish" value="1" />
<br /><br /><input class="postsubmit" name="twittersubmit" type="submit" value="Submit">
</form>';
echo '<form id="pluginsettings2" method="post">';
echo '<div class="sitescrolling">
<br><input type="checkbox" name="facebookenabled" ';  if ($data['facebook_enabled'] == '1'){
	echo 'value="1" checked';
} else {
	echo 'value="0"';
}echo'> Facebook enabled<br></div>'; echo'
<br /><label name="facebookapikey">Facebook API Key</label>
<br /><input type="text" name="facebookapikey" value='.$data['facebook_apikey'].'/>
<br /><label name="facebookapisecret">Facebook API Secret</label>
<br /><input type="text" name="facebookapisecret" value="'.$data['facebook_apisecret'].'" />
<br /><label name="facebookaccesstoken">Facebook Access Token</label>
<br /><input type="text" name="facebookaccesstoken" value="'.$data['facebook_accesstoken'].'"/>
<div class="smalltext"><a href="https://developers.facebook.com/tools/explorer/" title="Get access token here." alt="Get access token here.">Get access token here.</a></div>
<label name="facebookpagename">Facebook Page Name</label>
<br /><input type="text" name="facebookpagename" value="'.$data['facebook_pagename'].'"/>
<input type="hidden" name="facebookdistinguish" value="1" />
<br /><br /><input class="postsubmit" name="facebooksubmit" type="submit" value="Submit">
</form>';
echo '<form id="pluginsettings3" method="post">';
echo '<div class="sitescrolling">
<br><input type="checkbox" name="pinterestenabled" ';  if ($data['pinterest_enabled'] == '1'){
	echo 'value="1" checked';
} else {
	echo 'value="0"';
}echo'> Pinterest enabled<br></div>'; echo'
<br /><label name="pinterestapikey">Pinterest API Key</label>
<br /><input type="text" name="pinterestapikey" value='.$data['pinterest_apikey'].'/>
<br /><label name="pinterestapisecret">Pinterest API Secret</label>
<br /><input type="text" name="pinterestapisecret" value="'.$data['pinterest_apisecret'].'" />
<br /><label name="pinterestaccesstoken">Pinterest Access Token</label>
<br /><input type="text" name="pinterestaccesstoken" value="'.$data['pinterest_token'].'"/>
<div class="smalltext"><a href="https://developers.pinterest.com/tools/access_token/" title="Get access token here." alt="Get access token here.">Get access token here.</a></div>
<label name="facebookpagename">Pinterest Board for Pinning</label>
<br /><input type="text" name="pinterestboard" value="'.$data['pinterest_board'].'"/>
<input type="hidden" name="pinterestdistinguish" value="1" />
<br /><br /><input class="postsubmit" name="pinterestsubmit" type="submit" value="Submit">
</form>
</div></div>';
	echo '<script>$(';echo"'";echo'input[type="checkbox"]';echo"').change(function(){
    this.value = (Number(this.checked));
	});</script>";
?>