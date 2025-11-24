<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "imoveisR";
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
						<p style="margin-top:15px;" class="nome-lista">Imóveis</p>
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
								<form name="filtro" action="<?php echo $configUrl;?>relatorios/imoveis/" method="post" >
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
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; padding-top:5px; font-family:Arial; margin:0; font-size:24px; font-weight:bold;"><?php echo $nomeEmpresaMenor;?> - Relatório Imóveis</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:30px;">
									<div id="mostra-dados" style="width:100%;">
<?php
					if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>					
										<p style="padding:0px; margin:0px; font-size:20px; font-weight:bold; font-family:Arial; color:#000; text-align:center;">Resumo Imóveis</p>
										<br/>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:19%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Imóvel</p>
											<p style="width:10%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Quantidade</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Total</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Média</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Lucro</p>
											<br style="clear:both;"/>
										</div>
<?php
						$sqlResumo = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissao) AS totalComissao, COUNT(I.codImovel) AS totalQuantidade FROM contratos C inner join contratosImoveis CI inner join imoveis I on CI.codImovel = I.codImovel WHERE CI.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' GROUP BY C.codContrato";
						$resultResumo = $conn->query($sqlResumo);
						$dadosResumo = $resultResumo->fetch_assoc();
						
						if($dadosResumo['totalQuantidade'] >= 1){
							
							$mediaResumo = $dadosResumo['totalValor'] / $dadosResumo['totalQuantidade'];
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:21%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">Imóveis</p>
											<p style="width:12%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosResumo['totalQuantidade'];?></p>
											<p style="width:22.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosResumo['totalValor'], 2, ",", ".");?></p>
											<p style="width:22%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($mediaResumo, 2, ",", ".");?></p>
											<p style="width:22.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosResumo['totalComissao'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
										<br/>
										<br/>
<?php
						}
?>
										<p style="padding:0px; margin:0px; font-size:20px; font-weight:bold; font-family:Arial; color:#000; text-align:center;">Tipo Imóvel</p>
										<br/>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:19%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Tipo Imóvel</p>
											<p style="width:10%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Quantidade</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Total</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Média</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Lucro</p>
											<br style="clear:both;"/>
										</div>
<?php
						$sqlTipoImovel = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissao) AS totalComissao, COUNT(I.codImovel) AS totalQuantidade FROM tipoImovel T inner join imoveis I on T.codTipoImovel = I.codTipoImovel inner join contratosImoveis CI on I.codImovel = CI.codImovel inner join contratos C on CI.codContrato = C.codContrato inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' GROUP BY T.codTipoImovel ORDER BY totalValor DESC, T.nomeTipoImovel ASC";
						$resultTipoImovel = $conn->query($sqlTipoImovel);
						while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){

							if($dadosTipoImovel['totalQuantidade'] >= 1){
							
								$mediaTipoImovel = $dadosTipoImovel['totalValor'] / $dadosTipoImovel['totalQuantidade'];
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:21%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosTipoImovel['nomeTipoImovel'];?></p>
											<p style="width:12%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosTipoImovel['totalQuantidade'];?></p>
											<p style="width:22.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosTipoImovel['totalValor'], 2, ",", ".");?></p>
											<p style="width:22%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($mediaTipoImovel, 2, ",", ".");?></p>
											<p style="width:22.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosTipoImovel['totalComissao'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
							}
						}
?>					
										<br/>
										<br/>
										<p style="padding:0px; margin:0px; font-size:20px; font-weight:bold; font-family:Arial; color:#000; text-align:center;">Bairro</p>
										<br/>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:19%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Bairro</p>
											<p style="width:10%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Quantidade</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Total</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Média</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Lucro</p>
											<br style="clear:both;"/>
										</div>
