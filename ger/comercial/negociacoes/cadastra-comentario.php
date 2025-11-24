 <?php
	ob_start();
	session_start();
	
	include('../../f/conf/config.php');
	include('../../f/conf/conexao.php');

	$codNegociacao = $_POST['codNegociacao'];
	$motivo = $_POST['motivo'];
	$comentario = $_POST['comentario'];

	$update = "UPDATE negociacoes SET fechamentoNegociacao = 'NF', motivoNegociacao = '".$motivo."', comentarioNegociacao = '".$comentario."' WHERE codNegociacao = ".$codNegociacao;
	$result = $conn->query($update);

	if($result == 1){
		echo "ok";
	}	
?>		
