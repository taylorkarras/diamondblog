<?php
$global = new DB_global;
$retrive = new DB_retrival;

if ($retrive->isLoggedIn() == true && !$retrive->restrictpermissionlevel('3')){

	if (empty($_FILES['importfile'])){
	echo 'Must select database file.';
	exit;
	}

	$fileext = pathinfo($_FILES['importfile']['name'], PATHINFO_EXTENSION);
	if ($fileext !== 'xml'){
	echo 'File must be an XML file.';
	exit;
	}

$contents = json_decode(json_encode(simplexml_load_file($_FILES['importfile']['tmp_name'])),TRUE);
if ($contents['isdiamondblog']['answer'] !== 'Yes' or empty($contents['isdiamondblog']['answer'])){
	echo 'File must be a DiamondBlog Database file.';
	exit;
}
	
$settings = array();
$storage = array();
$mail = array();
$templates = array();
foreach ($contents['settings'] as $key => $item){
$settings[$key] = $item;
}
foreach ($contents['storage'] as $key => $item){
$storage[$key] = $item;
}
foreach ($contents['mail'] as $key => $item){
$mail[$key] = $item;
}
foreach ($contents['templates'] as $key => $item){
$templates[$key] = $item;
}

//Settings

$global->sqlquery("UPDATE dd_settings SET site_name = '".$settings['sitename']."', site_title = '".$settings['sitetitle']."', site_metadescription = '".$settings['sitemetadescription']."', date_format = '".$settings['dateformat']."', time_format = '".$settings['timeformat']."', site_color = '".$settings['sitecolor']."' postsperpage = '".$settings['postsperpage']."', commentsperpage = '".$settings['commentsperpage']."', default_theme = 'default', navigation_select = '".$settings['navigationselect']."', pages_on = '".$settings['pageson']."', menu_on = '".$settings['menuon']."' subtext_on = '".$settings['subtexton']."', contact_users_on = '".$settings['contactuserson']."', logo_on = '0';");
$global->sqlquery("TRUNCATE TABLE dd_storage");
$global->sqlquery("INSERT INTO `dd_storage` (`ftp_server`, `ftp_user`, `ftp_password`, `ftp_directory`, `ftp_inuse`) VALUES ('".$storage['ftpserver']."', '".$storage['ftpuser']."', '".$storage['ftppassword']."', '".$storage['ftpdirectory']."', '".$storage['ftpinuse']."'");
$global->sqlquery("TRUNCATE TABLE dd_mail");
$global->sqlquery("INSERT INTO `dd_mail` (`mail_server`, `mail_user`, `mail_password`, `mail_inuse`) VALUES ('".$mail['mailserver']."', '".$mail['mailuser']."', '".$mail['mailpassword']."', '".$mail['mailinuse']."'");
$global->sqlquery("UPDATE dd_templates SET 404_message = '".$templates['notfoundmessage']."', comment_notification_message = '".$templates['commentnotificationmessage']."'");

//Content

$global->sqlquery("TRUNCATE TABLE dd_content; ALTER TABLE dd_content AUTO_INCREMENT = 1;");
foreach ($contents['content']['posts']['post'] as $item){
$global->sqlquery("INSERT INTO `dd_content` (`content_id`, `content_link`, `content_embedcode`, `content_description`, `content_summary`, `content_title`, `content_category`, `content_tags`, `content_permalink`, `content_shortlink`, `content_date`, `content_author`, `content_pinned`, `content_commentsclosed`) VALUES (NULL, '".$item['contentlink']."', '".$item['contentembedcode']."', '".$item['contentdescription']."', '".$item['contentsummary']."', '".$item['contenttitle']."', '".$item['contentcategory']."', '".$item['contenttags']."', '".$item['contentpermalink']."', '".$item['contentshortlink']."', '".$item['contentdate']."', '".$item['contentauthor']."', '".$item['contentpinned']."', '".$item['contentcommentsclosed']."')");
}
$global->sqlquery("TRUNCATE TABLE dd_pages; ALTER TABLE dd_pages AUTO_INCREMENT = 1;");
foreach ($contents['content']['pages']['page'] as $item){
$global->sqlquery("INSERT INTO `dd_pages` (`page_number`, `page_title`, `page_content`, `page_author`, `page_link`, `page_external_link`, `page_contactform`, `page_menu_pos`, `page_is_link`) VALUES (NULL, '".$item['pagetitle']."', '".$item['pagecontent']."', '".$item['pageauthor']."', '".$item['pagelink']."', '".$item['pageexternallink']."', '$item['pagecontactform']', '".$item['pagemenupos']."', '".$item['pageislink']."')");
}
$global->sqlquery("TRUNCATE TABLE dd_reports; ALTER TABLE dd_reports AUTO_INCREMENT = 1;");
foreach ($contents['content']['reports']['report'] as $item){
$global->sqlquery("INSERT INTO `dd_reports` (`report_id`, `report_commentid`, `report_ip`, `report_name`, `report_email`, `report_text`) VALUES (NULL, '".$item['reportcommentid']."', '".$item['reportip']."', '".$item['reportname']."', '".$item['reportemail']."', '".$item['reporttext']."')");
}
$global->sqlquery("TRUNCATE TABLE dd_comments; ALTER TABLE dd_comments AUTO_INCREMENT = 1;");
foreach ($contents['content']['comments']['comment'] as $item){
$global->sqlquery("INSERT INTO `dd_comments` (`comment_id`, `comment_postid`, `comment_isreply`, `comment_replyto`, `comment_username`, `comment_email`, `comment_date`, `comment_content`, `comment_ip`, `comment_reported`, `comment_isfromadmin`, `comment_isfromcontributor`, `comment_userid`) VALUES (NULL, '".$item['commentpostid']."', '".$item['commentisreply']."', '".$item['commentreplyto']."', '".$item['commentusername']."', '".$item['commentemail']."', '".$item['commentdate']."', '".$item['commentcontent']."', '".$item['commentip']."', '".$item['commentreported']."', '".$item['commentisfromadmin']."', '".$item['commentisfromcontributor']."', '".$item['commentuserid']."')");
}
$global->sqlquery("TRUNCATE TABLE dd_drafts; ALTER TABLE dd_drafts AUTO_INCREMENT = 1;");
foreach ($contents['content']['drafts']['draft'] as $item){
$global->sqlquery("INSERT INTO `dd_drafts` (`draft_id`, `draft_link`, `draft_description`, `draft_title`, `draft_category`, `draft_tags`, `draft_date`, `draft_author`) VALUES (NULL, '".$item['draftlink']."', '".$item['draftdescription']."', '".$item['drafttitle']."', '".$item['draftcategory']."', '".$item['drafttags']."', '".$item['draftdate']."', '".$item['draftauthor']."')");
}

//List

$global->sqlquery("TRUNCATE TABLE dd_users; ALTER TABLE dd_users AUTO_INCREMENT = 1;");
foreach ($contents['lists']['users']['user'] as $item){
$global->sqlquery("INSERT INTO `dd_users` (`user_id`, `user_username`, `user_realname`, `user_password`, `user_picture`, `user_description`, `user_subtext`, `user_location`, `user_isadmin`, `user_iscontributor`, `user_ismod`, `user_closedaccount`, `user_email`, `user_datejoined`) VALUES (NULL, '".$item['username']."', '".$item['userrealname']."', '".$item['userpassword']."', '".$item['userpicture']."', '".$item['userdescription']."', '".$item['usersubtext']."', '".$item['userlocation']."', '".$item['userisadmin']."', '".$item['useriscontributor']."', '".$item['userismod']."', '".$item['userclosedaccount']."', '".$item['useremail']."', '".$item['userdatejoined']."')");
}
$global->sqlquery("TRUNCATE TABLE dd_votes; ALTER TABLE dd_votes AUTO_INCREMENT = 1;");
foreach ($contents['lists']['votes']['vote'] as $item){
$global->sqlquery("INSERT INTO `dd_votes` (`cvote_id`, `cvote_ip`, `cvote_commentid`, `cvote_p_id`, `cvote_voted`, `cvote_positive`, `cvote_negative`) VALUES (NULL, '".$item['voteip']."', '".$item['votecommentid']."', '".$item['votepid']."', '".$item['voted']."', '".$item['votepositive']."', '".$item['votenegative']."')");
}
$global->sqlquery("TRUNCATE TABLE dd_mailtree; ALTER TABLE dd_mailtree AUTO_INCREMENT = 1;");
foreach ($contents['lists']['mailtree']['item'] as $item){
$global->sqlquery("INSERT INTO `dd_mailtree` (`mailtree_id`, `mailtree_name`, `mailtree_email`) VALUES (NULL, '".$item['mailtreename']."', '".$item['mailtreeemail']."')");
}
$global->sqlquery("TRUNCATE TABLE dd_banlist; ALTER TABLE dd_banlist AUTO_INCREMENT = 1;");
foreach ($contents['lists']['banlist']['item'] as $item){
$global->sqlquery("INSERT INTO `dd_banlist` (`banlist_no`, `banlist_ip`, `banlist_name`, `banlist_email`, `banlist_duration`, `banlist_reason`) VALUES (NULL, '".$item['banlistip']."', '".$item['banlistname']."', '".$item['banlistemail']."', '".$item['banlistduration']."', '".$item['banlistreason']."')");
}
$global->sqlquery("TRUNCATE TABLE dd_tags; ALTER TABLE dd_tags AUTO_INCREMENT = 1;");
foreach ($contents['lists']['tags']['tag'] as $item){
$global->sqlquery("INSERT INTO `dd_tags` (`tag_number`, `tag_name`) VALUES (NULL, '".$item['tagname']."')");
}
$global->sqlquery("TRUNCATE TABLE dd_categories; ALTER TABLE dd_categories AUTO_INCREMENT = 1;");
foreach ($contents['lists']['categories']['category'] as $item){
$global->sqlquery("INSERT INTO `dd_tags` (`tag_number`, `tag_name`) VALUES (NULL, '".$item['categoryname']."')");
}

echo 'Success';
	exit;
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}
