<?php
class DB_retrival {
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
	public function usersubtext($userid)
{
	$global = new DB_global;
	$query = "SELECT user_subtext FROM dd_users WHERE user_id = '".$userid."';";
	
	$subtextinit = $global->sqlquery($query);
	$subtext = $subtextinit->fetch_assoc();
	return $subtext['user_subtext'];
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
	public function email($userid)
{
	$global = new DB_global;
	$query = "SELECT user_email FROM dd_users WHERE user_id = '".$userid."';";
	
	$mailinit = $global->sqlquery($query);
	$mail = $mailinit->fetch_assoc();
	return $mail['user_email'];
}

}