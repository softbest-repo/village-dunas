<?php
	include('info.php');

	function chamarCurl($url) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		curl_setopt($ch, CURLOPT_TIMEOUT, 1);
		curl_setopt($ch, CURLOPT_NOSIGNAL, 1);
		curl_exec($ch);
		curl_close($ch);
	}
		
	chamarCurl($configUrlWa."wa/reseta.php");	
		
	echo json_encode(['success' => true, 'message' => 'Sucesso']);
?>
