<?php

$global = new DB_global;
$retrive = new DB_retrival;
$postsperpageinit = $global->sqlquery("SELECT postsperpage FROM dd_settings LIMIT 1;");
$postsperpage = $postsperpageinit->fetch_assoc();
$ppp = $postsperpage['postsperpage'];

$ctq = str_replace ('_', ' ', $_GET['name']);

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 

$result = $global->sqlquery("SELECT * FROM dd_content WHERE content_tags LIKE '%".$ctq."%' ORDER BY content_date DESC LIMIT $start_from, $ppp;");
$resultcount = $result->num_rows;
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_content WHERE content_tags LIKE '%".$ctq."%'");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $ppp);

$check = new DB_check;
if ($result->num_rows > 0) {
	echo '<h1>There are '.$row2[0].' pages with the tag ("'.$ctq.'").</h1>
<br />';
echo '<div class="contentpostscroll">';
    // output data of each row
    while($row = $result->fetch_assoc()) {
		// Comments
		echo '<div class="contentcomment"><a class="contentcomment" href="'; echo $row['content_permalink']; echo '#comments" title="Comment & share!" alt="Comment & share!">Comments (';echo $check->retrieve_comment_count($row['content_id']); echo')'; echo'<a/></div>';
		// Title
        echo '<a href="';echo $row['content_permalink']; echo '" class="contenttitle" title="';echo $row['content_title']; echo '" alt="';echo $row['content_title']; echo '"><div class="contenttitle">';echo $row['content_title']; echo '</div></a>';
		// Date
		echo '<div class="contentdate">Posted on '.$row['content_date'].' by '.$retrive->realname($row['content_author']).'</div>';
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
		echo "No tag name entered!";
	} else {
    echo "There are no posts with the tag ('".$_GET['name']."').";
	}
}

echo pagebar($page, $total_pages, $ppp, '5', '1');
		echo '</div>';
