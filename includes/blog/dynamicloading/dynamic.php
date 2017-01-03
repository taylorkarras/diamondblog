<?php
if (isset($_GET['ppp'])){
$global = new DB_global;
$retrive = new DB_retrival;
$postsperpageinit = $global->sqlquery("SELECT * FROM dd_settings;");
$postsperpage = $postsperpageinit->fetch_assoc();
$start_from = $_GET['ppp'];

$check = new DB_check;

if ($_GET['type'] == 'content'){

$ppp = $_GET['ppp'] + $postsperpage['postsperpage'];

$result = $global->sqlquery("SELECT * FROM dd_content WHERE content_pinned = '0' ORDER BY content_date DESC LIMIT $start_from, ".$postsperpage['postsperpage'].";");

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		$date=date_create($row['content_date']);
		// Comments
		echo '<div class="contentcomment"><a class="contentcomment" href="'; echo $row['content_permalink']; echo '#comments" title="Comment & share!" alt="Comment & share!">Comments (';echo $check->retrieve_comment_count($row['content_id']); echo')'; echo'<a/></div>';
		// Title
        echo '<a href="';echo $row['content_permalink']; echo '" class="contenttitle" title="';echo $row['content_title']; echo '" alt="';echo $row['content_title']; echo '"><div class="contenttitle">';echo $row['content_title']; echo '</div></a>';
		// Date
		echo '<div class="contentdate">Posted on '.date_format($date, $postsperpage['date_format']." ".$postsperpage['time_format']).' by '.$retrive->realname($row['content_author']).'</div>';
		// Post
		echo '<div class="contentpost">'; echo $row['content_embedcode'];
		echo '<br />';
				echo $row['content_summary'];
		if (strpos($row['content_summary'], "...")){
		echo '<p><a class="readmore" href="'.$row['content_permalink'].'" title="';echo $row['content_title']; echo '" alt="';echo $row['content_title']; echo '">(read more)</a></p>';
		}
		echo '</div>';
		// Category
		echo '<div class="contentcategory">Categorized under: <a href="/category?name=';
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
    }
}

if ($result->num_rows == $postsperpage['postsperpage']) {
echo "<div id='replace'><script>

	var scrolleddown = false;
	var ppp = ".$ppp.";

$(window).scroll(function() {
	var window_scrolled = ($(document).height()/100)*95;
        if($(this).scrollTop() + $(this).innerHeight() >= window_scrolled) {
			if (scrolleddown == false){
				console.log(ppp);
			scrolleddown = true;
		$.get('/dynamicload?type=content&ppp=' + ppp, function(data) {
	$('#replace').replaceWith(data) });
	instgrm.Embeds.process();
			}
        }
    })</script></div>";
}

exit;
}

if ($_GET['type'] == 'comments' && isset($_GET['pageid'])){

	$the_post_id = $_GET['pageid'];

	$cpp = $_GET['ppp'] + $postsperpage['commentsperpage'];
	$count = '1' + $_GET['ppp'];
	$comments = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_approved = '1' AND comment_isreply = '0' AND comment_postid LIKE '$the_post_id' ORDER BY comment_date ASC LIMIT $start_from, ".$postsperpage['commentsperpage']."");

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
		$commentreplies = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_approved = '1' AND comment_isreply = '1' AND comment_replyto LIKE '".$rowcomments['comment_id']."' ORDER BY comment_date ASC LIMIT 0, 5;");
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
		' - <a href="/reportcomment?commentid='.$rowcommentsreplies['comment_id'].'" rel="nofollow"  alt="Report Comment" title="Report Comment">Report</a></div>';
		}
		}
		echo '<div class="commentcontent2">'.$rowcommentreplies['comment_content'].'</div>';
		echo '</div>';
			$replycount++;}
			if ($commentreplies->num_rows == 5) {
		echo '<div id="replyreplace'.$rowcomments['comment_id'].'">';
		echo '<a class="morereplies" href="javascript:void(0)" alt="Load More Replies" title="Load More Replies"><div class="commentboxreply" style="font-size:40px; text-align: center; font-weight:bold;">Load More Replies</div></a>';
		echo "<script>

	var scrolleddown = false;
	var cpp = ".$cpp.";
	
$('#replyreplace".$rowcomments['comment_id']." .morereplies').on('click', function() {
var clicked = false;
			if (clicked == false){
			clicked = true;
			$('#replyreplace".$rowcomments['comment_id']." .morereplies').text('Please Wait');
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

if ($comments->num_rows == $postsperpage['commentsperpage']) {
echo "<div id='replace'><script>

	var scrolleddown = false;
	var ppp = ".$cpp."

$(window).scroll(function() {
	var window_scrolled = ($(document).height()/100)*95;
        if($(this).scrollTop() + $(this).innerHeight() >= window_scrolled) {
			if (scrolleddown == false){
			scrolleddown = true;
		$.get('/dynamicload?type=comments&pageid=".$_GET['pageid']."&ppp=' + ppp, function(data) {
	$('#replace').replaceWith(data) });
			}
        }
    })</script></div>";
}

exit;
}
} else {
exit;
	}