<?php
	ob_start();
	session_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');

	$sqlUsuario = "SELECT * FROM usuarios WHERE statusUsuario = 'T' and codUsuario = ".$_COOKIE['codAprovado'.$cookie]." LIMIT 0,1";
	$resultUsuario = $conn->query($sqlUsuario);
	$dadosUsuario = $resultUsuario->fetch_assoc();	

	$codNegociacao = $_GET['codNegociacao'];
	$confere = $_GET['confere'];
	
	$sqlCompromissos = "SELECT * FROM compromissos WHERE statusCompromisso = 'T' and codNegociacao = ".$codNegociacao." and dataCompromisso >= '".date('Y-m-d')."' ORDER BY codCompromisso DESC LIMIT 0,1";
	$resultCompromissos = $conn->query($sqlCompromissos);
	$dadosCompromissos = $resultCompromissos->fetch_assoc();
	
	if($dadosCompromissos['codCompromisso'] == "" || $confere == "T"){

		$_SESSION['nomeCompromisso'] = "";
		$_SESSION['colaborador'] = "";
		$_SESSION['codTipoCompromisso'] = "";
		$_SESSION['data'] = "";
		$_SESSION['hora'] = "";	
		$_SESSION['descricaoCompromisso'] = "";
?>		
						<form id="form-negociacao" action="" method="post" onSubmit="return cadastraCompromisso();">
							<div class="botao-expansivel" style="position:absolute; right:-15px; top:5px;" onClick="fecharCompromisso();"><div class="esquerda-botao"></div><input class="botao" type="button" value="X"/><div class="direita-botao"></div></div>
							<p class="titulo">Cadastrar Compromisso</p>

							<input type="hidden" value="<?php echo $codNegociacao;?>" name="codNegociacao" id="codNegociacao"/>

							<p class="bloco-campo-float"><label class="label">Nome: <span class="obrigatorio"> * </span></label>
							<input type="text" class="campo" style="width:400px;" required name="nomeCompromisso" id="nomeCompromisso" value="<?php echo $_SESSION['nomeCompromisso'];?>" /></p>

							<p class="bloco-campo-float"><label class="label">Corretor(a): <span class="obrigatorio"> * </span></label>
<?php
	if($dadosUsuario['tipoUsuario'] != "C"){
?>
								<select class="campo" id="usuario" style="width:300px;" required name="usuario">
									<option value="">Selecione</option>
<?php
	$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4 ORDER BY nomeUsuario ASC, codUsuario ASC";
	$resultUsuario = $conn->query($sqlUsuario);
	while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
									<option value="<?php echo $dadosUsuario['codUsuario'];?>" <?php echo $_COOKIE['codAprovado'.$cookie] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?> ><?php echo $dadosUsuario['nomeUsuario'];?></option>
<?php
	}
?>
								</select>
<?php
	}else{
?>
								<label style="font-weight:normal;"><?php echo $dadosUsuario['nomeUsuario'];?></label>
								<input type="hidden" name="usuario" id="usuario" value="<?php echo $dadosUsuario['codUsuario'];?>"/>
<?php
	}
?>							
							</p>
							
							<br class="clear"/>	
																																			
							<p class="bloco-campo-float"><label>Tipo Compromisso: <span class="obrigatorio"> * </span></label>
								<select id="codTipoCompromisso" style="width:372px;" required class="campo" name="codTipoCompromisso">
									<option value="" >Selecione</option>
<?php
		$sqlTipoCompromisso = "SELECT codTipoCompromisso, nomeTipoCompromisso FROM tipoCompromisso WHERE statusTipoCompromisso = 'T' ORDER BY nomeTipoCompromisso ASC";
		$resultTipoCompromisso = $conn->query($sqlTipoCompromisso);
		while($dadosTipoCompromisso = $resultTipoCompromisso->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoCompromisso['codTipoCompromisso'];?>" <?php echo $dadosTipoCompromisso['codTipoCompromisso'] == $_SESSION['codTipoCompromisso'] ? '/SELECTED/' : '';?> ><?php echo $dadosTipoCompromisso['nomeTipoCompromisso'];?></option>
<?php
		}
?>
								</select>						
							</p>

							<p class="bloco-campo-float"><label>Data: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="date" id="data" name="data" required style="width:150px;" id="data" value="<?php echo $_SESSION['data']; ?>"/></p>

							<p class="bloco-campo-float" style="margin-right:0px;"><label>Horário: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="time" style="width:150px;" required name="hora" id="hora" value="<?php echo $_SESSION['hora']; ?>"/></p>

							<p class="bloco-campo" style="margin-bottom:10px;"><label>Descrição: <span class="obrigatorio"></span></label>
							<textarea class="desabilita campo" id="descricaoCompromisso" name="descricaoCompromisso" style="width:710px; height:70px; padding-top:5px; padding-bottom:5px;" value=""></textarea></p>
														
							<div class="botao-expansivel" style="display:table; float:none; margin: auto; padding-right:18px;"><div class="esquerda-botao"></div><input class="botao" type="submit" name="cadastrar" title="Cadastrar Compromisso" value="Cadastrar Compromisso" /><div class="direita-botao"></div></div>						
						</form>					
