<?php
$global = new DB_global;
$temp1 = $global->sqlquery("SELECT * FROM dd_templates");
$temp2 = $temp1->fetch_assoc();

echo consolemenu();
echo '<div id="page">
<div class="center">Templates</div>
</br>
<div id="settingslist">
<div class="center">404 page</div>
<form id="template" method="post">
<textarea class="ckeditor" name="404template">'.$temp2['404_message'].'</textarea>
<input type=hidden name="404distinguish" value="set">
<div class="center">Comment warning</div>
<form id="template2" method="post">
<textarea class="ckeditor" name="commentwarning">'.$temp2['comment_notification_message'].'</textarea>
<input type=hidden name="cwdistinguish" value="set">
<br /><br /><input class="postsubmit" name="404submit" type="submit" value="Submit"></form>
</div></div>';
?>