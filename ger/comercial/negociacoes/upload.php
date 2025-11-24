<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/negociacoesAnexo/';
	
	$codNegociacao = $_POST['codNegociacao'];
					
	foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmp_name) {

		if (!is_uploaded_file($tmp_name)) {
			continue;
		}
		  
		$file_name = $_FILES['arquivo']['name'][$index];
		$file_type = $_FILES['arquivo']['type'][$index];
		$file_size = $_FILES['arquivo']['size'][$index];

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  										
		$sqlNegociacao = "INSERT INTO negociacoesAnexos VALUES(0, ".$codNegociacao.", ".$_COOKIE['codAprovado'.$cookie].", '".date('Y-m-d')."', '".$file_name."', '".$ext."')";
		$resultNegociacao = $conn->query($sqlNegociacao);	

		$sqlPegaNegociacao = "SELECT codNegociacaoAnexo FROM negociacoesAnexos ORDER BY codNegociacaoAnexo DESC LIMIT 0,1";
		$resultPegaNegociacao = $conn->query($sqlPegaNegociacao);
		$dadosPegaNegociacao = $resultPegaNegociacao->fetch_assoc();
					
		$codNegociacaoAnexo = $dadosPegaNegociacao['codNegociacaoAnexo'];
			
		move_uploaded_file($tmp_name, $pastaDestino.$codNegociacao."-".$codNegociacaoAnexo."-O.".$ext);
						
		chmod($pastaDestino.$codNegociacao."-".$codNegociacaoAnexo."-O.".$ext, 0755);

	}
?>
