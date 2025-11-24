<?php 
	ob_start();
	session_start();
	
	include ('../f/conf/config.php');
	include ('../f/conf/functions.php');

	if (!$conn) {
		die("Erro na conexão com o banco de dados: " . $conn->connect_error);
	}

	$codContrato = $_POST['codContrato'];
	$nomeIntencao = $_POST['nomeIntencao'] ?? '';
	$nascimentoIntencao = $_POST['nascimentoIntencao'] ?? '';
	$cpfIntencao = $_POST['cpfIntencao'] ?? '';
	$rgIntencao = $_POST['rgIntencao'] ?? '';
	$orgaoIntencao = $_POST['orgaoIntencao'] ?? '';
	$profissaoIntencao = $_POST['profissaoIntencao'] ?? '';
	$nacionalidadeIntencao = $_POST['nacionalidadeIntencao'] ?? '';
	$estadoCivilIntencao = $_POST['estadoCivilIntencao'] ?? '';
	$conjugeIntencao = $_POST['conjugeIntencao'] ?? '';
	$nascimentoConjugeIntencao = $_POST['nascimentoConjugeIntencao'] ?? '';
	$cpfConjugeIntencao = $_POST['cpfConjugeIntencao'] ?? '';
	$rgConjugeIntencao = $_POST['rgConjugeIntencao'] ?? '';
	$orgaoConjugeIntencao = $_POST['orgaoConjugeIntencao'] ?? '';
	$profissaoConjugeIntencao = $_POST['profissaoConjugeIntencao'] ?? '';
	$enderecoIntencao = $_POST['enderecoIntencao'] ?? '';
	$cepIntencao = $_POST['cepIntencao'] ?? '';
	$telefoneIntencao = $_POST['telefoneIntencao'] ?? '';
	$emailIntencao = $_POST['emailIntencao'] ?? '';
	$telefone2Intencao = $_POST['telefone2Intencao'] ?? '';
	$email2Intencao = $_POST['email2Intencao'] ?? '';
	$loteamentoIntencao = $_POST['loteamentoIntencao'] ?? '';
	$cidadeIntencao = $_POST['cidadeIntencao'] ?? '';
	$loteIntencao = $_POST['loteIntencao'] ?? '';
	$quadraIntencao = $_POST['quadraIntencao'] ?? '';
	$tamanhoIntencao = $_POST['tamanhoIntencao'] ?? '';
	$ruaIntencao = $_POST['ruaIntencao'] ?? '';
	$matriculaIntencao = $_POST['matriculaIntencao'] ?? '';
	$totalIntencao = str_replace(",", ".", str_replace(".", "", $_POST['totalIntencao'] ?? ''));
	$sinalIntencao = str_replace(",", ".", str_replace(".", "", $_POST['sinalIntencao'] ?? ''));
	$saldoIntencao = str_replace(",", ".", str_replace(".", "", $_POST['saldoIntencao'] ?? ''));
	$valorInIntencao = $_POST['valorInIntencao'] ?? '';
	$formaIntencao = $_POST['formaIntencao'] ?? '';
	$dataParcelaIntencao = $_POST['dataParcelaIntencao'] ?? '';
	$nomeDeclaracaoIntencao = $_POST['nomeDeclaracaoIntencao'] ?? '';
	$cidadeDataIntencao = $_POST['cidadeDataIntencao'] ?? '';
	$estadoDataIntencao = $_POST['estadoDataIntencao'] ?? '';
	$diaDataIntencao = $_POST['diaDataIntencao'] ?? '';
	$mesDataIntencao = $_POST['mesDataIntencao'] ?? '';

	$sqlUpdate = "UPDATE contratos 
		SET nomeIntencao = ?, nascimentoIntencao = ?, cpfIntencao = ?, rgIntencao = ?, orgaoIntencao = ?, profissaoIntencao = ?, nacionalidadeIntencao = ?, 
			estadoCivilIntencao = ?, conjugeIntencao = ?, nascimentoConjugeIntencao = ?, cpfConjugeIntencao = ?, rgConjugeIntencao = ?, 
			orgaoConjugeIntencao = ?, profissaoConjugeIntencao = ?, enderecoIntencao = ?, cepIntencao = ?, telefoneIntencao = ?, 
			emailIntencao = ?, telefone2Intencao = ?, email2Intencao = ?, loteamentoIntencao = ?, 
			cidadeIntencao = ?, loteIntencao = ?, quadraIntencao = ?, tamanhoIntencao = ?, ruaIntencao = ?, 
			matriculaIntencao = ?, totalIntencao = ?, sinalIntencao = ?, saldoIntencao = ?, valorInIntencao = ?, formaIntencao = ?, 
			dataParcelaIntencao = ?, declaracaoIntencao = ?, cidadeDataIntencao = ?, 
			estadoDataIntencao = ?, diaDataIntencao = ?, mesDataIntencao = ?
		WHERE codContrato = ?";

	$stmt = $conn->prepare($sqlUpdate);
	$stmt->bind_param("ssssssssssssssssssssssssssssssssssssssi",
		$nomeIntencao, data($nascimentoIntencao), $cpfIntencao, $rgIntencao, $orgaoIntencao, $profissaoIntencao, $nacionalidadeIntencao, 
		$estadoCivilIntencao, $conjugeIntencao, data($nascimentoConjugeIntencao), $cpfConjugeIntencao, $rgConjugeIntencao, 
		$orgaoConjugeIntencao, $profissaoConjugeIntencao, $enderecoIntencao, $cepIntencao, $telefoneIntencao, 
		$emailIntencao, $telefone2Intencao, $email2Intencao, $loteamentoIntencao, 
		$cidadeIntencao, $loteIntencao, $quadraIntencao, $tamanhoIntencao, $ruaIntencao, 
		$matriculaIntencao, $totalIntencao, $sinalIntencao, $saldoIntencao, $valorInIntencao, $formaIntencao, 
		$dataParcelaIntencao, $nomeDeclaracaoIntencao, $cidadeDataIntencao, 
		$estadoDataIntencao, $diaDataIntencao, $mesDataIntencao, $codContrato
	);

	if ($stmt->execute()) {
		$sqlContrato = "SELECT * FROM contratos C inner join lotes L on C.codLote = L.codLote inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join quadras Q on L.codQuadra = Q.codQuadra WHERE C.codContrato = ".$codContrato." ORDER BY C.codContrato DESC LIMIT 0,1";
		$resultContrato = $conn->query($sqlContrato);
		$dadosContrato = $resultContrato->fetch_assoc();
		
		$sqlMovimentacao = "SELECT * FROM movimentacoes WHERE codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and codLote = ".$dadosContrato['codLote']." and nomeMovimentacao = 'CA' ORDER BY codMovimentacao DESC LIMIT 0,1";
		$resultMovimentacao = $conn->query($sqlMovimentacao);
		$dadosMovimentacao = $resultMovimentacao->fetch_assoc();
		
		if($dadosMovimentacao['codMovimentacao'] == ""){
			$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', '".$_COOKIE['codAprovado'.$cookie]."', '".$dadosContrato['codLote']."', 'CA', 'T', 1)";
			$resultInsere = $conn->query($sqlInsere);		

			$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Intenção de compra confeccionado para o loteamento ".$dadosContrato['nomeLoteamento'].", quadra ".$dadosContrato['nomeQuadra'].", lote ".$dadosContrato['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
			$resultHistorico = $conn->query($sqlHistorico);
			
			$sqlContrato = "UPDATE contratos SET tipoContrato = 'AA' WHERE codContrato = ".$codContrato."";
			$resultContrato = $conn->query($sqlContrato);
		}else{
			$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Intenção de compra alterado para o loteamento ".$dadosContrato['nomeLoteamento'].", quadra ".$dadosContrato['nomeQuadra'].", lote ".$dadosContrato['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
			$resultHistorico = $conn->query($sqlHistorico);			
		}
		echo "ok";
	} else {
		echo "Erro ao atualizar contrato: " . $stmt->error;
	}

	$stmt->close();
	$conn->close();
?>
