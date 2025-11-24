<?php
	ob_start();
	session_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');
	include ('../../f/conf/functions.php');

	$sqlUsuario = "SELECT * FROM usuarios WHERE statusUsuario = 'T' and codUsuario = ".$_COOKIE['codAprovado'.$cookie]." LIMIT 0,1";
	$resultUsuario = $conn->query($sqlUsuario);
	$dadosUsuario = $resultUsuario->fetch_assoc();	
	
	$codNegociacao = $_GET['codNegociacao'];

	$sqlInfos = "SELECT N.*, C.codEstado FROM negociacoes N left join cidade C on N.codCidade = C.codCidade WHERE N.codNegociacao = ".$codNegociacao;
	$resultInfos = $conn->query($sqlInfos);
	$dadosInfos = $resultInfos->fetch_assoc();
	
	$_SESSION['cliente'] = $dadosInfos['nomeClienteNegociacao'];
	$_SESSION['tipoImovel'] = $dadosInfos['codTipoImovel'];
	$_SESSION['tipoPagamento'] = $dadosInfos['codTipoPagamento'];
	$_SESSION['resultado'] = $dadosInfos['resultadoNegociacao'];
	$_SESSION['fechamento'] = $dadosInfos['fechamentoNegociacao'];
	$_SESSION['descricao'] = $dadosInfos['descricaoNegociacao'];
	$_SESSION['motivo'] = $dadosInfos['motivoNegociacao'];
	$_SESSION['comentario'] = $dadosInfos['comentarioNegociacao'];
	$_SESSION['midia'] = $dadosInfos['midiaNegociacao'];
	$_SESSION['usuario'] = $dadosInfos['codUsuario'];
	$_SESSION['tipoCliente'] = $dadosInfos['tipoClienteNegociacao'];
	$_SESSION['fPrecoD'] = $dadosInfos['fPrecoDNegociacao'];
	$_SESSION['fPrecoA'] = $dadosInfos['fPrecoANegociacao'];
	$_SESSION['telefone'] = $dadosInfos['telefoneNegociacao'];
	$_SESSION['cidade'] = $dadosInfos['codCidade'];
	$_SESSION['estado'] = $dadosInfos['codEstado'];	
