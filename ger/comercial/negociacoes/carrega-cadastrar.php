<?php
	ob_start();
	session_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');

	$sqlUsuario = "SELECT * FROM usuarios WHERE statusUsuario = 'T' and codUsuario = ".$_COOKIE['codAprovado'.$cookie]." LIMIT 0,1";
	$resultUsuario = $conn->query($sqlUsuario);
	$dadosUsuario = $resultUsuario->fetch_assoc();	

	$_SESSION['cliente'] = "";
	$_SESSION['tipoPagamento'] = "";
	$_SESSION['resultado'] = "";
	$_SESSION['tipoCliente'] = "";
	$_SESSION['tipoImovel'] = "";
	$_SESSION['fPrecoD'] = "";
	$_SESSION['fPrecoA'] = "";
	$_SESSION['fechamento'] = "";
	$_SESSION['descricao'] = "";
	$_SESSION['midia'] = "";
	$_SESSION['codTipoCompromisso'] = "";
	$_SESSION['data'] = "";
	$_SESSION['hora'] = "";
	$_SESSION['usuario'] = "";
	$_SESSION['telefone'] = "";
	$_SESSION['cidade'] = "";
	$_SESSION['estado'] = "24";
?>		
						<form id="form-negociacao" action="" method="post" onSubmit="return cadastraNegociacao();">
							<div class="botao-expansivel" style="position:absolute; right:-15px; top:5px;" onClick="fechaCadastraNegociacao();"><div class="esquerda-botao"></div><input class="botao" type="button" value="X"/><div class="direita-botao"></div></div>
							<p class="titulo">Cadastrar Negociação</p>

							<p class="bloco-campo-float"><label class="label">Cliente: <span class="obrigatorio"> * </span></label>
							<input type="text" class="campo" style="width:220px;" required name="cliente" id="cliente" value="<?php echo $_SESSION['cliente'];?>" /></p>
							
							<p class="bloco-campo-float"><label class="label">Categoria: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipoPagamento" style="width:250px;" name="tipoPagamento">
									<option value="">Selecione</option>
<?php
	$sqlTipoPagamento = "SELECT nomeTipoPagamento, codTipoPagamento FROM tipoPagamento WHERE statusTipoPagamento = 'T' and tipoPagamento = 'R' ORDER BY nomeTipoPagamento ASC, codTipoPagamento ASC";
	$resultTipoPagamento = $conn->query($sqlTipoPagamento);
	while($dadosTipoPagamento = $resultTipoPagamento->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoPagamento['codTipoPagamento'];?>" <?php echo $_SESSION['tipoPagamento'] == $dadosTipoPagamento['codTipoPagamento'] ? '/SELECTED/' : '';?> ><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></option>
<?php
	}
?>
								</select>
							</p>	

							<p class="bloco-campo-float" style="width:120px;"><label class="label">Corretor(a): <span class="obrigatorio"> * </span></label>
<?php
	if($dadosUsuario['tipoUsuario'] != "C"){
?>
								<select class="campo" id="usuario" style="width:220px;" name="usuario">
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

							<p class="bloco-campo-float"><label class="label">Tipo Cliente: <span class="obrigatorio"> </span></label>
								<select class="campo" id="tipoCliente" style="width:172px;" name="tipoCliente">
									<option value="">Selecione</option>
									<option value="I" <?php echo $_SESSION['tipoCliente'] == "I" ? '/SELECTED/' : '';?> >Investidor</option>
									<option value="N" <?php echo $_SESSION['tipoCliente'] == "N" ? '/SELECTED/' : '';?> >Normal</option>
								</select>
							</p>	

							<p class="bloco-campo-float"><label class="label">Tipo Imóvel: <span class="obrigatorio"> </span></label>
								<select class="campo" id="tipoImovel" style="width:172px;" name="tipoImovel">
									<option value="">Selecione</option>
<?php
	$sqlTipoImovel = "SELECT nomeTipoImovel, codTipoImovel FROM tipoImovel WHERE statusTipoImovel = 'T' ORDER BY nomeTipoImovel ASC, codTipoImovel ASC";
	$resultTipoImovel = $conn->query($sqlTipoImovel);
	while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoImovel['codTipoImovel'];?>" <?php echo $_SESSION['tipoImovel'] == $dadosTipoImovel['codTipoImovel'] ? '/SELECTED/' : '';?> ><?php echo $dadosTipoImovel['nomeTipoImovel'];?></option>
<?php
	}
