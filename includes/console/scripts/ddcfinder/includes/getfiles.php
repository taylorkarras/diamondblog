<?php

function getfiles(){
$retrive = new DB_retrival;
$global = new DB_global;

if($retrive->isftpenabled()){
	$ftpinit = $global->sqlquery("SELECT * FROM dd_storage");
$ftp = $ftpinit->fetch_assoc();
$conn_id = ftp_ssl_connect($ftp['ftp_server']);
ftp_pasv($conn_id, true);
$login_result = ftp_login($conn_id, $ftp['ftp_user'], $ftp['ftp_password']);
ftp_chdir($conn_id, $ftp['ftp_directory']);
$list = ftp_nlist($conn_id, ".");

$imagedms = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');

foreach ($list as $key => $value){
if(preg_match('/(.*)\.[^.]+$/', $value)){
echo '<div class="file"><div class="image"><img src="https://'.$ftp['ftp_server'].'/'.$value.'" style="width:'.$imagedms['thumbs_max_width'].'px; border:1px solid black;"></img></div>
<div class="imagename">'.$value.'</div></div>';
if (!restrictpermissionlevel('1')){}{
echo '
<ul class="custom-menu">
  <li data-action="delete">Delete</li>
</ul>';
}
}
}

echo'<script>    $(".file").click(function() {
		$(".file").removeClass("active");
        $(this).addClass("active");
    });
	
	$(".file").dblclick(function() {
		var url = $("img", this).attr("src");
		returnFileUrl(url);
		console.log(url);
	});
		</script>';
if (restrictpermissionlevel('1')){} else {
echo'<script>

$(".file").bind("contextmenu", function (event) {
    
    // Avoid the real one
    event.preventDefault();
    
    // Show contextmenu
    $(".custom-menu").finish().toggle(100).
    
    // In the right position (the mouse)
    css({
        top: event.pageY + "px",
        left: event.pageX + "px"
    });
$(".file").removeClass("active");
$(this).addClass("active");
});


// If the document is clicked somewhere
$(".file").bind("mousedown", function (e) {
    
    // If the clicked element is not the menu
    if (!$(e.target).parents(".custom-menu").length > 0) {
        
        // Hide it
        $(".custom-menu").hide(100);
    }
});


// If the menu element is clicked
$(".custom-menu li").click(function(){
var imagename = $(".active").find(".imagename").text();
    // This is the triggered action name
    switch($(this).attr("data-action")) {
        
        // A case for each action. Your actions here
        case "delete": if (confirm("Are you sure you want to delete \""+imagename+"\"?")) {
			var data = {};
    $.ajax({
		          dataType: "json",
          type: "POST",
          url: "/includes/console/scripts/ddcfinder/includes/deletefile.php?dir="+localStorage.getItem("ftpdirectory")+"&file="+imagename,
          data: data,
          success: function(resp) {
              if (resp.delete === true) {
getfiles("root");
			  }
          }
      });
  } else {
    return false;
  }
    }
  
    // Hide it AFTER the action was triggered
    $(".custom-menu").hide(100);
  });</script>';
}}else {
$imagedms = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');
$list = scandir($_SERVER['DOCUMENT_ROOT'].'/'.$imagedms['files_root']);
unset($list[0]);
unset($list[1]);
unset($list[2]);
unset($list[3]);
foreach ($list as $key => $value){
if(preg_match('/(.*)\.[^.]+$/', $value)){
echo '<div class="file"><div class="image"><img src="https://'.$_SERVER['HTTP_HOST'].$imagedms['files_root'].'/'.$value.'" style="width:'.$imagedms['thumbs_max_width'].'px; border:1px solid black;"></img></div>
<div class="imagename">'.$value.'</div></div>';
if (!restrictpermissionlevel('1')){}{
echo '
<ul class="custom-menu">
  <li data-action="delete">Delete</li>
</ul>';
}
}
}

echo'<script>    $(".file").click(function() {
		$(".file").removeClass("active");
        $(this).addClass("active");
    });
	
	$(".file").dblclick(function() {
		var url = $("img", this).attr("src");
		returnFileUrl(url);
		console.log(url);
	});
		</script>';
		if (restrictpermissionlevel('1')){} else {
echo'<script>

$(".file").bind("contextmenu", function (event) {
    
    // Avoid the real one
    event.preventDefault();
    
    // Show contextmenu
    $(".custom-menu").finish().toggle(100).
    
    // In the right position (the mouse)
    css({
        top: event.pageY + "px",
        left: event.pageX + "px"
    });
$(".file").removeClass("active");
$(this).addClass("active");
});


// If the document is clicked somewhere
$(".file").bind("mousedown", function (e) {
    
    // If the clicked element is not the menu
    if (!$(e.target).parents(".custom-menu").length > 0) {
        
        // Hide it
        $(".custom-menu").hide(100);
    }
});


// If the menu element is clicked
$(".custom-menu li").click(function(){
var imagename = $(".active").find(".imagename").text();
    // This is the triggered action name
    switch($(this).attr("data-action")) {
        
        // A case for each action. Your actions here
        case "delete": if (confirm("Are you sure you want to delete \""+imagename+"\"?")) {
			var data = {};
    $.ajax({
		          dataType: "json",
          type: "POST",
          url: "/includes/console/scripts/ddcfinder/includes/deletefile.php?dir="+localStorage.getItem("ftpdirectory")+"&file="+imagename,
          data: data,
          success: function(resp) {
              if (resp.delete === true) {
getfiles("root");
			  }
          }
      });
  } else {
    return false;
  }
    }
  
    // Hide it AFTER the action was triggered
    $(".custom-menu").hide(100);
  });</script>';
}}
}

