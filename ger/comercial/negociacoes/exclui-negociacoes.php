<?php
	ob_start();
	session_start();
	
	include('../../f/conf/config.php');

	$codNegociacao = $_POST['codNegociacao'];
	
	$sqlDelete = "DELETE FROM negociacoes WHERE codNegociacao = ".$codNegociacao."";
	$resultDelete = $conn->query($sqlDelete);
	
	$sqlDelete = "DELETE FROM negociacaoDecorrer WHERE codNegociacao = ".$codNegociacao."";
	$resultDelete1 = $conn->query($sqlDelete);
	
	$sqlDelete = "DELETE FROM negociacoesAnexos WHERE codNegociacao = ".$codNegociacao."";
	$resultDelete2 = $conn->query($sqlDelete);
	
	$sqlDelete = "DELETE FROM compromissos WHERE codNegociacao = ".$codNegociacao."";
	$resultDelete3 = $conn->query($sqlDelete);

	if($resultDelete == 1){
		echo "ok";
	}
?>		