?>
								</select>
							</p>	

							<p class="bloco-campo-float"><label class="label">Faixa de Preço de: <span class="obrigatorio"> </span></label>
								<select class="campo" id="fPrecoD" style="width:175px;" name="fPrecoD">
									<option value="">Selecione</option>
									<option value="0.00" <?php echo $_SESSION['fPrecoD'] == "0.00" ? '/SELECTED/' : '';?> >R$ 0,00</option>
									<option value="50000.00" <?php echo $_SESSION['fPrecoD'] == "50000.00" ? '/SELECTED/' : '';?> >R$ 50.000,00</option>
									<option value="100000.00" <?php echo $_SESSION['fPrecoD'] == "100000.00" ? '/SELECTED/' : '';?> >R$ 100.000,00</option>
									<option value="150000.00" <?php echo $_SESSION['fPrecoD'] == "150000.00" ? '/SELECTED/' : '';?> >R$ 150.000,00</option>
									<option value="200000.00" <?php echo $_SESSION['fPrecoD'] == "200000.00" ? '/SELECTED/' : '';?> >R$ 200.000,00</option>
									<option value="250000.00" <?php echo $_SESSION['fPrecoD'] == "250000.00" ? '/SELECTED/' : '';?> >R$ 250.000,00</option>
									<option value="300000.00" <?php echo $_SESSION['fPrecoD'] == "300000.00" ? '/SELECTED/' : '';?> >R$ 300.000,00</option>
									<option value="500000.00" <?php echo $_SESSION['fPrecoD'] == "500000.00" ? '/SELECTED/' : '';?> >R$ 500.000,00</option>
									<option value="600000.00" <?php echo $_SESSION['fPrecoD'] == "600000.00" ? '/SELECTED/' : '';?> >R$ 600.000,00</option>
									<option value="700000.00" <?php echo $_SESSION['fPrecoD'] == "700000.00" ? '/SELECTED/' : '';?> >R$ 700.000,00</option>
									<option value="800000.00" <?php echo $_SESSION['fPrecoD'] == "800000.00" ? '/SELECTED/' : '';?> >R$ 800.000,00</option>
									<option value="900000.00" <?php echo $_SESSION['fPrecoD'] == "900000.00" ? '/SELECTED/' : '';?> >R$ 900.000,00</option>
									<option value="1000000.00" <?php echo $_SESSION['fPrecoD'] == "1000000.00" ? '/SELECTED/' : '';?> >R$ 1.000.000,00</option>
									<option value="1500000.00" <?php echo $_SESSION['fPrecoD'] == "1500000.00" ? '/SELECTED/' : '';?> >R$ 1.500.000,00</option>
									<option value="2000000.00" <?php echo $_SESSION['fPrecoD'] == "2000000.00" ? '/SELECTED/' : '';?> >+R$ 2.000.000,00</option>
								</select>
							</p>

							<p class="bloco-campo-float" style="margin-right:0px;"><label class="label">Faixa de Preço até: <span class="obrigatorio"> </span></label>
								<select class="campo" id="fPrecoA" style="width:175px;" name="fPrecoA">
									<option value="">Selecione</option>
									<option value="50000.00" <?php echo $_SESSION['fPrecoA'] == "50000.00" ? '/SELECTED/' : '';?> >R$ 50.000,00</option>
									<option value="100000.00" <?php echo $_SESSION['fPrecoA'] == "100000.00" ? '/SELECTED/' : '';?> >R$ 100.000,00</option>
									<option value="150000.00" <?php echo $_SESSION['fPrecoA'] == "150000.00" ? '/SELECTED/' : '';?> >R$ 150.000,00</option>
									<option value="200000.00" <?php echo $_SESSION['fPrecoA'] == "200000.00" ? '/SELECTED/' : '';?> >R$ 200.000,00</option>
									<option value="250000.00" <?php echo $_SESSION['fPrecoA'] == "250000.00" ? '/SELECTED/' : '';?> >R$ 250.000,00</option>
									<option value="300000.00" <?php echo $_SESSION['fPrecoA'] == "300000.00" ? '/SELECTED/' : '';?> >R$ 300.000,00</option>
									<option value="500000.00" <?php echo $_SESSION['fPrecoA'] == "500000.00" ? '/SELECTED/' : '';?> >R$ 500.000,00</option>
									<option value="600000.00" <?php echo $_SESSION['fPrecoA'] == "600000.00" ? '/SELECTED/' : '';?> >R$ 600.000,00</option>
									<option value="700000.00" <?php echo $_SESSION['fPrecoA'] == "700000.00" ? '/SELECTED/' : '';?> >R$ 700.000,00</option>
									<option value="800000.00" <?php echo $_SESSION['fPrecoA'] == "800000.00" ? '/SELECTED/' : '';?> >R$ 800.000,00</option>
									<option value="900000.00" <?php echo $_SESSION['fPrecoA'] == "900000.00" ? '/SELECTED/' : '';?> >R$ 900.000,00</option>
									<option value="1000000.00" <?php echo $_SESSION['fPrecoA'] == "1000000.00" ? '/SELECTED/' : '';?> >R$ 1.000.000,00</option>
									<option value="1500000.00" <?php echo $_SESSION['fPrecoA'] == "1500000.00" ? '/SELECTED/' : '';?> >R$ 1.500.000,00</option>
									<option value="2000000.00" <?php echo $_SESSION['fPrecoA'] == "2000000.00" ? '/SELECTED/' : '';?> >+R$ 2.000.000,00</option>
								</select>
							</p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label class="label">Etapa: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="resultado" style="width:240px;" required name="resultado" onChange="abreCompromissos(this.value);">
									<option value="C" >Lead</option>
									<option value="EM" >Apresentação</option>
									<option value="V" >Visita</option>
									<option value="EP">Fechamento</option>
									<option value="AC" >Contrato</option>
									<option value="R"  >Retorno</option>
								</select>
							</p>

							<p class="bloco-campo-float"><label class="label">Fechamento: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="fechamento" style="width:170px;" required name="fechamento" onChange="mostraLabel(this.value);">
									<option value="EA">Em Aberto</option>
									<option value="F">Fechado</option>
									<option value="NF">Não Fechado</option>
								</select>
							</p>
																
							<p class="bloco-campo-float"><label class="label">Mídia: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="midia" style="width:224px;" required name="midia">
									<option value="">Selecione</option>
									<option value="WH">Whatsapp</option>
									<option value="IN">Instagram</option>
									<option value="ES">Escritório</option>									
									<option value="FA">Facebook</option>
									<option value="SI">Site</option>
									<option value="ID">Indicação</option>
									<option value="EM">E-mail</option>
								</select>
							</p>									

							<p class="bloco-campo-float" style="float:left; margin-top:25px; margin-left:10px;">
							<label style="display:inherit; cursor:pointer;"><input onClick="abreCompromissos('S');" style="height:auto; cursor:pointer;" class="campo" type="checkbox" id="compromisso" name="compromisso" value="S"/> Compromisso <span class="obrigatorio"> </span></label></p>

							<br class="clear" />					

							<fieldset id="cadastra-compromisso" style="display:none;"> 
							   <legend>Cadastrar Compromisso</legend>

								<p class="bloco-campo-float"><label>Tipo Compromisso: <span class="obrigatorio"> * </span></label>
									<select id="codTipoCompromisso" style="width:350px;" disabled="disabled" required class="campo" name="codTipoCompromisso">
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
								<input class="campo" type="date" id="data" name="data" required disabled="disabled" style="width:150px;" id="data" value="<?php echo $_SESSION['data']; ?>"/></p>

								<p class="bloco-campo-float" style="margin-right:0px;"><label>Horário: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="time" style="width:150px;" required disabled="disabled" name="hora" id="hora" value="<?php echo $_SESSION['hora']; ?>"/></p>

								<p class="bloco-campo" style="margin-bottom:0px;"><label>Descrição: <span class="obrigatorio"></span></label>
								<textarea class="desabilita campo" id="descricaoCompromisso" disabled="disabled" name="descricaoCompromisso" style="width:686px; height:80px; padding-top:5px; padding-bottom:5px;" value=""></textarea></p>

							</fieldset>
							
							<br class="clear" />					
	
							<p class="bloco-campo-float"><label>Telefone: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="telefone" name="telefone" style="width:120px;" value="<?php echo $_SESSION['telefone']; ?>"  onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);"/></p>

							<p class="bloco-campo-float" style=""><label>Estado: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="estado" name="estado" style="width:282px;" required onChange="carregaCidade(this.value);">
									<option value="">Selecione</option>
