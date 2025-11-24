<?php 
	include ('f/conf/config.php');

	$codCidade = $_POST['codCidade'];
	
	if($codCidade == ""){
?>
										<p class="bloco-campo-float">
											<select class="campo" id="loteamentoFiltroSite" name="loteamentoFiltroSite">
												<option value="">Loteamentos</option>
												<option value="">Todos</option>
<?php
		$sqlLoteamentos = "SELECT * FROM loteamentos WHERE statusLoteamento =  'T' ORDER BY codLoteamento ASC";
		$resultLoteamentos = $conn->query($sqlLoteamentos);
		while($dadosLoteamentos = $resultLoteamentos->fetch_assoc()){
?>
												<option value="<?php echo $dadosLoteamentos['codLoteamento'];?>" <?php echo $_SESSION['loteamentoFiltroSite'] == $dadosLoteamentos['codLoteamento'] ? '/SELECTED/' : '';?>><?php echo $dadosLoteamentos['nomeLoteamento'];?></option>
<?php
		}
?>
											</select>
										</p>
<?php
	}else{
?>
										<p class="bloco-campo-float">
											<select class="campo" id="loteamentoFiltroSite" name="loteamentoFiltroSite">
												<option value="">Loteamentos</option>
												<option value="">Todos</option>
<?php
		$sqlLoteamentos = "SELECT * FROM loteamentos WHERE statusLoteamento =  'T' and codCidade = ".$codCidade." ORDER BY nomeLoteamento ASC";
		$resultLoteamentos = $conn->query($sqlLoteamentos);
		while($dadosLoteamentos = $resultLoteamentos->fetch_assoc()){
?>
												<option value="<?php echo $dadosLoteamentos['codLoteamento'];?>" <?php echo $_SESSION['loteamentoFiltroSite'] == $dadosLoteamentos['codLoteamento'] ? '/SELECTED/' : '';?>><?php echo $dadosLoteamentos['nomeLoteamento'];?></option>
<?php
		}
?>
											</select>
										</p>
<?php
	}
?>
