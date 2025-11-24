<?php
	ob_start();
	session_start();
	
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');

	$codNegociacao = $_POST['codNegociacao'];
	$fechamento = $_POST['fechamento'];
	
	$update = "UPDATE negociacoes SET fechamentoNegociacao = '".$fechamento."', dataFimNegociacao = '".date('Y-m-d')."' WHERE codNegociacao = ".$codNegociacao;
	$result = $conn->query($update);

	if($result == 1){
		echo "ok";
	}
?>		