if (isset($_GET['dir']) && $_GET['dir'] == 'root'){
require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/global.php';
require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/retrival.php';	
	
$retrive = new DB_retrival;
$global = new DB_global;

if($retrive->isftpenabled()){
	$ftpinit = $global->sqlquery("SELECT * FROM dd_storage");
$ftp = $ftpinit->fetch_assoc();
$conn_id = ftp_ssl_connect($ftp['ftp_server']);
ftp_pasv($conn_id, true);
$login_result = ftp_login($conn_id, $ftp['ftp_user'], $ftp['ftp_password']);
ftp_chdir($conn_id, $ftp['ftp_directory']);
$list = ftp_nlist($conn_id, ".");

$imagedms = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');

foreach ($list as $key => $value){
if(preg_match('/(.*)\.[^.]+$/', $value)){
echo '<div class="file"><div class="image"><img src="https://'.$ftp['ftp_server'].'/'.$value.'" style="width:'.$imagedms['thumbs_max_width'].'px; border:1px solid black;"></img></div>
<div class="imagename">'.$value.'</div></div>';
if (restrictpermissionlevel('1')){}{
echo '
<ul class="custom-menu">
  <li data-action="delete">Delete</li>
</ul>';
}
}
}

echo'<script>    $(".file").click(function() {
		$(".file").removeClass("active");
        $(this).addClass("active");
    });
	
	$(".file").dblclick(function() {
		var url = $("img", this).attr("src");
		returnFileUrl(url);
		console.log(url);
	});
		</script>';
