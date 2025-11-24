<?php
	include('../../f/conf/config.php');
	
	$codContrato = $_POST['codContrato'];
	$codContratoItem = $_POST['codContratoItem'];
	$textoContratoItem = $_POST['textoContratoItem'];

	$sqlContratoItem = "SELECT * FROM contratosItens WHERE codContratoItem = ".$codContratoItem." and codContrato = ".$codContrato." LIMIT 0,1";
	$resultContratoItem = $conn->query($sqlContratoItem);
	$dadosContratoItem = $resultContratoItem->fetch_assoc();

	if($dadosContratoItem['codContratoItem'] != ""){

		if(strlen($textoContratoItem) <= 310){
			
			$sql = "DELETE FROM contratosItens WHERE codContratoItem = ".$codContratoItem." and codContrato = ".$codContrato."";
			$result = $conn->query($sql);
			
		}else{
		
			$sql =  "UPDATE contratosItens SET textoContratoItem = '".str_replace("'", "&#39;", $textoContratoItem)."' WHERE codContratoItem = ".$codContratoItem." and codContrato = ".$codContrato."";
			$result = $conn->query($sql);	
			
		}
		
	}else{

		if(strlen($textoContratoItem) > 310){
		
			$sql =  "INSERT INTO contratosItens VALUES(".$codContratoItem.", ".$codContrato.", '".str_replace("'", "&#39;", $textoContratoItem)."')";
			$result = $conn->query($sql);		
		
		}		
	}

?>
