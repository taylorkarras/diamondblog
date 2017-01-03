<?php
class DB_retrival {
public function isLoggedIn()
{
$global = new DB_global;
if (isset($_COOKIE['userID']) && isset($_COOKIE['username'])){
$usercheck1 = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$_COOKIE['userID']."';");
$usercheck2 = $usercheck1->fetch_assoc();
    if ($_COOKIE['userID'] == $usercheck2['user_id'] && $_COOKIE['username'] == $usercheck2['user_username']){
        return true; // the user is loged in
    } else
    {
        return false; // not logged in
    }
}
}

public function isactive($page){
	if(strpos($_SERVER['REQUEST_URI'], $page)){
		return 'class="active"';
	}
}

public function checkLogin($u, $p, $rv)
{
 $global = new DB_global;
 $userfunc = new DB_userfunctions;
    if (!$userfunc->valid_username($u) || !$userfunc->valid_password($p) || !$userfunc->user_exists($u))
    {
        return false; // the name was not valid, or the password, or the username did not exist
    }
 
    //Now let us look for the user in the database.
    $query = sprintf("
		SELECT user_id
		FROM dd_users 
		WHERE 
		user_username = '$u'
		LIMIT 1;");
		
    $result = $global->sqlquery($query);
    // If the database returns a 0 as result we know the login information is incorrect.
    // If the database returns a 1 as result we know  the login was correct and we proceed.
    // If the database returns a result > 1 there are multple users
    // with the same username and password, so the login will fail.
    if (mysqli_num_rows($result) != 1)
    {
        return false;
    } else
    {
        // Login was successfull
        $row = mysqli_fetch_array($result);
		
		$passwordr = $global->sqlquery("
		SELECT user_password
		FROM dd_users
		WHERE
		user_username = '$u'
		LIMIT 1;");
$password = $passwordr->fetch_assoc();
		if (password_verify($p, $password['user_password'])){
        if($rv == '1'){
		// Save the user ID for use later
		setcookie('userID', $row['user_id'], time()+31536000,"/");
        // Save the username for use later
        setcookie('username', $u, time()+31536000,"/");
		// Now we show the userbox
		return true;
		}else{
		// Save the user ID for use later
        setcookie('userID', $row['user_id'], time()+86400,"/");
        // Save the username for use later
        setcookie('username', $u, time()+86400,"/");
        // Now we show the userbox
        return true;
		}
	}
	else {
		return false;
	}
    }
    return false;
}

public function permissionlevel($userid){
$global = new DB_global;
		$query = "SELECT * FROM dd_users WHERE user_id = '".$userid."';";
	$plinit = $global->sqlquery($query);
		
	$pl = $plinit->fetch_assoc();
	if ($pl['user_isadmin'] == '1'){
	return 'admin';
	} else if ($pl['user_iscontributor'] == '1'){
	return 'contrib';
	} else if ($pl['user_ismod'] == '1'){
	return 'mod';
	}
}

public function restrictpermissionlevel($userlevel){
$global = new DB_global;
		$query = "SELECT * FROM dd_users WHERE user_id = '".$_COOKIE['userID']."';";
	$plinit = $global->sqlquery($query);
		
	$pl = $plinit->fetch_assoc();
	if ($userlevel === '1' && $pl['user_iscontributor'] === '1'){
	return true;
	} else if ($userlevel === '2' && $pl['user_ismod'] === '1'){
	return true;
	} else if ($userlevel === '3' && $pl['user_ismod'] === '1' or $userlevel === '3' && $pl['user_iscontributor'] === '1'){
	return true;
	} else {
	return false;
	}
}

public function postsperpage()
{
	$global = new DB_global;
		$query = "SELECT postsperpage FROM dd_settings;";
	$pppinit = $global->sqlquery($query);
		
	$ppp = $pppinit->fetch_assoc();
	return $ppp['postsperpage'];}

	function dropdown_category_list()
{
	$global = new DB_global;
	$result = $global->sqlquery("SELECT * FROM dd_categories;");
	while ($row = $result->fetch_array()){
	return '<option value="'.$row['category_name'].'">'.$row['category_name'].'</option>';
	}
}

public function numberofposts()
{
	$global = new DB_global;
		$query = "SELECT * FROM dd_content;";
	$nopinit = $global->sqlquery($query);
		
	$nop = $nopinit->num_rows;
	return $nop;}
	
public function numberofreports()
{
	$global = new DB_global;
		$query = "SELECT * FROM dd_reports;";
	$norinit = $global->sqlquery($query);
		
	$nor = $norinit->num_rows;
	return $nor;}
	
public function commentsawaitingapproval()
{
	$global = new DB_global;
		$query = "SELECT * FROM dd_comments WHERE comment_approved = '0';";
	$norinit = $global->sqlquery($query);
		
	$nor = $norinit->num_rows;
	return $nor;}
	
public function numberofusers()
{
	$global = new DB_global;
		$query = "SELECT * FROM dd_users;";
	$nouinit = $global->sqlquery($query);
		
	$nou = $nouinit->num_rows;
	return $nou;}
	
public function userstatus($username)
{
	$global = new DB_global;
		$query = "SELECT * FROM dd_users WHERE user_username = '".$username."';";
	$statusinit = $global->sqlquery($query);
		
	$status = $statusinit->fetch_array();
	if ($status['user_isadmin'] == '1'){
		return 'Administrator';
	} else if ($status['user_iscontributor'] == '1'){
		return 'Contributor';
	} else if ($status['user_ismod'] == '1'){
		return 'Moderator';
	}
	}
	public function realname($userid)
{
	$global = new DB_global;
	$query = "SELECT user_realname FROM dd_users WHERE user_id = '".$userid."';";
	$query2 = "SELECT user_username FROM dd_users WHERE user_id = '".$userid."';";
	
	$realnameinit = $global->sqlquery($query);
	$realname = $realnameinit->fetch_assoc();
	if ($realname['user_realname'] == '')
	{
	$usernameinit = $global->sqlquery($query2);
	$username = $usernameinit->fetch_assoc();
	return $username['user_username'];
	} else {
	return $realname['user_realname'];
	}
}
	public function userid($name)
{
	$global = new DB_global;
	$query = "SELECT user_id FROM dd_users WHERE user_realname = '".$name."';";
	$query2 = "SELECT user_id FROM dd_users WHERE user_username = '".$name."';";
	
	$realnameinit = $global->sqlquery($query);
	$realname = $realnameinit->fetch_assoc();
	if ($realname['user_id'] == '')
	{
	$usernameinit = $global->sqlquery($query2);
	$username = $usernameinit->fetch_assoc();
	return $username['user_id'];
	} else {
	return $realname['user_id'];
	}
}

	public function username($userid)
{
	$global = new DB_global;
	$query = "SELECT user_username FROM dd_users WHERE user_id = '".$userid."';";
	
	$usernameinit = $global->sqlquery($query);
	$username = $usernameinit->fetch_assoc();
	return $username['user_username'];
}

	public function ismailenabled()
{
	$global = new DB_global;
	$query = "SELECT * FROM dd_mail;";
	
	$mailinit = $global->sqlquery($query);
	$mail = $mailinit->fetch_assoc();
	if ($mail['mail_inuse'] == '1'){
	return true;
}
	}
	public function isftpenabled()
{
	$global = new DB_global;
	$query = "SELECT * FROM dd_storage;";
	
	$ftpinit = $global->sqlquery($query);
	$ftp = $ftpinit->fetch_assoc();
	if ($ftp['ftp_inuse'] == '1'){
	return true;
} else {
	return false;
}
	}
	
public function canrecievecommentemails($userid){
$global = new DB_global;
$ifemailable = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$userid."'");
$ifemailable2 = $ifemailable->fetch_assoc();

	if ($ifemailable2['user_commentsnotify'] == '1' && $ifemailable2['user_closedaccount'] !== '1'){
		return true;
	}
}

	public function email($userid)
{
	$global = new DB_global;
	$query = "SELECT user_email FROM dd_users WHERE user_id = '".$userid."';";
	
	$mailinit = $global->sqlquery($query);
	$mail = $mailinit->fetch_assoc();
	return $mail['user_email'];
}
	
}
?>
