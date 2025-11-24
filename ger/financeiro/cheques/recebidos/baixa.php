				<div id="filtro">
					<p style="margin-top:40px; margin-bottom:20px; font-weight:bold; font-size:16px; color:#718B8F;"><img style="margin-right:10px;" src="<?php echo $configUrl;?>f/i/default/corpo-default/loading.gif" alt="Loading" />Aguarde, dando baixa no cheque.....</p>
				</div>
<?php
	$sqlChequeVerif = "SELECT * FROM cheques WHERE codCheque = ".$url[7]." LIMIT 0,1";
	$resultChequeVerif = $conn->query($sqlChequeVerif);
	$dadosChequeVerif = $resultChequeVerif->fetch_assoc();
	
	if($dadosChequeVerif['statusCheque'] == "T"){
		$sqlCheque = "UPDATE cheques SET statusCheque = 'F', dataDescontoCheque = '".date("Y-m-d")."' WHERE codCheque = ".$url[7];
		$resultCheque = $conn->query($sqlCheque);
	}else{
		$sqlCheque = "UPDATE cheques SET statusCheque = 'T', dataDescontoCheque = '' WHERE codCheque = ".$url[7];
		$resultCheque = $conn->query($sqlCheque);		
	}
	
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/cheques/recebidos/detalhes/".$url[7]."/'>";
?>
