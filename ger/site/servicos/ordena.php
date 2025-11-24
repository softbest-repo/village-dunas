<?php
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');
	
	$codServico = $_POST['codServico'];
	$codOrdenacaoServico = $_POST['codOrdenacaoServico'];
		
	$sql =  "UPDATE servicos SET codOrdenacaoServico = '".$codOrdenacaoServico."' WHERE codServico = '".$codServico."'";
	$result = $conn->query($sql);
?>