<?php
						$sqlBairro = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissao) AS totalComissao, COUNT(I.codImovel) AS totalQuantidade FROM bairros B inner join imoveis I on B.codBairro = I.codBairro inner join contratosImoveis CI on I.codImovel = CI.codImovel inner join contratos C on CI.codContrato = C.codContrato inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' GROUP BY B.codBairro ORDER BY totalValor DESC, B.nomeBairro ASC";
						$resultBairro = $conn->query($sqlBairro);
						while($dadosBairro = $resultBairro->fetch_assoc()){

							if($dadosBairro['totalQuantidade'] >= 1){
							
								$mediaBairro = $dadosBairro['totalValor'] / $dadosBairro['totalQuantidade'];
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:21%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosBairro['nomeBairro'];?></p>
											<p style="width:12%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosBairro['totalQuantidade'];?></p>
											<p style="width:22.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosBairro['totalValor'], 2, ",", ".");?></p>
											<p style="width:22%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($mediaBairro, 2, ",", ".");?></p>
											<p style="width:22.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosBairro['totalComissao'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
							}
						}
?>
										<br/>
										<br/>
										<p style="font-size:20px; font-weight:bold; color:#000; margin-bottom:15px; font-family:Arial; text-align:center;">Médio de Preços</p>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:73%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Média</p>
											<p style="width:22%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Quantidade</p>
											<br style="clear:both;"/>
										</div>										
<?php					
						$calculaMedia1 = "0.00";			
						$calculaMedia2 = "15000.00";

						$contMedidaI1 = 0;
						
						$sqlMediaI1 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
						$resultMediaI1 = $conn->query($sqlMediaI1);
						while($dadosMediaI1 = $resultMediaI1->fetch_assoc()){
							$contMedidaI1 = $contMedidaI1 + $dadosMediaI1['quantidadeImovel'];
						}
						
						if($contMedidaI1 == ""){
							$totalImoveis1 = 0;
						}else{
							$totalImoveis1 = $contMedidaI1;
						}		
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:75%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ 0 a 15.000,00</p>
											<p style="width:24.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $totalImoveis1;?></p>
											<br style="clear:both;"/>
										</div>
<?php					
						$calculaMedia1 = "15001.00";			
						$calculaMedia2 = "50000.00";

						$contMedidaI2 = 0;
						
						$sqlMediaI2 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
						$resultMediaI2 = $conn->query($sqlMediaI2);
						while($dadosMediaI2 = $resultMediaI2->fetch_assoc()){
							$contMedidaI2 = $contMedidaI2 + $dadosMediaI2['quantidadeImovel'];
						}
						if($contMedidaI2 == ""){
							$totalImoveis2 = 0;
						}else{
							$totalImoveis2 = $contMedidaI2;
						}	
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:75%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ 15.001,00 a 50.000,00</p>
											<p style="width:24.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $totalImoveis2;?></p>
											<br style="clear:both;"/>
										</div>
<?php					
						$calculaMedia1 = "50001.00";			
						$calculaMedia2 = "100000.00";
						
						$contMedidaI3 = 0;
						
						$sqlMediaI3 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
						$resultMediaI3 = $conn->query($sqlMediaI3);
						while($dadosMediaI3 = $resultMediaI3->fetch_assoc()){
							$contMedidaI3 = $contMedidaI3 + $dadosMediaI3['quantidadeImovel'];
						}
						
						if($contMedidaI3 == ""){
							$totalImoveis3 = 0;
						}else{
							$totalImoveis3 = $contMedidaI3;
						}			
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:75%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ 50.001,00 a 100.000,00</p>
											<p style="width:24.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $totalImoveis3;?></p>
											<br style="clear:both;"/>
										</div>
<?php					
						$calculaMedia1 = "100001.00";			
						$calculaMedia2 = "200000.00";
						
						$contMedidaI4 = 0;
						
						$sqlMediaI4 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
						$resultMediaI4 = $conn->query($sqlMediaI4);
						while($dadosMediaI4 = $resultMediaI4->fetch_assoc()){
							$contMedidaI4 = $contMedidaI4 + $dadosMediaI4['quantidadeImovel'];
						}
						
						if($contMedidaI4 == ""){
							$totalImoveis4 = 0;
						}else{
							$totalImoveis4 = $contMedidaI4;
						}	
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:75%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ 100.001,00 a 200.000,00</p>
											<p style="width:24.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $totalImoveis4;?></p>
											<br style="clear:both;"/>
										</div>
