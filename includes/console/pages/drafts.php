<?php
$global = new DB_global;
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
echo consolemenu();
echo "<div id='page'>";
echo '<div class="center"><a href="/console/posts/" title="Posts" alt="Posts">Posts</a> | Drafts</div><br />';
$result3 = $global->sqlquery("SELECT COUNT(*) FROM dd_drafts WHERE draft_author = '".$_COOKIE['userID']."'");
$row3 = $result3->fetch_row(); 
echo "<div class='center'>You have "; echo $row3[0]; echo " drafts on this blog.</div>";

		$ss1 = $global->sqlquery("SELECT * FROM dd_settings");
		$ss2 = $ss1->fetch_assoc();

$ppp = $ss2['postsperpage'];

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 

$result = $global->sqlquery("SELECT * FROM dd_drafts WHERE draft_author = '".$_COOKIE['userID']."' ORDER BY draft_id DESC LIMIT $start_from, $ppp;");
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_drafts");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $ppp);
	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $ppp - '1';
	}
	
echo '<div class="contentpostscroll">';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
echo '<a href="/console/posts/drafts/delete?postid='.$row['draft_id'].'" title="Delete" alt="Delete">Delete</a> | <a href="/console/posts/edit?draftid='.$row['draft_id'].'" title="Edit" alt="Edit">Edit</a>';
	echo '</div>';
	echo '<div class="postnumber">';
	echo $count;
	echo '</div>';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	echo $row['draft_title'];
	echo '</div>';
	echo '<div class="postdate">Edited on '.$row['draft_date'].'.</div>';
	echo '<div class="postcategory">Category: '.$row['draft_category'].'</div>';
	echo '<div class="posttags">Tags: '.$row['draft_tags'].'</div>';
	echo '</div>';
	echo '</div>';
	$count++;
	}
}
echo pagebar($page, $total_pages, $ppp, '5');
		echo '</div>';
		}else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>
