<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "funcionariosR";
			if(validaAcesso($area, $conn) == "ok"){

				if($_POST['data1'] != "" && $_POST['data2'] != ""){
					$data1 = $_POST['data1'];
					$data2 = $_POST['data2'];
					$_SESSION['data1'] = $data1;
					$_SESSION['data2'] = $data2;
				}else{
					$_SESSION['data1'] = "";
					$_SESSION['data2'] = "";
				}

				if(isset($_POST['funcionarioFiltroRela'])){
					if($_POST['funcionarioFiltroRela'] == ""){
						$_SESSION['funcionarioFiltroRela'] = "";
					}else{
						$_SESSION['funcionarioFiltroRela'] = $_POST['funcionarioFiltroRela'];
					}
				}
				
				if($_SESSION['funcionarioFiltroRela'] != ""){
					$filtraFuncionario = " and I.codFuncionario = '".$_SESSION['funcionarioFiltroRela']."'";
				}																	
?>
	
				<div id="filtro">
					<div id="localizacao-filtro">
						<p style="margin-top:15px;" class="nome-lista">Relatórios</p>
						<p style="margin-top:15px;" class="flexa"></p>
						<p style="margin-top:15px;" class="nome-lista">Funcionários</p>
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
								<form name="filtro" action="<?php echo $configUrl;?>relatorios/funcionarios/" method="post" >
									<p class="bloco-campo-float"><label>De: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data1" required name="data1" size="10" value="<?php echo $_SESSION['data1']; ?>"/></p>

									<p class="bloco-campo-float"><label>Até: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data2" required name="data2" size="10" value="<?php echo $_SESSION['data2']; ?>"/></p>

									<p><label class="label">Funcionário:</label>							
										<select class="campo" style="width:250px;" name="funcionarioFiltroRela">
											<option value="">Todos</option>
<?php
				$sqlFuncionario = "SELECT * FROM funcionarios F inner join imoveis I on F.codFuncionario = I.codFuncionario inner join contratos C on I.codImovel = C.codImovel WHERE F.statusFuncionario = 'T' GROUP BY F.codFuncionario ORDER BY F.nomeFuncionario ASC, F.codFuncionario ASC";
				$resultFuncionario = $conn->query($sqlFuncionario);
				while($dadosFuncionario = $resultFuncionario->fetch_assoc()){
?>
											<option value="<?php echo $dadosFuncionario['codFuncionario'];?>" <?php echo $_SESSION['funcionarioFiltroRela'] == $dadosFuncionario['codFuncionario'] ? '/SELECTED/' : '';?> ><?php echo $dadosFuncionario['nomeFuncionario'];?></option>
<?php
				}
?>
										</select>
									</p>
																									
									<p class="botao-filtrar" style="margin-top:17px;"><input type="submit" name="filtrar" value="Filtrar" onClick="enviar();" /></p>

									<br class="clear" />
								</form>						
							</div>
							<br class="clear"/>
						</div>
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>
						<p style="float:right; margin-right:50px; margin-top:43px; cursor:pointer; color:#718B8F;" onClick="abrirImprimir();"><img style="display:table; margin:0 auto;" src="<?php echo $configUrl;?>f/i/icones-imprimir2.gif" width="50"/>Com Lucro</p>											
						<p style="float:right; margin-right:50px; margin-top:43px; cursor:pointer; color:#718B8F;" onClick="abrirImprimir2();"><img style="display:table; margin:0 auto;" src="<?php echo $configUrl;?>f/i/icones-imprimir2.gif" width="50"/>Sem Lucro</p>											
<?php
				}
