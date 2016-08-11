<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
if ($retrive->restrictpermissionlevel('3')){
header('Location: https://'.$_SERVER['HTTP_HOST'].'/console/users/edit?userid='.$_COOKIE['userID']);
} else {
echo consolemenu();
echo "<div id='page'>";
echo "<div class='center'>There are "; echo number_format($retrive->numberofusers()); echo " users on this blog including admins, contributors and mods.</div>
<a class='nounderline' href='/console/users/new' alt='Create New User' title='Create New User'><div class='createnewpost'>Create New User</div></a>";

$global = new DB_global;
		$ss1 = $global->sqlquery("SELECT * FROM dd_settings");
		$ss2 = $ss1->fetch_assoc();
		
$ppp = $ss2['postsperpage'];

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 

$result = $global->sqlquery("SELECT * FROM dd_users ORDER BY user_id ASC LIMIT $start_from, $ppp;");
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
echo dbsearchbar('shdisabled');
echo '<div class="contentpostscroll">';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
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
}}  else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>