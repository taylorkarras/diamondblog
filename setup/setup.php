<?php

if(isset($_POST)){
	
			if(trim($_POST['sqlserver']) === '')  {
		$_SESSION['errors']['sqlserver'] = "You cannot leave the SQL server field blank.";
		$hasError = true;	
	} else {
		$sqlserver = $_POST['sqlserver'];
	}
	
				if(trim($_POST['sqlusername']) === '')  {
		$_SESSION['errors']['sqlusername'] = "You cannot leave the SQL username field blank.";
		$hasError = true;	
	} else {
		$sqlusername = $_POST['sqlusername'];
	}
	
				if(trim($_POST['sqlpassword']) === '')  {
		$_SESSION['errors']['sqlpassword'] = "You cannot leave the SQL password field blank.";
		$hasError = true;	
	} else {
		$sqlpassword = $_POST['sqlpassword'];
	}
	
        if(strlen($_POST['metadescription']) > '200')  {
                $_SESSION['errors']['metadescription'] = "Meta description cannot be longer than 200 characters.";
                $hasError = true;
        } else {
                $metadescription = str_replace("'", '', $_POST['metadescription']);
        }
	
				if(trim($_POST['adminemail']) === '')  {
		$_SESSION['errors']['adminemail'] = "You cannot leave the Admin email field blank.";
		$hasError = true;	
	} else {
		$adminemail = $_POST['adminemail'];
	}
	
				if(trim($_POST['sqldatabase']) === '')  {
		$_SESSION['errors']['sqldatabase'] = "You cannot leave the SQL database field blank.";
		$hasError = true;	
	} else {
		$sqldatabase = $_POST['sqldatabase'];
	}
	
					if(trim($_POST['sitename']) === '')  {
		$sitename = 'Another DiamondBlog Blog';
	} else {
		$sitename = $_POST['sitename'];
	}
	
					if(trim($_POST['sitetitle']) === '')  {
		$sitetitle = 'Another one in a million';
	} else {
		$sitetitle = $_POST['sitetitle'];
	}
	
					if(trim($_POST['siteurl']) === '')  {
		$siteurl = $_SERVER['HTTP_HOST'];
	} else {
		$siteurl = $_POST['siteurl'];
	}
	
		if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}} else {
	
		$sql = mysqli_connect($sqlserver, $sqlusername, $sqlpassword, $sqldatabase);
		$password = password_hash($_POST['adminpassword'], PASSWORD_DEFAULT);
if ($sql->connect_errno) {
    $_SESSION['errors']['sqlpassword'] = "Error connecting to server! ".$mysqli->connect_error;
	                echo json_encode($_SESSION['errors']);
                exit;
}
else {
	
	$sql->query("CREATE TABLE `dd_banlist` (
  `banlist_no` int(255) NOT NULL,
  `banlist_ip` varchar(255) NOT NULL,
  `banlist_name` varchar(256) NOT NULL,
  `banlist_email` varchar(256) NOT NULL,
  `banlist_duration` datetime NOT NULL,
  `banlist_reason` text NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_banlist`
  ADD PRIMARY KEY (`banlist_no`);
");

	$sql->query("
CREATE TABLE `dd_categories` (
  `category_id` int(255) NOT NULL,
  `category_name` text NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_categories`
  ADD PRIMARY KEY (`category_id`);
");
	$sql->query("
INSERT INTO `dd_categories` (`category_id`, `category_name`) VALUES
(1, 'Site News'),
(3, 'Other'),
(2, 'Opinion');
");

	$sql->query("
CREATE TABLE `dd_comments` (
  `comment_id` int(255) NOT NULL,
  `comment_postid` int(255) NOT NULL,
  `comment_isreply` int(11) NOT NULL DEFAULT '0',
  `comment_replyto` int(11) NOT NULL DEFAULT '0',
  `comment_username` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_email` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_date` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `comment_content` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `comment_ip` varchar(256) NOT NULL,
  `comment_reported` int(1) NOT NULL,
  `comment_isfromadmin` int(1) NOT NULL,
  `comment_isfromcontributor` int(1) NOT NULL,
  `comment_userid` int(1) NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_comments`
  ADD PRIMARY KEY (`comment_id`);
");

	$sql->query("
CREATE TABLE `dd_content` (
  `content_id` int(255) UNSIGNED NOT NULL,
  `content_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_embedcode` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_summary` text NOT NULL,
  `content_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_category` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_tags` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `content_permalink` text NOT NULL,
  `content_shortlink` varchar(12) NOT NULL,
  `content_date` datetime NOT NULL,
  `content_author` int(255) NOT NULL
  `content_pinned` int(11) NOT NULL DEFAULT '0',
  `content_commentsclosed` int(1) NOT NULL DEFAULT '0'
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_content`
  ADD PRIMARY KEY (`content_id`);
");
	$sql->query("
INSERT INTO `dd_content` (`content_id`, `content_link`, `content_embedcode`, `content_description`, `content_summary`, `content_title`, `content_category`, `content_tags`, `content_permalink`, `content_shortlink`, `content_date`, `content_author`, `content_pinned`, `content_commentsclosed`) VALUES
(1, '', '', 'Congratulations, you have successfully set up DiamondBlog, now get to bloggin\' by entering \"/console\" in your address bar. Feel free to delete this post anytime.', 'Congratulations, you have successfully set up DiamondBlog, now get to bloggin\' by entering \"/console\" in your address bar. Feel free to delete this post anytime.', 'My First DiamondBlog post!', 'Site News', '', 'my_first_diamondblog_post', '', NOW(), 1, 0, 0);

");

	$sql->query("
CREATE TABLE `dd_drafts` (
  `draft_id` int(255) NOT NULL,
  `draft_link` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `draft_description` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `draft_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `draft_category` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `draft_tags` mediumtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `draft_date` datetime NOT NULL,
  `draft_author` int(255) NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_drafts`
  ADD PRIMARY KEY (`draft_id`);
");
	$sql->query("
CREATE TABLE `dd_mail` (
  `mail_server` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_user` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_password` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `mail_inuse` int(1) NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
CREATE TABLE `dd_mailtree` (
  `mailtree_id` int(11) NOT NULL,
  `mailtree_name` varchar(256) NOT NULL,
  `mailtree_email` varchar(256) NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_mailtree`
  ADD PRIMARY KEY (`mailtree_id`);
");

	$sql->query("
CREATE TABLE `dd_pages` (
  `page_number` int(255) NOT NULL,
  `page_title` text NOT NULL,
  `page_content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_author` int(255) NOT NULL,
  `page_link` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `page_external_link` text NOT NULL,
  `page_contactform` int(1) NOT NULL,
  `page_menu_pos` int(2) NOT NULL,
  `page_is_link` int(1) NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_pages`
  ADD PRIMARY KEY (`page_number`);
");
	$sql->query("
CREATE TABLE `dd_reports` (
  `report_id` int(11) NOT NULL,
  `report_commentid` varchar(11) NOT NULL,
  `report_ip` varchar(256) NOT NULL,
  `report_name` varchar(256) NOT NULL,
  `report_email` varchar(256) NOT NULL,
  `report_text` text NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_reports`
  ADD PRIMARY KEY (`report_id`);
");
	$sql->query("
CREATE TABLE `dd_settings` (
  `site_url` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_name` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_title` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `admin_email` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_metadescription` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `date_format` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `time_format` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `site_color` varchar(7) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `postsperpage` int(2) NOT NULL DEFAULT '20',
  `commentsperpage` int(11) NOT NULL,
  `default_theme` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `navigation_select` int(1) NOT NULL,
  `pages_on` int(1) NOT NULL,
  `menu_on` int(1) NOT NULL,
  `subtext_on` int(1) NOT NULL,
  `contact_users_on` int(1) NOT NULL,
  `logo_on` int(1) NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
INSERT INTO `dd_settings` (`site_url`, `site_name`, `site_title`, `admin_email`, `site_metadescription`, `date_format`, `time_format`, `site_color`, `postsperpage`, `commentsperpage`, `default_theme`, `navigation_select`, `pages_on`, `menu_on`, `subtext_on`, `contact_users_on`, `logo_on`) VALUES
('".$siteurl."', '".$sitename."', '".$sitetitle."', '".$adminemail."', '".$metadescription."', 'F j, Y', 'g:i a', '#ffffff', 20, 10, 'default', 0, 0, 0, 1, 1, 0);
");
	$sql->query("
CREATE TABLE `dd_storage` (
  `ftp_server` varchar(255) NOT NULL,
  `ftp_user` varchar(256) NOT NULL,
  `ftp_password` varchar(255) NOT NULL,
  `ftp_directory` text NOT NULL,
  `ftp_inuse` int(1) NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
CREATE TABLE `dd_tags` (
  `tag_number` int(7) UNSIGNED NOT NULL,
  `tag_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_tags`
  ADD PRIMARY KEY (`tag_number`);
");
	$sql->query("
CREATE TABLE `dd_templates` (
  `404_message` mediumtext NOT NULL,
  `comment_notification_message` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
INSERT INTO `dd_templates` (`404_message`, `comment_notification_message`) VALUES
('404, file not found. Please try searching for content using the searchbar or heading back the way you came.', 'Just write a comment and post it in the comment section, it is easy! Be aware that DiamondBlog logs your IP for administrative purposes.');
");
	$sql->query("
CREATE TABLE `dd_users` (
  `user_id` int(255) NOT NULL,
  `user_username` varchar(255) NOT NULL,
  `user_realname` text NOT NULL,
  `user_password` longtext NOT NULL,
  `user_picture` text NOT NULL,
  `user_description` longtext NOT NULL,
  `user_subtext` text NOT NULL,
  `user_location` text NOT NULL,
  `user_isadmin` int(1) NOT NULL,
  `user_iscontributor` int(1) NOT NULL,
  `user_ismod` int(1) NOT NULL,
  `user_closedaccount` int(1) NOT NULL DEFAULT '0',
  `user_email` varchar(256) NOT NULL,
  `user_datejoined` date NOT NULL
) DEFAULT CHARSET=utf8mb4;
");
	$sql->query("
ALTER TABLE `dd_users`
  ADD PRIMARY KEY (`user_id`);
");
	$sql->query("
ALTER TABLE `dd_users`
  MODIFY `user_id` int(255) NOT NULL AUTO_INCREMENT;
");
	$sql->query("
INSERT INTO `dd_users` (`user_id`, `user_username`, `user_realname`, `user_password`, `user_picture`, `user_description`, `user_subtext`, `user_location`, `user_isadmin`, `user_iscontributor`, `user_ismod`, `user_closedaccount`, `user_email`, `user_datejoined`) VALUES
(NULL, 'admin', 'Admin', '".$password."', '', 'Just the default DiamondBlog account created during setup.', 'Just the default DiamondBlog account created during setup.', '', 1, 0, 0, NULL, '".$adminemail."', NOW());
");
	$sql->query("
CREATE TABLE `dd_votes` (
  `cvote_id` int(11) NOT NULL,
  `cvote_ip` varchar(255) NOT NULL,
  `cvote_commentid` int(255) NOT NULL,
  `cvote_p_id` int(11) NOT NULL,
  `cvote_voted` int(1) NOT NULL,
  `cvote_positive` int(1) NOT NULL,
  `cvote_negative` int(1) NOT NULL
) DEFAULT CHARSET=utf8mb4;
");	$sql->query("
ALTER TABLE `dd_votes`
  ADD PRIMARY KEY (`cvote_id`);");

$globalblog = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/includes/global.php');
$globalconsole = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/global.php');
$globalreplace = array('hostnamereplacesql', 'dbuserreplacesql', 'dbpassreplacesql', 'dbreplacesql');
$globalreplace2 = array($sqlserver, $sqlusername, $sqlpassword, $sqldatabase);
$globalblogreplace = str_replace($globalreplace, $globalreplace2, $globalblog);
$globalconsolereplace = str_replace($globalreplace, $globalreplace2, $globalconsole);
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/global.php', $globalconsolereplace);
$index = "<?php
define( \"INPROCESS\", true );
/** PHP version check **/
define('MINIMUM_PHP', '7.0');

if (version_compare(PHP_VERSION, MINIMUM_PHP, '<'))
{
	die('Your host needs to use PHP ' . MINIMUM_PHP . ' or higher to run MusicWiki,');
}

/** MySQL check **/
function check_mysql_versions() {
	if ( ! extension_loaded( 'mysqli' ) && ! extension_loaded( 'mysqlnd' ) ) {

		header( sprintf( '%s 500 Internal Server Error', \$protocol ), true, 500 );
		header( 'Content-Type: text/html; charset=utf-8' );
		die( __( 'Your PHP installation appears to be missing the MySQL extension which is required by MusicWiki.' ) );
	}
}

\$url = \$_SERVER['REQUEST_URI'];

if (strpos(\$url,'console') !== false) {
require_once(__DIR__.\"/includes/console/load.php\");
renderconsole();
} else {
require_once(__DIR__.\"/load.php\");
rendertheme();
}
?>";
file_put_contents($_SERVER['DOCUMENT_ROOT'].'/index.php', $index);
unlink($_SERVER['DOCUMENT_ROOT'].'/setup/setup.php');
unlink($_SERVER['DOCUMENT_ROOT'].'/setup/setupinterface.php');
rmdir($_SERVER['DOCUMENT_ROOT'].'/setup');

				$resp = array();
				$resp['resprefresh'] = true;
				$resp['url'] = 'https://'.$_SERVER['HTTP_HOST'].'/console';
				$resp['message'] = '
	<p>Success! DiamondBlog is now set up, happy blogging!.</p>';
			
                echo json_encode($resp);
		        exit;
											}
	}
}
