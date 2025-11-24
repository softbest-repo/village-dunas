<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codImovel = $_POST['codImovel'];
	$codOrdenacaoImovel = $_POST['codOrdenacaoImovel'];
	
	$sqlCons = "SELECT * FROM imoveis WHERE codImovel = '".$codImovel."'";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	$sql =  "UPDATE imoveis SET codOrdenacaoImovel = '".$codOrdenacaoImovel."' WHERE codImovel = '".$codImovel."'";
	$result = $conn->query($sql);
?>
