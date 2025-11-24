<?php 
	include ('../../f/conf/config.php');

	$codImovelImagem = $_POST['codImovelImagem'];
	$ordenacaoImovelImagem = $_POST['ordenacaoImovelImagem'];

	$update = "UPDATE imoveisImagens SET ordenacaoImovelImagem = '".$ordenacaoImovelImagem."' WHERE codImovelImagem = ".$codImovelImagem."";
	$result = $conn->query($update);
?>
