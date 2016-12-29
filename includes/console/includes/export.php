<?php
$global = new DB_global;
$retrive = new DB_retrival;

if ($retrive->isLoggedIn() == true && !$retrive->restrictpermissionlevel('3')){
header("Content-Type: application/xml;");
header('Content-Transfer-Encoding: binary');
header('Content-disposition: attachment; filename="'.strtolower(sitename()).'_'.date('Y-m-d').'.xml"');
header('Expires: 0');
header('Cache-Control: must-revalidate');
header('Pragma: public');
ob_clean();
flush();
echo '<?xml version="1.0" encoding="utf-8"?>';
echo '<diamondblog>';
echo '	<isdiamondblog>';
echo '		<answer>Yes</answer>';
echo '	</isdiamondblog>';
$settings = $global->sqlquery("SELECT * FROM dd_settings LIMIT 1;");
if ($settings->num_rows > 0) {
echo '	<settings>';
while($row = $settings->fetch_assoc()) {
echo '		<sitename>'.htmlentities($row['site_name'], ENT_XML1).'</sitename>';
if (!empty($row['site_title'])){
echo '		<sitetitle>'.htmlentities($row['site_title'], ENT_XML1).'</sitetitle>';
}
if (!empty($row['site_metadescription'])){
echo '		<sitemetadescription>'.htmlentities($row['site_metadescription'], ENT_XML1).'</sitemetadescription>';
}
echo '		<dateformat>'.$row['date_format'].'</dateformat>';
echo '		<timeformat>'.$row['time_format'].'</timeformat>';
if (!empty($row['site_color'])){
echo '		<sitecolor>'.$row['site_color'].'</sitecolor>';
}
echo '		<postsperpage>'.$row['postsperpage'].'</postsperpage>';
echo '		<commentsperpage>'.$row['commentsperpage'].'</commentsperpage>';
echo '		<navigationselect>'.$row['navigation_select'].'</navigationselect>';
echo '		<pageson>'.$row['pages_on'].'</pageson>';
echo '		<menuon>'.$row['menu_on'].'</menuon>';
echo '		<subtexton>'.$row['menu_on'].'</subtexton>';
echo '		<contactuserson>'.$row['menu_on'].'</contactuserson>';
}
echo '	</settings>';
}
$storage = $global->sqlquery("SELECT * FROM dd_storage LIMIT 1;");
if ($storage->num_rows > 0) {
echo '	<storage>';
while($row = $storage->fetch_assoc()) {
echo '		<ftpserver>'.$row['ftp_server'].'</ftpserver>';
echo '		<ftpuser>'.$row['ftp_user'].'</ftpuser>';
echo '		<ftppassword>'.$row['ftp_password'].'</ftppassword>';
if (!empty($row['ftp_directory'])){
echo '		<ftpdirectory>'.$row['ftp_directory'].'</ftpdirectory>';
}
echo '		<ftpinuse>'.$row['ftp_inuse'].'</ftpinuse>';
}
echo '	</storage>';
}
$mail = $global->sqlquery("SELECT * FROM dd_mail LIMIT 1;");
if ($mail->num_rows > 0) {
echo '	<mail>';
while($row = $mail->fetch_assoc()) {
echo '		<mailserver>'.$row['mail_server'].'</mailserver>';
echo '		<mailuser>'.$row['mail_user'].'</mailuser>';
echo '		<mailpassword>'.$row['mail_password'].'</mailpassword>';
echo '		<mailinuse>'.$row['mail_inuse'].'</mailinuse>';
}
echo '	</mail>';
}
$templates = $global->sqlquery("SELECT * FROM dd_templates LIMIT 1;");
if ($templates->num_rows > 0) {
echo '	<templates>';
while($row = $templates->fetch_assoc()) {
echo '		<notfoundmessage>'.htmlentities($row['404_message'], ENT_XML1).'</notfoundmessage>';
echo '		<commentnotificationmessage>'.htmlentities($row['comment_notification_message'], ENT_XML1).'</commentnotificationmessage>';
}
echo '	</templates>';
}
echo '	<content>';
$posts = $global->sqlquery("SELECT * FROM dd_content;");
if ($posts->num_rows > 0) {
echo '		<posts>';
while($row = $posts->fetch_assoc()) {
echo '				<post>';
echo '					<contentid>'.$row['content_id'].'</contentid>';
if (!empty($row['content_link'])){
echo '					<contentlink>'.$row['content_link'].'</contentlink>';
}
if (!empty($row['content_embedcode'])){
echo '					<contentembedcode>'.htmlentities($row['content_embedcode'], ENT_XML1).'</contentembedcode>';
}
echo '					<contentdescription>'.htmlentities($row['content_description'], ENT_XML1).'</contentdescription>';
echo '					<contentcategory>'.htmlentities($row['content_category'], ENT_XML1).'</contentcategory>';
echo '					<contentsummary>'.htmlentities($row['content_summary'], ENT_XML1).'</contentsummary>';
if (!empty($row['content_tags'])){
echo '					<contenttags>'.htmlentities($row['content_tags'], ENT_XML1).'</contenttags>';
}
echo '					<contentcommentsclosed>'.$row['content_commentsclosed'].'</contentcommentsclosed>';
echo '					<contentpermalink>'.$row['content_permalink'].'</contentpermalink>';
echo '					<contentshortlink>'.$row['content_shortlink'].'</contentshortlink>';
echo '					<contentauthor>'.$row['content_author'].'</contentauthor>';
echo '					<contenttitle>'.htmlentities($row['content_title'], ENT_XML1).'</contenttitle>';
echo '					<contentpinned>'.$row['content_pinned'].'</contentpinned>';
echo '					<contentdate>'.$row['content_date'].'</contentdate>';
echo '				</post>';
}
echo '		</posts>';
}
$drafts = $global->sqlquery("SELECT * FROM dd_drafts;");
if ($drafts->num_rows > 0) {
echo '		<drafts>';
while($row = $drafts->fetch_assoc()) {
echo '				<draft>';
echo '					<draftid>'.$row['draft_id'].'</draftid>';
if (!empty($row['draft_link'])){
echo '					<draftlink>'.$row['draft_link'].'</draftlink>';
}
echo '					<draftdescription>'.htmlentities($row['draft_description'], ENT_XML1).'</draftdescription>';
echo '					<drafttitle>'.htmlentities($row['draft_title'], ENT_XML1).'</drafttitle>';
echo '					<draftcategory>'.htmlentities($row['draft_category'], ENT_XML1).'</draftcategory>';
if (!empty($row['draft_tags'])){
echo '					<drafttags>'.htmlentities($row['draft_tags'], ENT_XML1).'</drafttags>';
}
echo '					<draftdate>'.$row['draft_date'].'</draft_date>';
echo '					<draftauthor>'.$row['draft_author'].'</draftauthor>';
echo '				</draft>';
}
echo '		</drafts>';
}
$comments = $global->sqlquery("SELECT * FROM dd_comments;");
if ($comments->num_rows > 0) {
echo '		<comments>';
while($row = $comments->fetch_assoc()) {
echo '			<comment>';
echo '				<commentid>'.$row['comment_id'].'</commentid>';
echo '				<commentpostid>'.$row['comment_postid'].'</commentpostid>';
echo '				<commentisreply>'.$row['comment_isreply'].'</commentisreply>';
echo '				<commentreplyto>'.$row['comment_replyto'].'</commentreplyto>';
echo '				<commentusername>'.htmlentities($row['comment_username'], ENT_XML1).'</commentusername>';
echo '				<commentdate>'.$row['comment_date'].'</commentdate>';
echo '				<commentcontent>'.htmlentities($row['comment_content'], ENT_XML1).'</commentcontent>';
echo '				<commentip>'.$row['comment_ip'].'</commentip>';
echo '				<commentreported>'.$row['comment_reported'].'</commentreported>';
echo '				<commentisfromadmin>'.$row['comment_isfromadmin'].'</commentisfromadmin>';
echo '				<commentisfromcontributor>'.$row['comment_isfromcontributor'].'</commentisfromcontributor>';
echo '				<commentuserid>'.$row['comment_userid'].'</commentuserid>';
echo '			</comment>';
}
echo '		</comments>';
}
$reports = $global->sqlquery("SELECT * FROM dd_reports;");
if ($reports->num_rows > 0) {
echo '		<reports>';
while($row = $reports->fetch_assoc()) {
echo '			<report>';
echo '				<reportid>'.$row['report_id'].'</reportid>';
echo '				<reportcommentid>'.$row['report_commentid'].'</reportcommentid>';
echo '				<reportip>'.$row['report_ip'].'</reportip>';
echo '				<reportname>'.htmlentities($row['report_name'], ENT_XML1).'</reportname>';
echo '				<reportemail>'.$row['report_email'].'</reportemail>';
echo '				<reporttext>'.$row['report_text'].'</reporttext>';
echo '			</report>';
}
echo '		</reports>';
}
$pages = $global->sqlquery("SELECT * FROM dd_pages;");
if ($pages->num_rows > 0) {
echo '		<pages>';
while($row = $pages->fetch_assoc()) {
echo '			<page>';
echo '				<pageauthor>'.$row['page_author'].'</pageauthor>';
echo '				<pagenumber>'.$row['page_number'].'</pagenumber>';
echo '				<pagetitle>'.htmlentities($row['page_title'], ENT_XML1).'</pagetitle>';
echo '				<pagecontent>'.htmlentities($row['page_content'], ENT_XML1).'</pagecontent>';
echo '				<pagelink>'.$row['page_link'].'</pagelink>';
if (!empty($row['page_external_link'])){
echo '				<pageexternallink>'.$row['page_external_link'].'</pageexternallink>';
}
echo '				<pagecontactform>'.$row['page_contactform'].'</pagecontactform>';
echo '				<pagemenupos>'.$row['page_menu_pos'].'</pagemenupos>';
echo '				<pageislink>'.$row['page_is_link'].'</pageislink>';
echo '			</page>';
}
echo '		</pages>';
}
echo '	</content>';
echo '	<lists>';
$users = $global->sqlquery("SELECT * FROM dd_users;");
if ($users->num_rows > 0) {
echo '		<users>';
while($row = $users->fetch_assoc()) {
echo '			<user>';
echo '				<userid>'.$row['user_id'].'</userid>';
echo '				<username>'.$row['user_username'].'</username>';
if (!empty($row['user_realname'])){
echo '				<userrealname>'.htmlentities($row['user_realname'], ENT_XML1).'</userrealname>';
}
echo '				<userpassword>'.$row['user_password'].'</userpassword>';
if (!empty($row['user_picture'])){
echo '				<userpicture>'.$row['user_picture'].'</userpicture>';
}
if (!empty($row['user_description'])){
echo '				<userdescription>'.htmlentities($row['user_description'], ENT_XML1).'</userdescription>';
}
if (!empty($row['user_subtext'])){
echo '				<usersubtext>'.htmlentities($row['user_subtext'], ENT_XML1).'</usersubtext>';
}
if (!empty($row['user_location'])){
echo '				<userlocation>'.htmlentities($row['user_location'], ENT_XML1).'</userlocation>';
}
echo '				<userisadmin>'.$row['user_isadmin'].'</userisadmin>';
echo '				<useriscontributor>'.$row['user_iscontributor'].'</useriscontributor>';
echo '				<userismod>'.$row['user_ismod'].'</userismod>';
echo '				<userclosedaccount>'.$row['user_closedaccount'].'</userclosedaccount>';
echo '				<useremail>'.$row['user_email'].'</useremail>';
echo '				<userdatejoined>'.$row['user_datejoined'].'</userdatejoined>';
echo '			</user>';
}
echo '		</users>';
}
$votes = $global->sqlquery("SELECT * FROM dd_votes;");
if ($votes->num_rows > 0) {
echo '		<votes>';
while($row = $votes->fetch_assoc()) {
echo '			<vote>';
echo '				<voteid>'.$row['cvote_id'].'</voteid>';
echo '				<voteip>'.$row['cvote_ip'].'</voteip>';
echo '				<votecommentid>'.$row['cvote_commentid'].'</votecommentid>';
echo '				<votepid>'.$row['cvote_p_id'].'</votepid>';
echo '				<voted>'.$row['cvote_voted'].'</voted>';
echo '				<votepositive>'.$row['cvote_positive'].'</votepositive>';
echo '				<votenegative>'.$row['cvote_negative'].'</votenegative>';
echo '			</vote>';
}
echo '		</votes>';
}
$mailtree = $global->sqlquery("SELECT * FROM dd_mailtree;");
if ($mailtree->num_rows > 0) {
echo '		<mailtree>';
while($row = $mailtree->fetch_assoc()) {
echo '			<item>';
echo '				<mailtreeid>'.$row['mailtree_id'].'</mailtreeid>';
echo '				<mailtreename>'.htmlentities($row['mailtree_name'], ENT_XML1).'</mailtreename>';
echo '				<mailtreeemail>'.$row['mailtree_email'].'</mailtreeemail>';
echo '			</item>';
}
echo '		</mailtree>';
}
$banlist = $global->sqlquery("SELECT * FROM dd_banlist;");
if ($banlist->num_rows > 0) {
echo '		<banlist>';
while($row = $banlist->fetch_assoc()) {
echo '			<item>';
echo '				<banlistno>'.$row['banlist_no'].'</banlistno>';
if (!empty($row['banlist_ip'])){
echo '				<banlistip>'.$row['banlist_ip'].'</banlistip>';
}
if (!empty($row['banlist_email'])){
echo '				<banlistemail>'.$row['banlist_email'].'</banlistemail>';
}
if (!empty($row['banlist_name'])){
echo '				<banlistname>'.$row['banlist_name'].'</banlistname>';
}
echo '				<banlistduration>'.$row['banlist_duration'].'</banlistduration>';
echo '				<banlistreason>'.htmlentities($row['banlist_reason'], ENT_XML1).'</banlistreason>';
echo '			</item>';
}
echo '		</banlist>';
}
$tags = $global->sqlquery("SELECT * FROM dd_tags;");
if ($tags->num_rows > 0) {
echo '		<tags>';
while($row = $tags->fetch_assoc()) {
echo '			<tag>';
echo '				<tagnumber>'.$row['tag_number'].'</tagnumber>';
echo '				<tagname>'.htmlentities($row['tag_name'], ENT_XML1).'</tagname>';
echo '			</tag>';
}
echo '		</tags>';
}
$categories = $global->sqlquery("SELECT * FROM dd_categories;");
if ($categories->num_rows > 0) {
echo '		<categories>';
while($row = $categories->fetch_assoc()) {
echo '			<category>';
echo '				<categoryid>'.$row['category_id'].'</categoryid>';
echo '				<categoryname>'.htmlentities($row['category_name'], ENT_XML1).'</categoryname>';
echo '			</category>';
}
echo '		</categories>';
}
echo '	</lists>';
echo '</diamondblog>';
exit;
} else {
 header("HTTP/1.0 403 Forbidden");
 die();
	}
