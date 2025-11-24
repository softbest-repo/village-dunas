<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "vendas-despesas";
			if(validaAcesso($conn, $area) == "ok"){

				if($_POST['data1'] != "" && $_POST['data2'] != ""){
					$data1 = $_POST['data1'];
					$data2 = $_POST['data2'];
					$_SESSION['data1'] = $data1;
					$_SESSION['data2'] = $data2;
				}else{
					$_SESSION['data1'] = "";
					$_SESSION['data2'] = "";
				}													
?>
	
				<div id="filtro">
					<div id="localizacao-filtro">
						<p style="margin-top:15px;" class="nome-lista">Relatórios</p>
						<p style="margin-top:15px;" class="flexa"></p>
						<p style="margin-top:15px;" class="nome-lista">Vendas / Despesas</p>
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
								<form name="filtro" action="<?php echo $configUrl;?>relatorios/vendas-despesas/" method="post" >
									<p class="bloco-campo-float"><label>De: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data1" required name="data1" size="10" value="<?php echo $_SESSION['data1']; ?>"/></p>

									<p class="bloco-campo-float"><label>Até: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data2" required name="data2" size="10" value="<?php echo $_SESSION['data2']; ?>"/></p>
																
									<p class="botao-filtrar" style="margin-top:17px;"><input type="submit" name="filtrar" value="Filtrar" /></p>

									<br class="clear" />
								</form>						
							</div>
							<br class="clear"/>
						</div>
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>
						<p style="float:right; margin-right:50px; margin-top:43px; cursor:pointer;" onClick="abrirImprimir();"><img src="<?php echo $configUrl;?>f/i/icones-imprimir2.gif" width="50"/></p>
<?php
				}
?>
						<br class="clear"/>
					</div>
				</div>
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>				<script type="text/javascript">
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
					<div id="conteudo-scroll" style="width:900px; height:500px; overflow-y:auto;">
						<p class="botao-fechar" onClick="fechaArquivo();" style="width:25px; color:#FFFFFF; padding:1px; padding-top:2px; text-align: center; cursor: pointer; position: absolute; z-index:1; background-color:#718B8F; border-radius:235px; font-size:20px; margin-left:892px; margin-top:-15px;">X</p>
						<p class="botao-imprimir" style="position:absolute; z-index:2; cursor:pointer; margin-left:418px; margin-top:-30px;" onClick="imprimeRequisicao('imprime-requisicao', 'imprime.html')"><img src="<?php echo $configUrlGer;?>f/i/icon-impressora2.png" alt="Imagem" /></p>
						<div id="imprime-requisicao" style="width:800px; padding-top:20px; padding-bottom:20px; margin:0 45px auto;">
							<div style="width:800px; margin:0 auto;">
								<div id="topo-requisicao" style="width:800px; border-bottom:2px solid #000000;">	
									<p style="display:table; margin:0 auto; padding-bottom:10px;"><img src="<?php echo $configUrlGer;?>f/i/comp.png" height="80"/></p>
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; padding-top:5px; margin:0; font-family:Arial; font-size:24px; font-weight:bold;"><?php echo $nomeEmpresaMenor;?> - Relatório Vendas / Despesas</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:40px;">
									<div id="mostra-dados" style="width:100%;">
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:67%; float:left; margin:0; padding:1%; font-size:16px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Contas</p>
											<p style="width:28%; float:left; margin:0; padding:1%; font-size:16px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:none;">Valor</p>
											<br style="clear:both;"/>
										</div>
