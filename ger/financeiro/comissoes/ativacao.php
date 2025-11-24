<?php
	include('../../f/conf/config.php');
	
	$codComissaoCorretor = $_POST['codComissaoCorretor'];
	
	$sqlCons = "SELECT * FROM comissoesCorretores WHERE codComissaoCorretor = ".$codComissaoCorretor." LIMIT 0,1";
	$resultCons = $conn->query($sqlCons);
	$dadosCons = $resultCons->fetch_assoc();
		
	if($dadosCons['statusComissaoCorretor'] == "T"){
		$alteraStatus = "F";
	}else{
		$alteraStatus = "T";
	}
	
	$sql =  "UPDATE comissoesCorretores SET statusComissaoCorretor = '".$alteraStatus."' WHERE codComissaoCorretor = ".$codComissaoCorretor;
	$result = $conn->query($sql);			
?>
