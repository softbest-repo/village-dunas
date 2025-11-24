<?php
	include('info.php');
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

	function enviarMensagemWhatsapp($numero, $nomeUsuario, $phone_number_id, $token) {
		$numeroProcessado = str_replace(["(", ")", "-", " "], "", $numero);

		$messageData = [
			"messaging_product" => "whatsapp",
			"recipient_type" => "individual",
			"to" => $numeroProcessado,
			"type" => "text",
			"text" => [
				"preview_url" => false,
				"body" => "Olá *".$nomeUsuario."*!\n\n Mensagens automáticas foram normalizadas."
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
		curl_close($ch);

		return $response;
	}

	$sqlUsuario = "SELECT U.* FROM usuarios U LEFT JOIN usuariosLogins UL ON U.codUsuario = UL.codUsuario AND DATE(UL.dataUsuarioLogin) = CURDATE() WHERE U.statusUsuario = 'T' AND UL.codUsuario IS NULL ORDER BY U.codUsuario ASC";
	$resultUsuario = $conn->query($sqlUsuario);
	while($dadosUsuario = $resultUsuario->fetch_assoc()){
		if($dadosUsuario['celularUsuario'] != ""){
			enviarMensagemWhatsapp(
				$dadosUsuario['celularUsuario'],
				$dadosUsuario['nomeUsuario'],
				$phone_number_id,
				$token
			);
		}
	}
	$conn->close();