<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codBanner = $_POST['codBanner'];
	$codOrdenacaoBanner = $_POST['codOrdenacaoBanner'];
		
	$sql =  "UPDATE banners SET codOrdenacaoBanner = '".$codOrdenacaoBanner."' WHERE codBanner = '".$codBanner."'";
	$result = $conn->query($sql);
?>
