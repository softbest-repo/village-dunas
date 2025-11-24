<?php
	ob_start();
	session_start();

	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);

	include('../../f/conf/config.php');
	include('../../f/conf/functions.php');

	$codNegociacao = intval($_GET['codNegociacao']);

	$sqlNegociacao = "SELECT * FROM negociacoes WHERE codNegociacao = $codNegociacao ORDER BY codNegociacao DESC LIMIT 1";
	$resultNegociacao = $conn->query($sqlNegociacao);
	$dadosNegociacao = $resultNegociacao->fetch_assoc();

	if ($dadosNegociacao) {
		$codTipoImovel = $conn->real_escape_string($dadosNegociacao['codTipoImovel']);
		$precoMin = floatval($dadosNegociacao['fPrecoDNegociacao']);
		$precoMax = floatval($dadosNegociacao['fPrecoANegociacao']);

		$sqlImoveis = "SELECT COUNT(codImovel) AS total FROM imoveis WHERE statusImovel = 'T' AND codTipoImovel = '$codTipoImovel' AND precoImovel BETWEEN $precoMin AND $precoMax";
		$resultImoveis = $conn->query($sqlImoveis);
		$dadosImovel = $resultImoveis->fetch_assoc();

		$total = (int)$dadosImovel['total'];
	} else {
		$total = 0;
	}

	header('Content-Type: application/json');
	echo json_encode([
		'resposta' => [
			'total' => $total,
			'cliente' => isset($dadosNegociacao['nomeClienteNegociacao']) ? $dadosNegociacao['nomeClienteNegociacao'] : null
		]
	]);
?>
