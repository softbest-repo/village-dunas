<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "corretores";
			if(validaAcesso($conn, $area) == "ok"){

				if($_POST['data1'] != "" && $_POST['data2'] != ""){
					$data1 = $_POST['data1'];
					$data2 = $_POST['data2'];
					$_SESSION['data1'] = $data1;
					$_SESSION['data2'] = $data2;
				}else{
					// Caso as sessions estejam vazias, filtra pelo mês atual
					if(empty($_SESSION['data1']) && empty($_SESSION['data2'])){
						$_SESSION['data1'] = date("Y-m-01");
						$_SESSION['data2'] = date("Y-m-t");
					} else {
						// mantém as sessões (possivelmente preexistentes)
						$_SESSION['data1'] = $_SESSION['data1'];
						$_SESSION['data2'] = $_SESSION['data2'];
					}
				}		

				if(isset($_POST['contratoFiltro'])){
					if($_POST['contratoFiltro'] != ""){
						$_SESSION['contratoFiltro'] = $_POST['contratoFiltro'];
					}else{
						$_SESSION['contratoFiltro'] = "";
					}
				}
				
				if($_SESSION['contratoFiltro'] != ""){
					$filtraContrato = " and C.codContrato = '".$_SESSION['contratoFiltro']."'";
					$filtraContrato2 = " and COM.codContrato = '".$_SESSION['contratoFiltro']."'";
					$filtraContrato3 = " and CC.codContrato = '".$_SESSION['contratoFiltro']."'";
				}		

				if($_POST['corretor'] != "" && $_POST['corretor'] != "TO"){
					$_SESSION['corretor'] = $_POST['corretor'];
				}else{
					$_SESSION['corretor'] = "";
				}											
?>
	
				<div id="filtro">
					<div id="localizacao-filtro">
						<p style="margin-top:15px;" class="nome-lista">Relatórios</p>
						<p style="margin-top:15px;" class="flexa"></p>
						<p style="margin-top:15px;" class="nome-lista">Imóveis Próprios</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro" style="width:auto; float:left;">
							<SCRIPT language="javascript">
								function AbreCalendario(largura,altura,formulario,campo,tmpx) {
									vertical   = (screen.height/2) - (altura/2);
									horizontal = (screen.width/2) - (largura/2);
									var jan = window.open('<?php echo $configUrl;?>calendario/calendario.php?formulario='+formulario+'&campo='+campo+'&tmpx='+tmpx,'','toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=yes,resizable=0,copyhistory=0,screenX='+screen.width+',screenY='+screen.height+',top='+vertical+',left='+horizontal+',width='+largura+',height='+altura);
									jan.focus();
								}
							</SCRIPT>
							<div class="por-mes" style="float:left; margin-right:20px;">	
								<br class="clear"/>
								<form name="filtro" action="<?php echo $configUrl;?>relatorios/imoveis-proprios/" method="post" >
									<p class="bloco-campo-float"><label>De: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data1" required name="data1" size="10" value="<?php echo $_SESSION['data1']; ?>"/></p>

									<p class="bloco-campo-float"><label>Até: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data2" required name="data2" size="10" value="<?php echo $_SESSION['data2']; ?>"/></p>
									
									<p class="bloco-campo-float">
										<label>Filtrar Contrato:</label>
										<select class="selectContratoFiltro form-control campo" id="idSelectContratoFiltro" name="contratoFiltro" style="width:350px; display: none;">
											<optgroup label="Selecione">
											<option value="">Todos</option>	
<?php
				$sqlContratos = "SELECT * FROM contratos C inner join clientes CL on C.codCliente = CL.codCliente inner join contas CO on C.codContrato = CO.codContrato GROUP BY C.codContrato ORDER BY C.dataContrato DESC";
				$resultContratos = $conn->query($sqlContratos);
				while($dadosContratos = $resultContratos->fetch_assoc()){
?>
											<optgroup label="Contrato #<?php echo $dadosContratos['codContrato'];?> - <?php echo $dadosContratos['nomeCliente'];?>">
<?php
					$lotes = "Código(s): ";
					
					$cont = 0;
				
					$sqlContratoImoveis = "SELECT * FROM contratosImoveis WHERE codContrato = ".$dadosContratos['codContrato']." ORDER BY codContratoImovel ASC";
					$resultContratoImoveis = $conn->query($sqlContratoImoveis);
					while($dadosContratoImoveis = $resultContratoImoveis->fetch_assoc()){
						$cont++;
						if($cont == 1){
							$lotes .= $dadosContratoImoveis['codLote'];
						}else{
							$lotes .= ", ".$dadosContratoImoveis['codLote'];
						}
					}
?>	
													<option value="<?php echo trim($dadosContratos['codContrato']);?>" <?php echo $dadosContratos['codContrato'] == $_SESSION['contratoFiltro'] ? 'selected' : ''; ?>><?php echo $lotes;?> - <?php echo data($dadosContratos['dataContrato']);?> - R$ <?php echo number_format($dadosContratos['valorContrato'], 2, ",", ".");?></option>										
											</optgroup>
<?php
				}
?>
										</select>										
									</p>

									<script>
										var $rfgs = jQuery.noConflict();

										$rfgs(".selectContratoFiltro").select2({
											placeholder: "Todos",
											multiple: false,
											templateResult: function (data) {
												if (!data.id) {
													return data.text;
												}
												var $result = $rfgs('<span>' + data.text + '</span>');
												return $result;
											},
											escapeMarkup: function (markup) {
												return markup;
											}
										});
									</script>
																								
									<p class="botao-filtrar" style="margin-top:17px;"><input type="submit" name="filtrar" value="Filtrar" onClick="enviar();" /></p>

									<br class="clear" />
								</form>						
							</div>
							<br class="clear"/>
						</div>
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>
<!--
						<p style="float:right; margin-right:50px; margin-top:43px; cursor:pointer;" onClick="abrirImprimir();"><img src="<?php echo $configUrl;?>f/i/icones-imprimir2.gif" width="50"/></p>											
-->
<?php
				}
