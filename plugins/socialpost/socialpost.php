<?php
if( !defined( "INPROCESS" ) ){
 header("HTTP/1.0 403 Forbidden");
 die();
}

			require $_SERVER['DOCUMENT_ROOT']."/plugins/socialpost/twitteroauth/autoload.php";
			use Abraham\TwitterOAuth\TwitterOAuth;
			require $_SERVER['DOCUMENT_ROOT'].'/plugins/socialpost/Facebook/autoload.php';
			require $_SERVER['DOCUMENT_ROOT'].'/plugins/socialpost/Pinterest/autoload.php';
			use DirkGroenen\Pinterest\Pinterest;

class socialpost extends plugin {

    static function inc_post_form_bottom(){
				$global = new DB_global;
		$social1 = $global->sqlquery("SELECT * FROM ddp_socialpost");
		$social2 = $social1->fetch_assoc();
				if ($_POST['posttotwitter'] == '1'){
		$tconnection = new TwitterOAuth($social2['twitter_apikey'], $social2['twitter_apisecret'], $social2['twitter_accesstoken'], $social2['twitter_accesstokensecret']);
		var_dump($tconnection->post("statuses/update", ["status" => 'New in "'.$_POST['category'].'" - '.$GLOBALS['posttitle'].' https://'.$_SERVER['HTTP_HOST'].'/'.$GLOBALS['shortlink'].' #vaporwave']));
				}
				if ($_POST['posttofacebook'] == '1'){
		$fb = new Facebook\Facebook([
 'app_id' => $social2['facebook_apikey'],
 'app_secret' => $social2['facebook_apisecret'],
 'default_graph_version' => 'v2.2',
]);
 if (isset($GLOBALS['embedlink'])){
$embedlink = $GLOBALS['embedlink'];
 } else if (isset($GLOBALS['embedlinkinstagram'])) {
$embedlink = $GLOBALS['embedlinkinstagram'];
 } else if (isset($GLOBALS['embedlinkyoutube'])) {
$embedlink = $GLOBALS['embedlinkyoutube'];
 } else if (isset($GLOBALS['embedlinkimgur'])) {
$embedlink = $GLOBALS['embedlinkimgur'];
 } else if (isset($GLOBALS['embedlinksoundcloud'])) {
$embedlink = $GLOBALS['embedlinksoundcloud'];
 }

 if (isset($embedlink)){
$linkData = [
 'link' => $_SERVER['HTTP_HOST'].'/'.$GLOBALS['shortlink'],
 'message' => strip_tags($GLOBALS['$postsummary']),
 'image' => $embedlink,
 'name' => $GLOBALS['posttitle']
];
 } else {
$linkData = [
 'link' => $_SERVER['HTTP_HOST'].'/'.$GLOBALS['shortlink'],
 'message' => strip_tags($GLOBALS['$postsummary']),
 'name' => $GLOBALS['posttitle']
];
 }
$pageAccessToken = $social2['facebook_accesstoken'];
	
$fb->post('/'.$social2['facebook_pagename'].'/feed', $linkData, $pageAccessToken);
				}
				if ($_POST['posttopinterest'] == '1'){
 if (isset($GLOBALS['embedlink'])){
$embedlink = $GLOBALS['embedlink'];
 } else if (isset($GLOBALS['embedlinkinstagram'])) {
$embedlink = $GLOBALS['embedlinkinstagram'];
 } else if (isset($GLOBALS['embedlinkyoutube'])) {
$embedlink = $GLOBALS['embedlinkyoutube'];
 } else if (isset($GLOBALS['embedlinkimgur'])) {
$embedlink = $GLOBALS['embedlinkimgur'];
 } else if (isset($GLOBALS['embedlinksoundcloud'])) {
$embedlink = $GLOBALS['embedlinksoundcloud'];
 }

$pinterest = new Pinterest($social2['pinterest_apikey'], $social2['pinterest_apisecret']);
$pinterest->auth->setOAuthToken($social2['pinterest_token']);
$pinterest->pins->create(array(
    "note"          => $GLOBALS['posttitle'],
    "image_url"     => $embedlink,
    "board"         => $social2['pinterest_board'],
	"link"          => 'http://'.$_SERVER['HTTP_HOST'].'/'.$GLOBALS['shortlink']
));
				}
    }
	
    static function post_form_bottom(){
		$global = new DB_global;
			if (empty($_GET["postid"])){
		$ifenabled1 = $global->sqlquery("SELECT * FROM ddp_socialpost");
		$ifenabled2 = $ifenabled1->fetch_assoc();
        echo '<div class="sitescrolling">';
		if($ifenabled2['twitter_enabled'] == '1'){
		echo '<br><input type="checkbox" name="posttotwitter" value="1" checked> Post to Twitter';
				}
		if($ifenabled2['facebook_enabled'] == '1'){
		echo '<br><input type="checkbox" name="posttofacebook" value="1" checked> Post to Facebook';
		}
				if($ifenabled2['pinterest_enabled'] == '1'){
		echo '<br><input type="checkbox" name="posttopinterest" value="1" checked> Post to Pinterest';
				}
		echo '</div>';
		echo '<script>$(';echo"'";echo'input[type="checkbox"]';echo"').change(function(){
    this.value = (Number(this.checked));
	});</script>";
			}
    }
}
?>