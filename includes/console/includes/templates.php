<?php
$templates = new League\Plates\Engine();

function renderconsole(){
global $templates;
$templates->addFolder('root', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/');
echo $templates->render('root::index');

}

//Define theme functions//
?>