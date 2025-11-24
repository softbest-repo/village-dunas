<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/imoveisAnexo/';
	
	$codImovel = $_POST['codImovel'];
								
	foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmp_name) {

		if (!is_uploaded_file($tmp_name)) {
			continue;
		}
		  
		$file_name = $_FILES['arquivo']['name'][$index];
		$file_type = $_FILES['arquivo']['type'][$index];
		$file_size = $_FILES['arquivo']['size'][$index];

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  						
		$sqlImovel = "INSERT INTO imoveisAnexos VALUES(0, ".$codImovel.", '".$file_name."', '".$ext."')";
		$resultImovel = $conn->query($sqlImovel);	

		$sqlPegaImovel = "SELECT codImovelAnexo FROM imoveisAnexos ORDER BY codImovelAnexo DESC LIMIT 0,1";
		$resultPegaImovel = $conn->query($sqlPegaImovel);
		$dadosPegaImovel = $resultPegaImovel->fetch_assoc();
					
		$codImovelAnexo = $dadosPegaImovel['codImovelAnexo'];
			
		move_uploaded_file($tmp_name, $pastaDestino.$codImovel."-".$codImovelAnexo."-O.".$ext);
						
		chmod($pastaDestino.$codImovel."-".$codImovelAnexo."-O.".$ext, 0755);					   
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."cadastros/imoveis/anexos/".$codImovel."/'>";		
?>
