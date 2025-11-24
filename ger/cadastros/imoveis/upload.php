<?php
	session_start();

	include('../../f/conf/config.php');

	require '../../../vendor/autoload.php';

	use Intervention\Image\ImageManagerStatic as Image;

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'] . $urlUpload . '/f/imoveis/';

	$codImovel = $_POST['codImovel'];

	function saveWebPImage($original_image, $new_image_path, $quality = 100)
	{
		return imagewebp($original_image, $new_image_path, $quality);
	}


	function applyWatermark($imagePath, $watermark, $ratio)
	{
		$image = imagecreatefromstring(file_get_contents($imagePath));
		$width = imagesx($image);
		$height = imagesy($image);

		$watermarkRatio = $ratio;
		$watermarkWidth = imagesx($watermark) * $watermarkRatio;
		$watermarkHeight = imagesy($watermark) * $watermarkRatio;

		$watermarkResized = imagecreatetruecolor($watermarkWidth, $watermarkHeight);
		imagealphablending($watermarkResized, false);
		imagesavealpha($watermarkResized, true);
		imagecopyresampled($watermarkResized, $watermark, 0, 0, 0, 0, $watermarkWidth, $watermarkHeight, imagesx($watermark), imagesy($watermark));

		$destX = ($width - $watermarkWidth) / 2;
		$destY = ($height - $watermarkHeight) / 2;

		imagecopy($image, $watermarkResized, $destX, $destY, 0, 0, $watermarkWidth, $watermarkHeight);

		imagejpeg($image, $imagePath, 100);

		imagedestroy($image);
		imagedestroy($watermarkResized);
	}
					
	foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmp_name) {

		if (!is_uploaded_file($tmp_name)) {
			continue;
		}

		$file_name = $_FILES['arquivo']['name'][$index];
		$file_type = $_FILES['arquivo']['type'][$index];
		$file_size = $_FILES['arquivo']['size'][$index];

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

		if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'mp4'])) {

			$file_name = uniqid() . '.' . $ext;

			$sqlCont = "SELECT * FROM imoveisImagens WHERE codImovel = " . $codImovel . " ORDER BY ordenacaoImovelImagem DESC LIMIT 0,1";
			$resultCont = $conn->query($sqlCont);
			$dadosCont = $resultCont->fetch_assoc();

			$cont = ($dadosCont['codImovelImagem'] == "") ? 1 : $dadosCont['ordenacaoImovelImagem'] + 1;

			$sqlImovel = "INSERT INTO imoveisImagens VALUES(0, " . $codImovel . ", " . $cont . ", '" . $ext . "')";
			$conn->query($sqlImovel);

			$sqlPegaImovel = "SELECT codImovelImagem FROM imoveisImagens ORDER BY codImovelImagem DESC LIMIT 0,1";
			$resultPegaImovel = $conn->query($sqlPegaImovel);
			$dadosPegaImovel = $resultPegaImovel->fetch_assoc();

			$codImovelImagem = $dadosPegaImovel['codImovelImagem'];

			$originalPath = $pastaDestino . $codImovel . "-" . $codImovelImagem . "-O." . $ext;
			$ocPath = $pastaDestino . $codImovel . "-" . $codImovelImagem . "-OC." . $ext;

			move_uploaded_file($tmp_name, $originalPath);
			copy($originalPath, $ocPath);

			chmod($originalPath, 0755);
			chmod($ocPath, 0755);

			if ($ext != "mp4") {

				$imagemPreparada = Image::make($originalPath);
				$width = $imagemPreparada->width();
				$height = $imagemPreparada->height();

				if ($width >= 1200 && $height >= 900) {
					$imagemPreparada->fit(1200, 900)->save($originalPath);
					$liberado = "ok";
				} elseif ($width >= 800 && $height >= 600) {
					$imagemPreparada->fit(800, 600)->save($originalPath);
					$liberado = "ok";
				} elseif ($width >= 600 && $height >= 450) {
					$imagemPreparada->fit(600, 450)->save($originalPath);
					$liberado = "ok";
				} else {
					$liberado = "nao";
				}

				if ($liberado == "ok") {

					$watermarkPath = "marca.png";
					$watermark = imagecreatefrompng($watermarkPath);
					imagealphablending($watermark, true);
					imagesavealpha($watermark, true);

					$imagemWebPOc = $pastaDestino . $codImovel . "-" . $codImovelImagem . "-WOC.webp";
					$newImageOc = imagecreatefromstring(file_get_contents($ocPath));
					saveWebPImage($newImageOc, $imagemWebPOc, 95);

					// Aplicar marca d'água na OC sem redimensionar
					applyWatermark($imagemWebPOc, $watermark, 0.50);

					// Criar a versão WEBP
					$imagemWebP = $pastaDestino . $codImovel . "-" . $codImovelImagem . "-W.webp";
					$newImage = imagecreatefromstring(file_get_contents($originalPath));
					saveWebPImage($newImage, $imagemWebP, 95);

					applyWatermark($imagemWebP, $watermark, 0.25);
					
					imagedestroy($newImage);

					chmod($originalPath, 0755);
					chmod($imagemWebP, 0755);
				} else {
					$sqlDelete = "DELETE FROM imoveisImagens WHERE codImovelImagem = " . $codImovelImagem;
					$conn->query($sqlDelete);
					unlink($originalPath);
					$erroTamanho = "sim";
				}
			}
		} else {
			$erroExtensao = "sim";
		}
	}

	if ($erroTamanho == "sim") {
		$_SESSION['erroTamanho'] = "<p class='erro'>Uma ou mais imagens são muito pequenas e por isso não foram cadastradas!</p>";
	}

	if ($erroExtensao == "sim") {
		$_SESSION['erroExtensao'] = "<p class='erro'>Uma ou mais imagens não possuem extensão permitida para cadastro!</p>";
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=" . $configUrl . "cadastros/imoveis/imagens/" . $codImovel . "/'>";
?>
