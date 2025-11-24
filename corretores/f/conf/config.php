<?php
	$configUrl = "http://192.168.1.200/sanFerreira/corretores/";
	$configUrlSeg = "http://192.168.1.200/sanFerreira_m/corretores/";
	$configUrlGer = "http://192.168.1.200/sanFerreira/ger/";

	$configServer = "localhost";
	$configLogin = "root";
	$configSenha = "epitafio";
	$configBaseDados = "sanFerreira";

	$conn = new mysqli($configServer, $configLogin, $configSenha, $configBaseDados);

	$urlUpload = "/sanFerreira/ger";

	if ($conn->connect_error) {
		die("Erro de conexão: " . $conn->connect_error);
	}

	$sqlSession = "SET SESSION sql_mode = ''";
	$resultSession = $conn->query($sqlSession);
		
	$nomeEmpresa = "sanFerreira Corretores";
	$nomeEmpresaMenor = "sanFerreira Corretores";
	
	$cookie = "sanFerreiraCorretoresSite";
	
	$diasReserva = 2;
	
	$aux = "";
	
	$linguagem = "Portuguese";
	$pais = "Brazil";
	$estado = "Santa Catarina";
	$cidade = "Balneário Gaivota";
	
	$keywordsConfig = "";

	$hostEmail = "email-ssl.com.br";
	$dominio = "https://www.sanferreira.com.br";
	$dominioSem = "www.sanferreira.com.br";

	$chaveSite = "";
	$chaveSecreta = "";
	
	$cor1 = "#002c23";
	$cor2 = "#07473a";
?>
	
