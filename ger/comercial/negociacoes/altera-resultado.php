<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');

	$codNegociacao = $_POST['codNegociacao'];
	$resultado = $_POST['resultado'];

	$sqlUpdateNegociacao = "UPDATE negociacoes SET resultadoNegociacao = '".$resultado."' WHERE codNegociacao = ".$codNegociacao."";
	$resultUpdateNegociacao = $conn->query($sqlUpdateNegociacao);
	
	if($resultUpdateNegociacao == 1){
		echo "ok";
	}
?>		
