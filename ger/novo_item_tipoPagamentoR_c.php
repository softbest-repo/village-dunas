<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('f/conf/config.php');
	include('f/conf/conexao.php');

	$value = $_POST['value'];
	
	$cont = 0;

	$sqlInsere = "INSERT INTO tipoPagamento VALUES(0, 'R', '".$value."', 'V', 'T')";
	$resultInsere = $conn->query($sqlInsere);
?>
