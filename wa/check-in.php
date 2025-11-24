<?php
	include('info.php');

	if(date('H:i:s') >= $limiteCheckin && date('H:i:s') <= $horaInicio){

		include('../f/conf/config.php');

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
		
								
		$sqlUsuario = "SELECT U.* FROM usuarios U LEFT JOIN usuariosLogins UL ON U.codUsuario = UL.codUsuario AND DATE(UL.dataUsuarioLogin) = CURDATE() WHERE U.statusUsuario = 'T' and U.leadsUsuario = 'S' AND UL.codUsuario IS NULL ORDER BY U.codUsuario ASC";
		$resultUsuario = $conn->query($sqlUsuario);
		while($dadosUsuario = $resultUsuario->fetch_assoc()){
					
			if($dadosUsuario['celularUsuario'] != ""){
				

				$numero = $dadosUsuario['celularUsuario'];
				$numero = str_replace("(", "", $numero);
				$numero = str_replace(")", "", $numero);
				$numero = str_replace(" ", "", $numero);
				$numero = str_replace("-", "", $numero);

				$numeroProcessado = str_replace(["(", ")", "-", " "], "", $dadosUsuario['celularUsuario']);
							
				$sqlConfereU = "SELECT U.* FROM usuarios U INNER JOIN usuariosLogins UL ON U.codUsuario = UL.codUsuario AND DATE(UL.dataUsuarioLogin) = CURDATE() WHERE U.codUsuario = ".$dadosUsuario['codUsuario']." and U.statusUsuario = 'T' and U.tipoUsuario = 'C' ORDER BY U.codUsuario ASC";
				$resultConfereU = $conn->query($sqlConfereU);
				$dadosConfereU = $resultConfereU->fetch_assoc();
				
				if($dadosConfereU['codUsuario'] == ""){
										
					$messageData = [
						"messaging_product" => "whatsapp",
						"recipient_type" => "individual",
						"to" => $numeroProcessado,
						"type" => "template",
						"template" => [
							"name" => "check_in_diario",
							"language" => ["code" => "pt_BR"],
							"components" => [
								[
									"type" => "body",
									"parameters" => [
										["type" => "text", "text" => $dadosUsuario['nomeUsuario']." ".$dadosUsuario['sobrenomeUsuario']],         // Substitui {{1}}
									]
								]
							]					
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


					if (strlen($numeroProcessado) == 11 && substr($numeroProcessado, 2, 1) == "9") {
						$numeroProcessado = "55".padronizarNumero($numeroProcessado);
					}					
							
					$sqlInsere = "INSERT INTO conversas VALUES(0, '', 'whatsapp', '".$dadosUsuario['nomeUsuario']." ".$dadosUsuario['sobrenomeUsuario']."', ".$numeroProcessado.", '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 'F', '', 'I', 'T', 'T')";
					$resultInsere = $conn->query($sqlInsere);
				
				}	
			}
		}
		
		$conn->close();		
	}		
		
	echo json_encode(['success' => true, 'message' => 'Sucesso']);	