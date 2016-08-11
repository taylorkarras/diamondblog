<?php
$global = new DB_global;
$check = new DB_check;
$retrive = new DB_retrival;
$postsperpageinit = $global->sqlquery("SELECT * FROM dd_settings;");
$postsperpage = $postsperpageinit->fetch_assoc();
$templateinit = $global->sqlquery("SELECT * FROM dd_templates;");
$template = $templateinit->fetch_assoc();

$link = explode("/", $_SERVER['REQUEST_URI']);
$resultpost = $global->sqlquery("SELECT * FROM dd_content WHERE content_permalink = '".$link[1]."' LIMIT 1");
$resultpostint = $resultpost->fetch_assoc();
$date=date_create($resultpostint['content_date']);

$ampembedcode = $resultpostint['content_embedcode'];
$ampdescription = $resultpostint['content_description'];
$ampsearcharray = array();
$ampreplacementarray = array();
if($resultpostint['content_permalink'] == $link[1]){
	
echo '<!doctype html>
<html amp lang="en">
  <head>
    <meta charset="utf-8">
    <title>'.$resultpostint['content_title'].' - '.$postsperpage['site_name'].'</title>
    <link rel="canonical" href="https://'.$_SERVER['HTTP_HOST'].'/'.$link[1].'" />
<style amp-custom>';

echo file_get_contents("https://".$_SERVER['HTTP_HOST']."/themes/".THEME."/styles/ampstyle.css");
  
echo '
  .title-bar amp-img{
	      display:table;
		  margin:auto;
  }
  
  .content {
    width: 640px;
    margin: auto;
    font-size: 22px;
}

	.title {
	    text-align: center;
	}
  
ul.meta li {
    list-style: none;
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
</style>
	    <meta name="viewport" content="width=device-width,minimum-scale=1,initial-scale=1">
    <script type="application/ld+json">
      {
        "@context": "http://schema.org",
        "@type": "';
		if ($resultpostint['content_category'] == 'Reviews' or $resultpostint['content_category'] == 'Articles' or $resultpostint['content_category'] == 'Site News' or $resultpostint['content_category'] == 'Spotlight' or $resultpostint['content_category'] == 'Interviews' or $resultpostint['content_category'] == 'Opinion' or $resultpostint['content_category'] == 'News')
		{ echo 'NewsArticle';
	    } else if ($resultpostint['content_category'] == 'Videos')
	    { echo 'VideoObject';}
	else { echo 'ImageObject'; }
		echo '
		",
        "headline": "'.$resultpostint['content_title'].'",
        "datePublished": "'.$date->format(DateTime::W3C).'",
		'; if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/logo.png')) {
          echo '"image": [
		  "https://'.$_SERVER['HTTP_HOST'].'/images/logo.png"
		  ]';
		}
		echo '
    </script>
  <script async custom-element="amp-dynamic-css-classes" src="https://cdn.ampproject.org/v0/amp-dynamic-css-classes-0.1.js"></script>
  <script async custom-element="amp-anim" src="https://cdn.ampproject.org/v0/amp-anim-0.1.js"></script>
  <script async custom-element="amp-fit-text" src="https://cdn.ampproject.org/v0/amp-fit-text-0.1.js"></script>
  <script async custom-element="amp-font" src="https://cdn.ampproject.org/v0/amp-font-0.1.js"></script>
  <script async custom-element="amp-instagram" src="https://cdn.ampproject.org/v0/amp-instagram-0.1.js"></script>
  <script async custom-element="amp-image-lightbox" src="https://cdn.ampproject.org/v0/amp-image-lightbox-0.1.js"></script>
  <script async custom-element="amp-lightbox" src="https://cdn.ampproject.org/v0/amp-lightbox-0.1.js"></script>
  <script async custom-element="amp-twitter" src="https://cdn.ampproject.org/v0/amp-twitter-0.1.js"></script>
  <script async custom-element="amp-youtube" src="https://cdn.ampproject.org/v0/amp-youtube-0.1.js"></script>
  <script async custom-element="amp-dailymotion" src="https://cdn.ampproject.org/v0/amp-dailymotion-0.1.js"></script>
  <script async custom-element="amp-iframe" src="https://cdn.ampproject.org/v0/amp-iframe-0.1.js"></script></script>
	  <script async custom-element="amp-vine" src="https://cdn.ampproject.org/v0/amp-vine-0.1.js"></script>
	  <script async custom-element="amp-vimeo" src="https://cdn.ampproject.org/v0/amp-vimeo-0.1.js"></script>
	  <script async custom-element="amp-soundcloud" src="https://cdn.ampproject.org/v0/amp-soundcloud-0.1.js"></script>
	<script async custom-element="amp-pinterest" src="https://cdn.ampproject.org/v0/amp-pinterest-0.1.js"></script>
	<script async custom-element="amp-facebook" src="https://cdn.ampproject.org/v0/amp-facebook-0.1.js"></script>
    <style amp-boilerplate>body{-webkit-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-moz-animation:-amp-start 8s steps(1,end) 0s 1 normal both;-ms-animation:-amp-start 8s steps(1,end) 0s 1 normal both;animation:-amp-start 8s steps(1,end) 0s 1 normal both}@-webkit-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-moz-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-ms-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@-o-keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}@keyframes -amp-start{from{visibility:hidden}to{visibility:visible}}</style><noscript><style amp-boilerplate>body{-webkit-animation:none;-moz-animation:none;-ms-animation:none;animation:none}</style></noscript>
    <script async src="https://cdn.ampproject.org/v0.js"></script>
