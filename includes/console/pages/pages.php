<?php

$global = new DB_global;
$retrive = new DB_retrival;
		$ss1 = $global->sqlquery("SELECT * FROM dd_settings");
		$ss2 = $ss1->fetch_assoc();
if ($retrive->isLoggedIn() == true){
if ($retrive->restrictpermissionlevel('3')){

echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to view this section!</div></div>';

} else {
echo consolemenu();
echo "<div id='page'><div class='center'><a href='/console/settings/categoriesandpages/mail' title='Mail' alt='Mail'>Mail</a> | <a href='/console/settings/categoriesandpages/tags' title='Tags' alt='Tags'>Tags</a> | <a href='/console/settings/categoriesandpages' title='Categories' alt='Categories'>Categories</a> | Pages</div>
<br /><div class='center'>"; if(retrieve_pages_status() == false) {
echo'Pages are currently not enabled, <a href="/console/settings/categoriesandpages/2/pageswitch?position=on" title="Enable Pages" alt="Enable Pages">enable?</a>'; }
else {
echo 'Pages are currently enabled, you have '.retrieve_page_count().' pages, <a href="/console/settings/categoriesandpages/2/pageswitch?position=off" title="Disable Pages" alt="Disable Pages">disable?</a>';} echo "</div>
"; if(retrieve_pages_status() == false) {} else {
echo"<a class='nounderline' href='/console/pages/new' alt='Create New Page' title='Create New Page'><div class='createnewpost'>Create New Page</div></a>";}

if(retrieve_pages_status() == false) {}
else {

$ppp = $ss2['postsperpage'];

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 

$result = $global->sqlquery("SELECT * FROM dd_pages ORDER BY page_number DESC LIMIT $start_from, $ppp; ");
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_pages");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $ppp);
	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $ppp - '1';
	}
	
echo '<div class="contentpostscroll">';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
	echo '<a href="/console/pages/delete?pageid='.$row['page_number'].'" title="Delete" alt="Delete">Delete</a> | <a href="/console/pages/edit?pageid='.$row['page_number'].'" title="Edit" alt="Edit">Edit</a>';
	echo '</div>';
	echo '<div class="postnumber">';
	echo $count;
	echo '</div>';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	echo '<a href="/'.$row['page_link'].'" alt="View page '.$count.'", title="View page '.$count.'">'.$row['page_title'].'</a>';
	echo '</div>';
	echo '</div>';
	echo '</div>';
	$count++;
	}
}
echo pagebar($page, $total_pages, $ppp, '5');
		echo '</div>';
}
}} else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>