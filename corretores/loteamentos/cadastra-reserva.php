<?php
	ob_start();
	
	include('../f/conf/config.php');
	include('../f/conf/functions.php');
	
	$codLote = $_POST['codLote'];		
	
	if($_COOKIE['codAprovado'.$cookie] != ""){

		$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$codLote." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
		$resultReservas = $conn->query($sqlReservas);
		$dadosReservas = $resultReservas->fetch_assoc();

		if($dadosReservas['codLoteReserva'] == ""){

			$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$codLote." or codUnido = ".$codLote." ORDER BY codLote ASC LIMIT 0,1";
			$resultUniao = $conn->query($sqlUniao);
			$dadosUniao = $resultUniao->fetch_assoc();
			
			if($dadosUniao['codLoteUnido'] != ""){
				$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosUniao['codLote']." ORDER BY codLote ASC";
				$resultUniao = $conn->query($sqlUniao);
				while($dadosUniao = $resultUniao->fetch_assoc()){
					
					$codLoteMaster = $dadosUniao['codLote'];
					
					$sqlReservar = "INSERT INTO lotesReservas VALUES(0, '".$dadosUniao['codUnido']."', ".$_COOKIE['codAprovado'.$cookie].", '".date('Y-m-d H:i:s')."', NULL, 'A')";
					$resultReservar = $conn->query($sqlReservar);				

					if($resultReservar == 1){
						$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', ".$_COOKIE['codAprovado'.$cookie].", '".$dadosUniao['codUnido']."', 'RR', 'T', 2)";
						$resultInsere = $conn->query($sqlInsere);
						
						$sqlLote = "SELECT nomeLote, codLoteamento FROM lotes WHERE codLote = '".$dadosUniao['codUnido']."' ORDER BY codLote DESC LIMIT 0,1";
						$resultLote = $conn->query($sqlLote);
						$dadosLote = $resultLote->fetch_assoc();
						
						$sqlLoteamento = "SELECT nomeLoteamento FROM loteamentos WHERE codLoteamento = '".$dadosLote['codLoteamento']."' ORDER BY codLoteamento DESC LIMIT 0,1";
						$resultLoteamento = $conn->query($sqlLoteamento);
						$dadosLoteamento = $resultLoteamento->fetch_assoc();

						$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Reserva realizada no loteamento ".$dadosLoteamento['nomeLoteamento']." lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
						$resultHistorico = $conn->query($sqlHistorico);		
						
					}
				}	
				
				if($codLoteMaster != ""){
					$sqlReservar = "INSERT INTO lotesReservas VALUES(0, ".$codLoteMaster.", ".$_COOKIE['codAprovado'.$cookie].", '".date('Y-m-d H:i:s')."', NULL, 'A')";
					$resultReservar = $conn->query($sqlReservar);				

					if($resultReservar == 1){
						$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', ".$_COOKIE['codAprovado'.$cookie].", ".$codLoteMaster.", 'RR', 'T', 2)";
						$resultInsere = $conn->query($sqlInsere);
						
						$sqlLote = "SELECT nomeLote, codLoteamento FROM lotes WHERE codLote = ".$codLoteMaster." ORDER BY codLote DESC LIMIT 0,1";
						$resultLote = $conn->query($sqlLote);
						$dadosLote = $resultLote->fetch_assoc();
						
						$sqlLoteamento = "SELECT nomeLoteamento FROM loteamentos WHERE codLoteamento = ".$dadosLote['codLoteamento']." ORDER BY codLoteamento DESC LIMIT 0,1";
						$resultLoteamento = $conn->query($sqlLoteamento);
						$dadosLoteamento = $resultLoteamento->fetch_assoc();

						$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Reserva realizada no loteamento ".$dadosLoteamento['nomeLoteamento']." lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
						$resultHistorico = $conn->query($sqlHistorico);		
						
					}			
				}
						
			}else{
				$sqlReservar = "INSERT INTO lotesReservas VALUES(0, ".$codLote.", ".$_COOKIE['codAprovado'.$cookie].", '".date('Y-m-d H:i:s')."', NULL, 'A')";
				$resultReservar = $conn->query($sqlReservar);			
			
				if($resultReservar == 1){
					
					$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', ".$_COOKIE['codAprovado'.$cookie].", ".$codLote.", 'RR', 'T', 2)";
					$resultInsere = $conn->query($sqlInsere);
					
					$sqlLote = "SELECT nomeLote, codLoteamento FROM lotes WHERE codLote = ".$codLote." ORDER BY codLote DESC LIMIT 0,1";
					$resultLote = $conn->query($sqlLote);
					$dadosLote = $resultLote->fetch_assoc();
					
					$sqlLoteamento = "SELECT nomeLoteamento FROM loteamentos WHERE codLoteamento = ".$dadosLote['codLoteamento']." ORDER BY codLoteamento DESC LIMIT 0,1";
					$resultLoteamento = $conn->query($sqlLoteamento);
					$dadosLoteamento = $resultLoteamento->fetch_assoc();

					$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Reserva realizada no loteamento ".$dadosLoteamento['nomeLoteamento']." lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
					$resultHistorico = $conn->query($sqlHistorico);		
					
				}	
			}	

			echo "ok";	

		}else{
			echo "erro reserva";
		}	
		
	}else{
		echo "erro login";
	}			
?>
