<?php 
	include ('../../f/conf/config.php');

	$codCidade = $_POST['codCidade'];
?>
									<div class="bloco-campo-float"><label class="label">Bairro: <span class="obrigatorio"> * </span></label>
										<select id="bairro" class="campo" name="bairro" required style="width:230px;" onChange="carregaQuadra();">
											<option id="option" value="">Selecione uma Bairro</option>
<?php
	$sqlBairro = "SELECT nomeBairro, codBairro FROM bairros WHERE statusBairro = 'T' and codCidade = ".$codCidade." ORDER BY nomeBairro ASC";
	$resultBairro = $conn->query($sqlBairro);
	while($dadosBairro = $resultBairro->fetch_assoc()){
?>
											<option value="<?php echo $dadosBairro['codBairro'] ;?>" <?php echo $_SESSION['cidade'] == $dadosBairro['codBairro'] ? '/SELECTED/' : '';?>><?php echo $dadosBairro['nomeBairro'];?></option>
<?php
	}
?>					
										</select>
									</div>
