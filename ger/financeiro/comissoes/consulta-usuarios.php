<?php 
	include ('../../f/conf/config.php');
	
	$codUsuario = isset($_GET['codUsuario']) ? intval($_GET['codUsuario']) : 0;

	if ($codUsuario > 0) {
		$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = $codUsuario ORDER BY codUsuario ASC LIMIT 1";
		$resultUsuario = $conn->query($sqlUsuario);

		if ($resultUsuario->num_rows > 0) {
			$dadosUsuario = $resultUsuario->fetch_assoc();
			
			if($dadosUsuario['tipoUsuario'] == "CP"){
				$codCorretorLitoral = "C-".$dadosUsuario['codCorretorLitoral'];
				
				$sqlLitoral = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosUsuario['codCorretorLitoral']." ORDER BY codUsuario ASC LIMIT 0,1";
				$resultLitoral = $conn->query($sqlLitoral);
				$dadosLitoral = $resultLitoral->fetch_assoc();
				
				if($dadosLitoral['codUsuario'] != 0){
					$codGerente = "G-".$dadosLitoral['codGerente'];					
				}else{
					$codGerente = 0;
				}
			}else{
				$codCorretorLitoral = 0;
				$codGerente = "G-".$dadosUsuario['codGerente'];
			}

			echo json_encode([
				'corretorLitoral' => $codCorretorLitoral,
				'gerente' => $codGerente
			]);
		} else {
			echo json_encode(['erro' => 'Usuário não encontrado']);
		}
	} else {
		echo json_encode(['erro' => 'Código de usuário inválido']);
	}

	$conn->close();
?>
