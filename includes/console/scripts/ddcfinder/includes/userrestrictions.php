<?php function 
restrictpermissionlevel($userlevel){
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