?>
						<br class="clear"/>
					</div>
				</div>
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>
				<script type="text/javascript">
					function imprimeRequisicao(id, pg) {
						var printContents = document.getElementById(id).innerHTML;
						var originalContents = document.body.innerHTML;

						document.body.innerHTML = printContents;

						window.print();

						document.body.innerHTML = originalContents;
					}					

					function fechaArquivo(){
						var $rr = jQuery.noConflict();
						$rr("#conteudo-imprimir").fadeOut("slow");
					}
					
					function abrirImprimir(){
						var $ee = jQuery.noConflict();
						$ee("#conteudo-imprimir").fadeIn("slow");
						document.getElementById("botao-imprimir").style.display="none";									 
					}
				</script>
				<div id="conteudo-imprimir" style="width:900px; margin-top:-100px; min-height:500px; display:none; position:absolute; z-index:1; left:50%; margin-left:-450px; box-shadow:0px 0px 20px #528585; border-radius:10px; background-color:#FFFFFF;">
					<div id="conteudo-scroll" style="width:900px; height:500px; overflow-x:hidden; overflow-y:auto;">
						<p class="botao-fechar" onClick="fechaArquivo();" style="width:25px; color:#FFFFFF; padding:1px; padding-top:2px; text-align: center; cursor: pointer; position: absolute; z-index:1; background-color:#718B8F; border-radius:235px; font-size:20px; margin-left:892px; margin-top:-15px;">X</p>
						<p class="botao-imprimir" style="position:absolute; z-index:2; cursor:pointer; margin-left:418px; margin-top:-30px;" onClick="imprimeRequisicao('imprime-requisicao', 'imprime.html')"><img src="<?php echo $configUrlGer;?>f/i/icon-impressora2.png" alt="Imagem" /></p>
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
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; padding-top:5px; font-family:Arial; margin:0; font-size:24px; font-weight:bold;"><?php echo $nomeEmpresaMenor;?> - Relatório Corretores</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:30px;">
									<div id="mostra-dados" style="width:100%;">

									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
