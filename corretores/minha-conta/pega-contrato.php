<?php 
	session_start();
	
	include ('../f/conf/config.php');
	include ('../f/conf/functions.php');

	$codContrato = $_POST['codContrato'];
	
	$sqlContratos = "SELECT * FROM contratos CO inner join lotes L on CO.codLote = L.codLote inner join quadras Q on L.codQuadra = Q.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join cidades C on LO.codCidade = C.codCidade WHERE CO.codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and CO.codContrato = ".$codContrato." GROUP BY CO.codContrato ORDER BY CO.dataContrato DESC";
	$resultContratos = $conn->query($sqlContratos);
	$dadosContratos = $resultContratos->fetch_assoc();
	
	$sqlContrato = "SELECT * FROM contratos WHERE codContrato = ".$dadosContratos['codContrato']." LIMIT 0,1";
	$resultContrato = $conn->query($sqlContrato);
	$dadosContrato = $resultContrato->fetch_assoc();
	
	$sqlCorretor = "SELECT * FROM corretores WHERE codCorretor = ".$dadosContrato['codCorretor']." LIMIT 0,1";
	$resultCorretor = $conn->query($sqlCorretor);
	$dadosCorretor = $resultCorretor->fetch_assoc();
	
	$sqlLote = "SELECT * FROM lotes WHERE codLote = ".$dadosContratos['codLote']." LIMIT 0,1";
	$resultLote = $conn->query($sqlLote);
	$dadosLote = $resultLote->fetch_assoc();
	
	$sqlLoteamento = "SELECT * FROM loteamentos WHERE codLoteamento = ".$dadosContratos['codLoteamento']." LIMIT 0,1";
	$resultLoteamento = $conn->query($sqlLoteamento);
	$dadosLoteamento = $resultLoteamento->fetch_assoc();
	
	if($dadosLote['codConta'] != 0){
		$sqlConta = "SELECT * FROM contas WHERE codConta = ".$dadosLote['codConta']." ORDER BY codConta ASC LIMIT 0,1";
		$resultConta = $conn->query($sqlConta);
		$dadosConta = $resultConta->fetch_assoc();	
	}else{
		$sqlConta = "SELECT * FROM contas WHERE codConta = ".$dadosLoteamento['codConta']." ORDER BY codConta ASC LIMIT 0,1";
		$resultConta = $conn->query($sqlConta);
		$dadosConta = $resultConta->fetch_assoc();			
	}

	$sqlUniaoMaster = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosLote['codLote']." or codUnido = ".$dadosLote['codLote']." ORDER BY codLote ASC LIMIT 0,1";
	$resultUniaoMaster = $conn->query($sqlUniaoMaster);
	$dadosUniaoMaster = $resultUniaoMaster->fetch_assoc();
	
	if($dadosUniaoMaster['codLoteUnido'] != ""){
		$sqlUniao = "SELECT * FROM lotesUnidos LU inner join lotes L on LU.codLote = L.codLote WHERE L.codLote = ".$dadosUniaoMaster['codLote']." ORDER BY LU.codLoteUnido ASC";
		$resultUniao = $conn->query($sqlUniao);
		$dadosUniao = $resultUniao->fetch_assoc();
		
		$lote = $dadosUniao['nomeLote'];
		$precoLote = $dadosUniao['precoLote'];
		
		$sqlUniao = "SELECT * FROM lotesUnidos LU inner join lotes L on LU.codUnido = L.codLote WHERE LU.codLote = ".$dadosUniaoMaster['codLote']." ORDER BY LU.codLote ASC";
		$resultUniao = $conn->query($sqlUniao);
		while($dadosUniao = $resultUniao->fetch_assoc()){
			$lote .= ", ".$dadosUniao['nomeLote'];
			$precoLote = $precoLote + $dadosUniao['precoLote'];
		}
	
	}else{
		$lote = $dadosLote['nomeLote'];
		$precoLote = $dadosLote['precoLote'];
	}	
	
	if($dadosContrato['loteamentoIntencao'] != ""){
		$_SESSION['nomeIntencao'] = $dadosContratos['nomeIntencao'];
		$_SESSION['nascimentoIntencao'] = data($dadosContratos['nascimentoIntencao']);
		$_SESSION['cpfIntencao'] = $dadosContratos['cpfIntencao'];
		$_SESSION['rgIntencao'] = $dadosContratos['rgIntencao'];
		$_SESSION['orgaoIntencao'] = $dadosContratos['orgaoIntencao'];
		$_SESSION['profissaoIntencao'] = $dadosContratos['profissaoIntencao'];
		$_SESSION['nacionalidadeIntencao'] = $dadosContratos['nacionalidadeIntencao'];
		$_SESSION['estadoCivilIntencao'] = $dadosContratos['estadoCivilIntencao'];
		$_SESSION['conjugeIntencao'] = $dadosContratos['conjugeIntencao'];
		$_SESSION['nascimentoConjugeIntencao'] = data($dadosContratos['nascimentoConjugeIntencao']);
		$_SESSION['cpfConjugeIntencao'] = $dadosContratos['cpfConjugeIntencao'];
		$_SESSION['rgConjugeIntencao'] = $dadosContratos['rgConjugeIntencao'];
		$_SESSION['orgaoConjugeIntencao'] = $dadosContratos['orgaoConjugeIntencao'];
		$_SESSION['profissaoConjugeIntencao'] = $dadosContratos['profissaoConjugeIntencao'];
		$_SESSION['enderecoIntencao'] = $dadosContratos['enderecoIntencao'];
		$_SESSION['cepIntencao'] = $dadosContratos['cepIntencao'];
		$_SESSION['telefoneIntencao'] = $dadosContratos['telefoneIntencao'];
		$_SESSION['emailIntencao'] = $dadosContratos['emailIntencao'];
		$_SESSION['telefone2Intencao'] = $dadosContratos['telefone2Intencao'];
		$_SESSION['email2Intencao'] = $dadosContratos['email2Intencao'];
		$_SESSION['loteamentoIntencao'] = $dadosContratos['loteamentoIntencao'];
		$_SESSION['cidadeIntencao'] = $dadosContratos['cidadeIntencao'];
		$_SESSION['loteIntencao'] = $dadosContratos['loteIntencao'];
		$_SESSION['quadraIntencao'] = $dadosContratos['quadraIntencao'];
		$_SESSION['tamanhoIntencao'] = $dadosContratos['tamanhoIntencao'];
		$_SESSION['ruaIntencao'] = $dadosContratos['ruaLote'];
		$_SESSION['matriculaIntencao'] = $dadosContratos['matriculaIntencao'];
		if($dadosContratos['totalIntencao'] != ""){
			$_SESSION['totalIntencao'] = number_format($dadosContratos['totalIntencao'], 2, ",", ".");
		}else{
			$_SESSION['totalIntencao'] = "";
		}
		if($dadosContratos['sinalIntencao'] != ""){
			$_SESSION['sinalIntencao'] = number_format($dadosContratos['sinalIntencao'], 2, ",", ".");
		}else{
			$_SESSION['sinalIntencao'] = "";
		}
		if($dadosContratos['saldoIntencao'] != ""){
			$_SESSION['saldoIntencao'] = number_format($dadosContratos['saldoIntencao'], 2, ",", ".");
		}else{
			$_SESSION['saldoIntencao'] = "";
		}
		$_SESSION['valorInIntencao'] = $dadosContratos['valorInIntencao'];
		$_SESSION['formaIntencao'] = $dadosContratos['formaIntencao'];
		$_SESSION['dataParcelaIntencao'] = $dadosContratos['dataParcelaIntencao'];
		$_SESSION['declaracaoIntencao'] = $dadosContratos['declaracaoIntencao'];
		$_SESSION['cidadeDataIntencao'] = $dadosContratos['cidadeDataIntencao'];
		$_SESSION['estadoDataIntencao'] = $dadosContratos['estadoDataIntencao'];
		$_SESSION['diaDataIntencao'] = $dadosContratos['diaDataIntencao'];
		$_SESSION['mesDataIntencao'] = $dadosContratos['mesDataIntencao'];
	}else{	
		$_SESSION['nomeIntencao'] = "";
		$_SESSION['nascimentoIntencao'] = "";
		$_SESSION['cpfIntencao'] = "";
		$_SESSION['rgIntencao'] = "";
		$_SESSION['orgaoIntencao'] = "";
		$_SESSION['nacionalidadeIntencao'] = "";
		$_SESSION['estadoCIntencao'] = "";
		$_SESSION['conjugeIntencao'] = "";
		$_SESSION['nascimentoConjugeIntencao'] = "";
		$_SESSION['cpfConjugeIntencao'] = "";
		$_SESSION['rgConjugeIntencao'] = "";
		$_SESSION['orgaoConjugeIntencao'] = "";
		$_SESSION['profissaoConjugeIntencao'] = "";
		$_SESSION['enderecoIntencao'] = "";
		$_SESSION['cepIntencao'] = "";
		$_SESSION['telefoneIntencao'] = "";
		$_SESSION['emailIntencao'] = "";
		$_SESSION['telefone2Intencao'] = "";
		$_SESSION['email2Intencao'] = "";
		$_SESSION['loteamentoIntencao'] = $dadosContratos['nomeLoteamento'];
		$_SESSION['cidadeIntencao'] = $dadosContratos['nomeCidade'];
		$_SESSION['loteIntencao'] = $lote;
		$_SESSION['quadraIntencao'] = $dadosContratos['nomeQuadra'];
		$_SESSION['tamanhoIntencao'] = $dadosContratos['frenteLote']." x ".$dadosContratos['fundosLote'];
		$_SESSION['ruaIntencao'] = $dadosContratos['ruaLote'];
		$_SESSION['matriculaIntencao'] = $dadosContratos['matriculaLote'];	
		$_SESSION['totalIntencao'] = number_format($precoLote, 2, ",", ".");
		$_SESSION['valorInIntencao'] = $precoLote;
		$_SESSION['sinalIntencao'] = "";
		$_SESSION['saldoIntencao'] = "";
		$_SESSION['formaIntencao'] = "";
		$_SESSION['dataParcelaIntencao'] = "";
		$_SESSION['declaracaoIntencao'] = "";
		$_SESSION['cidadeDataIntencao'] = "";
		$_SESSION['estadoDataIntencao'] = "";
		$_SESSION['diaDataIntencao'] = "";
		$_SESSION['mesDataIntencao'] = "";		
	}
