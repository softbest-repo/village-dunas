<?php
	include('../../f/conf/config.php');

	$nomeCidade = $_POST['nomeCidade'];

	$sqlCidade = "SELECT * FROM cidade WHERE statusCidade = 'T' and nomeCidade = '".$nomeCidade."'";
	$resultCidade = $conn->query($sqlCidade);
	$dadosCidade = $resultCidade->fetch_assoc();
	
	if($dadosCidade['codCidade'] != ""){
		echo $dadosCidade['codCidade'];
	}else{
		echo "erro";
	}
?>