<?php
				$sqlEstado = "SELECT nomeEstado, codEstado FROM estado WHERE statusEstado = 'T' ORDER BY nomeEstado ASC";
				$resultEstado = $conn->query($sqlEstado);
				while($dadosEstado = $resultEstado->fetch_assoc()){
?>
									<option value="<?php echo $dadosEstado['codEstado'] ;?>" <?php echo $_SESSION['estado'] == $dadosEstado['codEstado'] ? '/SELECTED/' : '';?> ><?php echo $dadosEstado['nomeEstado'] ;?></option>
<?php
				}
?>					
								</select>
								<br class="clear"/>
							</p>
							
<?php
				if($_SESSION['estado'] == ""){
?>													
							<div id="sel-padrao">
								<p class="bloco-campo-float" style="margin-right:0px;"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
									<select id="default-usage-select" id="cidade" class="campo" name="cidade" style="width:288px;">
										<option id="option" value="">Selecione um Estado primeiro</option>
									</select>
									<br class="clear"/>
								</p>
							</div>
<?php
				}
?>													
							<div id="carrega-cidade">
<?php
				if($_SESSION['estado'] != ""){
?>
								<p class="bloco-campo-float" style="margin-right:0px;"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
									<select class="campo" name="cidade" style="width:288px;" id="cidade">
										<option value="">Selecione</option>

<?php
					$sqlCidade = "SELECT * FROM cidade WHERE statusCidade = 'T' and codEstado = ".$_SESSION['estado']." ORDER BY nomeCidade ASC";
					$resultCidade = $conn->query($sqlCidade);
					while($dadosCidade = $resultCidade->fetch_assoc()){			
?>
										<option value="<?php echo $dadosCidade['codCidade']; ?>" <?php echo $dadosCidade['codCidade'] == $_SESSION['cidade'] ? '/SELECTED/' : ''; ?> ><?php echo $dadosCidade['nomeCidade']; ?></option>
<?php
					}
?>
									</select>
								</p>
<?php
				}
?>									
							</div>
							
							<br class="clear" />	
							
							<p class="bloco-campo" style="margin-bottom:10px;"><label>Andamento Negociação: <span class="obrigatorio"></span></label>
							<textarea class="desabilita campo" id="descricao" name="descricao" style="width:710px; height:70px; padding-top:5px; padding-bottom:5px;" value=""></textarea></p>
														
							<div class="botao-expansivel" style="display:table; float:none; margin: auto; padding-right:18px;"><div class="esquerda-botao"></div><input class="botao" type="submit" name="cadastrar" title="Salvar Negociação" value="Cadastrar Negociação" /><div class="direita-botao"></div></div>						
						</form>					