?>
						<br class="clear"/>
					</div>
				</div>
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

					function fechaArquivo2(){
						var $rrs = jQuery.noConflict();
						$rrs("#conteudo-imprimir2").fadeOut("slow");
					}
					
					function abrirImprimir2(){
						var $ees = jQuery.noConflict();
						$ees("#conteudo-imprimir2").fadeIn("slow");
						document.getElementById("botao-imprimir2").style.display="none";									 
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
									<p style="display:table; margin:0 auto; padding-bottom:10px;"><img src="<?php echo $configUrlGer;?>f/i/logo-6002.png" height="80"/></p>
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; padding-top:5px; font-family:Arial; margin:0; font-size:24px; font-weight:bold;"><?php echo $nomeEmpresaMenor;?> - Relatório Funcionários</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto;">
									<div id="mostra-dados" style="width:100%;">
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>					
<?php
					if($_SESSION['funcionarioFiltroRela'] != ""){

						$sqlFuncionario = "SELECT nomeFuncionario, codFuncionario FROM funcionarios WHERE statusFuncionario = 'T' and codFuncionario = ".$_SESSION['funcionarioFiltroRela']." ORDER BY nomeFuncionario ASC, codFuncionario ASC";
						$resultFuncionario = $conn->query($sqlFuncionario);
						$dadosFuncionario = $resultFuncionario->fetch_assoc();						
?>								
										<p style="font-size:18px; font-weight:bold; color:#000; margin-top:20px; text-align:center;">Vendas do Funcionário <span style="font-size:18px; color:#000; font-weight:normal;"><?php echo $dadosFuncionario['nomeFuncionario'];?></span></p>														
										<p style="font-size:15px; margin-top:10px; color:#000; margin-bottom:10px; text-align:center;"><?php echo data($_SESSION['data1']);?> até <?php echo data($_SESSION['data2']);?></p>														
<?php
					}else{
?>
										<p style="font-size:18px; font-weight:bold; margin-top:20px; color:#000; text-align:center;">Vendas por Funcionário</p>														
										<p style="font-size:15px; margin-top:10px; color:#000; margin-bottom:10px; text-align:center;"><?php echo data($_SESSION['data1']);?> até <?php echo data($_SESSION['data2']);?></p>														
<?php
					}
?>
										<br/>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:29%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Funcionário</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Nº de Vendas</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Total de Vendas</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Média por Venda</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Lucro</p>
											<br style="clear:both;"/>
										</div>
<?php
					$sqlResumo = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissaoContrato) AS totalComissao, SUM(I.quantidadeImovel) AS totalQuantidade FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario WHERE C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraFuncionario." GROUP BY F.codFuncionario ORDER BY totalValor DESC, C.dataContrato ASC";
					$resultResumo = $conn->query($sqlResumo);
					while($dadosResumo = $resultResumo->fetch_assoc()){
						
						$mediaResumo = $dadosResumo['totalValor'] / $dadosResumo['totalQuantidade'];
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:31%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosResumo['nomeFuncionario'];?></p>
											<p style="width:17%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosResumo['totalQuantidade'];?></p>
											<p style="width:17%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosResumo['totalValor'], 2, ",", ".");?></p>
											<p style="width:17%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($mediaResumo, 2, ",", ".");?></p>
											<p style="width:17%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosResumo['totalComissao'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
					}
?>	
										<br/>
										<br/>
										<p style="padding:0px; margin:0px; font-size:20px; font-weight:bold; font-family:Arial; color:#000; text-align:center;">Vendas por Tipo Imóvel</p>
