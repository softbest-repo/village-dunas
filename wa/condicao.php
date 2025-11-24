<?php	
	include('info.php');
	include('../f/conf/config.php');
	
	$agora = new DateTime();
	
	if ($agora->format('H:i:s') < $limiteCheckin) {
		$inicio = (new DateTime('yesterday'))->format('Y-m-d') . " " . $limiteCheckin;
		$fim    = $agora->format('Y-m-d') . " " . $limiteCheckin;
	} else {
		$inicio = $agora->format('Y-m-d') . " " . $limiteCheckin;
		$fim    = (new DateTime('tomorrow'))->format('Y-m-d') . " " . $limiteCheckin;
	}

	$sqlVerificaCorretores = "SELECT COUNT(*) as total FROM usuarios u INNER JOIN usuariosLogins ul ON u.codUsuario = ul.codUsuario	WHERE ul.dataUsuarioLogin >= '$inicio' AND ul.dataUsuarioLogin <  '$fim'";
	$resultVerifica = $conn->query($sqlVerificaCorretores);
	$dadosVerifica = $resultVerifica->fetch_assoc();

	if ($dadosVerifica['total'] == 0) {
		die("Nenhum corretor disponível para o dia atual.");
	}
	
	$codLead = $dadosLeads['codLead'];

	$proximoCorretor = "";
	
	if(date('H:i:s') < $limiteCheckin){
		$sqlFila = "SELECT codUsuario FROM fila WHERE loginFila >= CONCAT(CURDATE() - INTERVAL 1 DAY, ' ".$limiteCheckin."') AND loginFila < CONCAT(CURDATE(), ' ".$limiteCheckin."') ORDER BY envioFila ASC, loginFila ASC, codUsuario ASC LIMIT 1";
	}else{
		$sqlFila = "SELECT codUsuario FROM fila WHERE loginFila >= CONCAT(CURDATE(), ' ".$limiteCheckin."') AND loginFila < CONCAT(DATE_ADD(CURDATE(), INTERVAL 1 DAY), ' ".$limiteCheckin."') ORDER BY envioFila ASC, loginFila ASC, codUsuario ASC LIMIT 1";
	}

	$resultFila = $conn->query($sqlFila);
	$dadosFila = $resultFila->fetch_assoc();	
							
	$proximoCorretor = $dadosFila['codUsuario'];		