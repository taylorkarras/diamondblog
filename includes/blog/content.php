<?php
$global = new DB_global;
$retrive = new DB_retrival;
$postsperpageinit = $global->sqlquery("SELECT * FROM dd_settings;");
$postsperpage = $postsperpageinit->fetch_assoc();
$ppp = $postsperpage['postsperpage'];

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 

if ($page > '1'){
define ("PREPEND", 'Page '.$_GET['page'].'');
}

$result = $global->sqlquery("SELECT * FROM dd_content WHERE content_pinned = '0' ORDER BY content_date DESC LIMIT $start_from, $ppp;");
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_content");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $ppp);

$pinned = $global->sqlquery("SELECT * FROM dd_content WHERE content_pinned = '1' OR content_pinned = '2';");

$check = new DB_check;
pluginClass::hook( "content_top" );
// Pinned post //
if ($pinned->num_rows > 0) {
    // output data of each row
echo '<div id="pinned">';
echo '<h2>Pinned</h2>';
    while($row = $pinned->fetch_assoc()) {
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
echo '</div>';
}

echo '<div class="contentpostscroll">';
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
} else {
    echo "This blog currently has no posts.";
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
		$.get('/dynamicload?type=content&ppp=' + ppp, function(data) {
	$('#replace').replaceWith(data) });
			}
        }
    })</script></div>";
} else {
echo pagebar($page, $total_pages, $ppp, '5');
}
		echo '</div>';
