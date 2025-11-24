<?php
	include('info.php');	
	
	if(isset($_GET['ref'])){
		include('../f/conf/config.php');

		$sqlUsuarioLead = "SELECT * FROM usuariosLeads WHERE codUsuarioLead = ".$_GET['ref']." ORDER BY codUsuarioLead DESC LIMIT 0,1";
		$resultUsuarioLead = $conn->query($sqlUsuarioLead);
		$dadosUsuarioLead = $resultUsuarioLead->fetch_assoc();

		$sqlConfereUltimoLead = "SELECT * FROM usuariosLeads WHERE codLead = ".$dadosUsuarioLead['codLead']." ORDER BY codUsuarioLead DESC LIMIT 0,1";
		$resultConfereUltimoLead = $conn->query($sqlConfereUltimoLead);
		$dadosConfereUltimoLead = $resultConfereUltimoLead->fetch_assoc();

		$sqlLead = "SELECT * FROM leads WHERE codLead = ".$dadosUsuarioLead['codLead']." ORDER BY codLead DESC";
		$resultLead = $conn->query($sqlLead);
		$dadosLead = $resultLead->fetch_assoc();

		$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosUsuarioLead['codUsuario']." ORDER BY codUsuario DESC LIMIT 0,1";
		$resultUsuario = $conn->query($sqlUsuario);
		$dadosUsuario = $resultUsuario->fetch_assoc();

		if($dadosConfereUltimoLead['codUsuario'] == $dadosUsuarioLead['codUsuario']){

			$sqlConversa = "SELECT * FROM conversas WHERE codConversa = ".$dadosLead['codConversa']." ORDER BY codConversa ASC";
			$resultConversa = $conn->query($sqlConversa);
			$dadosConversa = $resultConversa->fetch_assoc();

			$sqlMensagemLead = "SELECT * FROM mensagens WHERE codConversa = ".$dadosConversa['codConversa']." ORDER BY codMensagem ASC LIMIT 0,1";
			$resultMensagemLead = $conn->query($sqlMensagemLead);
			$dadosMensagemLead = $resultMensagemLead->fetch_assoc();	
			
			if($dadosConversa['anuncio'] == "R" && $dadosConversa['source'] != ""){			
				$remarketing = "ok";
				$tituloRemarketing = $dadosConversa['source'];
			}else{
				$remarketing = "";
				$tituloRemarketing = "";				
			}
 							
			if($dadosLead['statusLead'] == "T" || $dadosLead['statusLead'] == "R" || $dadosLead['statusLead'] == "M"){	
				
				function formatarNumeroTelefone($numero) {
					// Remove caracteres não numéricos
					$numero = preg_replace('/\D+/', '', $numero);
		
					// Verifica se o número começa com 55 (código do Brasil)
					if (substr($numero, 0, 2) === '55') {
						// Adiciona o dígito 9 ao número se ele não tiver 9 dígitos no celular
						$ddd_e_numero = substr($numero, 2); // Remove o código do país
						if (strlen($ddd_e_numero) == 10) {
							// Adiciona o dígito 9
							$ddd_e_numero = substr_replace($ddd_e_numero, '9', 2, 0);
						}
						$numero = '55' . $ddd_e_numero;
					}
		
					// Formata o número no padrão +55 (XX) 9XXXX-XXXX
					if (preg_match('/^55(\d{2})(\d{5})(\d{4})$/', $numero, $matches)) {
						return "+55 ({$matches[1]}) {$matches[2]}-{$matches[3]}";
					}
		
					// Retorna o número original se não puder formatar
					return $numero;
				}
										
				$numero = $dadosUsuario['celularUsuario'];
				$numero = str_replace("(", "", $numero);
				$numero = str_replace(")", "", $numero);
				$numero = str_replace(" ", "", $numero);
				$numero = str_replace("-", "", $numero);

				if($dadosLead['statusLead'] == "T"){

					$messageData = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => "55".$numero,
						"type" => "text",
						"text" => [
							"preview_url" => false,
							"body" => "Lead *ID: ".$dadosUsuarioLead['codLead']."* confirmado 👏!\n\nNúmero: ".formatarNumeroTelefone($dadosConversa['numero'])."\n\n_Esta mensagem é automática!_"
						]
					];	
				}else
				if($dadosLead['statusLead'] == "R"){
					if($dadosConversa['anuncio'] == "T"){
						$origem = "Anúncio";
					}else{
						$origem = "Orgânico";
					}

					if($remarketing == "ok"){								
						$messageData = [
							"messaging_product" => "whatsapp",
							"recipient_type" => "individual",
							"to" => "55".$numero,
							"type" => "text",
							"text" => [
								"preview_url" => false,
								"body" => "Olá *".$dadosUsuario['nomeUsuario']."*\n\n Você recebeu um Lead Recorrente *ID: ".$dadosUsuarioLead['codLead']."* 👏!\n\n*Nome*\n".$dadosConversa['nome']."\n\n*Origem*\nRemarketing\n\n*Anúncio*\n".$tituloRemarketing."\n\n*Mensagem*\n".$dadosMensagemLead['mensagem']."\n\n*Número*: ".formatarNumeroTelefone($dadosConversa['numero'])."\n\n_Esta mensagem é automática!_"
							]
						];
					}else{
						if($dadosConversa['source'] != ""){					
							$messageData = [
								"messaging_product" => "whatsapp",
								"recipient_type" => "individual",
								"to" => "55".$numero,
								"type" => "text",
								"text" => [
									"preview_url" => false,
									"body" => "Olá *".$dadosUsuario['nomeUsuario']."*\n\n Você recebeu um Lead Recorrente *ID: ".$dadosUsuarioLead['codLead']."* 👏!\n\n*Nome*\n".$dadosConversa['nome']."\n\n*Origem*\n".$origem."\n\n*Link Origem*\n".$dadosConversa['source']."\n\n*Mensagem*\n".$dadosMensagemLead['mensagem']."\n\n*Número*: ".formatarNumeroTelefone($dadosConversa['numero'])."\n\n_Esta mensagem é automática!_"
								]
							];	
						}else{
							$messageData = [
								"messaging_product" => "whatsapp",
								"recipient_type" => "individual",
								"to" => "55".$numero,
								"type" => "text",
								"text" => [
									"preview_url" => false,
									"body" => "Olá *".$dadosUsuario['nomeUsuario']."*\n\n Você recebeu um Lead Recorrente *ID: ".$dadosUsuarioLead['codLead']."* 👏!\n\n*Nome*\n".$dadosConversa['nome']."\n\n*Origem*\n".$origem."\n\n*Mensagem*\n".$dadosMensagemLead['mensagem']."\n\n*Número*: ".formatarNumeroTelefone($dadosConversa['numero'])."\n\n_Esta mensagem é automática!_"
								]
							];						
						}	
					}				
				}else
				if($dadosLead['statusLead'] == "M"){
					if($dadosConversa['source'] == "WH"){
						$origemManual = "WhatsApp";
					}else if($dadosConversa['source'] == "IN"){
						$origemManual = "Instagram";
					}else if($dadosConversa['source'] == "ES"){
						$origemManual = "Escritório";
					}else if($dadosConversa['source'] == "FA"){
						$origemManual = "Facebook";
					}else if($dadosConversa['source'] == "SI"){
						$origemManual = "Site";
					}else if($dadosConversa['source'] == "R"){
						$origemManual = "Remarketing";
					}else if($dadosConversa['source'] == "ID"){
						$origemManual = "Indicação";
					}else{
						$origemManual = $dadosConversa['source'];
					}
					$messageData = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => "55".$numero,
						"type" => "text",
						"text" => [
							"preview_url" => false,
							"body" => "Olá *".$dadosUsuario['nomeUsuario']."*\n\n Você recebeu um Lead Direcionado *ID: ".$dadosUsuarioLead['codLead']."* 👏!\n\n*Nome*\n".$dadosConversa['nome']."\n\n*Origem*\n".$origemManual."\n\n*Briefing*\n".$dadosMensagemLead['mensagem']."\n\n*Número*: ".formatarNumeroTelefone($dadosConversa['numero'])."\n\n_Esta mensagem é automática!_"
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
					$sqlUpdate = "UPDATE usuariosLeads SET statusUsuarioLead = 'T', interacaoUsuarioLead = '".date('Y-m-d H:i:s')."' WHERE codUsuarioLead = ".$_GET['ref']."";
					$resultUpdate = $conn->query($sqlUpdate);

					$sqlConversaLead = "UPDATE conversas SET status = 'F' WHERE codConversa = ".$dadosUsuarioLead['codConversa']."";
					$resultConversaLead = $conn->query($sqlConversaLead);
								
					if($resultUpdate == 1){
						$sqlUpdateFila = "UPDATE fila SET interacaoFila = '".date('Y-m-d H:i:s')."' WHERE codUsuario = ".$dadosUsuario['codUsuario']."";
						$resultUpdateFila = $conn->query($sqlUpdateFila);					
					}
				
					$sqlUpdate = "UPDATE leads SET statusLead = 'F', codUsuario = ".$dadosUsuarioLead['codUsuario']." WHERE codLead = ".$dadosUsuarioLead['codLead']."";
					$resultUpdate = $conn->query($sqlUpdate);
					
					if($resultUpdate == 1){						
						$sqlInsereNegociacoes = "INSERT INTO negociacoes VALUES(0, 119, ".$dadosUsuarioLead['codUsuario'].", 0, 0, ".$dadosUsuarioLead['codUsuario'].", 0, '".$dadosConversa['nome']."', '".date('Y-m-d')."', '".date('Y-m-d')."', '".date('Y-m-d')."', '".date('H:i:s')."', '".formatarNumeroTelefone($dadosConversa['numero'])."', 'N', '0.00', '0.00', 'C', 'EA', '', '', '".$dadosMensagemLead['mensagem']."', 'WH', 'T')";
						$resultInsereNegociacoes = $conn->query($sqlInsereNegociacoes);
					}

					if($dadosLead['statusLead'] == "T"){
?>
				<script type="text/javascript">
					location.href = "https://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $dadosConversa['numero'];?>";				
				</script>
				
<?php			
					}
				}

				curl_close($ch);
			}else{
				if($dadosConfereUltimoLead['codUsuario'] == $dadosUsuarioLead['codUsuario']){				
					if($dadosLead['statusLead'] == "T"){
?>
				<script type="text/javascript">
					location.href = "https://api.whatsapp.com/send?1=pt_BR&phone=<?php echo $dadosConversa['numero'];?>";				
				</script>
<?php				
					}
				}else{
					$numero = $dadosUsuario['celularUsuario'];
					$numero = str_replace("(", "", $numero);
					$numero = str_replace(")", "", $numero);
					$numero = str_replace(" ", "", $numero);
					$numero = str_replace("-", "", $numero);

					$messageData = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => "55".$numero,
						"type" => "text",
						"text" => [
							"preview_url" => false,
							"body" => "O Lead *ID: ".$dadosUsuarioLead['codLead']."* já foi confirmado!\n\n_Esta mensagem é automática!_"
						]
					];		
						
					$ch = curl_init("https://graph.facebook.com/v21.0/$phone_number_id/messages");

					curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
					curl_setopt($ch, CURLOPT_POST, true);
					curl_setopt($ch, CURLOPT_HTTPHEADER, [
						"Authorization: Bearer $token",
						"Content-Type: application/json"
					]);
					curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));

					$response = curl_exec($ch);							
				}
			}
		}else{
			$numero = $dadosUsuario['celularUsuario'];
			$numero = str_replace("(", "", $numero);
			$numero = str_replace(")", "", $numero);
			$numero = str_replace(" ", "", $numero);
			$numero = str_replace("-", "", $numero);

			$messageData = [
				"messaging_product" => "whatsapp",
				"recipient_type" => "individual",
				"to" => "55".$numero,
				"type" => "text",
				"text" => [
					"preview_url" => false,
					"body" => "O Lead *ID: ".$dadosUsuarioLead['codLead']."* já foi enviado para o próximo corretor!\n\n_Esta mensagem é automática!_"
				]
			];		
				
			$ch = curl_init("https://graph.facebook.com/v21.0/$phone_number_id/messages");

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POST, true);
			curl_setopt($ch, CURLOPT_HTTPHEADER, [
				"Authorization: Bearer $token",
				"Content-Type: application/json"
			]);
			curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($messageData));

			$response = curl_exec($ch);				
		}
		
		$conn->close();
	
	}	
?>
				<script>
					window.close();				
				</script>