<?php					
						$calculaMedia1 = "200001.00";			
						$calculaMedia2 = "400000.00";

						$contMedidaI5 = 0;
						
						$sqlMediaI5 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
						$resultMediaI5 = $conn->query($sqlMediaI5);
						while($dadosMediaI5 = $resultMediaI5->fetch_assoc()){
							$contMedidaI5 = $contMedidaI5 + $dadosMediaI5['quantidadeImovel'];
						}
						
						if($contMedidaI5 == ""){
							$totalImoveis5 = 0;
						}else{
							$totalImoveis5 = $contMedidaI5;
						}		
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:75%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ 200.001,00 a 400.000,00</p>
											<p style="width:24.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $totalImoveis5;?></p>
											<br style="clear:both;"/>
										</div>
<?php					
						$calculaMedia1 = "400001.00";			
						$calculaMedia2 = "800000.00";
						
						$contMedidaI6 = 0;
						
						$sqlMediaI6 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
						$resultMediaI6 = $conn->query($sqlMediaI6);
						while($dadosMediaI6 = $resultMediaI6->fetch_assoc()){
							$contMedidaI6 = $contMedidaI6 + $dadosMediaI6['quantidadeImovel'];
						}
						
						if($contMedidaI6 == ""){
							$totalImoveis6 = 0;
						}else{
							$totalImoveis6 = $contMedidaI6;
						}		
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:75%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ 400.001,00 a 800.000,00</p>
											<p style="width:24.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $totalImoveis6;?></p>
											<br style="clear:both;"/>
										</div>
<?php					
						$calculaMedia1 = "800001.00";			
						
						$contMedidaI7 = 0;
						
						$sqlMediaI7 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
						$resultMediaI7 = $conn->query($sqlMediaI7);
						while($dadosMediaI7 = $resultMediaI7->fetch_assoc()){
							$contMedidaI7 = $contMedidaI7 + $dadosMediaI7['quantidadeImovel'];
						}
						
						if($contMedidaI7 == ""){
							$totalImoveis7 = 0;
						}else{
							$totalImoveis7 = $contMedidaI7;
						}	
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:75%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">Acima de R$ 800.000,00</p>
											<p style="width:24.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $totalImoveis7;?></p>
											<br style="clear:both;"/>
										</div>
										<br/>
										<br/>
										<p style="padding:0px; margin:0px; font-size:20px; font-weight:bold; font-family:Arial; color:#000; text-align:center;">Dados da Venda em Tabela</p>
										<br/>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:31%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Lote, Quadra e Bairro</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Data</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Valor</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:15px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Lucro</p>
											<br style="clear:both;"/>
										</div>
<?php
						$sqlContratoImovel = "SELECT C.valorComissao, C.valorContrato, C.dataContrato, I.codBairro, I.loteImovel, I.quadraImovel FROM contratosImoveis CI inner join contratos C on CI.codContrato = C.codContrato inner join imoveis I on CI.codImovel = I.codImovel WHERE CI.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' GROUP BY CI.codContratoImovel ORDER BY C.dataContrato ASC";
						$resultContratoImovel = $conn->query($sqlContratoImovel);
						while($dadosContratoImovel = $resultContratoImovel->fetch_assoc()){
							
							$sqlBairro = "SELECT * FROM bairros WHERE codBairro = '".$dadosContratoImovel['codBairro']."' ORDER BY codBairro DESC LIMIT 0,1";
							$resultBairro = $conn->query($sqlBairro);
							$dadosBairro = $resultBairro->fetch_assoc();
							
							$sqlQuadra = "SELECT * FROM quadras WHERE nomeQuadra = '".$dadosContratoImovel['loteImovel']."' ORDER BY codQuadra DESC LIMIT 0,1";
							$resultQuadra = $conn->query($sqlQuadra);
							$dadosQuadra = $resultQuadra->fetch_assoc();
							
							$sqlLote = "SELECT * FROM lotes WHERE nomeLote = '".$dadosContratoImovel['quadraImovel']."' ORDER BY codLote DESC LIMIT 0,1";
							$resultLote = $conn->query($sqlLote);
							$dadosLote = $resultLote->fetch_assoc();
?>
										<div id="clientes" style="width:100%; margin-bottom:10px;">
											<p style="width:33%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo $dadosBairro['nomeBairro'];?>, <?php echo $dadosQuadra['nomeQuadra'];?>, <?php echo $dadosLote['nomeLote'];?></p>
											<p style="width:22.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;"><?php echo data($dadosContratoImovel['dataContrato']);?></p>
											<p style="width:22%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosContratoImovel['valorContrato'], 2, ",", ".");?></p>
											<p style="width:22.5%; float:left; margin:0; font-size:14px; font-family:Arial; text-align:center;">R$ <?php echo number_format($dadosContratoImovel['valorComissao'], 2, ",", ".");?></p>
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
<?php
				}
