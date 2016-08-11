<?php
$retrive = new DB_retrival;
	if ($retrive->isLoggedIn() == true){
if ($retrive->restrictpermissionlevel('3')){

echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to view this section!</div></div>';

} else {
if(isset($_GET['style'])){
echo consolemenu();
$csscontents = file_get_contents($_SERVER['DOCUMENT_ROOT'].'/themes/'.$_GET['theme'].'/styles/'.$_GET['style']);
echo '<div id="page"><div class="center">Edit '.$_GET['style'].'
<br /><br />
<form id="themecss" method="post">
<textarea name="cssfile" class="cssedit">'.$csscontents.'</textarea>
<input type="hidden" name="themename" value="'.$_GET['theme'].'"/>
<input type="hidden" name="cssname" value="'.$_GET['style'].'"/>
<input type="submit" name="csssubmit" />
</form></div></div>';

} else {
echo consolemenu();
echo '<div id="page"><div class="center">Edit '.$_GET['theme'].' CSS
<br /><br />';
$themedirsinit = scandir($_SERVER["DOCUMENT_ROOT"].'/themes/'.$_GET['theme'].'/styles/');
unset($themedirsinit[0]);
unset($themedirsinit[1]);
foreach ($themedirsinit as $option){
echo'
<li><a href="/console/settings/theme/css?theme='.$_GET['theme'].'&style='.$option.'" "title="'.$option.' settings" "alt="'.$option.'">'.$option.'</a></li>';
}
echo '</div></div></div>';
}
	}} else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}