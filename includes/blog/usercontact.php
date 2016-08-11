<?php
$username = explode("/", $_SERVER['REQUEST_URI']);
$global = new DB_global;
$usersetting = $global->sqlquery("SELECT * FROM dd_settings");
$usersetting2 = $usersetting->fetch_assoc();
$userinfo = $global->sqlquery("SELECT * FROM dd_users WHERE user_username = '".$username[1]."'");
$userinfo2 = $userinfo->fetch_assoc();

if ($userinfo2['user_username'] == $username[1] && $usersetting2['contact_users_on'] == '1'){
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
	<input name="emailip" type="hidden" value="'; echo $_SERVER['REMOTE_ADDR']; echo '">
	<br><input type="reset" value="Reset"><input name="emailsubmit" type="submit" value="Submit">';
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
echo '<div class="notfoundpage"><h1>404 file not found</h1>
<p>The requested article or page has either been relocated or does not exist, if you reached this page in error; please consider the following.</p>
<li><b>Heading back:</b> Either to the homepage or retracing your steps, hopefully you will find something there.</li>
<li><b>Checking the location:</b> You might of mistyped something or forgotten to put in a word, try doublechecking to see if you have done exactly that.</li>
<li><b>Checking if the url exists:</b> In that case you might of wanted to check out our 404 page on purpose, in that case; you are an awesome explorer.</li>
<li><b>Using the search bar:</b> It is extremely helpful, it can help you search for pratically anything you would like to search for.</li>

<p>We at Vapourban wish you good luck in getting away fron this 404 page.
<br /><i>-The Management</i></p>';

}
?>