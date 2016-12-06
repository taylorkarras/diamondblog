<?php
$global = new DB_global;
$check = new DB_check;
$retrive = new DB_retrival;
$postsperpageinit = $global->sqlquery("SELECT * FROM dd_settings;");
$postsperpage = $postsperpageinit->fetch_assoc();
$templateinit = $global->sqlquery("SELECT * FROM dd_templates;");
$template = $templateinit->fetch_assoc();

$link = str_replace("/", "", $_SERVER['REQUEST_URI']);

$arepageson1 = $global->sqlquery("SELECT pages_on FROM dd_settings LIMIT 1");
$arepageson2 = $arepageson1->fetch_assoc();

	if (isset($_GET["page"])) { $page  = $_GET["page"];
$link = str_replace('?page='.$_GET["page"], '', $link);	} else { $page=1; };  

if($arepageson2['pages_on'] == '1'){
$resultpage = $global->sqlquery("SELECT * FROM dd_pages WHERE page_link = '$link' LIMIT 1");
$resultpage2 = $resultpage->fetch_assoc();
}
$resultpost = $global->sqlquery("SELECT * FROM dd_content WHERE content_permalink = '$link' LIMIT 1");
$resultpost2 = $resultpost->fetch_assoc();
$resultpost3 = $global->sqlquery("SELECT * FROM dd_content WHERE content_shortlink = '$link' LIMIT 1");
$resultpost4 = $resultpost3->fetch_assoc();

$userinfo = $global->sqlquery("SELECT * FROM dd_users WHERE user_username = '$link' LIMIT 1");
$userinfo2 = $userinfo->fetch_assoc();

if (!is_null($resultpage2['page_link'])){
			define ("PREPEND", $resultpage2['page_title']);
pluginClass::hook( "page_top" );
	echo '<div class="contentpage">';echo $resultpage2['page_content'];
	
	$check->email_form1($link);
	
	echo '</div>';
} else if($userinfo2['user_username'] == $link && $userinfo2['user_isadmin'] == '1' or $userinfo2['user_iscontributor'] == '1'){
header("X-Robots-Tag: noindex", true);
echo '<div id="userinfo"><h1>'.$userinfo2['user_realname'].'</h1>
<small>(';
if ($userinfo2['user_isadmin'] == '1')
{echo 'Administrator';}
if ($userinfo2['user_iscontributor'] == '1')
{echo 'Contributor';}
echo ')

<br /><br /><li>Location: '.$userinfo2['user_location'].'</li>';
if ($check->usercontactenabled() == true){
echo '<li><a href="/'.$userinfo2['user_username'].'/contact" rel="nofollow" title="Contact" alt="Contact">Contact</a></li>';
echo '<li><a href="/author?name='.$userinfo2['user_username'].'" rel="nofollow" title="All articles by this author" alt="All articles by this author">All articles by this author</a></li>';
}
echo '
<h2>About Me:</h2>
'.$userinfo2['user_description'].'</div>';
}

else if(strpos($_SERVER['REQUEST_URI'], $resultpost4['content_shortlink'])){
header('Location: https://'.$_SERVER['HTTP_HOST'].'/'.$resultpost4['content_permalink']);
}else if(!is_null($resultpost2['content_permalink'])){
pluginClass::hook( "post_top" );
$resultpost = $global->sqlquery("SELECT * FROM dd_content WHERE content_permalink = '$link' LIMIT 1");
    while($row = $resultpost->fetch_assoc()) {
		define ("PREPEND", $row['content_title']);
		$date=date_create($row['content_date']);
		// Title
        echo '<div class="contenttitle">';echo $row['content_title']; echo '</div>';
		// Date
		echo '<div class="contentdate">Posted on '.date_format($date, $postsperpage['date_format']." ".$postsperpage['time_format']).' by '.$retrive->realname($row['content_author']).'</div>';
		// Post
pluginClass::hook( "post_contenttop_1" );
		echo '<div class="contentpost">';echo $row['content_embedcode'];
		echo '<br />';
pluginClass::hook( "post_contenttop_2" );
		echo $row['content_description']; echo '</div>';
pluginClass::hook( "post_contentbottom" );
		// Category
		echo '<div class="contentcategory">Categorized under: <a href="/?cat=';
		$catlowcase = strtolower($row['content_category']);
		echo $catlowcase;
		echo '" rel="nofollow" alt="'; echo $row['content_category']; echo '" title="'; echo $row['content_category']; echo'">'; echo $row['content_category']; echo '</div></a>';
		// Tags
		echo '<div class="contenttags">Tags: ';
		$tags = explode (", ", $row['content_tags']);
		foreach ($tags as $tag) {
			echo '<a href="/tag?name=';
		$taglowcase = strtolower($tag);
		echo $taglowcase;
		echo '" rel="nofollow" alt="'; echo $tag; echo '" title="'; echo $tag; echo'">'; echo $tag; echo '</a> ';
		}
		echo '</div>';
		
		//Subtext Box
		if ($check->ifsubtextenabled() == true){
			
			$subtextcheck = $global->sqlquery("SELECT user_subtext FROM dd_users WHERE user_id = '".$row['content_author']."'");
			$subtextcheck2 = $subtextcheck->fetch_assoc();
			if (!empty($subtextcheck2['user_subtext'])){
			
			$subtext1 = $global->sqlquery("SELECT * FROM dd_users WHERE user_id = '".$row['content_author']."'");
			$subtext2 = $subtext1->fetch_assoc();
			echo '<div id="subtextbox"><h2>About '.$retrive->realname($row['content_author']).'</h2>
			<p>'.$retrive->usersubtext($row['content_author']).'</p>
			<a href="/'.$retrive->username($row['content_author']).'" title="Read more!" alt="Read more!">Read more...</a></div>';
			}
		}
		
			echo "<script>if(window.location.hash){
				var url = window.location.href;
				var id = url.substring(url.indexOf('#')+1);	document.getElementById(id).scrollIntoView(true);
			}</script>";
pluginClass::hook( "post_bottom" );
				// Comments
		echo '<div class="postcomment">Comments (';echo $check->retrieve_comment_count($row['content_id']); echo')'; echo'</div>';
    }
	$post_id = $global->sqlquery("SELECT content_id FROM dd_content WHERE content_permalink LIKE '$link'");
	$post_id_init = $post_id->fetch_assoc();
	$the_post_id = $post_id_init['content_id'];
	if ($check->ifcommentsclosed($the_post_id)){
	} else if ($check->ifbanned()){
	} else {
	echo '<h3 class="commentinvite">Leave a comment!</h3>';
	}
	echo '<div id="comments"></div>';
	if ($check->ifcommentsclosed($the_post_id)){
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
    toolbar: [
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
]
});
</script><style>
.cke {
margin-top: 15px;
}
</style>";
	echo '<input name="commentreply" id="cr-v" type="hidden" value="0">';
	echo '<input name="commentreplyto" id="crt-id" type="hidden" value="0">';
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
    toolbar: [
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
]
});
</script>";
        echo '<input name="commentreply" id="cr-v" type="hidden" value="0">';
        echo '<input name="commentreplyto" id="crt-id" type="hidden" value="0">';
