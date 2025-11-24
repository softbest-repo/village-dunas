<?php
	include('../../f/conf/config.php');

	$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/comissoesAnexo/';
	
	$codAgrupadorComissao = $_POST['codAgrupadorComissao'];
	$corretor = $_POST['corretor'];
								
	foreach ($_FILES['arquivo']['tmp_name'] as $index => $tmp_name) {

		if (!is_uploaded_file($tmp_name)) {
			continue;
		}
				  
		$file_name = $_FILES['arquivo']['name'][$index];
		$file_type = $_FILES['arquivo']['type'][$index];
		$file_size = $_FILES['arquivo']['size'][$index];

		$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
  							
		$sqlComissao = "INSERT INTO comissoesAnexos VALUES(0, ".$codAgrupadorComissao.", ".$_POST['corretor'].", '".$file_name."', '".$ext."')";
		$resultComissao = $conn->query($sqlComissao);	

		$sqlPegaComissao = "SELECT codComissaoAnexo FROM comissoesAnexos ORDER BY codComissaoAnexo DESC LIMIT 0,1";
		$resultPegaComissao = $conn->query($sqlPegaComissao);
		$dadosPegaComissao = $resultPegaComissao->fetch_assoc();
					
		$codComissaoAnexo = $dadosPegaComissao['codComissaoAnexo'];
			
		move_uploaded_file($tmp_name, $pastaDestino.$codAgrupadorComissao."-".$codComissaoAnexo."-O.".$ext);
						
		chmod($pastaDestino.$codAgrupadorComissao."-".$codComissaoAnexo."-O.".$ext, 0755);
			
	}

	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."financeiro/comissoes/gerenciar-documentos/".$codAgrupadorComissao."/'>";		
?>
