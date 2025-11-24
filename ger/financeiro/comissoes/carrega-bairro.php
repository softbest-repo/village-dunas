<?php 
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');

	$codCidade = $_POST['codCidade'];
	
	if($codCidade != ""){
?>
									<div class="bloco-campo-float"><label class="label">Bairro: <span class="obrigatorio"> * </span></label>
										<select id="bairro" class="campo" name="bairro" required style="width:250px;" onChange="liberaCampos('B');">
											<option id="option" value="">Selecione um Bairro</option>
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
<?php
	}else{
?>
									<div class="bloco-campo-float"><label class="label">Bairro: <span class="obrigatorio"> * </span></label>
										<select id="bairro" class="campo" name="bairro" required style="width:250px;" onChange="liberaCampos('B');">
											<option id="option" value="">Selecione uma cidade primeiro</option>				
										</select>
									</div>
<?php		
	}
?>