<?php
					$sqlTipoImovel = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissaoContrato) AS totalComissao, SUM(I.quantidadeImovel) AS totalQuantidade FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario inner join tipoImovel TI on I.codTipoImovel = TI.codTipoImovel WHERE C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraFuncionario." GROUP BY TI.codTipoImovel ORDER BY totalValor DESC, C.dataContrato ASC";
					$resultTipoImovel = $conn->query($sqlTipoImovel);
					while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){						
?>	
										<p style="font-size:16px; text-decoration:underline; margin-top:15px; color:#000; margin-bottom:20px; text-align:center;"><?php echo $dadosTipoImovel['nomeTipoImovel'];?></p>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:29%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Funcionário</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Nº de Vendas</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Total de Vendas</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Média por venda</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Lucro</p>
											<br style="clear:both;"/>
										</div>
<?php
						$sqlResumo = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissaoContrato) AS totalComissao, SUM(I.quantidadeImovel) AS totalQuantidade FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario WHERE C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and I.codTipoImovel = ".$dadosTipoImovel['codTipoImovel']."".$filtraFuncionario." GROUP BY F.codFuncionario ORDER BY totalValor DESC, C.dataContrato ASC";
						$resultResumo = $conn->query($sqlResumo);
						while($dadosResumo = $resultResumo->fetch_assoc()){
							
							$mediaTotalTipoImovel = $dadosResumo['totalValor'] / $dadosResumo['totalQuantidade'];
							$quantidadeTipoImovel = $quantidadeTipoImovel + $dadosResumo['totalQuantidade'];
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:31%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosResumo['nomeFuncionario'];?></p>
											<p style="width:17%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosResumo['totalQuantidade'];?></p>
											<p style="width:17%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosResumo['totalValor'], 2, ",", ".");?></p>
											<p style="width:17%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($mediaTotalTipoImovel, 2, ",", ".");?></p>
											<p style="width:17%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosResumo['totalComissao'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
						}
?>					
										<br/>
<?php
					}
?>										
										<br/>
										<p style="padding:0px; margin:0px; font-size:20px; font-weight:bold; font-family:Arial; color:#000; text-align:center;">Listagem das Vendas</p>
										<br/>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Funcionário</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Comprador</p>
											<p style="width:10%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Telefone</p>
											<p style="width:17%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">L, Q e B</p>
											<p style="width:8%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Data</p>
											<p style="width:10%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Valor</p>
											<p style="width:10%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Lucro</p>
											<br style="clear:both;"/>
										</div>