pluginClass::hook( "comment_captcha" );
	echo '<br /><br /><input name="commentsubmit" type="submit" value="Post comment"/>
	</form>';
	echo '<div id="commentwarning">'.$template['comment_notification_message'].'</div>';
	}
	//Comments display
	
	$post_id = $global->sqlquery("SELECT content_id FROM dd_content WHERE content_permalink LIKE '$link'");
	$post_id_init = $post_id->fetch_assoc();
	$the_post_id = $post_id_init['content_id'];
	
	$commentsperpageinit = $global->sqlquery("SELECT commentsperpage FROM dd_settings LIMIT 1;");
	$commentsperpage = $commentsperpageinit->fetch_assoc();
	$cpp = $commentsperpage['commentsperpage'];
	$start_from = ($page-1) * $cpp;
	
	$comments = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_isreply = '0' AND comment_postid LIKE '$the_post_id' ORDER BY comment_date ASC LIMIT $start_from, $cpp");
	$comments2 = $global->sqlquery("SELECT COUNT(*) FROM dd_comments WHERE comment_postid LIKE '$the_post_id'");
	$row2 = $comments2->fetch_row(); 
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
		echo '<a href="/votecomment?postid='.$the_post_id.'&commentid='.$rowcomments['comment_id'].'&vote=positive" style="color:';if ($check->ifvotedpositive($rowcomments['comment_id'])){
		echo VOTED;}else {
		echo 'green';}
		echo '" rel="nofollow" alt="Upvote this comment!" title="Upvote this comment!">▲</a><br />';
		}echo '<div style="text-align:center">'.$check->positivenegativecomb($the_post_id, $rowcomments['comment_id']).'</div>';
		if ($check->ifbanned() or $check->istor()){
		}else{
		echo '<a href="/votecomment?postid='.$the_post_id.'&commentid='.$rowcomments['comment_id'].'&vote=negative" style="color:';if ($check->ifvotednegative($rowcomments['comment_id'])){
		echo VOTEDN;}else {
		echo 'red';}
		echo '" rel="nofollow" alt="Downvote this comment!" title="Downvote this comment!">▼</a>';
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
		' - <a href="/reportcomment?id='.$rowcomments['comment_id'].'&ip='.$_SERVER['REMOTE_ADDR'].'" rel="nofollow" alt="Report Comment" title="Report Comment">Report</a> | ';
		} echo '<a href="#postcomment" rel="nofollow" onclick="document.getElementById(';echo "'"; echo 'cr-v'; echo"'"; echo').value = 1; document.getElementById(';echo "'"; echo 'crt-id'; echo"'"; echo').value = '.$rowcomments['comment_id'].';document.getElementById('; echo "'";echo '#postcomment';echo "'"; echo').scrollIntoView();" alt="Reply" title="Reply to this comment.">Reply</a></div>';
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
		echo '<a href="/votecomment?postid='.$the_post_id.'&commentid='.$rowcommentreplies['comment_id'].'&vote=positive" style="color:';if ($check->ifvotedpositive($rowcommentreplies['comment_id'])){
		echo VOTED;}else {
		echo 'green';}
		echo '"  alt="Upvote this comment!" title="Upvote this comment!">▲</a><br />';
		}echo '<div style="text-align:center">'.$check->positivenegativecomb($the_post_id, $rowcommentreplies['comment_id']).'</div>';
		if ($check->ifbanned()){
		}else{
		echo '<a href="/votecomment?postid='.$the_post_id.'&commentid='.$rowcommentreplies['comment_id'].'&vote=negative" style="color:';if ($check->ifvotednegative($rowcommentreplies['comment_id'])){
		echo VOTEDN;}else {
		echo 'red';}
		echo '" alt="Downvote this comment!" title="Downvote this comment!">▼</a>';
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
echo pagebar($page, $total_pages, $cpp, '5');
echo '</div>';
amp();
} else {
header("HTTP/2.0 404 Not Found");
define ("PREPEND", '404 Not Found');
echo '<div class="notfoundpage">'.$template['404_message'].'</div>';
}
