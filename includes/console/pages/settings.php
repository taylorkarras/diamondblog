<?php

$global = new DB_global;
$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
if (!$retrive->restrictpermissionlevel('3')){
if (strpos($_SERVER['REQUEST_URI'], "site")){
		$ss1 = $global->sqlquery("SELECT * FROM dd_settings");
		$ss2 = $ss1->fetch_assoc();
		
echo consolemenu();
echo '<div id="page"><div class="center">Site Settings</div>
<br />
<div id="settingslist" style="display:table">
<form enctype="multipart/form-data" id="logo"> 
      <label for="logo"><b>Site Logo:</b></label><br />';
	  if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/logo.png')){
echo '<img src="/images/logo.png" alt="Logo" title="Logo" />
<div class="center smalltext">Current logo</div>';
	  }
echo' <div class="logo"><input type="hidden" name="MAX_FILE_SIZE" value="500000" />
      <br /><input class="s_floatleft" type="file" name="logo" id="logo" accept="image/*"><br />
	  <input type="button" value="Upload" class="logoupload" style="width: 100px;" >
	  <br /><h3>Guidelines:</h3>
	  <div class="smalltext">
	  <li>Logos must be in a PNG format (transparency recommened).</li>
	  <li>Logos cannot be larger than 5MB.</li>
	  </div>
	  </div>
	  <h4 id="loading2" >Uploading avatar..</h4>
	  <div id="upload2"></div>
	  </form>
<form enctype="multipart/form-data" id="icon"> 
      <label for="icon"><b>Site Icon:</b></label><br />';
	  	  if (file_exists($_SERVER['DOCUMENT_ROOT'].'/images/favicon-310px.png')){
echo '<img src="/images/favicon-310px.png" alt="Icon" title="Icon" />
<div class="center smalltext">Current Icon</div>';
	  }
echo '<div class="icon"><input type="hidden" name="MAX_FILE_SIZE" value="500000" />
      <br /><input class="s_floatleft" type="file" name="favicon" id="favicon" accept="image/*"><br />
	  <input type="button" value="Upload" class="iconupload" style="width: 100px;" >
	  <br /><h3>Guidelines:</h3>
	  <div class="smalltext">
	  <li>Icons should be in the square format</li>
	  <li>Icons cannot be larger than 5MB.</li>
	  </div>
	  </div>
	  <h4 id="loading" >Uploading avatar..</h4>
	  <div id="upload"></div>
	  </form></div>
<form id="sitesettings" method="post">
<label type="text" name="sitename">Site Name</label>
<br /><input type="text" name="sitename" value="'.$ss2['site_name'].'">
<br /><br /><label type="text" name="sitetitle">Site Title</label>
<br /><input type="text" name="sitetitle" value="'.$ss2['site_title'].'">
<br /><br /><label type="text" name="adminemail">Admin Email</label>
<br /><input type="text" name="adminemail" value="'.$ss2['admin_email'].'">
<br /><br /><label type="text" name="metadescription">Site Meta Description</label>
<div class="smalltext">200 character max.</div>
<br /><textarea class="metadescription" name="metadescription" maxlength="200">'.$ss2['site_metadescription'].'</textarea>
<br /><br /><label type="text" name="dateformat">Date format</label>
<div class="smalltext">PHP format only (<a href="http://php.net/manual/en/function.date.php" title="PHP time manual" alt="PHP time manual">read here</a>)</div>
<br /><input type="text" name="dateformat" value="'.$ss2['date_format'].'">
<br /><br /><label type="text" name="timeformat">Time format</label>
<div class="smalltext">PHP format only (<a href="http://php.net/manual/en/function.date.php" title="PHP time manual" alt="PHP time manual">read here</a>)</div>
<br /><input type="text" name="timeformat" value="'.$ss2['time_format'].'">
<br /><br /><label type="text" name="sitecolor">Site Color</label>
<div class="smalltext">Color must be in hexidecimal format.</div>
<br /><input type="text" name="sitecolor" value="'.$ss2['site_color'].'">
<br /><br /><label type="text" name="postsperpage">Posts Per Page</label>
<br /><input type="text" name="postsperpage" value="'.$ss2['postsperpage'].'">
<br /><br /><label type="text" name="commentsperpage">Comments Per Page</label>
<br /><input type="text" name="commentsperpage" value="'.$ss2['commentsperpage'].'">
<br /><br /><label name="sitescrolling">Site scrolling</label>
<div class="sitescrolling">
<input type="radio" name="sitescrolling"  ';
  if ($ss2['navigation_select'] == '0'){
	echo 'value="0" checked';
} else {
	echo 'value="0"';
}
echo'> Paged<br>
  <input type="radio" name="sitescrolling" ';
  if ($ss2['navigation_select'] == '1'){
	echo 'value="1" checked';
} else {
	echo 'value="1"';
}
echo'> Dynamic<br>';
echo '<br><input type="checkbox" name="subtextenabled" ';  if ($ss2['subtext_on'] == '1'){
	echo 'value="1" checked';
} else {
	echo 'value="0"';
}echo'> User Subtext Boxes Enabled<br>';
echo '<br><input type="checkbox" name="usercontactenabled" ';  if ($ss2['contact_users_on'] == '1'){
	echo 'value="1" checked';
} else {
	echo 'value="0"';
}echo'> Public user contact enabled<br>';
echo '<br><input type="checkbox" name="logoenabled" ';  if ($ss2['logo_on'] == '1'){
	echo 'value="1" checked';
} else {
	echo 'value="0"';
}echo'> Logo enabled<br></div>';
	echo '<script>$(';echo"'";echo'input[type="checkbox"]';echo"').change(function(){
    this.value = (Number(this.checked));
	});
	
    $('input[type=radio][name^=sitescrolling]').change(function() {
        if (this.value == '1') {
			$('input[type=radio][name^=sitescrolling]').removeAttr('checked');
			$('input[type=radio][name^=sitescrolling]').val('1');
			this.value = '0';
			this.setAttribute('checked', '');
			$(this).prop('checked', true);
        }
        else if (this.value == '0') {
			$('input[type=radio][name^=sitescrolling]').removeAttr('checked');
			$('input[type=radio][name^=sitescrolling]').val('0');
			this.value = '1';
			this.setAttribute('checked', '');
			$(this).prop('checked', true);
        }
    });</script>";