<?php
					$sqlContratoImovel = "SELECT * FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario WHERE C.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraFuncionario." GROUP BY C.codContrato ORDER BY C.dataContrato ASC";
					$resultContratoImovel = $conn->query($sqlContratoImovel);
					while($dadosContratoImovel = $resultContratoImovel->fetch_assoc()){

						$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$dadosContratoImovel['codCliente']." LIMIT 0,1";
						$resultCliente = $conn->query($sqlCliente);
						$dadosCliente = $resultCliente->fetch_assoc();						
?>
										<div id="clientes" style="width:100%; margin-bottom:10px; border-bottom:1px solid #000; padding-bottom:5px;">
											<p style="width:17.2%; float:left; margin:0; font-size:11px; font-family:Arial; text-align:center;"><?php echo $dadosContratoImovel['nomeFuncionario'];?></p>
											<p style="width:17.2%; float:left; margin:0; font-size:11px; font-family:Arial; text-align:center;"><?php echo $dadosCliente['nomeCliente'] != "" ? $dadosCliente['nomeCliente'] : '--';?></p>
											<p style="width:12.2%; float:left; margin:0; font-size:11px; font-family:Arial; text-align:center;"><?php echo $dadosCliente['telefoneCliente'] != "" ? $dadosCliente['telefoneCliente'] : $dadosCliente['celularCliente'];?> <?php echo $dadosCliente['telefoneCliente'] != "" && $dadosCliente['celularCliente'] != "" ? "<br/>".$dadosCliente['celularCliente'] : '';?> <?php echo $dadosCliente['telefoneCliente'] == "" && $dadosCliente['celularCliente'] == "" ? '--' : '';?></p>
											<p style="width:19%; float:left; margin:0; font-size:11px; font-family:Arial; text-align:center;"><?php echo $dadosContratoImovel['loteFiltroContrato'];?>, <?php echo $dadosContratoImovel['quadraFiltroContrato'];?>, <?php echo $dadosContratoImovel['bairroFiltroContrato'];?></p>
											<p style="width:10.1%; float:left; margin:0; font-size:12px; font-family:Arial; text-align:center;"><?php echo data($dadosContratoImovel['dataContrato']);?></p>
											<p style="width:12%; float:left; margin:0; font-size:12px; font-family:Arial; text-align:right;">R$ <?php echo number_format($dadosContratoImovel['valorContrato'], 2, ",", ".");?></p>
											<p style="width:12%; float:left; margin:0; font-size:12px; font-family:Arial; text-align:right;">R$ <?php echo number_format($dadosContratoImovel['valorComissaoContrato'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
					}
?>
										<br/>
										
<?php
				}
?>										
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div id="conteudo-imprimir2" style="width:900px; margin-top:-100px; min-height:500px; display:none; position:absolute; z-index:1; left:50%; margin-left:-450px; box-shadow:0px 0px 20px #528585; border-radius:10px; background-color:#FFFFFF;">
					<div id="conteudo-scroll" style="width:900px; height:500px; overflow-y:auto;">
						<p class="botao-fechar" onClick="fechaArquivo2();" style="width:25px; color:#FFFFFF; padding:1px; padding-top:2px; text-align: center; cursor: pointer; position: absolute; z-index:1; background-color:#718B8F; border-radius:235px; font-size:20px; margin-left:892px; margin-top:-15px;">X</p>
						<p class="botao-imprimir" style="position:absolute; z-index:2; cursor:pointer; margin-left:418px; margin-top:-30px;" onClick="imprimeRequisicao2('imprime-requisicao2', 'imprime.html')"><img src="<?php echo $configUrlGer;?>f/i/icon-impressora2.png" alt="Imagem" /></p>
						<div id="imprime-requisicao2" style="width:800px; padding-top:20px; padding-bottom:20px; margin:0 45px auto;">
							<div style="width:800px; margin:0 auto;">
								<script type="text/javascript">
									function imprime() {
										var oJan;
										oJan.window.print();
									}
																	
									function tiraBotao() {
										document.getElementById("botao-imprimir2").style.display="none";									 
									}								
								</script>
								<p style="display:none; margin: auto; margin-bottom:20px;" id="botao-imprimir2"><input type="submit" value="Imprimir" onClick="tiraBotao(); imprime(window.print());"/></p>
								<div id="topo-requisicao" style="width:800px; border-bottom:2px solid #000000;">	
									<p style="display:table; margin:0 auto; padding-bottom:10px;"><img src="<?php echo $configUrlGer;?>f/i/logo-6002.png" height="80"/></p>
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; padding-top:5px; font-family:Arial; margin:0; font-size:24px; font-weight:bold;"><?php echo $nomeEmpresaMenor;?> - Relatório Funcionários</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto;">
									<div id="mostra-dados" style="width:100%;">
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>					
<?php
					if($_SESSION['funcionarioFiltroRela'] != ""){

						$sqlFuncionario = "SELECT nomeFuncionario, codFuncionario FROM funcionarios WHERE statusFuncionario = 'T' and codFuncionario = ".$_SESSION['funcionarioFiltroRela']." ORDER BY nomeFuncionario ASC, codFuncionario ASC";
						$resultFuncionario = $conn->query($sqlFuncionario);
						$dadosFuncionario = $resultFuncionario->fetch_assoc();						
?>								
										<p style="font-size:18px; font-weight:bold; color:#000; margin-top:20px; text-align:center;">Vendas do Funcionário <span style="font-size:18px; color:#000; font-weight:normal;"><?php echo $dadosFuncionario['nomeFuncionario'];?></span></p>														
										<p style="font-size:15px; margin-top:10px; color:#000; margin-bottom:10px; text-align:center;"><?php echo data($_SESSION['data1']);?> até <?php echo data($_SESSION['data2']);?></p>														
<?php
					}else{
?>
										<p style="font-size:18px; font-weight:bold; margin-top:20px; color:#000; text-align:center;">Vendas por Funcionário</p>														
										<p style="font-size:15px; margin-top:10px; color:#000; margin-bottom:10px; text-align:center;"><?php echo data($_SESSION['data1']);?> até <?php echo data($_SESSION['data2']);?></p>														
<?php
					}
?>
										<br/>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:35%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Funcionário</p>
											<p style="width:18%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Nº de Vendas</p>
											<p style="width:19%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Total de Vendas</p>
											<p style="width:19%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Média por Venda</p>
											<br style="clear:both;"/>
										</div>
<?php
					$sqlResumo = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissaoContrato) AS totalComissao, SUM(I.quantidadeImovel) AS totalQuantidade FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario WHERE C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraFuncionario." GROUP BY F.codFuncionario ORDER BY totalValor DESC, C.dataContrato ASC";
					$resultResumo = $conn->query($sqlResumo);
					while($dadosResumo = $resultResumo->fetch_assoc()){
						
						$mediaResumo = $dadosResumo['totalValor'] / $dadosResumo['totalQuantidade'];
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:37.3%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosResumo['nomeFuncionario'];?></p>
											<p style="width:20%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosResumo['totalQuantidade'];?></p>
											<p style="width:21.3%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosResumo['totalValor'], 2, ",", ".");?></p>
											<p style="width:21.3%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($mediaResumo, 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
					}
