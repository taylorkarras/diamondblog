<?php
$global = new DB_global;
$check = new DB_check;
$retrive = new DB_retrival;
$templateinit = $global->sqlquery("SELECT * FROM dd_templates;");
$template = $templateinit->fetch_assoc();
$userinfo3 = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$_COOKIE['userID']."' LIMIT 1");
$userinfo4 = $userinfo3->fetch_assoc();
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/plugins.php';
pluginClass::initialize();
	echo '<head>';
themestyle();
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="mobile-web-app-capable" content="yes">';
echo'<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/jquery-2.2.3.min.js"></script>
<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/ckeditor/ckeditor.js"></script>
<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/ckeditor/adapters/jquery.js"></script>
<script>
    var CKEDITOR_BASEPATH = "/scripts/ckeditor/";
</script>
<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/jquery.jscroll.min.js"></script>
';
echo '
<style>
body {
width: auto !important;
background-color: transparent !important;
}

.cke {
color: #000000 !important;
font-family: "Arial" !important;
}
</style>';
echo '</head>';
	navigation();
	if (isset($_GET["page"])) { $page  = $_GET["page"];
$link = str_replace('?page='.$_GET["page"], '', $link);	} else { $page=1; }; 
echo '<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/diamondblog-func.js"></script>';
pluginClass::hook( "ampcomments_captcha" );
	echo '<div class="postcomment">Comments (';echo $check->retrieve_comment_count($_GET['postid']); echo')'; echo'</div>';
		if ($check->ifcommentsclosed($_GET['postid'])){
	} else if ($check->ifbanned()){
	} else {
	echo '<h3 class="commentinvite">Leave a comment!</h3>';
	}
	echo '<div id="comments"></div>';
	if ($check->ifcommentsclosed($_GET['postid'])){
	echo '<h3 class="commentinvite">Comments are closed.</h3><br />';
	} else if ($check->ifbanned()){
		echo '<div id="scommentbox">
		You have been blocked from commenting and voting on comments.
		<br />
		<br /><b>Reason:</b> <I>'.BANREASON.'</i>
		<br />
		<br /><b>Ban will expire on</b> '.BANEXPIRATION.'</div>';
	} else if ($check->isLoggedIn()){
		
$userinfo3 = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$_COOKIE['userID']."' LIMIT 1");
$userinfo4 = $userinfo3->fetch_assoc();
		
	echo '
	<form method="post" id="postcomment">
	<big>You are logged in as '.$retrive->realname($_COOKIE['userID']).'.</big>
	<input name="commentname" type="hidden" value="'.$retrive->realname($_COOKIE['userID']).'"/>
	<input name="commentemail" type="hidden" value="'.$userinfo4['user_email'].'"/>
	<br /><br /><label for="commentcontent"><div class="commentcontentheader"><b>Comment:</b></div></label>
	<textarea name="commentcontent" id="commentcontent requiredField"/></textarea>';
	echo "<script>    CKEDITOR.replace( 'commentcontent', {
	customConfig: 'custom/config.js',
    toolbar: [
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: ['selection'], items: ['SelectAll'] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
]
});
</script>";
	echo '<input name="commentreply" id="cr-v" type="hidden" value="0">';
	echo '<input name="commentreplyto" id="crt-id" type="hidden" value="0">';
	echo '<input name="commentip" type="hidden" value="'; echo $_SERVER['REMOTE_ADDR']; echo '">';
	echo '<br /><br /><input name="commentsubmit" type="submit" value="Post comment"/>
	</form>';
	echo '<div id="commentwarning">'.$template['comment_notification_message'].'</div>';
	}
	else {
	echo '
	<form method="post" id="postcomment">
	<div class="commentcontentheader">
	<label for="commentname"><b>Name:</b></label></div>
	<input name="commentname" type="text" class="txtarea requiredField"/>
	<br /><br /><div class="commentcontentheader"><label for="commentemail"><b>Email:</b></label></div>
	<input name="commentemail" type="email" class="txtarea requiredField"/>
	<br /><br /><label for="commentcontent"><div class="commentcontentheader"><b>Comment:</b></div></label>
	<textarea name="commentcontent" id="commentcontent requiredField"/></textarea>';
	echo "<script>    CKEDITOR.replace( 'commentcontent', {
	customConfig: 'custom/config.js',
    toolbar: [
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: ['selection'], items: ['SelectAll'] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
]
});
</script>";
        echo '<input name="commentreply" id="cr-v" type="hidden" value="0">';
        echo '<input name="commentreplyto" id="crt-id" type="hidden" value="0">';
	echo '<input name="commentip" type="hidden" value="'; echo $_SERVER['REMOTE_ADDR']; echo '">';
