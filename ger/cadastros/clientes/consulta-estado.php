<?php
	include('../../f/conf/config.php');

	$siglaEstado = $_POST['siglaEstado'];

	$sqlEstado = "SELECT * FROM estado WHERE statusEstado = 'T' and siglaEstado = '".$siglaEstado."'";
	$resultEstado = $conn->query($sqlEstado);
	$dadosEstado = $resultEstado->fetch_assoc();
	
	if($dadosEstado['codEstado'] != ""){
		echo $dadosEstado['codEstado'];
	}else{
		echo "erro";
	}
?>
