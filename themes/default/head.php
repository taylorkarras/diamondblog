<head>
<title><?php sitename() ?>: <?php sitetitle() ?></title>
<?php essentialhead()?>
<?php amp()?>
<?php
pluginClass::hook( "head" ); ?>
<!--[if lte IE 9]>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/scripts/modernizr-custom.js"></script>
<script   src="https://code.jquery.com/jquery-1.12.4.min.js"   integrity="sha256-ZosEbRLbNQzLpnKIkEdrPv7lOy9C27hHQ+Xp8a4MxAQ="   crossorigin="anonymous"></script>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/scripts/placeholder.js"></script>
<![endif]-->
<link rel="stylesheet" media="screen and (max-width : 615px)" href="<?php themestylecustom('style-600px.css')?>">
<link rel="stylesheet" media="screen and (max-width : 535px)" href="<?php themestylecustom('style-540px.css')?>">
<link rel="stylesheet" media="screen and (max-width : 482px)" href="<?php themestylecustom('style-480px.css')?>">
<?php themestyle()?>
<link href="<?php themestylecustom('print.css')?>" rel="stylesheet" media="print" type="text/css" />
</head>
