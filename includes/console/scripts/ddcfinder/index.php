<!DOCTYPE html>
<html>
<head>
<link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/ddcfinder/style.css" rel="stylesheet" type="text/css">
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/jquery-2.2.3.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/ckeditor/ckeditor.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/ckeditor/adapters/jquery.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/ddcfinder/ddcfinder.js"></script>
</head>
<body>
<?php
include 'includes.php';
echo "<div id='dirbrowse'>
	<div class='dircontent'>";
if (restrictpermissionlevel('1')){
}
else {
echo "<div class='buttonsfix buttons' style='left: 0px'><a class='addfolder button' href='#'>Add Folder</a></div>";
echo "<div id='addfolder' class='modal'>
  <div class='modal-content'>
    <span class='close'>x</span>
    <form method='post' id='folderform'>
<label for='foldername'>Folder Name:</label>
<input name='foldername' type='text'/>
<input type='submit' id='foldersubmit' value='Create Folder' />
<input type='hidden' name='uploaderror'>
</form>

</div></div>";
}
getdir();
echo"</div>
</div>
</div><div id='main'>
<div class='content'>
<div class='buttons'><a class='upload button' href='#'>Upload</a></div>";


echo "<div id='upload' class='modal'>

  <!-- Modal content -->
  <div class='modal-content'>
    <span class='close'>x</span>
    <form enctype='multipart/form-data' method='post' enctype='multipart/form-data' id='uploadform'>
<input name='uploadimage[]' id='uploadimage' type='file' multiple accept='images/*' />
<input type='submit'  id='submit-btn' value='Upload' />
<input type='hidden' name='uploaderror'>
</form>
<div class='progress-wrap progress'>
  <div class='progress-bar progress'></div>
</div>
  </div>

</div>";

echo"<div id='fileslist'>";
echo getfiles();
echo "</div></div>
</div>
<div id='footer'>
";?>
</body>