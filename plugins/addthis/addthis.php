<?php
if( !defined( "INPROCESS" ) ){
 header("HTTP/1.0 403 Forbidden");
 die();
}

class addthis extends plugin {

    static function end_of_body(){
		$global = new DB_global;
		$addthiscode1 = $global->sqlquery("SELECT * from ddp_addthis");
		$addthiscode2 = $addthiscode1->fetch_assoc();
        echo $addthiscode2['addthis_code'];
        return true;
    }
}
?>