?>
													<script>													
														function moeda(z){  
															v = z.value;
															v=v.replace(/\D/g,"")  //permite digitar apenas números
														v=v.replace(/[0-9]{12}/,"inválido")   //limita pra máximo 999.999.999,99
														v=v.replace(/(\d{1})(\d{8})$/,"$1.$2")  //coloca ponto antes dos últimos 8 digitos
														v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")  //coloca ponto antes dos últimos 5 digitos
														v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2")	//coloca virgula antes dos últimos 2 digitos
															z.value = v;
														}		
														
														function salvaInformacao(){
															var $bj = jQuery.noConflict();
															var dadosIntencao = {
																codContrato: <?php echo $codContrato;?>,
																nomeIntencao: document.getElementById("nomeIntencao").value,
																nascimentoIntencao: document.getElementById("nascimentoIntencao").value,
																cpfIntencao: document.getElementById("cpfIntencao").value,
																rgIntencao: document.getElementById("rgIntencao").value,
																orgaoIntencao: document.getElementById("orgaoIntencao").value,
																profissaoIntencao: document.getElementById("profissaoIntencao").value,
																nacionalidadeIntencao: document.getElementById("nacionalidadeIntencao").value,
																estadoCivilIntencao: document.getElementById("estadoCivilIntencao").value,
																conjugeIntencao: document.getElementById("conjugeIntencao").value,
																nascimentoConjugeIntencao: document.getElementById("nascimentoConjugeIntencao").value,
																cpfConjugeIntencao: document.getElementById("cpfConjugeIntencao").value,
																rgConjugeIntencao: document.getElementById("rgConjugeIntencao").value,
																orgaoConjugeIntencao: document.getElementById("orgaoConjugeIntencao").value,
																profissaoConjugeIntencao: document.getElementById("profissaoConjugeIntencao").value,
																enderecoIntencao: document.getElementById("enderecoIntencao").value,
																cepIntencao: document.getElementById("cepIntencao").value,
																telefoneIntencao: document.getElementById("telefoneIntencao").value,
																emailIntencao: document.getElementById("emailIntencao").value,
																telefone2Intencao: document.getElementById("telefone2Intencao").value,
																email2Intencao: document.getElementById("email2Intencao").value,
																loteamentoIntencao: document.getElementById("loteamentoIntencao").value,
																cidadeIntencao: document.getElementById("cidadeIntencao").value,
																loteIntencao: document.getElementById("loteIntencao").value,
																quadraIntencao: document.getElementById("quadraIntencao").value,
																tamanhoIntencao: document.getElementById("tamanhoIntencao").value,
																ruaIntencao: document.getElementById("ruaIntencao").value,
																matriculaIntencao: document.getElementById("matriculaIntencao").value,
																totalIntencao: document.getElementById("totalIntencao").value,
																sinalIntencao: document.getElementById("sinalIntencao").value,
																saldoIntencao: document.getElementById("saldoIntencao").value,
																valorInIntencao: "<?php echo $_SESSION['valorInIntencao'];?>",
																formaIntencao: document.getElementById("formaIntencao").value,
																dataParcelaIntencao: document.getElementById("dataParcelaIntencao").value,
																nomeDeclaracaoIntencao: document.getElementById("nomeDeclaracaoIntencao").value,
																cidadeDataIntencao: document.getElementById("cidadeDataIntencao").value,
																estadoDataIntencao: document.getElementById("estadoDataIntencao").value,
																diaDataIntencao: document.getElementById("diaDataIntencao").value,
																mesDataIntencao: document.getElementById("mesDataIntencao").value
															};

															$bj.post("<?php echo $configUrl;?>minha-conta/salva-intencao.php", dadosIntencao, function(data) {
																if(data.trim() == "ok"){
																	var $tg = jQuery.noConflict();

																	$tg('.editando').css('display', 'none');

																	var printContents = document.getElementById("conteudo-requisicao").cloneNode(true);

																	var originalInputs = document.getElementById("conteudo-requisicao").querySelectorAll("input, textarea");
																	var clonedInputs = printContents.querySelectorAll("input, textarea");

																	originalInputs.forEach((input, index) => {
																		if (clonedInputs[index]) {
																			clonedInputs[index].value = input.value;
																		}
																	});

																	var originalContents = document.body.innerHTML;
																	document.body.innerHTML = "";
																	document.body.appendChild(printContents);

																	window.print();

																	document.body.innerHTML = originalContents;
																	$tg('.editando').css('display', 'block');
																	fechaImprimir();
																}
															}).fail(function(error) {
																console.error("Erro:", error);
															});	
														}												
													</script>    
													<p class="fundo-preto" onClick="fechaImprimir();" style="width:100%; height:100%; position:fixed; left:0; top:0; background:rgba(0,0,0,0.8);"></p>
													<div id="conteudo-imprimir" style="width:900px; min-height:61px; display:block; position:fixed; z-index:1; top:50%; left:50%; transform:translate(-50%, -50%); box-shadow:0px 0px 20px #528585; border-radius:10px; background-color:#FFFFFF;">
														<div style="padding:10px 20px; border-bottom:1px solid #ccc; text-align:center;"><strong style="font-weight:bold; display:block; text-align:center; color:#002c23; padding-bottom:5px;">Conta para depósito do Sinal de Arras:</strong><strong style="font-size:14px; color:#002c23; <?php echo $dadosConta['pixConta'] == "" ? 'display:none;' : '';?>">Chave Pix:</strong> <?php echo $dadosConta['pixConta'];?><span style="<?php echo $dadosConta['pixConta'] == "" ? 'display:none;' : '';?>"> | </span><strong style="font-size:14px; color:#002c23; <?php echo $dadosConta['nomeConta'] == "" ? 'display:none;' : '';?>">Razão Social:</strong> <?php echo $dadosConta['nomeConta'];?><br style="<?php echo $dadosConta['nomeConta'] == "" ? 'display:none;' : '';?>"/><strong style="font-size:14px; color:#002c23; <?php echo $dadosConta['agenciaConta'] == "" ? 'display:none;' : '';?>">Agência:</strong> <?php echo $dadosConta['agenciaConta'];?> <span style="<?php echo $dadosConta['agenciaConta'] == "" ? 'display:none;' : '';?>">|</span> <strong style="font-size:14px; color:#002c23; <?php echo $dadosConta['contaConta'] == "" ? 'display:none;' : '';?>">Conta:</strong> <?php echo $dadosConta['contaConta'];?><span style="<?php echo $dadosConta['agenciaConta'] == "" && $dadosConta['contaConta'] == "" ? 'display:none;' : '';?>"> | </span><strong style="font-size:14px; color:#002c23; <?php echo $dadosConta['bancoConta'] == "" ? 'display:none;' : '';?>">Banco:</strong> <?php echo $dadosConta['bancoConta'];?> <span style="<?php echo $dadosConta['bancoConta'] == "" ? 'display:none;' : '';?>">|</span> <strong style="font-size:14px; color:#002c23; <?php echo $dadosConta['cnpjConta'] == "" ? 'display:none;' : '';?>">CNPJ:</strong> <?php echo $dadosConta['cnpjConta'];?></div>
														<div id="conteudo-scroll" style="width:900px; height:400px;">
															<p class="botao-fechar" onClick="fechaImprimir();" style="width:28px; color:#FFFFFF; padding:1px; padding-top:2px; text-align: center; cursor: pointer; position: absolute; z-index:1; background-color:#FF0000; border-radius:235px; font-size:18px; margin-left:890px; margin-top:-130px;">X</p>
															<div id="imprime-requisicao" style="width:862px; margin-top:20px; margin-bottom:20px; margin:20px auto; height:380px; overflow-y:auto; overflow-x:hidden;">
																<div id="conteudo-requisicao" style="width:862px;">
																	<div id="mostra-dados" style="width:850px;">
																		<div class="fecha-docs" id="contrato" style="width:850px; display:block; height:100%;">
																			<p id="botao-alterar-contrato" class="botao-alterar" onClick="salvaInformacao();" style="width:170px; text-align:center; position:absolute; cursor:pointer; padding:2px 20px; margin-top:-143px; margin-left:340px; border-radius:15px; background-color:#00b816; color:#FFF;">Salvar e Imprimir PDF</p>
																			<p class="editando" style="color:#FFF; position:absolute; font-size:14px; left:0; margin-top:-138px;">Editando contrato <strong style="color:#FFF; font-size:14px;"><?php echo $contrato;?></strong></p>																		
																			<p style="margin:0px; padding:0px; display:flex;"><img src="<?php echo $configUrl;?>f/i/quebrado/topo-sanferreira.png" width="100%"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-weight:bold; color:#000; font-size:18px; text-align:center; font-family:Arial;">PROPOSTA DE COMPRA DE BEM(NS) IMÓVEL(EIS)</p>
																			<p style="margin:0px; padding:0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; padding-top:25px;">Identificação do(a) Comprador(a): </p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">Nome: <input type="text" value="<?php echo $_SESSION['nomeIntencao'];?>" id="nomeIntencao" style="width:456px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Data de Nascimento: <input type="text" value="<?php echo $_SESSION['nascimentoIntencao'] != '00/00/0000' ? $_SESSION['nascimentoIntencao'] : '';?>" id="nascimentoIntencao" style="width:180px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">CPF: <input type="text" value="<?php echo $_SESSION['cpfIntencao'];?>" id="cpfIntencao" style="width:230px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">RG: <input type="text" value="<?php echo $_SESSION['rgIntencao'];?>" id="rgIntencao" style="width:230px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Órgão Expedidor: <input type="text" value="<?php echo $_SESSION['orgaoIntencao'];?>" id="orgaoIntencao" style="width:168px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Nacionalidade: <input type="text" value="<?php echo $_SESSION['nacionalidadeIntencao'];?>" id="nacionalidadeIntencao" style="width:190px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Estado Civil: <input type="text" value="<?php echo $_SESSION['estadoCivilIntencao'];?>" id="estadoCivilIntencao" style="width:170px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Profissão: <input type="text" value="<?php echo $_SESSION['profissaoIntencao'];?>" id="profissaoIntencao" style="width:206px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">Cônjuge ou 2º Comprador(a): <input type="text" value="<?php echo $_SESSION['conjugeIntencao'];?>" id="conjugeIntencao" style="width:327px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Data de Nascimento: <input type="text" value="<?php echo $_SESSION['nascimentoConjugeIntencao'] != "00/00/0000" ? $_SESSION['nascimentoConjugeIntencao'] : '';?>" id="nascimentoConjugeIntencao" style="width:145px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">CPF: <input type="text" value="<?php echo $_SESSION['cpfConjugeIntencao'];?>" id="cpfConjugeIntencao" style="width:164px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">RG: <input type="text" value="<?php echo $_SESSION['rgConjugeIntencao'];?>" id="rgConjugeIntencao" style="width:120px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Órgão Expedidor: <input type="text" value="<?php echo $_SESSION['orgaoConjugeIntencao'];?>" id="orgaoConjugeIntencao" style="width:60px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Profissão: <input type="text" value="<?php echo $_SESSION['profissaoConjugeIntencao'];?>" id="profissaoConjugeIntencao" style="width:206px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Endereço: <input type="text" value="<?php echo $_SESSION['enderecoIntencao'];?>" id="enderecoIntencao" style="width:772px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">CEP: <input type="text" value="<?php echo $_SESSION['cepIntencao'];?>" id="cepIntencao" style="width:200px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;" onKeyDown="Mascara(this,Cep);" onKeyPress="Mascara(this,Cep);" onKeyUp="Mascara(this,Cep);"/></p>																			
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">Telefone: <input type="text" value="<?php echo $_SESSION['telefoneIntencao'];?>" id="telefoneIntencao" style="width:200px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;" onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">E-mail: <input type="email" value="<?php echo $_SESSION['emailIntencao'];?>" id="emailIntencao" style="width:266px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">Telefone 2: <input type="text" value="<?php echo $_SESSION['telefone2Intencao'];?>" id="telefone2Intencao" style="width:300px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;" onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">E-mail 2: <input type="email" value="<?php echo $_SESSION['email2Intencao'];?>" id="email2Intencao" style="width:391px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:0px; font-size:17px; color:#000; font-family:Arial; font-weight:normal; padding-top:25px;">A presente proposta tem como objeto o(s) seguinte(s) imóvel(is):</p>
																			<p style="margin:0px; padding:0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; padding-top:20px;">Dados do Imóvel: </p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left; margin-right:10px;">Loteamento: <input type="text" value="<?php echo $_SESSION['loteamentoIntencao'];?>" id="loteamentoIntencao" style="width:350px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Cidade: <input type="text" value="<?php echo $_SESSION['cidadeIntencao'];?>" id="cidadeIntencao" style="width:336px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Lote(s): <input type="text" value="<?php echo $_SESSION['loteIntencao'];?>" id="loteIntencao" style="width:790px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Quadra(s): <input type="text" value="<?php echo $_SESSION['quadraIntencao'];?>" id="quadraIntencao" style="width:768px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Tamanho: <input type="text" value="<?php echo $_SESSION['tamanhoIntencao'];?>" id="tamanhoIntencao" style="width:774px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Rua: <input type="text" value="<?php echo $_SESSION['ruaIntencao'];?>" id="ruaIntencao" style="width:811px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Matrícula(s): <input type="text" value="<?php echo $_SESSION['matriculaIntencao'];?>" id="matriculaIntencao" style="width:755px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; padding-top:20px;">Condições de Compra: </p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Valor total do(s) imóvel(is): <input type="text" value="<?php echo $_SESSION['totalIntencao'];?>" id="totalIntencao" onKeyup="moeda(this);" style="width:653px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Sinal de negócio: <input type="text" value="<?php echo $_SESSION['sinalIntencao'];?>" id="sinalIntencao" onKeyup="moeda(this);" style="width:721px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Saldo devedor: <input type="text" value="<?php echo $_SESSION['saldoIntencao'];?>" id="saldoIntencao" onKeyup="moeda(this);" style="width:737px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Forma de Pagamento: <textarea id="formaIntencao" style="width:687px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"><?php echo $_SESSION['formaIntencao'];?></textarea></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; float:left;">Data das parcelas: <input type="text" value="<?php echo $_SESSION['dataParcelaIntencao'];?>" id="dataParcelaIntencao" style="width:712px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/></p>
																			<br class="clear"/>
																			<p style="margin:0px; padding:0px; font-size:16px; color:#000; font-family:Arial; font-weight:bold; padding-top:20px;">Declaração do Comprador: </p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; line-height:150%;">Eu, <input type="text" value="<?php echo $_SESSION['declaracaoIntencao'];?>" id="nomeDeclaracaoIntencao" style="width:300px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/>, já qualificado, declaro a minha intenção de comprar o(s) imóvel(is) descrito(s) nesta proposta. Estou ciente e de acordo com todas as condições, direitos e obrigações relacionados a esta transação imobiliária, conforme especificado acima. Comprometo-me a cumprir com todos os termos estabelecidos, incluindo os prazos e formas de pagamentos acordados.<br/>Declaro ainda que recebi todas as informações necessárias sobre o imóvel, suas características, documentação e estado de conservação, e que estou plenamente consciente das responsabilidades da aquisição.</p>
																			<p style="margin:0px; padding:5px 0px 0px 0px; font-size:16px; color:#000; font-family:Arial; padding-top:30px;"><input type="text" value="<?php echo $_SESSION['cidadeDataIntencao'];?>" id="cidadeDataIntencao" style="width:300px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/>/<input type="text" value="<?php echo $_SESSION['estadoDataIntencao'];?>" id="estadoDataIntencao" style="width:50px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/>, <input type="text" value="<?php echo $_SESSION['diaDataIntencao'];?>" id="diaDataIntencao" style="width:50px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/> de <input type="text" value="<?php echo $_SESSION['mesDataIntencao'];?>" id="mesDataIntencao" style="width:100px; color:#000; font-size:16px; border:none; border-bottom:1px solid #000; outline:none;"/>de <?php echo date('Y');?></p>
																			<div style="display:table; margin:0 auto; padding-top:75px;">
																				<?php
																					$nomeCorretorExibicao = $dadosCorretor['nomeCorretor'];
																					$partesNome = preg_split('/\s+/', trim($nomeCorretorExibicao));
																					$nomeCorretorExibicao = implode(' ', array_slice($partesNome, 0, 3));
																				?>
																				<p style="margin:0px; padding:0px; font-size:16px; color:#000; font-family:Arial; text-align:justify; line-height:160%; padding-top:10px; text-align:center; float:left; margin-right:25px;">____________________________<br/><strong style="color:#000; font-family: Arial;">Corretor(a): <span style="font-weight:normal;"><?php echo $nomeCorretorExibicao; ?></span></strong></p>
																				<p style="margin:0px; padding:0px; font-size:16px; color:#000; font-family:Arial; text-align:justify; line-height:160%; padding-top:10px; text-align:center; float:left; margin-right:25px;">____________________________<br/><strong style="color:#000; font-family: Arial;">Comprador(a)</strong></p>
																				<p style="margin:0px; padding:0px; font-size:16px; color:#000; font-family:Arial; text-align:justify; line-height:160%; padding-top:10px; text-align:center; float:left; margin-right:25px;">____________________________<br/><strong style="color:#000; font-family: Arial;">Comprador(a)</strong></p>
																			</div>	
																		</div>
																		<p class="editando" style="color:#FFF; position:absolute; font-size:14px; left:50%; bottom:0; transform:translateX(-50%); margin-bottom:-28px;">Loteamento: <strong style="font-size:14px; color:#FFF;"><?php echo $dadosContratos['nomeLoteamento'];?></strong> - Quadra: <strong style="font-size:14px; font-weight:600; color:#FFF;"><?php echo $dadosContratos['nomeQuadra'];?></strong> - Lote(s): <strong style="font-size:14px; font-weight:600; color:#FFF;"><?php echo $lote;?></strong></p>																																			
																	</div>
																</div>
															</div>
														</div>	
													</div>
													<style>
														textarea {
															overflow: hidden;
															resize: none;
														}													
													</style>
													<script>
														function ajustarAltura() {
															const numeroDeCaracteres = document.getElementById('formaIntencao').value.length;

															// Definir o número de caracteres por linha (ajustar conforme necessário)
															const caracteresPorLinha = 70; 

															// Calcular o número de linhas necessárias
															let numeroDeLinhas = Math.ceil(numeroDeCaracteres / caracteresPorLinha);

															const alturaPorLinha = 21; // Altura para cada linha de texto (ajustar conforme necessário)
															if(numeroDeLinhas <= 0 || numeroDeLinhas == ""){
																numeroDeLinhas = 1;
															}

															document.getElementById('formaIntencao').style.height = `${numeroDeLinhas * alturaPorLinha}px`;
														}

														ajustarAltura();
														setTimeout("ajustarAltura()", 5000);

														document.getElementById('formaIntencao').addEventListener('input', function() {
															this.style.height = 'auto';  // Redefine a altura para calcular corretamente
															if(this.scrollHeight == 0)
															this.style.height = (this.scrollHeight) + 'px';  // Ajusta a altura para o tamanho do conteúdo
														});
													</script>
