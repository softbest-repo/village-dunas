<?php 
	include ('f/conf/config.php');
	
	$sqlLotesReservas = "SELECT * FROM lotesReservas WHERE dataOutLoteReserva IS NULL and statusLoteReserva = 'A' ORDER BY dataInLoteReserva ASC";
	$resultLotesReservas = $conn->query($sqlLotesReservas);
	while($dadosLotesReservas = $resultLotesReservas->fetch_assoc()){

		$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosLotesReservas['codLote']." or codUnido = ".$dadosLotesReservas['codLote']." ORDER BY codLote ASC LIMIT 0,1";
		$resultUniao = $conn->query($sqlUniao);
		$dadosUniao = $resultUniao->fetch_assoc();
		
		if($dadosUniao['codLote'] != ""){
			$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosUniao['codLote']." ORDER BY codLote ASC LIMIT 0,1";
			$resultUniao = $conn->query($sqlUniao);
			while($dadosUniao = $resultUniao->fetch_assoc()){
				$sqlContrato = "SELECT * FROM contratos WHERE (codLote = ".$dadosUniao['codUnido']." or codLote = ".$dadosUniao['codLote'].") and tipoContrato = 'AA' ORDER BY codContrato DESC LIMIT 0,1";
				$resultContrato = $conn->query($sqlContrato);
				$dadosContrato = $resultContrato->fetch_assoc();
				
				if($dadosContrato['codContrato'] != ""){
					$diasReservaSql = 6;
					break;
				}else{
					$diasReservaSql = $diasReserva;
				}
			}	
		}else{

			$sqlContrato = "SELECT * FROM contratos WHERE codLote = ".$dadosLotesReservas['codLote']." and tipoContrato = 'AA' ORDER BY codContrato DESC LIMIT 0,1";
			$resultContrato = $conn->query($sqlContrato);
			$dadosContrato = $resultContrato->fetch_assoc();

			if($dadosContrato['codContrato'] != ""){
				$diasReservaSql = 6;
			}else{
				$diasReservaSql = $diasReserva;
			}									
		}
					
		$sqlLotesReservas = "SELECT * FROM lotesReservas WHERE dataOutLoteReserva IS NULL AND statusLoteReserva = 'A' AND TIMESTAMPDIFF(SECOND, dataInLoteReserva, NOW()) >= ".$diasReservaSql." * 86400 ORDER BY dataInLoteReserva ASC";
		$resultLotesReservas = $conn->query($sqlLotesReservas);
		$dadosLotesReservas = $resultLotesReservas->fetch_assoc();
		
		if($dadosLotesReservas['codLoteReserva'] != ""){
		
			$sqlUpdate = "UPDATE lotesReservas SET dataOutLoteReserva = '".date('Y-m-d H:i:s')."' WHERE codLoteReserva = ".$dadosLotesReservas['codLoteReserva']."";
			$resultUpdate = $conn->query($sqlUpdate);
			
			if($resultUpdate == 1){
				$sqlMovimentacao = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', 0, ".$dadosLotesReservas['codLote'].", 'RC', 'T', 3)";
				$resultMovimentacao = $conn->query($sqlMovimentacao);
			}
		}
	}
?>
