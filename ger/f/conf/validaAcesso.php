<?php	
	$validaAcesso = "nao";
	
	$sqlAreas = "SELECT AC.urlAreaAcesso FROM areasAcesso AC inner join areaUsuario ACO on AC.codAreaAcesso = ACO.codAreaAcesso inner join usuarios C on ACO.codUsuario = C.codUsuario WHERE AC.statusAreaAcesso = 'T' and ACO.codUsuario = '".$_COOKIE['codAprovado'.$cookie]."'";
	$resultAreas = $conn->query($sqlAreas);
	while($dadosAreas = $resultAreas->fetch_assoc()){
		if($dadosAreas['urlAreaAcesso'] == $area){
			$validaAcesso = "ok";
		}
	}	
?>
	
