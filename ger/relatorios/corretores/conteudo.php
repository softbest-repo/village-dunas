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
					$_SESSION['data1'] = "";
					$_SESSION['data2'] = "";
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
						<p style="margin-top:15px;" class="nome-lista">Corretores</p>
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
								<form name="filtro" action="<?php echo $configUrl;?>relatorios/corretores/" method="post" >
									<p class="bloco-campo-float"><label>De: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data1" required name="data1" size="10" value="<?php echo $_SESSION['data1']; ?>"/></p>

									<p class="bloco-campo-float"><label>Até: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="date" id="data2" required name="data2" size="10" value="<?php echo $_SESSION['data2']; ?>"/></p>

									<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> </span></label>
										<select class="selectCorretor form-control campo" id="idSelectUsuario" name="corretor" style="width:250px; display: none;">
											<option value="TO">Todos</option>	
<?php
				$sqlUsuario = "SELECT * FROM usuarios WHERE tipoUsuario = 'C' or codUsuario = '4' ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
											<option value="<?php echo $dadosUsuario['codUsuario'];?>" <?php echo $dadosUsuario['codUsuario'] == $_SESSION['corretor'] ? 'selected' : ''; ?>><?php echo $dadosUsuario['nomeUsuario'];?></option>										
<?php
				}