</head>
<body>
		<nav class="title-bar">';
		if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/logo.png')) {
		 echo'<amp-img class="logo" src="https://'.$_SERVER['HTTP_HOST'].'/images/logo.png"
      width="264"
      height="50"
      alt="'.$postsperpage['site_name'].'"></amp-img>';
		} else {
		echo '<div class="sitename">'.$postsperpage['site_name'].'</div>';
		}
		echo'
		</nav>
		<div class="content">';
		// Title
        echo '<h1 class="title">';echo $resultpostint['content_title']; echo '</h1>';
		// Date
		echo '<ul class="meta">';
		echo '<li class="byline">';
		echo '<span class="author">'.$retrive->realname($resultpostint['content_author']).' - </span></li>';
		echo '<li><time datetime="'.$date->format(DateTime::W3C).'">Posted on '.date_format($date, $postsperpage['date_format']." ".$postsperpage['time_format']).'</time></li>
		</ul>';
		$pattern = '/data-oembed-url=*("(.*?)")/';
		// Post
		preg_match_all($pattern, $resultpostint['content_description'], $oembedvalues);
		if(preg_grep('/instagram/', $oembedvalues[1])){
		$instagramconvert = preg_grep('/instagram/', $oembedvalues[1]);
		foreach ($instagramconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$value3 = explode('/', $value2);
		$instagramregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
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
		$twitterregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
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
		$youtuberegex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
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
		$vineregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
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
		$vimeoregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
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
		if(preg_grep('/soundcloud/', $oembedvalues[1])){
		$soundcloudconvert = preg_grep('/soundcloud/', $oembedvalues[1]);
		foreach ($soundcloudconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$value3 = file_get_contents('https://noembed.com/embed?url='.$value2);
		preg_match('/tracks%2F([^&]+)&/', $value3, $value4);
		$soundcloudregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
		$soundcloudamp = '<amp-soundcloud 
    data-trackid="'.$value4[1].'"
    height="657"
    layout="fixed-height">
</amp-soundcloud>';
		array_push($ampsearcharray, $soundcloudregex);
		array_push($ampreplacementarray, $soundcloudamp);
		}
		}
		if(preg_grep('/pinterest/', $oembedvalues[1])){
		$pinterestconvert = preg_grep('/pinterest/', $oembedvalues[1]);
		foreach ($pinterestconvert as $value){
		$value2 = str_replace ('"', '', $value);
		$pinterestregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
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
		$value3 = file_get_contents('https://noembed.com/embed?url='.$value2);
		preg_match('/tracks%2F([^&]+)&/', $value3, $value4);
		$soundcloudregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
		$soundcloudamp = '<amp-soundcloud 
    data-trackid="'.$value4[1].'"
    height="657"
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
		$dailymotionregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
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
		$facebookregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
		$facebookamp = '<amp-facebook width=486 height=657
  layout="responsive"
  data-href="'.$value2.'">
</amp-facebook>';
		array_push($ampsearcharray, $facebookregex);
		array_push($ampreplacementarray, $facebookamp);
		}
		}
		$patternimg = '/img.*? \s*(src="(.*?)")/';
		if(preg_match_all($patternimg, $resultpostint['content_description'], $imgsrcvalues)){
		foreach ($imgsrcvalues[2] as $value){
		$value2 = str_replace ('"', '', $value);
		$imgregex = '/<img.*? \s*(src="(.*'.preg_quote($value2, '/').')").* \/>/';
		$imageamp = '<amp-img src="'.$value2.'"
      width="1080"
      height="610"
      layout="responsive"
      alt=""></amp-img>';
		array_push($ampsearcharray, $imgregex);
		array_push($ampreplacementarray, $imageamp);
		}
		}
		if(preg_match('/imgur/', $oembedvalues[1]) or preg_match('/reddit/', $oembedvalues[1]) or preg_match('/mixcloud/', $oembedvalues[1]) or preg_match('/audiomack/', $oembedvalues[1]) or preg_match('/bandcamp/', $oembedvalues[1])){
		$imgurunsupported = preg_grep('/imgur/', $oembedvalues[1]);
		$redditunsupported = preg_grep('/audiomack/', $oembedvalues[1]);
		$mixcloudunsupported = preg_grep('/reddit/', $oembedvalues[1]);
		$audiomackunsupported = preg_grep('/mixcloud/', $oembedvalues[1]);
		$bandcampunsupported = preg_grep('/bandcamp/', $oembedvalues[1]);
		foreach ($bandcampunsupported as $value){
		$value2 = str_replace ('"', '', $value);
		$unsupportedregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
		$unsupportedamp = '<div class="unsupported">This type of embed is unsupported on AMP pages (not by us), please visit the page on the regular website to see the embed.)</div>';
		array_push($ampsearcharray, $unsupportedregex);
		array_push($ampreplacementarray, $unsupportedamp);
		}
		foreach ($mixcloudunsupported as $value){
		$value2 = str_replace ('"', '', $value);
		$unsupportedregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
		$unsupportedamp = '<div class="unsupported">This type of embed is unsupported on AMP pages (not by us), please visit the page on the regular website to see the embed.)</div>';
		array_push($ampsearcharray, $unsupportedregex);
		array_push($ampreplacementarray, $unsupportedamp);
		}
		foreach ($audiomackunsupported as $value){
		$value2 = str_replace ('"', '', $value);
		$unsupportedregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
		$unsupportedamp = '<div class="unsupported">This type of embed is unsupported on AMP pages (not by us), please visit the page on the regular website to see the embed.)</div>';
		array_push($ampsearcharray, $unsupportedregex);
		array_push($ampreplacementarray, $unsupportedamp);
		}
		foreach ($mixcloudunsupported as $value){
		$value2 = str_replace ('"', '', $value);
		$unsupportedregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
		$unsupportedamp = '<div class="unsupported">This type of embed is unsupported on AMP pages (not by us), please visit the page on the regular website to see the embed.)</div>';
		array_push($ampsearcharray, $unsupportedregex);
		array_push($ampreplacementarray, $unsupportedamp);
		}
		foreach ($redditunsupported as $value){
		$value2 = str_replace ('"', '', $value);
		$unsupportedregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
		$unsupportedamp = '<div class="unsupported">This type of embed is unsupported on AMP pages (not by us), please visit the page on the regular website to see the embed.)</div>';
		array_push($ampsearcharray, $unsupportedregex);
		array_push($ampreplacementarray, $unsupportedamp);
		}
		foreach ($imgurunsupported as $value){
		$value2 = str_replace ('"', '', $value);
		$unsupportedregex = '/<div data-oembed-url=\"'.preg_quote($value2, '/').'\">.*?<\/div>/';
		$unsupportedamp = '<div class="unsupported">This type of embed is unsupported on AMP pages (not by us), please visit the page on the regular website to see the embed.)</div>';
		array_push($ampsearcharray, $unsupportedregex);
		array_push($ampreplacementarray, $unsupportedamp);
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
			} else if(preg_match('/instagram/', $resultpostint['content_link'])){
		echo '<amp-facebook width=486 height=657
  layout="responsive"
  data-href="'.$resultpostint['content_link'].'">
			</amp-facebook>';} else if(preg_match('/imgur/', $resultpostint['content_link']) or preg_match('/reddit/', $resultpostint['content_link']) or preg_match('/mixcloud/', $resultpostint['content_link']) or preg_match('/audiomack/', $resultpostint['content_link']) or preg_match('/audiomack/', $resultpostint['content_link'])){
				#$url = file_get_contents('http://iframe.ly/api/oembed?url='.$resultpostint['content_link'].'&api_key=dcfb3943c025e9e7b8f24e&iframe=amp');
				#preg_match('/"html": *("(.*)")/', $url, $match);
				#$url2 = str_replace('""', '', $match[2]);
				#$url3 = str_replace("\\", '', $url2);
				#echo '<div class="padding"></div>';
				#echo $url3;
				echo '<div class="unsupported">This type of embed is unsupported on AMP pages (not by us), unfortunately AMP do not allow it to be placed on the very top, please visit the page on the regular website to see the embed.)</div>';
			} else if (preg_match('/jpg/', $resultpostint['content_link']) or preg_match('/gif/', $resultpostint['content_link']) or preg_match('/png/', $resultpostint['content_link']) or preg_match('/gif/', $resultpostint['content_link'])){
				echo '<amp-img src="'.$resultpostint['content_link'].'"
      width="1080"
      height="610"
      layout="responsive"
      alt=""></amp-img>';
			}
		}
	
		echo preg_replace($ampsearcharray, $ampreplacementarray, $resultpostint['content_description']);
echo '</div></body>
</html>';
exit;} else {
header("HTTP/2.0 404 Not Found");
echo '<div class="notfoundpage">'.$template['404_message'].'</div>';
}