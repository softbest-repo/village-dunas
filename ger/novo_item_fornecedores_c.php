<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('f/conf/config.php');

	$value = $_POST['value'];
	
	$cont = 0;

	$sqlInsere = "INSERT INTO fornecedores VALUES(0, 'F', '', '".$value."', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'T')";
	$resultInsere = $conn->query($sqlInsere);
?>
