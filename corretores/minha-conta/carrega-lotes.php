<?php 
	ob_start();

	include ('../f/conf/config.php');

	$codLoteamento = $_POST['codLoteamento'];
	$codQuadra = $_POST['codQuadra'];
	
	if($codLoteamento != 0){
		if($codQuadra != 0){
?>
														<p class="campo bloco-campo"><label>Lote:</label>
															<select class="selectLote form-control campo" id="idSelectLote" name="lote" style="width:400px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
				$sqlLotesLista = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.statusLote = 'T' and L.codLoteamento = ".$codLoteamento." and L.codQuadra = ".$codQuadra." and L.vendidoLote = 'F' GROUP BY L.codLote ORDER BY L.nomeLote ASC";
				$resultLotesLista = $conn->query($sqlLotesLista);
				while($dadosLotesLista = $resultLotesLista->fetch_assoc()){

					$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotesLista['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
					$resultReservas = $conn->query($sqlReservas);
					$dadosReservas = $resultReservas->fetch_assoc();

					if($dadosReservas['codLoteReserva'] == "" || $dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){										
?>
																<option value="<?php echo trim($dadosLotesLista['codLote']);?>" <?php echo trim($dadosLotesLista['codLote']) == $_SESSION['lote'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLista['nomeLote']);?></option>	
<?php
					}
				}
?>
															</select>										
														</p>
<?php
		}else{
?>
														<p class="campo bloco-campo"><label>Lote:</label>
															<select class="selectLote form-control campo" id="idSelectLote" name="lote" style="width:400px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
				$sqlLotesLista = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.statusLote = 'T' and L.codLoteamento = ".$codLoteamento." and L.vendidoLote = 'F' GROUP BY L.codLote ORDER BY L.nomeLote ASC";
				$resultLotesLista = $conn->query($sqlLotesLista);
				while($dadosLotesLista = $resultLotesLista->fetch_assoc()){

					$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotesLista['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
					$resultReservas = $conn->query($sqlReservas);
					$dadosReservas = $resultReservas->fetch_assoc();

					if($dadosReservas['codLoteReserva'] == "" || $dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){											
?>
																<option value="<?php echo trim($dadosLotesLista['codLote']);?>" <?php echo trim($dadosLotesLista['codLote']) == $_SESSION['lote'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLista['nomeLote']);?></option>	
<?php
					}
				}
?>
															</select>										
														</p>
<?php			
		}
	}else{
?>
														<p class="campo bloco-campo"><label>Lote:</label>
															<select class="selectLote form-control campo" id="idSelectLote" name="lote" style="width:400px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
				$sqlLotesLista = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.statusLote = 'T' and L.codQuadra = ".$codQuadra." and L.vendidoLote = 'F' GROUP BY L.codLote ORDER BY L.nomeLote ASC";
				$resultLotesLista = $conn->query($sqlLotesLista);
				while($dadosLotesLista = $resultLotesLista->fetch_assoc()){		

					$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotesLista['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
					$resultReservas = $conn->query($sqlReservas);
					$dadosReservas = $resultReservas->fetch_assoc();

					if($dadosReservas['codLoteReserva'] == "" || $dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){								
?>
																<option value="<?php echo trim($dadosLotesLista['codLote']);?>" <?php echo trim($dadosLotesLista['codLote']) == $_SESSION['lote'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLista['nomeLote']);?></option>	
<?php
					}
				}
?>
															</select>										
														</p>
<?php
	}
?>
														<script>
															var $rfh = jQuery.noConflict();
															
															$rfh(".selectLote").select2({
																placeholder: "Todos",
																multiple: false									
															});																	
														</script>	
