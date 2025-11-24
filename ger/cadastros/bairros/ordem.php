<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codBairro = $_POST['codBairro'];
	$codOrdenacaoBairro = $_POST['codOrdenacaoBairro'];
	
	$sqlCons = "SELECT * FROM bairros WHERE codBairro = '".$codBairro."'";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	$sql =  "UPDATE bairros SET codOrdenacaoBairro = '".$codOrdenacaoBairro."' WHERE codBairro = '".$codBairro."'";
	$result = $conn->query($sql);
?>
