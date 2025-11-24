<?php 
	include ('../../f/conf/config.php');
?>
							<p class="bloco-campo-float"><label>Quadra: <span class="obrigatorio"> * </span></label>
								<select class="selectQuadra form-control campo" id="idSelectQuadra" name="quadra" style="width:140px; display: none;">
									<optgroup label="Selecione">
<?php
				$sqlQuadrasLista = "SELECT * FROM quadras ORDER BY codQuadra ASC";
				$resultQuadrasLista = $conn->query($sqlQuadrasLista);
				while($dadosQuadrasLista = $resultQuadrasLista->fetch_assoc()){				
?>
									<option value="<?php echo trim($dadosQuadrasLista['nomeQuadra']);?>"><?php echo trim($dadosQuadrasLista['nomeQuadra']);?></option>	
<?php
				}
?>
								</select>										
							</p>

							<script>
								var $rfs = jQuery.noConflict();
								
								$rfs(".selectQuadra").select2({
									placeholder: "Selecione",
									multiple: false									
								});	
								
								$rfs(".selectQuadra").val("").trigger("change");
								
								$rfs(".selectQuadra").on("select2:select", function (e) {
									var cidadeSeleciona = document.getElementById("cidades").value;
									var bairroSeleciona = document.getElementById("bairro").value;
									var quadraSeleciona = document.getElementById("idSelectQuadra").value;

									var $tgfs = jQuery.noConflict();
									$tgfs.post("<?php echo $configUrl;?>cadastros/imoveis/lotes.php", {codCidade: cidadeSeleciona, codBairro: bairroSeleciona, quadraImovel: quadraSeleciona}, function(data){
										$tgfs("#carrega-lotes").html(data);
									});									
								});																	
							</script>
