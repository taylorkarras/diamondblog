<?php
$global = new DB_global;
$check = new DB_check;
$retrive = new DB_retrival;
include 'includes/templates.php';
$templates->addFolder('amp', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/blog/amp/');

$templateinit = $global->sqlquery("SELECT * FROM dd_templates;");
$template = $templateinit->fetch_assoc();

$arepageson1 = $global->sqlquery("SELECT pages_on FROM dd_settings LIMIT 1");
$arepageson2 = $arepageson1->fetch_assoc();

$link = explode("/", $_SERVER['REQUEST_URI']);

$resultpost = $global->sqlquery("SELECT * FROM dd_content WHERE content_permalink = '".$link[1]."' LIMIT 1");
$resultpostint = $resultpost->fetch_assoc();

if (!is_null($resultpostint['content_permalink'])){
echo $templates->render('amp::amppost');
} else {
header("HTTP/2.0 404 Not Found");
define ("PREPEND", '404 Not Found');
echo '<div class="notfoundpage">'.$template['404_message'].'</div>';
}