<?php
	}else{
		
		$_SESSION['nomeCompromisso'] = $dadosCompromissos['nomeCompromisso'];
		$_SESSION['usuario'] = $dadosCompromissos['codUsuario'];
		$_SESSION['codTipoCompromisso'] = $dadosCompromissos['codTipoCompromisso'];
		$_SESSION['data'] = $dadosCompromissos['dataCompromisso'];
		$_SESSION['hora'] = $dadosCompromissos['horaCompromisso'];
		$_SESSION['descricaoCompromisso'] = $dadosCompromissos['descricaoCompromisso'];		
?>
						<form id="form-negociacao" action="" method="post" onSubmit="return alterarCompromisso();">
							<div class="botao-expansivel" style="position:absolute; right:-15px; top:5px;" onClick="fecharCompromisso();"><div class="esquerda-botao"></div><input class="botao" type="button" value="X"/><div class="direita-botao"></div></div>
							<p class="titulo">Alterar Compromisso</p>

							<input type="hidden" value="<?php echo $codNegociacao;?>" name="codNegociacao" id="codNegociacao"/>

							<p class="bloco-campo-float"><label class="label">Nome: <span class="obrigatorio"> * </span></label>
							<input type="text" class="campo" style="width:400px;" required name="nomeCompromisso" id="nomeCompromisso" value="<?php echo $_SESSION['nomeCompromisso'];?>" /></p>

							<p class="bloco-campo-float"><label class="label">Corretor(a): <span class="obrigatorio"> * </span></label>
<?php
	if($dadosUsuario['tipoUsuario'] != "C"){
?>
								<select class="campo" id="usuario" style="width:300px;" name="usuario" required >
									<option value="">Selecione</option>
<?php
	$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4 ORDER BY nomeUsuario ASC, codUsuario ASC";
	$resultUsuario = $conn->query($sqlUsuario);
	while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
									<option value="<?php echo $dadosUsuario['codUsuario'];?>" <?php echo $_SESSION['usuario'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?> ><?php echo $dadosUsuario['nomeUsuario'];?></option>
<?php
	}
?>
								</select>
<?php
	}else{
?>
								<label style="font-weight:normal;"><?php echo $dadosUsuario['nomeUsuario'];?></label>
								<input type="hidden" name="usuario" id="usuario" value="<?php echo $dadosUsuario['codUsuario'];?>"/>
<?php
	}
?>							
							</p>
							
							<br class="clear"/>	
																																			
							<p class="bloco-campo-float"><label>Tipo Compromisso: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="codTipoCompromisso" style="width:372px;" required name="codTipoCompromisso">
									<option value="" >Selecione</option>
<?php
		$sqlTipoCompromisso = "SELECT codTipoCompromisso, nomeTipoCompromisso FROM tipoCompromisso WHERE statusTipoCompromisso = 'T' ORDER BY nomeTipoCompromisso ASC";
		$resultTipoCompromisso = $conn->query($sqlTipoCompromisso);
		while($dadosTipoCompromisso = $resultTipoCompromisso->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoCompromisso['codTipoCompromisso'];?>" <?php echo $dadosTipoCompromisso['codTipoCompromisso'] == $_SESSION['codTipoCompromisso'] ? '/SELECTED/' : '';?> ><?php echo $dadosTipoCompromisso['nomeTipoCompromisso'];?></option>
<?php
		}
?>
								</select>						
							</p>

							<p class="bloco-campo-float"><label>Data: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="date" id="data" name="data" required style="width:150px;" id="data" value="<?php echo $_SESSION['data']; ?>"/></p>

							<p class="bloco-campo-float" style="margin-right:0px;"><label>Horário: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="time" style="width:150px;" required name="hora" id="hora" value="<?php echo $_SESSION['hora']; ?>"/></p>

							<p class="bloco-campo" style="margin-bottom:10px;"><label>Descrição: <span class="obrigatorio"></span></label>
							<textarea class="desabilita campo" id="descricaoCompromisso" name="descricaoCompromisso" style="width:710px; height:70px; padding-top:5px; padding-bottom:5px;"><?php echo $_SESSION['descricaoCompromisso'];?></textarea></p>
														
							<div class="botao-expansivel" style="display:table; float:none; margin: auto; padding-right:18px;"><div class="esquerda-botao"></div><input class="botao" type="submit" name="cadastrar" title="Alterar Compromisso" value="Alterar Compromisso" /><div class="direita-botao"></div></div>						
						</form>					
<?php		
	}		
?>
