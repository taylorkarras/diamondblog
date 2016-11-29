<head>
<!DOCTYPE html>
<title>DiamondBlog Setup</title>
<script src="https://<?php echo $_SERVER['HTTP_HOST']; ?>/includes/console/scripts/jquery-2.2.3.min.js"></script>
<link rel="stylesheet" href="./style.css">
</head>
<body>
<h1 style="text-align:center">DiamondBlog Setup</h1>
<?php
echo '<div id="setup">
Thank you for chosing DiamondBlog, off all the blog CMSes you could chose, we are glad you chose the most risque. Here are the following things you get form installing DiamondBlog.
<br \\>
<br \\><li><b>No clutter.</b> Do not clutter up your website with a sidebar, get your content from one single page without all the clutter.</li>
<li><b>Ultimate design.</b> Design the blog the way you want it to be with extensive theming endpoints and extensive design language.</li>
<li><b>Ultimate speed.</b> Don\'t be bound by something that pretends to be a CMS or does too much for what you need, get the speed you need; even on a 96MB RAM server.</li>
<li><b>Future-proof.</b> RSS 2.0, Accelerated Mobile Project, Auto Scrolling; whatever you need, it\'s all here.</li>
<li><b>Need we say more?</b></li>

<br \\>Finish this quick instalation process to get started.
</div>
<form id="setup2" method="post">
<label for="sqlserver">SQL Server</label>
<br \\><input type="text" name="sqlserver">
<br \\><br \\><label for="sqldatabase">SQL Database</label>
<br \\><input type="text" name="sqldatabase">
<br \\><br \\><label for="sqlusername">SQL Username</label>
<br \\><input type="text" name="sqlusername">
<br \\><br \\><label for="sqlpassword">SQL Password</label>
<br \\><input type="password" name="sqlpassword">
<br \\><br \\><label for="sitename">Site Name</label>
<br \\><input type="text" name="sitename">
<br \\><br \\><label for="sitetitle">Site Title</label>
<br \\><input type="text" name="sitetitle">
<br \\><br \\><label for="siteurl">Site URL</label>
<br \\><input type="text" name="siteurl">
<br \\><br \\><label type="text" name="metadescription">Site Meta Description</label>
<div class="smalltext">200 character max.</div>
<br \\><textarea class="metadescription" name="metadescription" maxlength="200"></textarea>
<br \\><br \\><label for="adminemail">Admin Email</label>
<br \\><input type="text" name="adminemail">
<br \\><br \\><label for="password">Password</label>
<br \\><small>Below is your generated password that\'ll be activated upon registration, please keep it in a safe place.</small>
<br \\><br \\>';

	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, 12);
	echo '"'.$password.'"<input type="hidden" name="adminpassword" value="'.$password.'">';
	
echo'<br \\><br \\><input type="submit" name="setupsubmit" value="Finish Setup"></form>';

echo'<script>var data = {};
$(\'body\').on(\'click\', \'input[type="submit"]\', function() {
      resetErrors();
	  var myinstances = [];

      $.each($(\'form input, form select\'), function(i, v) {
          if (v.type !== \'submit\') {
              data[v.name] = v.value;
          }
	  }); $.each($(\'textarea\'), function(i, v) {
          if (v.type !== \'submit\') {
              data[v.name] = v.value;
          }
      }); //end each
      $.ajax({
          dataType: \'json\',
          type: \'POST\',
          url: \'setup.php\',
          data: data,
          success: function(resp) {
              if (resp.resprefresh === true) {
                  	//successful validation
					$(\'body\').append(\'<div class="successmessage">\'+resp.message+\'</div>\')
					$(\'.successmessage\').delay(5000).fadeOut(\'fast\');
					window.setTimeout(function(){
					window.location.href = resp.url;
					}, 5000);
			  } else {
                  $.each(resp, function(i, v) {
	        console.log(i + " => " + v); // view in console for error messages
                      var msg = \'<div class="break"></div><label class="error" for="\'+i+\'">\'+v+\'</label>\';
                      $(\'input[name="\' + i + \'"], select[name="\' + i + \'"], textarea[name="\' + i + \'"]\').addClass(\'inputTxtError\').after(msg);
                  });
                  var keys = Object.keys(resp);
                  $(\'input[name="\'+keys[0]+\'"]\').focus();
              }
          },
          error: function(xhr, status, error) {
			  var err = eval("(" + xhr.responseText + ")");
              console.log(err.Message);
          }
      });
      return false;
  });;
function resetErrors() {
    $(\'form input, form select, textarea\').removeClass(\'inputTxtError\');
    $(\'label.error\').remove();
}
</script>';
	?>
</body>