?>	
										<br/>
										<br/>
										<p style="padding:0px; margin:0px; font-size:20px; font-weight:bold; font-family:Arial; color:#000; text-align:center;">Vendas por Tipo Imóvel</p>
<?php
					$sqlTipoImovel = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissaoContrato) AS totalComissao, SUM(I.quantidadeImovel) AS totalQuantidade FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario inner join tipoImovel TI on I.codTipoImovel = TI.codTipoImovel WHERE C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraFuncionario." GROUP BY TI.codTipoImovel ORDER BY totalValor DESC, C.dataContrato ASC";
					$resultTipoImovel = $conn->query($sqlTipoImovel);
					while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){						
?>	
										<p style="font-size:16px; text-decoration:underline; margin-top:15px; color:#000; margin-bottom:20px; text-align:center;"><?php echo $dadosTipoImovel['nomeTipoImovel'];?></p>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:35%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Funcionário</p>
											<p style="width:18%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Nº de Vendas</p>
											<p style="width:19%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Total de Vendas</p>
											<p style="width:19%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Média por venda</p>
											<br style="clear:both;"/>
										</div>
<?php
						$sqlResumo = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissaoContrato) AS totalComissao, SUM(I.quantidadeImovel) AS totalQuantidade FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario WHERE C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and I.codTipoImovel = ".$dadosTipoImovel['codTipoImovel']."".$filtraFuncionario." GROUP BY F.codFuncionario ORDER BY totalValor DESC, C.dataContrato ASC";
						$resultResumo = $conn->query($sqlResumo);
						while($dadosResumo = $resultResumo->fetch_assoc()){
							
							$mediaTotalTipoImovel = $dadosResumo['totalValor'] / $dadosResumo['totalQuantidade'];
							$quantidadeTipoImovel = $quantidadeTipoImovel + $dadosResumo['totalQuantidade'];
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:37.3%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosResumo['nomeFuncionario'];?></p>
											<p style="width:20%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosResumo['totalQuantidade'];?></p>
											<p style="width:21.3%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosResumo['totalValor'], 2, ",", ".");?></p>
											<p style="width:21.3%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($mediaTotalTipoImovel, 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
						}
?>					
										<br/>
<?php
					}
?>										
										<br/>
										<p style="padding:0px; margin:0px; font-size:20px; font-weight:bold; font-family:Arial; color:#000; text-align:center;">Listagem das Vendas</p>
										<br/>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Funcionário</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Comprador</p>
											<p style="width:10%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Telefone</p>
											<p style="width:19%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">L, Q e B</p>
											<p style="width:8%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Data</p>
											<p style="width:10%; float:left; margin:0; padding:1%; font-size:13px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Valor</p>
											<br style="clear:both;"/>
										</div>
