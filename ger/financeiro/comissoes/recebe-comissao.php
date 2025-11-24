<?php 
	session_start();
	
	include ('../../f/conf/config.php');
	include ('../../f/conf/controleAcesso.php');

	$codComissao = isset($_POST['codComissao']) ? intval($_POST['codComissao']) : 0;
	
	if($codComissao != 0){
		$sqlComissao = "SELECT pagamentoComissao FROM comissoes WHERE codComissao = ".$codComissao." ORDER BY codComissao DESC LIMIT 0,1";
		$resultComissao = $conn->query($sqlComissao);
		$dadosComissao = $resultComissao->fetch_assoc();
		
		if($dadosComissao['pagamentoComissao'] == "T"){
			$status = "F";
		}else{
			$status = "T";
		}
		
		$sqlUpdateComissao = "UPDATE comissoes SET pagamentoComissao = '".$status."' WHERE codComissao = ".$codComissao."";
		$resultUpdateComissao = $conn->query($sqlUpdateComissao);
		
		if($resultUpdateComissao == 1){
			echo $status;
		}
	}
	
	$conn->close();
?>
