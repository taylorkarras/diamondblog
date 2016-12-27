<?php
if (isset($_GET['ppp']) && isset($_GET['commentid'])){
$global = new DB_global;
$retrive = new DB_retrival;
$postsperpageinit = $global->sqlquery("SELECT * FROM dd_settings;");
$postsperpage = $postsperpageinit->fetch_assoc();
$start_from = $_GET['ppp'];
$cpp = $_GET['ppp'] + 5;

$check = new DB_check;

		$commentreplies = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_isreply = '1' AND comment_replyto LIKE '".$_GET['commentid']."' ORDER BY comment_date ASC LIMIT $start_from, 5;");
	if ($commentreplies->num_rows > 0) {
		$replycount = '1' + $_GET['ppp'];
		    while($rowcommentreplies = $commentreplies->fetch_assoc()) {
				echo '<div id="comment_'.$rowcommentreplies['comment_id'].'" class="commentboxreply">';
						// Vote
		echo '<div class="commentvote">';
		if ($check->ifbanned()){
		}else{
		echo '<a href="/votecomment?postid='.$the_post_id.'&commentid='.$rowcommentreplies['comment_id'].'&vote=positive" style="color:';if ($check->ifvotedpositive($rowcommentreplies['comment_id'])){
		echo VOTED;}else {
		echo 'green';}
		echo '"  alt="Upvote this comment!" title="Upvote this comment!">?</a><br />';
		}echo '<div style="text-align:center">'.$check->positivenegativecomb($the_post_id, $rowcommentreplies['comment_id']).'</div>';
		if ($check->ifbanned()){
		}else{
		echo '<a href="/votecomment?postid='.$the_post_id.'&commentid='.$rowcommentreplies['comment_id'].'&vote=negative" style="color:';if ($check->ifvotednegative($rowcommentreplies['comment_id'])){
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
		' - <a href="/reportcomment?commentid='.$rowcommentsreplies['comment_id'].'" rel="nofollow"  alt="Report Comment" title="Report Comment">Report</a></div>';
		}
		}
		echo '<div class="commentcontent2">'.$rowcommentreplies['comment_content'].'</div>';
		echo '</div>';
			$replycount++;}
	}
			if ($commentreplies->num_rows == $cpp) {
		echo '<div id="replyreplace'.$rowcomments['comment_id'].'">';
		echo '<a class="morereplies" href="javascript:void(0)" alt="Load More Replies" title="Load More Replies"><div class="commentboxreply" style="font-size:40px; text-align: center; font-weight:bold;">Load More Replies</div></a>';
		echo "<script>

	var scrolleddown = false;
	var cpp = '".$cpp."'

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
		exit;
	} else {
exit;
	}