<?php
				}
?>				
				<div id="dados-conteudo">
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>
					<div id="contratos-receber">
						<div id="col-esq-receber" style="width:100%;">
							<p class="titulo-receber" style="font-size:24px; font-weight:bold; text-align:center; padding-bottom:20px; color:#718B8F;">Resumo Geral <span style="font-weight:normal;">(Entradas e Sáidas no Período)</span></p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq" >Contas</th>
									<th class="canto-dir">Valor</th>
								</tr>					
<?php	
				$totalRP = 0; 
				
				$sqlContaR = "SELECT SUM(valorContaParcial) total FROM contas C inner join contasParcial CP on C.codConta = CP.codConta inner join contratos CO on C.codContrato = CO.codContrato WHERE C.baixaConta = 'T' and C.areaPagamentoConta = 'R' and CP.dataContaParcial >= '".$_SESSION['data1']."' and CP.dataContaParcial <= '".$_SESSION['data2']."'".$filtraContrato."";
				$resultContaR = $conn->query($sqlContaR);
				$dadosContaR = $resultContaR->fetch_assoc();
				
				$sqlContaP = "SELECT SUM(valorContaParcial) total FROM contas C INNER JOIN contasParcial CP ON C.codConta = CP.codConta LEFT JOIN despesasImovel DI ON C.codDespesaImovel = DI.codDespesaImovel inner join comissoesCorretores CC on C.codComissaoCorretor = CC.codComissaoCorretor left join comissoes COM on CC.codComissao = COM.codComissao WHERE C.baixaConta = 'T' AND C.areaPagamentoConta = 'P' AND CP.dataContaParcial >= '".$_SESSION['data1']."' AND CP.dataContaParcial <= '".$_SESSION['data2']."' AND (C.codComissaoCorretor != 0 OR C.codDespesaImovel != 0)".$filtraContrato2."";
				$resultContaP = $conn->query($sqlContaP);
				$dadosContaP = $resultContaP->fetch_assoc();
					
				$totalRP = $dadosContaR['total'] - $dadosContaP['total'];
				
				if($dadosContaR['total'] > $dadosContaP['total']){
					$color = "color:#0000FF;";
				}else{
					$color = "color:#FF0000;";
				}
?>

								<tr class="tr">
									<td class="oitenta" style="text-align:center; color:#0000FF; font-size:18px;">Vendas</a></td>
									<td class="vinte" style="text-align:center; color:#0000FF; font-size:18px;">R$ <?php echo number_format($dadosContaR['total'], 2, ",", ".");?></a></td>
								</tr>
								<tr class="tr">
									<td class="oitenta" style="text-align:center; color:#FF0000; font-size:18px;">Despesas</a></td>
									<td class="vinte" style="text-align:center; color:#FF0000; font-size:18px;">R$ <?php echo number_format($dadosContaP['total'], 2, ",", ".");?></a></td>
								</tr>							 
							</table>							
							<div id="total" style="background-color:#f5f5f5; margin-top:20px; width:100%;">
								<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Lucro:</p>
								<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; padding-bottom:10px; font-size:18px; <?php echo $color;?>">R$ <?php echo number_format($totalRP, 2, ",", ".");?></p>
							</div>
						</div>
						<br class="clear"/>
						<br/>
						<br/>
						<br/>
						<div id="col-dir-receber" style="width:100%;">
							<p class="titulo-receber" style="font-size:22px; text-align:center; padding-bottom:15px; font-weight:bold; color:#718B8F;">Vendas <span style="font-weight:normal;">(Realizadas no Período)</span></p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Código</th>
									<th>Corretor</th>
									<th>Cliente</th>
									<th>Imóvel(eis)</th>
									<th>Data da Venda</th>
									<th class="canto-dir">Valor</th>
								</tr>					
