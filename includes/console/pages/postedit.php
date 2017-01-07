<?php
	$global = new DB_global;
	$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
if ($retrive->restrictpermissionlevel('2')){
echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to perform this action!</div></div>';
} else {
	if (!empty($_GET["postid"])){
		$editpost1 = $global->sqlquery("SELECT * FROM dd_content WHERE content_id = '".$_GET["postid"]."';");
		$editpost2 = $editpost1->fetch_assoc();
		define ('POSTPEND', 'Edit Post: '.$editpost2['content_title']);
	}
	if (!empty($_GET["draftid"])){
		$editpost1 = $global->sqlquery("SELECT * FROM dd_drafts WHERE draft_id = '".$_GET["draftid"]."';");
		$editpost2 = $editpost1->fetch_assoc();
		define ('POSTPEND', 'Edit Post: '.$editpost2['draft_title']);
	}
if ($retrive->restrictpermissionlevel('1') && $_COOKIE['userID'] !== $editpost2['content_author'] && !empty($_GET["postid"]) or $retrive->restrictpermissionlevel('1') && $_COOKIE['userID'] !== $editpost2['draft_author'] && !empty($_GET["draftid"])){
echo consolemenu();
echo '<div id="page"><div class="center">You are not authorized to perform this action!</div></div>';
} else { echo consolemenu();
echo '<div id="page"><div class="center">';
if (!empty($_GET["draftid"])){
echo 'Edit Draft';
$_SESSION['editid']['post'] = 'new';
} else if (empty($_GET["postid"])){
echo 'Create New Post';
$_SESSION['editid']['post'] = 'new';
	} else 
	{
echo 'Edit Post';
	}
echo '<form id="post" method="post">
<label title="posttitle"><b>Post title:</b></label>
<br /><input type="text" name="posttitle"';
if (!empty($_GET["postid"])){
	echo 'value="'.$editpost2['content_title'].'"';
}
if (!empty($_GET["draftid"])){
	echo 'value="'.$editpost2['draft_title'].'"';
}
echo '>';
echo '<br /><br /><label title="postmedialink"><b>Link to embeddable media:</b></label>
<br /><input type="text" name="postmedialink"';
if (!empty($_GET["postid"])){
	echo 'value="'.$editpost2['content_link'].'"';
}
if (!empty($_GET["draftid"])){
	echo 'value="'.$editpost2['draft_link'].'"';
}
echo '>';
echo '<br /><div class="smalltext">Accepted formats: Soundcloud, Bandcamp, YouTube, Vimeo, Dailymotion, Audiomack, Twitter, Facebook, Instagram, Vine, Mixcloud, Imgur, Reddit, Images (JPEG, PNG, GIF)</div>
<br /><label title="postcontent"><b>Post content:</b></label>
<br /><textarea  class="ckeditor" name="postcontent">';
if (!empty($_GET["postid"])){
	echo $editpost2['content_description'];
}
if (!empty($_GET["draftid"])){
	echo $editpost2['draft_description'];
}
echo'</textarea>';
echo'<input type="hidden" name="oneortheother">
<br /><label title="posttags"><b>Tags:</b></label>
<br /><input type="text" id="posttags" name="tags"';
if (!empty($_GET["postid"])){
	echo 'value="'.$editpost2['content_tags'].'"';
}
if (!empty($_GET["draftid"])){
	echo 'value="'.$editpost2['draft_tags'].'"';
}
echo '>';
echo'<br /><br /><label title="postcategory"><b>Category:</b></label>
<br /><select id="editcategory" name="category">';
	$result = $global->sqlquery("SELECT * FROM dd_categories;");
	while ($row = $result->fetch_array()){
	echo '<option value="'.$row['category_name'].'">'.$row['category_name'].'</option>';
	}
echo '</select>';
        echo '<div class="sitescrolling">';
		echo '<br><input type="checkbox" name="moderatecomments"';
if (isset($editpost2) && $editpost2['comments_moderated'] == '1')
{ echo' value="1" checked';}
else { echo ' value="0"';}echo '> Comments on this post are moderated.</div>';

if (!empty($_GET["postid"])){
	echo '<script>window.onload = function(){document.getElementById("editcategory").value = "'.$editpost2['content_category'].'";
	}</script>';
}
if (!empty($_GET["draftid"])){
	echo '<script>window.onload = function(){document.getElementById("editcategory").value = "'.$editpost2['draft_category'].'";
	}</script>';
}

pluginClass::hook( "post_form_bottom" );

