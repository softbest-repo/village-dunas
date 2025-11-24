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
	
	$sqlCompromissos = "INSERT INTO compromissos VALUES(0, ".$codNegociacao.", ".$codTipoCompromisso.", 2, ".$codUsuario.", ".$_COOKIE['codAprovado'.$cookie].", '".$nomeCompromisso."', '".date("Y-m-d")."', '".$data."', '".$hora."', '".$descricaoCompromisso."', 'T')";
	$resultCompromissos = $conn->query($sqlCompromissos);
				
	if($resultCompromissos == 1){
			
		$sqlCompromisso = "SELECT * FROM compromissos ORDER BY codCompromisso DESC LIMIT 0,1";
		$resultCompromisso = $conn->query($sqlCompromisso);
		$dadosCompromisso = $resultCompromisso->fetch_assoc();

		$sqlInsere = "INSERT INTO compromissosUsuario VALUES(0, ".$dadosCompromisso['codCompromisso'].", ".$codUsuario.")";
		$resultInsere = $conn->query($sqlInsere);
		
		echo "ok";
	}
?>		
