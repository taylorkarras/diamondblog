<?php
	$global = new DB_global;
	$retrive = new DB_retrival;
	$userfunc = new DB_userfunctions;
if ($retrive->isLoggedIn() == true){
		$usercheck1 = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$_COOKIE["userID"]."';");
		$usercheck2 = $usercheck1->fetch_assoc();
	if ($usercheck2['user_isadmin'] == '1'){
	if (strpos($_SERVER['REQUEST_URI'], 'console/users/new')){
echo consolemenu();
echo '<div id="page"><div class="center">Create New User';
echo '<form id="createuser" method="post">
<label title="username"><b>Username:</b></label>
<br /><input type="text" name="username">
<br /><br /><label title="useremail"><b>Email:</b></label>
<br /><input type="text" name="useremail">
<br /><br /><label title="userlevel"><b>User Level:</b></label>
<br /><select id="userlevel" name="userlevel">';
	echo '<option value="admin">Administrator</option>';
	echo '<option value="contrib">Contributor</option>';
	echo '<option value="mod">Moderator</option>';
echo '</select>
<input type="hidden" name="userpassword" value="'.$userfunc->random_password().'" >';
echo '<br /><br /><input class="postsubmit" name="usersubmit" type="submit" value="Submit">';
echo '<label><b>Notes:</b></label>
<li>Password is generated automatically.</li>
<li>User details is sent to email specified.</li>
<li>Moderators can only moderate comments.</li>
</form>';
echo '</div>';
	}
	
	if (!empty($_GET["userid"])){
		$edituser1 = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$_GET["userid"]."';");
		$edituser2 = $edituser1->fetch_assoc();
		$edituser3 = $global->sqlquery("SELECT subtext_on FROM dd_settings");
		$edituser4 = $edituser3->fetch_assoc();
		
echo consolemenu();
echo '<div id="page"><div class="center">Edit User ('.$retrive->realname($_GET['userid']).')';
echo '<form id="edituser" method="post">
<label title="userrealname"><b>Real name:</b></label>
<br /><input type="text" name="userrealname" value="'.$edituser2['user_realname'].'">
<br /><br /><label title="userlocation"><b>User location:</b></label>
<br /><input type="text" name="userlocation" value="'.$edituser2['user_location'].'">';
define ('POSTPEND', 'Edit User: '.$retrive->realname($_GET['userid']));
echo '<br /><br /><label title="useremail"><b>Your email:</b></label>
<br /><input type="text" name="useremail" value="'.$edituser2['user_email'].'">';
echo '<br /><br /><label title="userdescription"><b>Describe yourself:</b></label>
<br /><textarea  class="ckeditor" name="userdescription">'.$edituser2['user_description'].'</textarea>';
if ($edituser4['subtext_on'] == '1'){
echo '<br /><label title="usersubtext"><b>Describe yourself in a few words:</b></label>
<br /><textarea  id="comment" name="usersubtext">'.$edituser2['user_subtext'].'</textarea>';
}
if ($_GET['userid'] !== '1'){
echo '<br /><label title="userlevel"><b>User Level:</b></label>
<br /><select id="userlevel" name="userlevel">';
	echo '<option value="admin">Administrator</option>';
	echo '<option value="contrib">Contributor</option>';
	echo '<option value="mod">Moderator</option>';
echo '</select>';
if (!empty($_GET["userid"])){
	echo '<script>window.onload = function(){document.getElementById("userlevel").value = "'.$retrive->permissionlevel($_GET['userid']).'";
	}</script>';
}
echo '<div class="sitescrolling">
<br /><input type="checkbox" name="closedaccount"';
if ($edituser2['user_closedaccount'] == '1')
{ echo' value="1" checked';}
else { echo ' value="0"';}echo '> Closed account';
echo '</div>';
}
echo '<br /><br /><label name="userpasswordchange1"><b>Change password:</b></label>
<br /><input type="password" name="userpasswordchange1">
<br /><br /><label name="userpasswordchange2"><b>Repeat password:</b></label>
<br /><input type="password" name="userpasswordchange2"><br />';
if ($_GET['userid'] !== '1'){
echo '<div class="sitescrolling">
<br /><input type="checkbox" name="sendpassword"> Send new password to email.<br>';
	echo '<script>$(';echo"'";echo'input[type="checkbox"]';echo"').change(function(){
    this.value = (Number(this.checked));
	});</script>";
