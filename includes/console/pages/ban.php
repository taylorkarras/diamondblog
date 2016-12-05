<?php
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
echo consolemenu();
echo '<div id="page"><div class="center">Add Ban</div>';
echo '<form id="banadd" method="post">
<label title="addthree"><b>Add IP (v4/v6)/Name/Email:</b></label>
<br /><input type="text" name="addthree"';
echo '<br /><br /><label title="banreason"><b>Ban Reason:</b></label>
<br /><input type="text" name="banreason" >';
echo '<br /><label title="banexpiration"><b>Expires In...:</b></label>';
echo '<br /><div class="smalltext">Must be in "years, months, days, hours, minutes, seconds" format; for permabans, use "never" or "infinite".</div>';
echo '<input type="text" name="banexpiration" >';
echo '<div class="sitescrolling">
<input type="checkbox" name="baneradicatecomments" value="0"> Eradicate comments</div>';
	echo '<script>$(';echo"'";echo'input[type="checkbox"]';echo"').change(function(){
    this.value = (Number(this.checked));
	});</script>";
echo '<input class="postsubmit" name="bansubmit" type="submit" value="Submit">';
echo '</form>';
$global = new DB_global;
		$ss1 = $global->sqlquery("SELECT * FROM dd_settings");
		$ss2 = $ss1->fetch_assoc();
		
$ppp = $ss2['postsperpage'];

if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 

if ($_GET["page"] > '1'){
define ("PAGE", '(Page '.$_GET['page'].')');
}

$result = $global->sqlquery("SELECT * FROM dd_banlist ORDER BY banlist_no DESC LIMIT $start_from, $ppp;");
$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_banlist");
$row2 = $result2->fetch_row(); 
$total_records = $row2[0];
$total_pages = ceil($total_records / $ppp);
	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $start_from - $page + '1';
	}
echo '<br>';
echo dbsearchbar('shdisabled');
echo '<div class="contentpostscroll">';
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
	echo '<a href="/console/ban/unban?unbanid='.$row['banlist_no'].'" title="Unban" alt="Unban">Unban</a>';
	echo '</div>';
	echo '<div class="postnumber">';
	echo $count;
	echo '</div>';
	echo '<div class="postinfobox">';
	echo '<div class="posttitle">';
	if (!empty($row['banlist_ip'])){
	echo $row['banlist_ip'].' (IP Ban)';
	} else if (!empty($row['banlist_name'])){
	echo $row['banlist_name'].' (Name Ban)';
	} else if (!empty($row['banlist_email'])){
	echo $row['banlist_email'].' (Email Ban)';
	}
	echo '</div>';
	echo '<div class="postcategory">Reason: <i>'.$row['banlist_reason'].'</i></div>';
	echo '<div class="posttags">Expires on <i>';
	if ($row['banlist_duration'] == '0000-00-00 00:00:00'){
	echo 'infinite';
	}else {
	echo $row['banlist_duration'];
	}echo '</i></div>';
	echo '</div>';
	echo '</div>';
	$count++;
	}
}
echo pagebar($page, $total_pages, $ppp, '5');
		echo '</div>';
echo '</div>';
} else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>