?>				
				<div id="dados-conteudo">
<?php
				if($_SESSION['data1'] != "" && $_SESSION['data1'] != ""){
?>
					<div id="contratos-receber">
						<div id="total" style="margin-top:20px;">	
							<div id="total" style="margin-bottom:40px;">	
								<p style="font-size:20px; font-weight:bold; margin-top:20px; color:#718B8F; margin-bottom:20px; text-align:center;">Resumo Imóveis</p>														
								<table class="tabela-menus" >
									<tr class="titulo-tabela" border="none">
										<th class="canto-esq">Imóvel</th>
										<th>Quantidade</th>
										<th>Total</th>
										<th>Média</th>
										<th class="canto-dir">Lucro</th>
									</tr>
<?php
					$sqlResumo = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissao) AS totalComissao, COUNT(I.codImovel) AS totalQuantidade FROM contratos C inner join contratosImoveis CI inner join imoveis I on CI.codImovel = I.codImovel WHERE CI.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' GROUP BY C.codContrato";
					$resultResumo = $conn->query($sqlResumo);
					$dadosResumo = $resultResumo->fetch_assoc();

						if($dadosResumo['totalQuantidade'] >= 1){
						
							$mediaResumo = $dadosResumo['totalValor'] / $dadosResumo['totalQuantidade'];
?>											
									<tr class="tr">
										<td class="trinta
										" style="text-align:center; font-size:15px;">Imóveis</a></td>
										<td class="dez" style="text-align:center; font-size:15px;"><?php echo $dadosResumo['totalQuantidade'];?></a></td>
										<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($dadosResumo['totalValor'], 2, ",", ".");?></a></td>
										<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($mediaResumo, 2, ",", ".");?></a></td>
										<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($dadosResumo['totalComissao'], 2, ",", ".");?></a></td>
									</tr>								
<?php
						}
?>
								</table>																				
							</div>
							<p style="font-size:20px; font-weight:bold; margin-top:20px; color:#718B8F; margin-bottom:20px; text-align:center;">Tipo Imóvel</p>						
							<div id="total" style="margin-bottom:40px;">	
								<table class="tabela-menus" >
									<tr class="titulo-tabela" border="none">
										<th class="canto-esq">Tipo Imóvel</th>
										<th>Quantidade</th>
										<th>Total</th>
										<th>Média</th>
										<th class="canto-dir">Lucro</th>
									</tr>
