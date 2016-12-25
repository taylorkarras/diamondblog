<?php
function consolemenu(){
$retrive = new DB_retrival;
echo "<div id='menu'><div class='menu2'><ul><li><a ".$retrive->isactive('posts')." href='/console/posts/' alt='Posts' title='Posts'>Posts</a></li>";
echo "<li><a ".$retrive->isactive('reports')." href='/console/reports/' alt='Reports' title='Reports'>Reports</a></li>";
if ($retrive->restrictpermissionlevel('3')){
echo "<li><a ".$retrive->isactive('users')." href='/console/users/' alt='Users' title='Users'>User</a></li>";
}else {
echo "<li><a ".$retrive->isactive('users')." href='/console/users/' alt='Users' title='Users'>Users</a></li>";
}
echo "<li><a ".$retrive->isactive('ban')."href='/console/ban/' alt='Ban' title='Ban'>Ban</a></li>";
pluginClass::hook( "console_menu" );
if ($retrive->restrictpermissionlevel('3')){
	
}else {
echo "<li><a ".$retrive->isactive('settings')." href='/console/settings/' alt='Settings' title='Settings'>Settings</a></li>";
} echo "<li><a href='/console/logout/' alt='Logout' title='Logout'>Logout</a></li></ul></div></div>";
}

function sitename()
{
$global = new DB_global;
$titleinit = $global->sqlquery("SELECT site_name FROM dd_settings LIMIT 1;");
$title = $titleinit->fetch_assoc();
return $title['site_name'];
}

function retrieve_post_positive_votes($postid){
	$global = new DB_global;
	$positivevotes1 = $global->sqlquery("SELECT SUM(`cvote_positive`) AS `totalvotespositive` FROM `dd_votes` WHERE `cvote_commentid` = '".$postid."';");
	$positivevotes2 = $positivevotes1->fetch_assoc();
	if (is_null($positivevotes2['totalvotespositive'])){
	return '0';
	} else {
	return $positivevotes2['totalvotespositive'];
	}
}

function retrieve_post_negative_votes($postid){
	$global = new DB_global;
	$negativevotes1 = $global->sqlquery("SELECT SUM(`cvote_negative`) AS `totalvotesnegative` FROM `dd_votes` WHERE `cvote_commentid` = '".$postid."';");
	$negativevotes2 = $negativevotes1->fetch_assoc();
	if (is_null($negativevotes2['totalvotesnegative'])){
	return '0';
	} else {
	return $negativevotes2['totalvotesnegative'];
	}
}

function retrieve_comment_count($postid){
	$global = new DB_global;
$commentcount1 = $global->sqlquery("SELECT comment_id FROM dd_comments WHERE comment_postid = '".$postid."';");
$commentcount2 = $commentcount1->num_rows;
return $commentcount2;
}

function retrieve_page_count(){
	$global = new DB_global;
$pagecount1 = $global->sqlquery("SELECT page_number FROM dd_pages;");
$pagecount2 = $pagecount1->num_rows;
return $pagecount2;
}

function retrieve_pages_status(){
	$global = new DB_global;
	$pagesstatus1 = $global->sqlquery("SELECT * FROM `dd_settings`");
	$pagesstatus2 = $pagesstatus1->fetch_assoc();
	if ($pagesstatus2['pages_on'] == '0' && $pagesstatus2['menu_on'] == '0') {
	return false; } 
	else {
		return true;
	}
}

function navigation()
{
$global = new DB_global;
$navigationinit = $global->sqlquery("SELECT navigation_select FROM dd_settings LIMIT 1;");
$navigation = $navigationinit->fetch_assoc();
if ($navigation['navigation_select']){
echo "<script>$('#page').jscroll({
    nextSelector: 'a.dbnext:last',
    contentSelector: '.contentpostscroll'
})</script>";
}
}

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
		$display = 'style="display:none;"';
	}
	if($lastpage > 1)
	{	
		$pagination .= "<div style=".$display." class=\"pagination\"";
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

function dbsearchbar($searchhint = "shenabled")
{
	$global = new DB_global;
	
	echo '<form method="get" id="search">';
	if (!empty($_GET['query'])){
	$query = " value='".$_GET['query']."'";
	} else {
	$query = '';
	}
	echo "<input type='search' name='dbsearchbar' id='searchbar' placeholder='Search'".$query.">";
	if ($searchhint == 'shenabled'){
	echo "<div class='searchhint'>This searchbar can also search for specific describers as well as words... Here's a couple you can try.
	<br />
	<br />
	<li>“category:” To search by category.</li>
	<li>“tags:” To search by a specific tag or tags.</li>
	<li>“date:” To search by MM/DD/YYYY or by specific month or year.</li>
	<li>“author:” To search for posts by a specific author.</li></div>";
	}
		if ($searchhint == 'shdisabled'){
	}
	echo '<input type="submit" style="display:none;" />';
	echo '</form>';
}
?>
