<?php
if( !defined( "INPROCESS" ) ){
 header("HTTP/1.0 403 Forbidden");
 die();
}
		
		include($_SERVER['DOCUMENT_ROOT'].'/plugins/pushnotifications/vendor/autoload.php');
		use ElephantIO\Client as Elephant;
		use ElephantIO\Engine\SocketIO\Version1X as Version1X;

class pushnotifications extends plugin {

    static function manifest(){
		$global = new DB_global;
		$settings = $global->sqlquery("SELECT * from ddp_pushnotifications");
		$settings2 = $settings->fetch_assoc();
		echo ' "gcm_sender_id": "'.$settings2['gcm_projectno'].'",';
	}

    static function head(){
		$global = new DB_global;
		$settings = $global->sqlquery("SELECT * from ddp_pushnotifications");
		$settings2 = $settings->fetch_assoc();
		echo '
		<script src="'.$settings2['nodejs_server'].'/socket.io/socket.io.js"></script>';
echo "<script type='text/javascript'>
if ('Notification' in window) {

var socket = io.connect('".$settings2['nodejs_server']."');

	socket.emit('register', {blogname: 'vapourban'});

if ('serviceWorker' in navigator) {
navigator.serviceWorker.register('/sw.js');
			        Notification.requestPermission(function(result) {
			if (result === 'granted') {
				navigator.serviceWorker.ready.then(function(reg) {
					        reg.pushManager.subscribe({
            userVisibleOnly: true
        }).then(function(sub) {
				var ep = sub.endpoint.split('/');
$.get('/plugins/pushnotifications/ip.php',
      function(data) {
        var ip = data;
		var ua = navigator.userAgent;
      
			var data ={
				'ipaddress' : ip,
				'endpoint' : ep.slice(-1).pop(),
				'useragent' : ua
			};
			
			$.ajax({
				type : 'POST',
				url : '/plugins/pushnotifications/addtodb.php',
				data : data,
				dataType: 'JSON'
			})
			
				})
				});
				})
				
				navigator.serviceWorker.ready.then(function(registration) {
socket.on('notification', function (data) {
	
    registration.showNotification(data.args.title, {
      body: data.args.message,
      icon: data.args.logo,
      lang: 'en',
      vibrate: [300, 50, 300]
	}).onclick = function () {
      window.open(data.args.url);
    };
})
				})
			}
});
} else {
				        Notification.requestPermission(function(result) {
			if (result === 'granted') {
	socket.on('notification', function (data) {
	new Notification(data.args.title, {
      body: data.args.message,
      icon: data.args.logo,
      lang: 'en',
      vibrate: [300, 50, 300]
	}).onclick = function () {
      window.open(data.args.url);
    };
	})
			}
						})
}
}
			//Closing
</script>";

        return true;
    }

    static function inc_post_form_bottom(){
		$global = new DB_global;
		$pushcode = $global->sqlquery("SELECT * FROM ddp_pushnotifications_list");
		$settings = $global->sqlquery("SELECT * from ddp_pushnotifications");
		$settings2 = $settings->fetch_assoc();

$elephant = new Elephant(new Version1X('https://central.vapourban.com:8000'));
$elephant->initialize();
$elephant->emit('broadcast', ['blogname' => 'vapourban','type' => 'notification','args' => array('logo' => 'https://vapourban.com/images/android-icon-192x192.png', 'title' => 'New Post in '.$GLOBALS['category'], 'message' => $GLOBALS['posttitle'], 'url' => 'http://vapourban.com/'.$GLOBALS['shortlink'])]);
$elephant->close();
if ($pushcode->num_rows > '0') {

while ($row = $pushcode->fetch_assoc()) {

	if(strpos($row['list_useragent'], 'Chrome')){
$data = array("registration_ids" => array($row['list_endpoint']), "notification" => array("body" => $GLOBALS['posttitle'], "title" => "New Post in ".$GLOBALS['category'], "icon" => "https://vapourban.com/images/android-icon-192x192.png", "click_action" => "http://vapourban.com/".$GLOBALS['shortlink']));
$json = str_replace(array("\\r","\\n","\\t"), "",json_encode($data,JSON_PRETTY_PRINT));

$headers = array('Authorization: key='.$settings2['gcm_apiid'],'Content-Type:' . 'application/json');
$gcm = curl_init("https://fcm.googleapis.com/fcm/send");
curl_setopt($gcm, CURLOPT_POST, true);
curl_setopt($gcm, CURLOPT_POSTFIELDS, $json);
curl_setopt($gcm, CURLOPT_HTTPHEADER, $headers);
	}
if(strpos(curl_exec($gcm), 'NotRegistered')){
$global->sqlquery("DELETE FROM ddp_pushnotifications_list WHERE list_endpoint = '".$row['list_endpoint']."';");
}
}
}
		exit;
    }
}
?>