<?php
					$sqlContratoImovel = "SELECT * FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario WHERE C.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraFuncionario." GROUP BY C.codContrato ORDER BY C.dataContrato ASC";
					$resultContratoImovel = $conn->query($sqlContratoImovel);
					while($dadosContratoImovel = $resultContratoImovel->fetch_assoc()){

						$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$dadosContratoImovel['codCliente']." LIMIT 0,1";
						$resultCliente = $conn->query($sqlCliente);
						$dadosCliente = $resultCliente->fetch_assoc();						
?>
										<div id="clientes" style="width:100%; margin-bottom:10px; border-bottom:1px solid #000; padding-bottom:5px;">
											<p style="width:22.2%; float:left; margin:0; font-size:11px; font-family:Arial; text-align:center;"><?php echo $dadosContratoImovel['nomeFuncionario'];?></p>
											<p style="width:22.2%; float:left; margin:0; font-size:11px; font-family:Arial; text-align:center;"><?php echo $dadosCliente['nomeCliente'] != "" ? $dadosCliente['nomeCliente'] : '--';?></p>
											<p style="width:12.2%; float:left; margin:0; font-size:11px; font-family:Arial; text-align:center;"><?php echo $dadosCliente['telefoneCliente'] != "" ? $dadosCliente['telefoneCliente'] : $dadosCliente['celularCliente'];?> <?php echo $dadosCliente['telefoneCliente'] != "" && $dadosCliente['celularCliente'] != "" ? "<br/>".$dadosCliente['celularCliente'] : '';?> <?php echo $dadosCliente['telefoneCliente'] == "" && $dadosCliente['celularCliente'] == "" ? '--' : '';?></p>
											<p style="width:21%; float:left; margin:0; font-size:11px; font-family:Arial; text-align:center;"><?php echo $dadosContratoImovel['loteFiltroContrato'];?>, <?php echo $dadosContratoImovel['quadraFiltroContrato'];?>, <?php echo $dadosContratoImovel['bairroFiltroContrato'];?></p>
											<p style="width:10.1%; float:left; margin:0; font-size:12px; font-family:Arial; text-align:center;"><?php echo data($dadosContratoImovel['dataContrato']);?></p>
											<p style="width:12%; float:left; margin:0; font-size:12px; font-family:Arial; text-align:right;">R$ <?php echo number_format($dadosContratoImovel['valorContrato'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
					}
?>
										<br/>
										
<?php
				}
?>										
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div id="dados-conteudo">
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>
					<div id="contratos-receber">
						<div id="total" style="margin-top:20px;">	
							<div id="total" style="margin-bottom:40px;">	
<?php
					if($_SESSION['funcionarioFiltroRela'] != ""){

						$sqlFuncionario = "SELECT nomeFuncionario, codFuncionario FROM funcionarios WHERE statusFuncionario = 'T' and codFuncionario = ".$_SESSION['funcionarioFiltroRela']." ORDER BY nomeFuncionario ASC, codFuncionario ASC";
						$resultFuncionario = $conn->query($sqlFuncionario);
						$dadosFuncionario = $resultFuncionario->fetch_assoc();						
?>								
								<p style="font-size:20px; font-weight:bold; margin-top:20px; color:#718B8F; text-align:center;">Vendas do Funcionário <span style="font-size:20px; color:#718B8F; font-weight:normal;"><?php echo $dadosFuncionario['nomeFuncionario'];?></span></p>														
								<p style="font-size:16px; margin-top:10px; color:#718B8F; margin-bottom:20px; text-align:center;"><?php echo data($_SESSION['data1']);?> até <?php echo data($_SESSION['data2']);?></p>														
<?php
					}else{
?>
								<p style="font-size:20px; font-weight:bold; margin-top:20px; color:#718B8F; text-align:center;">Vendas por Funcionário</p>														
								<p style="font-size:16px; margin-top:10px; color:#718B8F; margin-bottom:20px; text-align:center;"><?php echo data($_SESSION['data1']);?> até <?php echo data($_SESSION['data2']);?></p>														
<?php
					}
?>
								<table class="tabela-menus" >
									<tr class="titulo-tabela" border="none">
										<th class="canto-esq">Funcionário</th>
										<th>Nº de Vendas</th>
										<th>Total de Vendas</th>
										<th>Média por Venda</th>
										<th class="canto-dir">Lucro</th>
									</tr>
<?php
					$sqlResumo = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissaoContrato) AS totalComissao, SUM(I.quantidadeImovel) AS totalQuantidade FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario WHERE C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraFuncionario." GROUP BY F.codFuncionario ORDER BY totalValor DESC, C.dataContrato ASC";
					$resultResumo = $conn->query($sqlResumo);
					while($dadosResumo = $resultResumo->fetch_assoc()){
						
						$mediaResumo = $dadosResumo['totalValor'] / $dadosResumo['totalQuantidade'];					
?>											
									<tr class="tr">
										<td class="vinte" style="text-align:center; font-size:15px;"><?php echo $dadosResumo['nomeFuncionario'];?></a></td>
										<td class="dez" style="text-align:center; font-size:15px;"><?php echo $dadosResumo['totalQuantidade'];?></a></td>
										<td class="vinte" style="width:10%; text-align:center; font-size:15px;">R$ <?php echo number_format($dadosResumo['totalValor'], 2, ",", ".");?></a></td>
										<td class="vinte" style="width:10%; text-align:center; font-size:15px;">R$ <?php echo number_format($mediaResumo, 2, ",", ".");?></a></td>
										<td class="vinte" style="width:10%; text-align:center; font-size:15px;">R$ <?php echo number_format($dadosResumo['totalComissao'], 2, ",", ".");?></a></td>
									</tr>								
<?php
					}