?>		
						<form id="form-negociacao" action="" enctype="multipart/form-data" method="post" onSubmit="return alteraNegociacao();">
						<p class="lixeira" style="position:absolute; left:20px; top:10px; cursor:pointer;" onClick="excluirNegociacao(<?php echo $codNegociacao;?>, '<?php echo $_SESSION['cliente'];?>');"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/lixeira-2.svg" width="17"/></p>
							<div class="botao-expansivel" style="position:absolute; right:-15px; top:5px;" onClick="fechaAlterarNegociacao();"><div class="esquerda-botao"></div><input class="botao" type="button" value="X"/><div class="direita-botao"></div></div>
							<p class="titulo">Alterar Negociação</p>

							<input type="hidden" value="<?php echo $codNegociacao;?>" name="codNegociacao" id="codNegociacao"/>

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
									<option value="0.00" <?php echo $_SESSION['fPrecoD'] == "0.00" && $_SESSION['fPrecoA'] != "0.00" ? '/SELECTED/' : '';?> >R$ 0,00</option>
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
									<option value="C" <?php echo $_SESSION['resultado'] == "C" ? '/SELECTED/' : '';?> >Lead</option>
									<option value="EM" <?php echo $_SESSION['resultado'] == "EM" ? '/SELECTED/' : '';?> >Apresentação</option>
									<option value="V" <?php echo $_SESSION['resultado'] == "V" ? '/SELECTED/' : '';?> >Visita</option>
									<option value="EP" <?php echo $_SESSION['resultado'] == "EP" ? '/SELECTED/' : '';?> >Fechamento</option>
									<option value="AC" <?php echo $_SESSION['resultado'] == "AC" ? '/SELECTED/' : '';?> >Contrato</option>
									<option value="R" <?php echo $_SESSION['resultado'] == "R" ? '/SELECTED/' : '';?> >Retorno</option>
								</select>
							</p>	

							<p class="bloco-campo-float"><label class="label">Fechamento: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="fechamento" style="width:240px;" required name="fechamento" onChange="mostraLabel(this.value);">
									<option value="EA" <?php echo $_SESSION['fechamento'] == 'EA' ? '/SELECTED/' : '';?> >Em Aberto</option>
									<option value="F" <?php echo $_SESSION['fechamento'] == 'F' ? '/SELECTED/' : '';?> >Fechado</option>
									<option value="NF" <?php echo $_SESSION['fechamento'] == 'NF' ? '/SELECTED/' : '';?> >Não Fechado</option>
								</select>
							</p>
																
							<p class="bloco-campo-float" style="width:215px;"><label class="label">Mídia: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="midia" style="width:225px;" required name="midia">
									<option value="">Selecione</option>
									<option value="WH" <?php echo $_SESSION['midia'] == 'WH' ? '/SELECTED/' : '';?> >Whatsapp</option>
									<option value="IN" <?php echo $_SESSION['midia'] == 'IN' ? '/SELECTED/' : '';?> >Instagram</option>
									<option value="ES" <?php echo $_SESSION['midia'] == 'ES' ? '/SELECTED/' : '';?> >Escritório</option>
									<option value="FA" <?php echo $_SESSION['midia'] == 'FA' ? '/SELECTED/' : '';?> >Facebook</option>
									<option value="SI" <?php echo $_SESSION['midia'] == 'SI' ? '/SELECTED/' : '';?> >Site</option>
									<option value="ID" <?php echo $_SESSION['midia'] == 'ID' ? '/SELECTED/' : '';?> >Indicação</option>
									<option value="EM" <?php echo $_SESSION['midia'] == 'EM' ? '/SELECTED/' : '';?> >E-mail</option>
								</select>
							</p>									
							
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
														
							<div class="botao-expansivel" style="display:table; float:none; margin: auto; padding-right:18px;"><div class="esquerda-botao"></div><input class="botao" type="submit" name="cadastrar" title="Alterar Negociação" value="Alterar Negociação" /><div class="direita-botao"></div></div>						
							<p id="ancora-andamento"></p>
							<div id="andamentos-negociacoes">
								<p class="titulo">Andamento Negociação</p>							
																
								<p class="bloco-campo"><label>Cadastrar Andamento: <span class="obrigatorio"></span></label>
								<textarea class="desabilita campo" id="descricaoAndamento" name="descricaoAndamento" style="width:710px; height:80px; padding-top:5px; padding-bottom:5px;"><?php echo $_SESSION['descricaoNegociacao']; ?></textarea></p>
							
								<div class="botao-expansivel" style="float:none; display:table; margin:0 auto; padding-right:18px;"><div class="esquerda-botao"></div><input class="botao" onClick="cadastraAndamentoNegociacao(<?php echo $codNegociacao;?>)" type="button" name="cadastro-andamento" title="Salvar Andamento da Negociação" value="Salvar Andamento da Negociação" /><div class="direita-botao"></div></div>						
								
								<br/>
<?php
				if($_SESSION['fechamento'] == "NF"){
?>								
								<div id="negociacao-status">
									<p style="color:#666; font-size:16px; padding-bottom:10px;"><strong style="font-size:16px;">Fechamento:</strong> Não Fechado</p>
									<p style="color:#666; font-size:16px; padding-bottom:10px;"><strong style="font-size:16px;">Motivo:</strong> <?php echo $_SESSION['motivo'];?></p>
									<p style="color:#666; font-size:16px; <?php echo $_SESSION['comentario'] == "" ? 'display:none;' : '';?>"><strong style="font-size:16px;">Comentário:</strong> <?php echo $_SESSION['comentario'];?></p>
								</div>
								<br/>
<?php
				}
?>								
								<div id="carrega-andamentos">	
									<table class="tabela-menus" style="width:727px; margin-top:10px;">	
										<tr class="titulo-tabela" border="none" style="height:25px;">
											<th class="canto-esq" style="font-size:13px; height:25px; text-align:left; padding-left:20px;">Usuário | Data</th>
											<th class="canto-dir" style="font-size:13px; height:25px; text-align:left; padding-left:20px;">Descrição</th>
										</tr>																				