<?php	
					$totalRP = 0; 
					
					$sqlContaR = "SELECT SUM(vParcela) total FROM contas WHERE baixaConta = 'T' and areaPagamentoConta = 'R' and dataCConta >= '".$_SESSION['data1']."' and dataCConta <= '".$_SESSION['data2']."'";
					$resultContaR = $conn->query($sqlContaR);
					$dadosContaR = $resultContaR->fetch_assoc();
					
					$sqlContaP = "SELECT SUM(vParcela) total FROM contas WHERE baixaConta = 'T' and areaPagamentoConta = 'P' and dataCConta >= '".$_SESSION['data1']."' and dataCConta <= '".$_SESSION['data2']."'";
					$resultContaP = $conn->query($sqlContaP);
					$dadosContaP = $resultContaP->fetch_assoc();
						
					$totalRP = $dadosContaR['total'] - $dadosContaP['total'];
					
					if($dadosContaR['total'] > $dadosContaP['total']){
						$color = "color:#0000FF;";
					}else{
						$color = "color:#FF0000;";
					}
?>

										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:70%; float:left; margin:0; font-size:16px; color:#0000FF; font-family:Arial; text-align:center;">Vendas</p>
											<p style="width:30%; float:left; margin:0; font-size:16px; color:#0000FF; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosContaR['total'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:70%; float:left; margin:0; font-size:16px; color:#FF0000; font-family:Arial; text-align:center;">Despesas</p>
											<p style="width:30%; float:left; margin:0; font-size:16px; color:#FF0000; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosContaP['total'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
										<p style="padding:0px; margin:0px; padding-top:5px; margin-top:20px; border-top:1px solid #000;"></p>
										<p style="padding:0px; margin:0px; width:30%; text-align:center; float:right; font-family:Arial; <?php echo $color;?> font-size:16px;"><strong>Total:</strong><br/>R$ <?php echo number_format($totalRP, 2, ",", ".");?></p>
										<br style="clear:both;"/>
										<p style=" padding:0px; margin:0px;margin-top:5px; border-bottom:1px solid #000;"></p>
										<br/>
										<br/>
										<br/>
										<p style="margin:0px; padding:0px; font-size:20px; text-align:center; text-decoration:underline; font-family:Arial; padding-bottom:20px; font-weight:bold;">Vendas</p>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:27%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Cliente</p>
											<p style="width:28%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:none;">Tipo Pagamento</p>
											<p style="width:18%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:none;">Data de Cadastro</p>
											<p style="width:18%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:none;">Valor</p>
											<br style="clear:both;"/>
										</div>
<?php
					$totalRS = 0;
					
					$sqlContaRS = "SELECT * FROM contas WHERE baixaConta = 'T' and areaPagamentoConta = 'R' and dataCConta >= '".$_SESSION['data1']."' and dataCConta <= '".$_SESSION['data2']."' ORDER BY dataCConta ASC";
					$resultContaRS = $conn->query($sqlContaRS);
					while($dadosContaRS = $resultContaRS->fetch_assoc()){
								
						$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosContaRS['codTipoPagamento']." LIMIT 0,1";
						$resultTipoPagamento = $conn->query($sqlTipoPagamento);
						$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();
						
						$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$dadosContaRS['codCliente']." LIMIT 0,1";
						$resultCliente = $conn->query($sqlCliente);
						$dadosCliente = $resultCliente->fetch_assoc();
							
						$totalRS = $totalRS + $dadosContaRS['vParcela'];		
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:30%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosCliente['nomeCliente'];?></p>
											<p style="width:30%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></p>
											<p style="width:20%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo data($dadosContaRS['dataCConta']);?></p>
											<p style="width:20%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosContaRS['vParcela'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
					}
?>
										<p style="padding:0px; margin:0px; padding-top:5px; margin-top:20px; border-top:1px solid #000;"></p>
										<p style="padding:0px; margin:0px; width:20%; text-align:center; font-size:16px; font-family:Arial; float:right;"><strong>Total:</strong><br/>R$ <?php echo number_format($totalRS, 2, ",", ".");?></p>
										<br style="clear:both;"/>
										<p style="padding:0px; margin:0px; margin-top:5px; border-bottom:1px solid #000;"></p>
										<br/>
										<br/>
										<br/>
										<p style="margin:0px; padding:0px; font-size:20px; text-align:center; text-decoration:underline; padding-bottom:20px; font-family:Arial; font-weight:bold;">Despesas</p>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:27%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Fornecedor</p>
											<p style="width:28%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:none;">Tipo Pagamento</p>
											<p style="width:18%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:none;">Data de Cadastro</p>
											<p style="width:18%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:none;">Valor</p>
											<br style="clear:both;"/>
										</div>
