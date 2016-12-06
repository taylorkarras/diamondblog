<?php

$global = new DB_global;
$retrive = new DB_retrival;

$url = urldecode($_GET['query']);
$urlstripped1 = preg_replace('/[^ ]*:"[^"]+"/', '', $url);
$urlstripped2 = preg_replace('/[^ ]*:\S+/im', '', $urlstripped1); 
$urlexploded = str_getcsv($urlstripped2, ", ", '"');
$haserror = '';
$category = '';
$tags = '';
$date = '';
$author = '';
	  if (empty($_GET['query'])){
$query='';
}else{
$query=$_GET['query'];
define ('POSTPEND', 'Post search results for "'.$query.'"');
}
  if(empty($url)){
	  echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
$haserror = true;
  }
//Category
if (preg_match('/category:"[^"]+"/im', $url) or preg_match('/, category:"[^"]+"/im', $url)){
preg_match_all ('/category:"[^"]+"/im', $url, $category2);
if(empty($category2[0])){
	echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$category3 = implode(':',$category2[0]);
$replace = array('category:', ',');
$category4 = str_replace($replace, '', $category3);
$category5 = str_replace('"', '', $category4);
$category = " AND content_category = '".$category5."' ";
  }
  } else if (preg_match('/^category:.*/', $url) or preg_match('/, category:.*/', $url)){
preg_match_all ('/category:\S+/im', $url, $category2);
if(empty($category2[0])){
	echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$category3 = implode(':',$category2[0]);
$replace = array('category:', ',');
$category4 = str_replace($replace, '', $category3);
$category = " AND content_category = '".$category4."' ";
  }
  }
//Tags
if (preg_match('/^tag:.*/', $url) or preg_match('/, tag:.*/', $url)){
preg_match_all ('/tag:"[^"]+"/im', $url, $singletag2);
if(empty($singletag2[0])){
	echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$singletag3 = implode(':',$singletag2[0]);
$replace = array('tag:', ',', '"');
$singletag4 = str_replace($replace, '', $singletag3);
$tags = " AND LOWER(content_tags) LIKE LOWER('%".$singletag5."%') ";
  }
}  else if (preg_match('/^tags:.*/', $url) or preg_match('/, tags:.*/', $url)){
preg_match_all ('/tags:.*/im', $url, $tags2);
if(empty($singletag2[0])){
	echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
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
$tags = " AND LOWER(content_tags) LIKE LOWER('%".$tags8."%')";
} else {
$replace = array('"', '% ');
$replace2 = array('', '%');
$replace3 = array('/, category:.*/im', '/, tags:.*/im', '/, author:.*/im', '/, date:.*/im');
$tags5 = str_replace($replace, $replace2, $tags4);
$tags6 = preg_replace($replace3, '', $tags5);
$tags = " AND LOWER(content_tags) LIKE LOWER('%".$tags6."%')";
}
  }
  }
  
  //Date
