<?php

$global = new DB_global;
$retrive = new DB_retrival;

$url = urldecode($_GET['query']);
$urlstripped1 = preg_replace('/[^ ]*:"[^"]+"/', '', $url);
$urlstripped2 = preg_replace('/[^ ]*:\S+/im', '', $urlstripped1);
$urlstripped3 = 
$urlexploded = str_getcsv($urlstripped2, ", ", '"');
  if(empty($url)){
echo consolemenu();
echo "<div id='page'>";
echo "<div class='center'>There are "; echo $retrive->numberofusers(); echo " users on this blog including admins, contributors and mods.</div>
<a class='nounderline' href='/console/users/new' alt='Create New User' title='Create New User'><div class='createnewpost'>Create New User</div></a>";
echo dbsearchbar();
echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
$haserror = true;
  }
//Status
  if (preg_match('/^status:.*/', $url) or preg_match('/, status:.*/', $url)){
preg_match_all ('/status:\S+/im', $url, $status2);
if(empty($status2[0])){
echo consolemenu();
echo "<div id='page'>";
echo "<div class='center'>There are "; echo $retrive->numberofusers(); echo " users on this blog including admins, contributors and mods.</div>
<a class='nounderline' href='/console/users/new' alt='Create New User' title='Create New User'><div class='createnewpost'>Create New User</div></a>";
echo dbsearchbar();
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$status3 = implode(':',$status2[0]);
$replace = array('status:', ',');
$status4 = str_replace($replace, '', $status3);
if (strpos($status4, 'admin') !== false){
$status = " AND user_isadmin = '1' ";
  } else if (strpos($status4, 'contrib') !== false){
$status = " AND user_iscontributor = '1' ";
  } else if (strpos($status4, 'mod') !== false){
$status = " AND user_ismod = '1' ";
  }
  }}
  
  //Date
if (preg_match('/^date:.*/', $url) or preg_match('/, date:.*/', $url)){
preg_match_all ('/date:\S+/', $url, $date2);
if(empty($date2[0])){
echo consolemenu();
echo "<div id='page'>";
echo "<div class='center'>There are "; echo $retrive->numberofusers(); echo " users on this blog including admins, contributors and mods.</div>
<a class='nounderline' href='/console/users/new' alt='Create New User' title='Create New User'><div class='createnewpost'>Create New User</div></a>";
echo dbsearchbar();
	echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
	$haserror = true;
  } else {
$date3 = implode(':',$date2[0]);
$replace = array('date:', ',');
$date4 = str_replace($replace, '', $date3);
if (!preg_match("/^(\d{2})\/(\d{2})\/(\d{4})$/", $date4)){
echo consolemenu();
echo "<div id='page'>";
echo "<div class='center'>There are "; echo $retrive->numberofusers(); echo " users on this blog including admins, contributors and mods.</div>
<a class='nounderline' href='/console/users/new' alt='Create New User' title='Create New User'><div class='createnewpost'>Create New User</div></a>";
	echo '<h1 style="display:table; margin:0;">Please enter the date in the MM/DD/YYYY format.</h1>';
	$haserror = true;
} else {
	$date5 = explode('/', $date4);
	$date = " AND user_datejoined = '".$date5[2].'/'.$date5[1].'/'.$date5[0]."%' ";
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

$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_users");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $ppp);
	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $ppp - '1';
	}

	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 
	
$contentquery = " user_username LIKE ('".$searchterm5."') OR user_realname LIKE ('".$searchterm5."')";
$query = "SELECT * FROM dd_users WHERE".$contentquery.$status.$date." ORDER BY user_id DESC LIMIT $start_from, $ppp;";

if(trim($searchterm5) === ''){
$contentquery = "";
$query = "SELECT * FROM dd_users WHERE".$status.$date." ORDER BY user_id DESC LIMIT $start_from, $ppp;";
$pos = strpos($query, 'AND');
if ($pos !== false) {
    $newstring = substr_replace($query, '', '29', strlen('AND'));
}
$results = $global->sqlquery($newstring);
}
else {
$results = $global->sqlquery($query);
}
$searchresultnumbers = $results->num_rows;
echo consolemenu();
echo "<div id='page'>";
echo "<div class='center'>There are "; echo $retrive->numberofusers(); echo " users on this blog including admins, contributors and mods.</div>
<a class='nounderline' href='/console/users/new' alt='Create New User' title='Create New User'><div class='createnewpost'>Create New User</div></a>";

	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $ppp - '1';
	}
echo dbsearchbar();
echo '<div class="contentpostscroll">';
if ($results->num_rows > 0) {
    // output data of each row
    while($row = $results->fetch_assoc()) {
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
	if ($row['user_id'] == '1'){
	} else {
	echo '<a href="/console/users/delete?userid='.$row['user_id'].'" title="Delete" alt="Delete">Delete</a> | ';
	} echo '<a href="/console/users/edit?userid='.$row['user_id'].'" title="Edit" alt="Edit">Edit</a>';
	echo '</div>';
	echo '<div class="postnumber">';
	echo $count;
	echo '</div>';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	echo '<a href="/'.$row['user_username'].'" alt="View post '.$count.'", title="View post '.$count.'">'.$row['user_realname'].'</a> ('.$row['user_username'].') ('.$retrive->userstatus($row['user_username']).')';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	$count++;
	}
}
echo pagebar($page, $total_pages, $ppp, '5');
		echo '</div>';
echo "</div>";
}