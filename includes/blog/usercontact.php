<?php
$username = explode("/", $_SERVER['REQUEST_URI']);
$global = new DB_global;
$templateinit = $global->sqlquery("SELECT * FROM dd_templates;");
$template = $templateinit->fetch_assoc();
$usersetting = $global->sqlquery("SELECT * FROM dd_settings");
$usersetting2 = $usersetting->fetch_assoc();
$userinfo = $global->sqlquery("SELECT * FROM dd_users WHERE user_username = '".$username[1]."'");
$userinfo2 = $userinfo->fetch_assoc();

if ($userinfo2['user_username'] == $username[1] && $usersetting2['contact_users_on'] == '1'){
header("X-Robots-Tag: noindex", true);
pluginClass::hook( "user_contact" );
echo '<h1>Contact '.$userinfo2['user_realname'].'</h1>';
echo '<form id="mail" method="post">
	<label name="emailname">Name:</label>
	<br><input type="text" name="emailname"/>
	<br><br><label name="emailsubject">Subject:</label>
	<br><input type="text" name="emailsubject"/>
	<br><br><label name="emailaddress">Email address:</label>
	<br><input type="email" name="emailaddress"/>
	<input type="hidden" value="'.$userinfo2['user_username'].'" name="emaildestination">
	<br><br><label name="emailmessage">Message:</label>
	<br><textarea id="message" name="emailmessage"></textarea>
	<input name="emailip" type="hidden" value="'; echo $_SERVER['REMOTE_ADDR']; echo '">';
	if (!isset($_COOKIE["userID"])){
pluginClass::hook( "comment_captcha" );
}
	echo '<br><input type="reset" value="Reset"><input name="emailsubmit" type="submit" value="Submit">';
		echo "<script>    CKEDITOR.replace( 'message', {
    toolbar: [
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
]
});
</script>";
echo '</form>';
} else {
header("HTTP/2.0 404 Not Found");
define ("PREPEND", '404 Not Found');
echo '<div class="notfoundpage">'.$template['404_message'].'</div>';
}
?>
