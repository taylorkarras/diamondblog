<?php
$global = new DB_global;
$check = new DB_check;
$retrive = new DB_retrival;

$ssinit = $global->sqlquery("SELECT * FROM dd_settings");
$ss = $ssinit->fetch_assoc();
$category_link = str_replace('_', ' ', $_GET['category']);
$author_link = str_replace('_', ' ', $_GET['author']);
  header("Content-Type: application/xml;");

echo '<?xml version="1.0" encoding="utf-8"?>
<rss version="2.0" xmlns:atom="http://www.w3.org/2005/Atom">
  <channel>
  <atom:link href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'" rel="self" type="application/rss+xml" />';
  if (isset($_GET['category'])){
	echo '<title>Category - "'.$category_link.'": '.$ss['site_name'].'</title>
  <link>https://'.$_SERVER['HTTP_HOST'].'/category?name='.$category_link.'</link>
  <description>Results for the category "'.$category_link.'" on '.$ss['site_name'].'</description>';  
  } else if (isset($_GET['author'])){
	echo '<title>Author - "'.$author_link.'": '.$ss['site_name'].'</title>
  <link>https://'.$_SERVER['HTTP_HOST'].'/author?name='.$author_link.'</link>
  <description>Results for the author "'.$author_link.'" on '.$ss['site_name'].'</description>';  
  } else {
  echo '<title>'.$ss['site_name'].'</title>
  <link>https://'.$_SERVER['HTTP_HOST'].'</link>
  <description>'.$ss['site_title'].'</description>';
  }
  echo '<language>en-us</language>';

$date=date_create($row['content_date']);

if (isset($_GET['category'])){
$result = $global->sqlquery("SELECT * FROM dd_content WHERE content_category = '".$category_link."' ORDER BY content_date DESC LIMIT 10");
} else if (isset($_GET['author'])){
$userid = $retrive->userid($author_link);
$result = $global->sqlquery("SELECT * FROM dd_content WHERE content_author = '".$userid."' ORDER BY content_date DESC LIMIT 10");
} else {
$result = $global->sqlquery("SELECT * FROM dd_content ORDER BY content_date DESC LIMIT 10");
}
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
		echo '<item>
		';
		// Title
        echo '<title>'.htmlentities($row['content_title'], ENT_XML1).'</title>
		';
		// Date
		echo '<pubDate>'.date_format($date,"D, d M Y H:i:s O").'</pubDate>
		';
		// Post
		echo '<link>https://'.$_SERVER['HTTP_HOST'].'/'.$row['content_permalink'].'</link>
		';
		echo '<guid>https://'.$_SERVER['HTTP_HOST'].'/'.$row['content_shortlink'].'</guid>
		';
		$fix = str_replace("&nbsp;", "&#160;", $row['content_summary']);
		$fix2 = str_replace ("&Delta", "&#916", $fix);
		echo '<description>'.strip_tags($fix2).'</description>
		';
		echo '</item>
		';
    }
}
echo '
</channel>
</rss>';
exit;
