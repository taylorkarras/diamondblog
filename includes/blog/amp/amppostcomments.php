<?php
$global = new DB_global;
$check = new DB_check;
$retrive = new DB_retrival;
$templateinit = $global->sqlquery("SELECT * FROM dd_templates;");
$template = $templateinit->fetch_assoc();
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
background-image: none !important;
width: auto !important;
background-color: transparent !important;
}

.cke {
color: #000000 !important;
font-family: "Arial" !important;
}

.postcomment {
float:initial !important;
}
</style>';
echo file_get_contents("https://".$_SERVER['HTTP_HOST']."/themes/".THEME."/styles/ampfont.php");
echo '</head>';
	if (isset($_GET["page"])) { $page  = $_GET["page"];
$link = str_replace('?page='.$_GET["page"], '', $link);	} else { $page=1; }; 
echo '<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/diamondblog-func.js"></script>';

	echo '<div class="postcomment">Comments (';echo $check->retrieve_comment_count($_GET['postid']); echo')'; echo'</div>';
	//Comments display
	
	$commentsperpageinit = $global->sqlquery("SELECT commentsperpage FROM dd_settings LIMIT 1;");
	$commentsperpage = $commentsperpageinit->fetch_assoc();
	$cpp = $commentsperpage['commentsperpage'];
	
if ($check->ispagingdynamic()){	
	$comments = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_approved = '1' AND comment_isreply = '0' AND comment_postid LIKE '".$_GET['postid']."' ORDER BY comment_date ASC LIMIT 0, $cpp");
} else {
	$comments = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_approved = '1' AND comment_isreply = '0' AND comment_postid LIKE '".$_GET['postid']."' ORDER BY comment_date ASC");
}
	$count = '1';
echo '<div class="contentpostscroll">';
	
	if ($comments->num_rows > 0) {
    // output data of each row
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
		' - <a href="/reportcomment?commentid='.$rowcomments['comment_id'].'" rel="nofollow" alt="Report Comment" title="Report Comment">Report</a> | ';
		} echo '<a href="#postcomment" rel="nofollow" onclick="document.getElementById(';echo "'"; echo 'cr-v'; echo"'"; echo').value = 1; document.getElementById(';echo "'"; echo 'crt-id'; echo"'"; echo').value = '.$rowcomments['comment_id'].';document.getElementById('; echo "'";echo '#postcomment';echo "'"; echo').scrollIntoView();" alt="Reply" title="Reply to this comment.">Reply</a></div>';
		}
		echo '<div class="commentcontent2">'.$rowcomments['comment_content'].'</div>';
		echo '</div>';
		// Replies //
		if ($check->ispagingdynamic()){
		$commentreplies = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_approved = '1' AND comment_isreply = '1' AND comment_replyto LIKE '".$rowcomments['comment_id']."' ORDER BY comment_date DESC LIMIT 0, 5;");
		} else {
		$commentreplies = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_approved = '1' AND comment_isreply = '1' AND comment_replyto LIKE '".$rowcomments['comment_id']."' ORDER BY comment_date DESC;");
		}
	if ($commentreplies->num_rows > 0) {
		echo '<div class="commentreplies">';
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
			if ($check->ispagingdynamic() && $commentreplies->num_rows == 5){
				echo '<div id="replyreplace'.$rowcomments['comment_id'].'">';
		echo '<a class="morereplies" style="color:#fff;" href="javascript:void(0)" alt="Load More Replies" title="Load More Replies"><div class="commentboxreply" style="font-size:40px; text-align: center; font-weight:bold;">Load More Replies</div></a>';
		echo "<script>

	var scrolleddown = false;
	var cpp = ".$cpp.";
	
$('#replyreplace".$rowcomments['comment_id']." .morereplies').on('click', function() {
var clicked = false;
			if (clicked == false){
			clicked = true;
			$('#replyreplace".$rowcomments['comment_id']." .commentboxreply').text('Please Wait');
		$.get('/commentreplies?commentid=".$rowcomments['comment_id']."&ppp=' + cpp, function(data) {
	$('#replyreplace".$rowcomments['comment_id']."').replaceWith(data) });
			}
    })</script></div>";
		}
			echo '</div>';
		
	}
				
		$count++;
	}
}

if ($check->ispagingdynamic() && $comments->num_rows == $cpp){
echo "<div id='replace'><script>

	var scrolleddown = false;
	var ppp = ".$cpp."

$(window).scroll(function() {
	var window_scrolled = ($(document).height()/100)*95;
        if($(this).scrollTop() + $(this).innerHeight() >= window_scrolled) {
			if (scrolleddown == false){
			scrolleddown = true;
		$.get('/dynamicload?type=comments&pageid=".$_GET['postid']."&ppp=' + ppp, function(data) {
	$('#replace').replaceWith(data) });
			}
        }
    })</script></div>";
}
echo '</div>';
exit;
