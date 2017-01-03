<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
if (strpos($_SERVER['REQUEST_URI'], "approval")){
echo consolemenu();
echo "<div id='page'>";
echo '<div class="center"><a href="/console/reports/" title="Reports" alt="Reports">Reports</a> | Comment Approval</div><br />';
echo "<div class='center'>There are "; echo number_format($retrive->commentsawaitingapproval()); echo " comments awaiting approval.</div>";

$global = new DB_global;

		$ss1 = $global->sqlquery("SELECT * FROM dd_settings");
		$ss2 = $ss1->fetch_assoc();

$ppp = $ss2['postsperpage'];

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 

if ($page > '1'){
define ("PAGE", ' (Page '.$_GET['page'].')');
}

$result = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_approved = '0' ORDER BY comment_id DESC LIMIT $start_from, $ppp;");
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_comments WHERE comment_approved = '0'");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $ppp);
	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $start_from - $page + '1';
	}
echo '<div class="contentpostscroll">';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
	echo '<a href="/console/comments/approve?commentid='.$row['comment_id'].'" title="Approve" alt="Approve">Approve</a> | <a href="/console/comments/delete?commentid='.$row['comment_id'].'" title="Delete" alt="Delete">Delete</a>';
	echo '</div>';
	echo '<div class="postnumber">';
	echo $count;
	echo '</div>';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	echo $row['comment_username']; echo' ('.$row['comment_ip'].') ('.$row['comment_email'].')';
	echo '</div>';
	echo '<div class="postcategory">'.$row['comment_content'].'</div>';
	echo '</div>';
	echo '</div>';
	$count++;
	}
}
echo pagebar($page, $total_pages, $ppp, '5');
		echo '</div>';
}
else if (isset($_GET['reportid']))
{
$global = new DB_global;
$result = $global->sqlquery("SELECT * FROM dd_reports WHERE report_id = '".$_GET['reportid']."'");
$result2 = $result->fetch_assoc();
$comment = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_id = '".$result2['report_commentid']."'");
$comment2 = $comment->fetch_assoc();

if($result2['report_id'] == NULL){
header("Location: /console/reports");
}

echo consolemenu();
echo "<div id='page'>";
echo "<div class='center'>The specified report is provided below.</div>";

	echo '<div class="postbox">';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	echo $result2['report_name']; echo' ('.$result2['report_ip'].') ('.$result2['report_email'].')';
	echo '</div>';
	echo '<div class="postcategory">'.$result2['report_text'].'</div>';
	echo '</div>';
	echo '</div>';

	echo "<br><div class='center'>The comment reported is provided below.</div>";
	
		echo '<div class="postbox">';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	echo $comment2['comment_username']; echo' ('.$comment2['comment_ip'].') ('.$comment2['comment_email'].')';
	echo '</div>';
	echo '<div class="postcategory">'.$comment2['comment_content'].'</div>';
	echo '</div>';
	echo '</div>';
	
	echo "<br><div class='center'>What would you like to do.</div>";
	echo '<br><div class="center"><a href="/console/posts/comments/delete?commentid='.$result2['report_commentid'].'" title="Delete Comment" alt="Delete Comment">Delete Comment</a> | <a href="/console/posts/comments/unreport?id='.$_GET['reportid'].'&commentid='.$result2['report_commentid'].'" alt="Unreport" title="Unreport">Unreport</a></div>';
	
echo '</div>';

} else {
$_SESSION['referral_url']['comments'] = 'https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
echo consolemenu();
echo "<div id='page'>";
echo '<div class="center">Reports | <a href="/console/reports/approval/" title="Comment Approval" alt="Comment Approval">Comment Approval</a></div><br />';
echo "<div class='center'>There are "; echo number_format($retrive->numberofreports()); echo " reports on this blog.</div>";

$global = new DB_global;

		$ss1 = $global->sqlquery("SELECT * FROM dd_settings");
		$ss2 = $ss1->fetch_assoc();

$ppp = $ss2['postsperpage'];

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 

if ($page > '1'){
define ("PAGE", ' (Page '.$_GET['page'].')');
}

$result = $global->sqlquery("SELECT * FROM dd_reports ORDER BY report_id DESC LIMIT $start_from, $ppp;");
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_reports");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $ppp);
	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $start_from - $page + '1';
	}
echo '<div class="contentpostscroll">';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
	echo '<a href="/console/reports?reportid='.$row['report_id'].'" title="View Detailed Information" alt="View Detailed Information">View Detailed Information</a>';
	echo '</div>';
	echo '<div class="postnumber">';
	echo $count;
	echo '</div>';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	echo $row['report_name']; echo' ('.$row['report_ip'].') ('.$row['report_email'].')';
	echo '</div>';
	echo '<div class="postcategory">'.$row['report_text'].'</div>';
	echo '</div>';
	echo '</div>';
	$count++;
	}
}
echo pagebar($page, $total_pages, $ppp, '5');
		echo '</div>';
		}}else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>
