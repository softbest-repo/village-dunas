<?php 
	include ('../f/conf/config.php');

	$codLoteamento = $_POST['codLoteamento'];
	$codQuadra = $_POST['codQuadra'];
	
	if($codLoteamento == 0){
		$filtra = "L.statusLote = 'T' and L.destaqueLote = 'T'";
	}else{
		$filtra = "L.codLoteamento = ".$codLoteamento;
	}
	
	if($codQuadra != ""){
?>
														<p class="bloco-campo"><label>Lote:</label><br/>
															<select class="selectLote form-control campo" id="idSelectLote" name="loteFiltroSite" style="width:130px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
				$sqlLotesLista = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE ".$filtra." and L.codQuadra = ".$codQuadra." GROUP BY L.codLote ORDER BY L.nomeLote ASC";
				$resultLotesLista = $conn->query($sqlLotesLista);
				while($dadosLotesLista = $resultLotesLista->fetch_assoc()){				
?>
																<option value="<?php echo trim($dadosLotesLista['codLote']);?>" <?php echo trim($dadosLotesLista['codLote']) == $_SESSION['loteFiltroSite'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLista['nomeLote']);?></option>	
<?php
				}
?>
															</select>										
														</p>

														<script>
															var $rfh = jQuery.noConflict();
															
															$rfh(".selectLote").select2({
																placeholder: "Todos",
																multiple: false									
															});																	
														</script>	
<?php
	}else{
?>
														<p class="bloco-campo"><label>Lote:</label><br/>
															<select class="selectLote form-control campo" id="idSelectLote" name="loteFiltroSite" style="width:130px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
				$sqlLotesLista = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE ".$filtra." GROUP BY L.codLote ORDER BY L.nomeLote ASC";
				$resultLotesLista = $conn->query($sqlLotesLista);
				while($dadosLotesLista = $resultLotesLista->fetch_assoc()){				
?>
																<option value="<?php echo trim($dadosLotesLista['codLote']);?>" <?php echo trim($dadosLotesLista['codLote']) == $_SESSION['loteFiltroSite'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLista['nomeLote']);?></option>	
<?php
				}
?>
															</select>										
														</p>

														<script>
															var $rfh = jQuery.noConflict();
															
															$rfh(".selectLote").select2({
																placeholder: "Todos",
																multiple: false									
															});																	
														</script>
<?php
	}
?>
