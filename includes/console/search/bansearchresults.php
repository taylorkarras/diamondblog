<?php

$global = new DB_global;
$retrive = new DB_retrival;

$url = urldecode($_GET['query']);
  if(empty($url)){
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
echo dbsearchbar();
echo '<h1 style="display:table; margin:0;">No search terms entered, please enter search terms above.</h1>';
$haserror = true;
  }

if ($haserror == true){}
else {
$postsperpageinit = $global->sqlquery("SELECT postsperpage FROM dd_settings LIMIT 1;");
$postsperpage = $postsperpageinit->fetch_assoc();
$ppp = $postsperpage['postsperpage'];

$result2 = $global->sqlquery("SELECT COUNT(*) FROM dd_banlist");
$row2 = $result2->fetch_row();
		if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
	if ($page == '1'){
	$count = $page;
	}
	else {
	$count = $page + $ppp - '1';
	}

	if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; }; 
$start_from = ($page-1) * $ppp; 
	
$query = "SELECT * FROM dd_banlist WHERE banlist_name LIKE ('%".$url."%') OR banlist_email LIKE ('%".$url."%') OR banlist_ip LIKE ('%".$url."%') ORDER BY banlist_no DESC LIMIT $start_from, $ppp;";
$query2 = "SELECT COUNT(*) FROM dd_banlist WHERE banlist_name LIKE ('%".$url."%') OR banlist_email LIKE ('%".$url."%') OR banlist_ip LIKE ('%".$url."%')";

$results = $global->sqlquery($query);
$results2 = $global->sqlquery($query2);
$searchresultnumbers = $results2->fetch_row();
$total_records = $searchresultnumbers[0];
$total_pages = ceil($total_records / $ppp);

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
echo '<br>';
echo dbsearchbar('shdisabled');
echo '<div class="contentpostscroll">';
if ($results->num_rows > 0) {
    // output data of each row
    while($row = $results->fetch_assoc()) {
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
}
