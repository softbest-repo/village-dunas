<?php 
	ob_start();
	session_start();
	
	include ('../../f/conf/config.php');
	
	$codCidade = $_POST['codCidade'];
	$codBairro = $_POST['codBairro'];
	$quadraImovel = $_POST['quadraImovel'];
?>
							<p class="bloco-campo-float"><label>Lote(s): <span class="obrigatorio"> * </span></label>
								<select class="selectLote form-control campo" id="idSelectLote" name="lote[]" multiple="" style="width:140px; display: none;">
									<optgroup label="Selecione">
<?php
				$sqlLotesLista = "SELECT * FROM lotes ORDER BY codLote ASC";
				$resultLotesLista = $conn->query($sqlLotesLista);
				while($dadosLotesLista = $resultLotesLista->fetch_assoc()){
					
					$sqlImovel = "SELECT * FROM imoveis I inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$quadraImovel."' and I.loteImovel = '".trim($dadosLotesLista['nomeLote'])."' GROUP BY I.codImovel ORDER BY I.codImovel DESC LIMIT 0,1";
					$resultImovel = $conn->query($sqlImovel);
					$dadosImovel = $resultImovel->fetch_assoc();

					$nomeCorretor = explode(" ", $dadosImovel['nomeUsuario']);

					$lotes = explode(",", $_SESSION['lote']);
					$loteOk = "";
					foreach($lotes as $lote) {
						$lote = trim($lote);
						if($lote == trim($dadosLotesLista['nomeLote'])){
							$loteOk = "sim";
						}
					}	
															
					if($dadosImovel['codImovel'] == "" || $loteOk == "sim" && $_SESSION['quadra'] == $quadraImovel || $dadosImovel['codTipoImovel'] == 6 || $dadosImovel['codTipoImovel'] == 8 || $dadosImovel['codTipoImovel'] == 11){
						
						$sqlImovel = "SELECT * FROM imoveisLotes IL inner join imoveis I on IL.codImovel = I.codImovel inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$quadraImovel."' and IL.nomeLote = '".trim($dadosLotesLista['nomeLote'])."' GROUP BY IL.codImovelLote ORDER BY I.codImovel DESC LIMIT 0,1";
						$resultImovel = $conn->query($sqlImovel);
						$dadosImovel = $resultImovel->fetch_assoc();
						
						$nomeCorretor = explode(" ", $dadosImovel['nomeUsuario']);
						
						if($dadosImovel['codImovel'] == "" || $loteOk == "sim" && $_SESSION['quadra'] == $quadraImovel || $dadosImovel['codTipoImovel'] == 6 || $dadosImovel['codTipoImovel'] == 8 || $dadosImovel['codTipoImovel'] == 11){
							$classColor = "select2-green";
							$corretor = "";
							$disabled = "";					
						}else{
							$classColor = "select2-red";
							$corretor = " - ".$nomeCorretor[0];
							$disabled = "disabled='disabled'";								
						}			
					}else{
						$classColor = "select2-red";
						$corretor = " - ".$nomeCorretor[0];
						$disabled = "disabled='disabled'";							
					}	
?>
									<option class="<?php echo $classColor;?>" value="<?php echo trim($dadosLotesLista['nomeLote']);?>" <?php echo $disabled;?> ><?php echo trim($dadosLotesLista['nomeLote']).$corretor;?></option>	
<?php
				}
?>
								</select>										
							</p>
							<script>
								var $rf = jQuery.noConflict();
								
								$rf(".selectLote").select2({
									placeholder: "Selecione",
									multiple: true,
									allowClear: true,
									templateResult: function (data, container) {
										if (data.element) {
											$rf(container).addClass($rf(data.element).attr("class"));
										}
										return data.text;
									}									
								});		

								$rf(".selectLote").val("").trigger("change");																
							</script>
