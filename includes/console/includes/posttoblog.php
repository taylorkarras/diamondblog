<?php
use Embed\Embed;
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
	if ($retrive->restrictpermissionlevel('2')){
 header("HTTP/1.0 403 Forbidden");
 die();
	}
require_once $_SERVER['DOCUMENT_ROOT'].'/includes/plugins.php';
pluginClass::initialize();
$global = new DB_global;
unset($GLOBALS['embedlink']);
unset($_SESSION["errors"]);
    if (isset($_POST))
    {
		if(trim($_POST['posttitle']) === '')  {
		$_SESSION['errors']['posttitle'] = "Please enter a post title.";
		$hasError = true;	
	} else {
		$posttitle = $_POST['posttitle'];
		$GLOBALS['posttitle'] = $posttitle;
	}
	
		if(!empty($_POST['postmedialink']) or !empty($_POST['postcontent']))  {	
		$postmedialink = $_POST['postmedialink'];
		$postcontent = str_replace("'", '"', $_POST['postcontent']);
		if (str_word_count($postcontent) > '56'){
		$threedots = "...";
		}
		$postsummary2 = preg_replace('/((\w+\W*){56}(\w+))(.*)/', '${1}', $_POST['postcontent']).$threedots.'</p>';
		$postsummary = str_replace("'", '"', $postsummary2);
		$GLOBALS['$postsummary'] = $postsummary;
	} else {
		$_SESSION['errors']['oneortheother'] = "Please either enter a link or enter post content, you can enter both if you want.";
		$hasError = true;
	}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}}
		
		if (strpos($_POST['postmedialink'], 'bandcamp') == true){$bandcamplink = file_get_contents($_POST['postmedialink']);
		$bandcamp_id1 = strstr($bandcamplink, 'album_embed_data' );
		$unnecessaryarray = array(',', '{', ':', '}', '+');
		$bandcamp_id2 = str_replace($unnecessaryarray, '', $bandcamp_id1);
		$bandcamp_id3 = explode(' ', $bandcamp_id2);
		$embedlink = '<iframe style="border: 0; width: 100%; height: 120px;" src="https://bandcamp.com/EmbeddedPlayer/album='.$bandcamp_id3[18].'/size=large/bgcol=ffffff/linkcol=0687f5/tracklist=false/artwork=small/transparent=true/" seamless></iframe>';
		}
		else if (strpos($_POST['postmedialink'], 'vimeo') == true)
		{
			$vimeolink = explode('/', $_POST['postmedialink']);
			$embedlink = '<iframe src="https://player.vimeo.com/video/'.$vimeolink[3].'" width="640" height="360" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
		}
		else if (strpos($_POST['postmedialink'], 'dailymotion') == true)
		{
			$dailymotionlink1 = str_replace('/', '_', $_POST['postmedialink']);
			$dailymotionlink2 = explode('_', $dailymotionlink1);
			$embedlink = '<iframe frameborder="0" width="640" height="360" src="https://dailymotion.com/embed/video/'.$dailymotionlink2[4].'" allowfullscreen></iframe>';
		}
		else if (strpos($_POST['postmedialink'], 'audiomack') == true){
			$audiomacklink1 = strstr($_POST['postmedialink'], 'song' );
			$audiomacklink2 = str_replace('song/', '', $audiomacklink1);
			$embedlink = '<iframe src="http://www.audiomack.com/embed4/'.$audiomacklink2.'" scrolling="no" width="100%" height="110" scrollbars="no" frameborder="0"></iframe>';
		}
		else if (strpos($_POST['postmedialink'], 'twitter') == true or strpos($_POST['postmedialink'], 'instagram') == true or strpos($_POST['postmedialink'], 'facebook') == true or strpos($_POST['postmedialink'], 'imgur') == true or strpos($_POST['postmedialink'], 'reddit') == true or strpos($_POST['postmedialink'], 'soundcloud') == true or strpos($_POST['postmedialink'], 'tumblr') == true or strpos($_POST['postmedialink'], 'youtube') == true){
			$embed = Embed::create($_POST['postmedialink']);
			$embedlink = $embed->code;
			$GLOBALS['embedlinkinstagram'] = $embed->thumbnail_url;
			$GLOBALS['embedlinkyoutube'] = $embed->image;
			$GLOBALS['embedlinkimgur'] = $embed->media_url;
			$GLOBALS['embedlinksoundcloud'] = $embed->thumbnail_url;
		}
		else if (strpos($_POST['postmedialink'], 'vine') == true){
			$vine = explode ('/', $_POST['postmedialink']);
			$embedlink = '<iframe src="https://vine.co/v/'.$vine[4].'/embed/simple" width="480" height="480" frameborder="0"></iframe><script src="https://platform.vine.co/static/scripts/embed.js"></script>';
		}
		else if (strpos($_POST['postmedialink'], 'mixcloud') == true){
			$embedlink = '<iframe width="100%" height="120" src="https://www.mixcloud.com/widget/iframe/?feed='.$_POST['postmedialink'].'&hide_cover=1&light=1" frameborder="0"></iframe>';
		}
		else if (strpos($_POST['postmedialink'], jpg) == true or strpos($_POST['postmedialink'], jpeg) == true or strpos($_POST['postmedialink'], png) == true or strpos($_POST['postmedialink'], gif) == true or strpos($_POST['postmedialink'], gifv) == true ){
			$embedlink = '<img src="'.$_POST['postmedialink'].'" alt="External Image" title="External Image"></img>';
			$GLOBALS['embedlink'] = $_POST['postmedialink'];
		}
		
		$GLOBALS['category'] = $_POST['category'];
		$plarray1 = array(',', '!', "'", ';', '&', '=', '?', ' ');
		$permalink1 = str_replace($plarray1, '_', $posttitle);
		$permalink2 = strtolower($permalink1);
		
		if (!empty($_POST['postidtoedit'])){
			$global->sqlquery("UPDATE `dd_content` SET `content_link` = '".$postmedialink."', `content_embedcode` = '".$embedlink."', `content_description` = '".$postcontent."', `content_summary` = '".$postsummary."', `content_title` = '".$posttitle."', `content_category` = '".$_POST['category']."', `content_tags` = '".$_POST['tags']."', `content_permalink` = '".$permalink2."' WHERE `dd_content`.`content_id` = '".$_POST['postidtoedit']."'");	
			
						        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resp'] = true;
				$resp['message'] = '
	<p>Edited post successfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
		} else {
			$GLOBALS['category'] = $_POST['category'];
			$shortlink = $global->generate_code(10);
			$GLOBALS['shortlink'] = $shortlink;
			$global->sqlquery("INSERT INTO `dd_content` (`content_id`, `content_link`, `content_embedcode`, `content_description`, `content_summary`, `content_title`, `content_category`, `content_tags`, `content_permalink`, `content_shortlink`, `content_date`, `content_author`) VALUES (NULL, '".$postmedialink."', '".$embedlink."', '".$postcontent."', '".$postsummary."', '".$posttitle."', '".$_POST['category']."', '".$posttags."', '".$permalink2."', '".$shortlink."', NOW(), '".$_COOKIE['userID']."')");
			
		if (str_word_count($_POST['tags']) == '1'){
		$global->sqlquery("INSERT INTO `dd_tags` (`tag_number`, `tag_name`) VALUES (NULL, '".$_POST['tags']."')");
		} else {		
		$posttags = explode(',', $_POST['tags']);
		foreach ($posttags as $posttag) {
			$similartaginit = $global->sqlquery("SELECT tag_name FROM `dd_tags` WHERE `tag_name` = '".$posttag."';");
			$similartag = $similartaginit->fetch_assoc();
		if ($similartag['tag_name'] !== $posttag){
			$global->sqlquery("INSERT INTO `dd_tags` (`tag_number`, `tag_name`) VALUES (NULL, '".$posttag."')");
		}
		}
		}
			
			pluginClass::hook( "inc_post_form_bottom" );
			
							        		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			
				$resp = array();
				$resp['resprefresh'] = true;
				$resp['url'] = 'https://'.$_SERVER['HTTP_HOST'].'/console/posts';
				$resp['message'] = '
	<p>Post created sucessfully.</p>';
			
                echo json_encode($resp);
		        exit;
	}
		}
	}
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}