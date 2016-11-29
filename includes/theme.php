<?php
//Theme selection//
function defaulttheme()
{
$global = new DB_global;
$themeinit = $global->sqlquery('SELECT default_theme FROM dd_settings');
$theme = $themeinit->fetch_assoc();
return $theme['default_theme'];
}

define ('THEME', defaulttheme());

$templates->addFolder('themeroot', ''.$_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME.'/');
$templates->addFolder('themestyles', ''.$_SERVER['DOCUMENT_ROOT'].'/themes/'.THEME.'/styles');

function themeheader()
{
global $templates;
echo $templates->render('themeroot::head');
}

function essentialhead()
{
		$global = new DB_global;
		$settings = $global->sqlquery("SELECT * from dd_settings");
		$settings2 = $settings->fetch_assoc();
if (strpos($_SERVER['REQUEST_URI'], "category")){
$category = str_replace('name=', '', $_SERVER['QUERY_STRING']);
echo '<link rel="alternate" type="application/rss+xml" title="Category - &quot;'.$category.'&quot;: '.$settings2['site_name'].'" href="https://'.$_SERVER['HTTP_HOST'].'/feed?category='.$category.'" />';
} else if (strpos($_SERVER['REQUEST_URI'], "author")){
$category = str_replace('name=', '', $_SERVER['QUERY_STRING']);
echo '<link rel="alternate" type="application/rss+xml" title="Author - &quot;'.$category.'&quot;: '.$settings2['site_name'].'" href="https://'.$_SERVER['HTTP_HOST'].'/feed?author='.$category.'" />';
} else {
echo '<link rel="alternate" type="application/rss+xml" title="'.$settings2['site_name'].'" href="https://'.$_SERVER['HTTP_HOST'].'/feed" />';
}
echo '<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<meta name="mobile-web-app-capable" content="yes">';
echo'<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/jquery-2.2.3.min.js"></script>
<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/ckeditor/ckeditor.js"></script>
<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/ckeditor/adapters/jquery.js"></script>
<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/jquery.jscroll.min.js"></script>
<script src="https://'.$_SERVER['HTTP_HOST'].'/scripts/jquery.mousewheel.min.js"></script>
<script>
    var CKEDITOR_BASEPATH = "/scripts/ckeditor/";
</script>';
echo '
<link rel="apple-touch-icon" sizes="57x57" href="images/favicon-57px.png">
<link rel="apple-touch-icon" sizes="76x76" href="images/favicon-76px.png">
<link rel="apple-touch-icon" sizes="120x120" href="images/favicon-120px.png">
<link rel="apple-touch-icon" sizes="152x152" href="images/favicon-152px.png">
<link rel="apple-touch-icon" sizes="192x192" href="images/favicon-192px.png">
<link rel="icon" type="image/png" sizes="192x192"  href="images/favicon-192px.png">
<link rel="icon" type="image/png" sizes="32x32" href="images/favicon-32px.png">
<link rel="icon" type="image/png" sizes="96x96" href="images/favicon-96px.png">
<link rel="icon" type="image/png" sizes="16x16" href="images/favicon-16px.png">
<link rel="manifest" href="./manifest.json">
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="msapplication-TileImage" content="images/favicon-144px.png">
<meta name="theme-color" content="'.$settings2['site_color'].'" />';
$link = str_replace('/', '', $_SERVER['REQUEST_URI']);

$resultpage = $global->sqlquery("SELECT * FROM dd_pages WHERE page_link = '$link' LIMIT 1");
$resultpage2 = $resultpage->fetch_assoc();

$resultpost = $global->sqlquery("SELECT * FROM dd_content WHERE content_permalink = '$link' LIMIT 1");
$resultpost2 = $resultpost->fetch_assoc();
$url = "https://".$_SERVER['HTTP_HOST'].str_replace('/', '', $_SERVER['REQUEST_URI']);
if ($url === $settings2['site_url'] && !empty($settings2['site_metadescription'])){
echo '<meta name="description" content="'.$settings2['site_metadescription'].'">';
} else if (!empty($resultpost2['content_summary'])){
echo '<meta name="description" content="'.strip_tags($resultpost2['content_summary']).'">';
} else if (!empty($resultpage2['page_title'])){
echo '<meta name="decription" content="'.$resultpage2['page_title'].'">';
}
preg_match('/[^< *img*src *= *>"\']?([^"\']*)+(png|jpg|gif)/' , $resultpost2['content_description'], $image); 
if (!empty($resultpost2['content_title'])){
echo '<meta property="og:title" content="'.$resultpost2['content_title'].'">';
}
if (!empty($resultpost2['content_permalink'])){
echo '<meta property="og:url" content="http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'">';
}
if (!empty($resultpost2['content_description'])){
echo '<meta property="og:image" content="'.$image[0].'">';
echo '<meta property="og:type" content="article">';
} else {
echo '<meta property="og:image" content="http://'.$_SERVER['HTTP_HOST'].'images/logo.png">';
echo '<meta property="og:type" content="article">';
}
if (!empty($resultpost2['content_summary'])){
echo '<meta property="og:description" content="'.strip_tags($resultpost2['content_summary']).'">';
echo '<meta property="og:site_name" content="'.$settings2['site_name'].'">';
}
}

