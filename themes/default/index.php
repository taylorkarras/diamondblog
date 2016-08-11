<html>
<?php rssdetect()?>
<?php themeheader()?>
<body>
<div id="wrapper">
<div id="header">
<div class="logo">
<?php themelogo()?>
</div>
<?php dbmenu1()?>
</div>
<?php dbsearchbar()?>
<div id="blog">
<?php phrouteresponse()?>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/scripts/diamondblog-func.js"></script>
</div>

</div>
<div id="footer"></div>
<?php
pluginClass::hook( "end_of_body" ); ?>
</body>
</html>