?>
								</table>																				
							</div>
							<p style="font-size:20px; font-weight:bold; margin-top:20px; color:#718B8F; margin-bottom:20px; text-align:center;">Vendas por Tipo Imóvel</p>						
<?php
					$sqlTipoImovel = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissaoContrato) AS totalComissao, SUM(I.quantidadeImovel) AS totalQuantidade FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario inner join tipoImovel TI on I.codTipoImovel = TI.codTipoImovel WHERE C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraFuncionario." GROUP BY TI.codTipoImovel ORDER BY totalValor DESC, C.dataContrato ASC";
					$resultTipoImovel = $conn->query($sqlTipoImovel);
					while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){						
?>	
							<p style="font-size:18px; text-decoration:underline; margin-top:20px; color:#718B8F; margin-bottom:20px; text-align:center;"><?php echo $dadosTipoImovel['nomeTipoImovel'];?></p>
							<div id="total" style="margin-bottom:40px;">	
								<table class="tabela-menus" >
									<tr class="titulo-tabela" border="none">
										<th class="canto-esq">Funcionário</th>
										<th>Nº de Vendas</th>
										<th>Total de Vendas</th>
										<th>Média por venda</th>
										<th class="canto-dir">Lucro</th>
									</tr>
<?php
						$sqlResumo = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissaoContrato) AS totalComissao, SUM(I.quantidadeImovel) AS totalQuantidade FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario WHERE C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and I.codTipoImovel = ".$dadosTipoImovel['codTipoImovel']."".$filtraFuncionario." GROUP BY F.codFuncionario ORDER BY totalValor DESC, C.dataContrato ASC";
						$resultResumo = $conn->query($sqlResumo);
						while($dadosResumo = $resultResumo->fetch_assoc()){
							
							$mediaTotalTipoImovel = $dadosResumo['totalValor'] / $dadosResumo['totalQuantidade'];
							$quantidadeTipoImovel = $quantidadeTipoImovel + $dadosResumo['totalQuantidade'];

							$sqlProprietario = "SELECT * FROM proprietarios WHERE codProprietario = ".$dadosResumo['codProprietario']." LIMIT 0,1";
							$resultProprietario = $conn->query($sqlProprietario);
							$dadosProprietario = $resultProprietario->fetch_assoc();							
?>											
									<tr class="tr">
										<td class="vinte" style="text-align:center; font-size:15px;"><?php echo $dadosResumo['nomeFuncionario'];?></a></td>
										<td class="dez" style="text-align:center; font-size:15px;"><?php echo $dadosResumo['totalQuantidade'];?></a></td>
										<td class="vinte" style="width:10%; text-align:center; font-size:15px;">R$ <?php echo number_format($dadosResumo['totalValor'], 2, ",", ".");?></a></td>
										<td class="vinte" style="width:10%; text-align:center; font-size:15px;">R$ <?php echo number_format($mediaTotalTipoImovel, 2, ",", ".");?></a></td>
										<td class="vinte" style="width:10%; text-align:center; font-size:15px;">R$ <?php echo number_format($dadosResumo['totalComissao'], 2, ",", ".");?></a></td>
									</tr>
<?php
						}
