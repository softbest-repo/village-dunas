<?php
	ob_start();
	session_start();
	
	include('../../f/conf/config.php');

	$codNegociacao = $_POST['codNegociacao'];
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
	
	$update = "UPDATE negociacoes SET codAlteraUsuario = ".$_COOKIE['codAprovado'.$cookie].", codTipoImovel = '".$tipoImovel."',  nomeClienteNegociacao = '".$nomeCliente."', dataAtualizaNegociacao = '".date('Y-m-d')."', horaAtualizaNegociacao = '".date('H:i:s')."', resultadoNegociacao = '".$resultado."', fechamentoNegociacao = '".$fechamento."', midiaNegociacao = '".$midia."', codTipoPagamento = ".$codTipoPagamento.", codUsuario = ".$codUsuario.", telefoneNegociacao = '".$telefone."', tipoClienteNegociacao = '".$tipoCliente."', fPrecoDNegociacao = '".$fPrecoD."', fPrecoANegociacao = '".$fPrecoA."', codEstado = ".$estado.", codCidade = ".$cidade." WHERE codNegociacao = ".$codNegociacao;
	$result = $conn->query($update);

	if($result == 1){
		echo "ok";
	}