echo'<input type="hidden" name="sitesettings" value="1">
<br /><input class="postsubmit" name="settingssubmit" type="submit" value="Submit">
</form>
';
}
else if (strpos($_SERVER['REQUEST_URI'], "theme")){
echo consolemenu();
echo '<div id="page"><div class="center">Theme</div>
<br />';
$themedirsinit = scandir($_SERVER["DOCUMENT_ROOT"].'/themes/');
unset($themedirsinit[0]);
unset($themedirsinit[1]);
foreach ($themedirsinit as $option){
	$ss3 = $global->sqlquery("SELECT * FROM dd_settings");
	$ss4 = $ss3->fetch_assoc();
	echo '<div class="postbox">';
	echo '<div class="postoptions">';
	if ($ss4['default_theme'] == $option) {
	echo 'Activated';
	} else {
	echo '<a href="/console/settings/themes/activatetheme?theme='.$option.'" alt="Activate theme" title="Activate theme">Activate theme</a>';
	}
	echo ' | <a href="/console/settings/theme/css?theme='.$option.'" alt="Edit CSS" title="Edit CSS">Edit CSS</a></div>';
	echo '<div class="posttitle">';
	$themedirs = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/themes/'.$option.'/info.ini');
	echo $themedirs[themename];
	echo '</div>';
	echo '<div class="postdate">By '.$themedirs[creator].' ('.$themedirs[version].')</div>';
	echo '<br /><div class="themedescription">'.$themedirs[description].'</div>';
	echo '</div>';
	}
echo '</div>';
} else if (strpos($_SERVER['REQUEST_URI'], "storage")){
		$ss5 = $global->sqlquery("SELECT * FROM dd_storage");
		$ss6 = $ss5->fetch_assoc();
		$ss7 = $global->sqlquery("SELECT * FROM dd_mail");
		$ss8 = $ss7->fetch_assoc();

echo consolemenu();
echo '<div id="page"><div class="center">Storage Settings</div>
<br />
<div id="settingslist">
<form id="storagesettings" method="post">
<div class="sitescrolling">
<input type="checkbox" name="storageenabled" ';
if ($ss6['ftp_inuse'] == '1')
{ echo' value="1" checked';}
else { echo ' value="0"';}echo '> FTP Enabled<br>';
echo '</div>
<br /><label type="text" name="storageserver">FTP Server</label>
<br /><input type="text" name="storageserver" value="'.$ss6['ftp_server'].'">
<br /><br /><label type="text" name="storageuser">FTP User</label>
<br /><input type="text" name="storageuser" value="'.$ss6['ftp_user'].'">
<br /><br /><label type="text" name="storagepassword">FTP Password</label>
<br /><input type="password" name="storagepassword" value="'.$ss6['ftp_password'].'">
<br /><br /><label name="storagedirectory">FTP directory</label>
<br /><input type="text" name="storagedirectory" value="'.$ss6['ftp_directory'].'">
<br /><br /><input class="postsubmit" name="ftpsettingssubmit" type="submit" value="Submit">
</form>	
<div>';
echo '<div id="settingslist">
<form id="mailsettings" method="post">
<div class="sitescrolling">
<br /><input type="checkbox" name="mailenabled"';
if ($ss8['mail_inuse'] == '1')
{ echo' value="1" checked';}
else { echo ' value="0"';}echo '> Mail server enabled<br>';
	echo '<script>$(';echo"'";echo'input[type="checkbox"]';echo"').change(function(){
    this.value = (Number(this.checked));
	});</script>";