<?php
					$totalPS = 0;
					
					$sqlContaPS = "SELECT * FROM contas WHERE baixaConta = 'T' and areaPagamentoConta = 'P' and dataCConta >= '".$_SESSION['data1']."' and dataCConta <= '".$_SESSION['data2']."' ORDER BY dataCConta ASC";
					$resultContaPS = $conn->query($sqlContaPS);
					while($dadosContaPS = $resultContaPS->fetch_assoc()){
											
						$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosContaPS['codTipoPagamento']." LIMIT 0,1";
						$resultTipoPagamento = $conn->query($sqlTipoPagamento);
						$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();

						$sqlFornecedor = "SELECT * FROM fornecedores WHERE codFornecedor = ".$dadosContaPS['codFornecedor']." LIMIT 0,1";
						$resultFornecedor = $conn->query($sqlFornecedor);
						$dadosFornecedor = $resultFornecedor->fetch_assoc();
						
						$totalPS = $totalPS + $dadosContaPS['vParcela'];	
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:30%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosFornecedor['nomeFornecedor'];?></p>
											<p style="width:30%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></p>
											<p style="width:20%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo data($dadosContaPS['dataCConta']);?></p>
											<p style="width:20%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosContaPS['vParcela'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
					}
?>
										<p style="padding:0px; margin:0px; padding-top:5px; margin-top:20px; border-top:1px solid #000;"></p>
										<p style="padding:0px; margin:0px; width:20%; text-align:center; font-size:16px; font-family:Arial; float:right;"><strong>Total:</strong><br/>R$ <?php echo number_format($totalPS, 2, ",", ".");?></p>
										<br style="clear:both;"/>
										<p style=" padding:0px; margin:0px;margin-top:5px; border-bottom:1px solid #000;"></p>										
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
					<div id="contas-receber">
						<div id="col-esq-receber" style="width:100%;">
							<p class="titulo-receber"></p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq" >Contas</th>
									<th class="canto-dir">Valor</th>
								</tr>					
<?php	
				$totalRP = 0; 
				
				$sqlContaR = "SELECT SUM(vParcela) total FROM contas WHERE baixaConta = 'T' and areaPagamentoConta = 'R' and dataCConta >= '".$_SESSION['data1']."' and dataCConta <= '".$_SESSION['data2']."'";
				$resultContaR = $conn->query($sqlContaR);
				$dadosContaR = $resultContaR->fetch_assoc();
				
				$sqlContaP = "SELECT SUM(vParcela) total FROM contas WHERE baixaConta = 'T' and areaPagamentoConta = 'P' and dataCConta >= '".$_SESSION['data1']."' and dataCConta <= '".$_SESSION['data2']."'";
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
								<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total:</p>
								<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; padding-bottom:10px; font-size:18px; <?php echo $color;?>">R$ <?php echo number_format($totalRP, 2, ",", ".");?></p>
							</div>
						</div>
						<br class="clear"/>
						<br/>
						<br/>
						<br/>
						<div id="col-dir-receber" style="width:100%;">
							<p class="titulo-receber" style="font-size:22px; text-align:center; padding-bottom:15px; font-weight:bold; color:#718B8F;">Vendas</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq" >Cliente</th>
									<th>Tipo Pagamento</th>
									<th>Data de Cadastro</th>
									<th class="canto-dir">Valor</th>
								</tr>					