function themestyle()
{
echo '<link href="https://'.$_SERVER['HTTP_HOST'].'/themes/'.THEME.'/styles/style.css" rel="stylesheet" type="text/css">';
}

function themestylecustom($script)
{
echo 'https://'.$_SERVER['HTTP_HOST'].'/themes/'.THEME.'/styles/'.$script;
}

function themejs($script)
{
echo '<script src="https://'.$_SERVER['HTTP_HOST'].'/themes/'.THEME.'/js/'.$script.'"></script>';
}

function navigation()
{
$global = new DB_global;
$navigationinit = $global->sqlquery("SELECT navigation_select FROM dd_settings LIMIT 1;");
$navigation = $navigationinit->fetch_assoc();
if ($navigation['navigation_select']){
echo "<script>
$('#blog').jscroll({
    nextSelector: 'a.dbnext:last',
    contentSelector: '.contentpostscroll'
})
</script>";
}
}

function sitename()
{
$global = new DB_global;
if (defined('PREPEND')){
	echo ''.PREPEND.' - ';
}
$titleinit = $global->sqlquery("SELECT site_name FROM dd_settings LIMIT 1;");
$title = $titleinit->fetch_assoc();
echo $title['site_name'];
}

function sitetitle()
{
$global = new DB_global;
$titleinit = $global->sqlquery("SELECT site_title FROM dd_settings LIMIT 1;");
$title = $titleinit->fetch_assoc();
echo $title['site_title'];
}

function amp()
{
$url = str_replace('/', '', $_SERVER['REQUEST_URI']);
$global = new DB_global;
$linkinit = $global->sqlquery("SELECT * FROM dd_content WHERE content_permalink = '".$url."'");
$link = $linkinit->fetch_assoc();
if (strpos($_SERVER['REQUEST_URI'], $link['content_permalink'])){
echo '<link rel="amphtml" href="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/amp">';
}
}
function dbsearchbar()
{
	$global = new DB_global;
$titleinit = $global->sqlquery("SELECT site_name FROM dd_settings LIMIT 1;");
$title = $titleinit->fetch_assoc();
	
	echo '<form method="post" id="search">';
	echo "<input type='search' name='dbsearchbar' id='searchbar' placeholder='Search ".$title['site_name']."' value='".$_GET['query']."'>";
	echo "<div class='searchhint'>This searchbar can also search for specific describers as well as words... Here's a couple you can try.
	<br />
	<br />
	<li>“category:” To search by category.</li>
	<li>“tags:” To search by a specific tag or tags.</li>
	<li>“date:” To search by MM/DD/YYYY or by specific month or year.</li>
	<li>“author:” To search for posts by a specific author.</li></div>";
	echo '<input type="submit" style="display:none;" />';
	echo '</form>';
}

function dbmenu1()
{
	$global = new DB_global;
$settingsinit = $global->sqlquery("SELECT * FROM dd_settings;");
$settings = $settingsinit->fetch_assoc();
	$menuinit = $global->sqlquery("SELECT * FROM dd_pages ORDER BY page_menu_pos ASC;");
if ($settings['menu_on'] == '1'){
	echo' <div id="menu"><ul>';
if ($menuinit->num_rows > 0) {
    // output data of each row
    while($menurow = $menuinit->fetch_assoc()) {
		if ($menurow['page_is_link'] == '1'){
	echo' <li><a href="'.$menurow['page_external_link'].'" title="'.$menurow['page_title'].'." alt="'.$menurow['page_title'].'" ">'.$menurow['page_title'].'</a></li>';
		} else {
	echo' <li><a href="/'.$menurow['page_link'].'" title="'.$menurow['page_title'].'" alt="'.$menurow['page_title'].'" ">'.$menurow['page_title'].'</a></li>';
		}
}
}
echo' </ul></div>';
}
}

