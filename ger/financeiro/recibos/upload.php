<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/recibosAnexo/';
	
	$codRecibo = $_POST['codRecibo'];
					
	foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmp_name) {

		if (!is_uploaded_file($tmp_name)) {
			continue;
		}
		  
		$file_name = $_FILES['arquivo']['name'][$index];
		$file_type = $_FILES['arquivo']['type'][$index];
		$file_size = $_FILES['arquivo']['size'][$index];

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  										
		$sqlRecibo = "INSERT INTO recibosAnexos VALUES(0, ".$codRecibo.", '".$file_name."', '".$ext."')";
		$resultRecibo = $conn->query($sqlRecibo);	

		$sqlPegaRecibo = "SELECT codReciboAnexo FROM recibosAnexos ORDER BY codReciboAnexo DESC LIMIT 0,1";
		$resultPegaRecibo = $conn->query($sqlPegaRecibo);
		$dadosPegaRecibo = $resultPegaRecibo->fetch_assoc();
					
		$codReciboAnexo = $dadosPegaRecibo['codReciboAnexo'];
			
		move_uploaded_file($tmp_name, $pastaDestino.$codRecibo."-".$codReciboAnexo."-O.".$ext);
						
		chmod($pastaDestino.$codRecibo."-".$codReciboAnexo."-O.".$ext, 0755);

	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."financeiro/recibos/gerenciar-documentos/".$codRecibo."/'>";		
?>
