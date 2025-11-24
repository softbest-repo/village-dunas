<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codBanner = $_POST['codBanner'];
	$codOrdenacaoBanner = $_POST['codOrdenacaoBanner'];
	
	$sqlCons = "SELECT * FROM banners WHERE codBanner = '".$codBanner."'";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	$sql =  "UPDATE banners SET codOrdenacaoBanner = '".$codOrdenacaoBanner."' WHERE codBanner = '".$codBanner."'";
	$result = $conn->query($sql);
?>
