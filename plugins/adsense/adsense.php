<?php

if( !defined( "INPROCESS" ) ){
 header("HTTP/1.0 403 Forbidden");
 die();
}

class adsense extends plugin {

    static function content_top(){
		$global = new DB_global;
		$adcode1 = $global->sqlquery("SELECT * from ddp_adsense");
		$adcode2 = $adcode1->fetch_assoc();
        echo $adcode2['adcode_content'];
		echo '<br>';
        return true;
    }
	
    static function post_top(){
		$global = new DB_global;
		$adcode1 = $global->sqlquery("SELECT * from ddp_adsense");
		$adcode2 = $adcode1->fetch_assoc();
        echo $adcode2['adcode_post'];
		echo '<br>';
        return true;
    }
	
    static function post_bottom(){
		$global = new DB_global;
		$adcode1 = $global->sqlquery("SELECT * from ddp_adsense");
		$adcode2 = $adcode1->fetch_assoc();
        echo $adcode2['adcode_post'];
		echo '<br>';
        return true;
    }
}
?>