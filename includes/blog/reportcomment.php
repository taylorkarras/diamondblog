<?php
$global = new DB_global;
$check = new DB_check;
$templateinit = $global->sqlquery("SELECT * FROM dd_templates;");
$template = $templateinit->fetch_assoc();
if (isset($_GET['commentid'])){
$_SESSION['info']['comment_id'] = $_GET['commentid'];
}
$reported1 = $global->sqlquery("SELECT * FROM `dd_reports` WHERE report_ip = '".$_SERVER['REMOTE_ADDR']."'");
$reported2 = $global->sqlquery("SELECT * FROM `dd_comments` WHERE comment_reported = '1' AND comment_id = '".$_SESSION['info']['comment_id']."'");

if (isset($_GET['commentid']) && $reported1->num_rows > 0 && $reported2->num_rows > 0){
echo '<h2>Comment already reported!</h2>';
} else if($check->isLoggedIn()) {
echo '<h2>You cannot report comments while logged in!</h2>';
}	else if ($check->ifbanned()){
		echo '<div id="scommentbox">
		You have been blocked from reporting comments.
		<br />
		<br /><b>Reason:</b> <I>'.BANREASON.'</i>
		<br />
		<br /><b>Ban will expire on</b> '.BANEXPIRATION.'</div>';
	}
else if (isset($_GET['commentid'])){
header("X-Robots-Tag: noindex", true);
$_SESSION['info']['comment_id'] = $_GET['commentid'];
echo '<h1>Report Comment</h1>';
echo '<form id="reportcomment2" method="post">
	<label name="rcname">Name:</label>
	<br><input type="text" name="rcname"/>
	<br><br><label name="rcemailaddress">Email address:</label>
	<br><input type="email" name="rcemailaddress"/>
	<br><br><label name="rcmessage">Message:</label>
	<br><textarea id="rcmessage" name="rcmessage"></textarea>';
	if (!isset($_COOKIE["userID"])){
pluginClass::hook( "comment_captcha" );
}
	echo '<br><input type="reset" value="Reset"><input name="rcsubmit" type="submit" value="Submit">';
echo '</form>';
} else {
header("HTTP/2.0 404 Not Found");
define ("PREPEND", '404 Not Found');
echo '<div class="notfoundpage">'.$template['404_message'].'</div>';
}
