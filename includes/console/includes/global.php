<?php

// Database settings
// database hostname or IP. default:localhost
// localhost will be correct for 99% of times
define("HOST", "hostnamereplacesql");
// Database user
define("DBUSER", "dbuserreplacesql");
// Database password
define("PASS", 'dbpassreplacesql');
// Database name
define("DB", "dbreplacesql");

class DB_global
{

############## Make the mysql connection ###########
public function sqlquery($queryterms)
{

	$sql = mysqli_connect(HOST, DBUSER, PASS, DB);

if ($sql->connect_errno) {
    echo 'Could not connect!, Please contact the site\'s administrator.' . $mysqli->connect_error;
}
else {
	return $sql->query($queryterms);
}
}

public function real_escape_string($word)
{

	$sql = mysqli_connect(HOST, DBUSER, PASS, DB);

if ($sql->connect_errno) {
    echo 'Could not connect!, Please contact the site\'s administrator.' . $mysqli->connect_error;
}
else {
	return $sql->real_escape_string($word);
}
}

public function sqllastid($queryterms)
{

        $sql = mysqli_connect(HOST, DBUSER, PASS, DB);

if ($sql->connect_errno) {
    echo 'Could not connect!, Please contact the site\'s administrator.' . $mysqli->connect_error;
}
else {
        $temp = $sql->query($queryterms);
        return $sql->insert_id;
}
}



public function generate_code($length = 10)
{
 
    if ($length <= 0)
    {
        return false;
    }
 
    $code = "";
    $chars = "abcdefghijklmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
    srand((double)microtime() * 1000000);
    for ($i = 0; $i < $length; $i++)
    {
        $code = $code . substr($chars, rand() % strlen($chars), 1);
    }
    return $code;
 
}
}