//function to return the pagination string
function pagebar($page, $totalitems, $limit = 15, $adjacents = 1, $andsign = 0)
{
$global = new DB_global;
$ifnavenabled2 = $global->sqlquery("SELECT navigation_select FROM dd_settings");
$ifnavenabled = $ifnavenabled2->fetch_assoc();	
	//defaults
	if(!$adjacents) $adjacents = 1;
	if(!$limit) $limit = 15;
	if(!$page) $page = 1;
	if($andsign == 1){
		$symbol=$_SERVER['REQUEST_URI']."&";
	} else {
		$symbol="?";
	}
	
	//other vars
	$prev = $page - 1;									//previous page is page - 1
	$next = $page + 1;									//next page is page + 1
	$lastpage = $totalitems;				//lastpage is = total items / items per page, rounded up.
	$lpm1 = $lastpage - 1;								//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if ($ifnavenabled['navigation_select'] == '1'){
		$display = 'style="display:none"';
	}
	if($lastpage > 1)
	{	
		$pagination .= "<div $display class=\"pagination\"";
		if($margin || $padding)
		{
			$pagination .= " style=\"";
			if($margin)
				$pagination .= "margin: $margin;";
			if($padding)
				$pagination .= "padding: $padding;";
			$pagination .= "\"";
		}
		$pagination .= ">";

		//previous button
		if ($page > 1) 
			$pagination .= "<a href=\"".$symbol."page=$prev\">< prev</a>";
		else
			$pagination .= "<span class=\"disabled\">< prev</span>";	
		
		//pages	
		if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
		{	
			for ($counter = 1; $counter <= $lastpage; $counter++)
			{
				if ($counter == $page)
					$pagination .= "<span class=\"current\">$counter</span>";
				else
					$pagination .= "<a href=\"".$symbol."page=". $counter . "\">$counter</a>";					
			}
		}
		elseif($lastpage >= 7 + ($adjacents * 2))	//enough pages to hide some
		{
			//close to beginning; only hide later pages
			if($page < 1 + ($adjacents * 3))		
			{
				for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
				{
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"".$symbol."page". $counter . "\">$counter</a>";					
				}
				$pagination .= "<span class=\"elipses\">...</span>";
				$pagination .= "<a href=\"".$symbol."page" . $lpm1 . "\">$lpm1</a>";
				$pagination .= "<a href=\"".$symbol."page". $lastpage . "\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination .= "<a href=\"".$symbol."page". "1\">1</a>";
				$pagination .= "<a href=\"".$symbol."page". "2\">2</a>";
				$pagination .= "<span class=\"elipses\">...</span>";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"".$symbol."page". $counter . "\">$counter</a>";					
				}
				$pagination .= "...";
				$pagination .= "<a href=\"".$symbol."page". $lpm1 . "\">$lpm1</a>";
				$pagination .= "<a href=\"".$symbol."page". $lastpage . "\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination .= "<a href=\"".$symbol."page". "1\">1</a>";
				$pagination .= "<a href=\"".$symbol."page". "2\">2</a>";
				$pagination .= "<span class=\"elipses\">...</span>";
				for ($counter = $lastpage - (1 + ($adjacents * 3)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination .= "<span class=\"current\">$counter</span>";
					else
						$pagination .= "<a href=\"".$symbol."page". $counter . "\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination .= "<a class='dbnext' href=\"".$symbol."page=". $next . "\">next ></a>";
		else
			$pagination .= "<span class=\"disabled\">next ></span>";
		$pagination .= "</div>\n";
	}
	
	return $pagination;

}

function rssdetect(){
$global = new DB_global;
$settingsinit = $global->sqlquery("SELECT * FROM dd_settings;");
$settings = $settingsinit->fetch_assoc();
if (strpos($_SERVER['REQUEST_URI'], "category")){
$category = str_replace('name=', '', $_SERVER['QUERY_STRING']);
define ("RSSHEAD", '<link rel="alternate" type="application/rss+xml" title="Category - &quot;'.$category.'&quot;: '.$settings['site_name'].'" href="https://'.$_SERVER['HTTP_HOST'].'/feed?category='.$category.'" />');
} else if (strpos($_SERVER['REQUEST_URI'], "author")){
$category = str_replace('name=', '', $_SERVER['QUERY_STRING']);
define ("RSSHEAD", '<link rel="alternate" type="application/rss+xml" title="Author - &quot;'.$category.'&quot;: '.$settings['site_name'].'" href="https://'.$_SERVER['HTTP_HOST'].'/feed?author='.$category.'" />');
} else {
define ("RSSHEAD", '<link rel="alternate" type="application/rss+xml" title="'.$settings['site_name'].'" href="https://'.$_SERVER['HTTP_HOST'].'/feed" />');
}
}

function themelogo(){
$global = new DB_global;
$themelogo2 = $global->sqlquery("SELECT * FROM dd_settings");
$themelogo = $themelogo2->fetch_assoc();
if ($themelogo['logo_on'] == '1'){
if(file_exists($_SERVER['DOCUMENT_ROOT'].'/images/logo.png')){
echo '<a href="/"><img src="/images/logo.png" title="Home" alt="Home/Logo"></a>';} else {
$global = new DB_global;
$titleinit = $global->sqlquery("SELECT site_name FROM dd_settings LIMIT 1;");
$title = $titleinit->fetch_assoc();
echo '<div class="sitename"><a href="/">'.$title['site_name'].'</a></div>';
}
}
else {
$titleinit = $global->sqlquery("SELECT site_name FROM dd_settings LIMIT 1;");
$title = $titleinit->fetch_assoc();
echo '<div class="sitename"><a href="/">'.$title['site_name'].'</a></div>';
}
}
function rendertheme(){
global $templates;
echo $templates->render('themeroot::index');
}
?>
