<?php 
	ob_start();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		include ('../f/conf/config.php');
	
		$lote = $_POST['lote'];
		$quadra = $_POST['quadra'];
		$loteamento = $_POST['loteamento'];
		
		$sqlLote = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra WHERE L.nomeLote = '".$conn->real_escape_string($lote)."' and Q.nomeQuadra = '".$conn->real_escape_string($quadra)."' and L.codLoteamento = '".$conn->real_escape_string($loteamento)."' ORDER BY L.codLote ASC LIMIT 1";
		$resultLote = $conn->query($sqlLote);
		$dadosLote = $resultLote->fetch_assoc();
		
		echo $dadosLote['codLote'];
		
		$conn->close();
	}
?>
