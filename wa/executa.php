<?php
		error_reporting(E_ALL);
		ini_set('display_errors', 1);

		include('info.php');
		include('../f/conf/config.php');

		$lockFile = 'cron-reseta.lock';
		
		chamarCurl($configUrlWa."wa/reseta.php");

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

		function formatarNumeroTelefoneSem($numero) {
			$numero = preg_replace('/\D+/', '', $numero);

			// Remove o código do país '55' se existir
			if (substr($numero, 0, 2) === '55') {
				$numero = substr($numero, 2);
			}

			// Adiciona o 9 se necessário para números de 10 dígitos (sem o 9)
			if (strlen($numero) == 10) {
				$numero = substr_replace($numero, '9', 2, 0);
			}

			// Formata para (DD) 9XXXX-XXXX
			if (preg_match('/^(\d{2})(\d{5})(\d{4})$/', $numero, $matches)) {
				return "({$matches[1]}) {$matches[2]}-{$matches[3]}";
			}

			// Caso não bata o padrão, retorna o número puro
			return $numero;
		}

		function formatarNumeroTelefone($numero) {
			$numero = preg_replace('/\D+/', '', $numero);

			if (substr($numero, 0, 2) === '55') {
				$ddd_e_numero = substr($numero, 2); // Remove o código do país
				if (strlen($ddd_e_numero) == 10) {
					$ddd_e_numero = substr_replace($ddd_e_numero, '9', 2, 0);
				}
				$numero = '55' . $ddd_e_numero;
			}

			if (preg_match('/^55(\d{2})(\d{5})(\d{4})$/', $numero, $matches)) {
				return "+55 ({$matches[1]}) {$matches[2]}-{$matches[3]}";
			}

			return $numero;
		}

		$sqlLogWhats = "SELECT * FROM logWhats WHERE status = 'T' ORDER BY data_recebimento ASC";
		$resultLogWhats = $conn->query($sqlLogWhats);
		if (!$resultLogWhats) {
			die("Erro na consulta: " . $conn->error);
		}
		while($dadosLogWhats = $resultLogWhats->fetch_assoc()){		

			$data = json_decode($dadosLogWhats['json_recebido'], true);
				
			foreach ($data['entry'] as $entry) {
				$idWa = $entry['id'];

				foreach ($entry['changes'] as $change) {
					$value = $change['value'];

					$produto = $value['messaging_product'];

					foreach ($value['contacts'] as $contact) {
						$nome = $contact['profile']['name'];
						$numero = $contact['wa_id'];
					}

					foreach ($value['messages'] as $message) {
						$id = $message['id'];
						$dataM = $message['timestamp'];
						$tipo = $message['type'];
						if($tipo == "button"){
							$texto = $message['button']['text'];
						}else{
							$texto = $message['text']['body'];
						}

						if (isset($message['referral'])) {
							$isAd = "T";
							$sourceUrl = $message['referral']['source_url'];
						} else {
							$isAd = "F";
							$sourceUrl = null;
						}	

						if (isset($message['context'])) {
							$idRespondida = $message['context']['id'];
							$fromRespondida = $message['context']['from'];
						} else {
							$idRespondida = null;
							$fromRespondida = null;
						}
					}
				}
			}

			$sqlConfere = "SELECT * FROM conversas WHERE numero = '".$numero."' ORDER BY codConversa DESC LIMIT 0,1";
			$resultConfere = $conn->query($sqlConfere);
			$dadosConfere = $resultConfere->fetch_assoc();
			
			$sqlUsuario = "SELECT * FROM usuarios WHERE REPLACE(REPLACE(REPLACE(REPLACE(REPLACE(celularUsuario, '(', ''), ')', ''), ' ', ''), '-', ''), '.', '') = '".padronizarNumeroCom9($numero)."' and leadsUsuario = 'S' and statusUsuario = 'T' ORDER BY codUsuario DESC LIMIT 1";
			$resultUsuario = $conn->query($sqlUsuario);
			$dadosUsuario = $resultUsuario->fetch_assoc();

			$dataMensagem = (new DateTime())->setTimestamp(timestamp: $dataM);			
			$dataMensagem = $dataMensagem->format('Y-m-d H:i:s');	
			$timestampUnix = strtotime($dataMensagem);
			$currentTimestamp = strtotime($dadosConfere['dataAtt']);
			$timeDifference = $timestampUnix - $currentTimestamp;
											
			if($dadosUsuario['codUsuario'] != "" && $dadosConfere['codConversa'] == "" || $dadosUsuario['codUsuario'] != "" && $dadosConfere['status'] == "F"){
				
				echo "entrou usuario";
				
				$numeroProcessado = str_replace(["(", ")", "-", " "], "", $dadosUsuario['celularUsuario']);

				if (strlen($numeroProcessado) == 11 && substr($numeroProcessado, 2, 1) == "9") {
					$numeroProcessado = substr($numeroProcessado, 0, 2) . substr($numeroProcessado, 3);
				}
						
				if(strtolower($texto) == "sair" || strtolower($texto) == "exit" || strtolower($texto) == "sair lead" || strtolower($texto) == "exit lead"){

					$messageId = $id;
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
				
					$sqlUpdate = "UPDATE fila SET loginFila = NULL WHERE codUsuario = ".$dadosUsuario['codUsuario']."";
					$resultUpdate = $conn->query($sqlUpdate);
					
					$messageData = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => $numeroProcessado,
						"type" => "text",
						"text" => [
							"preview_url" => false,
							"body" => "Você não receberá mais Leads hoje!\n\n_Esta mensagem é automática_"
						]
					];							

					$sqlLogWhatsUp = "UPDATE logWhats SET status = 'F' WHERE id = ".$dadosLogWhats['id']."";
					$resultLogWhatsUp = $conn->query($sqlLogWhatsUp);
				}else
				if(strtolower($texto) == "entrar" || strtolower($texto) == "receber" || strtolower($texto) == "entrar lead" || strtolower($texto) == "receber lead"){

					$messageId = $id;
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
				
					$sqlUpdate = "UPDATE fila SET loginFila = '".date('Y-m-d H:i:s')."' WHERE codUsuario = ".$dadosUsuario['codUsuario']."";
					$resultUpdate = $conn->query($sqlUpdate);
					
					$messageData = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => $numeroProcessado,
						"type" => "text",
						"text" => [
							"preview_url" => false,
							"body" => "Você agora receberá leads!\n\n_Esta mensagem é automática_"
						]
					];							

					$sqlLogWhatsUp = "UPDATE logWhats SET status = 'F' WHERE id = ".$dadosLogWhats['id']."";
					$resultLogWhatsUp = $conn->query($sqlLogWhatsUp);
				}else{
					$messageId = $id;
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
				
					$messageData = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => $numeroProcessado,
						"type" => "text",
						"text" => [
							"preview_url" => false,
							"body" => "Olá *{$dadosUsuario['nomeUsuario']}*! \n\nO seu número neste conversa é reservado somente para interações com o sistema.\n\n_Esta mensagem é automática_"
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

				if ($response === false) {
					echo 'Erro: ' . curl_error($ch);
				}
				
				curl_close($ch);
				
				$sqlLogWhatsUp = "UPDATE logWhats SET status = 'F' WHERE id = ".$dadosLogWhats['id']."";
				$resultLogWhatsUp = $conn->query($sqlLogWhatsUp);
				
			}else
			if($dadosUsuario['codUsuario'] != "" && $dadosConfere['status'] == "T" && $dadosConfere['envio'] == "S"){
				
				echo "entrou interage corretor";
				
				$messageId = $id;
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
									
				$sqlConversaLead = "SELECT DISTINCT C.codConversa FROM conversas C INNER JOIN usuariosLeads UL ON C.codConversa = UL.codConversa LEFT JOIN mensagens M ON C.codConversa = M.codConversa WHERE C.numero = '".$numero."' and C.status = 'T' AND UL.statusUsuarioLead = 'A' AND (M.mensagem NOT REGEXP '[[:<:]](sim|yes|aceitar|aceitar lead|aceito|aceita|não|nao|recuso|recusa|recusar|recusar lead)[[:>:]]' OR M.mensagem IS NULL) ORDER BY UL.codUsuarioLead ASC LIMIT 0,1";
				$resultConversaLead = $conn->query($sqlConversaLead);
				$dadosConversaLead = $resultConversaLead->fetch_assoc();
				
				if ($dadosConversaLead && isset($dadosConversaLead['codConversa']) && $dadosConversaLead['codConversa'] != "") {
							
					$sqlMensagem = "INSERT INTO mensagens VALUES(0, ".$dadosConversaLead['codConversa'].", '".$id."', '".$texto."', '".$tipo."', '".$dataMensagem."', 'C', 'F')";
					$resultMensagem = $conn->query($sqlMensagem);
					
					if($resultMensagem == 1){										
						$sqlLogWhatsUp = "UPDATE logWhats SET status = 'F' WHERE id = ".$dadosLogWhats['id']."";
						$resultLogWhatsUp = $conn->query($sqlLogWhatsUp);

						chamarCurl($configUrlWa."wa/interage-corretor.php");
					}
				}else{
					$sqlLogWhatsUp = "UPDATE logWhats SET status = 'F' WHERE id = ".$dadosLogWhats['id']."";
					$resultLogWhatsUp = $conn->query($sqlLogWhatsUp);
				}
			}else
			if($dadosUsuario['codUsuario'] != "" && $dadosConfere['status'] == "T" && $dadosConfere['envio'] == "I"){
				
				echo "entrou check-in";
					
				$messageId = $id;
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
						
				$sqlMensagem = "INSERT INTO mensagens VALUES(0, ".$dadosConfere['codConversa'].", '".$id."', '".$texto."', '".$tipo."', '".$dataMensagem."', 'C', 'F')";
				$resultMensagem = $conn->query($sqlMensagem);
				
				if($resultMensagem == 1){
					$sqlLogWhatsUp = "UPDATE logWhats SET status = 'F' WHERE id = ".$dadosLogWhats['id']."";
					$resultLogWhatsUp = $conn->query($sqlLogWhatsUp);

					sleep(3);
					
					chamarCurl($configUrlWa."wa/realiza-checkin.php"); 
				}
			}else{
				
				echo "entrou cliente";

				if($idRespondida != ""){
					$sqlMensagemRemarketing = "SELECT * FROM mensagens WHERE id = '".$idRespondida."' ORDER BY codMensagem DESC LIMIT 0,1";
					$resultMensagemRemarketing = $conn->query($sqlMensagemRemarketing);
					$dadosMensagemRemarketing = $resultMensagemRemarketing->fetch_assoc();

					if($dadosMensagemRemarketing['codMensagem'] != ""){
						$isAd = "R";
						$sourceUrl = $dadosMensagemRemarketing['mensagem'];
					}
				}

				$sqlNegociacoes = "SELECT * FROM negociacoes WHERE telefoneNegociacao = '".formatarNumeroTelefone($numero)."' or telefoneNegociacao = '".formatarNumeroTelefoneSem($numero)."' ORDER BY codNegociacao DESC LIMIT 0,1";
				$resultNegociacoes = $conn->query($sqlNegociacoes);
				$dadosNegociacoes = $resultNegociacoes->fetch_assoc();

				// $sqlDisparo = "SELECT * FROM disparosClientes DC inner join disparos D on DC.codDisparo = D.codDisparo  WHERE DC.codNegociacao = '".$dadosNegociacoes['codNegociacao']."' ORDER BY DC.codDisparoCliente DESC LIMIT 0,1";
				// $resultDisparo = $conn->query($sqlDisparo);
				// $dadosDisparo = $resultDisparo->fetch_assoc(); 

				// if (isset($dadosDisparo['dataDisparo']) && strtotime($dadosDisparo['dataDisparo']) >= strtotime('-7 days')) {
				// 	$isAd = "R";
				// 	$sourceUrl = $dadosDisparo['descricaoDisparo'];
				// }

				if($dadosConfere['codConversa'] != ""){
							
					if($timeDifference >= 21600 || $isAd == "T" || $isAd == "R"){
						$sqlInsere = "INSERT INTO conversas VALUES(0, '".$idWa."', '".$produto."', '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $nome))."', '".$numero."', '".$dataMensagem."', '".$dataMensagem."', '".$isAd."', '".$sourceUrl."', 'C', 'F', 'T')";
						$resultInsere = $conn->query($sqlInsere);
						$novoIdConversa = $conn->insert_id;
						
						if($resultInsere == 1){				
							$sqlMensagem = "INSERT INTO mensagens VALUES(0, ".$novoIdConversa.", '".$id."', '".$texto."', '".$tipo."', '".$dataMensagem."', 'C', 'F')";
							$resultMensagem = $conn->query($sqlMensagem);
							
							if($resultMensagem == 1){ 											
								$sqlLogWhatsUp = "UPDATE logWhats SET status = 'F' WHERE id = ".$dadosLogWhats['id']."";
								$resultLogWhatsUp = $conn->query($sqlLogWhatsUp);

								chamarCurl($configUrlWa."wa/interage.php");  					
							}
						}
					}else{				
						$sqlUpdateCon = "UPDATE conversas SET status = 'F' WHERE codConversa = ".$dadosConfere['codConversa']."";
						$resultUpdateCon = $conn->query($sqlUpdateCon);
						
						if($resultUpdateCon == 1){ 		

							$sqlMensagem = "INSERT INTO mensagens VALUES(0, ".$dadosConfere['codConversa'].", '".$id."', '".$texto."', '".$tipo."', '".$dataMensagem."', 'C', 'F')";
							$resultMensagem = $conn->query($sqlMensagem);
							
							if($resultMensagem == 1){									
								$sqlLogWhatsUp = "UPDATE logWhats SET status = 'F' WHERE id = ".$dadosLogWhats['id']."";
								$resultLogWhatsUp = $conn->query($sqlLogWhatsUp);

								chamarCurl($configUrlWa."wa/interage.php"); 					
							}	
						
						}				
					}
				}else{				
					$dataMensagem = (new DateTime())->setTimestamp($dataM);			
					$dataMensagem = $dataMensagem->format('Y-m-d H:i:s');			
					
					$sqlInsere = "INSERT INTO conversas VALUES(0, '".$idWa."', '".$produto."', '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $nome))."', '".$numero."', '".$dataMensagem."', '".$dataMensagem."', '".$isAd."', '".$sourceUrl."', 'C', 'F', 'T')";
					$resultInsere = $conn->query($sqlInsere);
					
					if($resultInsere == 1){				
						
						$sqlConversa = "SELECT * FROM conversas WHERE idWa = ".$idWa." and numero = ".$numero." ORDER BY codConversa DESC LIMIT 0,1";
						$resultConversa = $conn->query($sqlConversa);
						$dadosConversa = $resultConversa->fetch_assoc();
						
						$sqlMensagem = "INSERT INTO mensagens VALUES(0, ".$dadosConversa['codConversa'].", '".$id."', '".$texto."', '".$tipo."', '".$dataMensagem."', 'C', 'F')";
						$resultMensagem = $conn->query($sqlMensagem);
						
						if($resultMensagem == 1){
							$sqlLogWhatsUp = "UPDATE logWhats SET status = 'F' WHERE id = ".$dadosLogWhats['id']."";
							$resultLogWhatsUp = $conn->query($sqlLogWhatsUp);
			
							chamarCurl($configUrlWa."wa/interage.php");;  					
						}
					}			
				}	
			}						
		}

		$conn->close();
	
		http_response_code(200);

		function chamarCurl($url) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($ch, CURLOPT_TIMEOUT, 10);
			curl_exec($ch);
			curl_close($ch);
		}			
?>
