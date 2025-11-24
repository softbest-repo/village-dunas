<?php
	if( $_SERVER['REQUEST_METHOD'] == 'POST'){
		
		$filename = $_POST['img'];
    
		$ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));

		switch ($ext) {
			case 'jpg':
			case 'jpeg':
			$original_image = imagecreatefromjpeg($filename);
			break;
			case 'png':
			$original_image = imagecreatefrompng($filename);
			break;
			case 'gif':
			$original_image = imagecreatefromgif($filename);
			break;
		}

		$img_width = imagesx($original_image);
		$img_height = imagesy($original_image);

		$width = $_POST['w'];
		$height = $_POST['h'];
		$x = $_POST['x'];
		$y = $_POST['y'];

		$cropped = imagecreatetruecolor($width, $height);

		imagecopy($cropped, $original_image, 0, 0, $x, $y, $width, $height);

		switch ($ext) {
			case 'jpg':
			case 'jpeg':
			imagejpeg($cropped, $filename, 100);
			break;
			case 'png':
			imagepng($cropped, $filename);
			break;
			case 'gif':
			imagegif($cropped, $filename);
			break;
		}

		imagedestroy($original_image);
		imagedestroy($cropped);
		
		exit;

	}
