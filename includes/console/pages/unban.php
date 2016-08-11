<?php
	$global = new DB_global;
	$retrive = new DB_retrival;
	$query = $global->sqlquery("SELECT * FROM dd_banlist WHERE banlist_no = '".$_GET['unbanid']."' LIMIT 1");
	$banlist = $query->fetch_assoc();
if ($retrive->isLoggedIn() == true){
	if (empty($_GET['unbanid']) or is_null($banlist['banlist_no'])){
echo consolemenu();
echo '<div id="page"><div class="center">The ban does not exist or has already been unbanned.
<br /><br /><a href="javascript:history.back()" alt="Go back" title="Go back">Go back</a>
</div></div>';
	} else {
echo consolemenu();
define ('POSTPEND', 'Unban');
echo '<div id="page"><div class="center">Are you sure</i>?
<br /><br /><a href="/console/ban/unbanconfirm?unbanid='.$_GET['unbanid'].'" alt="Unban" title="Unban">Yes, I am sure.</a> | <a href="javascript:history.back()" alt="Do not unban" title="Do not unban">No, I am not.</a></div></div>';
	}
} else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>