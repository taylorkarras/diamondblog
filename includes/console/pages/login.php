<?php
$retrive = new DB_retrival;
if (!$retrive->isLoggedIn())
{
unset($_SESSION["errors"]);
    // user is not logged in.
    if (isset($_POST))
    {
		if(trim($_POST['usernamelogin']) === '')  {
		$_SESSION['errors']['usernamelogin'] = "Forgot to enter in your username.";
		$hasError = true;	
	} else {
		$usernamelogin = trim($_POST['usernamelogin']);
	}
	
	if(trim($_POST['passwordlogin']) === '')  {
		$_SESSION['errors']['passwordlogin'] = "Forgot to enter in your password.";
		$hasError = true;
	} else {
		$passwordlogin = trim($_POST['passwordlogin']);
	}	
	
	if($_POST['remember'] == '1'){
		$remember = '1';
	} else {
		$remember = '0';
	}
	
	if(isset($usernamelogin) && isset($passwordlogin) && $retrive->checkLogin($usernamelogin, $passwordlogin, $remember) == false && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
		$_SESSION['errors']['loginstatus'] = "Could not login!, Invalid login credentials!";
		$hasError = true;
    }
	
	if(isset($usernamelogin) && isset($passwordlogin) && $retrive->checkLogin($usernamelogin, $passwordlogin, $remember) == true && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
	   $_SESSION['resp']['formrefresh'] = true;
       echo json_encode($_SESSION['resp']);
       exit;
	}
	
	if(isset($hasError)){
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&  strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                echo json_encode($_SESSION['errors']);
                exit;
	}}
	// retrieve the username and password sent from login form & check the login.
	
        // retrieve the username and password sent from login form & check the login.
	}        // User is not logged in and has not pressed the login button
        // so we show him the loginform
		echo '<h1 id="welcome">Welcome to '.sitename().', powered by DiamondBlog!</h1>
<form id="login" method="post">
<input name="loginstatus" type="hidden" id="loginstatus" />
<label title="Username"><b>Username:</b></label>
  <div class="minorbreak"></div><input tabindex="1" accesskey="u" name="usernamelogin" type="text" maxlength="30" class="txtarea requiredField" id="usernamelogin" />
  <div class="minorbreak"></div><label title="Password"><b>Password:</b></label>
  <div class="minorbreak"></div><input tabindex="2" accesskey="p" name="passwordlogin" type="password" maxlength="15" class="txtarea requiredField" id="passwordlogin" />
  <div class="minorbreak"></div><input type="checkbox" name="remember" value="0">Remember Me
  <div class="minorbreak"></div>
  <input name="reset" type="reset" value="Reset">
    <input id="loginbox" name="login" type="submit" value="Login">
</form>';
	echo '<script>$(';echo"'";echo'input[type="checkbox"]';echo"').change(function(){
    this.value = (Number(this.checked));
	});</script>";
} else
{
	$templates = new League\Plates\Engine();
	$templates->addFolder('console', ''.$_SERVER['DOCUMENT_ROOT'].'/includes/console/pages');
    echo $templates->render('console::summary');;
}