if (!empty($_GET["postid"])){
$_SESSION['editid']['post'] = $_GET["postid"];
}
if (!empty($_GET["draftid"])){
$_SESSION['editid']['draft'] = $_GET["draftid"];
}
		echo '<script>$(';echo"'";echo'input[type="checkbox"]';echo"').change(function(){
    this.value = (Number(this.checked));
	});</script>";
echo '<br /><br /><input class="postsubmit" name="postsubmit" type="submit" value="Submit"></form>';
	if (empty($_GET["postid"]) or !empty($_GET["draftid"])){
echo '<br /><button class="postsubmit" onClick="savedraft()">Save Draft</button>';
	}
echo '</div>';
echo '<script>
    $("#posttags").autocomplete({
				serviceUrl: "livetagsearch",
        minChars: "1",
		delimiter: ","
    });
</script>';
echo "<script>function savedraft() {
      resetErrors();
	  var myinstances = [];
	  
//this is the foreach loop
for(var i in CKEDITOR.instances) {

   /* this  returns each instance as object try it with alert(CKEDITOR.instances[i]) */
    CKEDITOR.instances[i]; 
   
    /* this returns the names of the textareas/id of the instances. */
    CKEDITOR.instances[i].name;

    /* returns the initial value of the textarea */
    CKEDITOR.instances[i].value;  
 
   /* this updates the value of the textarea from the CK instances.. */
   CKEDITOR.instances[i].updateElement();

   /* this retrieve the data of each instances and store it into an associative array with
       the names of the textareas as keys... */
   myinstances[CKEDITOR.instances[i].name] = CKEDITOR.instances[i].getData(); 
CKEDITOR.instances[i].setReadOnly(true);
}
var data = new FormData($('#post')[0]);
      $.each($('form input, form select'), function(i, v) {
          if (v.type !== 'submit') {
              data[v.name] = v.value;
          }
	  }); $.each($('textarea'), function(i, v) {
          if (v.type !== 'submit') {
              data[v.name] = v.value;
          }
      }); //end each
      $.ajax({
		  beforeSend:function(resp){
		$('input, button, select, textarea').prop('disabled', true);
	  $('body').append('<div class=\"message\"><div class=\"successmessage\" style=\"background-color:#f0f0f0\">Please wait...</div></div>');
        /* Before serialize */
        for ( instance in CKEDITOR.instances ) {
            CKEDITOR.instances[instance].updateElement();
        }
        return true; 
    },
          dataType: 'json',
          type: 'POST',
          url: 'console/draft',
          data: data,
		  contentType: false,
			processData: false,
          success: function(resp) {
              if (resp.resprefresh === true) {
                  	//successful validation
					$('.successmessage').remove();
					$('body').append('<div class=\"message\"><div class=\"successmessage\">'+resp.message+'</div></div>')
					$('.successmessage').delay(5000).fadeOut('fast');
					window.setTimeout(function(){
					window.location.href = resp.url;
					}, 5000);
			  } else if (resp.resp === true) {
                  	//successful validation
					$('input, button, select, textarea').prop('disabled', false);
				  				  	  for(var i in CKEDITOR.instances) {
	CKEDITOR.instances[i].setReadOnly(false);
}
					$('.successmessage').remove();
					$('body').append('<div class=\"message\"><div class=\"successmessage\">'+resp.message+'</div></div>')
					$('.successmessage').delay(5000).fadeOut('fast');
			  } else {
                  $.each(resp, function(i, v) {
	        console.log(i + ' => ' + v); // view in console for error messages
                      var msg = '<div class=";echo'"break"'
					  ; echo"></div><label class=";echo '"error"'; echo " for=\"'+i+'\">'+v+'</label>';
                      $('input[name=\"' + i + '\"], select[name=\"' + i + '\"], textarea[name=\"' + i + '\"]').addClass('inputTxtError').after(msg);
                  });
                  var keys = Object.keys(resp);
                  $('input[name=\"'+keys[0]+'\"]').focus();
				  				  	  for(var i in CKEDITOR.instances) {
	CKEDITOR.instances[i].setReadOnly(false);
}
$('input, button, select, textarea').prop('disabled', false);
	  $('.successmessage').remove();
              }
          },
          error: function(xhr, status, error) {
			  var err = eval('(' + xhr.responseText + ')');
              console.log(err.Message);
          }
      });
      return false;
  };
</script>";}}}else {
	header('Location: https://'.$_SERVER['HTTP_HOST'].'/console');
}
?>