<?php	
	$cont = 0;
	
	$sqlDecorrer = "SELECT ND.*, CO.nomeUsuario FROM negociacaoDecorrer ND inner join usuarios CO on ND.codUsuario = CO.codUsuario WHERE ND.codNegociacao = ".$codNegociacao." ORDER BY ND.codDecorrer DESC";	
	$resultDecorrer = $conn->query($sqlDecorrer);
	while($dadosDecorrer = $resultDecorrer->fetch_assoc()){
	
		$cont++;
		
		$descricaoDecorrer = str_replace("\r\n", "<br/>", $dadosDecorrer['mensagemDecorrer']);
?>
										<tr class="tr" style="background:#f5f5f5;">
											<td style="width:25%; text-align:left; padding-left:20px;"><strong><?php echo $dadosDecorrer['nomeUsuario'];?></strong> | <?php echo data($dadosDecorrer['dataDecorrer']);?></td>
											<td style="width:75%; text-align:left; padding-left:20px;"><?php echo $descricaoDecorrer;?></td>
										</tr>
<?php
	}
?>
									</table>
<?php
	if($cont == 0){

?>
									<p class="msg" style="font-size:14px; padding-top:20px; padding-bottom:20px;">Nenhum andamento cadastrado</p>
<?php
	}
?>
								</div>									
							</div>							
							<div id="andamentos-negociacoes">
								<p class="titulo">Anexos Andamento</p>							
								<div id="carregamento-upload" style="display:none;">
									<p class="texto">Carregando...</p>
								</div>
								<style>
									#carregamento-upload {width:300px; height:200px; position:fixed; z-index:100; left:50%; margin-left:-150px; top:50%; margin-top:-100px; background-color:#FFF; box-shadow:0px 0px 10px -3px #000; border:1px solid #ccc; border-radius:10px;}
									#carregamento-upload .texto {font-size:16px; color:#666; margin-top:65px; padding-top:50px; font-family:Arial; text-align:center; background:transparent url('<?php echo $configUrl;?>cadastros/clientes/loading.gif') center top no-repeat;}
								</style>	
								<div style="width:425px; margin:0 auto;">
									<label class="label" style="font-size:15px; line-height:30px; font-weight:normal;"><strong>Extensão:</strong> Todas | <strong>Tamanho:</strong> Max 20MB<br/><input style="display:block; margin-right:20px; float:left; padding-top:5px; height:27px;" type="file" class="campo" name="arquivo[]" id="arquivo" multiple="true" /></labeL>
									<div class="botao-expansivel" style="padding-top:3px;"><p class="esquerda-botao"></p><input class="botao" type="button" name="salvar" onClick="loadingUpload();" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div>						
									<input style="float:left;" type="hidden" value="<?php echo $url[5];?>" name="codCliente"/>
									<br class="clear"/>
								</div>
															
								<br/>							
								<div id="carrega-anexos">	
									<table class="tabela-menus" style="width:727px; margin-top:10px;">	
										<tr class="titulo-tabela" border="none" style="height:25px;">
											<th class="canto-esq" style="font-size:13px; height:25px; text-align:left; padding-left:20px;">Usuário | Data</th>
											<th style="font-size:13px; height:25px; text-align:left; padding-left:20px;">Anexo</th>
											<th class="canto-dir" style="font-size:13px; height:25px; text-align:center;">Excluir</th>
										</tr>																				
