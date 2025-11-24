<?php
	ob_start();
	session_start();
	
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');

	$codNegociacao = $_POST['codNegociacao'];
	$descricaoAndamento = $_POST['descricaoAndamento'];
		
	$sql3 = "INSERT INTO negociacaoDecorrer VALUES(0, ".$codNegociacao.", '".$_COOKIE['codAprovado'.$cookie]."', '".date('Y-m-d')."', '".$descricaoAndamento."')";
	$result3 = $conn->query($sql3);						
				
	if($result3 == 1){
		echo "ok";
	}
?>		
