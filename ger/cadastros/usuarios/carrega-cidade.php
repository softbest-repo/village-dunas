<?php 
	include ('../../f/conf/config.php');

	$codEstado = $_POST['codEstado'];
?>
									<div class="bloco-campo-float" style="width:259px;"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
										<select id="cidade" class="campo" name="cidade" required style="width:200px;">
											<option id="option" value="">Selecione uma Cidade</option>
<?php
	$sqlCidade = "SELECT nomeCidade, codCidade FROM cidade WHERE statusCidade = 'T' and codEstado = ".$codEstado." ORDER BY nomeCidade ASC";
	$resultCidade = $conn->query($sqlCidade);
	while($dadosCidade = $resultCidade->fetch_assoc()){
?>
											<option value="<?php echo $dadosCidade['codCidade'] ;?>" <?php echo $_SESSION['cidade'] == $dadosCidade['codCidade'] ? '/SELECTED/' : '';?>><?php echo $dadosCidade['nomeCidade'];?></option>
<?php
	}
?>					
										</select>
									</div>
