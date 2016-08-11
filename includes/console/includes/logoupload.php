<?php
if (isset($_POST)){
$imageFileType = pathinfo($_FILES["logo"]["name"],PATHINFO_EXTENSION);
	if (empty($_FILES['logo']['name'])){
		echo '<span class="error">Please select a file to upload!</span>';
        exit;		
	} else if ($_FILES["logo"]["size"] > 500000) {
    echo '<span class="error">Your image is too large!</span>';
        exit;
	} else if($imageFileType != "png") {
    echo '<span class="error">Only PNG files are allowed to be used as a logo.</span>';
        exit;
} else if (getimagesize($_FILES["logo"]["tmp_name"]) == false){
		echo '<span class="error">Error, file is not an image!</span>';
        exit;
} else if($imageFileType == "png") {
	move_uploaded_file($_FILES["logo"]["tmp_name"], $_SERVER['DOCUMENT_ROOT'].'/images/logo.png');
	echo "Logo uploaded!";
	exit;
}
}