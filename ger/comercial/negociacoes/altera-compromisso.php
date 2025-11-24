<?php
	ob_start();
	session_start();
	
	include('../../f/conf/config.php');

	$codNegociacao = $_POST['codNegociacao'];
	$nomeCompromisso = $_POST['nomeCompromisso'];
	$codUsuario = $_POST['codUsuario'];
	$codTipoCompromisso = $_POST['codTipoCompromisso'];
	$data = $_POST['data'];
	$hora = $_POST['hora'];
	$descricaoCompromisso = $_POST['descricaoCompromisso'];
	
	$sqlCompromissos = "UPDATE compromissos SET codTipoCompromisso = ".$codTipoCompromisso.", codUsuario = ".$codUsuario.", nomeCompromisso = '".$nomeCompromisso."', dataCompromisso = '".$data."', horaCompromisso = '".$hora."', descricaoCompromisso = '".$descricaoCompromisso."' WHERE codNegociacao = ".$codNegociacao."";
	$resultCompromissos = $conn->query($sqlCompromissos);
				
	if($resultCompromissos == 1){
		echo "ok";
	}
?>		