if (restrictpermissionlevel('1')){} else {
echo'<script>

$(".file").bind("contextmenu", function (event) {
    
    // Avoid the real one
    event.preventDefault();
    
    // Show contextmenu
    $(".custom-menu").finish().toggle(100).
    
    // In the right position (the mouse)
    css({
        top: event.pageY + "px",
        left: event.pageX + "px"
    });
$(".file").removeClass("active");
$(this).addClass("active");
});


// If the document is clicked somewhere
$(".file").bind("mousedown", function (e) {
    
    // If the clicked element is not the menu
    if (!$(e.target).parents(".custom-menu").length > 0) {
        
        // Hide it
        $(".custom-menu").hide(100);
    }
});


// If the menu element is clicked
$(".custom-menu li").click(function(){
var imagename = $(".active").find(".imagename").text();
    // This is the triggered action name
    switch($(this).attr("data-action")) {
        
        // A case for each action. Your actions here
        case "delete": if (confirm("Are you sure you want to delete \""+imagename+"\"?")) {
			var data = {};
    $.ajax({
		          dataType: "json",
          type: "POST",
          url: "/includes/console/scripts/ddcfinder/includes/deletefile.php?dir="+localStorage.getItem("ftpdirectory")+"&file="+imagename,
          data: data,
          success: function(resp) {
              if (resp.delete === true) {
getfiles("root");
			  }
          }
      });
  } else {
    return false;
  }
    }
  
    // Hide it AFTER the action was triggered
    $(".custom-menu").hide(100);
  });</script>';
}}else {
$imagedms = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');
$list = scandir($_SERVER['DOCUMENT_ROOT'].'/'.$imagedms['files_root']);
unset($list[0]);
unset($list[1]);
unset($list[2]);
unset($list[3]);

foreach ($list as $key => $value){
if(preg_match('/(.*)\.[^.]+$/', $value)){
echo '<div class="file"><div class="image"><img src="https://'.$_SERVER['HTTP_HOST'].$imagedms['files_root'].'/'.$value.'" style="width:'.$imagedms['thumbs_max_width'].'px; border:1px solid black;"></img></div>
<div class="imagename">'.$value.'</div></div>';
if (restrictpermissionlevel('1')){} else {
echo'
<ul class="custom-menu">
  <li data-action="delete">Delete</li>
</ul>';
}
}
}

echo'<script>    $(".file").click(function() {
		$(".file").removeClass("active");
        $(this).addClass("active");
    });
	
	$(".file").dblclick(function() {
		var url = $("img", this).attr("src");
		returnFileUrl(url);
		console.log(url);
	});
		</script>';
		if (restrictpermissionlevel('1')){} else {
echo'<script>

$(".file").bind("contextmenu", function (event) {
    
    // Avoid the real one
    event.preventDefault();
    
    // Show contextmenu
    $(".custom-menu").finish().toggle(100).
    
    // In the right position (the mouse)
    css({
        top: event.pageY + "px",
        left: event.pageX + "px"
    });
$(".file").removeClass("active");
$(this).addClass("active");
});


// If the document is clicked somewhere
$(".file").bind("mousedown", function (e) {
    
    // If the clicked element is not the menu
    if (!$(e.target).parents(".custom-menu").length > 0) {
        
        // Hide it
        $(".custom-menu").hide(100);
    }
});


// If the menu element is clicked
$(".custom-menu li").click(function(){
var imagename = $(".active").find(".imagename").text();
    // This is the triggered action name
    switch($(this).attr("data-action")) {
        
        // A case for each action. Your actions here
        case "delete": if (confirm("Are you sure you want to delete \""+imagename+"\"?")) {
			var data = {};
    $.ajax({
		          dataType: "json",
          type: "POST",
          url: "/includes/console/scripts/ddcfinder/includes/deletefile.php?dir="+localStorage.getItem("ftpdirectory")+"&file="+imagename,
          data: data,
          success: function(resp) {
              if (resp.delete === true) {
getfiles("root");
			  }
          }
      });
  } else {
    return false;
  }
    }
  
    // Hide it AFTER the action was triggered
    $(".custom-menu").hide(100);
  });</script>';
}}



} else if (isset($_GET['dir'])){
require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/global.php';
require $_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/retrival.php';	
	
$retrive = new DB_retrival;
$global = new DB_global;

if($retrive->isftpenabled()){
	$ftpinit = $global->sqlquery("SELECT * FROM dd_storage");
$ftp = $ftpinit->fetch_assoc();
$conn_id = ftp_ssl_connect($ftp['ftp_server']);
ftp_pasv($conn_id, true);
$login_result = ftp_login($conn_id, $ftp['ftp_user'], $ftp['ftp_password']);
ftp_chdir($conn_id, $ftp['ftp_directory'].'/'.$_GET['dir']);
$list = ftp_nlist($conn_id, ".");

$imagedms = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');

foreach ($list as $key => $value){
if(preg_match('/(.*)\.[^.]+$/', $value)){
echo '<div class="file"><div class="image"><img src="https://'.$ftp['ftp_server'].'/'.$_GET['dir'].'/'.$value.'" style="width:'.$imagedms['thumbs_max_width'].'px; border:1px solid black;"></img></div>
<div class="imagename">'.$value.'</div></div>';
if ($retrive->restrictpermissionlevel('1')){} else {
	echo'
<ul class="custom-menu">
  <li data-action="delete">Delete</li>
</ul>';
}
}
}

echo'<script>    $(".file").click(function() {
		$(".file").removeClass("active");
        $(this).addClass("active");
    });
	
	$(".file").dblclick(function() {
		var url = $("img", this).attr("src");
		returnFileUrl(url);
		console.log(url);
	});
		</script>';