if (preg_match('/^date:.*/', $url) or preg_match('/, date:.*/', $url)){
preg_match_all ('/date:.+/', $url, $date2);
if(empty($date2[0])){
	echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  }  else {
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
  if (preg_match('/^author:.*/', $url) or preg_match('/, author:.*/', $url)){
preg_match_all ('/author:"[^"]+"/im', $url, $author2);
if(empty($author2[0])){
	echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$author3 = implode(':',$author2[0]);
$replace = array('author:', '"', ',');
$author4 = str_replace($replace, '', $author3);
if ($retrive->userid($author4) == true){
$author5 = $retrive->userid($author4);
$author = " AND content_author = '".$author5."' ";
} else {
	echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
	echo '<h1 style="display:table; margin:0;">Author not found.</h1>';
	$haserror = true;
}
  }
  } else if (preg_match('/^author:.*/', $url) or preg_match('/, author:.*/', $url)){
preg_match_all ('/author:.*/im', $url, $author2);
if(empty($author2[0])){
	echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$author3 = implode(':',$author2[0]);
$replace = array('author:', '"', ',');
$author4 = str_replace($replace, '', $author3);
if ($retrive->userid($author4) == true){
$author5 = $retrive->userid($author4);
$author = " AND content_author = '".$author5."' ";
} else {
	echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
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
$searchterm5 = '%'.$urlremovecommas2.'%';
}
else {
$searchtermra1 = str_replace('%% ,', '', $searchterm);
$searchtermra2 = str_replace(', %%', '', $searchtermra1);
$searchterm5 = '%'.$searchtermra2.'%';
}

if ($haserror == true){}
else {
$postsperpageinit = $global->sqlquery("SELECT postsperpage FROM dd_settings LIMIT 1;");
$postsperpage = $postsperpageinit->fetch_assoc();
$ppp = $postsperpage['postsperpage'];

		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };
$start_from = ($page-1) * $ppp;

if ($page > '1'){
define ("PAGE", ' (Page '.$_GET['page'].')');
}

        if ($page == '1'){
        $count = $page;
        }
        else {
        $count = $page + $start_from - $page + '1';
        }
	
$contentquery = " content_title LIKE ('".$searchterm5."') OR content_description LIKE ('".$searchterm5."')";
$query = "SELECT * FROM dd_content WHERE".$contentquery.$category.$tags.$date.$author." ORDER BY content_date DESC LIMIT $start_from, $ppp;";
$query2 = "SELECT COUNT(*) FROM dd_content WHERE".$contentquery.$category.$tags.$date.$author.";";

if(trim($searchterm5) === ''){
$contentquery = "";
$query = "SELECT * FROM dd_content WHERE".$category.$tags.$date.$author." ORDER BY content_date DESC LIMIT $start_from, $ppp;";
$query2 = "SELECT COUNT(*) FROM dd_content WHERE".$category.$tags.$date.$author.";";
$pos = strpos($query, 'AND');
if ($pos !== false) {
    $newstring = substr_replace($query, '', '31', strlen('AND'));
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
echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";

echo dbsearchbar();
echo '<div class="contentpostscroll">';
if ($results->num_rows > 0) {
echo '<h1 style="display:table; margin:0;">There are '.number_format($searchresultnumbers[0]).' search results.</h1>';
    // output data of each row
    while($row = $results->fetch_assoc()) {
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
	echo '<a href="/console/posts/delete?postid='.$row['content_id'].'" title="Delete" alt="Delete">Delete</a> | <a href="/console/posts/edit?postid='.$row['content_id'].'" title="Edit" alt="Edit">Edit</a> | <a href="/console/posts/comments?postid='.$row['content_id'].'"  title="Comments" alt="Comments">Comments (';echo retrieve_comment_count($row['content_id']); echo')'; echo'</a>';
	echo '</div>';
	echo '<div class="postnumber">';
	echo $count;
	echo '</div>';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	echo '<a href="/'.$row['content_permalink'].'" alt="View post '.$count.'", title="View post '.$count.'">'.$row['content_title'].'</a>';
	echo '</div>';
	echo '<div class="postdate">Posted on '.$row['content_date'].'.</div>';
	echo '<div class="postcategory">Category: '.$row['content_category'].'</div>';
	echo '<div class="posttags">Tags: '.$row['content_tags'].'</div>';
	echo '</div>';
	echo '</div>';
	$count++;
	}
}
echo pagebar($page, $total_pages, $ppp, '5' , '1');
		echo '</div>';
} else {
		echo consolemenu();
echo "<div id='page'>
<div class='center'>There are "; echo $retrive->numberofposts(); echo " posts on this blog.</div>
<a class='nounderline' href='/console/posts/new' alt='Create New Post' title='Create New Post'><div class='createnewpost'>Create New Post</div></a>";
echo dbsearchbar();
    echo "<h1>No search results found.</h1>";
	echo '</div>';
}
}
