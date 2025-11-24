<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/balnearioGaivota/';
	
	$codBalnearioGaivota = $_POST['codBalnearioGaivota'];

	$sizes = [
		['width' => 200, 'height' => 150, 'tamanho' => 'P'],
		['width' => 400, 'height' => 300, 'tamanho' => 'M'],
		['width' => 800, 'height' => 600, 'tamanho' => 'G'],
	];
								
	foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmp_name) {

		if (!is_uploaded_file($tmp_name)) {
			continue;
		}
		  
		$file_name = $_FILES['arquivo']['name'][$index];
		$file_type = $_FILES['arquivo']['type'][$index];
		$file_size = $_FILES['arquivo']['size'][$index];

		if (strpos($file_type, 'image') === false) {
			continue;
		}

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  
		if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])){	
			
			$file_name = uniqid().'.'.$ext;							
				
			$sqlBalnearioGaivota = "INSERT INTO balnearioGaivotaImagens VALUES(0, ".$codBalnearioGaivota.", 'I', 'F', '".$ext."')";
			$resultBalnearioGaivota = $conn->query($sqlBalnearioGaivota);	

			$sqlPegaBalnearioGaivota = "SELECT codBalnearioGaivotaImagem FROM balnearioGaivotaImagens ORDER BY codBalnearioGaivotaImagem DESC LIMIT 0,1";
			$resultPegaBalnearioGaivota = $conn->query($sqlPegaBalnearioGaivota);
			$dadosPegaBalnearioGaivota = $resultPegaBalnearioGaivota->fetch_assoc();
						
			$codBalnearioGaivotaImagem = $dadosPegaBalnearioGaivota['codBalnearioGaivotaImagem'];
				
			move_uploaded_file($tmp_name, $pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);
							
			chmod($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext, 0755);
							   
			foreach ($sizes as $size) {
				list($width, $height) = getimagesize($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);

				$ratio = $width / $height;
				$new_width = $size['width'];
				$new_height = $new_width / $ratio;
				$tamanho = $size['tamanho'];

				$new_image = imagecreatetruecolor($new_width, $new_height);

				switch ($ext) {
					case 'jpg':
					case 'jpeg':
					$original_image = imagecreatefromjpeg($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);
					break;
					case 'png':
					$original_image = imagecreatefrompng($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);
					break;
					case 'gif':
					$original_image = imagecreatefromgif($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);
					break;
				}

				imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

				switch ($ext) {
					case 'jpg':
					case 'jpeg':
					imagejpeg($new_image, $pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-".$tamanho.".".$ext, 100);
					break;
					case 'png':
					imagepng($new_image, $pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-".$tamanho.".".$ext);
					break;
					case 'gif':
					imagegif($new_image, $pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-".$tamanho.".".$ext);
					break;
				}

				imagedestroy($new_image);

				chmod($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-P.".$ext, 0755);
				chmod($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-M.".$ext, 0755);
				chmod($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-G.".$ext, 0755);								
			}

		}else{
			$erroExt = "erro";
		}
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."site/balnearioGaivota/imagens/".$codBalnearioGaivota."/'>";		
?>
