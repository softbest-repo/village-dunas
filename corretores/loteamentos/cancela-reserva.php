<?php
	ob_start();
	
	include('../f/conf/config.php');
	include('../f/conf/functions.php');
	
	$codLote = $_POST['codLote'];		
	
	if($codLote != ""){
		$novaData = date('Y-m-d H:i:s');

		$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$codLote." or codUnido = ".$codLote." ORDER BY codLote ASC LIMIT 0,1";
		$resultUniao = $conn->query($sqlUniao);
		$dadosUniao = $resultUniao->fetch_assoc();
		
		if($dadosUniao['codLoteUnido'] != ""){
			$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosUniao['codLote']." ORDER BY codLote ASC";
			$resultUniao = $conn->query($sqlUniao);
			while($dadosUniao = $resultUniao->fetch_assoc()){

				$codLoteMaster = $dadosUniao['codLote'];		

				$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosUniao['codUnido']." and dataOutLoteReserva IS NULL";
				$resultReservas = $conn->query($sqlReservas);
				$dadosReservas = $resultReservas->fetch_assoc();							
				
				$sqlUpdate = "UPDATE lotesReservas SET dataOutLoteReserva = '".$novaData."', statusLoteReserva = 'A' WHERE codLoteReserva = '".$dadosReservas['codLoteReserva']."'";
				$resultUpdate = $conn->query($sqlUpdate);								

				$sqlLote = "SELECT nomeLote, codLoteamento FROM lotes WHERE codLote = ".$dadosUniao['codUnido']." ORDER BY codLote DESC LIMIT 0,1";
				$resultLote = $conn->query($sqlLote);
				$dadosLote = $resultLote->fetch_assoc();
				
				$sqlLoteamento = "SELECT nomeLoteamento FROM loteamentos WHERE codLoteamento = ".$dadosLote['codLoteamento']." ORDER BY codLoteamento DESC LIMIT 0,1";
				$resultLoteamento = $conn->query($sqlLoteamento);
				$dadosLoteamento = $resultLoteamento->fetch_assoc();

				$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Reserva cancelada no loteamento ".$dadosLoteamento['nomeLoteamento']." lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
				$resultHistorico = $conn->query($sqlHistorico);		
								
				if($resultUpdate == 1){
					$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', ".$_COOKIE['codAprovado'.$cookie].", ".$dadosUniao['codUnido'].", 'RC', 'T', 2)";
					$resultInsere = $conn->query($sqlInsere);

				}
			}

			$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$codLoteMaster." and dataOutLoteReserva IS NULL";
			$resultReservas = $conn->query($sqlReservas);
			$dadosReservas = $resultReservas->fetch_assoc();							
			
			$sqlUpdate = "UPDATE lotesReservas SET dataOutLoteReserva = '".$novaData."', statusLoteReserva = 'A' WHERE codLoteReserva = '".$dadosReservas['codLoteReserva']."'";
			$resultUpdate = $conn->query($sqlUpdate);								

			$sqlLote = "SELECT nomeLote, codLoteamento FROM lotes WHERE codLote = ".$codLoteMaster." ORDER BY codLote DESC LIMIT 0,1";
			$resultLote = $conn->query($sqlLote);
			$dadosLote = $resultLote->fetch_assoc();
			
			$sqlLoteamento = "SELECT nomeLoteamento FROM loteamentos WHERE codLoteamento = ".$dadosLote['codLoteamento']." ORDER BY codLoteamento DESC LIMIT 0,1";
			$resultLoteamento = $conn->query($sqlLoteamento);
			$dadosLoteamento = $resultLoteamento->fetch_assoc();

			$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Reserva cancelada no loteamento ".$dadosLoteamento['nomeLoteamento']." lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
			$resultHistorico = $conn->query($sqlHistorico);		
							
			if($resultUpdate == 1){
				$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', ".$_COOKIE['codAprovado'.$cookie].", ".$codLoteMaster.", 'RC', 'T', 2)";
				$resultInsere = $conn->query($sqlInsere);

			}			
		}else{
			$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$codLote." and dataOutLoteReserva IS NULL";
			$resultReservas = $conn->query($sqlReservas);
			$dadosReservas = $resultReservas->fetch_assoc();							

			$sqlUpdate = "UPDATE lotesReservas SET dataOutLoteReserva = '".$novaData."', statusLoteReserva = 'A' WHERE codLoteReserva = '".$dadosReservas['codLoteReserva']."'";
			$resultUpdate = $conn->query($sqlUpdate);								

			$sqlLote = "SELECT nomeLote, codLoteamento FROM lotes WHERE codLote = ".$codLote." ORDER BY codLote DESC LIMIT 0,1";
			$resultLote = $conn->query($sqlLote);
			$dadosLote = $resultLote->fetch_assoc();
			
			$sqlLoteamento = "SELECT nomeLoteamento FROM loteamentos WHERE codLoteamento = ".$dadosLote['codLoteamento']." ORDER BY codLoteamento DESC LIMIT 0,1";
			$resultLoteamento = $conn->query($sqlLoteamento);
			$dadosLoteamento = $resultLoteamento->fetch_assoc();

			$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Reserva cancelada no loteamento ".$dadosLoteamento['nomeLoteamento']." lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
			$resultHistorico = $conn->query($sqlHistorico);		
							
			if($resultUpdate == 1){
				$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', ".$_COOKIE['codAprovado'.$cookie].", ".$codLote.", 'RC', 'T', 2)";
				$resultInsere = $conn->query($sqlInsere);
			}		
		}

		echo "ok";

	}else{
		echo "erro";
	}			
?>
