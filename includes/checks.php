<?php

class DB_check
{

public function ifbanned() {
	
	$global = new DB_global;
	
	$ipcheck1 = $global->sqlquery("SELECT * FROM `dd_banlist` WHERE banlist_ip = '".$_SERVER['REMOTE_ADDR']."'");
	$ipcheck2 = $ipcheck1->fetch_assoc();
	
	if ($ipcheck2['banlist_ip'] == $_SERVER['REMOTE_ADDR']) {
	define ('BANREASON', $ipcheck2['banlist_reason']);
	define ('BANEXPIRATION', $ipcheck2['banlist_duration']);
	return true;
	}
}

private function ReverseIPOctets($inputip){
$ipoc = explode(".",$inputip);
return $ipoc[3].".".$ipoc[2].".".$ipoc[1].".".$ipoc[0];
}

public function istor(){
if (gethostbyname($this->ReverseIPOctets($_SERVER['REMOTE_ADDR']).".".$_SERVER['SERVER_PORT'].".".$this->ReverseIPOctets($_SERVER['SERVER_ADDR']).".ip-port.exitlist.torproject.org")=="127.0.0.2") {
return true;
} else {
return false;
} 
}


public function ifvotedpositive($id) {
		$global = new DB_global;
	
	$ipcheck1 = $global->sqlquery("SELECT * FROM `dd_votes` WHERE cvote_commentid = '".$id."'");
	$ipcheck2 = $ipcheck1->fetch_assoc();
	
	$commentid1 = $global->sqlquery("SELECT * FROM `dd_comments` WHERE comment_id = '".$id."'");
	$commentid2 = $commentid1->fetch_assoc();
	
	if ($id == $commentid2['comment_id']) {
		if($ipcheck2['cvote_positive'] == '1'){
	define ('VOTED', 'yellow');
	return true;
	}
}
}

public function ifvotednegative($id) {
		$global = new DB_global;
	
	$ipcheck1 = $global->sqlquery("SELECT * FROM `dd_votes` WHERE cvote_commentid = '".$id."'");
	$ipcheck2 = $ipcheck1->fetch_assoc();
	
	$commentid1 = $global->sqlquery("SELECT * FROM `dd_comments` WHERE comment_id = '".$id."'");
	$commentid2 = $commentid1->fetch_assoc();
	
	if ($id == $commentid2['comment_id']) {
		if($ipcheck2['cvote_negative'] == '1'){
	define ('VOTEDN', 'yellow');
	return true;
	}
}
}

public function positivenegativecomb($id, $id2){
			$global = new DB_global;
	
		$math1 = $global->sqlquery("SELECT SUM(`cvote_negative`) AS `totalvotesnegative` FROM `dd_votes` WHERE `cvote_p_id` = '".$id."' AND `cvote_commentid` = '".$id2."'");
		$math2 = $math1->fetch_assoc();
		$math3 = $global->sqlquery("SELECT SUM(`cvote_positive`) AS `totalvotespositive` FROM `dd_votes` WHERE `cvote_p_id` = '".$id."' AND `cvote_commentid` = '".$id2."'");
		$math4 = $math3->fetch_assoc();
		if ($math4['totalvotespositive'] > $math2['totalvotesnegative']){
		$math5 = '+'.$math4['totalvotespositive'];
		} else if ($math2['totalvotesnegative'] > $math4['totalvotespositive']){
		$math5 = '-'.$math2['totalvotesnegative'];
		} else if ($math2['totalvotesnegative'] == $math4['totalvotespositive']){
		$math5 = '0';
		}
		return $math5;
}

public function retrieve_comment_count($postid){
	$global = new DB_global;
$commentcount1 = $global->sqlquery("SELECT comment_postid FROM dd_comments WHERE comment_postid = '".$postid."';");
$commentcount2 = $commentcount1->num_rows;
return $commentcount2;
}

public function email_form1($link){
		$global = new DB_global;
$emailcheck = $global->sqlquery("SELECT page_contactform FROM dd_pages WHERE page_link = '".$link."';");
$emailcheck2 = $emailcheck->fetch_assoc();

if ($emailcheck2['page_contactform'] == '1') {
	echo '<form id="mail" method="post">
	<label name="emailname">Name:</label>
	<br><input type="text" name="emailname"/>
	<br><br><label name="emailsubject">Subject:</label>
	<br><input type="text" name="emailsubject"/>
	<br><br><label name="emailaddress">Email address:</label>
	<br><input type="email" name="emailaddress"/>
	<br><br><label name="emaildestination">Destination:</label>
	<br><select name="emaildestination">';
	$result = $global->sqlquery("SELECT * FROM dd_mailtree;");
	while ($row = $result->fetch_array()){
	echo '<option value="'.$row['mailtree_name'].'">'.$row['mailtree_name'].'</option>';
	}
	echo '</select>
	<br><br><label name="emailmessage">Message:</label>
	<br><textarea id="message" name="emailmessage"></textarea>
	<input name="emailip" type="hidden" value="'; echo $_SERVER['REMOTE_ADDR']; echo '">';
if (!isset($_COOKIE['userID'])){
	pluginClass::hook( "comment_captcha" );
}
	echo '<br /><input type="reset" value="Reset"><input name="emailsubmit" type="submit" value="Submit">';
		echo "<script>    CKEDITOR.replace( 'message', {
    toolbar: [
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
]
});
</script>";
echo '</form>';
}

}
public function ifsubtextenabled() {
	
	$global = new DB_global;
	
	$subtextcheck1 = $global->sqlquery("SELECT subtext_on FROM dd_settings");
	$subtextcheck2 = $subtextcheck1->fetch_assoc();
	
	if ($subtextcheck2['subtext_on'] == '1') {
	return true;
	}
	else {
	return false;
	}
}

public function valid_email($email)
{
 
	// First, we check that there's one @ symbol, and that the lengths are right
	if (!preg_match('/^[^@]{1,64}@[^@]{1,255}$/', $email))
	{
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++)
	{
		if (!preg_match("/^(([A-Za-z0-9!#$%&'*+=?^_`{|}~-][A-Za-z0-9!#$%&'*+=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/",
		$local_array[$i]))
		{
			return false;
		}
	}
	if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1]))
	{ // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2)
		{
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++)
		{
			if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i]))
			{
				return false;
			}
		}
	}
	return true;
}

public function isLoggedIn()
{
$global = new DB_global;
$usercheck1 = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$_COOKIE['userID']."';");
$usercheck2 = $usercheck1->fetch_assoc();
if (isset($_COOKIE['userID']) && isset($_COOKIE['username'])){
    if ($_COOKIE['userID'] == $usercheck2['user_id'] && $_COOKIE['username'] == $usercheck2['user_username']){
        return true; // the user is loged in
    } else
    {
        return false; // not logged in
    }
}

}
public function usercontactenabled()
{
	$global = new DB_global;
		$usercontactinit = $global->sqlquery("SELECT contact_users_on FROM dd_settings LIMIT 1;");
	$usercontact = $usercontactinit->fetch_assoc();
	
if ($usercontact['contact_users_on'] == '1'){
	return true;
}
}

public function ifcommentsclosed($postid)
{
	$global = new DB_global;
		$commentsclosedinit = $global->sqlquery("SELECT content_commentsclosed FROM dd_content WHERE content_id = '".$postid."' LIMIT 1;");
	$commentsclosed = $commentsclosedinit->fetch_assoc();
	
if ($commentsclosed['content_commentsclosed'] == '1'){
	return true;
}
}

}
