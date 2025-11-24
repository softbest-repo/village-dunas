<?php
	include('../f/conf/config.php');
	
	$codContrato = $_POST['codContrato'];
	$textoContrato = $_POST['textoContrato'];

	$sqlContratoItem = "SELECT * FROM contratosCriados WHERE codContrato = ".$codContrato." LIMIT 0,1";
	$resultContratoItem = $conn->query($sqlContratoItem);
	$dadosContratoItem = $resultContratoItem->fetch_assoc();

	if($dadosContratoItem['codContratoCriado'] != ""){

		if(strlen($textoContrato) <= 310){
			
			$sql = "DELETE FROM contratosCriados WHERE codContrato = ".$codContrato."";
			$result = $conn->query($sql);
			
		}else{
		
			$sql =  "UPDATE contratosCriados SET textoContratoCriado = '".str_replace("'", "&#39;", $textoContrato)."' WHERE codContrato = ".$codContrato."";
			$result = $conn->query($sql);	
			
		}
		
	}else{

		if(strlen($textoContrato) > 310){
		
			$sql =  "INSERT INTO contratosCriados VALUES(0, ".$codContrato.", '".date('Y-m-d')."', '".str_replace("'", "&#39;", $textoContrato)."')";
			$result = $conn->query($sql);		
		
		}		
	}

?>
