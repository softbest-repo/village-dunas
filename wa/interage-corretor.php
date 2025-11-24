<?php
	include('../f/conf/config.php');
	include('info.php');					
	
	$sqlConfere = "SELECT * FROM conversas C inner join mensagens M on C.codConversa = M.codConversa inner join usuariosLeads UL on C.codConversa = UL.codConversa WHERE C.status = 'T' and C.envio = 'S' and UL.statusUsuarioLead = 'A' GROUP BY C.codConversa ORDER BY UL.codUsuarioLead ASC";
	$resultConfere = $conn->query($sqlConfere);
	while($dadosConfere = $resultConfere->fetch_assoc()){
			
 		$sqlMensagem = "SELECT * FROM mensagens WHERE codConversa = ".$dadosConfere['codConversa']." ORDER BY data DESC, codMensagem DESC LIMIT 0,1";
 		$resultMensagem = $conn->query($sqlMensagem);
 		$dadosMensagem = $resultMensagem->fetch_assoc();
 		
 		$sqlUsuarioLead = "SELECT * FROM usuariosLeads WHERE codConversa = ".$dadosConfere['codConversa']." ORDER BY codUsuarioLead DESC LIMIT 0,1";
 		$resultUsuarioLead = $conn->query($sqlUsuarioLead);
 		$dadosUsuarioLead = $resultUsuarioLead->fetch_assoc();
 		
 		$sqlLead = "SELECT * FROM leads WHERE codLead = ".$dadosUsuarioLead['codLead']." ORDER BY codLead DESC LIMIT 0,1";
 		$resultLead = $conn->query($sqlLead);
 		$dadosLead = $resultLead->fetch_assoc();
 		 		
 		$sqlConversaLead = "SELECT * FROM conversas WHERE codConversa = ".$dadosLead['codConversa']." ORDER BY codConversa DESC LIMIT 0,1";
 		$resultConversaLead = $conn->query($sqlConversaLead);
 		$dadosConversaLead = $resultConversaLead->fetch_assoc();
 		
 		$sqlMensagemLead = "SELECT * FROM mensagens WHERE codConversa = ".$dadosConversaLead['codConversa']." ORDER BY codMensagem ASC LIMIT 0,1";
 		$resultMensagemLead = $conn->query($sqlMensagemLead);
 		$dadosMensagemLead = $resultMensagemLead->fetch_assoc();

		if($dadosConversaLead['anuncio'] == "R" && $dadosConversaLead['source'] != ""){			
			$remarketing = "ok";
			$tituloRemarketing = $dadosConversaLead['source'];
		}else{
			$remarketing = "";
			$tituloRemarketing = "";				
		}

		$messageId = $dadosMensagem['id']; // Substituir por ID real da mensagem
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
					 		
 		if(strtolower($dadosMensagem['mensagem']) == "sim" || strtolower($dadosMensagem['mensagem']) == "yes" || strtolower($dadosMensagem['mensagem']) == "aceito" || strtolower($dadosMensagem['mensagem']) == "aceita" || strtolower($dadosMensagem['mensagem']) == "aceitar" || strtolower($dadosMensagem['mensagem']) == "aceitar lead"){

			if($dadosLead['tipoLead'] == "RM"){

				if($dadosConversaLead['source'] == "WH"){
					$origemManual = "WhatsApp";
				}else if($dadosConversaLead['source'] == "IN"){
					$origemManual = "Instagram";
				}else if($dadosConversaLead['source'] == "ES"){
					$origemManual = "Escritório";
				}else if($dadosConversaLead['source'] == "FA"){
					$origemManual = "Facebook";
				}else if($dadosConversaLead['source'] == "SI"){
					$origemManual = "Site";
				}else if($dadosConversaLead['source'] == "R"){
					$origemManual = "Remarketing";
				}else if($dadosConversaLead['source'] == "ID"){
					$origemManual = "Indicação";
				}else{
					$origemManual = $dadosConversaLead['source'];
				}
				
				$messageData1 = [
					"messaging_product" => "whatsapp",
					"recipient_type" => "individual",
					"to" => $dadosConfere['numero'],
					"type" => "text",
					"text" => [
						"preview_url" => false,
						"body" => "*Lead ID: ".$dadosUsuarioLead['codLead']."*\n\n*Nome*\n".$dadosConversaLead['nome']."\n\n*Origem*\n".$origemManual."\n\n*Briefing*\n".$dadosMensagemLead['mensagem']."\n\n*Clique aqui para confirmar o lead*\n".$configUrlWa."wa/aceitar-lead.php?ref=".$dadosUsuarioLead['codUsuarioLead']."\n\n_Esta mensagem é automática!_"
					]
				];	
			}else{
				if($dadosConversaLead['anuncio'] == "T"){
					$origem = "Anúncio";
				}else{
					$origem = "Orgânico";
				}

				if($remarketing == "ok"){								
					$messageData1 = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => $dadosConfere['numero'],
						"type" => "text",
						"text" => [
							"preview_url" => false,
							"body" => "*Lead ID: ".$dadosUsuarioLead['codLead']."*\n\n*Nome*\n".$dadosConversaLead['nome']."\n\n*Origem*\nRemarketing\n\n*Anúncio*\n".$tituloRemarketing."\n\n*Mensagem*\n".$dadosMensagemLead['mensagem']."\n\n*Clique aqui para confirmar o lead*\n".$configUrlWa."wa/aceitar-lead.php?ref=".$dadosUsuarioLead['codUsuarioLead']."\n\n_Esta mensagem é automática!_"
						]
					];
				}else{
					if($dadosConversaLead['source'] != ""){
						$messageData1 = [
							"messaging_product" => "whatsapp",
							"recipient_type" => "individual",
							"to" => $dadosConfere['numero'],
							"type" => "text",
							"text" => [
								"preview_url" => false,
								"body" => "*Lead ID: ".$dadosUsuarioLead['codLead']."*\n\n*Nome*\n".$dadosConversaLead['nome']."\n\n*Origem*\n".$origem."\n\n*Link Origem*\n".$dadosConversaLead['source']."\n\n*Mensagem*\n".$dadosMensagemLead['mensagem']."\n\n*Clique aqui para confirmar o lead*\n".$configUrlWa."wa/aceitar-lead.php?ref=".$dadosUsuarioLead['codUsuarioLead']."\n\n_Esta mensagem é automática!_"
							]
						];
					}else{
						$messageData1 = [
							"messaging_product" => "whatsapp",
							"recipient_type" => "individual",
							"to" => $dadosConfere['numero'],
							"type" => "text",
							"text" => [
								"preview_url" => false,
								"body" => "*Lead ID: ".$dadosUsuarioLead['codLead']."*\n\n*Nome*\n".$dadosConversaLead['nome']."\n\n*Origem*\n".$origem."\n\n*Mensagem*\n".$dadosMensagemLead['mensagem']."\n\n*Clique aqui para confirmar o lead*\n".$configUrlWa."wa/aceitar-lead.php?ref=".$dadosUsuarioLead['codUsuarioLead']."\n\n_Esta mensagem é automática!_"
							]
						];				
					}					
				}
			}
			
			$status = "F";			
			
			$response1 = sendMessage($conn, $phone_number_id, $token, $messageData1, $status, $dadosConfere['codConversa'], $dadosUsuarioLead['codLead'], $dadosUsuarioLead['codUsuarioLead']);			
		}else
		if(strtolower($dadosMensagem['mensagem']) == "não" || strtolower($dadosMensagem['mensagem']) == "nao" || strtolower($dadosMensagem['mensagem']) == "recuso" || strtolower($dadosMensagem['mensagem']) == "recusa" || strtolower($dadosMensagem['mensagem']) == "recusar" || strtolower($dadosMensagem['mensagem']) == "recusar lead"){
		
			$messageData1 = [
				"messaging_product" => "whatsapp",
				"recipient_type" => "individual",
				"to" => $dadosConfere['numero'],
				"type" => "text",
				"text" => [
					"preview_url" => false,
					"body" => "O lead *ID: ".$dadosUsuarioLead['codLead']."* não foi aceito!\n\n_Esta mensagem é automática!_"
				]
			];

			$status = "F";
			
			$response1 = sendMessage($conn, $phone_number_id, $token, $messageData1, $status, $dadosConfere['codConversa'], $dadosUsuarioLead['codLead'], $dadosUsuarioLead['codUsuarioLead']);			

			$sqlUpdateUL = "UPDATE usuariosLeads SET statusUsuarioLead = 'F', interacaoUsuarioLead = '".date('Y-m-d H:i:s')."' WHERE codUsuarioLead = ".$dadosUsuarioLead['codUsuarioLead']."";
			$resultUpdateUL = $conn->query($sqlUpdateUL);

			$sqlUpdateLead = "UPDATE leads SET envioLead = NULL WHERE codLead = ".$dadosLead['codLead']."";
			$resultUpdateLead = $conn->query($sqlUpdateLead);
			
			chamarCurl($configUrlWa."wa/roleta.php");			
		}else{
			$messageData1 = [
				"messaging_product" => "whatsapp",
				"recipient_type" => "individual",
				"to" => $dadosConfere['numero'],
				"type" => "text",
				"text" => [
					"preview_url" => false,
					"body" => "*Não entendi sua resposta*\n\nVocê precisa selecionar umas *opções* enviadas *abaixo*.\n\n_Esta mensagem é automática!_"
				]
			];

			$messageData2 = [
				"messaging_product" => "whatsapp",
				"recipient_type" => "individual",
				"to" => $dadosConfere['numero'],
				"type" => "template",
				"template" => [
					"name" => "envia_corretor_curto",
					"language" => ["code" => "pt_BR"]
				]			
			];	
						
			$status = "T";

			sendMessage($conn, $phone_number_id, $token, $messageData1, $status, $dadosConfere['codConversa'], $dadosUsuarioLead['codLead'], $dadosUsuarioLead['codUsuarioLead']);			
			sendMessage($conn, $phone_number_id, $token, $messageData2, $status, $dadosConfere['codConversa'], $dadosUsuarioLead['codLead'], $dadosUsuarioLead['codUsuarioLead']);	
			
			$sqlMensagem = "UPDATE mensagens SET respondida = 'T' WHERE codMensagem = ".$dadosMensagem['codMensagem']."";
			$resultMensagem = $conn->query($sqlMensagem);		
		}
			
	}

	function sendMessage($conn, $phone_number_id, $token, $messageData, $status, $codConversa, $codLead, $codUsuarioLead) {	
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
?>