pluginClass::hook( "comment_captcha" );
	echo '<br /><br /><input name="commentsubmit" type="submit" value="Post comment"/>
	</form>';
	echo '<div id="commentwarning">'.$template['comment_notification_message'].'</div>';
	}
	
	//Comments display
	
	$commentsperpageinit = $global->sqlquery("SELECT commentsperpage FROM dd_settings LIMIT 1;");
	$commentsperpage = $commentsperpageinit->fetch_assoc();
	$cpp = $commentsperpage['commentsperpage'];
	$start_from = ($page-1) * $cpp;
	
	$comments = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_isreply = '0' AND comment_postid LIKE '".$_GET['postid']."' LIMIT $start_from, $cpp");
	$comments2 = $global->sqlquery("SELECT COUNT(*) FROM dd_comments WHERE comment_postid LIKE '".$_GET['postid']."'");
	$row2 = $comments2->fetch_row(); 
	$total_records = $row2[0];
	
	$result = $global->sqlquery("SELECT * FROM dd_content ORDER BY content_date DESC LIMIT $start_from, $ppp;");
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_content");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $cpp);

echo '<div class="contentpostscroll">';

	if ($comments->num_rows > 0) {
    // output data of each row
	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $cpp - '1';
	}
    while($rowcomments = $comments->fetch_assoc()) {
		// Comments
		echo '<div id="comment_'.$rowcomments['comment_id'].'" class="commentbox">';
		// Vote
		echo '<div class="commentvote">';
		if ($check->ifbanned() or $check->istor()){
		}else{
		echo '<a href="/votecomment?postid='.$_GET['postid'].'&commentid='.$rowcomments['comment_id'].'&vote=positive" style="color:';if ($check->ifvotedpositive($rowcomments['comment_id'])){
		echo VOTED;}else {
		echo 'green';}
		echo '"  alt="Upvote this comment!" title="Upvote this comment!">?</a><br />';
		}echo '<div style="text-align:center">'.$check->positivenegativecomb($_GET['postid'], $rowcomments['comment_id']).'</div>';
		if ($check->ifbanned() or $check->istor()){
		}else{
		echo '<a href="/votecomment?postid='.$_GET['postid'].'&commentid='.$rowcomments['comment_id'].'&vote=negative" style="color:';if ($check->ifvotednegative($rowcomments['comment_id'])){
		echo VOTEDN;}else {
		echo 'red';}
		echo '" alt="Downvote this comment!" title="Downvote this comment!">?</a>';
		}
		echo '</div>';
		echo '<div class="commentnumber">#'.$count.'</div>';
		if ($rowcomments['comment_isfromadmin'] == '1'){
		echo '<div class="commentname"><a style="color:#00ff2b; text-decoration:none;" href="/'.$retrive->username($rowcomments['comment_userid']).'" title="'.$rowcomments['comment_username'].'" alt ="'.$rowcomments['comment_username'].'">'.$rowcomments['comment_username'].'</a></div>';
		} else if ($rowcomments['comment_isfromcontributor'] == '1'){
		echo '<div class="commentname"><a style="color:#ff0000; text-decoration:none;" href="/'.$retrive->username($rowcomments['comment_userid']).'" title="'.$rowcomments['comment_username'].'" alt ="'.$rowcomments['comment_username'].'">'.$rowcomments['comment_username'].'</a></div>';
		} else {
		echo '<div class="commentname">'.$rowcomments['comment_username'].'</div>';
		}
		echo '<div class="commentdate">'.$rowcomments['comment_date'];
		if ($check->ifbanned()){
		}else{
			
			if ($rowcomments['comment_reported'] == '1'){
			echo ' - <b>Comment Reported</b> | ';}
			else {
			echo
		' - <a href="/reportcomment?id='.$rowcomments['comment_id'].'&ip='.$_SERVER['REMOTE_ADDR'].'" alt="Report Comment" title="Report Comment">Report</a> | ';
		} echo '<a href="#postcomment" onclick="document.getElementById(';echo "'"; echo 'cr-v'; echo"'"; echo').value = 1; document.getElementById(';echo "'"; echo 'crt-id'; echo"'"; echo').value = '.$rowcomments['comment_id'].';document.getElementById('; echo "'";echo '#postcomment';echo "'"; echo').scrollIntoView();" alt="Reply" title="Reply to this comment.">Reply</a></div>';
		}
		echo '<div class="commentcontent2">'.$rowcomments['comment_content'].'</div>';
		echo '</div>';
		// Replies //
		$commentreplies = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_isreply = '1' AND comment_replyto LIKE '".$rowcomments['comment_id']."' ORDER BY comment_date DESC;");
	if ($commentreplies->num_rows > 0) {
		echo '<div id="commentreplies">';
		echo '<h2>Replies to this comment:</h2>';
		$replycount = '1';
		    while($rowcommentreplies = $commentreplies->fetch_assoc()) {
				echo '<div id="comment_'.$rowcommentreplies['comment_id'].'" class="commentboxreply">';
						// Vote
		echo '<div class="commentvote">';
		if ($check->ifbanned()){
		}else{
		echo '<a href="/votecomment?postid='.$_GET['postid'].'&commentid='.$rowcommentreplies['comment_id'].'&vote=positive" style="color:';if ($check->ifvotedpositive($rowcommentreplies['comment_id'])){
		echo VOTED;}else {
		echo 'green';}
		echo '"  alt="Upvote this comment!" title="Upvote this comment!">?</a><br />';
		}echo '<div style="text-align:center">'.$check->positivenegativecomb($_GET['postid'], $rowcommentreplies['comment_id']).'</div>';
		if ($check->ifbanned()){
		}else{
		echo '<a href="/votecomment?postid='.$_GET['postid'].'&commentid='.$rowcommentreplies['comment_id'].'&vote=negative" style="color:';if ($check->ifvotednegative($rowcommentreplies['comment_id'])){
		echo VOTEDN;}else {
		echo 'red';}
		echo '" alt="Downvote this comment!" title="Downvote this comment!">?</a>';
		}
		echo '</div>';
		echo '<div class="commentreplynumber">#'.$replycount.'</div>';
		if ($rowcommentreplies['comment_isfromadmin'] == '1'){
		echo '<div class="commentname"><a style="color:#00ff2b; text-decoration:none;" href="/'.$retrive->username($rowcommentreplies['comment_userid']).'" title="'.$rowcommentreplies['comment_username'].'" alt ="'.$rowcommentreplies['comment_username'].'">'.$rowcommentreplies['comment_username'].'</a></div>';
		} else if ($rowcommentreplies['comment_isfromcontributor'] == '1'){
		echo '<div class="commentname"><a style="color:#ff0000; text-decoration:none;" href="/'.$retrive->username($rowcommentreplies['comment_userid']).'" title="'.$rowcommentreplies['comment_username'].'" alt ="'.$rowcommentreplies['comment_username'].'">'.$rowcommentreplies['comment_username'].'</a></div>';
		} else {
		echo '<div class="commentname">'.$rowcommentreplies['comment_username'].'</div>';
		}
		echo '<div class="commentdate">'.$rowcommentreplies['comment_date'];
		if ($check->ifbanned()){
		}else{
			
			if ($rowcommentreplies['comment_reported'] == '1'){
			echo ' - <b>Comment Reported</b></div>';}
			else {
			echo
		' - <a href="/reportcomment?id='.$rowcommentreplies['comment_id'].'&ip='.$_SERVER['REMOTE_ADDR'].'" alt="Report Comment" title="Report Comment">Report</a></div>';
		}
		}
		echo '<div class="commentcontent2">'.$rowcommentreplies['comment_content'].'</div>';
		echo '</div>';
			$replycount++;}
	}
				
		$count++;
	}
}
echo $totalpages;
echo pagebar($page, $total_pages, $cpp, '5', '1');
echo '</div>';
exit;