<!DOCTYPE html>
<html>
<head>
<meta name="robots" content="noindex" />
<link rel="stylesheet" type="text/css" href="https://noembed.com/noembed.css" />
<link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/styles/style.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" media="screen and (max-width : 615px)" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/styles/style-600px.css">
<link rel="stylesheet" media="screen and (max-width : 535px)" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/styles/style-540px.css">
<link rel="stylesheet" media="screen and (max-width : 482px)" href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/styles/style-480px.css">
<title>DiamondBlog Console<?php if (defined('POSTPEND')){
	echo ' - '.POSTPEND;
	if (defined('PAGE')){
	echo  PAGE;
	}
} ?></title>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/jquery-2.2.3.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/ckeditor/ckeditor.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/ckeditor/adapters/jquery.js"></script>
<link href="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/featherlight.min.css" rel="stylesheet" type="text/css" />
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console//scripts/featherlight.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/jquery.autocomplete.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/jquery.mousewheel.min.js"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/jquery.jscroll.min.js"></script>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
<script>
    var CKEDITOR_BASEPATH = '/scripts/ckeditor/';
</script>
<?php navigation();?>
</head>
<body>
<?php phrouteresponse()?>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/console-func.js"></script>
</body>
</html>
