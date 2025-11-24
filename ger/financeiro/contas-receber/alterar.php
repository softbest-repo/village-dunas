<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "contas-receber";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlConta = "SELECT * FROM contas WHERE codConta = '".$url[6]."' LIMIT 0,1";
				$resultConta = $conn->query($sqlConta);
				$dadosContas = $resultConta->fetch_assoc();

				$sqlCliente = "SELECT * FROM clientes WHERE codCliente = '".$dadosContas['codCliente']."' LIMIT 0,1";
				$resultCliente = $conn->query($sqlCliente);
				$dadosCliente = $resultCliente->fetch_assoc();			
?>
			<div id="localizacao-topo">
				<div id="conteudo-localizacao-topo">
					<p class="nome-lista">Financeiro</p>
					<p class="flexa"></p>
					<p class="nome-lista">Contas a Receber</p>
					<p class="flexa"></p>
					<p class="nome-lista">Alterar</p>
					<p class="flexa"></p>
					<p class="nome-lista"><?php echo $dadosCliente['nomeCliente'] ;?> - <?php echo data($dadosContas['dataCConta']);?></p>
					<br class="clear" />
				</div>

<?php
				if($dadosContas['statusConta'] == 'T' && $dadosContas['baixaConta'] == 'F' || $dadosContas['statusConta'] == 'F' && $dadosContas['baixaConta'] == 'T'){
?>
				<table class="tabela-interno" >
					<tr class="tr-interno">
					<td class="botoes-interno"><a href='<?php echo $configUrl; ?>financeiro/contas-receber/baixa/<?php echo $dadosContas['codConta'];?>/' title='Deseja estornar <?php echo $dadosContas['nomeConta'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/dinheiro-estorno.gif' alt="icone"></a></td>
					</tr>
				</table>
<?php
				}
?>
				<div class="botao-consultar" style="float:left;"><a title="Consultar Contas a Receber" href="<?php echo $configUrl;?>financeiro/contas-receber/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				<br class="clear"/>
			</div>
			<div id="dados-conteudo">
				<div id="cadastrar">