<?php
				$totalRS = 0;
				
				$sqlContaRS = "SELECT * FROM contas WHERE baixaConta = 'T' and areaPagamentoConta = 'R' and dataCConta >= '".$_SESSION['data1']."' and dataCConta <= '".$_SESSION['data2']."' ORDER BY dataCConta ASC";
				$resultContaRS = $conn->query($sqlContaRS);
				while($dadosContaRS = $resultContaRS->fetch_assoc()){
							
					$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosContaRS['codTipoPagamento']." LIMIT 0,1";
					$resultTipoPagamento = $conn->query($sqlTipoPagamento);
					$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();
					
					$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$dadosContaRS['codCliente']." LIMIT 0,1";
					$resultCliente = $conn->query($sqlCliente);
					$dadosCliente = $resultCliente->fetch_assoc();
						
					$totalRS = $totalRS + $dadosContaRS['vParcela'];		
?>

								<tr class="tr">
									<td class="trinta" style="text-align:center;"><?php echo $dadosCliente['nomeCliente'];?></a></td>
									<td class="trinta" style="text-align:center;"><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></a></td>
									<td class="vinte" style="text-align:center;"><?php echo data($dadosContaRS['dataCConta']);?></a></td>
									<td class="vinte" style="text-align:center;">R$ <?php echo number_format($dadosContaRS['vParcela'], 2, ",", ".");?></a></td>
								</tr>
<?php
				}
?>							 
							</table>													
							<div id="total" style="background-color:#f5f5f5; margin-top:20px; width:100%;">
								<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total:</p>
								<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; padding-bottom:10px; font-size:16px;">R$ <?php echo number_format($totalRS, 2, ",", ".");?></p>
							</div>
						</div>
						<br class="clear"/>
						<br/>
						<br/>
						<br/>
						<br/>
						<div id="col-dir-receber" style="width:100%;">
							<p class="titulo-receber" style="font-size:22px; text-align:center; padding-bottom:15px; font-weight:bold; color:#718B8F;">Despesas</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq" >Fornecedor</th>
									<th>Tipo Pagamento</th>
									<th>Data de Cadastro</th>
									<th class="canto-dir">Valor</th>
								</tr>					
<?php
				$totalPS = 0;
				
				$sqlContaPS = "SELECT * FROM contas WHERE baixaConta = 'T' and areaPagamentoConta = 'P' and dataCConta >= '".$_SESSION['data1']."' and dataCConta <= '".$_SESSION['data2']."' ORDER BY dataCConta ASC";
				$resultContaPS = $conn->query($sqlContaPS);
				while($dadosContaPS = $resultContaPS->fetch_assoc()){
										
					$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosContaPS['codTipoPagamento']." LIMIT 0,1";
					$resultTipoPagamento = $conn->query($sqlTipoPagamento);
					$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();

					$sqlFornecedor = "SELECT * FROM fornecedores WHERE codFornecedor = ".$dadosContaPS['codFornecedor']." LIMIT 0,1";
					$resultFornecedor = $conn->query($sqlFornecedor);
					$dadosFornecedor = $resultFornecedor->fetch_assoc();
					
					$totalPS = $totalPS + $dadosContaPS['vParcela'];		
?>

								<tr class="tr">
									<td class="trinta" style="text-align:center;"><?php echo $dadosFornecedor['nomeFornecedor'];?></a></td>
									<td class="trinta" style="text-align:center;"><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></a></td>
									<td class="vinte" style="text-align:center;"><?php echo data($dadosContaPS['dataCConta']);?></a></td>
									<td class="vinte" style="text-align:center;">R$ <?php echo number_format($dadosContaPS['vParcela'], 2, ",", ".");?></a></td>
								</tr>
<?php
				}
?>							 
							</table>													
							<div id="total" style="background-color:#f5f5f5; margin-top:20px; width:100%;">
								<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total:</p>
								<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; padding-bottom:10px; font-size:16px;">R$ <?php echo number_format($totalPS, 2, ",", ".");?></p>
							</div>
						</div>
						<br class="clear"/>
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

