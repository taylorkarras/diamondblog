<?php
if( !defined( "INPROCESS" ) ){
 header("HTTP/1.0 403 Forbidden");
 die();
}

 class plugin{
  private function __construct(){}
 }
 
 // This is the actual plugin class.
 class pluginClass{  
  // This will be the list of active plugins
  static private $plugins = array();

  // Again, we don't want any instances 
  // of our static class.
  private function __construct(){}
  
  static function initialize(){
	  
   $directoryHandle = scandir( $_SERVER['DOCUMENT_ROOT'] . '/plugins/');
   // Populate the list of directories to check against
   if ($directoryHandle == true ) {
       foreach ($directoryHandle as $key => $directory) {
        // Make sure we're not dealing with a file or a link to the parent directory
		if ($directory == ".." or $directory == "."){
            unset($directoryHandle[$key]);
	   }
		if (is_file($directory) == true) {
			unset($directoryHandle[$key]);
       }
   }
      $directoryHandle2 = array_values($directoryHandle);
   }
   
   // We select all the plugins from our database
   // Each plugin has it's name stored, and whether
   // it is active or not (active = 0 or 1)
      $global = new DB_global;
	$key = '0';
	$active = array();
   foreach ($directoryHandle2 as $plugin) {
   $results = $global->sqlquery('SELECT * FROM ddp_'.$plugin);
   if ($results == true){
	$results2 = $results->fetch_assoc();
   if ($results2['plugin_enabled'] == '1'){
	   array_push($active, $plugin);
   }
   }
   }
   
   foreach( $active as $plugin ){
     pluginClass::register( $plugin );
   }
  }
  
  static function hook( $checkpoint ){
   foreach(pluginClass::$plugins as $plugin){
	   $callable = array($plugin, $checkpoint);
if (is_callable($callable)) {
call_user_func(array($plugin, $checkpoint));
}
   }
  }
  
  // Registration adds the plugin to the list of plugins, and also
  // includes it's code into our runtime.
  static function register( $plugin ){
   global $config_fullpath;
   require_once( $_SERVER['DOCUMENT_ROOT'] ."/plugins/$plugin/$plugin.php" );   
   array_push( pluginClass::$plugins, $plugin );
  }
 }