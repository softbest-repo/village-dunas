<?php 
	ob_start();
		
	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		include ('../../f/conf/config.php');
		include ('../../f/conf/controleAcesso.php');
	
		$nomeProprietario = $_POST['nomeProprietario'];
		$cpfProprietario = $_POST['cpfProprietario'];
		$corretor = $_POST['corretor'];
	
		if($nomeProprietario != ""){
								
			$sqlProprietario = "SELECT * FROM proprietarios WHERE nomeProprietario = '".trim($nomeProprietario)."' or cpfProprietario = '".$cpfProprietario."' and cpfProprietario != '' ORDER BY codProprietario DESC LIMIT 0,1";
			$resultProprietario = $conn->query($sqlProprietario);
			$dadosProprietario = $resultProprietario->fetch_assoc();
			
			if($dadosProprietario['codProprietario'] != "" && $dadosProprietario['codUsuario'] != $corretor){
				
				$sqlVinculados = "SELECT * FROM proprietariosUsuarios WHERE codProprietario = ".$dadosProprietario['codProprietario']." and codUsuario = ".$corretor." ORDER BY codProprietarioUsuario ASC LIMIT 0,1";
				$resultVinculados = $conn->query($sqlVinculados);
				$dadosVinculados = $resultVinculados->fetch_assoc();
				
				if($dadosVinculados['codProprietarioUsuario'] == ""){
					echo json_encode([
						'success' => true
					]);		
				}else{
					echo json_encode([
						'success' => "ok"
					]);					
				}		
			}else{			
				echo json_encode([
					'success' => "ok"
				]);
			}
		} else {
			echo json_encode(['success' => false, 'message' => 'Nome / Razão Social ou CPF / CNPJ não informados.']);
		}
	}
?>