echo '</div>
<br /><label type="text" name="mailserver">Mail (SMTP) Server</label>
<br /><input type="text" name="mailserver" value="'.$ss8['mail_server'].'">
<br /><br /><label type="text" name="mailuser">Mail User</label>
<br /><input type="text" name="mailuser" value="'.$ss8['mail_user'].'">
<br /><br /><label type="text" name="mailpassword">Mail Password</label>
<br /><input type="password" name="mailpassword" value="'.$ss8['mail_password'].'">
<br /><br /><input class="postsubmit" name="mailsettingssubmit" type="submit" value="Submit">
</form>	
<div></div>';	
} else if (strpos($_SERVER['REQUEST_URI'], "categoriesandpages/tags")){
		$ss3 = $global->sqlquery("SELECT * FROM dd_categories");
		$ss4 = $ss3->fetch_assoc();
	
echo consolemenu();
echo '<div id="page">
<div class="center"><a href="/console/settings/categoriesandpages/mail" title="Mail" alt="Mail">Mail</a> | Tags | <a href="/console/settings/categoriesandpages/" title="Tags" alt="Tags">Categories</a> | <a href="/console/settings/categoriesandpages/2" title="Pages" alt="Pages">Pages</a></div>
</br>
<div id="settingslist" class="center">
<form id="tagdelete" method="post">
<label name="categorydelete">Delete Tag</label>
<br /><select name="tagdelete">';
$result = $global->sqlquery("SELECT * FROM dd_tags;");
	while ($row = $result->fetch_array()){
	echo '<option value="'.$row['tag_name'].'">'.$row['tag_name'].'</option>';
	}
echo '</select>
<input type=hidden name="tagdeletedistinguish" value="set">
<br /><br /><input class="postsubmit" name="tagdeletesubmit" type="submit" value="Submit"></form>';
} 




