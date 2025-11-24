<?php 
	ob_start();
	
	include ('../f/conf/config.php');

	$codLoteamento = $_POST['codLoteamento'];
?>
									<p class="campo bloco-campo"><label>Quadra:</label>
										<select class="selectQuadra form-control campo" id="idSelectQuadra" name="quadra" style="width:400px; display: none;">
											<optgroup label="Selecione">
											<option value="">Todos</option>	
<?php
				$sqlQuadrasLote = "SELECT * FROM quadras Q inner join lotes L on Q.codQuadra = L.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.statusLote = 'T' and L.codLoteamento = ".$codLoteamento." and L.vendidoLote = 'F' GROUP BY Q.codQuadra ORDER BY Q.nomeQuadra ASC";
				$resultQuadrasLote = $conn->query($sqlQuadrasLote);
				while($dadosQuadrasLote = $resultQuadrasLote->fetch_assoc()){	
					
					$sqlLotes = "SELECT * FROM lotes WHERE codLoteamento = ".$codLoteamento." and codQuadra = ".$dadosQuadrasLote['codQuadra']." ORDER BY codLote ASC";
					$resultLotes = $conn->query($sqlLotes);
					while($dadosLotes = $resultLotes->fetch_assoc()){

						$libera = "nao";
												
						$sqlReservas1 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." ORDER BY codLoteReserva DESC LIMIT 0,1";
						$resultReservas1 = $conn->query($sqlReservas1);
						$dadosReservas1 = $resultReservas1->fetch_assoc();
						
						if($dadosReservas1['codLoteReserva'] != ""){
							
							$sqlReservas2 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NOT NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
							$resultReservas2 = $conn->query($sqlReservas2);
							$dadosReservas2 = $resultReservas2->fetch_assoc();
							
							if($dadosReservas2['codLoteReserva'] != ""){
								$libera = "ok";
								break;
							}else{
								$sqlReservas2 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
								$resultReservas2 = $conn->query($sqlReservas2);
								$dadosReservas2 = $resultReservas2->fetch_assoc();
								
								if($dadosReservas2['codLoteReserva'] != "" && $dadosReservas2['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
									$libera = "ok";
									break;
								}								
							}						
						
						}else{
							$libera = "ok";
						}
					
					}
					
					if($libera == "ok"){										
?>
											<option value="<?php echo trim($dadosQuadrasLote['codQuadra']);?>" <?php echo trim($dadosQuadrasLote['codQuadra']) == $_SESSION['quadra'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosQuadrasLote['nomeQuadra']);?></option>	
<?php
					}
				}
?>
										</select>										
									</p>

									<script>
										var $rfs = jQuery.noConflict();
										
										$rfs(".selectQuadra").select2({
											placeholder: "Todos",
											multiple: false									
										});	

										$rfs(".selectQuadra").on("select2:select", function (e) {
											var quadraSeleciona = document.getElementById("idSelectQuadra").value;

											$rfs.post("<?php echo $configUrl;?>minha-conta/carrega-lotes.php", {codLoteamento: <?php echo $codLoteamento;?>, codQuadra: quadraSeleciona}, function(data){
												$rfs("#carrega-lotes").html(data);
											});							
										});																															
									</script
