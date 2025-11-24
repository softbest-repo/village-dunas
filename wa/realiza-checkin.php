<?php
	function sendMessage($conn, $phone_number_id, $token, $messageData, $status, $codConversa) {	
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
			$sqlUpdate = "UPDATE conversas SET status = '".$status."' WHERE codConversa = ".$codConversa."";
			$resultUpdate = $conn->query($sqlUpdate);
		}

		curl_close($ch);	
	}

		function padronizarNumeroCom9($numero) {
			$numero = preg_replace('/\D/', '', $numero);

			if (substr($numero, 0, 2) === '55') {
				$numero = substr($numero, 2);
			}

			if (strlen($numero) < 10) {
				return $numero;
			}

			$ddd = substr($numero, 0, 2);
			$telefone = substr($numero, 2);

			$prefixosSem9 = ['2000', '2100', '2200', '2400', '3300']; 

			if (strlen($telefone) === 9 && $telefone[0] === '9') {
				return $ddd . $telefone;
			}

			if (strlen($telefone) === 8) {
				foreach ($prefixosSem9 as $prefixo) {
					if (strpos($telefone, $prefixo) === 0) {
						return $ddd . $telefone;
					}
				}

				return $ddd . '9' . $telefone;
			}

			return $ddd . $telefone;
		}
		
		include('../f/conf/config.php');
		include('info.php');
								
		$sqlConfere = "SELECT * FROM conversas C INNER JOIN mensagens M ON C.codConversa = M.codConversa WHERE C.status = 'T' AND C.envio = 'I' AND M.respondida = 'F' AND DATE(C.data) = CURDATE() GROUP BY C.numero ORDER BY C.codConversa ASC";
		$resultConfere = $conn->query($sqlConfere);
		while($dadosConfere = $resultConfere->fetch_assoc()){
				
			$sqlMensagem = "SELECT * FROM mensagens WHERE codConversa = ".$dadosConfere['codConversa']." ORDER BY data DESC, codMensagem DESC LIMIT 0,1";
			echo $sqlMensagem;
			$resultMensagem = $conn->query($sqlMensagem);
			$dadosMensagem = $resultMensagem->fetch_assoc();

			$codUsuario = "";
			
			$sqlConfereU = "SELECT U.* FROM usuarios U INNER JOIN usuariosLogins UL ON U.codUsuario = UL.codUsuario AND DATE(UL.dataUsuarioLogin) = CURDATE() WHERE REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(celularUsuario, '(', ''), ')', ''), ' ', ''), '-', ''), '.', '') = '".padronizarNumeroCom9($dadosConfere['numero'])."' and U.statusUsuario = 'T' and U.tipoUsuario = 'C' ORDER BY U.codUsuario ASC";
			$resultConfereU = $conn->query($sqlConfereU);
			$dadosConfereU = $resultConfereU->fetch_assoc();
			
			$codUsuario = $dadosConfereU['codUsuario'];
			
			if($codUsuario == ""){
				
				$sqlUsuario = "SELECT * FROM usuarios WHERE REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(celularUsuario, '(', ''), ')', ''), ' ', ''), '-', ''), '.', '') = '".padronizarNumeroCom9($dadosConfere['numero'])."' ORDER BY codUsuario DESC LIMIT 1";
				$resultUsuario = $conn->query($sqlUsuario);
				$dadosUsuario = $resultUsuario->fetch_assoc(); 		
							
				if(strtolower($dadosMensagem['mensagem']) == "sim" || strtolower($dadosMensagem['mensagem']) == "yes" || strtolower($dadosMensagem['mensagem']) == "check" || strtolower($dadosMensagem['mensagem']) == "checkin" || strtolower($dadosMensagem['mensagem']) == "check in" || strtolower($dadosMensagem['mensagem']) == "check-in"){
					
					$messageData1 = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => $dadosConfere['numero'],
						"type" => "text",
						"text" => [
							"preview_url" => false,
							"body" => "*Check-in realizado com sucesso!*\n\n_Esta mensagem é automática!_"
						]
					];
					
					$status = "F";			
					
					$response1 = sendMessage($conn, $phone_number_id, $token, $messageData1, $status, $dadosConfere['codConversa']);		
				
					$sqlInsere = "INSERT INTO usuariosLogins VALUES(0, ".$dadosUsuario['codUsuario'].", '".date('Y-m-d H:i:s')."')";
					$resultInsere = $conn->query($sqlInsere);
					
					if($resultInsere == 1){
											
						$sqlFila = "SELECT * FROM fila WHERE codUsuario = ".$dadosUsuario['codUsuario']." ORDER BY codUsuario ASC LIMIT 0,1";
						$resultFila = $conn->query($sqlFila);
						
						if($resultFila && $dadosFila = $resultFila->fetch_assoc()) {
							$sqlUpdate = "UPDATE fila SET loginFila = '".date('Y-m-d H:i:s')."', envioFila = NULL, interacaoFila = NULL WHERE codUsuario = ".$dadosUsuario['codUsuario']."";
							$resultUpdate = $conn->query($sqlUpdate);
						}else{
							$sqlInsere = "INSERT INTO fila VALUES(0, ".$dadosUsuario['codUsuario'].", NULL, NULL, '".date('Y-m-d H:i:s')."')";
							$resultInsere = $conn->query($sqlInsere);	

							$sqlFila = "SELECT * FROM fila WHERE codUsuario = ".$dadosUsuario['codUsuario']." ORDER BY codUsuario ASC LIMIT 0,1";
							$resultFila = $conn->query($sqlFila);
							$dadosFila = $resultFila->fetch_assoc();								
						}
						
						if($resultInsere == 1 || $resultUpdate == 1){
							$sqlLeads = "SELECT * FROM leads WHERE statusLead = 'T' ORDER BY recebidoLead ASC";
							$resultLeads = $conn->query($sqlLeads);
							while($dadosLeads = $resultLeads->fetch_assoc()){
								$sqlInsere = "INSERT INTO filaLeads VALUES(0, ".$dadosFila['codFila'].", ".$dadosUsuario['codUsuario'].", ".$dadosLeads['codLead'].", NULL)";
								$resultInsere = $conn->query($sqlInsere);	
							}
						}
					}				
				}else{
					$messageData1 = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => $dadosConfere['numero'],
						"type" => "text",
						"text" => [
							"preview_url" => false,
							"body" => "*Não entendi sua resposta*\n\nVocê precisa clicar no botão Check-in para confirmar!\n\n_Esta mensagem é automática!_"
						]
					];

					$messageData2 = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => $dadosConfere['numero'],
						"type" => "template",
						"template" => [
							"name" => "check_in_diario_menor",
							"language" => ["code" => "pt_BR"]
						]			
					];	
								
					$status = "T";

					sendMessage($conn, $phone_number_id, $token, $messageData1, $status, $dadosConfere['codConversa']);			
					sendMessage($conn, $phone_number_id, $token, $messageData2, $status, $dadosConfere['codConversa']);	
					
					$sqlMensagem = "UPDATE mensagens SET respondida = 'T' WHERE codMensagem = ".$dadosMensagem['codMensagem']."";
					$resultMensagem = $conn->query($sqlMensagem);		
				}
			}
				
		}
				
		echo json_encode(['success' => true, 'message' => 'Sucesso']);						
		
		$conn->close();