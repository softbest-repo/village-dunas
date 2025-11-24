<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "ranking";
			if(validaAcesso($conn, $area) == "ok"){

				// Mostra ano atual completo
				if(!empty($_POST['data1']) && !empty($_POST['data2'])){
					$data1 = $_POST['data1'];
					$data2 = $_POST['data2'];
					$_SESSION['data1'] = $data1;
					$_SESSION['data2'] = $data2;
				} else {
					$anoAtual = date('Y');
					$_SESSION['data1'] = $anoAtual . '-01-01';
					$_SESSION['data2'] = $anoAtual . '-12-31';
				}
?>
	
				<div id="filtro">
					<div id="localizacao-filtro">
						<p style="margin-top:15px;" class="nome-lista">Relatórios</p>
						<p style="margin-top:15px;" class="flexa"></p>
						<p style="margin-top:15px;" class="nome-lista">Ranking de Vendas</p>
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
								<form name="filtro" action="<?php echo $configUrl;?>relatorios/ranking/" method="post" >
									<p class="bloco-campo-float"><label>De: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data1" required name="data1" size="10" value="<?php echo $_SESSION['data1']; ?>"/></p>

									<p class="bloco-campo-float"><label>Até: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data2" required name="data2" size="10" value="<?php echo $_SESSION['data2']; ?>"/></p>
																
									<p class="botao-filtrar" style="margin-top:17px;"><input type="submit" name="filtrar" value="Filtrar" onClick="enviar();" /></p>

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
					<div id="conteudo-scroll" style="width:900px; height:500px; overflow-y:auto;">
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
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; padding-top:5px; margin:0; font-family:Arial; font-size:24px; font-weight:bold;"><?php echo $nomeEmpresaMenor;?> - Ranking de Vendas</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:30px;">
									<div id="mostra-dados" style="width:100%;">
										<p style="text-align:center; font-size:18px; padding-bottom:25px;"><?php echo data($_SESSION['data1']);?> á <?php echo data($_SESSION['data2']);?></p>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:7%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; text-align:center; font-family:Arial; border:1px dashed #000; border-right:none;">Posição</p>
											<p style="width:21.37%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; text-align:center; font-family:Arial; border:1px dashed #000; border-right:none;">Corretor</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; text-align:center; font-family:Arial; border:1px dashed #000; border-right:none;">Quantidade de  Vendas</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; text-align:center; font-family:Arial; border:1px dashed #000; border-right:none;">Maior Venda</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; text-align:center; font-family:Arial; border:1px dashed #000;">Total em Vendas</p>
											<br style="clear:both;"/>
										</div>
<?php				
					$totalVendas = 0;
					$totalValor = 0;

					$cont = 0;

					// Consulta todos os corretores que participaram de vendas com linhaComissaoCorretor = 'CV'
					$sqlCorretores = "SELECT U.codUsuario, U.nomeUsuario, COUNT(CC.codComissaoCorretor) as quantidadeVendas, MAX(CASE WHEN C.negociacaoComissao = 'V' THEN C.valorImovelComissao ELSE NULL END) as maiorVenda, SUM(CASE WHEN C.negociacaoComissao = 'V' THEN C.valorImovelComissao ELSE 0 END) as totalVendas FROM comissoesCorretores CC INNER JOIN usuarios U ON CC.codUsuario = U.codUsuario INNER JOIN comissoes C ON CC.codComissao = C.codComissao WHERE C.pagamentoComissao = 'T' and ((CC.linhaComissaoCorretor = 'CV' and C.negociacaoComissao = 'V') or (CC.linhaComissaoCorretor = 'CA' and C.negociacaoComissao = 'C')) and C.dataComissao >= '".$_SESSION['data1']."' and C.dataComissao <= '".$_SESSION['data2']."' GROUP BY U.codUsuario, U.nomeUsuario ORDER BY quantidadeVendas DESC";
					$resCorretores = $conn->query($sqlCorretores);
					while($corretor = $resCorretores->fetch_assoc()){
						$totalVendas += $corretor['quantidadeVendas'];
						$totalValor += $corretor['totalVendas'];		
						$cont++;				
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:10%; float:left; margin:0; font-size:18px; font-weight:bold; font-family:Arial; text-align:center; border-right:none;"><?php echo $cont; ?>º</p>
											<p style="width:23.5%; float:left; margin:0; font-size:15px; font-family:Arial; text-align:center; border-right:none;"><?php echo htmlspecialchars($corretor['nomeUsuario']); ?></p>
											<p style="width:22%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center; border-right:none;"><?php echo $corretor['quantidadeVendas']; ?></p>
											<p style="width:22%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center; border-right:none;">R$ <?php echo number_format($corretor['maiorVenda'], 2, ",", "."); ?></p>
											<p style="width:22%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($corretor['totalVendas'], 2, ",", "."); ?></p>
											<br style="clear:both;"/>
										</div>
<?php
					}
?>
										<br/>
										<br/>
										<br/>
										<br/>
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
						<div id="col-dir-receber" style="width:100%;">
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Posição</th>
									<th>Corretor</th>
									<th>Quantidade Vendas</th>
									<th>Maior Venda</th>
									<th class="canto-dir">Total em Vendas</th>
								</tr>
<?php
					$totalVendas = 0;
					$totalValor = 0;

					$cont = 0;

					// Consulta todos os corretores que participaram de vendas com linhaComissaoCorretor = 'CV'
					$sqlCorretores = "SELECT U.codUsuario, U.nomeUsuario, COUNT(CC.codComissaoCorretor) as quantidadeVendas, MAX(CASE WHEN C.negociacaoComissao = 'V' THEN C.valorImovelComissao ELSE NULL END) as maiorVenda, SUM(CASE WHEN C.negociacaoComissao = 'V' THEN C.valorImovelComissao ELSE 0 END) as totalVendas FROM comissoesCorretores CC INNER JOIN usuarios U ON CC.codUsuario = U.codUsuario INNER JOIN comissoes C ON CC.codComissao = C.codComissao WHERE C.pagamentoComissao = 'T' and ((CC.linhaComissaoCorretor = 'CV' and C.negociacaoComissao = 'V') or (CC.linhaComissaoCorretor = 'CA' and C.negociacaoComissao = 'C')) and C.dataComissao >= '".$_SESSION['data1']."' and C.dataComissao <= '".$_SESSION['data2']."' GROUP BY U.codUsuario, U.nomeUsuario ORDER BY quantidadeVendas DESC";
					$resCorretores = $conn->query($sqlCorretores);
					while($corretor = $resCorretores->fetch_assoc()){
						$totalVendas += $corretor['quantidadeVendas'];
						$totalValor += $corretor['totalVendas'];

						$cont++;
?>
								<tr class="tr">
									<td class="dez" style="text-align:center; font-size:20px; font-weight:bold;"><?php echo $cont; ?>º</td>
									<td class="trinta" style="text-align:center;"><?php echo htmlspecialchars($corretor['nomeUsuario']); ?></td>
									<td style="text-align:center; font-size:26px; font-weight:bold;"><?php echo $corretor['quantidadeVendas']; ?></td>
									<td style="text-align:center;">R$ <?php echo number_format($corretor['maiorVenda'], 2, ",", "."); ?></td>
									<td class="vinte" style="text-align:center;">R$ <?php echo number_format($corretor['totalVendas'], 2, ",", "."); ?></td>
								</tr>
<?php
					}
?>							 
							</table>	
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
