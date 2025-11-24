<?php
	$lockFile = 'cron-roleta.lock';
	if (file_exists($lockFile) && filemtime($lockFile) > (time() - 10)) {
		exit;
	}
	touch($lockFile);
   
    include('../f/conf/config.php');
    include('info.php');

	function padronizarNumero($numero) {
		$numero = preg_replace('/\D/', '', $numero);

		$prefixosCom9 = ['2000', '3300', '2100', '2200', '2400'];

		if (strlen($numero) >= 10) {
			$ddd = substr($numero, 0, 2);
			$telefone = substr($numero, 2);

			if (strlen($telefone) === 9 && $telefone[0] === '9') {
				$semNove = substr($telefone, 1);

				foreach ($prefixosCom9 as $prefixo) {
					if (strpos($semNove, $prefixo) === 0) {
						return $ddd . $telefone;
					}
				}

				return $ddd . $semNove;
			}

			return $ddd . $telefone;
		}

		return $numero;
	}
		
	$sqlLeads = "SELECT * FROM leads WHERE statusLead = 'T' AND (envioLead <= DATE_SUB(NOW(), INTERVAL ".$tempoLead." MINUTE) OR envioLead IS NULL) ORDER BY recebidoLead ASC";
    $resultLeads = $conn->query($sqlLeads);
    while($dadosLeads = $resultLeads->fetch_assoc()){
		
		include('condicao.php');
													
		$codUsuario = "";
		$codUsuarioLead = "";
		$statusUsuarioLead = "";
			
		$sqlUsuarioLead = "SELECT * FROM usuariosLeads WHERE codLead = ".$dadosLeads['codLead']." and statusUsuarioLead != 'T' ORDER BY codUsuarioLead DESC LIMIT 0,1";
		$resultUsuarioLead = $conn->query($sqlUsuarioLead);
		$dadosUsuarioLead = $resultUsuarioLead->fetch_assoc();
		
		$sqlTotalLeads = "SELECT count(codLead) total FROM leads WHERE statusLead = 'T' AND (envioLead <= DATE_SUB(NOW(), INTERVAL ".$tempoLead." MINUTE) OR envioLead IS NULL)";
		$resultTotalLeads = $conn->query($sqlTotalLeads);
		$dadosTotalLeads = $resultTotalLeads->fetch_assoc();
		
		$sqlUltimoLead = "SELECT * FROM usuariosLeads WHERE codUsuario = ".$proximoCorretor." ORDER BY codUsuarioLead DESC LIMIT 0,1";
		$resultUltimoLead = $conn->query($sqlUltimoLead);
		$dadosUltimoLead = $resultUltimoLead->fetch_assoc();
		
		if($dadosUsuarioLead){
			$codUsuario = $dadosUsuarioLead['codUsuario'];
			$codUsuarioLead = $dadosUsuarioLead['codUsuarioLead'];
			$statusUsuarioLead = $dadosUsuarioLead['statusUsuarioLead'];
		}
								
		if($codUsuario != $proximoCorretor || $dadosTotalLeads['total'] == 1 || $dadosVerifica['total'] == 1 && $dadosUltimoLead['codLead'] != $dadosLeads['codLead']){
								
			if($codUsuarioLead == "" || $statusUsuarioLead == "A" && date('H:i:s') >= $horaInicio && date('H:i:s') <= $horaFim || $statusUsuarioLead == "F"){
			
				$sqlUsuarioCelular = "SELECT * FROM usuarios WHERE codUsuario = ".$proximoCorretor." ORDER BY codUsuario DESC LIMIT 0,1";
				$resultUsuarioCelular = $conn->query($sqlUsuarioCelular);
				$dadosUsuarioCelular = $resultUsuarioCelular->fetch_assoc();

				$numeroProcessado = str_replace(["(", ")", "-", " "], "", $dadosUsuarioCelular['celularUsuario']);

				if (strlen($numeroProcessado) == 11 && substr($numeroProcessado, 2, 1) == "9") {
					$numeroProcessado = "55".padronizarNumero($numeroProcessado);
				}
						
				$sqlInsere = "INSERT INTO conversas VALUES(0, '', 'whatsapp', '".$dadosUsuarioCelular['nomeUsuario']." ".$dadosUsuarioCelular['sobrenomeUsuario']."', ".$numeroProcessado.", '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 'F', '', 'S', 'T', 'T')";
				$resultInsere = $conn->query($sqlInsere);

				if($resultInsere == 1){
					
					$sqlConversa = "SELECT * FROM conversas WHERE numero = ".$numeroProcessado." and envio = 'S' and status = 'T' ORDER BY codConversa DESC LIMIT 0,1";
					$resultConversa = $conn->query($sqlConversa);
					$dadosConversa = $resultConversa->fetch_assoc();

					$sqlUpdateLeads = "UPDATE usuariosLeads SET statusUsuarioLead = 'T' WHERE codLead = ".$dadosLeads['codLead']." and statusUsuarioLead = 'A'";
					$resultUpdateLeads = $conn->query($sqlUpdateLeads);
																			
					$sqlInsereLeads = "INSERT INTO usuariosLeads VALUES (0, ".$proximoCorretor.", ".$dadosLeads['codLead'].", ".$dadosConversa['codConversa'].", '".date('Y-m-d H:i:s')."', NULL, 'A')";
					$resultInsereLeads = $conn->query($sqlInsereLeads);

					if ($resultInsereLeads == 1){
							
						$sqlUpdateFila = "UPDATE fila SET envioFila = '".date('Y-m-d H:i:s')."' WHERE codUsuario = ".$proximoCorretor."";
						$resultUpdateFila = $conn->query($sqlUpdateFila);
						
						$sqlUpdateFila2 = "UPDATE filaLeads SET envioFilaLead = '".date('Y-m-d H:i:s')."' WHERE codUsuario = ".$proximoCorretor." and codLead = ".$dadosLeads['codLead']."";
						$resultUpdateFila2 = $conn->query($sqlUpdateFila2);
						
						$sqlUsuarioLead = "SELECT * FROM usuariosLeads WHERE codUsuario = ".$proximoCorretor." and codLead = ".$dadosLeads['codLead']." and statusUsuarioLead = 'A' ORDER BY codUsuarioLead DESC LIMIT 0,1";
						$resultUsuarioLead = $conn->query($sqlUsuarioLead);
						$dadosUsuarioLead = $resultUsuarioLead->fetch_assoc();
						
						if(date('H:i:s') >= $horaInicio && date('H:i:s') <= $horaFim){
						
							$messageData = [
								"messaging_product" => "whatsapp",
								"recipient_type" => "individual",
								"to" => $numeroProcessado,
								"type" => "template",
								"template" => [
									"name" => "envia_corretor_codigo",
									"language" => ["code" => "pt_BR"],
									"components" => [
										[
											"type" => "body",
											"parameters" => [
												["type" => "text", "text" => $dadosUsuarioLead['codLead']],         // Substitui {{1}}
											]
										]
									]					
								]			
							];		
						
						}else{
							$messageData = [
								"messaging_product" => "whatsapp",
								"recipient_type" => "individual",
								"to" => $numeroProcessado,
								"type" => "template",
								"template" => [
									"name" => "envia_corretor_codigo_s_expirar",
									"language" => ["code" => "pt_BR"],
									"components" => [
										[
											"type" => "body",
											"parameters" => [
												["type" => "text", "text" => $dadosUsuarioLead['codLead']],         // Substitui {{1}}
											]
										]
									]					
								]			
							];				
						}		
							
						$ch = curl_init("https://graph.facebook.com/v21.0/$phone_number_id/messages");

						curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
						curl_setopt($ch, CURLOPT_POST, true);
						curl_setopt($ch, CURLOPT_HTTPHEADER, [
							"Authorization: Bearer $token",
							"Content-Type: application/json"
						]);
						curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));
						
						$response = curl_exec($ch);
						
						if($response === false) {
							echo 'Erro: ' . curl_error($ch);
						}else{
							
							$sqlUpdate = "UPDATE leads SET envioLead = '".date('Y-m-d H:i:s')."' WHERE codLead = ".$dadosLeads['codLead']."";
							$conn->query($sqlUpdate);
						}

						curl_close($ch);

					}else{
						$sqlInsereLog = "INSERT INTO logs VALUES(0, 'Lead', '".$dadosLead['codLead']."', 'Conversa não encontrada ".$sqlConversa."', '".date('Y-m-d H:i:s')."')";
						$resultInsereLog = $conn->query($sqlInsereLog);
					}
				}
			}
		}
    }
	
   	$conn->close();
?>