<?php
					$sqlTipoImovel = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissao) AS totalComissao, COUNT(I.codImovel) AS totalQuantidade FROM tipoImovel T inner join imoveis I on T.codTipoImovel = I.codTipoImovel inner join contratosImoveis CI on I.codImovel = CI.codImovel inner join contratos C on CI.codContrato = C.codContrato inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' GROUP BY T.codTipoImovel ORDER BY totalValor DESC, T.nomeTipoImovel ASC";
					$resultTipoImovel = $conn->query($sqlTipoImovel);
					while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){
						
						$mediaTotalTipoImovel = $dadosTipoImovel['totalValor'] / $dadosTipoImovel['totalQuantidade'];
						$quantidadeTipoImovel = $quantidadeTipoImovel + $dadosTipoImovel['totalQuantidade'];
?>											
									<tr class="tr">
										<td class="trinta" style="text-align:center; font-size:15px;"><?php echo $dadosTipoImovel['nomeTipoImovel'];?></a></td>
										<td class="dez" style="text-align:center; font-size:15px;"><?php echo $dadosTipoImovel['totalQuantidade'];?></a></td>
										<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($dadosTipoImovel['totalValor'], 2, ",", ".");?></a></td>
										<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($mediaTotalTipoImovel, 2, ",", ".");?></a></td>
										<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($dadosTipoImovel['totalComissao'], 2, ",", ".");?></a></td>
									</tr>
<?php
					}
?>									
								</table>																				
							</div>
							<p style="font-size:20px; font-weight:bold; margin-top:20px; color:#718B8F; margin-bottom:20px; text-align:center;">Bairro</p>						
							<div id="total" style="margin-bottom:40px;">	
								<table class="tabela-menus" >
									<tr class="titulo-tabela" border="none">
										<th class="canto-esq">Bairro</th>
										<th>Quantidade</th>
										<th>Total</th>
										<th>Média</th>
										<th class="canto-dir">Lucro</th>
									</tr>
<?php
					$sqlBairro = "SELECT *, SUM(C.valorContrato) AS totalValor, SUM(C.valorComissao) AS totalComissao, COUNT(I.codImovel) AS totalQuantidade FROM bairros B inner join imoveis I on B.codBairro = I.codBairro inner join contratosImoveis CI on I.codImovel = CI.codImovel inner join contratos C on CI.codContrato = C.codContrato inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' GROUP BY B.codBairro ORDER BY totalValor DESC, B.nomeBairro ASC";
					$resultBairro = $conn->query($sqlBairro);
					while($dadosBairro = $resultBairro->fetch_assoc()){
						
						$mediaTotalBairro = $dadosBairro['totalValor'] / $dadosBairro['totalQuantidade'];
						$quantidadeBairro = $quantidadeBairro + $dadosBairro['totalQuantidade'];
?>											
									<tr class="tr">
										<td class="trinta" style="text-align:center; font-size:15px;"><?php echo $dadosBairro['nomeBairro'];?></a></td>
										<td class="dez" style="text-align:center; font-size:15px;"><?php echo $dadosBairro['totalQuantidade'];?></a></td>
										<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($dadosBairro['totalValor'], 2, ",", ".");?></a></td>
										<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($mediaTotalBairro, 2, ",", ".");?></a></td>
										<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($dadosBairro['totalComissao'], 2, ",", ".");?></a></td>
									</tr>
<?php
					}
?>									
								</table>																			
							</div>
							<p style="font-size:20px; font-weight:bold; color:#718B8F; margin-bottom:15px; text-align:center;">Médio de Preços</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Média</th>
									<th class="canto-dir">Quantidade</th>
								</tr>					
<?php					
					$calculaMedia1 = "0.00";			
					$calculaMedia2 = "15000.00";

					$contMedidaI1 = 0;
					
					$sqlMediaI1 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
					$resultMediaI1 = $conn->query($sqlMediaI1);
					while($dadosMediaI1 = $resultMediaI1->fetch_assoc()){
						$contMedidaI1 = $contMedidaI1 + $dadosMediaI1['quantidadeImovel'];
					}
					
					if($contMedidaI1 == ""){
						$totalImoveis1 = 0;
					}else{
						$totalImoveis1 = $contMedidaI1;
					}														
?>
								<tr class="tr">
									<td class="cinquenta" style="text-align:center; font-size:15px;">R$ 0 a 15.000,00</a></td>
									<td class="dez" style="text-align:center; font-size:15px;"><?php echo $totalImoveis1;?></a></td>
								</tr>