<?php	
	$cont = 0;
	
	$sqlAnexo = "SELECT * FROM negociacoesAnexos NA inner join usuarios U on NA.codUsuario = U.codUsuario WHERE NA.codNegociacao = ".$codNegociacao." ORDER BY NA.codNegociacaoAnexo DESC";	
	$resultAnexo = $conn->query($sqlAnexo);
	while($dadosAnexo = $resultAnexo->fetch_assoc()){
	
		$cont++;
		
		$replaceNome = str_replace(".".$dadosAnexo['extNegociacaoAnexo'], "", $dadosAnexo['nomeNegociacaoAnexo']);
?>
										<tr class="tr" style="background:#f5f5f5;">
											<td style="width:25%; text-align:left; padding-left:20px;"><strong><?php echo $dadosAnexo['nomeUsuario'];?></strong> | <?php echo data($dadosAnexo['dataNegociacaoAnexo']);?></td>
											<td style="width:65%; text-align:left; padding-left:20px;"><a target="_blank" download="<?php echo $replaceNome.".".$dadosAnexo['extNegociacaoAnexo'];?>" href="<?php echo $configUrlGer.'f/negociacoesAnexo/'.$dadosAnexo['codNegociacao'].'-'.$dadosAnexo['codNegociacaoAnexo'].'-O.'.$dadosAnexo['extNegociacaoAnexo'];?>"><?php echo $replaceNome.".".$dadosAnexo['extNegociacaoAnexo'];?></a></td>
											<td style="width:10%;"><span style="width:20px; height:19px; display:table; margin:0 auto; color:#FFF; padding-top:1px; cursor:pointer; text-align:center; background-color:#FF0000; border-radius:100%;" onClick="excluiAnexo(<?php echo $dadosAnexo['codNegociacaoAnexo'];?>)">X</span></td>
										</tr>
<?php
	}
?>
									</table>
<?php
	if($cont == 0){

?>
									<p class="msg" style="font-size:14px; padding-top:20px; padding-bottom:20px;">Nenhum anexo cadastrado</p>
<?php
	}
?>
								</div>									
							</div>	
							<div id="compromissos-negociacoes">
								<p class="titulo">Compromissos</p>																							
								<div id="carrega-andamentos">	
									<table class="tabela-menus" style="width:727px; margin-top:10px;">	
										<tr class="titulo-tabela" border="none" style="height:25px;">
											<th class="canto-esq" style="font-size:13px; height:25px; text-align:left; padding-left:10px;">Data e Hora</th>
											<th style="font-size:13px; height:25px; text-align:left; padding-left:10px;">Título</th>
											<th style="font-size:13px; height:25px; text-align:left; padding-left:10px;">Tipo</th>
											<th class="canto-dir" style="font-size:13px; height:25px; text-align:left; padding-left:10px;">Descrição</th>
										</tr>																				
<?php
	$cont = 0;
	
	$sqlCompromisso = "SELECT * FROM compromissos C inner join tipoCompromisso T on C.codTipoCompromisso = T.codTipoCompromisso inner join usuarios COL on C.codUsuario = COL.codUsuario WHERE codNegociacao = ".$codNegociacao." ORDER BY C.dataCompromisso DESC, C.horaCompromisso ASC, codCompromisso DESC";
	$resultCompromisso = $conn->query($sqlCompromisso);
	while($dadosCompromisso = $resultCompromisso->fetch_assoc()){
		
		$cont++;
		
		$descricaoCompromisso = str_replace("\r\n", "<br/>", $dadosCompromisso['descricaoCompromisso']);
		
		$horario = explode(":", $dadosCompromisso['horaCompromisso']);
		$horario = $horario[0].":".$horario[1];
		
		if($dadosCompromisso['dataCompromisso'] >= date('Y-m-d')){
			$background = "background:#b4dcff;";
		}else{
			$background = "";
		}
?>
										<tr class="tr" style="<?php echo $background;?>">
											<td style="width:20%; text-align:left; font-size:13px;"><strong style="font-size:13px;"><?php echo $dadosCompromisso['nomeUsuario'];?></strong><br/><?php echo data($dadosCompromisso['dataCompromisso']);?> | <?php echo $horario;?></td>
											<td style="width:25%; text-align:left; font-size:13px;"><?php echo $dadosCompromisso['nomeCompromisso'];?></td>
											<td style="width:25%; text-align:left; font-size:13px;"><?php echo $dadosCompromisso['nomeTipoCompromisso'];?></td>
											<td style="width:30%; text-align:left; font-size:13px;"><?php echo $descricaoCompromisso;?></td>
										</tr>
<?php
	}	
?>
									</table>
<?php
	if($cont == 0){

?>
									<p class="msg" style="font-size:14px; padding-top:20px; padding-bottom:20px;">Nenhum compromisso cadastrado</p>
<?php
	}
?>
								</div>									
							</div>		
						</form>					