<?php
				$totalRS = 0;
				
				$sqlContrato = "SELECT * FROM contratos C left join clientes CO on C.codCliente = CO.codCliente left join usuarios U on CO.codUsuario = U.codUsuario WHERE C.codContrato != '' and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraContrato." ORDER BY C.dataContrato DESC, C.codContrato DESC LIMIT 0,30";
				$resultContrato = $conn->query($sqlContrato);
				while($dadosContrato = $resultContrato->fetch_assoc()){

					$imoveis = "Código(s): ";
						
					$cont = 0;
					$sqlImoveis = "SELECT * FROM contratosImoveis CI inner join imoveis I on CI.codImovel = I.codImovel WHERE CI.codContrato = ".$dadosContrato['codContrato']." ORDER BY CI.codContrato ASC";
					$resultImoveis = $conn->query($sqlImoveis);
					while($dadosImoveis = $resultImoveis->fetch_assoc()){											
						$cont++;
						if($cont == 1){
							$imoveis .= $dadosImoveis['codigoImovel'];
						}else{
							$imoveis .= ", ".$dadosImoveis['codigoImovel'];
						}
					}
					
					$totalRS = $totalRS + $dadosContrato['valorContrato'];		
?>

								<tr class="tr">
									<td class="dez" style="text-align:center; font-weight:bold; font-size:20px;">#<?php echo $dadosContrato['codContrato'];?></a></td>
									<td class="vinte" style="text-align:center;"><?php echo $dadosContrato['nomeUsuario'];?></a></td>
									<td class="trinta" style="text-align:center;"><?php echo $dadosContrato['nomeCliente'];?></a></td>
									<td class="vinte" style="text-align:center;"><?php echo $imoveis;?></a></td>
									<td class="dez" style="text-align:center;"><?php echo data($dadosContrato['dataContrato']);?></a></td>
									<td class="dez" style="text-align:center;">R$ <?php echo number_format($dadosContrato['valorContrato'], 2, ",", ".");?></a></td>
								</tr>
<?php
				}
?>							 
							</table>													
							<div id="total" style="background-color:#f5f5f5; margin-top:20px; width:100%;">
								<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; color:#0000FF; padding-top:15px; text-align:right;">Total:</p>
								<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; color:#0000FF; padding-bottom:10px; font-size:16px;">R$ <?php echo number_format($totalRS, 2, ",", ".");?></p>
							</div>
						</div>
						<br/>
						<br/>
						<br/>
						<div id="col-dir-receber" style="width:100%;">
							<p class="titulo-receber" style="font-size:22px; text-align:center; padding-bottom:15px; font-weight:bold; color:#718B8F;">Entradas <span style="font-weight:normal;">(Realizadas no Período)</span></p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Nome</th>
									<th>Cliente</th>
									<th>Tipo Pagamento</th>
									<th>Data Pagamento</th>
									<th class="canto-dir">Valor</th>
								</tr>					
<?php
				$totalRS = 0;
				
				$sqlDespesa = "SELECT SUM(valorContaParcial) AS total, CP.dataContaParcial, C.nomeConta, CL.nomeCliente, TP.nomeTipoPagamento FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente inner join tipoPagamento TP on C.codTipoPagamento = TP.codTipoPagamento WHERE C.baixaConta = 'T' and C.areaPagamentoConta = 'R' and C.codContrato != 0 and CP.dataContaParcial >= '".$_SESSION['data1']."' AND CP.dataContaParcial <= '".$_SESSION['data2']."'".$filtraContrato." GROUP BY C.codConta ORDER BY CP.dataContaParcial ASC";
				$resultDespesa = $conn->query($sqlDespesa);
				while($dadosDespesa = $resultDespesa->fetch_assoc()){

					$totalRS = $totalRS + $dadosDespesa['total'];		
?>
								<tr class="tr">
									<td class="vinte" style="text-align:left;"><?php echo $dadosDespesa['nomeConta'];?></td>
									<td class="vinte" style="text-align:left;"><?php echo $dadosDespesa['nomeCliente'];?></td>
									<td class="vinte" style="text-align:left;"><?php echo $dadosDespesa['nomeTipoPagamento'];?></td>
									<td class="dez" style="text-align:center;"><?php echo data($dadosDespesa['dataContaParcial']);?></td>
									<td class="dez" style="text-align:center;">R$ <?php echo number_format($dadosDespesa['total'], 2, ",", ".");?></td>
								</tr>
<?php
				}
