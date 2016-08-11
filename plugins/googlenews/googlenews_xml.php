<?php
header("Content-type: text/xml");
if(strpos($_SERVER['REQUEST_URI'], 'newsfeed')){
	$global = new DB_global;
	$newssettings1 = $global->sqlquery("SELECT * FROM `ddp_googlenews`");
	$newssettings2 = $newssettings1->fetch_assoc();
	$sitesettings1 = $global->sqlquery("SELECT * FROM `dd_settings`");
	$sitesettings2 = $sitesettings1->fetch_assoc();
	if (str_word_count($newssettings2['googlenews_categories']) < '1'){
	$categories = "WHERE content_category = '".$newssettings2['googlenews_categories']."'";
	} else {
	$categoriesinit = explode(', ', $newssettings2['googlenews_categories']);
	foreach ($categoriesinit as $key => $value){
	$categoriesinit[$key] = "content_category = '".$value."' OR";
	}
	
	$index = count( $categoriesinit ) - 1;
	$value = $categoriesinit[$index];
	$categoriesinit[$index] = str_replace( "OR", "", $value );
	$categories = implode(' ', $categoriesinit);
	}
	
	$newsretrive = $global->sqlquery("SELECT * FROM dd_content WHERE ".$categories." LIMIT 20;");

	if ($newsretrive->num_rows > 0) {
	echo '<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="https://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:news="https://www.google.com/schemas/sitemap-news/0.9">';
	while($row = $newsretrive->fetch_assoc()) {
	echo '<url>';
	echo '<loc>https://'.$_SERVER['HTTP_HOST'].'/'.$row['content_permalink'].'</loc>';
	echo '<news:news>';
	echo '<news:publication>'.$sitesettings2['site_name'].'</news:publication>';
	echo '<news:language>en</news:language>';
	echo '<news:genres>Opinion, Blog</news:genres>';
	$date = date_create($row['content_date']);
	echo '<news:publication_date>'.date_format($date,'Y-m-d').'</news:publication_date>';
	echo '<news:title>'.$row['content_title'].'</news:title>';
	echo '<news:keywords>'.$row['content_tags'].'</news:keywords>';
	echo '</news:news>';
	echo '</url>';
	}
	echo '</urlset>';
	exit;
	} else {
		echo "SELECT * FROM dd_content WHERE ".$categories." LIMIT 20;";
		exit;
}
}