if ($retrive->restrictpermissionlevel('1')){} else {		
echo'<script>

$(".file").bind("contextmenu", function (event) {
    
    // Avoid the real one
    event.preventDefault();
    
    // Show contextmenu
    $(".custom-menu").finish().toggle(100).
    
    // In the right position (the mouse)
    css({
        top: event.pageY + "px",
        left: event.pageX + "px"
    });
$(".file").removeClass("active");
$(this).addClass("active");
});


// If the document is clicked somewhere
$(".file").bind("mousedown", function (e) {
    
    // If the clicked element is not the menu
    if (!$(e.target).parents(".custom-menu").length > 0) {
        
        // Hide it
        $(".custom-menu").hide(100);
    }
});


// If the menu element is clicked
$(".custom-menu li").click(function(){
var imagename = $(".active").find(".imagename").text();
    // This is the triggered action name
    switch($(this).attr("data-action")) {
        
        // A case for each action. Your actions here
        case "delete": if (confirm("Are you sure you want to delete \""+imagename+"\"?")) {
			var data = {};
    $.ajax({
		          dataType: "json",
          type: "POST",
          url: "/includes/console/scripts/ddcfinder/includes/deletefile.php?dir="+localStorage.getItem("ftpdirectory")+"&file="+imagename,
          data: data,
          success: function(resp) {
              if (resp.delete === true) {
getfiles(localStorage.getItem("ftpdirectory"));
			  }
          }
      });
  } else {
    return false;
  }
    }
  
    // Hide it AFTER the action was triggered
    $(".custom-menu").hide(100);
  });</script>';
}}else {
$imagedms = parse_ini_file($_SERVER["DOCUMENT_ROOT"].'/includes/console/scripts/ddcfinder/config.ini');
$list = scandir($_SERVER['DOCUMENT_ROOT'].'/'.$imagedms['files_root'].'/'.$_GET['dir']);
unset($list[0]);

foreach ($list as $key => $value){
if(preg_match('/(.*)\.[^.]+$/', $value)){
echo '<div class="file"><div class="image"><img src="https://'.$_SERVER['HTTP_HOST'].$imagedms['files_root'].'/'.$_GET['dir'].'/'.$value.'" style="width:'.$imagedms['thumbs_max_width'].'px; border:1px solid black;"></img></div>
<div class="imagename">'.$value.'</div></div>';
if (restrictpermissionlevel('1')){}{
	echo'
<ul class="custom-menu">
  <li data-action="delete">Delete</li>
</ul>';
}
}
}

echo'<script>    $(".file").click(function() {
		$(".file").removeClass("active");
        $(this).addClass("active");
    });
	
	$(".file").dblclick(function() {
		var url = $("img", this).attr("src");
		returnFileUrl(url);
		console.log(url);
	});
		</script>';
if (restrictpermissionlevel('1')){}{
echo'<script>

$(".file").bind("contextmenu", function (event) {
    
    // Avoid the real one
    event.preventDefault();
    
    // Show contextmenu
    $(".custom-menu").finish().toggle(100).
    
    // In the right position (the mouse)
    css({
        top: event.pageY + "px",
        left: event.pageX + "px"
    });
$(".file").removeClass("active");
$(this).addClass("active");
});


// If the document is clicked somewhere
$(".file").bind("mousedown", function (e) {
    
    // If the clicked element is not the menu
    if (!$(e.target).parents(".custom-menu").length > 0) {
        
        // Hide it
        $(".custom-menu").hide(100);
    }
});


// If the menu element is clicked
$(".custom-menu li").click(function(){
var imagename = $(".active").find(".imagename").text();
    // This is the triggered action name
    switch($(this).attr("data-action")) {
        
        // A case for each action. Your actions here
        case "delete": if (confirm("Are you sure you want to delete \""+imagename+"\"?")) {
			var data = {};
    $.ajax({
		          dataType: "json",
          type: "POST",
          url: "/includes/console/scripts/ddcfinder/includes/deletefile.php?dir="+localStorage.getItem("ftpdirectory")+"&file="+imagename,
          data: data,
          success: function(resp) {
              if (resp.delete === true) {
getfiles("root");
			  }
          }
      });
  } else {
    return false;
  }
    }
  
    // Hide it AFTER the action was triggered
    $(".custom-menu").hide(100);
  });</script>';
}}



} 
?>