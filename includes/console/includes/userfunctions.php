<?php
class DB_userfunctions {

public function changePassword($userid,$newpassword,$newpassword2){
$global = new DB_global;
 
	// we get the current password from the database
 
    $result = $global->sqlquery("SELECT user_password FROM dd_users  WHERE user_id = '".$userid."' LIMIT 1;");
	$encryptpassword = $result->fetch_assoc();
 
	// now we update the password in the database
	
	$newpassword2encrypt = password_hash($newpassword2, PASSWORD_DEFAULT);
    $query = sprintf("update dd_users set user_password = '".$newpassword2encrypt."' where user_id = '".$userid."'");
 
    if ($global->sqlquery($query))
    {
		return true;
	}else {return false;}
	return false;
}

public function user_exists($username)
{
 
$global = new DB_global;
 
    $query = sprintf("SELECT user_id FROM dd_users WHERE user_username = '".$username."' LIMIT 1");
    $result = $global->sqlquery($query);
 
    if (mysqli_num_rows($result) > 0)
    {
        return true;
    } else
    {
        return false;
    }
 
    return false;
 
}

public function user_email_exists($email)
{
 
  $global = new DB_global;
 
    $query = sprintf("SELECT user_id FROM dd_users WHERE user_email = '".$email."' LIMIT 1");
    $result = $global->sqlquery($query);
 
    if (!mysqli_num_rows($result) > 0)
    {
        return true;
    } else
    {
        return false;
    }
 
    return false;
 
}

#### Validation functions ####
public function valid_email($email)
{
 
	// First, we check that there's one @ symbol, and that the lengths are right
	if (!preg_match('/^[^@]{1,64}@[^@]{1,255}$/', $email))
	{
		// Email invalid because wrong number of characters in one section, or wrong number of @ symbols.
		return false;
	}
	// Split it into sections to make life easier
	$email_array = explode("@", $email);
	$local_array = explode(".", $email_array[0]);
	for ($i = 0; $i < sizeof($local_array); $i++)
	{
		if (!preg_match("/^(([A-Za-z0-9!#$%&'*+=?^_`{|}~-][A-Za-z0-9!#$%&'*+=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$/",
		$local_array[$i]))
		{
			return false;
		}
	}
	if (!preg_match("/^\[?[0-9\.]+\]?$/", $email_array[1]))
	{ // Check if domain is IP. If not, it should be valid domain name
		$domain_array = explode(".", $email_array[1]);
		if (sizeof($domain_array) < 2)
		{
			return false; // Not enough parts to domain
		}
		for ($i = 0; $i < sizeof($domain_array); $i++)
		{
			if (!preg_match("/^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$/", $domain_array[$i]))
			{
				return false;
			}
		}
	}
	return true;
}

public function valid_realname($realname)
{
	$global = new DB_global;
	$query = "SELECT user_realname FROM dd_users WHERE user_realname = '".$realname."';";
	$result = $global->sqlquery($query);
	$real_name = $result->fetch_assoc();
	if ($realname == $real_name['user_realname']){
		return true;
	}
	else {
		return false;
	}
}

public function valid_username($username, $minlength = 3, $maxlength = 30)
{
 
	$username = trim($username);
 
	if (empty($username))
	{
		return false; // it was empty
	}
	if (strlen($username) > $maxlength)
	{
		return false; // to long
	}
	if (strlen($username) < $minlength)
	{
 
		return false; //toshort
	}
 
	$result = preg_match("/^[A-Za-z0-9_\-]+$/", $username); //only A-Z, a-z and 0-9 are allowed
 
	if ($result)
	{
		return true; // ok no invalid chars
	} else
	{
		return false; //invalid chars found
	}
 
	return false;
 
}
 
public function valid_password($pass, $minlength = 8, $maxlength = 18)
{
	$pass = trim($pass);
 
	if (empty($pass))
	{
		return false;
	}
 
	if (strlen($pass) < $minlength)
	{
		return false;
	}
 
	if (strlen($pass) > $maxlength)
	{
		return false;
	}
 
	$result = preg_match_all('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]/', $pass);
 
	if ($result)
	{
		return true;
	} else
	{
		return false;
	}
 
	return false;
 
}

public function random_password($length = 12){
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
}
?>