<?php
				if($dadosContas['baixaConta'] == 'T'){
?>
 					<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
<?php
				}
			
				if(isset($_POST['vencimento'])){						
					$sqlPegaTipoPagamento = "SELECT * FROM tipoPagamento WHERE nomeTipoPagamento = '".$_POST['tipoPagamentoR']."' and tipoPagamento = 'R' ORDER BY codTipoPagamento DESC LIMIT 0,1";
					$resultPegaTipoPagamento = $conn->query($sqlPegaTipoPagamento);
					$dadosPegaTipoPagamento = $resultPegaTipoPagamento->fetch_assoc();

					$sqlAltera = "UPDATE contas SET codContrato = '".$_POST['cod-contrato']."', nomeConta = '".$_POST['nome']."', codTipoPagamento = '".$dadosPegaTipoPagamento['codTipoPagamento']."', financiamentoConta = '".$_POST['financiamento']."' WHERE codAgrupadorConta = ".$dadosContas ['codAgrupadorConta']."";
					$resultAltera = $conn->query($sqlAltera);					

					$sqlAltera = "UPDATE contas SET vencimentoConta = '".data($_POST['vencimento'])."', tipoPagamentoConta = '".$_POST['tipo-pagamento']."' WHERE codConta = ".$url[6]."";
					$resultAltera = $conn->query($sqlAltera);					
					
					if($resultAltera == 1){
						$_SESSION['alterar'] = "ok";
						$_SESSION['nome'] = $_POST['vencimento'];
						$erroData = "<p class='erro'>Conta a Receber alterada com sucesso!</p>";

						$sqlConta = "SELECT * FROM contas WHERE codConta = ".$url[6]." LIMIT 0,1";
						$resultConta = $conn->query($sqlConta);
						while($dadosConta = $resultConta->fetch_assoc()){

							$sqlCliente = "SELECT nomeCliente FROM clientes WHERE codCliente = ".$dadosConta['codCliente']." LIMIT 0,1";
							$resultCliente = $conn->query($sqlCliente);
							$dadosCliente = $resultCliente->fetch_assoc();

							$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosConta['codTipoPagamento']." LIMIT 0,1";
							$resultTipoPagamento = $conn->query($sqlTipoPagamento);
							$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();
														
							$_SESSION['clientes'] = $dadosCliente['nomeCliente'];
							$_SESSION['nome'] = $dadosConta['nomeConta'];
							$_SESSION['tipoPagamentoR'] = $dadosTipoPagamento['nomeTipoPagamento'];
							$_SESSION['total'] = number_format($dadosConta['totalConta'], 2, ",", ".");

							if($dadosConta['acrescimoConta'] == "0.00"){
								$_SESSION['acrescimo'] = "";
								$_SESSION['valorReceber'] = number_format($dadosConta['totalConta'], 2, ",", ".");
							}else{
								$valorReceber = $dadosConta['totalConta'] + $dadosConta['acrescimoConta'];
								$_SESSION['valorReceber'] = number_format($valorReceber, 2, ",", ".");
								$_SESSION['acrescimo'] = number_format($dadosConta['acrescimoConta'], 2, ",", ".");
							}

							if($dadosConta['descontoConta'] == "0.00"){
								$_SESSION['desconto2'] = "";
								$_SESSION['valorReceber'] = number_format($dadosConta['totalConta'], 2, ",", ".");
							}else{
								$valorReceber = $valorReceber - $dadosConta['descontoConta'];
								$_SESSION['valorReceber'] = number_format($valorReceber, 2, ",", ".");
								$_SESSION['desconto2'] = number_format($dadosConta['descontoConta'], 2, ",", ".");
							}
							
							$_SESSION['financiamento'] = $dadosConta['financiamentoConta'];
							$_SESSION['formaPagamento'] = $dadosConta['formaPagamentoConta'];
							$_SESSION['parcela'] = $dadosConta['parcelaConta'];
							$_SESSION['Vparcela'] = number_format($dadosConta['vParcela'], 2, ",", ".");
							$_SESSION['vencimento'] = data($dadosConta['vencimentoConta']);
							$_SESSION['tipo-pagamento'] = $dadosConta['tipoPagamentoConta'];
							
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar Conta a Receber!</p>";							
					}
				}else{
					$sqlConta = "SELECT * FROM contas WHERE codConta = ".$url[6]." LIMIT 0,1";
					$resultConta = $conn->query($sqlConta);
					while($dadosConta = $resultConta->fetch_assoc()){

						$sqlCliente = "SELECT nomeCliente FROM clientes WHERE codCliente = ".$dadosConta['codCliente']." LIMIT 0,1";
						$resultCliente = $conn->query($sqlCliente);
						$dadosCliente = $resultCliente->fetch_assoc();

						$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosConta['codTipoPagamento']." LIMIT 0,1";
						$resultTipoPagamento = $conn->query($sqlTipoPagamento);
						$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();
													
						$_SESSION['cod-contrato'] = $dadosConta['codContrato'];
						$_SESSION['clientes'] = $dadosCliente['nomeCliente'];
						$_SESSION['nome'] = $dadosConta['nomeConta'];
						$_SESSION['tipoPagamentoR'] = $dadosTipoPagamento['nomeTipoPagamento'];
						$_SESSION['total'] = number_format($dadosConta['totalConta'], 2, ",", ".");

						if($dadosConta['acrescimoConta'] == "0.00"){
							$_SESSION['acrescimo'] = "";
							$_SESSION['valorReceber'] = number_format($dadosConta['totalConta'], 2, ",", ".");
						}else{
							$valorReceber = $dadosConta['totalConta'] + $dadosConta['acrescimoConta'];
							$_SESSION['valorReceber'] = number_format($valorReceber, 2, ",", ".");
							$_SESSION['acrescimo'] = number_format($dadosConta['acrescimoConta'], 2, ",", ".");
						}

						if($dadosConta['descontoConta'] == "0.00"){
							$_SESSION['desconto2'] = "";
							$_SESSION['valorReceber'] = number_format($dadosConta['totalConta'], 2, ",", ".");
						}else{
							$valorReceber = $valorReceber - $dadosConta['descontoConta'];
							$_SESSION['valorReceber'] = number_format($valorReceber, 2, ",", ".");
							$_SESSION['desconto2'] = number_format($dadosConta['descontoConta'], 2, ",", ".");
						}
						
						$_SESSION['financiamento'] = $dadosConta['financiamentoConta'];
						$_SESSION['juros'] = $dadosConta['jurosConta'];
						$_SESSION['formaPagamento'] = $dadosConta['formaPagamentoConta'];
						$_SESSION['parcela'] = $dadosConta['parcelaConta'];
						$_SESSION['Vparcela'] = number_format($dadosConta['vParcela'], 2, ",", ".");
						$_SESSION['vencimento'] = data($dadosConta['vencimentoConta']);
						$_SESSION['tipo-pagamento'] = $dadosConta['tipoPagamentoConta'];
						
					}
				}

				$sqlContas = "SELECT * FROM contas WHERE codConta = ".$url[6]." LIMIT 0,1";
				$resultContas = $conn->query($sqlContas);
				$dadosContas = $resultContas->fetch_assoc();
				
				$sqlConfere = "SELECT count(codConta) total, SUM(vParcela) totalConta FROM contas WHERE codAgrupadorConta = ".$dadosContas['codAgrupadorConta']."";
				$resultConfere = $conn->query($sqlConfere);
				$dadosConfere = $resultConfere->fetch_assoc(); 

				if($erroData != "" || $erro == "sim" || $erro == "ok"){
?>
					<div class="area-erro">
<?php
					echo $erroData;
?>
					</div>
<?php
				}	
	
				if($_SESSION['extornar'] == "ok"){
					$_SESSION['extornar'] = "";
?>
					<div class="area-erro" style="width:auto; display:table; padding-left:30px; padding-right:30px; text-align:center;">
						<p class="erro">Conta a Receber <strong>extornada</strong> com sucesso!</p>
					</div>
<?php
				}
?>
					<script type="text/javascript">
						function habilitaCampo(){
							document.getElementById("nome").disabled = false;
							document.getElementById("vencimento").disabled = false;
							document.getElementById("idSelectContrato").disabled = false;
							document.getElementById("busca_autocomplete_softbest_tipoPagamentoR_c").disabled = false;
							document.getElementById("tipo-pagamento").disabled = false;
							document.getElementById("financiamento").disabled = false;
							document.getElementById("alterar").disabled = false;
						}						
					 </script>			
					<p class="obrigatorio">Campos obrigatórios *</p>
					<p class="obrigatorio" style="font-weight:normal;">Obs: os campos <strong>Contrato, Cliente, Tipo Pagamento, Tipo Financiamento e Descrição</strong> será alterados em todas as contas vinculadas;</p>
					<p class="data-cad" style="color:#718B8F; margin-top:20px; font-size:16px;"><strong style="font-size:16px;">Data de Cadastro:</strong> <?php echo data($dadosContas['dataCConta']);?></p>
					<br/>
					<form name="contas" action="<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $url[6];?>/" method="post">
											
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
						</script>										

						<p class="bloco-campo-float">
							<label>Contrato:</label>
							<select class="selectContrato form-control campo" id="idSelectContrato" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="cod-contrato" style="width:350px; display: none;">
								<option value="">Selecione</option>	
<?php
				$sqlContratos = "SELECT * FROM contratos C inner join clientes CL on C.codCliente = CL.codCliente ORDER BY C.dataContrato DESC";
				$resultContratos = $conn->query($sqlContratos);
				while($dadosContratos = $resultContratos->fetch_assoc()){
?>
								<optgroup label="Contrato #<?php echo $dadosContratos['codContrato'];?> - <?php echo $dadosContratos['nomeCliente'];?>">
<?php
					$lotes = "Código(s): ";
					
					$cont = 0;
				
					$sqlImoveis = "SELECT * FROM contratosImoveis CI inner join imoveis I on CI.codImovel = I.codImovel WHERE CI.codContrato = ".$dadosContratos['codContrato']." ORDER BY CI.codContrato ASC";
					$resultImoveis = $conn->query($sqlImoveis);
					while($dadosImoveis = $resultImoveis->fetch_assoc()){	
						$cont++;
						if($cont == 1){
							$lotes .= $dadosImoveis['codigoImovel'];
						}else{
							$lotes .= ", ".$dadosImoveis['codigoImovel'];
						}
					}
?>	
										<option value="<?php echo trim($dadosContratos['codContrato']);?>" <?php echo $dadosContratos['codContrato'] == $_SESSION['cod-contrato'] ? 'selected' : ''; ?>><?php echo $lotes;?> - <?php echo data($dadosContratos['dataContrato']);?> - R$ <?php echo number_format($dadosContratos['valorContrato'], 2, ",", ".");?></option>										
								</optgroup>
<?php
				}
?>
							</select>										
						</p>

						<script>
							var $rfg = jQuery.noConflict();

							$rfg(".selectContrato").select2({
								placeholder: "Selecione",
								multiple: false,
								templateResult: function (data) {
									if (!data.id) {
										return data.text;
									}
									var $result = $rfg('<span>' + data.text + '</span>');
									return $result;
								},
								escapeMarkup: function (markup) {
									return markup;
								}
							});
						</script>

						<div id="auto_complete_softbest" style="width:236px; float:left; margin-bottom:15px;">
							<p class="bloco-campo" style="margin-bottom:0px;"><label>Cliente: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="clientes" required style="width:220px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['clientes']; ?>" onKeyUp="auto_complete(this.value, 'clientes', event);" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest" /></p>
							
							<div id="exibe_busca_autocomplete_softbest" class="auto_complete_softbest" style="width:234px; display:none;">

							</div>
						</div>	
						
						<div id="auto_complete_softbest" style="width:176px; float:left; margin-bottom:15px;">
							<p class="bloco-campo" style="margin-bottom:0px;"><label>Tipo Pagamento: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="tipoPagamentoR" required style="width:160px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['tipoPagamentoR']; ?>" onClick="auto_complete(this.value, 'tipoPagamentoR_c', event);" onKeyUp="auto_complete(this.value, 'tipoPagamentoR_c', event);" onBlur="fechaAutoComplete('tipoPagamentoR_c');" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest_tipoPagamentoR_c" /></p>
							
							<div id="exibe_busca_autocomplete_softbest_tipoPagamentoR_c" class="auto_complete_softbest" style="display:none;">

							</div>
						</div>

						<p class="bloco-campo-float"><label>Tipo Financiamento: <span class="obrigatorio"> * </span></label>
							<select class="campo" id="financiamento" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required name="financiamento" style="width:170px;" onChange="tipoFinanciamento(this.value);">
								<option value="">Selecione</option>
								<option value="N" <?php echo $_SESSION['financiamento'] == 'N' ? '/SELECTED/' : '';?> >Nenhum</option>
								<option value="P" <?php echo $_SESSION['financiamento'] == 'P' ? '/SELECTED/' : '';?> >Próprio</option>
								<option value="B" <?php echo $_SESSION['financiamento'] == 'B' ? '/SELECTED/' : '';?> >Banco</option>
							</select>
							<br class="clear"/>
						</p>
						
						<br class="clear"/>
													
						<p class="bloco-campo-float"><label>Descrição: <span class="obrigatorio"> * </span></label>
						<input style="width:190px;" class="campo" type="text" name="nome" id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['nome'];?>" /></p>
						
						<p class="bloco-campo-float"><label>Valor da Conta: <span class="obrigatorio"> * </span></label>
						<input style="width:140px;" class="campo" type="text" id="valor" name="valor" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required value="<?php echo $_SESSION['total']; ?>" onKeyUp="moeda(this); calculosConta();"/></p>
													
						<p class="bloco-campo-float"><label>Acrescimo:</label>
						<input style="width:140px;" class="campo" type="text" disabled="disabled" id="acrescimo" name="acrescimo" value="<?php echo $_SESSION['acrescimo']; ?>" onKeyUp="moeda(this);"/></p>
													
						<p class="bloco-campo-float"><label>Desconto:</label>
						<input style="width:147px;" class="campo" type="text" disabled="disabled" id="desconto2" name="desconto2" value="<?php echo $_SESSION['desconto2']; ?>" onKeyUp="moeda(this);"/></p>

						<p class="bloco-campo-float"><label>Valor a Receber: <span class="obrigatorio"> * </span></label>
						<input style="width:147px;" class="campo" type="text" required readonly <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="valorReceber" name="valorReceber" value="<?php echo number_format($dadosConfere['totalConta'], 2, ",", "."); ?>"/></p>

						<br class="clear"/>
						
						<p class="bloco-campo-float"><label>N°. Parcelas: <span class="obrigatorio"> * </span></label>
						<input style="width:92px;" class="campo" type="text" name="parcela" disabled="disabled" required id="parcela" value="<?php echo $_SESSION['parcela'];?>" onKeyUp="divideParcelas();" /></p>

						<p class="bloco-campo-float"><label>Valor Parcela: <span class="obrigatorio"> * </span></label>
						<input style="width:119px;" class="campo" type="text" name="Vparcela" required readonly <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="Vparcela" value="<?php echo $_SESSION['Vparcela'];?>" /></p>
						

						<p class="bloco-campo-float"><label>Vencimento: <span class="obrigatorio"> * </span></label>
						<input class="campo" type="text" id="vencimento" name="vencimento" disabled="disabled" required style="width:119px;" value="<?php echo $_SESSION['vencimento']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data)"/></p>
											
						<p class="bloco-campo-float"><label>Meio de Pagamento: <span class="obrigatorio"> * </span></label>
							<select class="campo" id="tipo-pagamento" name="tipo-pagamento" disabled="disabled" required style="width:260px;">
								<option value="">Selecione</option>
								<option value="PI" <?php echo $_SESSION['tipo-pagamento'] == 'PI' ? '/SELECTED/' : '';?>>Pix</option>
								<option value="D" <?php echo $_SESSION['tipo-pagamento'] == 'D' ? '/SELECTED/' : '';?>>Dinheiro</option>
								<option value="C" <?php echo $_SESSION['tipo-pagamento'] == 'C' ? '/SELECTED/' : '';?>>Cartão</option>
								<option value="CH" <?php echo $_SESSION['tipo-pagamento'] == 'CH' ? '/SELECTED/' : '';?>>Cheque</option>
								<option value="B" <?php echo $_SESSION['tipo-pagamento'] == 'B' ? '/SELECTED/' : '';?>>Boleto</option>
								<option value="TD" <?php echo $_SESSION['tipo-pagamento'] == 'TD' ? '/SELECTED/' : '';?>>Transf/Depósito</option>
								<option value="P" <?php echo $_SESSION['tipo-pagamento'] == 'P' ? '/SELECTED/' : '';?>>Permuta</option>
							</select>
							<br class="clear"/>
						</p>

						<br class="clear"/>
						
						<div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" id="alterar" title="Alterar Conta a Receber" value="Alterar" onClick="validaForm();"/><p class="direita-botao"></p></div>						
						<br class="clear"/>
					</form>
<?php
				if($dadosConfere['total'] >= 2){
?>
					<div id="lista-parcelas" style="width:875px; display:none; margin-top:30px;">
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Parcela</th>
								<th>Vencimento</th>
								<th>Situação</th>
								<th>A Receber</th>
								<th>Valor da Parcela</th>
								<th>Receber</th>
								<th class="canto-dir">Baixa</th>
							</tr>					
<?php
					$sqlConta = "SELECT * FROM contas WHERE areaPagamentoConta = 'R' and codAgrupadorConta = ".$dadosContas['codAgrupadorConta']." ORDER BY statusConta ASC, baixaConta ASC, vencimentoConta ASC, codConta DESC";
					$resultConta = $conn->query($sqlConta);
					while($dadosConta = $resultConta->fetch_assoc()){

						if($dadosConta['statusConta'] == "T" && $dadosConta['baixaConta'] == "T"){
							$status = "";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "-inativo";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}
						
						if($dadosConta['baixaConta'] == "T" && $dadosConta['statusConta'] == "T"){
							$baixa = "-ativo.gif";
							$baixaIcone = "n-baixa";
							$baixaPergunta = "dar baixa";
						}else{
							$baixa = "-inativo.gif";
							$baixaIcone = "baixa";
							$baixaPergunta = "estornar";
						}

						$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosConta['codTipoPagamento']." LIMIT 0,1";
						$resultTipoPagamento = $conn->query($sqlTipoPagamento);
						$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();	

						$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$dadosConta['codConta']."";
						$resultContaParcial = $conn->query($sqlContaParcial);
						$dadosContaParcial = $resultContaParcial->fetch_assoc();

						$sqlContaParcialDesc = "SELECT SUM(descontoContaParcial) registros FROM contasParcial WHERE codConta = ".$dadosConta['codConta']."";
						$resultContaParcialDesc = $conn->query($sqlContaParcialDesc);
						$dadosContaParcialDesc = $resultContaParcialDesc->fetch_assoc();
						
						if($dadosConta['statusConta'] == 'T' && $dadosConta['baixaConta'] == 'T'){	
							$valorTotalParcial = $valorTotalParcial + $dadosContaParcial['registros'];	
						}
						
						if($dadosConta['statusConta'] == 'T' && $dadosConta['baixaConta'] == 'T'){
							$valorAPagar = $valorAPagar + $dadosConta['vParcela'];
						}
						
						if($dadosConta['statusConta'] == 'F' && $dadosConta['baixaConta'] == 'T'){
							$valorPago = $valorPago + $dadosConta['vParcela'] - $dadosContaParcialDesc['registros'];
						}

						if($dadosConta['statusConta'] == 'T' && $dadosConta['baixaConta'] == 'F'){
							$valorBaixa = $valorBaixa + $dadosConta['vParcela'];
						}
						
						$valorReceber = $dadosConta['vParcela'] - $dadosContaParcialDesc['registros'] - $dadosContaParcial['registros'];


						$valorDesconto = $valorDesconto + $dadosContaParcialDesc['registros'];

						$totalPago = $valorPago + $valorTotalParcial;
						
						$valorTotal = $valorTotal + $dadosConta['vParcela'];

						$totalAPagar = $valorAPagar - $valorTotalParcial; 
?>

							<tr class="tr">
								<td class="cinco" style="text-align:center;"><a style="<?php echo $dadosConta['vencimentoConta'] <= date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F' ? 'color:#FF0000;' : '';?>" href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'><?php echo $dadosConta['parcelaConta'] == "E" ? 'Entrada' : $dadosConta['parcelaConta'];?></a></td>
								<td class="vinte" style="text-align:center;"><a style="<?php echo $dadosConta['vencimentoConta'] <= date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F' ? 'color:#FF0000;' : '';?>" href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'><?php echo data($dadosConta['vencimentoConta']);?></a></td>
								<td class="vinte" style="text-align:center;"><a style="<?php echo $dadosConta['vencimentoConta'] <= date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F' ? 'color:#FF0000;' : '';?>" href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'><?php echo $dadosConta['statusConta'] == 'F' && $dadosConta['baixaConta'] == 'T' ? 'Paga' : '';?> <?php echo $dadosConta['statusConta'] == 'T' && $dadosConta['baixaConta'] == 'F' ? 'Baixa' : '';?> <?php echo $dadosConta['statusConta'] == 'T' && $dadosConta['baixaConta'] == 'T' ? 'Em Aberto' : '';?></a></td>
								<td class="vinte" style="text-align:center;"><a style="<?php echo $dadosConta['vencimentoConta'] <= date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F' ? 'color:#FF0000;' : '';?>" href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'>R$ <?php echo number_format($valorReceber, 2, ",", ".");?></a></td>
								<td class="vinte" style="text-align:center;"><a style="<?php echo $dadosConta['vencimentoConta'] <= date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F' ? 'color:#FF0000;' : '';?>" href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'>R$ <?php echo number_format($dadosConta['vParcela'], 2, ",", ".");?></a></td>
<?php	
						if($dadosConta['statusConta'] == "T" && $dadosConta['baixaConta'] == "T"){
?>
								<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'];?>/#pagamento' title='Deseja <?php echo $statusPergunta;?> a mensalidade do cliente <?php echo $dadosConta['nomeConta'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icone-pagamento<?php echo $status;?>.gif" alt="icone" /></a></td>
<?php
						}else{
?>
								<td class="botoes" style="padding:0px;"><img style="margin-left:5px;" src="<?php echo $configUrl;?>f/i/default/corpo-default/icone-pagamento<?php echo $status;?>.gif" alt="icone" /></td>
<?php
						}
					
?>
								<td class="botoes"><img style="margin-left:5px;" src="<?php echo $configUrl;?>f/i/icone<?php echo $baixa;?>" alt="icone" /></td>
							</tr>
<?php	
					}
?>						 						 
						</table>
						<div id="total" style="background-color:#f5f5f5; margin-top:20px; width:100%;">
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total de contas a receber:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($totalAPagar, 2, ",", ".");?></p>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total de descontos:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($valorDesconto, 2, ",", ".");?></p>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total de contas recebidas:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($totalPago, 2, ",", ".");?></p>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total de contas:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; padding-bottom:15px; font-size:16px;">R$ <?php echo number_format($valorTotal, 2, ",", ".");?></p>
						</div>
					</div>
					<script type="text/javascript">
						function abreParcelas(){
							var $r = jQuery.noConflict();					
							if(document.getElementById("lista-parcelas").style.display=="none"){
								$r("#lista-parcelas").slideDown("100");
							}else{
								$r("#lista-parcelas").slideUp("100");
							}
						}
					</script>
					<p style="font-size:16px; color:#718B8F; text-decoration:underline; cursor:pointer; padding-top:30px;" onClick="abreParcelas();">Ver todas a parcelas desta conta</p>
<?php
				}
?>
					<p id="pagamento" style="width:1115px;"></p>
<?php
				if($_POST['exclui-parcial'] != ""){
					$sqlDeleta = "DELETE FROM cheques WHERE codContaParcial = '".$_POST['exclui-parcial']."'";
					$resultDeleta = $conn->query($sqlDeleta);
					
					$sqlDeleta = "DELETE FROM contasParcial WHERE codContaParcial = '".$_POST['exclui-parcial']."'";
					$resultDeleta = $conn->query($sqlDeleta);

					$erroConteudo = "<p class='erro' style='width:auto;'>Pagamento excluído com sucesso!</p>";
				}
				
				if($_POST['contaPgto'] != ""){
					$sqlUpdate = "UPDATE contasParcial SET contaPagamentoConta = '".$_POST['contaPgto']."' WHERE codContaParcial = ".$_POST['cod']."";
					$resultUpdate = $conn->query($sqlUpdate);
				}	
				
				if($_POST['tipo-pagamento2'] != "" && $_POST['valor'] != ""){
												
					$sqlContador = "SELECT * FROM contasParcial WHERE codConta = ".$url[6]." and codContadorContaParcial = ".$_POST['contador']." LIMIT 0,1";
					$resultContador = $conn->query($sqlContador);
					$dadosContador = $resultContador->fetch_assoc();
					
					if($dadosContador['codContaParcial'] == ""){
						
						$valor = str_replace(".", "", $_POST['valor']);
						$valor = str_replace(".", "", $valor);
						$valor = str_replace(",", ".", $valor);
						
						$acrescimo = str_replace(".", "", $_POST['acrescimo']);
						$acrescimo = str_replace(".", "", $acrescimo);
						$acrescimo = str_replace(",", ".", $acrescimo);
												
						if($desconto == ""){
							$desconto = 0;
						}
												
						if($acrescimo == ""){
							$acrescimo = 0;
						}

						$valorReceber = $_POST['valorReceber'];
						$valorNovo = $valor + $acrescimo;

						$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
						$resultContaParcial = $conn->query($sqlContaParcial);
						$dadosContaParcial = $resultContaParcial->fetch_assoc();
										
						if($valorReceber >= $valor){
												
							$somaDados = $valor + $desconto;
							
							if(floatval($somaDados) <= floatval($valorReceber)){
							
								$quebraData = explode( "T", $_POST['dataCadastroP']);

								$sqlInsere = "INSERT INTO contasParcial VALUES(0, ".$_POST['contador'].", ".$url[6].", '".$valorNovo."', '".$desconto."', '".$acrescimo."', '".$quebraData[0]."', '".$quebraData[1]."', '".$_POST['nome-receber']."', '".$_POST['tipo-pagamento2']."', '".$_POST['conta']."', 'T')";
								$resultInsere = $conn->query($sqlInsere);
								
								if($resultInsere == 1){
									
									$sqlContaParcial = "SELECT * FROM contasParcial ORDER BY codContaParcial DESC LIMIT 0,1";
									$resultContaParcial = $conn->query($sqlContaParcial);
									$dadosContaParcial = $resultContaParcial->fetch_assoc();

																					
									if($_POST['tipo-pagamento2'] == "CH" && $_POST['nomeCheque'] != "" && $_POST['paraCheque'] != ""){
										$sqlBancos = "SELECT codBancoConta FROM bancosConta WHERE codigoBancoConta = ".$_POST['numeroBancoCheque']." LIMIT 0,1";
										$resultBancos = $conn->query($sqlBancos);
										$dadosBancos = $resultBancos->fetch_assoc();
																				
										$sqlInsere = "INSERT INTO cheques VALUES(0, ".$dadosContaParcial['codContaParcial'].", ".$dadosBancos['codBancoConta'].", '".$_POST['numeroBancoCheque']."', '".$_POST['nomeCheque']."', '".$_POST['agenciaCheque']."', '".$_POST['contaCheque']."', '".$_POST['numeroCheque']."', '".data($_POST['paraCheque'])."', '', 'R', '', 'T')";
										$resultInsere = $conn->query($sqlInsere);
									}
									
									$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
									$resultContaParcial = $conn->query($sqlContaParcial);
									$dadosContaParcial = $resultContaParcial->fetch_assoc();
									
									$sqlContaParcialDesc = "SELECT SUM(descontoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
									$resultContaParcialDesc = $conn->query($sqlContaParcialDesc);
									$dadosContaParcialDesc = $resultContaParcialDesc->fetch_assoc();
										
									$vParcela = number_format($dadosContas['vParcela'], 2);
									$vParcela = str_replace(",", "", $vParcela);
									$vParcela = str_replace(",", "", $vParcela);

									$descontos = number_format($dadosContaParcialDesc['registros'], 2);
									$descontos = str_replace(",", "", $descontos);
									$descontos = str_replace(",", "", $descontos);

									$contasParcial = number_format($dadosContaParcial['registros'], 2);
									$contasParcial = str_replace(",", "", $contasParcial);
									$contasParcial = str_replace(",", "", $contasParcial);

									$valorReceber = $vParcela - $descontos;

									$valorReceber = number_format($valorReceber, 2);
									$valorReceber = str_replace(",", "", $valorReceber);
									$valorReceber = str_replace(",", "", $valorReceber);
									
									$valorReceber = $valorReceber - $contasParcial;
										
									$limpaValor = number_format($valorReceber, 2);
									$limpaValor = str_replace(",", "", $limpaValor);
									$limpaValor = str_replace(",", "", $limpaValor);

									
									$sqlContaParcialDesc = "SELECT SUM(descontoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
									$resultContaParcialDesc = $conn->query($sqlContaParcialDesc);
									$dadosContaParcialDesc = $resultContaParcialDesc->fetch_assoc();
				
									$sqlContaParcialReceberAcres = "SELECT SUM(acrescimoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
									$resultContaParcialReceberAcres = $conn->query($sqlContaParcialReceberAcres);
									$dadosContaParcialReceberAcres = $resultContaParcialReceberAcres->fetch_assoc();
																	
									$valorReceber = $dadosContaParcialDesc['registros'] + $dadosContaParcial['registros'] - $dadosContaParcialReceberAcres['registros'];
									$valorReceber = floatval($dadosContas['vParcela']) - floatval($valorReceber);
															
									$_SESSION['valor'] = $valorReceber;

									$erroConteudo = "<p class='erro' style='width:auto;'>Conta Parcial cadastrada com sucesso, valor restante para pagamento: ".number_format($valorReceber, 2, ",", ".")."</p>";

									if($valorReceber == 0){
										$sqlUpdate = "UPDATE contas SET statusConta = 'F', baixaConta = 'T' WHERE codConta = ".$url[6]."";
										$resultUpdate = $conn->query($sqlUpdate);

										if($dadosContas['codComissao'] != ""){
											$sqlUpdate = "UPDATE comissoes SET pagamentoComissao = 'T' WHERE codComissao = ".$dadosContas['codComissao']."";
											$resultUpdate = $conn->query($sqlUpdate);
										}

										$_SESSION['ativacaos'] = "ok";
										$_SESSION['acao'] = "paga";
										
										$erroConteudo = "<p class='erro' style='width:auto;'>Conta Parcial cadastrada com sucesso. Esta conta a receber foi finalizada!</p>";
									}

									$sqlContadorContaParcial = "SELECT * FROM contasParcial WHERE codConta = ".$url[6]." ORDER BY codContaParcial DESC LIMIT 0,1";
									$resultContadorContaParcial = $conn->query($sqlContadorContaParcial);
									$dadosContadorContaParcial = $resultContadorContaParcial->fetch_assoc();
									
									$contador = $dadosContadorContaParcial['codContadorContaParcial'] + 1;									

									$sqlContaParcialDesc = "SELECT SUM(descontoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
									$resultContaParcialDesc = $conn->query($sqlContaParcialDesc);
									$dadosContaParcialDesc = $resultContaParcialDesc->fetch_assoc();
				
									$sqlContaParcialReceberAcres = "SELECT SUM(acrescimoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
									$resultContaParcialReceberAcres = $conn->query($sqlContaParcialReceberAcres);
									$dadosContaParcialReceberAcres = $resultContaParcialReceberAcres->fetch_assoc();
																	
									$valorReceber = $dadosContaParcialDesc['registros'] + $dadosContaParcial['registros'] - $dadosContaParcialReceberAcres['registros'];
									$valorReceber = floatval($dadosContas['vParcela']) - floatval($valorReceber);
															
									$_SESSION['valor'] = $valorReceber;									
								}
							
							}else{
								$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
								$resultContaParcial = $conn->query($sqlContaParcial);
								$dadosContaParcial = $resultContaParcial->fetch_assoc();
								
								$sqlContaParcialDesc = "SELECT SUM(descontoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
								$resultContaParcialDesc = $conn->query($sqlContaParcialDesc);
								$dadosContaParcialDesc = $resultContaParcialDesc->fetch_assoc();
			
								$sqlContaParcialReceberAcres = "SELECT SUM(acrescimoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
								$resultContaParcialReceberAcres = $conn->query($sqlContaParcialReceberAcres);
								$dadosContaParcialReceberAcres = $resultContaParcialReceberAcres->fetch_assoc();
																
								$valorReceber = $dadosContaParcialDesc['registros'] + $dadosContaParcial['registros'] - $dadosContaParcialReceberAcres['registros'];
								$valorReceber = floatval($dadosContas['vParcela']) - floatval($valorReceber);
														
								$_SESSION['valor'] = $valorReceber;
								
								$erroConteudo = "<p class='erro' style='width:auto;'>O valor digitado <strong>".number_format($valor, 2, ",", ".")."</strong> somado com o desconto <strong>".number_format($desconto, 2, ",", ".")."</strong> é maior que o valor a receber. <strong>Valor a Receber: ".number_format($valorReceber, 2, ",", ".")."</strong></p>";				

								$_SESSION['tipo-pagamento2'] = $dadosContas['tipoPagamentoConta'];

							}
						
						}else{
							$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
							$resultContaParcial = $conn->query($sqlContaParcial);
							$dadosContaParcial = $resultContaParcial->fetch_assoc();
							
							$sqlContaParcialDesc = "SELECT SUM(descontoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
							$resultContaParcialDesc = $conn->query($sqlContaParcialDesc);
							$dadosContaParcialDesc = $resultContaParcialDesc->fetch_assoc();
		
							$sqlContaParcialReceberAcres = "SELECT SUM(acrescimoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
							$resultContaParcialReceberAcres = $conn->query($sqlContaParcialReceberAcres);
							$dadosContaParcialReceberAcres = $resultContaParcialReceberAcres->fetch_assoc();
															
							$valorReceber = $dadosContaParcialDesc['registros'] + $dadosContaParcial['registros'] - $dadosContaParcialReceberAcres['registros'];
							$valorReceber = floatval($dadosContas['vParcela']) - floatval($valorReceber);
													
							$_SESSION['valor'] = $valorReceber;
							
							$erroConteudo = "<p class='erro' style='width:auto;'>O valor digitado <strong>".$valor."</strong> é maior que o restante a pagar. <strong>Restante: ".number_format($valorReceber, 2, ",", ".")."</strong></p>";

							$_SESSION['tipo-pagamento2'] = $dadosContas['tipoPagamentoConta'];

						}
					}else{
						$sqlContadorContaParcial = "SELECT * FROM contasParcial WHERE codConta = ".$url[6]." ORDER BY codContaParcial DESC LIMIT 0,1";
						$resultContadorContaParcial = $conn->query($sqlContadorContaParcial);
						$dadosContadorContaParcial = $resultContadorContaParcial->fetch_assoc();
						
						$contador = $dadosContadorContaParcial['codContadorContaParcial'] + 1;
						
						$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
						$resultContaParcial = $conn->query($sqlContaParcial);
						$dadosContaParcial = $resultContaParcial->fetch_assoc();
						
						$sqlContaParcialDesc = "SELECT SUM(descontoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
						$resultContaParcialDesc = $conn->query($sqlContaParcialDesc);
						$dadosContaParcialDesc = $resultContaParcialDesc->fetch_assoc();
	
						$sqlContaParcialReceberAcres = "SELECT SUM(acrescimoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
						$resultContaParcialReceberAcres = $conn->query($sqlContaParcialReceberAcres);
						$dadosContaParcialReceberAcres = $resultContaParcialReceberAcres->fetch_assoc();
														
						$valorReceber = $dadosContaParcialDesc['registros'] + $dadosContaParcial['registros'] - $dadosContaParcialReceberAcres['registros'];
						$valorReceber = floatval($dadosContas['vParcela']) - floatval($valorReceber);
												
						$_SESSION['valor'] = $valorReceber;
						
						$_SESSION['data-parcial'] = data(date('Y-m-d'));						

						$_SESSION['tipo-pagamento2'] = $dadosContas['tipoPagamentoConta'];
					}
					
				}else{
					$sqlContadorContaParcial = "SELECT * FROM contasParcial WHERE codConta = ".$url[6]." ORDER BY codContaParcial DESC LIMIT 0,1";
					$resultContadorContaParcial = $conn->query($sqlContadorContaParcial);
					$dadosContadorContaParcial = $resultContadorContaParcial->fetch_assoc();
					
					$contador = $dadosContadorContaParcial['codContadorContaParcial'] + 1;
					
					$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
					$resultContaParcial = $conn->query($sqlContaParcial);
					$dadosContaParcial = $resultContaParcial->fetch_assoc();
					
					$sqlContaParcialDesc = "SELECT SUM(descontoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
					$resultContaParcialDesc = $conn->query($sqlContaParcialDesc);
					$dadosContaParcialDesc = $resultContaParcialDesc->fetch_assoc();

					$sqlContaParcialReceberAcres = "SELECT SUM(acrescimoContaParcial) registros FROM contasParcial WHERE codConta = ".$url[6]."";
					$resultContaParcialReceberAcres = $conn->query($sqlContaParcialReceberAcres);
					$dadosContaParcialReceberAcres = $resultContaParcialReceberAcres->fetch_assoc();
													
					$valorReceber = $dadosContaParcialDesc['registros'] + $dadosContaParcial['registros'] - $dadosContaParcialReceberAcres['registros'];
					$valorReceber = floatval($dadosContas['vParcela']) - floatval($valorReceber);
											
					$_SESSION['valor'] = $valorReceber;
					
					$_SESSION['data-parcial'] = data(date('Y-m-d'));
					
					$_SESSION['tipo-pagamento2'] = $dadosContas['tipoPagamentoConta'];
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
					</script>
					<script type="text/javascript">
						function descontoss(valor){
							if(valor != ""){
								var valor = valor.replace(".", "");
								var valor = valor.replace(".", "");
								var valor = valor.replace(",", ".");
								var pegaValorPagar = document.getElementById("total-receber").value;
								var novoValor = pegaValorPagar - valor;
								document.getElementById("valor2").value=number_format(novoValor, 2, ",", ".");
							}
						}					
					</script>
<?php	
				if($erroConteudo != ""){
?>
					<div class="area-erro" style="width:auto; display:table; padding-left:30px; padding-right:30px; text-align:center;">
<?php
					echo $erroConteudo;	
?>
					</div>
<?php
				}
?>
					<form name="contasParcial" style="margin-top:40px;" action="<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $url[6];?>/#pagamento" method="post">
						<p class="titulo" style="font-size:18px; color:#718B8F; font-weight:bold;">Cadastrar Pagamento</p>
						<br/>
						<p class="total-receber" style="color:#718B8F; margin-bottom:10px;"><strong>Total a Receber:</strong> R$ <?php echo number_format($valorReceber, 2, ",", ".");?></p>

						<input type="hidden" value="<?php echo $contador;?>" name="contador"/>

						<p class="bloco-campo-float"><label>Valor: <span class="obrigatorio"> </span></label>
						<input style="width:75px;" class="campo" required type="text" <?php echo $dadosContas['baixaConta'] == "T" ? "" : "disabled='disabled'";?> name="valor" id="valor2" value="<?php echo number_format($valorReceber, 2, ",", ".");?>" onKeyUp="moeda(this);"/></p>
						<input type="hidden" id="total-receber" value="<?php echo $_SESSION['valor'];?>" name="valorReceber"/>

						<p class="bloco-campo-float"><label>Data Pagamento: <span class="obrigatorio">*</span></label>
						<input class="campo" type="datetime-local" id="dataCadastroP" name="dataCadastroP" <?php echo $dadosContas['baixaConta'] == "T" ? "" : "disabled='disabled'";?> required style="width:125px; height:17px;" value="<?php echo $_SESSION['dataCadastroP']; ?>"/></p>

						<p class="bloco-campo-float"><label>Desconto: <span class="obrigatorio"> </span></label>
						<input style="width:75px;" class="campo" type="text" <?php echo $dadosContas['baixaConta'] == "T" ? "" : "disabled='disabled'";?> name="desconto" id="desconto" onKeyUp="moeda(this); descontoss(this.value);"/></p>

						<p class="bloco-campo-float"><label>Acréscimo: <span class="obrigatorio"> </span></label>
						<input style="width:75px;" class="campo" type="text" <?php echo $dadosContas['baixaConta'] == "T" ? "" : "disabled='disabled'";?> name="acrescimo" id="acrescimo" onKeyUp="moeda(this);"/></p>

						<p class="bloco-campo-float"><label>Observação:</label><span class="obrigatorio"></span>
						<input type="text" style="width:170px;" class="campo" value="<?php echo $_SESSION['nomePagar'];?>" name="nome-receber"/></p>

						<p class="bloco-campo-float"><label>Meio de Pagamento: <span class="obrigatorio"> </span></label>
							<select class="campo" id="tipo-pagamento2" required onChange="mostraCheque(this.value);" <?php echo $dadosContas['baixaConta'] == "T" ? "" : "disabled='disabled'";?> name="tipo-pagamento2" style="width:152px;">
								<option value="">Selecione</option>
								<option value="PI" <?php echo $_SESSION['tipo-pagamento2'] == 'PI' ? '/SELECTED/' : '';?>>Pix</option>
								<option value="D" <?php echo $_SESSION['tipo-pagamento2'] == 'D' ? '/SELECTED/' : '';?>>Dinheiro</option>
								<option value="C" <?php echo $_SESSION['tipo-pagamento2'] == 'C' ? '/SELECTED/' : '';?>>Cartão</option>
								<option value="CH" <?php echo $_SESSION['tipo-pagamento2'] == 'CH' ? '/SELECTED/' : '';?>>Cheque</option>
								<option value="B" <?php echo $_SESSION['tipo-pagamento2'] == 'B' ? '/SELECTED/' : '';?>>Boleto</option>
								<option value="TD" <?php echo $_SESSION['tipo-pagamento2'] == 'TD' ? '/SELECTED/' : '';?>>Transf/Depósito</option>
								<option value="P" <?php echo $_SESSION['tipo-pagamento2'] == 'P' ? '/SELECTED/' : '';?>>Permuta</option>
							</select>
							<br class="clear"/>
						</p>

						<p class="bloco-campo-float"><label>Conta Pagamento: <span class="obrigatorio"> </span></label>
							<select class="campo" id="conta" required <?php echo $dadosContas['baixaConta'] == "T" ? "" : "disabled='disabled'";?> name="conta" style="width:138px; ">
								<option value="">Selecione</option>
<?php
				$sqlBanco = "SELECT * FROM bancos WHERE statusBanco = 'T' ORDER BY nomeBanco ASC";
				$resultBanco = $conn->query($sqlBanco);
				while($dadosBanco = $resultBanco->fetch_assoc()){
?>
								<option value="<?php echo $dadosBanco['codBanco'] ;?>"><?php echo $dadosBanco['nomeBanco'];?></option>
<?php
				}
?>					
							</select>
							<br class="clear"/>
						</p>
						<script>
							function mostraCheque(value){
								if(value == "CH"){
									document.getElementById("form-cheque").style.display="block";
								}else{
									document.getElementById("form-cheque").style.display="none";
								}
							}
						 </script>
						<div id="form-cheque" style="display:<?php echo $_SESSION['tipo-pagamento2'] == "CH" && $dadosContas['statusConta'] == 'T' ? 'block' : 'none';?>;">
							<br class="clear"/>
							<br/>
							<p class="titulo-cheques" style="font-size:20px; color:#718B8F; font-weight:bold; padding-bottom:10px;">Cheque</p>
							<p class="bloco-campo-float"><label>Banco:</label>
								<select class="campo" id="bancoChequeAvista" name="banco" onChange="insereBanco(this.value);" style="width:222px;">
									<option value="">Selecione</option>
<?php
				$sqlBancoConta = "SELECT * FROM bancosConta WHERE statusBancoConta = 'T' ORDER BY nomeBancoConta ASC";
				$resultBancoConta = $conn->query($sqlBancoConta);
				while($dadosBancoConta = $resultBancoConta->fetch_assoc()){
?>
									<option value="<?php echo $dadosBancoConta['codigoBancoConta'];?>" <?php echo $dadosBancoConta['codBancoConta'] == $_SESSION['bancoCheque2'] ? '/SELECTED/' : '';?> ><?php echo $dadosBancoConta['nomeBancoConta'];?></option>
<?php
				}
?>
								</select>
							</p>
							
							<script type="text/javascript">
								function insereBanco(value){
									document.getElementById("numeroBancoCheque").value=value;
								}
							</script>						
							
							<p class="bloco-campo-float"><label>Nº Banco:</label>
							<input class="campo" size="10" id="numeroBancoCheque" readonly type="text" name="numeroBancoCheque" value="" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer)"/></p>

							<p class="bloco-campo-float"><label>Nome:</label>
							<input class="campo" size="37" id="nomeCheque" type="text" name="nomeCheque" value="" /></p>
							
							<br class="clear" />

							<p class="bloco-campo-float"><label>Agência:</label>
							<input class="campo" type="text" id="agenciaCheque" size="14" name="agenciaCheque" value="" /></p>

							<p class="bloco-campo-float"><label>Conta:</label>
							<input class="campo" type="text" id="contaCheque" size="22" name="contaCheque" value="" /></p>

							<p class="bloco-campo-float"><label>Número:</label>
							<input class="campo" type="text" id="numeroCheque" size="17" name="numeroCheque" value="" /></p>

							<p class="bloco-campo-float"><label>Bom para:</label>
							<input class="campo" type="text" id="paraCheque" size="11" name="paraCheque" value="" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data)"/></p>

							<br class="clear" />
						 </div>					 
						<div class="botao-expansivel" style="margin-top:27px;"><p class="esquerda-botao"></p><input class="botao" type="submit" <?php echo $dadosContas['baixaConta'] == "T" ? "" : "disabled='disabled'";?> name="enviar" title="Alterar Conta a Receber" value="Realizar Pagamento"/><p class="direita-botao"></p></div>						
					</form>	
					<br class="clear"/>
					<script type="text/javascript">
						function number_format( numero, decimal, decimal_separador, milhar_separador ){	
							numero = (numero + '').replace(/[^0-9+\-Ee.]/g, '');
							var n = !isFinite(+numero) ? 0 : +numero,
								prec = !isFinite(+decimal) ? 0 : Math.abs(decimal),
								sep = (typeof milhar_separador === 'undefined') ? ',' : milhar_separador,
								dec = (typeof decimal_separador === 'undefined') ? '.' : decimal_separador,
								s = '',
								toFixedFix = function (n, prec) {
									var k = Math.pow(10, prec);
									return '' + Math.round(n * k) / k;
								};
							// Fix para IE: parseFloat(0.55).toFixed(0) = 0;
							s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
							if (s[0].length > 3) {
								s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
							}
							if ((s[1] || '').length < prec) {
								s[1] = s[1] || '';
								s[1] += new Array(prec - s[1].length + 1).join('0');
							}

							return s.join(dec);
						}
						
						function imprimeRequisicao(id, pg, valor, data) {
							document.getElementById("valor-imprime").innerHTML="R$ "+number_format(valor, 2, ",", ".");
							document.getElementById("data-imprime").innerHTML=data;
							document.getElementById("valor-imprime2").innerHTML="R$ "+number_format(valor, 2, ",", ".");
							document.getElementById("data-imprime2").innerHTML=data;
							var printContents = document.getElementById(id).innerHTML;
							var originalContents = document.body.innerHTML;

							document.body.innerHTML = printContents;

							window.print();

							document.body.innerHTML = originalContents;
						}						
					</script>
					<div id="conteudo-imprimir" style="width:900px; margin-top:-100px; display:none; min-height:500px; position:absolute; z-index:1; left:50%; margin-left:-450px; box-shadow:0px 0px 20px #528585; border-radius:10px; background-color:#FFFFFF;">
						<div id="conteudo-scroll" style="width:900px; height:500px; overflow-y:auto;">
							<div id="imprime-requisicao" style="width:800px; padding-top:20px; padding-bottom:20px; margin:0 45px auto;">
								<div style="width:800px; margin:0 auto;">
									<script type="text/javascript">
										function imprime() {
											var oJan;
											oJan.window.print();
										}
																		
										function tiraBotao() {
											document.getElementById("botao-imprimir").style.display="none";									 
										}								
									</script>
									<p style="display:none; margin: auto; margin-bottom:20px;" id="botao-imprimir"><input type="submit" value="Imprimir" onClick="tiraBotao(); imprime(window.print());"/></p>
									<div id="topo-requisicao" style="width:800px; border-bottom:2px solid #000000;">	
										<p style="display:table; margin:0 auto; padding-bottom:10px;"><img src="<?php echo $configUrlGer;?>f/i/comp.png" height="80"/></p>
										<div style="display:table; margin:0 auto;">
											<div style="display:table; margin:0 auto;">
												<p style="font-size:13px; padding:0px; margin:0px; font-family:Arial; float:left; margin-right:30px; margin-bottom:10px;"><?php echo $cnpjImobiliaria;?></p>
												<p style="font-size:13px; padding:0px; margin:0px; font-family:Arial; float:left; margin-bottom:10px;"><?php echo $telefoneImobiliaria;?></p>
												<br style="clear:both;"/>
											</div>	
											<p style="text-align:center; font-size:13px; padding:0px; margin:0px; font-family:Arial;"><?php echo $cidadeEstadoImobiliaria;?></p>
										</div>
										<br class="clear"/>
									</div>
									<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:40px;">
										<div id="mostra-dados" style="width:100%;">
											<p style="text-align:center; font-size:18px; font-family:Arial; font-weight:bold;">R E C I B O</p>
											<p style="padding-top:20px; padding-top:40px; font-family:Arial; text-align:center;">Recebemos de <span style="font-size:16px; font-weight:bold;"><?php echo $dadosCliente['nomeCliente'];?></span> a quantia de <span style="font-size:16px; font-weight:bold;" id="valor-imprime">R$ 200,00</span> em <span style="font-size:16px; font-weight:bold;" id="data-imprime">19/12/2015</span>.</p>
											<p style="text-align:center; padding-top:60px;">________________________________________</p>
										</div>
									</div>
									<p style="width:100%; border-top:1px dashed #000; margin-top:60px; margin-bottom:40px;"></p>
									<div id="topo-requisicao" style="width:800px; border-bottom:2px solid #000000;">	
										<p style="display:table; margin:0 auto; padding-bottom:10px;"><img src="<?php echo $configUrlGer;?>f/i/comp.png" height="80"/></p>
										<div style="display:table; margin:0 auto;">
											<p style="font-size:13px; padding:0px; margin:0px; font-family:Arial; float:left; margin-right:30px; margin-bottom:10px;"><?php echo $cnpjImobiliaria;?></p>
											<p style="font-size:13px; padding:0px; margin:0px; font-family:Arial; float:left; margin-bottom:10px;"><?php echo $telefoneImobiliaria;?></p>
											<p style="text-align:center; font-size:13px; padding:0px; margin:0px; font-family:Arial;"><?php echo $cidadeEstadoImobiliaria;?></p>
										</div>
										<br class="clear"/>
									</div>
									<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:40px;">
										<div id="mostra-dados" style="width:100%;">
											<p style="text-align:center; font-size:18px; font-family:Arial; font-weight:bold;">R E C I B O</p>
											<p style="padding-top:20px; padding-top:40px; font-family:Arial; text-align:center;">Recebemos de <span style="font-size:16px; font-weight:bold;"><?php echo $dadosCliente['nomeCliente'];?></span> a quantia de <span style="font-size:16px; font-weight:bold;" id="valor-imprime2">R$ 200,00</span> em <span style="font-size:16px; font-weight:bold;" id="data-imprime2">19/12/2015</span>.</p>
											<p style="text-align:center; padding-top:60px;">________________________________________</p>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
					<div id="mostra-parcial" style="width:1130px; margin-top:30px;">
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Data</th>
								<th>Hora</th>
								<th>Observação</th>
								<th>Meio</th>
								<th>Conta</th>
								<th>Desconto</th>
								<th>Acréscimo</th>
								<th>Valor</th>
								<th>Imprimir</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php
				$sqlContaParcial = "SELECT * FROM contasParcial WHERE codConta = ".$url[6]." ORDER BY dataContaParcial DESC, codContaParcial DESC";
				$resultContaParcial = $conn->query($sqlContaParcial);
				while($dadosContaParcial = $resultContaParcial->fetch_assoc()){
					
					if($dadosContaParcial['formaContaParcial'] == "PI"){
						$forma = "Pix";
					}else
					if($dadosContaParcial['formaContaParcial'] == "CH"){
						$forma = "Cheque";
					}else
					if($dadosContaParcial['formaContaParcial'] == "D"){
						$forma = "Dinheiro";
					}else
					if($dadosContaParcial['formaContaParcial'] == "C"){
						$forma = "Cartão";
					}else
					if($dadosContaParcial['formaContaParcial'] == "B"){
						$forma = "Boleto";
					}else
					if($dadosContaParcial['formaContaParcial'] == "TD"){
						$forma = "Transf/Depósito";
					}else{
						$forma = "Permuta";
					}
					
					$valorRecebido = $valorRecebido + $dadosContaParcial['valorContaParcial'];
					$valorDescontos = $valorDescontos + $dadosContaParcial['descontoContaParcial'];
					$valorAcrescimos = $valorAcrescimos + $dadosContaParcial['acrescimoContaParcial'];
?>

							<tr class="tr">
								<td class="dez" style="text-align:center;"><?php echo data($dadosContaParcial['dataContaParcial']);?></a></td>
								<td class="dez" style="text-align:center;"><?php echo $dadosContaParcial['horarioContaParcial'];?></a></td>
								<td class="dez" style="text-align:center;"><?php echo $dadosContaParcial['nomeContaParcial'];?></a></td>
								<td class="dez" style="width:10%; text-align:center;"><?php echo $forma;?></td>
								<td class="dez" style="width:10%; text-align:center;">
									<select onChange="executaForm(<?php echo $dadosContaParcial['codContaParcial'];?>);" class="campo" id="conta<?php echo $dadosContaParcial['codContaParcial'];?>" style="width:100%;">
<?php
					$sqlBanco = "SELECT * FROM bancos WHERE statusBanco = 'T' ORDER BY nomeBanco ASC";
					$resultBanco = $conn->query($sqlBanco);
					while($dadosBanco = $resultBanco->fetch_assoc()){
?>
										<option value="<?php echo $dadosBanco['codBanco'] ;?>" <?php echo $dadosContaParcial['contaPagamentoConta'] == $dadosBanco['codBanco'] ? '/SELECTED/' : '';?>><?php echo $dadosBanco['nomeBanco'];?></option>
<?php
					}
?>	
									</select>
								</td>
								<td class="dez" style="width:10%; text-align:center;">R$ <?php echo number_format($dadosContaParcial['descontoContaParcial'], 2, ",", ".");?></a></td>
								<td class="dez" style="width:10%; text-align:center;">R$ <?php echo number_format($dadosContaParcial['acrescimoContaParcial'], 2, ",", ".");?></a></td>
								<td class="dez" style="width:10%; text-align:center;">R$ <?php echo number_format($dadosContaParcial['valorContaParcial'], 2, ",", ".");?></a></td>
								<td class="botoes"><img style="cursor:pointer;" onClick="imprimeRequisicao('imprime-requisicao', 'imprime.html', '<?php echo number_format($dadosContaParcial['valorContaParcial'], 2);?>', '<?php echo data($dadosContaParcial['dataContaParcial']);?>');" src="<?php echo $configUrlGer;?>f/i/default/corpo-default/reemprimir.png"/></td>
								<td class="botoes" style="padding:0px;"><a href='javascript: confirmaExclusao(<?php echo $dadosContaParcial['codContaParcial'] ?>, "<?php echo htmlspecialchars($dadosContaParcial['nomeContaParcial']) ?>");' title='Deseja excluir a conta parcial <?php echo $dadosContaParcial['nomeContaParcial'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
							</tr>
<?php
				}
