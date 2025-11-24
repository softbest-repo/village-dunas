<?php
	$lockFile = 'cron-interage.lock';
	if (file_exists($lockFile) && filemtime($lockFile) > (time() - 60)) {
		exit;
	}
	touch($lockFile);
	
	include('../f/conf/config.php');
	include('info.php');
	
	$sqlConfere = "SELECT * FROM conversas WHERE recebe = 'F' and status = 'T' and envio = 'C' ORDER BY codConversa ASC";
	$resultConfere = $conn->query($sqlConfere);
	while($dadosConfere = $resultConfere->fetch_assoc()){
		
		$sqlMensagens = "SELECT count(codMensagem) total FROM mensagens WHERE codConversa = ".$dadosConfere['codConversa']." ORDER BY codMensagem DESC LIMIT 0,1";
		$resultMensagens = $conn->query($sqlMensagens);
		$dadosMensagens = $resultMensagens->fetch_assoc();
		
		$sqlMensagem = "SELECT * FROM mensagens WHERE codConversa = ".$dadosConfere['codConversa']." ORDER BY codMensagem DESC LIMIT 0,1";
		$resultMensagem = $conn->query($sqlMensagem);
		$dadosMensagem = $resultMensagem->fetch_assoc();

		$sqlRecorrencia = "SELECT * FROM conversas WHERE numero = ".$dadosConfere['numero']." and codConversa != ".$dadosConfere['codConversa']." ORDER BY codConversa DESC LIMIT 0,1";
		$resultRecorrencia = $conn->query($sqlRecorrencia);
		$dadosRecorrencia = $resultRecorrencia->fetch_assoc();
		
		$confereRecorrencia = "";

		if($dadosRecorrencia['codConversa'] != ""){
			$sqlReLead = "SELECT * FROM leads WHERE codConversa = '".$dadosRecorrencia['codConversa']."' ORDER BY codLead DESC LIMIT 0,1";
			$resultReLead = $conn->query($sqlReLead);
			$dadosReLead = $resultReLead->fetch_assoc();
			
			if($dadosReLead['statusLead'] == "F"){

				$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$dadosReLead['codUsuario']."' and statusUsuario = 'T' ORDER BY codUsuario DESC LIMIT 0,1";
				$resultUsuario = $conn->query($sqlUsuario);
				$dadosUsuario = $resultUsuario->fetch_assoc();

				if($dadosUsuario['codUsuario'] != ""){
					
					$confereRecorrencia = "T";

					$sqlLog = "INSERT INTO logs VALUES(0, 'Entrou R', '".date('Y-m-d H:i:s')."')";
					$resultLog = $conn->query($sqlLog);

					$sqlInsereLead = "INSERT INTO leads VALUES(0, 'A', ".$dadosConfere['codConversa'].", 0, '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 'R')";
					$resultInsereLead = $conn->query($sqlInsereLead);
				
					$codLeadInserido = $conn->insert_id;

					if($resultInsereLead == 1){
						$sqlInsereULeads = "INSERT INTO usuariosLeads VALUES (0, ".$dadosUsuario['codUsuario'].", ".$codLeadInserido.", ".$dadosConfere['codConversa'].", '".date('Y-m-d H:i:s')."', NULL, 'F')";
						$resultInsereULeads = $conn->query($sqlInsereULeads);	

						$codULeadInserido = $conn->insert_id;

						if($resultInsereULeads == 1){
							$sqlUpdateFila = "UPDATE fila SET envioFila = '".date('Y-m-d H:i:s')."' WHERE codUsuario = ".$dadosUsuario['codUsuario']."";
							$resultUpdateFila = $conn->query($sqlUpdateFila);
							
							$sqlUpdateFila2 = "UPDATE filaLeads SET envioFilaLead = '".date('Y-m-d H:i:s')."' WHERE codUsuario = ".$dadosUsuario['codUsuario']." and codLead = ".$codLeadInserido."";
							$resultUpdateFila2 = $conn->query($sqlUpdateFila2);
	
							chamarCurl($configUrlWa."wa/aceitar-lead.php?ref=".$codULeadInserido);
						}
					}
				}else{
					$sqlLog = "INSERT INTO logs VALUES(0, 'Entrou T Recorrente', '".date('Y-m-d H:i:s')."')";
					$resultLog = $conn->query($sqlLog);

					$confereRecorrencia = "F";

					$sqlInsereLead = "INSERT INTO leads VALUES(0, 'A', ".$dadosConfere['codConversa'].", 0, '".date('Y-m-d H:i:s')."', NULL, 'T')";
					$resultInsereLead = $conn->query($sqlInsereLead);					
				}
			}else{
				$sqlLog = "INSERT INTO logs VALUES(0, 'Entrou F', '".date('Y-m-d H:i:s')."')";
				$resultLog = $conn->query($sqlLog);

				$confereRecorrencia = "";

				$sqlInsereLead = "INSERT INTO leads VALUES(0, 'A', ".$dadosConfere['codConversa'].", 0, '".date('Y-m-d H:i:s')."', NULL, 'F')";
				$resultInsereLead = $conn->query($sqlInsereLead);				
			}
		}else{
			$sqlLog = "INSERT INTO logs VALUES(0, 'Entrou T', '".date('Y-m-d H:i:s')."')";
			$resultLog = $conn->query($sqlLog);

			$confereRecorrencia = "F";

			$sqlInsereLead = "INSERT INTO leads VALUES(0, 'A', ".$dadosConfere['codConversa'].", 0, '".date('Y-m-d H:i:s')."', NULL, 'T')";
			$resultInsereLead = $conn->query($sqlInsereLead);
		}
		
		$messageId = $dadosMensagem['id'];
		$readStatusData = [
			"messaging_product" => "whatsapp",
			"status" => "read",
			"message_id" => $messageId
		];

		$chRead = curl_init("https://graph.facebook.com/v21.0/$phone_number_id/messages");
		curl_setopt($chRead, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($chRead, CURLOPT_POST, true);
		curl_setopt($chRead, CURLOPT_HTTPHEADER, [
			"Authorization: Bearer $token",
			"Content-Type: application/json"
		]);
		curl_setopt($chRead, CURLOPT_POSTFIELDS, json_encode($readStatusData));
		curl_exec($chRead);
		curl_close($chRead); 							
    							
		if($dadosMensagens['total'] >= 2){
			if(date('H:i:s') >= $horaInicio && date('H:i:s') <= $horaFim){
				$messageData = [
					"messaging_product" => "whatsapp",
					"recipient_type" => "individual",
					"to" => $dadosConfere['numero'],
					"type" => "text",
					"text" => [
						"preview_url" => false,
						"body" => "A sua mensagem já foi enviada para um de nossos corretores\ne em breve você será chamado em uma nova conversa.\n\n_Esta mensagem é automática!_"
					]
				];
			}else{
				$messageData = [
					"messaging_product" => "whatsapp",
					"recipient_type" => "individual",
					"to" => $dadosConfere['numero'],
					"type" => "text",
					"text" => [
						"preview_url" => false,
						"body" => "A sua mensagem já foi enviada para um de nossos corretores\n, devido ao horário o contato poder ser um pouco demorado.\n\n_Esta mensagem é automática!_"
					]
				];				
			}
		}else{
			if(date('H:i:s') >= $horaInicio && date('H:i:s') <= $horaFim){
				$messageData = [
					"messaging_product" => "whatsapp",
					"recipient_type" => "individual",
					"to" => $dadosConfere['numero'],
					"type" => "text",
					"text" => [
						"preview_url" => false,
						"body" => "Olá *{$dadosConfere['nome']}*! \n\nAgradecemos o seu contato! Um de nossos corretores irá\nchamar você em instantes em uma nova conversa.\n\n_Esta mensagem é automática!_"
					]
				];	
			}else{
				$messageData = [
					"messaging_product" => "whatsapp",
					"recipient_type" => "individual",
					"to" => $dadosConfere['numero'],
					"type" => "text",
					"text" => [
						"preview_url" => false,
						"body" => "Olá *{$dadosConfere['nome']}*! \n\nAgradecemos o seu contato! Um de nossos corretores irá chamar você em uma\nnova conversa. Devido ao horário este contato poderá ser mais demorado.\n\n_Esta mensagem é automática!_"
					]
				];					
			}

			if($confereRecorrencia == "F"){
				if($resultInsereLead == 1){
					$sqlLead = "SELECT * FROM leads WHERE codConversa = ".$dadosConfere['codConversa']." ORDER BY codLead DESC";
					$resultLead = $conn->query($sqlLead);
					$dadosLead = $resultLead->fetch_assoc();
			
					$sqlFila = "SELECT * FROM fila WHERE loginFila >= CONCAT(CURDATE(), ' ', '".$limiteCheckin."') AND loginFila < CONCAT(DATE_ADD(CURDATE(), INTERVAL 1 DAY), ' ', '".$limiteCheckin."') ORDER BY interacaoFila ASC, loginFila ASC";
					$resultFila = $conn->query($sqlFila);
					while($dadosFila = $resultFila->fetch_assoc()){
						$sqlInsere = "INSERT INTO filaLeads VALUES(0, ".$dadosFila['codFila'].", ".$dadosFila['codUsuario'].", ".$dadosLead['codLead'].", NULL)";
						$resultInsere = $conn->query($sqlInsere);	
					}
				}
			}
			
			chamarCurl($configUrlWa."wa/reseta.php");	
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

		if ($response === false) {
			echo 'Erro: ' . curl_error($ch);
		} else {
			$sqlUpdate = "UPDATE conversas SET recebe = 'T' WHERE codConversa = ".$dadosConfere['codConversa']."";
			$resultUpdate = $conn->query($sqlUpdate);
		}

		curl_close($ch);
		
	}
	
	$conn->close();

	function chamarCurl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_exec($ch);
		curl_close($ch);
	}	

	unlink($lockFile);	
?>
