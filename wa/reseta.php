<?php
	include('info.php');

	$lockFile = 'cron-reseta.lock';
	if (file_exists($lockFile) && filemtime($lockFile) > (time() - 60)) {
		echo json_encode(['success' => true, 'message' => 'Sucesso / Arquivo Rodando']);
		exit;
	}
	touch($lockFile);
		
	include('../f/conf/config.php');

	$entra = "";
	$ativa = "";

	if(date('H:i:s') >= $horaInicio && date('H:i:s') <= $horaFim){
			
		$mudanca = "";
			
		$sqlUsuarioLead = "SELECT UL.codUsuario, UL.codUsuarioLead, L.codLead, UL.codConversa FROM usuariosLeads UL inner join leads L on UL.codLead = L.codLead WHERE UL.statusUsuarioLead = 'A' and L.statusLead = 'T' and L.envioLead <= DATE_SUB(NOW(), INTERVAL ".$tempoLead." MINUTE) GROUP BY UL.codLead ORDER BY L.codLead ASC";
		$resultUsuarioLead = $conn->query($sqlUsuarioLead);
		while($dadosUsuarioLead = $resultUsuarioLead->fetch_assoc()){

			$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosUsuarioLead['codUsuario']." ORDER BY codUsuario DESC LIMIT 0,1";
			$resultUsuario = $conn->query($sqlUsuario);
			$dadosUsuario = $resultUsuario->fetch_assoc();

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
					"body" => "Lead *ID: ".$dadosUsuarioLead['codLead']."* expirado!\n\n_Esta mensagem é automática!_"
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
			
			$sqlUpdateUL = "UPDATE usuariosLeads SET statusUsuarioLead = 'F' WHERE codUsuarioLead = ".$dadosUsuarioLead['codUsuarioLead']."";
			$resultUpdateUL = $conn->query($sqlUpdateUL);

			$sqlConversaLead = "UPDATE conversas SET status = 'F' WHERE codConversa = ".$dadosUsuarioLead['codConversa']."";
			$resultConversaLead = $conn->query($sqlConversaLead);
						
			if($resultUpdateUL == 1){
				$mudanca = "ok";
			}
		}
		
		if($mudanca == "ok"){
			chamarCurl($configUrlWa."wa/roleta.php");
		}
				
		$sqlUsuarioLeads = "SELECT * FROM usuariosLeads UL inner join leads L on UL.codLead = L.codLead WHERE UL.statusUsuarioLead = 'A' and L.statusLead = 'T' ORDER BY UL.codUsuarioLead DESC LIMIT 0,1";
		$resultUsuarioLeads = $conn->query($sqlUsuarioLeads);

		$sqlLeads = "SELECT * FROM leads WHERE statusLead = 'T' ORDER BY codLead DESC LIMIT 0,1";
		$resultLeads = $conn->query($sqlLeads);
				
		if($resultUsuarioLeads && $dadosUsuarioLeads = $resultUsuarioLeads->fetch_assoc()) {
			$ativa = "ok";		
			
			$entra = "ok";
		}else
		if($resultLeads && $dadosLeads = $resultLeads->fetch_assoc()) {
			chamarCurl($configUrlWa."wa/roleta.php");	
			$ativa = "ok";	
		}			
	}
	
	if($entra == ""){
	
		$sqlLeads = "SELECT * FROM leads WHERE statusLead = 'T' ORDER BY codLead DESC LIMIT 0,1";
		$resultLeads = $conn->query($sqlLeads);

		if($resultLeads && $dadosLeads = $resultLeads->fetch_assoc()) {
			chamarCurl($configUrlWa."wa/roleta.php");	
			$ativa = "ok";
		}		
	}

	function chamarCurl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_exec($ch);
		curl_close($ch);
	}
		
	sleep(60);
	
	if($ativa == "ok"){
		chamarCurl($configUrlWa."wa/reseta.php");
		chamarCurl($configUrlWa."wa/interage-corretor.php");		
	}
		
	$conn->close();

	echo json_encode(['success' => true, 'message' => 'Sucesso / Arquivo Iniciado']);
?>