?>		 								 
							<script>
								function executaForm(cod){
									document.getElementById("manda-cod").value=cod;
									var pegaValue = document.getElementById("conta"+cod).value;
									document.getElementById("manda-conta").value=pegaValue;
									document.getElementById("forms").submit();
								}
							</script>
							<script>
								 function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir a conta parcial "+nome+"?")){
										document.getElementById("exclui-parcial").value=cod;
										document.getElementById("forms-excluir").submit();
									}
								  }
							 </script>
							<form id="forms" action="<?php echo $configUrl;?>financeiro/contas-receber/alterar/<?php echo $url[6];?>/#pagamento" method="post">	
								<input type="hidden" value="" id="manda-cod" name="cod"/>
								<input type="hidden" value="" id="manda-conta" name="contaPgto"/>
							</form>	
							<form id="forms-excluir" action="<?php echo $configUrl;?>financeiro/contas-receber/alterar/<?php echo $url[6];?>/#pagamento" method="post">	
								<input type="hidden" value="" id="exclui-parcial" name="exclui-parcial"/>
							</form>	
						</table>				
						<p class="total-receber" style="color:#718B8F; margin-bottom:5px; padding-top:15px; margin-right:10px; text-align:right;"><strong>Valor da Conta:</strong> R$ <?php echo number_format($dadosContas['vParcela'], 2, ",", ".");?></p>
						<p class="total-receber" style="color:#718B8F; margin-bottom:5px; margin-right:10px; text-align:right;"><strong>Total Descontos:</strong> R$ <?php echo number_format($valorDescontos, 2, ",", ".");?></p>
						<p class="total-receber" style="color:#718B8F; margin-bottom:5px; margin-right:10px; text-align:right;"><strong>Total Acréscimos:</strong> R$ <?php echo number_format($valorAcrescimos, 2, ",", ".");?></p>
						<p class="total-receber" style="color:#718B8F; margin-bottom:5px; margin-right:10px; text-align:right;"><strong>Total Recebido:</strong> R$ <?php echo number_format($valorRecebido, 2, ",", ".");?></p>
						<p class="total-receber" style="color:#718B8F; margin-bottom:10px; margin-right:10px; text-align:right;"><strong>Total a Receber:</strong> R$ <?php echo number_format($valorReceber, 2, ",", ".");?></p>
					</div>
				</div>
			</div>
<?php
			}else{
?>	
			<div id="filtro">
				<div id="erro-permicao">	
<?php
				echo "<p><strong>Você não tem permissão para acessar essa área!</strong></p>";
				echo "<p>Para mais informações entre em contato com o administrador!</p>";
?>	
				</div>
			</div>
<?php
			}

		}else{
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."controle-acesso.php'>";
		}

	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login.php'>";
	}
?>
