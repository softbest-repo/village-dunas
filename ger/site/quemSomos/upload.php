<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/quemSomos/';
	
	$codQuemSomos = $_POST['codQuemSomos'];

	function saveWebPImage($original_image, $new_image_path, $quality = 100) {
		if (imagewebp($original_image, $new_image_path, $quality)) {
			return true;
		} else {
			return false;
		}
	}
									
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
  
		if(in_array($ext, ['jpg', 'jpeg', 'png', 'svg'])){	
			
			$file_name = uniqid().'.'.$ext;							
				
			$sqlQuemSomos = "INSERT INTO quemSomosImagens VALUES(0, ".$codQuemSomos.", 'F', '".$ext."')";
			$resultQuemSomos = $conn->query($sqlQuemSomos);	

			$sqlPegaQuemSomos = "SELECT codQuemSomosImagem FROM quemSomosImagens ORDER BY codQuemSomosImagem DESC LIMIT 0,1";
			$resultPegaQuemSomos = $conn->query($sqlPegaQuemSomos);
			$dadosPegaQuemSomos = $resultPegaQuemSomos->fetch_assoc();
						
			$codQuemSomosImagem = $dadosPegaQuemSomos['codQuemSomosImagem'];
				
			move_uploaded_file($tmp_name, $pastaDestino.$codQuemSomos."-".$codQuemSomosImagem."-O.".$ext);
							
			chmod($pastaDestino.$codQuemSomos."-".$codQuemSomosImagem."-O.".$ext, 0755);
			
			if($ext != "svg"){
							   
				$imagemWebP = $pastaDestino.$codQuemSomos."-".$codQuemSomosImagem."-W.webp";

				switch ($ext) {
					case 'jpg':
					case 'jpeg':
					$original_image = imagecreatefromjpeg($pastaDestino.$codQuemSomos."-".$codQuemSomosImagem."-O.".$ext);
					break;
					case 'png':
					$original_image = imagecreatefrompng($pastaDestino.$codQuemSomos."-".$codQuemSomosImagem."-O.".$ext);
					break;
					case 'gif':
					$original_image = imagecreatefromgif($pastaDestino.$codQuemSomos."-".$codQuemSomosImagem."-O.".$ext);
					break;
				}

				saveWebPImage($original_image, $imagemWebP, 95);
				imagedestroy($original_image);

				chmod($pastaDestino.$codQuemSomos."-".$codQuemSomosImagem."-W.webp", 0755);								
			}

		}else{
			$erroExt = "erro";
		}
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."site/quemSomos/imagens/".$codQuemSomos."/'>";		
?>
