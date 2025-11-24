<?php
	ob_start();
	session_start();
	
	include('../../f/conf/config.php');

	$nomeCliente = $_POST['nomeCliente'];
	$codTipoPagamento = $_POST['codTipoPagamento'];
	$codUsuario = $_POST['codUsuario'];
	$tipoCliente = $_POST['tipoCliente'];
	$tipoImovel = $_POST['tipoImovel'];
	$fPrecoD = $_POST['fPrecoD'];
	$fPrecoA = $_POST['fPrecoA'];
	$resultado = $_POST['resultado'];
	$fechamento = $_POST['fechamento'];
	$midia = $_POST['midia'];
	$codTipoCompromisso = $_POST['codTipoCompromisso'];
	$data = $_POST['data'];
	$hora = $_POST['hora'];
	$descricaoCompromisso = $_POST['descricaoCompromisso'];
	$telefone = $_POST['telefone'];
	$estado = $_POST['estado'];
	$cidade = $_POST['cidade'];
	$descricao = $_POST['descricao'];
	
	$insert = "INSERT INTO negociacoes VALUES(0, '".$codTipoPagamento."', '".$codUsuario."', '".$estado."', '".$cidade."', ".$_COOKIE['codAprovado'.$cookie].", '".$tipoImovel."', '".$nomeCliente."', '".date("Y-m-d")."', '".date("Y-m-d")."', '".date("Y-m-d")."', '".date("H-i-s")."', '".$telefone."', '".$tipoCliente."', '".$fPrecoD."', '".$fPrecoA."', '".$resultado."', '".$fechamento."', '', '', '".$descricao."', '".$midia."', 'T') ";
	$result = $conn->query($insert);
	
	$sqlCodNegociacao = "SELECT codNegociacao FROM negociacoes ORDER BY codNegociacao DESC LIMIT 0,1";
	$resultCodNegociacao = $conn->query($sqlCodNegociacao);
	$dadosCodNegociacao = $resultCodNegociacao->fetch_assoc();

	$numeroProcessado = str_replace(["(", ")", "-", " "], "", $telefone);

	if (strlen($numeroProcessado) == 11 && substr($numeroProcessado, 2, 1) == "9") {
		$numeroProcessado = substr($numeroProcessado, 0, 2) . substr($numeroProcessado, 3);
	}
				
	$sqlConversa = "INSERT INTO conversas VALUES(0, '', 'whatsapp', '".$nomeCliente."', '55".$numeroProcessado."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 'F', '', 'C', 'T', 'F')";
	$resultConversa = $conn->query($sqlConversa);
	
	if($resultConversa == 1){
		$sqlConversa = "SELECT codConversa FROM conversas WHERE nome = '".$nomeCliente."' ORDER BY codConversa DESC LIMIT 0,1";
		$resultConversa = $conn->query($sqlConversa);
		$dadosConversa = $resultConversa->fetch_assoc();
		
		$sqlInsereLead = "INSERT INTO leads VALUES(0, 'M', '".$dadosConversa['codConversa']."', ".$codUsuario.", '".date('Y-m-d H:i:s')."', NULL, 'F')";
		$resultInsereLead = $conn->query($sqlInsereLead);
	}
		
	if($codTipoCompromisso != ""){

		$sqlCompromissos = "INSERT INTO compromissos VALUES(0, '".$dadosCodNegociacao['codNegociacao']."', '".$codTipoCompromisso."', 2, '".$codUsuario."', ".$_COOKIE['codAprovado'.$cookie].", '".$nomeCliente."', '".date("Y-m-d")."', '".$data."', '".$hora."', '".$descricaoCompromisso."', 'T')";
		$resultCompromissos = $conn->query($sqlCompromissos);

		if($resultCompromissos == 1){
			
			$sqlCompromisso = "SELECT * FROM compromissos ORDER BY codCompromisso DESC LIMIT 0,1";
			$resultCompromisso = $conn->query($sqlCompromisso);
			$dadosCompromisso = $resultCompromisso->fetch_assoc();

			$sqlInsere = "INSERT INTO compromissosUsuario VALUES(0, ".$dadosCompromisso['codCompromisso'].", ".$codUsuario.")";
			$resultInsere = $conn->query($sqlInsere);
		
		}
	}
		
	$sql3 = "INSERT INTO negociacaoDecorrer VALUES(0, ".$dadosCodNegociacao['codNegociacao'].", '".$codUsuario."', '".date('Y-m-d')."', '".$descricao."')";
	$result3 = $conn->query($sql3);						
			
	if($result == 1){
		echo $dadosCodNegociacao['codNegociacao'];
	}else{
		echo "erro";
	}	
?>		