else if (strpos($_SERVER['REQUEST_URI'], "categoriesandpages/mail")){
		$ss3 = $global->sqlquery("SELECT * FROM dd_mailtree");
		$ss4 = $ss3->fetch_assoc();
	
echo consolemenu();
echo '<div id="page">
<div class="center">Mail | <a href="/console/settings/categoriesandpages/tags" title="Tags" alt="Tags">Tags</a> | <a href="/console/settings/categoriesandpages/" title="Categories" alt="Categories">Categories</a> | <a href="/console/settings/categoriesandpages/2" title="Pages" alt="Pages">Pages</a></div>
</br>
<div id="settingslist" class="center">
<form id="maildelete" method="post">
<label name="categorydelete">Delete Mail Destination</label>
<br /><select name="maildelete">';
$result = $global->sqlquery("SELECT * FROM dd_mailtree;");
	while ($row = $result->fetch_array()){
	echo '<option value="'.$row['mailtree_name'].'">'.$row['mailtree_name'].' ('.$row['mailtree_email'].')</option>';
	}
echo '</select>
<input type=hidden name="maildeletedistinguish" value="set">
<br /><br /><input class="postsubmit" name="maildeletesubmit" type="submit" value="Submit"></form>';
echo '<form id="mailadd" method="post">
<br /><label name="mailcategoryadd">Add Mail Category</label>
<br /><input type=text name="mailcategoryadd">
<br /><br /><label name="maildestinationadd">Mail Destination</label>
<br /><input type=text name="maildestinationadd">
<br /><br /><input class="postsubmit" name="mailaddsubmit" type="submit" value="Submit"></form>
';
}else if (strpos($_SERVER['REQUEST_URI'], "categoriesandpages")){
		$ss3 = $global->sqlquery("SELECT * FROM dd_categories");
		$ss4 = $ss3->fetch_assoc();
	
echo consolemenu();
echo '<div id="page">
<div class="center"><a href="/console/settings/categoriesandpages/mail" title="Mail" alt="Mail">Mail</a> | <a href="/console/settings/categoriesandpages/tags" title="Tags" alt="Tags">Tags</a> | Categories | <a href="/console/settings/categoriesandpages/2" title="Pages" alt="Pages">Pages</a></div>
</br>
<div id="settingslist">
<form id="categoryedit1" method="post">
<label name="categorydelete">Delete Category</label>
<br /><select name="categorydelete">';
$result = $global->sqlquery("SELECT * FROM dd_categories;");
	while ($row = $result->fetch_array()){
	echo '<option value="'.$row['category_name'].'">'.$row['category_name'].'</option>';
	}
echo '</select>
<input type=hidden name="categorydeletedistinguish" value="set">
<br /><br /><input class="postsubmit" name="categorydeletesubmit" type="submit" value="Submit"></form>
<form id="categoryedit2" method="post">
<br /><label name="categoryadd">Add Category</label>
<br /><input type=text name="categoryadd">
<br /><br /><input class="postsubmit" name="categoryaddsubmit" type="submit" value="Submit"></form>
';
} else if (strpos($_SERVER['REQUEST_URI'], "importexport")) {
echo consolemenu();
echo '<div id="page"><div class="center"><h2>Export</h2>
<br /><a href="/console/export" title="Export" alt="Export">Click here to export database in DiamondBlog XML format.</a></div>
<br />
<form id="import" method="post">
<br /><div class="center"><h2 name="importfile">Import</h2>
<br /><input type="file" accept=".xml" id="importfile" name="importfile"></div>
<br /><br /><input class="importsubmit" name="importsubmit" type="submit" value="Submit"></form>
';
echo '<script>
$(\'#import\').on(\'click\', \'input[type="submit"]\', function() {
var formdata = new FormData($(this).parents(\'#import\')[0]);
$(\'.error\').remove();
event.preventDefault();
$("input, button, select, textarea").prop(\'disabled\', true);
$(\'body\').append(\'<div class="message"><div class="successmessage" style="background-color:#f0f0f0">Please wait...</div></div>\');
	      $.ajax({
          type: \'POST\',
          url: \'/console/import\',
          data: formdata,
		  cache: false,
		  contentType: false,
		  processData: false, 
          success: function(data) {
              if (data == \'Success\') {
                  	//successful validation
					$("input, button, select, textarea").prop(\'disabled\', false);
					$(".successmessage").remove();
					$(\'body\').append(\'<div class="message"><div class="successmessage">Database Imported!</div></div>\')
					$(\'.successmessage\').delay(5000).fadeOut(\'fast\');
			  } else {
	        console.log(\'Error: \' + data); // view in console for error messages
                      $(\'.importsubmit\').after(\'<label class="error">\'+data+\'</label>\');
	  $("input, button, select, textarea").prop(\'disabled\', false);
	  $(".successmessage").remove();
                  $(\'.importsubmit\').focus();
              }
          }
      });
});</script>';

}else {
echo consolemenu();
echo '<div id="page"><div class="center">Settings</div>
<br />
<div id="settingslist">
<li><a href="/console/settings/site" "title="Site settings" "alt="Site settings">Site settings</a></li>
<div class="smalltext">Adjust settings such as how many posts display, change the site-name and change the feel of the site.</div>
<li><a href="/console/settings/theme" "title="Theme" "alt="Theme">Theme</a></li>
<div class="smalltext">Change the look of your blog.</div>
<li><a href="/console/settings/storage" "title="Storage settings" "alt="Storage settings">Storage settings</a></li>
<div class="smalltext">Store images elsewhere that is not on this server.</div>
<li><a href="/console/settings/categoriesandpages" "title="Tags, Categories, Pages & Mail Destinations" "alt="Tags, Categories, Pages & Mail Destinations">Tags, Categories, Pages & Mail Destinations</a></li>
<div class="smalltext">Adjust the sites informative side, all information management functions here.</div>
<li><a href="/console/settings/templates" "title="Templates" "alt="Templates">Templates</a></li>
<div class="smalltext">Configure what your visitors will see.</div>
<li><a href="/console/settings/importexport" "title="Import/Export" "alt="Import/Export">Import/Export</a></li>
<div class="smalltext">Export a/import an DiamondBlog XML database file.</div>
<li><a href="/console/settings/plugins" "title="Plugins" "alt="Plugins">Plugins</a></li>
<div class="smalltext">Enable and disable them here.</div>
<li><a href="/console/settings/pluginsettings" "title="Plugin Settings" "alt="Plugin Settings">Plugin Settings</a></li>
<div class="smalltext">Configure your plugins here.</div>
</div></div>';
}
} else {

echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to view this section!</div></div>';

} }else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>