?>									
								</table>																				
							</div>
<?php
					}	
?>
							<p style="font-size:20px; font-weight:bold; color:#718B8F; margin-bottom:15px; text-align:center;">Listagem das Vendas</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Funcionário</th>
									<th>Cliente / Comprador</th>
									<th>Telefone / Celular</th>
									<th>Lote, Quadra e Bairro</th>
									<th>Data</th>
									<th>Valor</th>
									<th class="canto-dir">Lucro</th>
								</tr>					
<?php
					$sqlContratoImovel = "SELECT * FROM contratos C inner join imoveis I on C.codImovel = I.codImovel inner join funcionarios F on I.codFuncionario = F.codFuncionario WHERE C.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."'".$filtraFuncionario." GROUP BY C.codContrato ORDER BY C.dataContrato ASC";
					$resultContratoImovel = $conn->query($sqlContratoImovel);
					while($dadosContratoImovel = $resultContratoImovel->fetch_assoc()){
						
						$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$dadosContratoImovel['codCliente']." LIMIT 0,1";
						$resultCliente = $conn->query($sqlCliente);
						$dadosCliente = $resultCliente->fetch_assoc();
?>
								<tr class="tr">
									<td class="vinte" style="width:15%; text-align:center; font-size:15px;"><?php echo $dadosContratoImovel['nomeFuncionario'];?></a></td>
									<td class="vinte" style="width:15%; text-align:center; font-size:15px;"><?php echo $dadosCliente['nomeCliente'];?></a></td>
									<td class="vinte" style="width:10%; text-align:center; font-size:15px;"><?php echo $dadosCliente['telefoneCliente'] != "" ? $dadosCliente['telefoneCliente'] : $dadosCliente['celularCliente'];?> <?php echo $dadosCliente['telefoneCliente'] != "" && $dadosCliente['celularCliente'] != "" ? "<br/> ".$dadosCliente['celularCliente'] : '';?></a></td>
									<td class="vinte" style="width:15%; text-align:center; font-size:15px;"><?php echo $dadosContratoImovel['loteFiltroContrato'];?>, <?php echo $dadosContratoImovel['quadraFiltroContrato'];?>, <?php echo $dadosContratoImovel['bairroFiltroContrato'];?></a></td>
									<td class="dez" style="text-align:center; font-size:15px;"><?php echo data($dadosContratoImovel['dataContrato']);?></a></td>
									<td class="vinte" style="width:10%; text-align:center; font-size:15px;">R$ <?php echo number_format($dadosContratoImovel['valorContrato'], 2, ",", ".");?></a></td>
									<td class="vinte" style="width:10%; text-align:center; font-size:15px;">R$ <?php echo number_format($dadosContratoImovel['valorComissaoContrato'], 2, ",", ".");?></a></td>
								</tr>
<?php
					}
?>								
							</table>																					
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
