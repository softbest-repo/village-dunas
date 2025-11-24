<?php
	ob_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('f/conf/config.php');
	include('f/conf/validaAcesso.php');

	$value = $_POST['value'];
	
	$cont = 0;

	$sqlInsere = "INSERT INTO proprietarios VALUES(0, '".$_COOKIE['codAprovado'.$cookie]."', '".$value."', '', '', '', 'M', NULL, '', '', 0, 0, '', '', '', '', 'T')";
	$resultInsere = $conn->query($sqlInsere);
?>
