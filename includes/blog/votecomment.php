<?php

$global = new DB_global;

$check = new DB_check;
if ($check->ifbanned()){}
else {

	$totalvotes = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_postid = '".$_GET["postid"]."' AND comment_id = '".$_GET["commentid"]."';");
		$totalvotesinit = $totalvotes->fetch_array();

		$IP = $_SERVER['REMOTE_ADDR'];
		
	$positivevote = $global->sqlquery("SELECT * FROM `dd_votes` WHERE `cvote_ip` = '".$IP."' AND `cvote_commentid` = '".$totalvotesinit['comment_id']."';");
	$positivevoteinit = $positivevote->fetch_array();
	$voteip = $positivevoteinit['cvote_ip'];
	
if ($_GET["vote"] == "positive" && $positivevoteinit['cvote_positive'] == '0' && $positivevoteinit['cvote_negative'] == '1' && $voteip > 0) {
	
	$global->sqlquery("UPDATE `dd_votes` SET `cvote_voted` = '1', `cvote_positive` = '1', `cvote_negative` = '0' WHERE `cvote_ip` = '".$IP."' AND `cvote_commentid` = '".$totalvotesinit['comment_id']."';");
	
}

else if ($_GET["vote"] == "positive" && $positivevoteinit['cvote_positive'] == '1' && $positivevoteinit['cvote_negative'] == '0' && $voteip > 0) {
	
	$global->sqlquery("DELETE FROM `dd_votes` WHERE `cvote_ip` = '".$IP."' AND `cvote_commentid` = '".$totalvotesinit['comment_id']."';");
	
}
		
else if ($_GET["vote"] == "positive" && empty($voteip)) {
	
	$global->sqlquery("INSERT INTO `dd_votes` (`cvote_ip`, `cvote_commentid`, `cvote_p_id`, `cvote_voted`, `cvote_positive`, `cvote_negative`) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$totalvotesinit['comment_id']."', '".$_GET["postid"]."', '1', '1', '0')");
	}

if ($_GET["vote"] == "negative" && $positivevoteinit['cvote_positive'] == '1' && $positivevoteinit['cvote_negative'] == '0' && $voteip > 0) {
	
	$global->sqlquery("UPDATE `dd_votes` SET `cvote_voted` = '1', `cvote_positive` = '0', `cvote_negative` = '1' WHERE `cvote_ip` = '".$IP."' AND `cvote_commentid` = '".$totalvotesinit['comment_id']."';");
	
}

else if ($_GET["vote"] == "negative" && $positivevoteinit['cvote_positive'] == '0' && $positivevoteinit['cvote_negative'] == '1' && $voteip > 0) {
	
	$global->sqlquery("DELETE FROM `dd_votes` WHERE `cvote_ip` = '".$IP."' AND `cvote_commentid` = '".$totalvotesinit['comment_id']."';");

}
		
else if ($_GET["vote"] == "negative" && empty($voteip)) {
	
	$global->sqlquery("INSERT INTO `dd_votes` (`cvote_ip`, `cvote_commentid`, `cvote_p_id`,  `cvote_voted`, `cvote_positive`, `cvote_negative`) VALUES ('".$_SERVER['REMOTE_ADDR']."', '".$totalvotesinit['comment_id']."', '".$_GET["postid"]."', '1', '0', '1')");
	
}

header("Location: " . $_SERVER["HTTP_REFERER"]);

}
