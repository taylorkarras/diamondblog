<?php
if (isset($_GET['ppp'])){
$global = new DB_global;
$retrive = new DB_retrival;
$postsperpageinit = $global->sqlquery("SELECT * FROM dd_settings;");
$postsperpage = $postsperpageinit->fetch_assoc();
$start_from = $_GET['ppp'];
$ppp = $_GET['ppp'] + $postsperpage['postsperpage'];
$check = new DB_check;

if ($_GET['type'] == 'specific'){
if (isset($_SESSION['info']['category'])){
$result = $global->sqlquery("SELECT * FROM dd_content WHERE content_category = '".$_SESSION['info']['category']."' ORDER BY content_date DESC LIMIT $start_from, ".$postsperpage['postsperpage'].";");
}
if (isset($_SESSION['info']['tag'])){
$result = $global->sqlquery("SELECT * FROM dd_content WHERE content_tags LIKE LOWER('%".$_SESSION['info']['tag']."%') ORDER BY content_date DESC LIMIT $start_from, ".$postsperpage['postsperpage'].";");
}
if (isset($_SESSION['info']['author'])){
$result = $global->sqlquery("SELECT * FROM dd_content WHERE content_author = LOWER('".$_SESSION['info']['author']."') ORDER BY content_date DESC LIMIT $start_from, ".$postsperpage['postsperpage'].";");
}
if ($result->num_rows > 0) {
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
		$.get('/dynamicresults?type=specific&ppp=' + ppp, function(data) {
	$('#replace').replaceWith(data) });
	instgrm.Embeds.process();
			}
        }
    })</script></div>";
}

exit;
}

if ($_GET['type'] == 'search'){
	$findarray = array('0,', $_GET['ppp'].',');
	$query = str_replace($findarray, $start_from.',', $_SESSION['info']['search']);
	
	$results = $global->sqlquery($query);
if ($results->num_rows > 0) {
    // output data of each row
    while($row = $results->fetch_assoc()) {
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
		echo str_replace(" ", "_", $catlowcase);
		echo '" alt="'; echo $row['content_category']; echo '" title="'; echo $row['content_category']; echo'">'; echo $row['content_category']; echo '</div></a>';
		// Tags
		echo '<div class="contenttags">Tags: ';
		$tags = explode (", ", $row['content_tags']);
		foreach ($tags as $tag) {
			echo '<a href="/tag?name=';
		$taglowcase = strtolower($tag);
		echo str_replace(" ", "_", $taglowcase);
		echo '" alt="'; echo $tag; echo '" title="'; echo $tag; echo'">'; echo $tag; echo '</a> ';
		}
		echo '</div>';
    }
}

if ($results->num_rows == $postsperpage['postsperpage']) {
echo "<div id='replace'><script>

	var scrolleddown = false;
	var ppp = ".$ppp.";

$(window).scroll(function() {
	var window_scrolled = ($(document).height()/100)*95;
        if($(this).scrollTop() + $(this).innerHeight() >= window_scrolled) {
			if (scrolleddown == false){
				console.log(ppp);
			scrolleddown = true;
		$.get('/dynamicresults?type=search&ppp=' + ppp, function(data) {
	$('#replace').replaceWith(data) });
	instgrm.Embeds.process();
			}
        }
    })</script></div>";
}
exit;
}
} else {
exit;
	}
