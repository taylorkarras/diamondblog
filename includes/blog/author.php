<?php

$global = new DB_global;
$retrive = new DB_retrival;
$check = new DB_check;
$postsperpageinit = $global->sqlquery("SELECT postsperpage FROM dd_settings LIMIT 1;");
$postsperpage = $postsperpageinit->fetch_assoc();
$ppp = $postsperpage['postsperpage'];

$ctq = str_replace ('_', ' ', $_GET['name']);
$userid = $retrive->userid($ctq);
$_SESSION['info']['author'] = $userid;
unset($_SESSION['info']['category']);
unset($_SESSION['info']['tag']);

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 

if ($page > '1'){
define ("PREPEND", 'Posts by author "'.$_GET['name'].'" (Page '.$_GET['page'].')');
} else {
define ("PREPEND", 'Posts by author "'.$_GET['name'].'"');
}

$result = $global->sqlquery("SELECT * FROM dd_content WHERE content_author = LOWER('".$userid."') ORDER BY content_date DESC LIMIT $start_from, $ppp;");
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_content WHERE content_author = '".$userid."';");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $ppp);
$resultcount = $total_records;

$check = new DB_check;
echo '<div class="contentpostscroll">';
if ($result->num_rows > 0) {
	echo '<h1>There are '.$resultcount.' pages with the author ("'.$ctq.'").</h1>
<br />';
    // output data of each row
    while($row = $result->fetch_assoc()) {
		// Comments
		echo '<div class="contentcomment"><a class="contentcomment" href="'; echo $row['content_permalink']; echo '#comments" title="Comment & share!" alt="Comment & share!">Comments (';echo $check->retrieve_comment_count($row['content_id']); echo')'; echo'<a/></div>';
		// Title
        echo '<a href="';echo $row['content_permalink']; echo '" class="contenttitle" title="';echo $row['content_title']; echo '" alt="';echo $row['content_title']; echo '"><div class="contenttitle">';echo $row['content_title']; echo '</div></a>';
		// Date
		echo '<div class="contentdate">Posted on '.$row['content_date'].'</div>';
		// Post
		echo '<div class="contentpost">'; echo $row['content_embedcode'];
		echo '<br />';
		echo $row['content_summary'];
                if (strpos($row['content_summary'], "...")){
                echo '<p><a class="readmore" href="'.$row['content_permalink'].'" title="';echo $row['content_title']; echo '" alt="';echo $row['content_title']; echo '">(read more)</a></p>';
                }
                echo '</div>';
		echo '<div class="contentcategory"></div>';
		echo '<div style="margin-bottom: 25px;"></div>';
    }
} else {
	if ($_GET['name'] == ''){
		echo "No author entered!";
	} else {
    echo "There are no posts with the author ('".$ctq."').";
	}
}

if ($check->ispagingdynamic() && $result->num_rows == $ppp){
	echo "<div id='replace'><script>

	var scrolleddown = false;
	var ppp = ".$ppp.";
$(window).scroll(function() {
		var window_scrolled = ($(document).height()/100)*95;
        if($(this).scrollTop() + $(this).innerHeight() >= window_scrolled) {
			if (scrolleddown == false){
			scrolleddown = true;
		$.get('/dynamicresults?type=specific&ppp=' + ppp, function(data) {
	$('#replace').replaceWith(data) });
			}
        }
    })</script></div>";
} else {
echo pagebar($page, $total_pages, $ppp, '5', '1');
}
		echo '</div>';
