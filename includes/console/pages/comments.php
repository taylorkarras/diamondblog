<?php
$global = new DB_global;
$retrive = new DB_retrival;
	if ($retrive->isLoggedIn() == true){
$commentcount1 = $global->sqlquery("SELECT comment_id FROM dd_comments WHERE comment_postid = '".$_GET['postid']."';");
$commentcount2 = $commentcount1->num_rows;

echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo number_format($commentcount2); echo " comments on this post.</div>";

$global = new DB_global;
		$ss1 = $global->sqlquery("SELECT * FROM dd_settings");
		$ss2 = $ss1->fetch_assoc();
		
$cpp = $ss2['commentsperpage'];

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $cpp; 

$result = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_postid = '".$_GET['postid']."' ORDER BY comment_id DESC LIMIT $start_from, $cpp;");
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_comments WHERE comment_postid = '".$_GET['postid']."'");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $cpp);
	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $cpp - '1';
	}
echo '<div class="contentpostscroll">';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
	echo '<a href="/console/posts/comments/delete?commentid='.$row['comment_id'].'" title="Delete" alt="Delete">Delete</a> | <a href="/console/posts/comments/edit?commentid='.$row['comment_id'].'" title="Edit" alt="Edit">Edit</a>';
	echo '</div>';
	echo '<div class="postnumber">';
	echo $count;
	echo '</div>';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	echo $row['comment_username']; echo' ('.$row['comment_ip'].') ('.$row['comment_email'].')';
	echo '</div>';
	echo '<div class="postdate">Posted on '.$row['comment_date'].'. (<b>'.retrieve_post_positive_votes($row['comment_id']).'</b> positive votes/<b>'.retrieve_post_negative_votes($row['comment_id']).'</b> negative votes)';
	if ($row['comment_reported'] == '1')
	{
	$reportip1 = $global->sqlquery("SELECT * FROM `dd_reports` where report_commentid = '".$row['comment_id']."'");
	$reportip2 = $reportip1->fetch_assoc();
	echo ' <b>(Comment reported by '.$reportip2['report_ip'].')</b> - <a href="/console/posts/comments/unreport?id='.$reportip2['report_id'].'&commentid='.$row['comment_id'].'" alt="Unreport" title="Unreport">Unreport</a>';
	}
	echo '</div>';
	echo '<div class="postcategory">'.$row['comment_content'].'</div>';
	echo '</div>';
	echo '</div>';
	$count++;
	}
}
echo pagebar($page, $total_pages, $cpp, '5', '1');
echo '</div>';
} else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>
