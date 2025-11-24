<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codCaracteristica = $_POST['codCaracteristica'];
	$codOrdenacaoCaracteristica = $_POST['codOrdenacaoCaracteristica'];
	
	$sqlCons = "SELECT * FROM caracteristicas WHERE codCaracteristica = '".$codCaracteristica."'";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	$sql =  "UPDATE caracteristicas SET codOrdenacaoCaracteristica = '".$codOrdenacaoCaracteristica."' WHERE codCaracteristica = '".$codCaracteristica."'";
	$result = $conn->query($sql);
?>
