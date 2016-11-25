<?php

$global = new DB_global;
$retrive = new DB_retrival;
$check = new DB_check;

$url = urldecode($_GET['query']);
$urlstripped1 = preg_replace('/[^ ]*:"[^"]+"/', '', $url);
$urlstripped2 = preg_replace('/[^ ]*:\S+/im', '', $urlstripped1);
$urlexploded = str_getcsv($urlstripped2, ", ", '"');
  if(empty($url)){
echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
$haserror = true;
  }
//Category
  if (preg_match('/^category:.*/', $url) or preg_match('/, category:.*/', $url)){
preg_match_all ('/category:\S+/im', $url, $category2);
if(empty($category2[0])){
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$category3 = implode(':',$category2[0]);
$replace = array('category:', ',');
$category4 = str_replace($replace, '', $category3);
$category5 = str_replace('"', '', $category4);
$category = " AND LOWER(content_category) = LOWER('".$category5."') ";
  }
  }

//Tags

if (preg_match('/^tag:"[^"]+"/im', $url) or preg_match('/, tag:"[^"]+"/im', $url)){
preg_match_all ('/tag:"[^"]+"/im', $url, $singletag2);
if(empty($singletag2[0])){
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$singletag3 = implode(':',$singletag2[0]);
$replace = array('tag:', ',', '"');
$singletag4 = str_replace($replace, '', $singletag3);
$singletag5 = str_replace('"', '', $singletag4);
$tags = " AND LOWER(content_tags) LIKE LOWER('%".$singletag5."%') ";
  }
} else if (preg_match('/^tags:.*/', $url) or preg_match('/, tags:.*/', $url)){
preg_match_all ('/tags:.*/im', $url, $tags2);

if(empty($tags2[0])){
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$tags3 = implode('%, %',$tags2[0]);
$tags4 = str_replace('tags:', '', $tags3);
if (preg_match('/^tag:"[^"]+"/im', $url) or preg_match('/, tag:"[^"]+"/im', $url)){
$tags5 = explode(',', $tags4);
$tags6 = implode("%, %", $tags5);
$tags7 = trim($tags6);
$replace = array('"', '% ');
$replace2 = array('', '%');
$tags8 = str_replace($replace, $replace2, $tags7);
$tags = " AND content_tags LIKE ('%".$tags8."%')";
} else {
$replace = array('"', '% ');
$replace2 = array('', '%');
$replace3 = array('/, category:.*/im', '/, tags:.*/im', '/, author:.*/im', '/, date:.*/im');
$tags5 = str_replace($replace, $replace2, $tags4);
$tags6 = preg_replace($replace3, '', $tags5);
$tags = " AND content_tags LIKE ('%".$tags6."%')";
}
  }
  }
  
  //Date
if (preg_match('/^date:.*/', $url) or preg_match('/, date:.*/', $url)){
preg_match_all ('/date:.+/', $url, $date2);
if(empty($date2[0])){
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$date3 = implode(':',$date2[0]);
$replace = array('date:', ',');
$date4 = str_replace($replace, '', $date3);
if (preg_match("/^\d{4}$/", $date4)){
        $date = " AND content_date BETWEEN '".$date4."-01-01' AND '".$date4."-12-31'";
} else if (preg_match('/^"[a-zA-Z0-9 ]+\d{4}"$/im', $date4)){
	$date5 = str_replace('"', "", $date4);
	$date6 = date('m/Y', strtotime($date5));
	$date7 = explode('/', $date6);
	$date = " AND content_date BETWEEN '".$date7[1]."-".$date7[0]."-01' AND '".$date7[1]."-".$date7[0]."-31'";
} else if (!preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $date4)){
	echo '<h1 style="display:table; margin:0;">Please enter the date in the MM/DD/YYYY format.</h1>';
	$haserror = true;
} else {
	$date5 = explode('/', $date4);
	$date = " AND content_date LIKE '%".$date5[2].'-'.$date5[0].'-'.$date5[1]."%' ";
}
  }
}

