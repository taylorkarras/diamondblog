<?php
if( !defined( "INPROCESS" ) ){
 header("HTTP/1.0 403 Forbidden");
 die();
}

class googlenews extends plugin {

    static function link_routes(){

$GLOBALS['router']->get('/newsfeed', function(){
$templates = new League\Plates\Engine();
$templates->addFolder('googlenews', $_SERVER['DOCUMENT_ROOT'].'/plugins/googlenews');
    return $templates->render('googlenews::googlenews_xml');;
});

	}
	
	}