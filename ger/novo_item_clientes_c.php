<?php
	ob_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('f/conf/config.php');

	$value = $_POST['value'];
	
	$cont = 0;

	$sqlInsere = "INSERT INTO clientes VALUES(0, '".date('Y-m-d')."', 'F', ".$_COOKIE['codAprovado'.$cookie].", '', '".$value."', '', '', '', 'M', NULL, 'S', '', '', '', '', '', '', 'F', NULL, '', '', '', '', '', 0, 0, 0, '', '', '', '', 'T')";
	$resultInsere = $conn->query($sqlInsere);
?>