//Author
  if (preg_match('/^author:"[^"]+"/im', $url) or preg_match('/, author:"[^"]+"/im', $url)){
preg_match_all ('/author:"[^"]+"/im', $url, $author2);
if(empty($author2[0])){
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$author3 = implode(':',$author2[0]);
$replace = array('author:', '"', ',');
$author4 = str_replace($replace, '', $author3);
$author5 = str_replace('"', '', $author4);
if ($retrive->userid($author5) == true){
$author6 = $retrive->userid($author5);
$author = " AND LOWER(content_author) = LOWER('".$author6."') ";
} else {
	echo '<h1 style="display:table; margin:0;">Author not found.</h1>';
	$haserror = true;
}
  }
  } else if (preg_match('/^author:.*/', $url) or preg_match('/, author:.*/', $url)){
preg_match_all ('/author:.*/im', $url, $author2);
if(empty($author2[0])){
        echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
        $haserror = true;
  } else {
$author3 = implode(':',$author2[0]);
$replace = array('author:', '"', ',');
$author4 = str_replace($replace, '', $author3);
$author5 = str_replace('"', '', $author4);
if ($retrive->userid($author5) == true){
$author6 = $retrive->userid($author5);
$author = " AND content_author = '".$author6."' ";
} else {
        echo '<h1 style="display:table; margin:0;">Author not found.</h1>';
        $haserror = true;
}
  }
  }


if (str_word_count($url) == '1'){
$searchtermreplace1 = preg_replace('/date[:]\S+/','',$url);
} else {
$searchterm2 = implode("%, %", $urlexploded);
$searchterm3 = trim($searchterm2);
$searchterm4 = str_replace('% ', "%",  $searchterm3);
$searchterm = preg_replace('/date[:]\S+/','',$searchterm4);
}

if (strlen($urlstripped2) < 1){
$searchterm5 = '';
}
else if (str_word_count($urlstripped2) == '1'){
$urlremovecommas1 = str_replace(', ', '', $urlstripped2);
$urlremovecommas2 = str_replace(', ', '', $urlremovecommas1);
$urlremovequotes = str_replace('"', '', $urlremovecommas2);
$searchterm5 = '%'.$urlremovequotes.'%';
}
else {
$searchtermra1 = str_replace('%% ,', '', $searchterm);
$searchtermra2 = str_replace(', %%', '', $searchtermra1);
$searchterm5 = '%'.$searchtermra2.'%';
}

if ($haserror == true){}
else {
$postsperpageinit = $global->sqlquery("SELECT * FROM dd_settings;");
$postsperpage = $postsperpageinit->fetch_assoc();
$ppp = $postsperpage['postsperpage'];

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $ppp;

$contentquery = " content_title LIKE ('".$searchterm5."') OR content_description LIKE ('".$searchterm5."')";
$query = "SELECT * FROM dd_content WHERE".$contentquery.$category.$tags.$date.$author." ORDER BY content_date DESC LIMIT $start_from, $ppp;";
$query2 = "SELECT COUNT(*) FROM dd_content WHERE".$contentquery.$category.$tags.$date.$author.";";

if(trim($searchterm5) === '' or strpos($query, '%%')){
$query = "SELECT * FROM dd_content WHERE".$category.$tags.$date.$author." ORDER BY content_date DESC LIMIT $start_from, $ppp;";
$query2 = "SELECT COUNT(*) FROM dd_content WHERE".$category.$tags.$date.$author.";";
$pos = strpos($query, 'AND');
if ($pos !== false) {
    $newstring = substr_replace($query, '', 31, strlen('AND'));
}
$pos = strpos($query2, 'AND');
if ($pos !== false) {
    $newstring2 = substr_replace($query2, '', 38, strlen('AND'));
}
$results = $global->sqlquery($newstring);
$results2 = $global->sqlquery($newstring2);
}
else {
$results = $global->sqlquery($query);
$results2 = $global->sqlquery($query2);
}
$searchresultnumbers = $results2->fetch_row();
$total_records = $searchresultnumbers[0];
$total_pages = ceil($total_records / $ppp);

if ($results->num_rows > 0) {
echo '<div class="contentpostscroll">';
echo '<h1>There are '.number_format($searchresultnumbers[0]).' results.</h1>';
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
echo pagebar($page, $total_pages, $ppp, '5', '1');
echo '</div>';
} else {
    echo "<h1>No search results found.</h1>";
}
}
