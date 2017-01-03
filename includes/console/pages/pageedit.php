<?php
	$global = new DB_global;
	$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
	if (!empty($_GET["pageid"])){
		$editpage1 = $global->sqlquery("SELECT * FROM dd_pages WHERE page_number = '".$_GET["pageid"]."';");
		$editpage2 = $editpage1->fetch_assoc();
	}
	if ($retrive->restrictpermissionlevel('3')){ 
echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to view this section!</div></div>';
	} else {
echo consolemenu();
if (!empty($_GET["pageid"])){
define ('POSTPEND', 'Edit Page: '.$editpage2['page_title']);
echo '<div id="page"><div class="center">Edit Page';
} else {
define ('POSTPEND', 'New Page');
$_SESSION['editid']['page'] = 'new';
}
echo '<div id="page"><div class="center">Create New Page';
echo '<form id="page" method="post">
<label title="pagetitle"><b>Page title:</b></label>
<br /><input type="text" name="pagetitle"';
if (!empty($_GET["pageid"])){
	echo 'value="'.$editpage2['page_title'].'"';
}
echo '>';
echo '<br /><br /><label title="pagelink"><b>Link:</b></label>
<br /><input type="text" name="pagelink"';
if (!empty($_GET["pageid"])){
	echo 'value="'.$editpage2['page_external_link'].'"';
}
echo '>';
echo '
<br /><label title="pagecontent"><b>Page content:</b></label>
<br /><textarea  class="ckeditor" name="pagecontent">';
if (!empty($_GET["pageid"])){
	echo $editpage2['page_content'];
}
echo'</textarea>
<input type="hidden" name="oneortheother">
<br /><label title="pagemenupos"><b>Position on menu:</b></label>
<br /><input type="text" name="pagemenupos"';
if (!empty($_GET["pageid"])){
	echo 'value="'.$editpage2['page_menu_pos'].'"';
}
echo '>';
echo'<br /><br /><label title="pagecustomlink"><b>Custom link:</b></label>
<br /><input type=text id="pagecustomlink" name="pagecustomlink" ';
if (!empty($_GET["pageid"])){
	echo 'value="'.$editpage2['page_link'].'"';
}
echo '>';
if (!empty($_GET["pageid"])){
$_SESSION['editid']['page'] = $_GET["pageid"];
}
echo '<br /><br /><br />
<div class="sitescrolling">
<input type="checkbox" id="contactform" name="contactform" ';
if ($editpage2['page_contactform'] == '1'){
	echo 'value="1" checked';
} else {
	echo 'value="0"';
}
echo'> This is a contact form.<br></div>';
	echo '<script>$(';echo"'";echo'input[type="checkbox"]';echo"').change(function(){
    this.value = (Number(this.checked));
	});</script>";
echo '<br /><input class="postsubmit" name="pagesubmit" type="submit" value="Submit">';
echo '</form>';
echo '</div>';
}} else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>