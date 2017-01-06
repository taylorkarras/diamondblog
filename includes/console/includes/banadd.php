<?php 
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
$global = new DB_global;
$user = new DB_userfunctions;
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/plugins.php';
pluginClass::initialize();
unset($_SESSION["errors"]);

	if (isset ($_GET['unbanid'])){
	
$global->sqlquery("DELETE FROM `dd_banlist` WHERE `banlist_no` = '".$_GET['unbanid']."'");
$global->sqlquery("DROP EVENT IF EXISTS ban_autoexpire_".$_GET['unbanid']."");
header("Location: /console/ban");
	
	} else if (isset($_POST))
    {

		if(trim($_POST['addthree']) === '')  {
		$_SESSION['errors']['addthree'] = "You must ban something.";
		$hasError = true;	
		} else {
		if (strpos($_POST['addthree'], '.') xor strpos($_POST['addthree'], '@')){
			if (substr_count($_POST['addthree'], '.') !== 3 && !ctype_digit($_POST['addthree']) && !filter_var($_POST['addthree'], FILTER_VALIDATE_IP)){
		$_SESSION['errors']['addthree'] = "An IPV4 address must have 3 dots, be valid and be all numbers!";
		$hasError = true;
	} else {
		$banip = $_POST['addthree'];
		}}
	if (strpos($_POST['addthree'], ':')){
			if (substr_count($_POST['addthree'], ':') !== 7 && preg_match('/[^a-z0-9]/', $_POST['addthree'])){
		$_SESSION['errors']['addthree'] = "An IPV6 address must have 7 colons, lowercase letters and numbers!";
		$hasError = true;
	} else {
		$banip = $_POST['addthree'];
	}
		}
		if (strpos($_POST['addthree'], '@')){
			if (!$user->valid_email($_POST['addthree'])) {$_SESSION['errors']['addthree'] = 'An email address must contain a "@" and a ".com"!';
			}
			else {
			$banemail = $_POST['addthree'];
			}
		}
		
		if (!preg_match('/[^!#$%^&*()_+|}{"?><,;\=-`~]/', $_POST['addthree'])) {
		$_SESSION['errors']['addthree'] = "Names can only have letters & numbers!";
		$hasError = true;
		} else {
			if (filter_var($_POST['addthree'], FILTER_VALIDATE_IP) or $user->valid_email($_POST['addthree'])){
			$banname = '';
			} else {
			$banname = $global->real_escape_string($_POST['addthree']);}
		}
		}

		if(trim($_POST['banreason']) === '')  {
		$_SESSION['errors']['banreason'] = "You cannot leave this field blank.";
		$hasError = true;	
	} else {
		$banreason = $_POST['banreason'];
	}
	
			if(trim($_POST['banexpiration']) == '' or strpos($_POST['banexpiration'], '/') or strpos($_POST['addthree'], ':')) {
		$_SESSION['errors']['banexpiration'] = "Please fill in when the ban expires in the proper format.";
		$hasError = true;	
	} else {
		$banexpiration = $_POST['banexpiration'];
	}
	
			if($_POST['banmoderatecomments'] == '1' && $_POST['baneradicatecomments'] == '1'){
		$_SESSION['errors']['banmoderatecomments'] = "Cannot eradicate comments while enforcing moderation.";
		$hasError = true;		
			}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
		$banexpirationseconds = strtotime(+$banexpiration);
		if ($_POST['banexpiration'] == 'infinite' or $_POST['banexpiration'] == 'never'){
		$banexpirationdate = '0000-00-00 00:00:00
';} else{
		$banexpirationdate = date("Y-m-d h:i:s", strtotime(+$banexpiration));
		}
		
		$id = $global->sqllastid("INSERT INTO `dd_banlist` (`banlist_no`, `banlist_ip`, `banlist_name`, `banlist_email`, `banlist_duration`, `banlist_reason`, `banlist_moderation`) VALUES (NULL, '".$banip."', '".$banname."', '".$banemail."', '".$banexpirationdate."', '".$banreason."', '".$_POST['banmoderatecomments']."')");
		if ($_POST['banexpiration'] == 'infinite' or $_POST['banexpiration'] == 'never'){}
		else{
		$global->sqlquery("CREATE EVENT IF NOT EXISTS ban_autoexpire_".$id." ON SCHEDULE AT CURRENT_TIMESTAMP + INTERVAL ".$banexpirationseconds." SECOND ON COMPLETION NOT PRESERVE DO DELETE FROM dd_banlist WHERE banlist_no = '".$id."'");
		}
		if ($_POST['baneradicatecomments'] == '1' && isset($banip)){
		$global->sqlquery("DELETE FROM `dd_comments` WHERE `dd_comments`.`comment_ip` = '".$banip."'");
		pluginClass::hook( "ban_eradicate" );
		} else if ($_POST['baneradicatecomments'] == '1' && isset($banemail)){
		$global->sqlquery("DELETE FROM `dd_comments` WHERE `dd_comments`.`comment_email` = '".$banemail."'");
		}
						        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['respresprefresh'] = true;
				$resp['message'] = '
	<p>Ban successfully added.</p>';
			
                echo json_encode($resp);
		        exit;
	}
	}
	}
} else {  header("HTTP/1.0 403 Forbidden");
 die();
	}
?>
