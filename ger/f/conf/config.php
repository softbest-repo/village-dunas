<?php

	error_reporting(0);
	ini_set('display_errors', 0);

	// $configServer = "50.116.87.98";
	// $configLogin = "servidor_village-dunas";
	// $configSenha = "epitafio2025*";
	// $configBaseDados = "servidor_village-dunas";

	$configServer = "localhost";
	$configLogin = "root";
	$configSenha = "";
	$configBaseDados = "village-dunas";	


	$configUrl = "http://".$_SERVER['HTTP_HOST']."/village-dunas/ger/";
	$configUrlGer = "http://".$_SERVER['HTTP_HOST']."/village-dunas/ger/";
	$configUrlSite = "http://".$_SERVER['HTTP_HOST']."/village-dunas/";
	
	
	$conn = new mysqli($configServer, $configLogin, $configSenha, $configBaseDados);

	if ($conn->connect_error) {
		die("Erro de conexão: " . $conn->connect_error);
	}

	$sqlSession = "SET SESSION sql_mode = ''";
	$resultSession = $conn->query($sqlSession);

	$cookie = "village-dunasGer";
	$configLimite = 20;
	
	$urlUpload = "/ger";

	$nomeEmpresa = "Ger | Imobiliária Village Dunas [GER]";
	$nomeEmpresaMenor = "Imobiliária Village Dunas";
	$hostEmail = "srv214.prodns.com.br";

	$razaoImobiliaria = "Imobiliária Village Dunas LTDA";
	$cnpjImobiliaria = "57.777.699/0001-18";
	$telefoneImobiliaria = "(48) 99693-0117";
	$cidadeEstadoImobiliaria = "Balneário Gaivota / SC";
	
