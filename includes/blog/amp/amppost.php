<?php
$global = new DB_global;
$check = new DB_check;
$retrive = new DB_retrival;
$postsperpageinit = $global->sqlquery("SELECT * FROM dd_settings;");
$postsperpage = $postsperpageinit->fetch_assoc();
$pattern = '/data-oembed-url=*("(.*?)")/';
$link = explode("/", $_SERVER['REQUEST_URI']);
$resultpost = $global->sqlquery("SELECT * FROM dd_content WHERE content_permalink = '".$link[1]."' LIMIT 1");
$resultpostint = $resultpost->fetch_assoc();
preg_match_all($pattern, $resultpostint['content_description'], $oembedvalues);
$date=date_create($resultpostint['content_date']);
$ampembedcode = $resultpostint['content_embedcode'];
$ampdescription = $resultpostint['content_description'];
$ampsearcharray = array();
$ampreplacementarray = array();
preg_match('/[^< *img*src *= *>"\']?(http[^"\']*)+(png|jpg|gif)/' , $resultpostint['content_description'], $image);
if($resultpostint['content_permalink'] == $link[1]){
echo '<!doctype html>
<html amp lang="en">
  <head>
    <meta charset="utf-8">
    <title>'.$resultpostint['content_title'].' - '.$postsperpage['site_name'].'</title>
    <link rel="canonical" href="https://'.$_SERVER['HTTP_HOST'].'/'.$link[1].'" />
<style amp-custom>';
			pluginClass::hook( "amp_style" );
echo file_get_contents("https://".$_SERVER['HTTP_HOST']."/themes/".THEME."/styles/ampstyle.css");
  
echo '
  .title-bar amp-img{
	      display:table;
		  margin:auto;
  }
  
  .content {
    padding: 10px;
    margin: auto;
    font-size: 22px;
	max-width: 350px;
}
	.title {
	    text-align: center;
	}
  
ul.meta li {
    list-styla: none;
    display: inline-block;
    line-height: 24px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    max-width: 300px;
}
  
  ul.meta {
    padding: 24px 0 0 0;
    margin: 0 0 24px 0;
}
	.unsupported {
    background-color: #ff0000;
    padding: 30px;
    color: #ffffff;
}
	amp-iframe {
		padding:10px;
		max-width: 350px;
		margin:auto;
	}
</style>
	    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "NewsArticle",
        "headline": "'.$resultpostint['content_title'].'",
        "datePublished": "'.$date->format(DateTime::W3C).'",
		"description": "'.strip_tags($resultpostint['content_summary']).'",
		"author": {
		"@type": "Person",
		"name": "'.$retrive->realname($resultpostint['content_author']).'"
		},
		"publisher": {
		"@type": "Organization",
		"name": "'.$postsperpage['site_name'].'"';
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/logo.png')) {
        echo ',"logo": {
          "@type": "ImageObject",
          "url": "https://'.$_SERVER['HTTP_HOST'].'/images/logo.png",
          "width": 264,
          "height": 50
        }';
		}
      echo '},';
	  if (!empty($image[0])){
		echo '"image": {
		"@type": "ImageObject",';
			echo '"url": "'.$image[0].'",
		  "height": 400,
		  "width": 225
		}';
	  } else {
	  		echo '"image": {
		"@type": "ImageObject",
          "url": "https://'.$_SERVER['HTTP_HOST'].'/images/logo.png",
          "width": 264,
          "height": 50
		}';
	  }
	  echo '
	  }
    </script>';
echo file_get_contents("https://".$_SERVER['HTTP_HOST']."/themes/".THEME."/styles/ampfont.php");
echo '
  <script async custom-element="amp-analytics" src="https://cdn.ampproject.org/v0/amp-analytics-0.1.js"></script>
  <script async custom-element="amp-dynamic-css-classes" src="https://cdn.ampproject.org/v0/amp-dynamic-css-classes-0.1.js"></script>
  <script async custom-element="amp-anim" src="https://cdn.ampproject.org/v0/amp-anim-0.1.js"></script>
  <script async custom-element="amp-fit-text" src="https://cdn.ampproject.org/v0/amp-fit-text-0.1.js"></script>
  <script async custom-element="amp-font" src="https://cdn.ampproject.org/v0/amp-font-0.1.js"></script>
  <script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>
  <script async custom-element="amp-image-lightbox" src="https://cdn.ampproject.org/v0/amp-image-lightbox-0.1.js"></script>
  <script async custom-element="amp-lightbox" src="https://cdn.ampproject.org/v0/amp-lightbox-0.1.js"></script>';
 if(preg_grep('/reddit/', $oembedvalues[1]) or preg_match('/reddit/', $resultpostint['content_link'])){
echo '<script async custom-element="amp-reddit" src="https://cdn.ampproject.org/v0/amp-reddit-0.1.js"></script>';
 }
 echo '<script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>
  <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
  <script async custom-element="amp-dailymotion" src="https://cdn.ampproject.org/v0/amp-dailymotion-0.1.js"></script>
  <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script>
	  <script async custom-element="amp-vine" src="https://cdn.ampproject.org/v0/amp-vine-0.1.js"></script>
	  <script async custom-element="amp-vimeo" src="https://cdn.ampproject.org/v0/amp-vimeo-0.1.js"></script>
	  <script async custom-element="amp-sidebar" src="https://cdn.ampproject.org/v0/amp-sidebar-0.1.js"></script>
	  <script async custom-element="amp-soundcloud" src="https://cdn.ampproject.org/v0/amp-soundcloud-0.1.js"></script>
	<script async custom-element="amp-pinterest" src="https://cdn.ampproject.org/v0/amp-pinterest-0.1.js"></script>
	<script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