?>
										</select>										
									</p>

									<script>
										var $rfg = jQuery.noConflict();

										$rfg(".selectCorretor").select2({
											placeholder: "Selecione",
											multiple: false
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
							<p class="titulo-receber" style="color:#666; font-size:26px; text-align:center; font-weight:bold; margin-bottom:30px;">Leads</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Tipo</th>
									<th class="canto-dir">Valor</th>
								</tr>					
<?php
	if($_SESSION['corretor'] != ""){
		$filtraUsuario = " = ".$_SESSION['corretor'];
	}else{
		$filtraUsuario = " != ''";
	}
	$totaLeads = 0;

	$totaLeadsRecebidos = 0;
	$sqlLeadsRecebidos = "SELECT * FROM leads L inner join usuariosLeads UL on L.codLead = UL.codLead WHERE L.codUsuario".$filtraUsuario." and DATE(UL.dataUsuarioLead) >= '".$_SESSION['data1']."' and DATE(UL.dataUsuarioLead) <= '".$_SESSION['data2']."' GROUP BY UL.codLead";
	$resultLeadsRecebidos = $conn->query($sqlLeadsRecebidos);
	while($dadosLeadsRecebidos = $resultLeadsRecebidos->fetch_assoc()){
		$totaLeadsRecebidos++;
	}

	$totaLeadsAtendidos = 0;
	$sqlLeadsAtendidos = "SELECT * FROM leads L inner join usuariosLeads UL on L.codLead = UL.codLead WHERE L.codUsuario".$filtraUsuario." and UL.statusUsuarioLead = 'T' and UL.interacaoUsuarioLead IS NOT NULL and DATE(UL.dataUsuarioLead) >= '".$_SESSION['data1']."' and DATE(UL.dataUsuarioLead) <= '".$_SESSION['data2']."' GROUP BY UL.codLead";
	$resultLeadsAtendidos = $conn->query($sqlLeadsAtendidos);
	while($dadosLeadsAtendidos = $resultLeadsAtendidos->fetch_assoc()){
		$totaLeadsAtendidos++;
	}

	$sqlTempoMedioResposta = "SELECT UL.dataUsuarioLead, UL.interacaoUsuarioLead FROM leads L INNER JOIN usuariosLeads UL ON L.codLead = UL.codLead WHERE L.codUsuario".$filtraUsuario." AND UL.statusUsuarioLead = 'T' AND UL.interacaoUsuarioLead IS NOT NULL AND DATE(UL.dataUsuarioLead) >= '".$_SESSION['data1']."' AND DATE(UL.dataUsuarioLead) <= '".$_SESSION['data2']."' GROUP BY UL.codLead";
	$resultTempoMedioResposta = $conn->query($sqlTempoMedioResposta);

	$totalSegundosResposta = 0;
	$totalRespostas = 0;

	if ($resultTempoMedioResposta && $resultTempoMedioResposta->num_rows > 0) {
		while($row = $resultTempoMedioResposta->fetch_assoc()) {
			$dataLead = $row['dataUsuarioLead'];
			$dataInteracao = $row['interacaoUsuarioLead'];
			if ($dataLead && $dataInteracao) {
				$segundos = strtotime($dataInteracao) - strtotime($dataLead);
				if ($segundos >= 0) {
					$totalSegundosResposta += $segundos;
					$totalRespostas++;
				}
			}
		}
	}

	if ($totalRespostas > 0) {
		$tempoMedioSegundos = intval($totalSegundosResposta / $totalRespostas);

		$horas = floor($tempoMedioSegundos / 3600);
		$minutos = floor(($tempoMedioSegundos % 3600) / 60);
		$segundos = $tempoMedioSegundos % 60;

		$tempoFormatado = [];

		if ($horas > 0) {
			$tempoFormatado[] = "{$horas} " . ($horas == 1 ? "hora" : "horas");
		}
		if ($minutos > 0) {
			$tempoFormatado[] = "{$minutos} " . ($minutos == 1 ? "minuto" : "minutos");
		}
		if ($segundos > 0 || empty($tempoFormatado)) {
			$tempoFormatado[] = "{$segundos} " . ($segundos == 1 ? "segundo" : "segundos");
		}

		$tempoMedio = implode(", ", $tempoFormatado);
	} else {
		$tempoMedio = "Não há";
	}

	$totaLeadsRecusados = 0;
	$sqlLeadsRecusados = "SELECT * FROM leads L inner join usuariosLeads UL on L.codLead = UL.codLead WHERE L.codUsuario".$filtraUsuario." and UL.statusUsuarioLead = 'F' and UL.interacaoUsuarioLead IS NOT NULL and DATE(UL.dataUsuarioLead) >= '".$_SESSION['data1']."' and DATE(UL.dataUsuarioLead) <= '".$_SESSION['data2']."' GROUP BY UL.codLead";
	$resultLeadsRecusados = $conn->query($sqlLeadsRecusados);
	while($dadosLeadsRecusados = $resultLeadsRecusados->fetch_assoc()){
		$totaLeadsRecusados++;
	}

	$totalLeadsNao = 0;
	$sqlLeadsNao = "SELECT * FROM leads L inner join usuariosLeads UL on L.codLead = UL.codLead WHERE L.codUsuario".$filtraUsuario." and UL.statusUsuarioLead = 'F' and UL.interacaoUsuarioLead IS NULL and DATE(UL.dataUsuarioLead) >= '".$_SESSION['data1']."' and DATE(UL.dataUsuarioLead) <= '".$_SESSION['data2']."' GROUP BY UL.codLead";
	$resultLeadsNao = $conn->query($sqlLeadsNao);
	while($dadosLeadsNao = $resultLeadsNao->fetch_assoc()){
		$totalLeadsNao++;
	}

	$totalLeadsNao = $totalLeadsNao - $totaLeadsAtendidos;

	if($totalLeadsNao < 0){
		$totalLeadsNao = 0;
	}
?>
								<tr class="tr">
									<td class="setenta" style="color:#0000FF; font-size:18px; font-weight:bold;">Leads Recebidos</a></td>
									<td class="trinta" style="text-align:center; color:#0000FF; font-size:26px; font-weight:bold;"><?php echo $totaLeadsRecebidos;?></a></td>
								</tr>
								<tr class="tr">
									<td class="setenta" style="color:#007c01; font-size:16px;">Leads Atendidos</a></td>
									<td class="trinta" style="text-align:center; color:#007c01; font-size:24px; font-weight:bold;"><?php echo $totaLeadsAtendidos;?></a></td>
								</tr>
								<tr class="tr">
									<td class="setenta" style="color:#007c01; font-size:16px;">Tempo de resposta médio</a></td>
									<td class="trinta" style="text-align:center; color:#007c01; font-size:18px; font-weight:bold;"><?php echo $tempoMedio;?></a></td>
								</tr>								
								<tr class="tr">
									<td class="setenta" style="color:#FF0000; font-size:16px;">Leads Recusados</a></td>
									<td class="trinta" style="text-align:center; color:#FF0000; font-size:24px; font-weight:bold;"><?php echo $totaLeadsRecusados;?></a></td>
								</tr>							 							 
							</table>							
						</div>
						<br/>
						<br/>
						<br/>
						<div id="col-esq-receber" style="width:100%; <?php echo $_SESSION['corretor'] != "" ? 'display:none;' : '';?>">
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Corretor</th>
									<th>Leads Recebidos</th>
									<th>Leads Atendidos</th>
									<th class="canto-dir">Tempo Médio de Resposta</th>
								</tr>					
<?php
			// Consulta para pegar os leads recebidos e atendidos do dia conforme a data selecionada
			// Corrigido para não multiplicar os leads atendidos, contando apenas leads distintos com status 'T'
			$sqlUsuariosLeads = "
				SELECT 
					u.codUsuario, 
					u.nomeUsuario, 
					MAX(ul.dataUsuarioLogin) AS dataUsuarioLogin, 
					COUNT(DISTINCT ulds.codLead) AS totalLeadsRecebidos, 
					(
						SELECT COUNT(DISTINCT ulds2.codLead)
						FROM usuariosLeads ulds2
						WHERE ulds2.codUsuario = u.codUsuario
							AND ulds2.statusUsuarioLead = 'T'
							AND DATE(ulds2.dataUsuarioLead) BETWEEN '".$_SESSION['data1']."' AND '".$_SESSION['data2']."'
					) AS totalLeadsAtendidos,
					(
						SELECT COUNT(DISTINCT ulds3.codLead)
						FROM usuariosLeads ulds3
						WHERE ulds3.codUsuario = u.codUsuario
							AND ulds3.statusUsuarioLead = 'A'
							AND DATE(ulds3.dataUsuarioLead) BETWEEN '".$_SESSION['data1']."' AND '".$_SESSION['data2']."'
					) AS totalLeadsEmAtendimento,
					(SELECT MAX(ulds2.dataUsuarioLead) FROM usuariosLeads ulds2 WHERE ulds2.codUsuario = u.codUsuario AND DATE(ulds2.dataUsuarioLead) BETWEEN '".$_SESSION['data1']."' AND '".$_SESSION['data2']."') AS ultimaInteracao,
					(
						SELECT 
							SEC_TO_TIME(AVG(TIMESTAMPDIFF(SECOND, ulds4.dataUsuarioLead, ulds4.interacaoUsuarioLead)))
						FROM usuariosLeads ulds4
						WHERE 
							ulds4.codUsuario = u.codUsuario
							AND ulds4.statusUsuarioLead = 'T'
							AND ulds4.interacaoUsuarioLead IS NOT NULL
							AND DATE(ulds4.dataUsuarioLead) BETWEEN '".$_SESSION['data1']."' AND '".$_SESSION['data2']."'
					) AS tempoMedioResposta
				FROM 
					usuarios u 
				INNER JOIN 
					usuariosLogins ul ON u.codUsuario = ul.codUsuario 
				LEFT JOIN 
					usuariosLeads ulds ON u.codUsuario = ulds.codUsuario 
						AND DATE(ulds.dataUsuarioLead) BETWEEN '".$_SESSION['data1']."' AND '".$_SESSION['data2']."'
				WHERE 
					DATE(ul.dataUsuarioLogin) BETWEEN '".$_SESSION['data1']."' AND '".$_SESSION['data2']."'
				GROUP BY 
					u.codUsuario, u.nomeUsuario
				ORDER BY 
					u.nomeUsuario ASC
			";
			$resultUsuariosLeads = $conn->query($sqlUsuariosLeads);
			while($dadosUsuariosLeads = $resultUsuariosLeads->fetch_assoc()){
				$cont++;
				$contTodos++;
				
				if($cont == 1){
					$background = "#FFF;";
				}else{
					$cont = 0;
					$background = "#f5f5f5;";
				}
				
				$quebraLogin = explode(" ", $dadosUsuariosLeads['dataUsuarioLogin']);
				$quebraLead = explode(" ", $dadosUsuariosLeads['ultimaInteracao']);
				
				if($dadosUsuariosLeads['ultimaInteracao'] <= date('Y-m-d 07:59:59')){
					$leadInteracao = "--";
				}else{
					$leadInteracao = $quebraLead[1];
				}	
?>
								<tr class="tr">
									<td class="quarenta" style="font-size:16px"><?php echo $dadosUsuariosLeads['nomeUsuario'];?></a></td>
									<td class="vinte" style="text-align:center;  color:#0000FF; font-size:20px; font-weight:bold;"><?php echo $dadosUsuariosLeads['totalLeadsRecebidos'];?></a></td>
									<td class="vinte" style="text-align:center; color:green; font-size:20px; font-weight:bold;"><?php echo $dadosUsuariosLeads['totalLeadsAtendidos'];?></a></td>
									<td class="vinte" style="text-align:center; color:green; font-size:15px; font-weight:bold;">
										<?php
											$tempo = $dadosUsuariosLeads['tempoMedioResposta'];
											if ($tempo && $tempo != '00:00:00' && $tempo != null) {
												// Remove milissegundos, se houver
												$tempo = explode('.', $tempo)[0];
												list($h, $m, $s) = explode(':', $tempo);
												$texto = '';
												if ((int)$h > 0) {
													$texto .= (int)$h . ' hora' . ((int)$h > 1 ? 's' : '') . ', ';
												}
												if ((int)$m > 0) {
													$texto .= (int)$m . ' minuto' . ((int)$m > 1 ? 's' : '') . ', ';
												}
												$texto .= (int)$s . ' segundo' . ((int)$s > 1 ? 's' : '');
												echo $texto;
											} else {
												echo '--';
											}
										?>
									</td>
								</tr>
<?php
			}
?>
							</table>							
							<br/>
							<br/>
							<br/>							
						</div>
						<div id="col-esq-receber" style="width:100%;">
							<p class="titulo-receber" style="color:#666; font-size:26px; text-align:center; font-weight:bold; margin-bottom:30px;">Negociações</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Tipo</th>
									<th class="canto-dir">Valor</th>
								</tr>					
<?php
	$sqlNegociacoes = "SELECT count(codNegociacao) total FROM negociacoes WHERE codUsuario".$filtraUsuario." and dataCadastroNegociacao >= '".$_SESSION['data1']."' and dataCadastroNegociacao <= '".$_SESSION['data2']."' ORDER BY codNegociacao DESC";
	$resultNegociacoes = $conn->query($sqlNegociacoes);
	$dadosNegociacoes = $resultNegociacoes->fetch_assoc();
	
	$sqlNegociacoesAndamento = "SELECT count(codNegociacao) total FROM negociacoes WHERE codUsuario".$filtraUsuario." and fechamentoNegociacao = 'EA' and dataCadastroNegociacao >= '".$_SESSION['data1']."' and dataCadastroNegociacao <= '".$_SESSION['data2']."' ORDER BY codNegociacao DESC";
	$resultNegociacoesAndamento = $conn->query($sqlNegociacoesAndamento);
	$dadosNegociacoesAndamento = $resultNegociacoesAndamento->fetch_assoc();
	
	$sqlNegociacoesFechado = "SELECT count(codNegociacao) total FROM negociacoes WHERE codUsuario".$filtraUsuario." and fechamentoNegociacao = 'F' and dataCadastroNegociacao >= '".$_SESSION['data1']."' and dataCadastroNegociacao <= '".$_SESSION['data2']."' ORDER BY codNegociacao DESC";
	$resultNegociacoesFechado = $conn->query($sqlNegociacoesFechado);
	$dadosNegociacoesFechado = $resultNegociacoesFechado->fetch_assoc();
	
	$sqlNegociacoesNFechado = "SELECT count(codNegociacao) total FROM negociacoes WHERE codUsuario".$filtraUsuario." and fechamentoNegociacao = 'NF' and dataCadastroNegociacao >= '".$_SESSION['data1']."' and dataCadastroNegociacao <= '".$_SESSION['data2']."' ORDER BY codNegociacao DESC";
	$resultNegociacoesNFechado = $conn->query($sqlNegociacoesNFechado);
	$dadosNegociacoesNFechado = $resultNegociacoesNFechado->fetch_assoc();
?>
								<tr class="tr">
									<td class="oitenta" style="color:#0000FF; font-size:18px; font-weight:bold;">Negociações Iniciadas</a></td>
									<td class="vinte" style="text-align:center; color:#0000FF; font-size:26px; font-weight:bold;"><?php echo $dadosNegociacoes['total'];?></a></td>
								</tr>
								<tr class="tr">
									<td class="oitenta" style="color:#007c01; font-size:16px;">Negociações em Andamento</a></td>
									<td class="vinte" style="text-align:center; color:#007c01; font-size:24px; font-weight:bold;"><?php echo $dadosNegociacoesAndamento['total'];?></a></td>
								</tr>							 
								<tr class="tr">
									<td class="oitenta" style="color:#007c01; font-size:16px;">Negociações Fechadas</a></td>
									<td class="vinte" style="text-align:center; color:#007c01; font-size:24px; font-weight:bold;"><?php echo $dadosNegociacoesFechado['total'];?></a></td>
								</tr>							 
								<tr class="tr">
									<td class="oitenta" style="color:#FF0000; font-size:16px;">Negociações Não Fechadas</a></td>
									<td class="vinte" style="text-align:center; color:#FF0000; font-size:24px; font-weight:bold;"><?php echo $dadosNegociacoesNFechado['total'];?></a></td>
								</tr>							 
							</table>							
						</div>
						<br/>
						<br/>
						<br/>						
						<div id="col-esq-receber" style="width:100%;">
							<p class="titulo-receber" style="color:#666; font-size:26px; text-align:center; font-weight:bold; margin-bottom:30px;">Vendas de Imóveis Próprios</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Título</th>
									<th>Quantidade</th>
									<th>Total em Vendas</th>
									<th class="canto-dir">Média por Venda</th>
								</tr>					
<?php
	$sqlContrato = "SELECT count(codContrato) total, SUM(valorContrato) totalValor FROM contratos WHERE codUsuario".$filtraUsuario." and dataContrato >= '".$_SESSION['data1']."' and dataContrato <= '".$_SESSION['data2']."' ORDER BY codContrato DESC";
	$resultContrato = $conn->query($sqlContrato);
	$dadosContrato = $resultContrato->fetch_assoc();
	
	if($dadosContrato['total'] >= 1){
		$mediaVendas = $dadosContrato['totalValor'] / $dadosContrato['total'];
	}
?>
								<tr class="tr">
									<td class="quarenta" style="color:#0000FF; font-size:18px; font-weight:bold;">Resumo Vendas</a></td>
									<td class="vinte" style="text-align:center; color:#0000FF; font-size:26px; font-weight:bold;"><?php echo $dadosContrato['total'];?></a></td>
									<td class="vinte" style="text-align:center; color:#0000FF; font-size:26px; font-weight:bold;">R$ <?php echo number_format($dadosContrato['totalValor'], 2, ",", ".");?></a></td>
									<td class="vinte" style="text-align:center; color:#0000FF; font-size:26px; font-weight:bold;">R$ <?php echo number_format($mediaVendas, 2, ",", ".");?></a></td>
								</tr>							 
							</table>							
						</div>
						<br/>
						<br/>
						<br/>						
						<div id="col-esq-receber" style="width:100%;">
							<p class="titulo-receber" style="color:#666; font-size:26px; text-align:center; font-weight:bold; margin-bottom:30px;">Vendas por Tipo Imóvel</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Tipo Imóvel</th>
									<th>Quantidade</th>
									<th>Total Vendas</th>
									<th class="canto-dir">Média</th>
								</tr>
<?php
					$totalVendas = 0;
					
					$sqlTipoImovel = "SELECT T.codTipoImovel, T.nomeTipoImovel, COUNT(DISTINCT CI.codImovel) AS totalImoveis FROM tipoImovel T INNER JOIN imoveis I ON T.codTipoImovel = I.codTipoImovel INNER JOIN contratosImoveis CI ON I.codImovel = CI.codImovel INNER JOIN contratos C ON CI.codContrato = C.codContrato INNER JOIN clientes CL ON C.codCliente = CL.codCliente WHERE C.codUsuario".$filtraUsuario." AND C.dataContrato >= '".$_SESSION['data1']."' AND C.dataContrato <= '".$_SESSION['data2']."' GROUP BY T.codTipoImovel, T.nomeTipoImovel ORDER BY T.nomeTipoImovel ASC;";
					$resultTipoImovel = $conn->query($sqlTipoImovel);
					while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){
						
						$sqlContrato = "SELECT C.valorContrato FROM contratos C inner join contratosImoveis CI on C.codContrato = CI.codContrato inner join imoveis I on CI.codImovel = I.codImovel inner join tipoImovel TI on I.codTipoImovel = TI.codTipoImovel WHERE C.codUsuario".$filtraUsuario." and TI.codTipoImovel = ".$dadosTipoImovel['codTipoImovel']." AND C.dataContrato >= '".$_SESSION['data1']."' AND C.dataContrato <= '".$_SESSION['data2']."' GROUP BY TI.codTipoImovel";
						$resultContrato = $conn->query($sqlContrato);
						while($dadosContrato = $resultContrato->fetch_assoc()){
							$totalContrato = $totalContrato + $dadosContrato['valorContrato'];
						}
						
						$mediaTotalTipoImovel = $totalContrato / $dadosTipoImovel['totalImoveis'];					
?>											
								<tr class="tr">
									<td class="trinta" style="text-align:center; font-size:15px;"><?php echo $dadosTipoImovel['nomeTipoImovel'];?></a></td>
									<td class="dez" style="text-align:center; font-size:15px;"><?php echo $dadosTipoImovel['totalImoveis'];?></a></td>
									<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($totalContrato, 2, ",", ".");?></a></td>
									<td class="vinte" style="text-align:center; font-size:15px;">R$ <?php echo number_format($mediaTotalTipoImovel, 2, ",", ".");?></a></td>
								</tr>
<?php
						$totalVendas = $totalVendas + $totalContrato;
					}
?>									
							</table>
<?php
					if($totalVendas == 0){
?>																											
							<p class="aviso" style="color:#444; text-align:center; padding-top:30px;">Não foi realizado nenhuma venda!</p>
<?php
					}
?>
						</div>
						<br/>
						<br/>
						<br/>							
						<div id="col-esq-receber" style="width:100%;">
							<p class="titulo-receber" style="color:#666; font-size:26px; text-align:center; font-weight:bold; margin-bottom:30px;">Check-in Diário</p>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Corretor(a)</th>
									<th>Data</th>
									<th class="canto-dir">Hora</th>
								</tr>
<?php
						// Filtrar por dataUsuarioLogin conforme o filtro de datas
						$sqlUsuario = "SELECT * FROM usuarios U 
							INNER JOIN usuariosLogins UL ON U.codUsuario = UL.codUsuario 
							WHERE U.codUsuario".$filtraUsuario." 
							AND UL.dataUsuarioLogin >= '".$_SESSION['data1']." 00:00:00' 
							AND UL.dataUsuarioLogin <= '".$_SESSION['data2']." 23:59:59' 
							GROUP BY UL.codUsuarioLogin 
							ORDER BY UL.dataUsuarioLogin ASC, U.nomeUsuario ASC";
						$resultUsuario = $conn->query($sqlUsuario);

						$totalSegundos = 0;
						$totalCheckins = 0;

						while($dadosUsuario = $resultUsuario->fetch_assoc()){
							$quebraData = explode(" ", $dadosUsuario['dataUsuarioLogin']);
							$horaCheckin = $quebraData[1];

							// Converter hora para segundos
							list($h, $m, $s) = explode(":", $horaCheckin);
							$segundos = ($h * 3600) + ($m * 60) + $s;
							$totalSegundos += $segundos;
							$totalCheckins++;
?>
								<tr class="tr">
									<td class="trinta" style="text-align:center; font-size:15px;"><?php echo $dadosUsuario['nomeUsuario'];?></a></td>
									<td class="vinte" style="text-align:center; font-size:15px;"><?php echo data($quebraData[0]);?></a></td>
									<td class="vinte" style="text-align:center; font-size:18px; font-weight:bold;"><?php echo $horaCheckin;?></a></td>
								</tr>
<?php
						}
?>
							</table>
<?php
						// Calcular média de horário de check-in
						if($totalCheckins > 0){
							$mediaSegundos = intval($totalSegundos / $totalCheckins);
							$mediaHoras = floor($mediaSegundos / 3600);
							$mediaMinutos = floor(($mediaSegundos % 3600) / 60);
							$mediaSegundosRestantes = $mediaSegundos % 60;
							$mediaFormatada = sprintf('%02d:%02d:%02d', $mediaHoras, $mediaMinutos, $mediaSegundosRestantes);
?>
							<p style="text-align:center; font-size:22px; color:#718B8F; margin-top:20px;">
								<strong style="font-size:22px;">Média de horário de check-in:</strong> <?php echo $mediaFormatada; ?>
							</p>
<?php
						} else {
?>
							<p style="text-align:center; font-size:22px; color:#718B8F; margin-top:20px;">
								<strong style="font-size:22px;">Não há check-ins no período selecionado.</strong>
							</p>
<?php
						}
?>
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
