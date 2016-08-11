<?php
	$global = new DB_global;
	$retrive = new DB_retrival;
if ($retrive->isLoggedIn() == true){
		$editcomment1 = $global->sqlquery("SELECT * FROM dd_comments WHERE comment_id = '".$_GET["commentid"]."';");
		$editcomment2 = $editcomment1->fetch_assoc();
		
echo consolemenu();
echo '<div id="page"><div class="center">Edit Comment';
echo '<form id="editcomment" method="post">
<label title="commentname"><b>Name:</b></label>
<br /><input type="text" name="commentname" value="'.$editcomment2['comment_username'].'">
<br /><br /><label title="commentemail"><b>Email:</b></label>
<br /><input type="text" name="commentemail" value="'.$editcomment2['comment_email'].'" >
<br /><br /><label title="commentcontent"><b>Comment content:</b></label>
<br /><textarea id="comment" name="commentcontent">';
	echo $editcomment2['comment_content'];
echo'</textarea>
<input type="hidden" name="commentid" value="'.$_GET['commentid'].'">
<br /><br /><input class="postsubmit" name="commenteditsubmit" type="submit" value="Submit">';
echo '</form>';
echo '</div>';
echo "<script>    CKEDITOR.replace( 'comment', {
    toolbar: [
    { name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Cut', 'Copy', 'Paste', '-', 'Undo', 'Redo' ] },
    { name: 'editing', groups: [ 'find', 'selection', 'spellchecker' ], items: [ 'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt' ] },
    { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', 'Strike' ] },
]
});
</script>";
} else {
	header('Location: '.$_SERVER['HTTP_HOST'].'/console');
}
?>