?>							 
							</table>													
							<div id="total" style="background-color:#f5f5f5; margin-top:20px; width:100%;">
								<p class="titulo" style="font-weight:bold; font-size:16px; color:#0000FF; padding-right:15px; padding-top:15px; text-align:right;">Total:</p>
								<p class="total" style="text-align:right; padding-right:15px; color:#0000FF; padding-top:5px; padding-bottom:10px; font-size:16px;">R$ <?php echo number_format($totalRS, 2, ",", ".");?></p>
							</div>
						</div>
						<br/>
						<br/>
						<br/>
						<div id="col-dir-receber" style="width:100%;">
							<p class="titulo-receber" style="font-size:22px; text-align:center; padding-bottom:15px; font-weight:bold; color:#718B8F;">Saídas <span style="font-weight:normal;">(Realizadas no Período)</span></p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Nome</th>
									<th>Fornecedor</th>
									<th>Tipo Pagamento</th>
									<th>Data Pagamento</th>
									<th class="canto-dir">Valor</th>
								</tr>					
<?php
				$totalRS = 0;
				
				$sqlDespesa = "SELECT SUM(valorContaParcial) AS total, CP.dataContaParcial, C.nomeConta, F.nomeFornecedor, TP.nomeTipoPagamento FROM contasParcial CP inner join contas C on CP.codConta = C.codConta left join despesasImovel D on C.codDespesaImovel = D.codDespesaImovel left join fornecedores F on C.codFornecedor = F.codFornecedor LEFT JOIN imoveis I ON D.codImovel = I.codImovel left join tipoPagamento TP on C.codTipoPagamento = TP.codTipoPagamento left join comissoesCorretores CC on C.codComissaoCorretor = CC.codComissaoCorretor left join comissoes COM on CC.codComissao = COM.codComissao WHERE (C.codDespesaImovel != '' or C.codComissaoCorretor) AND C.baixaConta = 'T' and C.areaPagamentoConta = 'P' and CP.dataContaParcial >= '".$_SESSION['data1']."' AND CP.dataContaParcial <= '".$_SESSION['data2']."'".$filtraContrato2." GROUP BY C.codConta ORDER BY CP.dataContaParcial ASC, D.codDespesaImovel DESC LIMIT 0,30";
				$resultDespesa = $conn->query($sqlDespesa);
				while($dadosDespesa = $resultDespesa->fetch_assoc()){

					$totalRS = $totalRS + $dadosDespesa['total'];		
?>
								<tr class="tr">
									<td class="vinte" style="text-align:left;"><?php echo $dadosDespesa['nomeConta'];?></td>
									<td class="vinte" style="text-align:left;"><?php echo $dadosDespesa['nomeFornecedor'];?></td>
									<td class="vinte" style="text-align:left;"><?php echo $dadosDespesa['nomeTipoPagamento'];?></td>
									<td class="dez" style="text-align:center;"><?php echo data($dadosDespesa['dataContaParcial']);?></td>
									<td class="dez" style="text-align:center;">R$ <?php echo number_format($dadosDespesa['total'], 2, ",", ".");?></td>
								</tr>
<?php
				}
?>							 
							</table>													
							<div id="total" style="background-color:#f5f5f5; margin-top:20px; width:100%;">
								<p class="titulo" style="font-weight:bold; font-size:16px; color:#FF0000; padding-right:15px; padding-top:15px; text-align:right;">Total:</p>
								<p class="total" style="text-align:right; padding-right:15px; color:#FF0000; padding-top:5px; padding-bottom:10px; font-size:16px;">R$ <?php echo number_format($totalRS, 2, ",", ".");?></p>
							</div>
						</div>
					</div>	
<?php
				}else{
?>
					<p style="text-align:center; padding-top:100px; font-size:16px; color:#718B8F;">Selecione no filtro acima a data De e Até para exibir um relatório!</p>
<?php				
				}
?>					
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
