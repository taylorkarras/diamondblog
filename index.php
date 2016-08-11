<?php
/** PHP version check **/
define('MINIMUM_PHP', '7.0');

if (version_compare(PHP_VERSION, MINIMUM_PHP, '<'))
{
	die('Your host needs to use PHP ' . MINIMUM_PHP . ' or higher to run DiamondBlog,');
}

/** MySQL check **/
function check_mysql_versions() {
	if ( ! extension_loaded( 'mysqli' ) && ! extension_loaded( 'mysqlnd' ) ) {

		header( sprintf( '%s 500 Internal Server Error', $protocol ), true, 500 );
		header( 'Content-Type: text/html; charset=utf-8' );
		die( __( 'Your PHP installation appears to be missing the MySQL extension which is required by DiamondBlog.' ) );
	}
}

header('Location: /setup/setupinterface.php');
?>