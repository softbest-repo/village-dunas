<?php 
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');

	$codCidade = $_POST['codCidade'];
?>
									<div class="bloco-campo-float"><label class="label">Bairro: <span class="obrigatorio"> </span></label>
										<select id="bairro-filtro" class="campo" name="bairro-filtro" style="width:180px; height:34px; margin-right:0px;">
											<option id="option" value="">Selecione uma Bairro</option>
<?php
	$sqlBairro = "SELECT nomeBairro, codBairro FROM bairros WHERE statusBairro = 'T' and codCidade = ".$codCidade." ORDER BY nomeBairro ASC";
	$resultBairro = $conn->query($sqlBairro);
	while($dadosBairro = $resultBairro->fetch_assoc()){
?>
											<option value="<?php echo $dadosBairro['codBairro'] ;?>" <?php echo $_SESSION['bairro-filtro'] == $dadosBairro['codBairro'] ? '/SELECTED/' : '';?>><?php echo $dadosBairro['nomeBairro'];?></option>
<?php
	}
?>					
										</select>
									</div>
