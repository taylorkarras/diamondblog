<?php
if( !defined( "INPROCESS" ) ){
 header("HTTP/1.0 403 Forbidden");
 die();
}

class ganalytics extends plugin {

    static function head(){
		$global = new DB_global;
		$analyticscode1 = $global->sqlquery("SELECT * from ddp_ganalytics");
		$analyticscode2 = $analyticscode1->fetch_assoc();
        echo $analyticscode2['analytics_code'];
        return true;
    }
}
?>