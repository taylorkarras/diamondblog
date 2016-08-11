<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/console/includes/external/class-php-ico.php');
if (isset($_POST)){
$imageFileType = pathinfo($_FILES["favicon"]["name"],PATHINFO_EXTENSION);
	if (empty($_FILES['favicon']['name'])){
		echo '<span class="error">Please select a file to upload!</span>';
        exit;		
	} else if ($_FILES["favicon"]["size"] > 500000) {
    echo '<span class="error">Your image is too large!</span>';
        exit;
	} else if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo '<span class="error">Only JPG, JPEG, PNG & GIF files are allowed to be used as an icon.</span>';
        exit;
} else if (getimagesize($_FILES["favicon"]["tmp_name"]) == false){
		echo '<span class="error">Error, file is not an image!</span>';
        exit;
} else if($imageFileType == "png") {
	$image = imagecreatefrompng($_FILES["favicon"]["tmp_name"]);
} else if($imageFileType == "jpg" or $imageFileType == "jpeg" or $imageFileType == "gif" or $imageFileType == "bmp"){
	$image = imagecreatefromjpeg($_FILES["favicon"]["tmp_name"]);
} else if($imageFileType == "gif"){
	$image = imagecreatefromgif($_FILES["favicon"]["tmp_name"]);
}
		list($width, $height) = getimagesize($_FILES["favicon"]["tmp_name"]);
		$image_310px = imagecreatetruecolor('310', '310');
		$image_192px = imagecreatetruecolor('192', '192');
		$image_152px = imagecreatetruecolor('152', '152');
		$image_120px = imagecreatetruecolor('120', '120');
		$image_96px = imagecreatetruecolor('96', '96');
		$image_76px = imagecreatetruecolor('76', '76');
		$image_57px = imagecreatetruecolor('57', '57');
		$image_48px = imagecreatetruecolor('48', '48');
		$image_36px = imagecreatetruecolor('36', '36');
		$image_32px = imagecreatetruecolor('32', '32');
		$image_16px = imagecreatetruecolor('16', '16');
			imageAlphaBlending($image_310px, false);
imageSaveAlpha($image_310px, true);
			imageAlphaBlending($image_192px, false);
imageSaveAlpha($image_192px, true);
			imageAlphaBlending($image_152px, false);
imageSaveAlpha($image_152px, true);
			imageAlphaBlending($image_120px, false);
imageSaveAlpha($image_120px, true);
			imageAlphaBlending($image_96px, false);
imageSaveAlpha($image_96px, true);
			imageAlphaBlending($image_76px, false);
imageSaveAlpha($image_76px, true);
			imageAlphaBlending($image_57px, false);
imageSaveAlpha($image_57px, true);
			imageAlphaBlending($image_48px, false);
imageSaveAlpha($image_48px, true);
			imageAlphaBlending($image_36px, false);
imageSaveAlpha($image_36px, true);
			imageAlphaBlending($image_32px, false);
imageSaveAlpha($image_32px, true);
			imageAlphaBlending($image_16px, false);
imageSaveAlpha($image_16px, true);

		 $transparent_310px = imagecolorallocatealpha($image_310px, 255, 255, 255, 127);
		 $transparent_192px = imagecolorallocatealpha($image_192px, 255, 255, 255, 127);
		 $transparent_152px = imagecolorallocatealpha($image_152px, 255, 255, 255, 127);
		 $transparent_120px = imagecolorallocatealpha($image_120px, 255, 255, 255, 127);
		 $transparent_96px = imagecolorallocatealpha($image_96px, 255, 255, 255, 127);
		 $transparent_76px = imagecolorallocatealpha($image_76px, 255, 255, 255, 127);
		 $transparent_57px = imagecolorallocatealpha($image_57px, 255, 255, 255, 127);
		 $transparent_48px = imagecolorallocatealpha($image_48px, 255, 255, 255, 127);
		 $transparent_36px = imagecolorallocatealpha($image_36px, 255, 255, 255, 127);
		 $transparent_32px = imagecolorallocatealpha($image_32px, 255, 255, 255, 127);
		 $transparent_16px = imagecolorallocatealpha($image_16px, 255, 255, 255, 127);
		  imagefilledrectangle($image_310px, 0, 0, 310, 310, $transparent_310px);
		  imagefilledrectangle($image_192px, 0, 0, 192, 192, $transparent_192px);
		  imagefilledrectangle($image_152px, 0, 0, 152, 152, $transparent_152px);
		  imagefilledrectangle($image_96px, 0, 0, 96, 96, $transparent_96px);
		  imagefilledrectangle($image_76px, 0, 0, 76, 76, $transparent_76px);
		  imagefilledrectangle($image_57px, 0, 0, 57, 57, $transparent_57px);
		  imagefilledrectangle($image_48px, 0, 0, 48, 48, $transparent_48px);
		  imagefilledrectangle($image_36px, 0, 0, 36, 36, $transparent_36px);
		  imagefilledrectangle($image_32px, 0, 0, 32, 32, $transparent_32px);
		  imagefilledrectangle($image_16px, 0, 0, 16, 16, $transparent_16px);
		imagecopyresampled($image_310px, $image, 0, 0, 0, 0, '310', '310', $width, $height);
		imagecopyresampled($image_192px, $image, 0, 0, 0, 0, '192', '192', $width, $height);
		imagecopyresampled($image_152px, $image, 0, 0, 0, 0, '152', '152', $width, $height);
		imagecopyresampled($image_120px, $image, 0, 0, 0, 0, '120', '120', $width, $height);
		imagecopyresampled($image_96px, $image, 0, 0, 0, 0, '96', '96', $width, $height);
		imagecopyresampled($image_76px, $image, 0, 0, 0, 0, '76', '76', $width, $height);
		imagecopyresampled($image_57px, $image, 0, 0, 0, 0, '57', '57', $width, $height);
		imagecopyresampled($image_48px, $image, 0, 0, 0, 0, '48', '48', $width, $height);
		imagecopyresampled($image_36px, $image, 0, 0, 0, 0, '36', '36', $width, $height);
		imagecopyresampled($image_32px, $image, 0, 0, 0, 0, '32', '32', $width, $height);
		imagecopyresampled($image_16px, $image, 0, 0, 0, 0, '16', '16', $width, $height);
		imagepng($image_310px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-310px.png', 0, PNG_NO_FILTER);
		imagepng($image_192px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-192px.png', 0, PNG_NO_FILTER);
		imagepng($image_152px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-152px.png', 0, PNG_NO_FILTER);
		imagepng($image_120px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-120px.png', 0, PNG_NO_FILTER);
		imagepng($image_96px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-96px.png', 0, PNG_NO_FILTER);
		imagepng($image_76px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-76px.png', 0, PNG_NO_FILTER);
		imagepng($image_57px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-57px.png', 0, PNG_NO_FILTER);
		imagepng($image_48px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-48px.png', 0, PNG_NO_FILTER);
		imagepng($image_36px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-36px.png', 0, PNG_NO_FILTER);
		imagepng($image_32px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-32px.png', 0, PNG_NO_FILTER);
		imagepng($image_16px, $_SERVER['DOCUMENT_ROOT'].'/images/favicon-16px.png', 0, PNG_NO_FILTER);
		$ico_lib = new PHP_ICO( $_FILES["favicon"]["tmp_name"] );
		$ico_lib->save_ico($_SERVER['DOCUMENT_ROOT'].'/favicon.ico');
		echo "Icon uploaded!";
		exit;
		}