echo '</div>';
}
echo '<input type="hidden" name="useridtoedit" value="'.$_GET["userid"].'"';
echo '<br /><br /><input class="postsubmit" name="usersubmit" type="submit" value="Submit">';
echo '</form>';
echo '</div>';
echo "<script>    CKEDITOR.replace( 'comment', {
    toolbar: [
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
]
});
</script>";
}
}else if ($_GET["userid"] == $_COOKIE['userID']){
			$edituser1 = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$_GET["userid"]."';");
		$edituser2 = $edituser1->fetch_assoc();
		$edituser3 = $global->sqlquery("SELECT subtext_on FROM dd_settings");
		$edituser4 = $edituser3->fetch_assoc();
	
echo consolemenu();
echo '<div id="page"><div class="center">Edit User ('.$retrive->realname($_GET['userid']).')';
echo '<form id="edituser" method="post">';

if ($retrive->restrictpermissionlevel('1')){
echo '<label title="userrealname"><b>Real name:</b></label>
<br /><input type="text" name="userrealname" value="'.$edituser2['user_realname'].'">
<br /><br /><label title="userlocation"><b>User location:</b></label>
<br /><input type="text" name="userlocation" value="'.$edituser2['user_location'].'">';
}
if ($_COOKIE['userID'] == $_GET['userid']){
define ('POSTPEND', 'Edit User: '.$retrive->realname($_GET['userid']));
echo '<br /><br /><label title="useremail"><b>Your email:</b></label>
<br /><input type="text" name="useremail" value="'.$edituser2['user_email'].'">';
}
if ($retrive->restrictpermissionlevel('1')){
echo '<br /><br /><label title="userdescription"><b>Describe yourself:</b></label>
<br /><textarea  class="ckeditor" name="userdescription">'.$edituser2['user_description'].'</textarea>';
if ($edituser4['subtext_on'] == '1'){
echo '<br /><label title="usersubtext"><b>Describe yourself in a few words:</b></label>
<br /><textarea  id="comment" name="usersubtext">'.$edituser2['user_subtext'].'</textarea>';
}
}
if ($_GET['userid'] !== '1'){
if ($retrive->restrictpermissionlevel('3')){
	} else {
echo '<br /><label title="userlevel"><b>User Level:</b></label>
<br /><select id="userlevel" name="userlevel">';
	echo '<option value="admin">Administrator</option>';
	echo '<option value="contrib">Contributor</option>';
	echo '<option value="mod">Moderator</option>';
echo '</select>';
if (!empty($_GET["userid"])){
	echo '<script>window.onload = function(){document.getElementById("userlevel").value = "'.$retrive->permissionlevel($_GET['userid']).'";
	}</script>';
}
}
}
echo '<br /><br /><label name="userpasswordchange1"><b>Change password:</b></label>
<br /><input type="password" name="userpasswordchange1">
<br /><br /><label name="userpasswordchange2"><b>Repeat password:</b></label>
<br /><input type="password" name="userpasswordchange2"><br />';
echo '<input type="hidden" name="useridtoedit" value="'.$_GET["userid"].'"';
echo '<br /><br /><input class="postsubmit" name="usersubmit" type="submit" value="Submit">';
echo '</form>';
echo '</div>';
echo "<script>    CKEDITOR.replace( 'comment', {
    toolbar: [
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
]
});
</script>";
}
} else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>
