<?php	
	function validaAcesso($conn, $area){

		$cookie = "MarkanImoveisGer";
	
		$sqlAreas = "SELECT AC.urlAreaAcesso FROM areasAcesso AC inner join areaUsuario ACO on AC.codAreaAcesso = ACO.codAreaAcesso inner join usuarios C on ACO.codUsuario = C.codUsuario WHERE AC.statusAreaAcesso = 'T' and ACO.codUsuario = ".$_COOKIE['codAprovado'.$cookie];
		$resultAreas = $conn->query($sqlAreas);
		while($dadosAreas = $resultAreas->fetch_assoc()){
			if($dadosAreas['urlAreaAcesso'] == $area){
				$acesso = "ok";
			}
		}
		return $acesso;
	}
	
	
	function controleUsuario($conn){

		$cookie = "MarkanImoveisGer";

		$sqlVerifica = "SELECT * FROM controleAcesso WHERE codUsuario = '".$_COOKIE['codAprovado'.$cookie]."' and dataControle = '".date("Y-m-d")."'";
		$resultVerifica = $conn->query($sqlVerifica);
		$dadosVerifica = $resultVerifica->fetch_assoc();
		
		if($dadosVerifica['codControle'] == $_COOKIE['controleAprovado'.$cookie]){
			return "tem usuario";
		}else{
			return "";
		}
		
	}	
	
	$sqlVerifica = "SELECT * FROM controleAcesso WHERE codUsuario = '".$_COOKIE['codAprovado'.$cookie]."' and dataControle = '".date("Y-m-d")."'";
	$resultVerifica = $conn->query($sqlVerifica);
	$dadosVerifica = $resultVerifica->fetch_assoc();
	
	if($dadosVerifica['codControle'] == $_COOKIE['controleAprovado'.$cookie]){
		$controleUsuario = "tem usuario";
	}else{
		$retornoControle = "";
	}
	
	$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$_COOKIE['codAprovado'.$cookie]."' LIMIT 0,1";
	$resultUsuario = $conn->query($sqlUsuario);
	$dadosUsuario = $resultUsuario->fetch_assoc();
	
	if($dadosUsuario['tipoUsuario'] == "C"){
		$filtraUsuario = " and codUsuario = ".$dadosUsuario['codUsuario']."";
		$filtraUsuarioI = " and CO.codUsuario = ".$dadosUsuario['codUsuario']."";
		$filtraUsuarioIM = " and I.codUsuario = ".$dadosUsuario['codUsuario']."";
		$filtraUsuarioPU = " and P.codUsuario = ".$dadosUsuario['codUsuario']."";
		$usuario = "C";
	}else
	if($dadosUsuario['tipoUsuario'] == "CE"){
		$filtraUsuario = " and codUsuario = ".$dadosUsuario['codUsuario']."";
		$filtraUsuarioI = " and CO.codUsuario = ".$dadosUsuario['codUsuario']."";
		$filtraUsuarioIM = " and I.codUsuario = ".$dadosUsuario['codUsuario']."";
		$filtraUsuarioPU = " and P.codUsuario = ".$dadosUsuario['codUsuario']."";
		$usuario = "CE";
	}else{
		$filtraUsuario = "";
		$filtraUsuarioI = "";
		$filtraUsuarioIM = "";
		$filtraUsuarioPU = "";
		$usuario = "A";
	}	
?>
	