</head>
<body>
		<nav class="title-bar"><a href="/">';
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/logo.png')) {
		 echo'<amp-img class="logo" src="https://'.$_SERVER['HTTP_HOST'].'/images/logo.png"
      width="264"
      height="50"
      alt="'.$postsperpage['site_name'].'"></amp-img>';
		} else {
		echo '<div class="sitename">'.$postsperpage['site_name'].'</div>';
		}
		echo'
		</a></nav>
		<div class="content">';
		// Title
        echo '<h1 class="title">';echo $resultpostint['content_title']; echo '</h1>';
		// Date
		echo '<ul class="meta">';
		echo '<li class="byline">';
		echo '<span class="author">'.$retrive->realname($resultpostint['content_author']).' - </span></li>';
		echo '<li><time datetime="'.$date->format(DateTime::W3C).'">Posted on '.date_format($date, $postsperpage['date_format']." ".$postsperpage['time_format']).'</time></li>
		</ul>';
		// Post
		if(preg_grep('/instagram/', $oembedvalues[1])){
		$instagramconvert = preg_grep('/instagram/', $oembedvalues[1]);
		foreach ($instagramconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$value3 = explode('/', $value2);
		$instagramregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$instagramamp = '<amp-instagram
    data-shortcode="'.$value3[4].'"
    width="400"
    height="400"
    layout="responsive">
</amp-instagram>';
		array_push($ampsearcharray, $instagramregex);
		array_push($ampreplacementarray, $instagramamp);
		array_push($ampsearcharray, '/<p style=.*?<\/script>/');
		array_push($ampreplacementarray, '');
		}
		}
		if(preg_grep('/twitter/', $oembedvalues[1])){
		$twitterconvert = preg_grep('/twitter/', $oembedvalues[1]);
		foreach ($twitterconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$value3 = explode('/', $value2);
		$twitterregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$twitteramp = '<amp-twitter
    data-tweetid="'.$value3[5].'"
    width="486"
    height="657"
	data-cards="hidden"
    layout="responsive">
</amp-twitter>';
		array_push($ampsearcharray, $twitterregex);
		array_push($ampreplacementarray, $twitteramp);
		}
		}
		if(preg_grep('/youtube/', $oembedvalues[1])){
		$youtubeconvert = preg_grep('/youtube/', $oembedvalues[1]);
		foreach ($youtubeconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$value3 = explode('=', $value2);
		$youtuberegex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$youtubeamp = '<amp-youtube
    data-videoid="'.$value3[1].'"
    width="480"
    height="270"
    layout="responsive">
</amp-youtube>';
		array_push($ampsearcharray, $youtuberegex);
		array_push($ampreplacementarray, $youtubeamp);
		}
		}
		if(preg_grep('/vine/', $oembedvalues[1])){
		$vineconvert = preg_grep('/vine/', $oembedvalues[1]);
		foreach ($vineconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$value3 = explode('/', $value2);
		$vineregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$vineamp = '<amp-vine 
    data-vineid="'.$value3[4].'"
    width="400"
    height="400"
    layout="responsive">
</amp-vine>';
		array_push($ampsearcharray, $vineregex);
		array_push($ampreplacementarray, $vineamp);
		}
		}
		if(preg_grep('/vimeo/', $oembedvalues[1])){
		$vimeoconvert = preg_grep('/vimeo/', $oembedvalues[1]);
		foreach ($vimeoconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$value3 = explode('/', $value2);
		$vimeoregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$vimeoamp = '<amp-vimeo 
    data-videoid="'.$value3[3].'"
    width="500"
    height="281"
    layout="responsive">
</amp-vimeo>';
		array_push($ampsearcharray, $vimeoregex);
		array_push($ampreplacementarray, $vimeoamp);
		}
		}
		if(preg_grep('/pinterest/', $oembedvalues[1])){
		$pinterestconvert = preg_grep('/pinterest/', $oembedvalues[1]);
		foreach ($pinterestconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$pinterestregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$pinterestamp = '<amp-pinterest width=245 height=330
  data-do="embedPin"
  data-url="'.$value2.'">
</amp-pinterest>';
		array_push($ampsearcharray, $pinterestregex);
		array_push($ampreplacementarray, $pinterestamp);
		}
		}
		if(preg_grep('/soundcloud/', $oembedvalues[1])){
		$soundcloudconvert = preg_grep('/soundcloud/', $oembedvalues[1]);
		foreach ($soundcloudconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$value3 = str_replace ("data-oembed-url=", '', $value2);
		$value4 = file_get_contents('https://noembed.com/embed?url='.$value3);
		preg_match('/tracks%2F([^&]+)&/', $value4, $value5);
		$soundcloudregex = '/<div data-oembed-url="'.preg_quote($value3, "/").'">.*?(div>)([^\s]+.?){1,3}(>)/';
		$soundcloudamp = '<amp-soundcloud
    data-trackid="'.$value5[1].'"
    height="200"
    layout="fixed-height">
</amp-soundcloud>';
		array_push($ampsearcharray, $soundcloudregex);
		array_push($ampreplacementarray, $soundcloudamp);
		}
		}
		if(preg_grep('/dailymotion/', $oembedvalues[1])){
		$dailymotionconvert = preg_grep('/dailymotion/', $oembedvalues[1]);
		foreach ($dailymotionconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$value3 = explode('/', $value2);
		$dailymotionregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$dailymotionamp = '<amp-dailymotion
    data-videoid="'.$value3[4].'"
    layout="responsive"
    width="480" height="270"></amp-dailymotion>';
		array_push($ampsearcharray, $dailymotionregex);
		array_push($ampreplacementarray, $dailymotionamp);
		}
		}
		if(preg_grep('/facebook/', $oembedvalues[1])){
		$facebookconvert = preg_grep('/facebook/', $oembedvalues[1]);
		foreach ($facebookconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$facebookregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$facebookamp = '<amp-facebook width=486 height=657
  layout="responsive"
  data-href="'.$value2.'">
</amp-facebook>';
		array_push($ampsearcharray, $facebookregex);
		array_push($ampreplacementarray, $facebookamp);
		}
		}
		if(preg_grep('/reddit/', $oembedvalues[1])){
		$redditconvert = preg_grep('/reddit/', $oembedvalues[1]);
		foreach ($redditconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$valuecomment = explode('/', $value);
		if(isset($valuecomment[8])){
		$redditregex2 = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$redditamp2 = '<amp-reddit width=400 height=200
  layout="responsive"
  data-embedtype="comment"
  data-src="'.$value2.'">
</amp-reddit>';
		array_push($ampsearcharray, $redditregex2);
		array_push($ampreplacementarray, $redditamp2);
		} else {
		$redditregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		$redditamp = '<amp-reddit width=400 height=200
  layout="responsive"
  data-embedtype="post"
  data-src="'.$value2.'">
</amp-reddit>';
		array_push($ampsearcharray, $redditregex);
		array_push($ampreplacementarray, $redditamp);
		}
		}
		}
		$patternimg = '/img.*? \s*(src="(.*?)")/';
		if(preg_match_all($patternimg, $resultpostint['content_description'], $imgsrcvalues)){
		foreach ($imgsrcvalues[2] as $value){
		$value2 = str_replace ('"', '', $value);
		$imgsize = getimagesize($value2);
		$imgregex = '/<img.*? \s*(src="(.*'.preg_quote($value2, '/').')").* \/>/';
		$imageamp = '<amp-img src="'.$value2.'"
      width="'.$imgsize[0].'"
      height="'.$imgsize[1].'"
      layout="responsive"
      alt=""></amp-img>';
		array_push($ampsearcharray, $imgregex);
		array_push($ampreplacementarray, $imageamp);
		}
		}
		
		//embed code
		if (isset($resultpostint['content_link'])){
			if(preg_match('/soundcloud/', $resultpostint['content_link'])){
				$link = file_get_contents('https://noembed.com/embed?url='.$resultpostint['content_link']);
		preg_match('/tracks%2F([^&]+)&/', $link, $link2);
				echo '<amp-soundcloud 
    data-trackid="'.$link2[1].'"
    height="657"
    layout="fixed-height">
</amp-soundcloud>';
			} else if(preg_match('/youtube/', $resultpostint['content_link'])){
		$link = explode('=', $resultpostint['content_link']);
		echo '<amp-youtube
    data-videoid="'.$link[1].'"
    width="480"
    height="270"
    layout="responsive">
</amp-youtube>';
			} else if(preg_match('/vimeo/', $resultpostint['content_link'])){
		$link = explode('/', $resultpostint['content_link']);
		echo '<amp-vimeo 
    data-videoid="'.$link[3].'"
    width="500"
    height="281"
    layout="responsive">
</amp-vimeo>';
			} else if(preg_match('/dailymotion/', $resultpostint['content_link'])){
		$link = explode('/', $resultpostint['content_link']);
		echo '<amp-dailymotion
    data-videoid="'.$link[4].'"
    layout="responsive"
    width="480" height="270"></amp-dailymotion>';
			} else if(preg_match('/twitter/', $resultpostint['content_link'])){
		$link = explode('/', $resultpostint['content_link']);
		echo '<amp-twitter
    data-tweetid="'.$link[5].'"
    width="486"
    height="657"
	data-cards="hidden"
    layout="responsive">
</amp-twitter>';
			} else if(preg_match('/instagram/', $resultpostint['content_link'])){
		$link = explode('/', $resultpostint['content_link']);
		echo '<amp-instagram
    data-shortcode="'.$link[4].'"
    width="400"
    height="400"
    layout="responsive">
</amp-instagram>';
			} else if(preg_match('/reddit/', $resultpostint['content_link'])){
				$ifredditcomment = explode('/', $resultpostint['content_link']);
					if (isset($ifredditcomment[8])){
		echo '<amp-reddit width=400 height=200
  layout="responsive"
  data-embedtype="comment"
  data-src="'.$resultpostint['content_link'].'">
</amp-reddit>';
					} else {
		echo '<amp-reddit width=400 height=200
  layout="responsive"
  data-embedtype="post"
  data-src="'.$resultpostint['content_link'].'">
</amp-reddit>';
					}}
			else if (preg_match('/jpg/', $resultpostint['content_link']) or preg_match('/gif/', $resultpostint['content_link']) or preg_match('/png/', $resultpostint['content_link']) or preg_match('/gif/', $resultpostint['content_link'])){
				$imgsize = getimagesize($resultpostint['content_link']);
				echo '<amp-img src="'.$resultpostint['content_link'].'"
      width="'.$imgsize[0].'"
      height="'.$imgsize[1].'"
      layout="responsive"
      alt=""></amp-img>';
			} else if(preg_match('/imgur/', $resultpostint['content_link']) or preg_match('/tumblr/', $resultpostint['content_link']) or preg_match('/mixcloud/', $resultpostint['content_link']) or preg_match('/audiomack/', $resultpostint['content_link']) or preg_match('/bandcamp/', $resultpostint['content_link'])){
		echo '<div class="unsupported">This type of embed is unsupported on AMP pages (not by us), please visit the page on the regular website to see the embed.)</div>';
		}
		}
		$replace1 = preg_replace($ampsearcharray, $ampreplacementarray, $resultpostint['content_description']);
		preg_match_all($pattern, $replace1, $oembedvalues2);
		$ampsearcharray2 = array();
		$ampreplacearray2 = array();
		foreach ($oembedvalues2[1] as $value){
		$value2 = str_replace ('"', '', $value);
		$embed = file_get_contents("https://iframe.ly/api/oembed?url=".$value2."&iframe=amp&api_key=dcfb3943c025e9e7b8f24e");
		$embed2 = json_decode($embed, true);
		$restregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?(div>)([^\s]+.?){1,3}(>)/';
		array_push($ampsearcharray2, $restregex);
		array_push($ampreplacearray2, $embed2['html']);
		}
		echo preg_replace($ampsearcharray2, $ampreplacearray2, $replace1);
		
		//echo preg_replace('/<div data-oembed-url=.*?(div>)([^\s]+.?){1,3}(>)/', '<div class="unsupported">This type of embed is unsupported on AMP pages (not by us), please visit the page on the regular website to see the embed.)</div>', $replace1);
			pluginClass::hook( "amp_post_bottom" );
			pluginClass::hook( "amp_bottom" );
echo '  <br> <amp-iframe width="480"
      height="720"
      layout="responsive"
      sandbox="allow-scripts allow-forms"
      allowfullscreen
      frameborder="0"
      src="https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].'/comments?postid='.$resultpostint['content_id'].'">
  </amp-iframe>';
		echo '</div></body>
</html>';
exit;}
