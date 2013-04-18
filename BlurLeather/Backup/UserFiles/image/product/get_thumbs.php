<?php
	if ( isset($_GET['width']) )
		$thumb_width  = $_GET['width'];
	else
		$thumb_width  = 100;
	if ( isset($_GET['height']) )
		$thumb_height = $_GET['height'];
	else
		$thumb_height = 100;
	if ( isset($_GET['im']) ) { $im   = $_GET['im'];   } else { $im   = ''; }

	header("Content-type: image/jpeg");
	$what = getimagesize($im);
	switch( $what['mime'] ){
		case 'image/png' : $orig_image = imagecreatefrompng($im);break;
		case 'image/jpeg': $orig_image = imagecreatefromjpeg($im);break;
		case 'image/gif' : $orig_image = imagecreatefromgif($im);
	}

	list($width, $height, $type, $attr) = getimagesize($im);

	$ratioW = $width / $thumb_width;
	$ratioH = $height / $thumb_height;

	$ratioU = ($ratioW > $ratioH) ? $ratioW:$ratioH;

	$newWidth = $width / $ratioU;
	$newHeight = $height / $ratioU;

	$sm_image = imagecreatetruecolor($newWidth, $newHeight) or die ("Cannot Initialize new gd image stream");
	imagecopyresampled($sm_image, $orig_image, 0, 0, 0, 0, $newWidth, $newHeight, imagesx($orig_image), imagesy($orig_image));
	imagejpeg($sm_image);

	imagedestroy($sm_image);
	imagedestroy($orig_image);
?>