<?php					
					$calculaMedia1 = "15001.00";			
					$calculaMedia2 = "50000.00";

					$contMedidaI2 = 0;
					
					$sqlMediaI2 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
					$resultMediaI2 = $conn->query($sqlMediaI2);
					while($dadosMediaI2 = $resultMediaI2->fetch_assoc()){
						$contMedidaI2 = $contMedidaI2 + $dadosMediaI2['quantidadeImovel'];
					}
					if($contMedidaI2 == ""){
						$totalImoveis2 = 0;
					}else{
						$totalImoveis2 = $contMedidaI2;
					}														
?>
								<tr class="tr">
									<td class="cinquenta" style="text-align:center; font-size:15px;">R$ 15.001,00 a 50.000,00</a></td>
									<td class="dez" style="text-align:center; font-size:15px;"><?php echo $totalImoveis2;?></a></td>
								</tr>
<?php					
					$calculaMedia1 = "50001.00";			
					$calculaMedia2 = "100000.00";
					
					$contMedidaI3 = 0;
					
					$sqlMediaI3 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
					$resultMediaI3 = $conn->query($sqlMediaI3);
					while($dadosMediaI3 = $resultMediaI3->fetch_assoc()){
						$contMedidaI3 = $contMedidaI3 + $dadosMediaI3['quantidadeImovel'];
					}
					
					if($contMedidaI3 == ""){
						$totalImoveis3 = 0;
					}else{
						$totalImoveis3 = $contMedidaI3;
					}														
?>
								<tr class="tr">
									<td class="cinquenta" style="text-align:center; font-size:15px;">R$ 50.001,00 a 100.000,00</a></td>
									<td class="dez" style="text-align:center; font-size:15px;"><?php echo $totalImoveis3;?></a></td>
								</tr>
<?php					
					$calculaMedia1 = "100001.00";			
					$calculaMedia2 = "200000.00";
					
					$contMedidaI4 = 0;
					
					$sqlMediaI4 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
					$resultMediaI4 = $conn->query($sqlMediaI4);
					while($dadosMediaI4 = $resultMediaI4->fetch_assoc()){
						$contMedidaI4 = $contMedidaI4 + $dadosMediaI4['quantidadeImovel'];
					}
					
					if($contMedidaI4 == ""){
						$totalImoveis4 = 0;
					}else{
						$totalImoveis4 = $contMedidaI4;
					}														
?>
								<tr class="tr">
									<td class="cinquenta" style="text-align:center; font-size:15px;">R$ 100.001,00 a 200.000,00</a></td>
									<td class="dez" style="text-align:center; font-size:15px;"><?php echo $totalImoveis4;?></a></td>
								</tr>
<?php					
					$calculaMedia1 = "200001.00";			
					$calculaMedia2 = "400000.00";

					$contMedidaI5 = 0;
					
					$sqlMediaI5 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
					$resultMediaI5 = $conn->query($sqlMediaI5);
					while($dadosMediaI5 = $resultMediaI5->fetch_assoc()){
						$contMedidaI5 = $contMedidaI5 + $dadosMediaI5['quantidadeImovel'];
					}
					
					if($contMedidaI5 == ""){
						$totalImoveis5 = 0;
					}else{
						$totalImoveis5 = $contMedidaI5;
					}														
?>
								<tr class="tr">
									<td class="cinquenta" style="text-align:center; font-size:15px;">R$ 200.001,00 a 400.000,00</a></td>
									<td class="dez" style="text-align:center; font-size:15px;"><?php echo $totalImoveis5;?></a></td>
								</tr>
<?php					
					$calculaMedia1 = "400001.00";			
					$calculaMedia2 = "800000.00";
					
					$contMedidaI6 = 0;
					
					$sqlMediaI6 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
					$resultMediaI6 = $conn->query($sqlMediaI6);
					while($dadosMediaI6 = $resultMediaI6->fetch_assoc()){
						$contMedidaI6 = $contMedidaI6 + $dadosMediaI6['quantidadeImovel'];
					}
					
					if($contMedidaI6 == ""){
						$totalImoveis6 = 0;
					}else{
						$totalImoveis6 = $contMedidaI6;
					}														
