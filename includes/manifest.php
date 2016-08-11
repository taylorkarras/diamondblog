<?php
header('Content-Type: application/json');
$global = new DB_global;
$settingsinit = $global->sqlquery("SELECT * FROM dd_settings;");
$settings = $settingsinit->fetch_assoc();
echo '{
 "name": "'.$settings['site_name'].'",
 "description": "'.$settings['site_title'].'",
 "display": "minimal-ui",
'; pluginClass::hook( "manifest" );
echo '
 "background-color": "'.$settings['site_color'].'",
 "icons": [
  {
   "src": "\/images\/favicon-36px.png",
   "sizes": "36x36",
   "type": "image\/png",
   "density": "0.75"
  },
  {
   "src": "\/images\/favicon-48px.png",
   "sizes": "48x48",
   "type": "image\/png",
   "density": "1.0"
  },
  {
   "src": "\/images\/favicon-76px.png",
   "sizes": "76x76",
   "type": "image\/png",
   "density": "1.5"
  },
  {
   "src": "\/images\/favicon-96px.png",
   "sizes": "96x96",
   "type": "image\/png",
   "density": "2.0"
  },
  {
   "src": "\/images\/favicon-152px.png",
   "sizes": "152x152",
   "type": "image\/png",
   "density": "3.0"
  },
  {
   "src": "\/images\/favicon-192px.png",
   "sizes": "192x192",
   "type": "image\/png",
   "density": "4.0"
  }
 ]
}';
exit;