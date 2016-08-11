<?php 
if (isset($_COOKIE['userID']) && isset($_COOKIE['username'])){
	   	   unset($_COOKIE['userID']);
	   unset($_COOKIE['username']);
	   setcookie('userID', null, -1,"/");
	   setcookie('username', null, -1,"/");
	   session_destroy();
	   header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
} else {
	session_destroy();
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>