?>
								<tr class="tr">
									<td class="cinquenta" style="text-align:center; font-size:15px;">R$ 400.001,00 a 800.000,00</a></td>
									<td class="dez" style="text-align:center; font-size:15px;"><?php echo $totalImoveis6;?></a></td>
								</tr>
<?php					
					$calculaMedia1 = "800001.00";			
					
					$contMedidaI7 = 0;
					
					$sqlMediaI7 = "SELECT SUM(C.valorContrato) AS total, COUNT(CI.codImovel) quantidadeImovel FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join clientes CL on C.codCliente = CL.codCliente WHERE I.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' and C.valorContrato >= '".$calculaMedia1."' and C.valorContrato <= '".$calculaMedia2."'";
					$resultMediaI7 = $conn->query($sqlMediaI7);
					while($dadosMediaI7 = $resultMediaI7->fetch_assoc()){
						$contMedidaI7 = $contMedidaI7 + $dadosMediaI7['quantidadeImovel'];
					}
					
					if($contMedidaI7 == ""){
						$totalImoveis7 = 0;
					}else{
						$totalImoveis7 = $contMedidaI7;
					}														
?>
								<tr class="tr">
									<td class="cinquenta" style="text-align:center; font-size:15px;">Acima de R$ 800.000,00</a></td>
									<td class="dez" style="text-align:center; font-size:15px;"><?php echo $totalImoveis7;?></a></td>
								</tr>
							</table>
							<br/>							
							<br/>							
							<p style="font-size:20px; font-weight:bold; color:#718B8F; margin-bottom:15px; text-align:center;">Dados da Venda em Tabela</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Lote, Quadra e Bairro</th>
									<th>Data</th>
									<th>Valor</th>
									<th class="canto-dir">Lucro</th>
								</tr>					
<?php
					$sqlContratoImovel = "SELECT C.valorComissao, C.valorContrato, C.dataContrato, I.codBairro, I.loteImovel, I.quadraImovel FROM contratosImoveis CI inner join contratos C on CI.codContrato = C.codContrato inner join imoveis I on CI.codImovel = I.codImovel WHERE CI.codImovel != 0 and C.dataContrato >= '".$_SESSION['data1']."' and C.dataContrato <= '".$_SESSION['data2']."' GROUP BY CI.codContratoImovel ORDER BY C.dataContrato ASC";
					$resultContratoImovel = $conn->query($sqlContratoImovel);
					while($dadosContratoImovel = $resultContratoImovel->fetch_assoc()){
						
						$sqlBairro = "SELECT * FROM bairros WHERE codBairro = '".$dadosContratoImovel['codBairro']."' ORDER BY codBairro DESC LIMIT 0,1";
						$resultBairro = $conn->query($sqlBairro);
						$dadosBairro = $resultBairro->fetch_assoc();
						
						$sqlQuadra = "SELECT * FROM quadras WHERE nomeQuadra = '".$dadosContratoImovel['loteImovel']."' ORDER BY codQuadra DESC LIMIT 0,1";
						$resultQuadra = $conn->query($sqlQuadra);
						$dadosQuadra = $resultQuadra->fetch_assoc();
						
						$sqlLote = "SELECT * FROM lotes WHERE nomeLote = '".$dadosContratoImovel['quadraImovel']."' ORDER BY codLote DESC LIMIT 0,1";
						$resultLote = $conn->query($sqlLote);
						$dadosLote = $resultLote->fetch_assoc();
?>
								<tr class="tr">
									<td class="trinta" style="text-align:center; font-size:15px;"><?php echo $dadosBairro['nomeBairro'];?>, <?php echo $dadosQuadra['nomeQuadra'];?>, <?php echo $dadosLote['nomeLote'];?></a></td>
									<td class="vinte" style="text-align:center; font-size:15px;"><?php echo data($dadosContratoImovel['dataContrato']);?></a></td>
									<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($dadosContratoImovel['valorContrato'], 2, ",", ".");?></a></td>
									<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($dadosContratoImovel['valorComissao'], 2, ",", ".");?></a></td>
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
