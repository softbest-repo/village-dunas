<?php 
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');

	$codPais = $_POST['codPais'];
?>
								<p class="bloco-campo-float"><label>Estado: <span class="obrigatorio"> * </span></label>
									<select class="campo" id="estado" name="estado" style="width:190px;" required onChange="carregaCidade(this.value);">
										<option value="">Selecione</option>
<?php
				$sqlEstado = "SELECT nomeEstado, codEstado FROM estado WHERE statusEstado = 'T' and codPais = ".$codPais." ORDER BY nomeEstado ASC";
				$resultEstado = $conn->query($sqlEstado);
				while($dadosEstado = $resultEstado->fetch_assoc()){
?>
										<option value="<?php echo $dadosEstado['codEstado'] ;?>" <?php echo $_SESSION['estado'] == $dadosEstado['codEstado'] ? '/SELECTED/' : '';?>><?php echo $dadosEstado['nomeEstado'] ;?></option>
<?php
				}
?>					
									</select>
									<br class="clear"/>
								</p>
