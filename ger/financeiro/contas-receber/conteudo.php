<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "contas-receber";
			if(validaAcesso($conn, $area) == "ok"){

				if($_SESSION['cadastros'] == "ok"){
					$erroConteudo = "<p class='erro'>Conta Receber <strong>".$_SESSION['nome']."</strong> cadastrada com sucesso!</p>";
					$_SESSION['cadastros'] = "";
				}else	
				if($_SESSION['alterar'] == "ok"){
					$erroConteudo = "<p class='erro'>Conta Receber <strong>".$_SESSION['nome']."</strong> alterada com sucesso!</p>";
					$_SESSION['alterar'] = "";
				}else	
				if($_SESSION['ativacaos'] == "ok"){
					$erroConteudo = "<p class='erro'>Conta Receber <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacaos'] = "";
				}

				if(isset($_POST['dia-filtro-receber'])){
					$_SESSION['dia-filtro-receber'] = $_POST['dia-filtro-receber'];
					$_SESSION['mes-filtro-receber'] = $_POST['mes-filtro-receber'];
					$_SESSION['ano-filtro-receber'] = $_POST['ano-filtro-receber'];
				}				

				if($_POST['tipo-filtro-status'] != ""){
					$_SESSION['tipo-filtro-status'] = $_POST['tipo-filtro-status'];					
				}
							
				if(isset($_POST['clientes-filtro'])){
					if(is_numeric($_POST['clientes-filtro'])){

						$_SESSION['clientes-filtro-mensalidades-2'] = $_POST['clientes-filtro'];
						$_SESSION['clientes-filtro'] = $_POST['clientes-filtro'];
						$_SESSION['clientes-filtro-mensalidades'] = $_POST['clientes-filtro'];						
											
					}else{
						$sqlCliente = "SELECT codCliente, nomeCliente FROM clientes WHERE nomeCliente = '".$_POST['clientes-filtro']."' ORDER BY codCliente ASC LIMIT 0,1";
						$resultCliente = $conn->query($sqlCliente);
						$dadosCliente = $resultCliente->fetch_assoc();
						
						$_SESSION['clientes-filtro-mensalidades-2'] = $dadosCliente['nomeCliente'];
						$_SESSION['clientes-filtro'] = $dadosCliente['nomeCliente'];
						$_SESSION['clientes-filtro-mensalidades'] = $dadosCliente['nomeCliente'];
					}
				}
				
				if($_SESSION['dia-filtro-receber'] == ""){
					$_SESSION['dia-filtro-receber'] = "T";
				}
				if($_SESSION['mes-filtro-receber'] == ""){
					$_SESSION['mes-filtro-receber'] = date('m');
				}
				if($_SESSION['ano-filtro-receber'] == ""){
					$_SESSION['ano-filtro-receber'] = date('Y');
				}
				
				if($_SESSION['dia-filtro-receber'] != "" && $_SESSION['dia-filtro-receber'] != "T"){
					$filtraDia = " and date_format(vencimentoConta, '%d') = '".$_SESSION['dia-filtro-receber']."'";
				}
				if($_SESSION['mes-filtro-receber'] != "" && $_SESSION['mes-filtro-receber'] != "T"){
					$filtraMes = " and date_format(vencimentoConta, '%m') = '".$_SESSION['mes-filtro-receber']."'";
				}
				if($_SESSION['ano-filtro-receber'] != "" && $_SESSION['ano-filtro-receber'] != "T"){
					$filtraAno = " and date_format(vencimentoConta, '%Y') = '".$_SESSION['ano-filtro-receber']."'";
				}

				if(is_numeric($_SESSION['clientes-filtro-mensalidades'])){

					if($_SESSION['clientes-filtro-mensalidades'] != ""){
						$filtraCliente = " and CO.codContrato = '".$_SESSION['clientes-filtro-mensalidades']."'";
						$filtraCliente2 = " and C.codContrato = '".$_SESSION['clientes-filtro-mensalidades']."'";
					}					
				
				}else{

					if($_SESSION['clientes-filtro-mensalidades'] != ""){
						$filtraCliente = " and C.nomeCliente = '".$_SESSION['clientes-filtro-mensalidades']."'";
						$filtraCliente2 = " and CL.nomeCliente = '".$_SESSION['clientes-filtro-mensalidades']."'";
					}

				}	
					
				if(isset($_POST['tipoPagamento-filtro-contas'])){
					if($_POST['tipoPagamento-filtro-contas'] != ""){
						$sqlTipoPagamento = "SELECT codTipoPagamento, nomeTipoPagamento FROM tipoPagamento WHERE nomeTipoPagamento = '".$_POST['tipoPagamento-filtro-contas']."' ORDER BY codTipoPagamento ASC LIMIT 0,1";
						$resultTipoPagamento = $conn->query($sqlTipoPagamento);
						$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();
						
						$_SESSION['tipoPagamento-filtro-contas'] = $dadosTipoPagamento['codTipoPagamento'];
						$_SESSION['tipoPagamento-filtro-contas-nome'] = $dadosTipoPagamento['nomeTipoPagamento'];
					}else{
						$_SESSION['tipoPagamento-filtro-contas'] = "";
						$_SESSION['tipoPagamento-filtro-contas-nome'] = "";
					}
				}
				
				if($_SESSION['tipoPagamento-filtro-contas'] != ""){
					$filtraTipo = " and CO.codTipoPagamento = ".$_SESSION['tipoPagamento-filtro-contas']."";
					$filtraTipo2 = " and C.codTipoPagamento = ".$_SESSION['tipoPagamento-filtro-contas']."";
				}										
				
				if($_SESSION['tipo-filtro-status'] != "" && $_SESSION['tipo-filtro-status'] != "TO"){
					$filtraStatus = " and CO.statusConta = '".$_SESSION['tipo-filtro-status']."' and CO.baixaConta = 'T'";
					$filtraStatus2 = " and C.statusConta = '".$_SESSION['tipo-filtro-status']."'";
				}	

				if(isset($_POST['contratoFiltro'])){
					if($_POST['contratoFiltro'] != ""){
						$_SESSION['contratoFiltro'] = $_POST['contratoFiltro'];
					}else{
						$_SESSION['contratoFiltro'] = "";
					}
				}
				
				if($_SESSION['contratoFiltro'] != ""){
					$filtraContrato = " and CO.codContrato = '".$_SESSION['contratoFiltro']."'";
					$filtraContrato2 = " and C.codContrato = '".$_SESSION['contratoFiltro']."'";
				}				
				
				if($_POST['conta'] != ""){
					$sqlUpdate = "UPDATE contas SET contaPagamentoConta = '".$_POST['conta']."' WHERE codConta = ".$_POST['cod']."";
					$resultUpdate = $conn->query($sqlUpdate);
				}									
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista" style="padding-top:5px;">Financeiro</p>
						<p class="flexa" style="padding-top:5px;"></p>
						<p class="nome-lista" style="padding-top:5px;">Contas a Receber</p>
						<br class="clear"/>
					</div>
<?php
	$_SESSION['voltarContasUrl'] = "contas-receber";
	$_SESSION['voltarContasTitulo'] = "Contas a Receber";
?>					
					<div class="demoTarget">
						<div id="formulario-filtro">
							<form name="filtro" action="<?php echo $configUrl;?>financeiro/contas-receber/" method="post" >																										
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
					echo $sqlContratoImoveis;
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
							
								<div id="auto_complete_softbest" style="width:247px; float:left; margin-bottom:15px;">
									<p class="bloco-campo" style="margin-bottom:0px;"><label>Filtrar Cliente: <span class="obrigatorio"> </span></label>
									<input class="campo" type="text" name="clientes-filtro" style="width:230px;" value="<?php echo $_SESSION['clientes-filtro']; ?>" onClick="auto_complete(this.value, 'clientes', event);" onKeyUp="auto_complete(this.value, 'clientes', event);" onkeydown="if (getKey(event) == 13) return false;" onBlur="fechaAutoComplete('clientes');" autocomplete="off" id="busca_autocomplete_softbest_clientes" /></p>
									<br class="clear"/>
									
									<div id="exibe_busca_autocomplete_softbest_clientes" class="auto_complete_softbest" style="width:234px; display:none;">

									</div>
								</div>
									
								<div id="auto_complete_softbest" style="width:170px; float:left; margin-bottom:15px;">
									<p class="bloco-campo" style="margin-bottom:0px;"><label>Tipo Pagamento: <span class="obrigatorio"> </span></label>
									<input class="campo" type="text" name="tipoPagamento-filtro-contas" style="width:155px;" value="<?php echo $_SESSION['tipoPagamento-filtro-contas-nome']; ?>" onClick="auto_complete(this.value, 'tipoPagamentoR', event);" onKeyUp="auto_complete(this.value, 'tipoPagamentoR', event);" onkeydown="if (getKey(event) == 13) return false;" onBlur="fechaAutoComplete('tipoPagamentoR');" autocomplete="off" id="busca_autocomplete_softbest_tipoPagamentoR" /></p>
									<br class="clear"/>
									
									<div id="exibe_busca_autocomplete_softbest_tipoPagamentoR" class="auto_complete_softbest" style="display:none;">

									</div>
								</div>
								
								<p><label class="label">Dia:</label>	
									<select class="campo" id="default-usage-select" name="dia-filtro-receber" style="width:80px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="01" <?php echo $_SESSION['dia-filtro-receber'] == '01' ? '/SELECTED/' : '';?>>01</option>
										<option value="02" <?php echo $_SESSION['dia-filtro-receber'] == '02' ? '/SELECTED/' : '';?>>02</option>
										<option value="03" <?php echo $_SESSION['dia-filtro-receber'] == '03' ? '/SELECTED/' : '';?>>03</option>
										<option value="04" <?php echo $_SESSION['dia-filtro-receber'] == '04' ? '/SELECTED/' : '';?>>04</option>
										<option value="05" <?php echo $_SESSION['dia-filtro-receber'] == '05' ? '/SELECTED/' : '';?>>05</option>
										<option value="06" <?php echo $_SESSION['dia-filtro-receber'] == '06' ? '/SELECTED/' : '';?>>06</option>
										<option value="07" <?php echo $_SESSION['dia-filtro-receber'] == '07' ? '/SELECTED/' : '';?>>07</option>
										<option value="08" <?php echo $_SESSION['dia-filtro-receber'] == '08' ? '/SELECTED/' : '';?>>08</option>
										<option value="09" <?php echo $_SESSION['dia-filtro-receber'] == '09' ? '/SELECTED/' : '';?>>09</option>
										<option value="10" <?php echo $_SESSION['dia-filtro-receber'] == '10' ? '/SELECTED/' : '';?>>10</option>
										<option value="11" <?php echo $_SESSION['dia-filtro-receber'] == '11' ? '/SELECTED/' : '';?>>11</option>
										<option value="12" <?php echo $_SESSION['dia-filtro-receber'] == '12' ? '/SELECTED/' : '';?>>12</option>
										<option value="13" <?php echo $_SESSION['dia-filtro-receber'] == '13' ? '/SELECTED/' : '';?>>13</option>
										<option value="14" <?php echo $_SESSION['dia-filtro-receber'] == '14' ? '/SELECTED/' : '';?>>14</option>
										<option value="15" <?php echo $_SESSION['dia-filtro-receber'] == '15' ? '/SELECTED/' : '';?>>15</option>
										<option value="16" <?php echo $_SESSION['dia-filtro-receber'] == '16' ? '/SELECTED/' : '';?>>16</option>
										<option value="17" <?php echo $_SESSION['dia-filtro-receber'] == '17' ? '/SELECTED/' : '';?>>17</option>
										<option value="18" <?php echo $_SESSION['dia-filtro-receber'] == '18' ? '/SELECTED/' : '';?>>18</option>
										<option value="19" <?php echo $_SESSION['dia-filtro-receber'] == '19' ? '/SELECTED/' : '';?>>19</option>
										<option value="20" <?php echo $_SESSION['dia-filtro-receber'] == '20' ? '/SELECTED/' : '';?>>20</option>
										<option value="21" <?php echo $_SESSION['dia-filtro-receber'] == '21' ? '/SELECTED/' : '';?>>21</option>
										<option value="22" <?php echo $_SESSION['dia-filtro-receber'] == '22' ? '/SELECTED/' : '';?>>22</option>
										<option value="23" <?php echo $_SESSION['dia-filtro-receber'] == '23' ? '/SELECTED/' : '';?>>23</option>
										<option value="24" <?php echo $_SESSION['dia-filtro-receber'] == '24' ? '/SELECTED/' : '';?>>24</option>
										<option value="25" <?php echo $_SESSION['dia-filtro-receber'] == '25' ? '/SELECTED/' : '';?>>25</option>
										<option value="26" <?php echo $_SESSION['dia-filtro-receber'] == '26' ? '/SELECTED/' : '';?>>26</option>
										<option value="27" <?php echo $_SESSION['dia-filtro-receber'] == '27' ? '/SELECTED/' : '';?>>27</option>
										<option value="28" <?php echo $_SESSION['dia-filtro-receber'] == '28' ? '/SELECTED/' : '';?>>28</option>
										<option value="29" <?php echo $_SESSION['dia-filtro-receber'] == '29' ? '/SELECTED/' : '';?>>29</option>
										<option value="30" <?php echo $_SESSION['dia-filtro-receber'] == '30' ? '/SELECTED/' : '';?>>30</option>
										<option value="31" <?php echo $_SESSION['dia-filtro-receber'] == '31' ? '/SELECTED/' : '';?>>31</option>
									</select>
								</p>
								<p><label class="label">Mês:</label>
									<select class="campo" id="default-usage-select2" name="mes-filtro-receber" style="width:105px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="01" <?php echo $_SESSION['mes-filtro-receber'] == '01' ? '/SELECTED/' : '';?>>Janeiro</option>
										<option value="02" <?php echo $_SESSION['mes-filtro-receber'] == '02' ? '/SELECTED/' : '';?>>Fevereiro</option>
										<option value="03" <?php echo $_SESSION['mes-filtro-receber'] == '03' ? '/SELECTED/' : '';?>>Março</option>
										<option value="04" <?php echo $_SESSION['mes-filtro-receber'] == '04' ? '/SELECTED/' : '';?>>Abril</option>
										<option value="05" <?php echo $_SESSION['mes-filtro-receber'] == '05' ? '/SELECTED/' : '';?>>Maio</option>
										<option value="06" <?php echo $_SESSION['mes-filtro-receber'] == '06' ? '/SELECTED/' : '';?>>Junho</option>
										<option value="07" <?php echo $_SESSION['mes-filtro-receber'] == '07' ? '/SELECTED/' : '';?>>Julho</option>
										<option value="08" <?php echo $_SESSION['mes-filtro-receber'] == '08' ? '/SELECTED/' : '';?>>Agosto</option>
										<option value="09" <?php echo $_SESSION['mes-filtro-receber'] == '09' ? '/SELECTED/' : '';?>>Setembro</option>
										<option value="10" <?php echo $_SESSION['mes-filtro-receber'] == '10' ? '/SELECTED/' : '';?>>Outubro</option>
										<option value="11" <?php echo $_SESSION['mes-filtro-receber'] == '11' ? '/SELECTED/' : '';?>>Novembro</option>
										<option value="12" <?php echo $_SESSION['mes-filtro-receber'] == '12' ? '/SELECTED/' : '';?>>Dezembro</option>
									</select>
								</p>
								<p><label class="label">Ano:</label>
									<select class="campo" id="default-usage-select3" name="ano-filtro-receber" style="width:80px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="2011" <?php echo $_SESSION['ano-filtro-receber'] == '2011' ? '/SELECTED/' : '';?>>2011</option>
										<option value="2012" <?php echo $_SESSION['ano-filtro-receber'] == '2012' ? '/SELECTED/' : '';?>>2012</option>
										<option value="2013" <?php echo $_SESSION['ano-filtro-receber'] == '2013' ? '/SELECTED/' : '';?>>2013</option>
										<option value="2014" <?php echo $_SESSION['ano-filtro-receber'] == '2014' ? '/SELECTED/' : '';?>>2014</option>
										<option value="2015" <?php echo $_SESSION['ano-filtro-receber'] == '2015' ? '/SELECTED/' : '';?>>2015</option>
										<option value="2016" <?php echo $_SESSION['ano-filtro-receber'] == '2016' ? '/SELECTED/' : '';?>>2016</option>
										<option value="2017" <?php echo $_SESSION['ano-filtro-receber'] == '2017' ? '/SELECTED/' : '';?>>2017</option>
										<option value="2018" <?php echo $_SESSION['ano-filtro-receber'] == '2018' ? '/SELECTED/' : '';?>>2018</option>
										<option value="2019" <?php echo $_SESSION['ano-filtro-receber'] == '2019' ? '/SELECTED/' : '';?>>2019</option>
										<option value="2020" <?php echo $_SESSION['ano-filtro-receber'] == '2020' ? '/SELECTED/' : '';?>>2020</option>
										<option value="2021" <?php echo $_SESSION['ano-filtro-receber'] == '2021' ? '/SELECTED/' : '';?>>2021</option>
										<option value="2022" <?php echo $_SESSION['ano-filtro-receber'] == '2022' ? '/SELECTED/' : '';?>>2022</option>
										<option value="2023" <?php echo $_SESSION['ano-filtro-receber'] == '2023' ? '/SELECTED/' : '';?>>2023</option>
										<option value="2024" <?php echo $_SESSION['ano-filtro-receber'] == '2024' ? '/SELECTED/' : '';?>>2024</option>
										<option value="2025" <?php echo $_SESSION['ano-filtro-receber'] == '2025' ? '/SELECTED/' : '';?>>2025</option>
										<option value="2026" <?php echo $_SESSION['ano-filtro-receber'] == '2026' ? '/SELECTED/' : '';?>>2026</option>
										<option value="2027" <?php echo $_SESSION['ano-filtro-receber'] == '2027' ? '/SELECTED/' : '';?>>2027</option>
										<option value="2028" <?php echo $_SESSION['ano-filtro-receber'] == '2028' ? '/SELECTED/' : '';?>>2028</option>
										<option value="2029" <?php echo $_SESSION['ano-filtro-receber'] == '2029' ? '/SELECTED/' : '';?>>2029</option>
										<option value="2030" <?php echo $_SESSION['ano-filtro-receber'] == '2030' ? '/SELECTED/' : '';?>>2030</option>
									</select>
								</p>

								<p><label class="label">Status:</label>							
									<select class="campo" id="default-usage-select4" style="width:100px; margin-right:0px;" name="tipo-filtro-status">
										<option value="TO">Todos</option>
										<option value="T" <?php echo $_SESSION['tipo-filtro-status'] == "T" ? '/SELECTED/' : '';?> >A Receber</option>
										<option value="F" <?php echo $_SESSION['tipo-filtro-status'] == "F" ? '/SELECTED/' : '';?> >Recebido</option>
									</select>
								</p>

								<script>
									function abreCadastrar(){
										var $rf = jQuery.noConflict();
										if(document.getElementById("cadastrar").style.display=="none"){
											document.getElementById("botaoFechar").style.display="block";
											$rf("#cadastrar").slideDown(250);
										}else{
											document.getElementById("botaoFechar").style.display="none";
											$rf("#cadastrar").slideUp(250);
										}
									}
								</script>
																						
								<p class="botao-filtrar" style="margin-top:18px;"><input type="submit" name="filtrar" value="Filtrar" onClick="enviar()" /></p>

								<div class="botao-novo" style="margin-left:0px; margin-top:18px;"><a onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Conta Receber</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:5px; margin-top:18px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>

								<p style="float:right; margin-right:5px; margin-top:15px; cursor:pointer;" onClick="abrirImprimir();"><img src="<?php echo $configUrl;?>f/i/icones-imprimir2.gif" width="50"/></p>											
								<br class="clear" />
							</form>
						</div>
					</div>
<?php
				if(isset($_POST['clientes'])){

					$sqlContaAntiga = "SELECT codAgrupadorConta FROM contas ORDER BY codAgrupadorConta DESC LIMIT 0,1";
					$resultContaAntiga = $conn->query($sqlContaAntiga);
					$dadosContaAntiga = $resultContaAntiga->fetch_assoc();
					
					$agrupador = $dadosContaAntiga['codAgrupadorConta'] + 1;

					$sqlPegaCliente = "SELECT * FROM clientes WHERE nomeCliente = '".$_POST['clientes']."' ORDER BY codCliente DESC LIMIT 0,1";
					$resultPegaCliente = $conn->query($sqlPegaCliente);
					$dadosPegaCliente = $resultPegaCliente->fetch_assoc();

					$sqlPegaTipoPagamento = "SELECT * FROM tipoPagamento WHERE nomeTipoPagamento = '".$_POST['tipoPagamentoR']."' and tipoPagamento = 'R' ORDER BY codTipoPagamento DESC LIMIT 0,1";
					$resultPegaTipoPagamento = $conn->query($sqlPegaTipoPagamento);
					$dadosPegaTipoPagamento = $resultPegaTipoPagamento->fetch_assoc();
					
					$valorTotal = str_replace(".", "", $_POST['imovel'.$i]);
					$valorTotal = str_replace(".", "", $valorTotal);
					$valorTotal = str_replace(",", ".", $valorTotal);

					$acrescimo = str_replace(".", "", $_POST['acrescimo']);
					$acrescimo = str_replace(".", "", $acrescimo);
					$acrescimo = str_replace(",", ".", $acrescimo);
										
					$desconto = str_replace(".", "", $_POST['desconto']);
					$desconto = str_replace(".", "", $desconto);
					$desconto = str_replace(",", ".", $desconto);


					if($dadosPegaTipoPagamento['codTipoPagamento'] != ""){		
								
						if($dadosPegaCliente['codCliente'] != ""){
							
							if($_POST['valor-troca1'] != ""){
								for($i=1; $i<=$_POST['quanti-ref']; $i++){								

									$valorRef = str_replace(".", "", $_POST['valor-troca'.$i]);
									$valorRef = str_replace(".", "", $valorRef);
									$valorRef = str_replace(",", ".", $valorRef);

									if($valorRef != ""){
										$insert = "INSERT INTO contas VALUES (0, ".$agrupador.", 0, 0, '".$_POST['cod-contrato']."', '', '".$_POST['codComissaoRecebe']."', 'F', 'R', ".$dadosPegaCliente['codCliente'].", 0, '".$dadosPegaTipoPagamento['codTipoPagamento']."', '".$_POST['financiamento']."', '".$_POST['nome']."', '".date('Y-m-d')."', '".data($_POST['data-troca'.$i])."', '".$_POST['bem-troca'.$i]."', '".$valorRef."', '".$valorTotal."', '".$acrescimo."', '".$desconto."', '".$_POST['tipo-pagamentoB'.$i]."', 'T', 'T')";
										$result = $conn->query($insert);					

										if($_POST['tipo-pagamentor'.$i] == "CH"){

											if($_POST['numeroBancoChequer'.$i] != "" && $_POST['nomeChequer'.$i] != "" && $_POST['agenciaChequer'.$i] != "" && $_POST['contaChequer'.$i] != "" && $_POST['numeroChequer'.$i] != "" && $_POST['paraChequer'.$i] != ""){

												$sqlConta = "SELECT codConta FROM contas ORDER BY codConta DESC LIMIT 0,1";
												$resultConta = $conn->query($sqlConta);
												$dadosConta = $resultConta->fetch_assoc();
												
												$sqlInsereContaParcial = "INSERT INTO contasParcial VALUES(0, 1, ".$dadosConta['codConta'].", '".$valorRef."', '', '".date('Y-m-d')."', '".date('H:i:s')."', 'Cheque', 'CH', 1, 'T')";
												$resultInsereContaParcial = $conn->query($sqlInsereContaParcial);
												
												if($resultInsereContaParcial == 1){
																									
													$sqlUpdate = "UPDATE contas SET statusConta = 'F' WHERE codConta = ".$dadosConta['codConta']."";
													$resultUpdate = $conn->query($sqlUpdate);
													
													$sqlContaParcial = "SELECT codContaParcial FROM contasParcial ORDER BY codContaParcial DESC LIMIT 0,1";
													$resultContaParcial = $conn->query($sqlContaParcial);
													$dadosContaParcial = $resultContaParcial->fetch_assoc();

													$sqlBancos = "SELECT codBancoConta FROM bancosConta WHERE codigoBancoConta = ".$_POST['numeroBancoChequer'.$i]." LIMIT 0,1";
													$resultBancos = $conn->query($sqlBancos);
													$dadosBancos = $resultBancos->fetch_assoc();
													
													$sqlInsereCheque = "INSERT INTO cheques VALUES(0, ".$dadosContaParcial['codContaParcial'].", ".$dadosBancos['codBancoConta'].", ".$_POST['numeroBancoChequer'.$i].", '".$_POST['nomeChequer'.$i]."', '".$_POST['agenciaChequer'.$i]."', '".$_POST['contaChequer'.$i]."', '".$_POST['numeroChequer'.$i]."', '".data($_POST['paraChequer'.$i])."', '', 'R', '', 'T')";
													$resultInsereCheque = $conn->query($sqlInsereCheque);
													
												}
											}
										}
									}
								}
							}

							function floorp($val, $precision)
							{
								$mult = pow(10, $precision);
								return floor($val * $mult) / $mult;
							}
													
							$dataInicio = "";
							$data = $_POST['vencimento'];
		
							$saldo = str_replace(".", "", $_POST['saldo']);
							$saldo = str_replace(".", "", $saldo);
							$saldo = str_replace(",", ".", $saldo);
		
							$Vparcela = str_replace(".", "", $_POST['Vparcela']);
							$Vparcela = str_replace(".", "", $Vparcela);
							$Vparcela = str_replace(",", ".", $Vparcela);

							$parcela = $_POST['parcela'];
							$VparcelRedonda = $Vparcela;

							$dimParc = $parcela - 1;
							$multiParc = $dimParc * $Vparcela;
							$dimSaldo = $saldo - $multiParc;
							
							for($i=1; $i<=$_POST['parcela']; $i++){	

								$mesSoma = $i - 1;
								if ($dataInicio == "") {
									$dataInicio = $data;
									$dataAnterior = $data;
								} else {
									$date = DateTime::createFromFormat('d/m/Y', $data);
									if ($date) {
										$date->modify('+'.$mesSoma.' month');
										$dataInicio = $date->format('d/m/Y');
										
										$quebraDataAnterior = explode("/", $dataAnterior);
										if($quebraDataAnterior[1] == "01"){
											$quebraDataInicio = explode("/", $dataInicio);
											if($quebraDataInicio[1] == "03"){
												$ano = $quebraDataInicio[2];
												if(($ano % 4 == 0 && $ano % 100 != 0) || $ano % 400 == 0){
													$dataInicio = "29/02/".$quebraDataInicio[2];
												}else{
													$dataInicio = "28/02/".$quebraDataInicio[2];
												}
											}
										}

										$quebraDataInicio = explode("/", $dataInicio);
										if($quebraDataAnterior[0] == 31){
											$mes = $quebraDataAnterior[1] + 1;
											if($mes == 4 || $mes == 6 || $mes == 9 || $mes == 11){
												$date2 = DateTime::createFromFormat('d/m/Y', $dataInicio);
												if($date2){
													$date2->modify('-1 day');
													$dataInicio = $date2->format('d/m/Y');					
												}
											}
										}

										$dataAnterior = $dataInicio;
									}
								}

								if($i == $parcela){
									$VparcelRedonda = $dimSaldo;
								}				
												
								$insert = "INSERT INTO contas VALUES (0, ".$agrupador.", 0, 0, '".$_POST['cod-contrato']."', '', '".$_POST['codComissaoRecebe']."', 'F', 'R', ".$dadosPegaCliente['codCliente'].", 0, '".$dadosPegaTipoPagamento['codTipoPagamento']."', '".$_POST['financiamento']."', '".$_POST['nome']."', '".date('Y-m-d')."', '".data($dataInicio)."', '".$i."', '".$VparcelRedonda."', '".$valorTotal."', '".$acrescimo."', '".$desconto."', '".$_POST['tipo-pagamento'.$i]."', 'T', 'T')";
								$result = $conn->query($insert);	

								if($_POST['tipo-pagamento'.$i] == "CH"){

									if($_POST['numeroBancoCheque'.$i] != "" && $_POST['nomeCheque'.$i] != "" && $_POST['agenciaCheque'.$i] != "" && $_POST['contaCheque'.$i] != "" && $_POST['numeroCheque'.$i] != "" && $_POST['paraCheque'.$i] != ""){

										$sqlConta = "SELECT codConta FROM contas ORDER BY codConta DESC LIMIT 0,1";
										$resultConta = $conn->query($sqlConta);
										$dadosConta = $resultConta->fetch_assoc();
										
										$sqlInsereContaParcial = "INSERT INTO contasParcial VALUES(0, 1, ".$dadosConta['codConta'].", '".$VparcelRedonda."', '', '".date('Y-m-d')."', '".date('H:i:s')."', 'Cheque', 'CH', 1, 'T')";
										$resultInsereContaParcial = $conn->query($sqlInsereContaParcial);
										
										if($resultInsereContaParcial == 1){
																							
											$sqlUpdate = "UPDATE contas SET statusConta = 'F' WHERE codConta = ".$dadosConta['codConta']."";
											$resultUpdate = $conn->query($sqlUpdate);
											
											$sqlContaParcial = "SELECT codContaParcial FROM contasParcial ORDER BY codContaParcial DESC LIMIT 0,1";
											$resultContaParcial = $conn->query($sqlContaParcial);
											$dadosContaParcial = $resultContaParcial->fetch_assoc();

											$sqlBancos = "SELECT codBancoConta FROM bancosConta WHERE codigoBancoConta = ".$_POST['numeroBancoCheque'.$i]." LIMIT 0,1";
											$resultBancos = $conn->query($sqlBancos);
											$dadosBancos = $resultBancos->fetch_assoc();
											
											$sqlInsereCheque = "INSERT INTO cheques VALUES(0, ".$dadosContaParcial['codContaParcial'].", ".$dadosBancos['codBancoConta'].", ".$_POST['numeroBancoCheque'.$i].", '".$_POST['nomeCheque'.$i]."', '".$_POST['agenciaCheque'.$i]."', '".$_POST['contaCheque'.$i]."', '".$_POST['numeroCheque'.$i]."', '".data($_POST['paraCheque'.$i])."', '', 'R', '', 'T')";
											$resultInsereCheque = $conn->query($sqlInsereCheque);
											
										}
									}
								}
												
							}
							
							if($result == 1){
								$_SESSION['cadastros'] = "ok";
								$_SESSION['nome'] = $_POST['nome'];
								$_SESSION['clientes'] = "";
								$_SESSION['juros'] = "";
								$_SESSION['tipoPagamentoR'] = "";				
								$_SESSION['vencimento'] = "";				
								$_SESSION['parcela'] = "";								
								$_SESSION['desconto'] = "";								
								$_SESSION['tipo-pagamento'] = "";								
								$_SESSION['valor'] = "";
								
								if($_POST['cod-contrato'] != ""){
									
									$sqlUpdate = "UPDATE contratos SET statusContrato = 'F' WHERE codContrato = ".$_POST['cod-contrato']."";
									$resultUpdate = $conn->query($sqlUpdate);
																
								}									
								
								if($_POST['codComissaoRecebe'] != ""){
									
									$sqlUpdate = "UPDATE comissoes SET statusComissao = 'F' WHERE codComissao = ".$_POST['codComissaoRecebe']."";
									$resultUpdate = $conn->query($sqlUpdate);
																
								}									
															
								echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/contas-receber/'>";									

								$display = "none";
							}else{
								$erroData = "<p class='erro'>Problemas ao cadastrar Conta a Receber!</p>";			
								$display = "block";
							}
						}else{
							$erroData = "<p class='erro'>O Cliente <strong>".$_POST['clientes']."</strong> não foi encontrado.</p>";
							$_SESSION['clientes'] = "";
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['juros'] = $_POST['juros'];
							$_SESSION['tipoPagamentoR'] = $_POST['tipoPagamentoR'];
							$_SESSION['vencimento'] = $_POST['vencimento'];				
							$_SESSION['parcela'] = $_POST['parcela'];				
							$_SESSION['tipo-pagamento'] = $_POST['tipo-pagamento'];				
							$_SESSION['valor'] = $_POST['valor'];	
							$display = "block";			
						}
					}else{
						$erroData = "<p class='erro'>O campo referente a <strong>".$_POST['tipoPagamentoR']."</strong> não foi encontrado, se for um novo, você precisa clicar em + Novo Tipo Pagamento.</p>";
						$_SESSION['cod-contrato'] = $_POST['cod-contrato'];
						$_SESSION['clientes'] = $_POST['clientes'];
						$_SESSION['filial'] = $_POST['filial'];
						$_SESSION['juros'] = $_POST['juros'];
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['tipoPagamentoR'] = $_POST['tipoPagamentoR'];
						$_SESSION['vencimento'] = $_POST['vencimento'];				
						$_SESSION['parcela'] = $_POST['parcela'];				
						$_SESSION['tipo-pagamento'] = $_POST['tipo-pagamento'];				
						$_SESSION['formaPagamento'] = $_POST['formaPagamento'];				
						$_SESSION['valor'] = $_POST['valor'];	
						$_SESSION['total'] = $_POST['valor'];	
						$_SESSION['imovel'] = $_POST['imovel'];	
						$_SESSION['valorTotal'] = $_POST['valorTotal'];	
						$_SESSION['saldo'] = $_POST['saldo'];	
						$_SESSION['entrada'] = $_POST['entrada'];	
						$_SESSION['desconto'] = $_POST['desconto'];	
						$_SESSION['acrescimo'] = $_POST['acrescimo'];	
						$_SESSION['Vparcela'] = $_POST['Vparcela'];	
						$_SESSION['financiamento'] = $_POST['financiamento'];	
						$display = "block";			
					}						
				}else{
					if($_POST['codContrato'] != ""){
						$_SESSION['cod-contrato'] = $_POST['codContrato'];
						$_SESSION['clientes'] = $_POST['nomeCliente'];
						$_SESSION['nome'] = "";
						$_SESSION['tipoPagamentoR'] = "";
						$_SESSION['juros'] = "";
						$_SESSION['vencimento'] = "";
						$_SESSION['parcela'] = "";
						$_SESSION['tipo-pagamento'] = "";
						$_SESSION['formaPagamento'] = "";
						$_SESSION['total'] = number_format($_POST['valorVenda'], 2, ",", ".");
						$_SESSION['imovel'] = number_format(trim($_POST['valorVenda']), 2, ",", ".");
						$_SESSION['entrada'] = "";
						$_SESSION['desconto'] = "";
						$_SESSION['acrescimo'] = "";
						$_SESSION['Vparcela'] = "";
						$display = "block";						
					}else
					if($_POST['codComissaoRecebe'] != ""){
						$_SESSION['codComissaoRecebe'] = $_POST['codComissaoRecebe'];
						$_SESSION['clientes'] = "";
						$_SESSION['nome'] = $_POST['nomeComissaoRecebe'];
						$_SESSION['tipoPagamentoR'] = $_POST['tipoPagamento'];
						$_SESSION['juros'] = "";
						$_SESSION['vencimento'] = "";
						$_SESSION['financiamento'] = "N";
						$_SESSION['parcela'] = "";
						$_SESSION['tipo-pagamento'] = "PI";
						$_SESSION['formaPagamento'] = "";
						$_SESSION['total'] = number_format($_POST['valorComissaoRecebe'], 2, ",", ".");
						$_SESSION['imovel'] = number_format(trim($_POST['valorComissaoRecebe']), 2, ",", ".");
						$_SESSION['entrada'] = "";
						$_SESSION['desconto'] = "";
						$_SESSION['acrescimo'] = "";
						$_SESSION['Vparcela'] = "";
						$display = "block";						
					}else{
						$_SESSION['cod-contrato'] = "";
						$_SESSION['imovel'] = "";
						$_SESSION['clientes'] = "";
						$_SESSION['nome'] = "";
						$_SESSION['juros'] = "T";
						$_SESSION['tipoPagamentoR'] = "";
						$_SESSION['vencimento'] = "";
						$_SESSION['parcela'] = "";
						$_SESSION['tipo-pagamento'] = "";
						$_SESSION['formaPagamento'] = "";
						$_SESSION['total'] = "";
						$_SESSION['valorTotal'] = "";
						$_SESSION['valorReceber'] = "";
						$_SESSION['entrada'] = "";
						$_SESSION['codigo-imovel'] = "";
						$_SESSION['acrescimo'] = "";
						$_SESSION['desconto'] = "";
						$_SESSION['Vparcela'] = "";
						$_SESSION['saldo'] = "";
						$display = "none";
					}			
				}

				if($erroData != "" || $erro == "sim" || $erro == "ok"){
?>
					<div class="area-erro">
<?php
					echo $erroData;
?>
					</div>
<?php
				}	
?>						
					<div id="cadastrar" style="display:<?php echo $display;?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">	
						<div class="botao-novo" style="margin-left:0px; margin-top:-20px; margin-bottom:20px;"><a href="<?php echo $configUrlGer;?>financeiro/tipoPagamento/1/"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Tipo Pagamento</div><div class="direita-novo"></div></a></div>
						<br class="clear"/>
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
						<script language="javascript">

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
							
							function calculosConta(){

								var $ss = jQuery.noConflict();
															
								var valorImovel = document.getElementById("total-imovel").value;
																
								if(valorImovel != "" && valorImovel != "0"){
									valorImovel = valorImovel.replace(".", "");
									valorImovel = valorImovel.replace(".", "");
									valorImovel = valorImovel.replace(",", ".");	

									document.getElementById("valor-saldo").disabled="";
									document.getElementById("valor-total").disabled="";

									var valorImovelSoma = valorImovel;
									
									var acrescimo = document.getElementById("acrescimo").value;
																		
									document.getElementById("acrescimo").disabled="";
									if(acrescimo != "" && acrescimo != "0"){
										acrescimo = acrescimo.replace(".", "");
										acrescimo = acrescimo.replace(".", "");
										acrescimo = acrescimo.replace(",", ".");
										
										valorImovelSoma = parseFloat(valorImovelSoma) + parseFloat(acrescimo);												
									}

									var desconto = document.getElementById("desconto").value;

									document.getElementById("desconto").disabled="";										
									if(desconto != "" && desconto != "0"){
										desconto = desconto.replace(".", "");
										desconto = desconto.replace(".", "");
										desconto = desconto.replace(",", ".");
										
										valorImovelSoma = valorImovelSoma - desconto;												
									}
										

									document.getElementById("valor-total").value=number_format(valorImovelSoma, 2, ",", ".");
									document.getElementById("valor-saldo").value=number_format(valorImovelSoma, 2, ",", ".");
									
									if(document.getElementById("parcela").value=="" && document.getElementById("vencimento").value=="" || document.getElementById("parcela").value=="0"){
										document.getElementById("parcela").value=1;
										document.getElementById("vencimento").value="<?php echo data(date('Y-m-d'));?>";
										divideParcelas();
									}										

									var valorTotal = document.getElementById("valor-total").value;
									valorTotal = valorTotal.replace(".", "");
									valorTotal = valorTotal.replace(".", "");
									valorTotal = valorTotal.replace(",", ".");	

									var valorSaldo = document.getElementById("valor-saldo").value;
									valorSaldo = valorSaldo.replace(".", "");
									valorSaldo = valorSaldo.replace(".", "");
									valorSaldo = valorSaldo.replace(",", ".");
									var valorSaldoSoma = valorSaldo;
									
									document.getElementById("bem-troca1").disabled="";
									document.getElementById("valor-troca1").disabled="";
									document.getElementById("data-troca1").disabled="";
									document.getElementById("tipo-pagamentoB1").disabled="";
									var pegaValorRef = document.getElementById("valor-troca1").value;
									if(pegaValorRef != ""){																												
										var pegaTotalRef = document.getElementById("quanti-ref").value;
										var somaRefs = 0;
										for(i=1; i<=pegaTotalRef; i++){
											if(document.getElementById("valor-troca"+i).value!=""){
												var pegaRefs = document.getElementById("valor-troca"+i).value;
												var pegaRefs = pegaRefs.replace(".", "");
												var pegaRefs = pegaRefs.replace(".", "");
												var pegaRefs = pegaRefs.replace(",", ".");		
												var somaRefs = parseFloat(somaRefs) + parseFloat(pegaRefs);
											}
										}
										
										var valorSaldoSoma = valorSaldoSoma - somaRefs;
										document.getElementById("total-bem").value=valorSaldoSoma;
									}								

									document.getElementById("valor-saldo").value=number_format(valorSaldoSoma, 2, ",", ".");

									document.getElementById("parcela").disabled="";										
									document.getElementById("Vparcela").disabled="";										
									document.getElementById("vencimento").disabled="";										
									document.getElementById("tipo-pagamento").disabled="";
									
									var parcela = document.getElementById("parcela").value;
									
									if(parcela != "" && parcela != "0"){
										divideParcelas();
									}										

									var pegaSaldo = document.getElementById("valor-saldo").value;
									var parcela = document.getElementById("parcela").value;
									var Vparcela = document.getElementById("Vparcela").value;
									var vencimento = document.getElementById("vencimento").value;
									var tipoPagamento = document.getElementById("tipo-pagamento").value;
	
									if(pegaSaldo != "" && parcela != "" && parcela != "0" && Vparcela != "" && vencimento != "" && tipoPagamento != ""){
										document.getElementById("botao-editar-parcelas").style.display="table";
										
										var pegaNomeRef = document.getElementById("bem-troca1").value;
										var pegaValorRef = document.getElementById("valor-troca1").value;
										var pegaDataRef = document.getElementById("data-troca1").value;
										var pegaMeioRef = document.getElementById("tipo-pagamentoB1").value;
										
										if(pegaNomeRef != "" && pegaValorRef != "" && pegaDataRef != "" && pegaMeioRef){
											var pegaTotalRef = document.getElementById("quanti-ref").value;
											for(i=1; i<=pegaTotalRef; i++){

												var pegaNome = document.getElementById("bem-troca"+i).value;
												var pegaValor = document.getElementById("valor-troca"+i).value;
												var pegaData = document.getElementById("data-troca"+i).value;
												var pegaTipoPagamento = document.getElementById("tipo-pagamentoB"+i).value;
												
												if(pegaNome != "" && pegaValor != "" && pegaData != "" && pegaTipoPagamento != ""){											

													if(document.getElementById("bloco-bemParce"+i)){
														
													}else{
														var novadiv = document.createElement('div');
														novadiv.setAttribute('id', "bloco-bemParce"+i);							
														document.getElementById("outros-valores").appendChild(novadiv);	
													}	
																							
													document.getElementById("bloco-bemParce"+i).innerHTML="<div id='parcela-r"+i+"' style='border:1px solid #ccc; background-color:#f5f5f5; padding:10px; margin-bottom:20px;'><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Nome "+i+": <span class='obrigatorio'> * </span></label><input style='width:120px;' class='campo' type='text' name='parcelar"+i+"'  readonly id='parcelar"+i+"' value='"+pegaNome+"'/></p><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Vencimento:</label><input class='campo' type='text' id='vencimentor"+i+"' readonly name='vencimentor"+i+"' style='width:120px;' value='"+pegaData+"' onKeyDown='Mascara(this,Data);' onKeyPress='Mascara(this,Data);' onKeyUp='Mascara(this,Data)'/></p><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Valor:</label><input style='width:100px;' required class='campo' type='text' id='valorr"+i+"' readonly name='valorr"+i+"' value='"+pegaValor+"' onKeyUp='moeda(this);'/></p><p class='bloco-campo' style='margin-bottom:0px;'><label>Meio de Pagamento: <span class='obrigatorio'> * </span></label><select class='campo' id='tipo-pagamentor"+i+"' style='width:217px;' required name='tipo-pagamentor"+i+"'><option value=''>Selecione</option><option value='PI'>Pix</option><option value='D'>Dinheiro</option><option value='C'>Cartão</option><option value='CH'>Cheque</option><option value='B'>Boleto</option><option value='TD'>Transf/Depósito</option><option value='P'>Permuta</option></select><br class='clear'/></p><div id='form-chequer"+i+"' style='display:none;'><br/><p class='titulo-cheques' style='font-size:16px; color:#718B8F; text-decoration:underline; font-weight:bold; padding-bottom:10px;'>Cheque</p><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Banco:</label><select class='campo' id='bancoChequeAvistar"+i+"' name='bancor"+i+"' style='width:170px;'><option value=''>Selecione</option><?php $sqlBancoConta = "SELECT * FROM bancosConta WHERE statusBancoConta = 'T' ORDER BY nomeBancoConta ASC"; $resultBancoConta = $conn->query($sqlBancoConta);while($dadosBancoConta = $resultBancoConta->fetch_assoc()){?><option value='<?php echo $dadosBancoConta['codigoBancoConta'];?>' <?php echo $dadosBancoConta['codBancoConta'] == $_SESSION['bancoCheque'] ? '/SELECTED/' : '';?> ><?php echo $dadosBancoConta['nomeBancoConta'];?></option><?php } ?></select></p><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Nº Banco:</label><input class='campo' size='10' id='numeroBancoChequer"+i+"' readonly type='text' name='numeroBancoChequer"+i+"' value='' onKeyDown='Mascara(this,Integer);' onKeyPress='Mascara(this,Integer);' onKeyUp='Mascara(this,Integer)'/></p><p class='bloco-campo' style='margin-bottom:0px;'><label>Nome:</label><input class='campo' style='width:221px;' id='nomeChequer"+i+"' type='text' name='nomeChequer"+i+"' value='' /></p><br class='clear' /><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Agência:</label><input class='campo' type='text' id='agenciaChequer"+i+"' style='width:113px;' name='agenciaChequer"+i+"' value='' /></p><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Conta:</label><input class='campo' type='text' id='contaChequer"+i+"' style='width:113px;' name='contaChequer"+i+"' value='' /></p><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Nº Cheque:</label><input class='campo' type='text' id='numeroChequer"+i+"' style='width:111px;' name='numeroChequer"+i+"' value='' /></p><p class='bloco-campo' style='margin-bottom:0px;'><label>Bom para:</label><input class='campo' type='text' id='paraChequer"+i+"' style='width:112px;' name='paraChequer"+i+"' value='' onKeyDown='Mascara(this,Data);' onKeyPress='Mascara(this,Data);' onKeyUp='Mascara(this,Data)'/></p></div></div>";									
													if(pegaTipoPagamento == "CH"){
														document.getElementById("form-chequer"+i).style.display="block";
													}
													document.getElementById("tipo-pagamentor"+i).setAttribute("onchange", "alteraMeio(this.value, 'r"+i+"'), mudaMeioBem(this.value, 'B"+i+"')");
													document.getElementById("bancoChequeAvistar"+i).setAttribute("onChange", "insereBanco(this.value, 'r"+i+"')");
													document.getElementById("tipo-pagamentor"+i).value=pegaTipoPagamento;
													
													var tipoPagamentoConfere = document.getElementById("tipo-pagamentor"+i).value;
													if(tipoPagamentoConfere == ""){
														document.getElementById("tipo-pagamentor"+i).value=tipoPagamentoConfere; 
													}
												}
												
											}
										}

										$ss.post("<?php echo $configUrl;?>financeiro/contas-receber/atualiza-parcelas.php", {saldo: pegaSaldo, parcela: parcela, Vparcela: Vparcela, vencimento: vencimento, tipoPagamento: tipoPagamento}, function(data){												
											document.getElementById("parcelas-valores").innerHTML=data;
										});													
									}else{
										document.getElementById("outros-valores").innerHTML="";
										document.getElementById("parcelas-valores").innerHTML="";
										document.getElementById("botao-editar-parcelas").style.display="none";
										document.getElementById("mostra-parcelas").style.display="none";
									}

								}else{									
									document.getElementById("valor-total").value="";									
									document.getElementById("valor-total").disabled="disabled";
																		
									document.getElementById("valor-saldo").value="";									
									document.getElementById("valor-saldo").disabled="disabled";									

									document.getElementById("acrescimo").value="";									
									document.getElementById("acrescimo").disabled="disabled";																		

									document.getElementById("bem-troca1").value="";									
									document.getElementById("bem-troca1").disabled="disabled";									
									document.getElementById("valor-troca1").value="";									
									document.getElementById("valor-troca1").disabled="disabled";									
									document.getElementById("data-troca1").value="";									
									document.getElementById("data-troca1").disabled="disabled";	
									document.getElementById("tipo-pagamentoB1").value="";									
									document.getElementById("tipo-pagamentoB1").disabled="disabled";	

									var pegaTotalRef = document.getElementById("quanti-ref").value;
									for(i=2; i<=pegaTotalRef; i++){
										var node = document.getElementById("bloco-bem"+i);
										if (node.parentNode) {
										  node.parentNode.removeChild(node);
										}
									}

									document.getElementById("quanti-ref").value=1;									
									document.getElementById("total-bem").value=0;									

									document.getElementById("desconto").value="";									
									document.getElementById("desconto").disabled="disabled";		
																	
									document.getElementById("parcela").value="";										
									document.getElementById("parcela").disabled="disabled";										
									document.getElementById("Vparcela").value="";										
									document.getElementById("Vparcela").disabled="disabled";										
									document.getElementById("vencimento").value="";										
									document.getElementById("vencimento").disabled="disabled";										
									document.getElementById("tipo-pagamento").value="";									
									document.getElementById("tipo-pagamento").disabled="disabled";									

									document.getElementById("outros-valores").innerHTML="";
									document.getElementById("parcelas-valores").innerHTML="";
									document.getElementById("botao-editar-parcelas").style.display="none";
									document.getElementById("mostra-parcelas").style.display="none";									
								}
							
							}

							function novoBem(){
								var valorImovel = document.getElementById("total-imovel").value;
								if(valorImovel != "" && valorImovel != 0){
									var pegaTotalRef = document.getElementById("quanti-ref").value;
									var somaPegaTotalRef = parseInt(pegaTotalRef) + 1;
									
									var novadiv = document.createElement('div');
									novadiv.setAttribute('id', "bloco-bem"+somaPegaTotalRef);							
									document.getElementById("bem").appendChild(novadiv);	
									document.getElementById("bloco-bem"+somaPegaTotalRef).innerHTML += "<p class='bloco-campo-float' style='margin-bottom:0px;'><label>Nome "+somaPegaTotalRef+":</label><input style='width:120px;' class='campo' onKeyup='calculosConta();' type='text' id='bem-troca"+somaPegaTotalRef+"' name='bem-troca"+somaPegaTotalRef+"' value=''/></p><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Valor:</label><input style='width:120px;' class='campo' type='text' id='valor-troca"+somaPegaTotalRef+"' name='valor-troca"+somaPegaTotalRef+"' value='' onkeyup='moeda(this); calculosConta();'/></p><p class='bloco-campo-float' style='margin-bottom:0px;'><label>Data:</label><input class='campo' type='text' id='data-troca"+somaPegaTotalRef+"' name='data-troca"+somaPegaTotalRef+"' style='width:100px;' value=''/></p><p class='bloco-campo' style='margin-bottom:0px;'><label>Meio de Pagamento: <span class='obrigatorio'> </span></label><select class='campo' id='tipo-pagamentoB"+somaPegaTotalRef+"' name='tipo-pagamentoB"+somaPegaTotalRef+"' style='width:175px;'><option value=''>Selecione</option><option value='PI'>Pix</option><option value='D'>Dinheiro</option><option value='C'>Cartão</option><option value='CH'>Cheque</option><option value='B'>Boleto</option><option value='TD'>Transf/Depósito</option><option value='P'>Permuta</option></select></p>";
									document.getElementById("bloco-bem"+somaPegaTotalRef).style.width="595px";
									document.getElementById("bloco-bem"+somaPegaTotalRef).style.marginTop="20px";
									document.getElementById("quanti-ref").value=somaPegaTotalRef;						
									document.getElementById("bem-troca"+somaPegaTotalRef).setAttribute("onkeyup", "calculosConta();");
									document.getElementById("valor-troca"+somaPegaTotalRef).setAttribute("onkeyup", "moeda(this); calculosConta();");
									document.getElementById("data-troca"+somaPegaTotalRef).setAttribute("onKeyDown", "Mascara(this,Data);");
									document.getElementById("data-troca"+somaPegaTotalRef).setAttribute("onKeyPress", "Mascara(this,Data);");
									document.getElementById("data-troca"+somaPegaTotalRef).setAttribute("onKeyUp", "Mascara(this,Data); calculosConta();");
									document.getElementById("tipo-pagamentoB"+somaPegaTotalRef).setAttribute("onChange", "calculosConta();");
								}
							}
																						
							function divideParcelas(){
								var parcelas = document.getElementById("parcela").value;
								var valorSaldo = document.getElementById("valor-saldo").value;

								if(parcelas != "" && parcelas != "0"){
									valorSaldo = valorSaldo.replace(".", "");
									valorSaldo = valorSaldo.replace(".", "");
									valorSaldo = valorSaldo.replace(",", ".");
									
									var divide = valorSaldo / parcelas;
									document.getElementById("Vparcela").value=number_format(divide, 2, ",", ".");
								}
							}
							
							function alteraMeio(meio, cod){
								if(meio == "CH"){
									document.getElementById("form-cheque"+cod).style.display="block";
								}else{
									document.getElementById("form-cheque"+cod).style.display="none";
								}
							}
	
							function insereBanco(value, cod){
								document.getElementById("numeroBancoCheque"+cod).value=value;
							}
							
							function mudaMeioBem(value, cod){
								document.getElementById("tipo-pagamento"+cod).value=value;
							}							
					
							function abreParcelas(){
								if(document.getElementById("mostra-parcelas").style.display=="none"){
									document.getElementById("mostra-parcelas").style.display="block";
								}else{
									document.getElementById("mostra-parcelas").style.display="none";
								}
							}
						</script>
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<form name="contas" action="<?php echo $configUrlGer; ?>financeiro/contas-receber/" method="post">
							<input type="hidden" id="tipoEnvio" name="tipoEnvio" value="" />
							<input type="hidden" value="<?php echo $_SESSION['codComissaoRecebe'];?>" name="codComissaoRecebe"/>
							
							<p class="bloco-campo-float">
								<label>Contrato:</label>
								<select class="selectContrato form-control campo" id="idSelectContrato" name="cod-contrato" style="width:350px; display: none;">
										<option value="">Selecione</option>	
<?php
				$sqlContratos = "SELECT * FROM contratos C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.statusContrato = 'T' ORDER BY C.dataContrato DESC";
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
							$lotes .= $dadosImoveis['codigoLote'];
						}else{
							$lotes .= ", ".$dadosImoveis['codigoLote'];
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
								<input class="campo" type="text" name="clientes" required style="width:220px;" value="<?php echo $_SESSION['clientes']; ?>" onClick="auto_complete(this.value, 'clientes_c', event);" onKeyUp="auto_complete(this.value, 'clientes_c', event);" onBlur="fechaAutoComplete('clientes_c');" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest_clientes_c" /></p>
								
								<div id="exibe_busca_autocomplete_softbest_clientes_c" class="auto_complete_softbest" style="width:234px; display:none;">

								</div>
							</div>	
							
							<div id="auto_complete_softbest" style="width:176px; float:left; margin-bottom:15px;">
								<p class="bloco-campo" style="margin-bottom:0px;"><label>Tipo Pagamento: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" name="tipoPagamentoR" required style="width:160px;" value="<?php echo $_SESSION['tipoPagamentoR']; ?>" onClick="auto_complete(this.value, 'tipoPagamentoR_c', event);" onKeyUp="auto_complete(this.value, 'tipoPagamentoR_c', event);" onBlur="fechaAutoComplete('tipoPagamentoR_c');" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest_tipoPagamentoR_c" /></p>
								
								<div id="exibe_busca_autocomplete_softbest_tipoPagamentoR_c" class="auto_complete_softbest" style="display:none;">

								</div>
							</div>

							<p class="bloco-campo-float"><label>Tipo Financiamento: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="financiamento" required name="financiamento" style="width:170px;">
									<option value="">Selecione</option>
									<option value="N" <?php echo $_SESSION['financiamento'] == 'N' ? '/SELECTED/' : '';?> >Nenhum</option>
									<option value="P" <?php echo $_SESSION['financiamento'] == 'P' ? '/SELECTED/' : '';?> >Próprio</option>
									<option value="B" <?php echo $_SESSION['financiamento'] == 'B' ? '/SELECTED/' : '';?> >Banco</option>
								</select>
								<br class="clear"/>
							</p>

							<br class="clear"/>
																			
							<p class="bloco-campo-float"><label>Descrição: <span class="obrigatorio"> * </span></label>
							<input style="width:180px;" class="campo" type="text" name="nome" required id="nome" value="<?php echo $_SESSION['nome'];?>" /></p>							

							<p class="bloco-campo-float"><label>Valor da Conta:<span class="obrigatorio"> * </span></label>
							<input style="width:125px;" class="campo" type="text" required id="total-imovel" name="imovel" value="<?php echo $_SESSION['imovel']; ?>" onkeyup="moeda(this); calculosConta();"/></p>

							<p class="bloco-campo-float"><label>Acréscimo:</label>
							<input style="width:90px;" class="campo" type="text" disabled="disabled" id="acrescimo" name="acrescimo" value="<?php echo $_SESSION['acrescimo']; ?>" onkeyup="moeda(this); calculosConta();"/></p>

							<p class="bloco-campo-float"><label>Desconto:</label>
							<input style="width:62px;" class="campo" type="text" id="desconto" disabled="disabled" name="desconto" value="<?php echo $_SESSION['desconto']; ?>" onkeyup="moeda(this); calculosConta(this);"/></p>

							<p class="bloco-campo-float"><label>Total:</label>
							<input style="width:125px;" class="campo" type="text" disabled="disabled" id="valor-total" required readonly name="valor" value="<?php echo $_SESSION['total']; ?>" /></p>

							<br class="clear"/>

							<div id="bem">
								<div id="bloco-bem1">	
							
									<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Nome 1:</label>
									<input style="width:120px;" class="campo" type="text" id="bem-troca1" disabled="disabled" name="bem-troca1" value="<?php echo $_SESSION['bem-troca1'];?>" onKeyup="calculosConta();"/></p>

									<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Valor:</label>
									<input style="width:120px;" class="campo" type="text" id="valor-troca1" disabled="disabled" name="valor-troca1" value="<?php echo $_SESSION['valor-troca1']; ?>" onkeyup="moeda(this); calculosConta(this);"/></p>

									<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Data:</label>
									<input class="campo" type="text" id="data-troca1" name="data-troca1" disabled="disabled" style="width:100px;" value="<?php echo $_SESSION['data-troca1']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data); calculosConta();"/></p>

									<p class="bloco-campo" style="margin-bottom:0px;"><label>Meio de Pagamento: <span class="obrigatorio"> </span></label>
										<select class="campo" id="tipo-pagamentoB1" disabled="disabled" onChange="calculosConta();" name="tipo-pagamentoB1" style="width:175px;">
											<option value="">Selecione</option>
											<option value="PI" <?php echo $_SESSION['tipo-pagamento1'] == 'PI' ? '/SELECTED/' : '';?>>Pix</option>
											<option value="D" <?php echo $_SESSION['tipo-pagamento1'] == 'D' ? '/SELECTED/' : '';?>>Dinheiro</option>
											<option value="C" <?php echo $_SESSION['tipo-pagamento1'] == 'C' ? '/SELECTED/' : '';?>>Cartão</option>
											<option value="CH" <?php echo $_SESSION['tipo-pagamento1'] == 'CH' ? '/SELECTED/' : '';?>>Cheque</option>
											<option value="B" <?php echo $_SESSION['tipo-pagamento1'] == 'B' ? '/SELECTED/' : '';?>>Boleto</option>
											<option value="TD" <?php echo $_SESSION['tipo-pagamento1'] == 'TD' ? '/SELECTED/' : '';?>>Transf/Depósito</option>
											<option value="P" <?php echo $_SESSION['tipo-pagamento1'] == 'P' ? '/SELECTED/' : '';?>>Permuta</option>
										</select>
									</p>														
								</div>
							</div>
							
							<div class="botao-consultar" onClick="novoBem();" style="margin-left:610px; margin-top:-32px; margin-bottom:0px; position:absolute;"><div class="esquerda-consultar"></div><div class="conteudo-consultar">+</div><div class="direita-consultar"></div></div>					

							<input type="hidden" value="1" name="quanti-ref" id="quanti-ref"/>
							<input type="hidden" value="0" name="total-bem" id="total-bem"/>
					
							<br class="clear"/>

							<p class="bloco-campo-float"><label>Saldo:</label>
							<input style="width:80px;" class="campo" type="text" id="valor-saldo" disabled="disabled" required readonly name="saldo" value="<?php echo $_SESSION['saldo']; ?>"/></p>

							<p class="bloco-campo-float"><label>N°. Parcelas: <span class="obrigatorio"> * </span></label>
							<input style="width:90px;" class="campo" type="text" name="parcela" disabled="disabled" required id="parcela" value="<?php echo $_SESSION['parcela'];?>" onKeyUp="divideParcelas(); calculosConta();" /></p>

							<p class="bloco-campo-float"><label>Valor Parcela: <span class="obrigatorio"> * </span></label>
							<input style="width:100px;" class="campo" type="text" name="Vparcela" disabled="disabled" required readonly id="Vparcela" value="<?php echo $_SESSION['Vparcela'];?>" /></p>

							<p class="bloco-campo-float"><label>Data Parcela: <span class="obrigatorio">*</span></label>
							<input class="campo" type="text" id="vencimento" name="vencimento" disabled="disabled" required style="width:95px;" value="<?php echo $_SESSION['vencimento']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data); calculosConta();"/></p>
																	
							<p class="bloco-campo-float"><label>Meio de Pagamento: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo-pagamento" onChange="calculosConta();" disabled="disabled" required name="tipo-pagamento" style="width:243px;">
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

							<p class="editar" id="botao-editar-parcelas" onClick="abreParcelas();" style="cursor:pointer; float:left; margin-right:100px; display:none; font-size:18px; text-decoration:underline; padding-top:10px; padding-bottom:10px; color:#718B8F;">Visualizar Parcela(s)</p>
							<br class="clear"/>
							<div id="mostra-parcelas" style="width:660px; border:1px solid #ccc; padding:10px; display:none;">
								<div id="outros-valores">
								
								</div>
								<div id="parcelas-valores">
								
								</div>
							</div>
							
							<input type="hidden" value="" id="valor-parcelas-hidden"/>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Conta a Receber" value="Salvar" onClick="validaForm(1);"/><p class="direita-botao"></p></div></p>						

<?php
				if($_POST['codContrato'] != ""){
					echo "<script> carregaImovel(".$_POST['codigoImovel']."); </script>";
				}
?>

							<br class="clear"/>
						</form>					
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
				</script>
				<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>								
				<div id="conteudo-imprimir" style="width:900px; margin-top:-100px; min-height:500px; display:none; position:absolute; z-index:1; left:50%; margin-left:-450px; box-shadow:0px 0px 20px #528585; border-radius:10px; background-color:#FFFFFF;">
					<div id="conteudo-scroll" style="width:900px; height:500px; overflow-y:auto; overflow-x:hidden;">
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
									<p style="display:table; margin:0 auto; padding-bottom:5px;"><img src="<?php echo $configUrlGer;?>f/i/comp.png" height="80"/></p>
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; margin:0; font-family:Arial; font-size:24px; font-weight:bold;">Contas a Receber</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:30px;">
									<div id="mostra-dados" style="width:100%;">
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:15.4%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Cliente</p>
											<p style="width:15.4%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Descrição</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Tipo Pagamento</p>
											<p style="width:5%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Parcela</p>
											<p style="width:8%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Vencimento</p>
											<p style="width:8%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">A Receber</p>
											<p style="width:8%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Valor</p>
											<p style="width:8%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Receber</p>
											<br style="clear:both;"/>
										</div>
<?php			
				$sqlConta = "SELECT CO.*, C.* FROM contas CO inner join clientes C on CO.codCliente = C.codCliente WHERE CO.areaPagamentoConta = 'R' and CO.baixaConta = 'T' and (CO.vencimentoConta < '".date('Y-m-d')."' and CO.statusConta = 'T'".$filtraContrato.$filtraCliente.$filtraTipo.$filtraStatus.") or CO.baixaConta = 'T' and CO.codCliente != ''".$filtraContrato.$filtraCliente.$filtraTipo.$filtraDia.$filtraMes.$filtraAno.$filtraStatus." ORDER BY CO.baixaConta ASC, CO.statusConta ASC, CO.vencimentoConta ASC, CO.codConta DESC LIMIT 0,60";
				$resultConta = $conn->query($sqlConta);
				while($dadosConta = $resultConta->fetch_assoc()){
					
					$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosConta['codTipoPagamento']." LIMIT 0,1";
					$resultTipoPagamento = $conn->query($sqlTipoPagamento);
					$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();	

					$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$dadosConta['codConta']."";
					$resultContaParcial = $conn->query($sqlContaParcial);
					$dadosContaParcial = $resultContaParcial->fetch_assoc();

					$sqlContaParcialDesc = "SELECT SUM(descontoContaParcial) registros FROM contasParcial WHERE codConta = ".$dadosConta['codConta']."";
					$resultContaParcialDesc = $conn->query($sqlContaParcialDesc);
					$dadosContaParcialDesc = $resultContaParcialDesc->fetch_assoc();

					if($dadosConta['statusConta'] == 'T' && $dadosConta['baixaConta'] == 'T' || $dadosConta['statusConta'] == 'F' && $dadosConta['baixaConta'] == 'T'){
						$valorAReceber =  $dadosConta['vParcela'] - $dadosContaParcial['registros'] - $dadosContaParcialDesc['registros'];

						$totalAReceber = $totalAReceber + $valorAReceber;					
						$totalDescontos = $totalDescontos + $dadosContaParcialDesc['registros'];					
						$totalRecebido = $totalRecebido + $dadosContaParcial['registros'];					
						$totalDeContas = $totalDeContas + $dadosConta['vParcela'];						
					}

					if($dadosConta['vencimentoConta'] < date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F'){
						$bold = "font-weight:bold;";
					}else{
						$bold = "";
					}
					if($dadosConta['vencimentoConta'] <= date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F'){
						$cor = "color:#FF0000;";
					}else{
						$cor = "";
					}
					
					if($dadosConta['statusConta'] == 'T' && $dadosConta['baixaConta'] == 'F'){
						$cor = "color:#8e8e8e; text-decoration:line-through;";
					}else{
						if($dadosConta['vencimentoConta'] <= date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F'){
							$cor = "color:#FF0000;";
						}else{
							$cor = "";
						}
					}	
?>
										<div id="clientes" style="width:100%; padding-bottom:10px; margin-bottom:10px; border-bottom:1px dashed #000;">
											<p class="nome-cliente" style="width:17.5%; float:left; margin:0; font-family:Arial; font-size:11px; text-align:center;"><?php echo $dadosConta['nomeCliente'];?> <?php echo $dadosConta['sobrenomeCliente'];?></p>
											<p class="nome-cliente" style="width:17.5%; float:left; margin:0; font-family:Arial; font-size:11px; text-align:center;"><?php echo $dadosConta['nomeConta'];?></p>
											<p class="cidade-cliente" style="width:17%; float:left; margin:0; font-family:Arial; font-size:11px; text-align:center;"><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></p>
											<p class="cidade-cliente" style="width:7.5%; float:left; margin:0; font-family:Arial; font-size:11px; text-align:center;"><?php echo $dadosConta['parcelaConta'];?></p>
											<p class="cidade-cliente" style="width:10%; float:left; margin:0; font-family:Arial; font-size:11px; text-align:center;"><?php echo data($dadosConta['vencimentoConta']);?></p>
											<p class="cidade-cliente" style="width:10%; float:left; margin:0; font-family:Arial; font-size:11px; text-align:center;">R$ <?php echo number_format($valorAReceber, 2, ",", ".");?></p>
											<p class="cidade-cliente" style="width:10%; float:left; margin:0; font-family:Arial; font-size:11px; text-align:center;">R$ <?php echo number_format($dadosConta['vParcela'], 2, ",", ".");?></p>
											<p class="cidade-cliente" style="width:10%; float:left; margin:0; font-family:Arial; font-size:11px; text-align:center;"><?php echo $dadosConta['statusConta'] == "T" ? 'Em Aberto' : 'Recebido';?></p>
											<br style="clear:both;"/>
										</div>
<?php
				}
				
				$valorTotalGeralDesconto = 0;

				$sqlContaGeral = "SELECT SUM(C.vParcela) totalConta FROM contas C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and (C.vencimentoConta < '".date('Y-m-d')."' and C.statusConta = 'T'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraStatus2.") or C.baixaConta = 'T' and C.codCliente != ''".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaGeral = $conn->query($sqlContaGeral);
				$dadosContaGeral = $resultContaGeral->fetch_assoc();
				
				$sqlContaGeralReceber = "SELECT SUM(C.vParcela) totalConta FROM contas C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T' and (C.vencimentoConta < '".date('Y-m-d')."' and C.statusConta = 'T'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraStatus2.") or C.baixaConta = 'T' and C.statusConta = 'T' and C.codCliente != ''".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaGeralReceber = $conn->query($sqlContaGeralReceber);
				$dadosContaGeralReceber = $resultContaGeralReceber->fetch_assoc();
					
				$sqlContaParcialDescontoTotal = "SELECT SUM(CP.descontoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaParcialDescontoTotal = $conn->query($sqlContaParcialDescontoTotal);
				$dadosContaParcialDescontoTotal = $resultContaParcialDescontoTotal->fetch_assoc();

				$valorTotalGeralDesconto = $valorTotalGeralDesconto + $dadosContaParcialDescontoTotal['totalConta'];
					
				$sqlContaParcialDescontoAtivo = "SELECT SUM(CP.descontoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T' and (C.vencimentoConta < '".date('Y-m-d')."' and C.statusConta = 'T'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraStatus2.") or C.baixaConta = 'T' and C.statusConta = 'T' and C.codCliente != ''".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaParcialDescontoAtivo = $conn->query($sqlContaParcialDescontoAtivo);
				$dadosContaParcialDescontoAtivo = $resultContaParcialDescontoAtivo->fetch_assoc();
				
				$sqlContaParcialAtivo = "SELECT SUM(CP.valorContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T' and (C.vencimentoConta < '".date('Y-m-d')."' and C.statusConta = 'T'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraStatus2.") or C.baixaConta = 'T' and C.statusConta = 'T' and C.codCliente != ''".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaParcialAtivo = $conn->query($sqlContaParcialAtivo);
				$dadosContaParcialAtivo = $resultContaParcialAtivo->fetch_assoc();
					
				$valorTotalGeralReceber = $dadosContaGeralReceber['totalConta'] - $dadosContaParcialAtivo['totalConta'] - $dadosContaParcialDescontoAtivo['totalConta'];
				
				$sqlContaGeralRecebido = "SELECT SUM(C.vParcela) totalConta FROM contas C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'F'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaGeralRecebido = $conn->query($sqlContaGeralRecebido);
				$dadosContaGeralRecebido = $resultContaGeralRecebido->fetch_assoc();
				
				$sqlContaParcialInativo = "SELECT SUM(CP.valorContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'F'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaParcialInativo = $conn->query($sqlContaParcialInativo);
				$dadosContaParcialInativo = $resultContaParcialInativo->fetch_assoc();	
				
				$valorTotalGeralRecebido = $dadosContaParcialInativo['totalConta'] + $dadosContaParcialAtivo['totalConta'];
?>
										<div id="total" style="width:100%; margin-top:30px; border-top:2px solid #000;">
											<p class="titulo" style="font-weight:bold; font-size:14px; padding-right:15px; padding-top:15px; text-align:right;">Contas a Receber:</p>
											<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:14px;">R$ <?php echo number_format($valorTotalGeralReceber, 2, ",", ".");?></p>
											<p class="titulo" style="font-weight:bold; font-size:14px; padding-right:15px; padding-top:15px; text-align:right;">Total Descontos:</p>
											<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:14px;">R$ <?php echo number_format($valorTotalGeralDesconto, 2, ",", ".");?></p>
											<p class="titulo" style="font-weight:bold; font-size:14px; padding-right:15px; padding-top:15px; text-align:right;">Contas Recebidas:</p>
											<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:14px;">R$ <?php echo number_format($valorTotalGeralRecebido, 2, ",", ".");?></p>
											<p class="titulo" style="font-weight:bold; font-size:14px; padding-right:15px; padding-top:15px; text-align:right;">Total de Contas a Receber:</p>
											<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; padding-bottom:15px; font-size:14px;">R$ <?php echo number_format($dadosContaGeral['totalConta'], 2, ",", ".");?></p>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>				
				<div id="dados-conteudo">
					<div id="consultas">
<?php	
				if($erroConteudo != ""){
?>
						<div class="area-erro">
<?php
					echo $erroConteudo;	
?>
						</div>
<?php
				}

				$sqlConta = "SELECT count(codConta) registros, codConta FROM contas CO inner join clientes C on CO.codCliente = C.codCliente WHERE CO.areaPagamentoConta = 'R' and (CO.vencimentoConta < '".date('Y-m-d')."' and CO.statusConta = 'T'".$filtraContrato.$filtraCliente.$filtraTipo.$filtraStatus.") or CO.codCliente != ''".$filtraContrato.$filtraCliente.$filtraTipo.$filtraDia.$filtraMes.$filtraAno.$filtraStatus."";				
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['codConta'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Cliente</th>
								<th>Descrição</th>
								<th>Tipo Pagamento</th>
								<th>Parcela</th>
								<th>Vencimento</th>
								<th>WhatsApp</th>
								<th>A Receber</th>
								<th>Valor</th>
								<th>Receber</th>
								<th class="canto-dir">Baixa</th>
							</tr>					
<?php
				}
				
				if($url[5] == 1 || $url[5] == ""){
					$pagina = 1;
					$sqlConta = "SELECT CO.*, C.* FROM contas CO inner join clientes C on CO.codCliente = C.codCliente WHERE CO.areaPagamentoConta = 'R' and (CO.vencimentoConta < '".date('Y-m-d')."' and CO.statusConta = 'T'".$filtraContrato.$filtraCliente.$filtraTipo.$filtraStatus.") or CO.codCliente != ''".$filtraContrato.$filtraCliente.$filtraTipo.$filtraDia.$filtraMes.$filtraAno.$filtraStatus." ORDER BY CO.baixaConta ASC, CO.statusConta ASC, CO.vencimentoConta ASC, CO.codConta DESC LIMIT 0,60";
				}else{
					$pagina = $url[5];
					$paginaFinal = $pagina * 60;
					$paginaInicial = $paginaFinal - 60;
					$sqlConta = "SELECT CO.*, C.* FROM contas CO inner join clientes C on CO.codCliente = C.codCliente WHERE CO.areaPagamentoConta = 'R' and (CO.vencimentoConta < '".date('Y-m-d')."' and CO.statusConta = 'T'".$filtraContrato.$filtraCliente.$filtraTipo.$filtraStatus.") or CO.codCliente != ''".$filtraContrato.$filtraCliente.$filtraTipo.$filtraDia.$filtraMes.$filtraAno.$filtraStatus." ORDER BY CO.baixaConta ASC, CO.statusConta ASC, CO.vencimentoConta ASC, CO.codConta DESC LIMIT ".$paginaInicial.",60";
				}		
				
				$resultConta = $conn->query($sqlConta);
				while($dadosConta = $resultConta->fetch_assoc()){
					$mostrando = $mostrando + 1;
					if($dadosConta['statusConta'] == "T" && $dadosConta['baixaConta'] == 'T'){
						$status = "";
						$statusIcone = "ativado";
						$statusPergunta = "desativar";
					}else{
						$status = "-inativo";
						$statusIcone = "desativado";
						$statusPergunta = "ativar";
					}
					
					if($dadosConta['baixaConta'] == "T" && $dadosConta['statusConta'] == 'T'){
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

					$sqlContaAcrescimo = "SELECT SUM(acrescimoContaParcial) registros FROM contasParcial WHERE codConta = ".$dadosConta['codConta']."";
					$resultContaAcrescimo = $conn->query($sqlContaAcrescimo);
					$dadosContaAcrescimo = $resultContaAcrescimo->fetch_assoc();
					
					if($dadosConta['statusConta'] == 'T' && $dadosConta['baixaConta'] == 'T' || $dadosConta['statusConta'] == 'F' && $dadosConta['baixaConta'] == 'T'){
						$valorAReceber =  $dadosConta['vParcela'] - $dadosContaParcial['registros'] - $dadosContaParcialDesc['registros'] + $dadosContaAcrescimo['registros'];

						$totalAReceber = $totalAReceber + $valorAReceber;					
						$totalDescontos = $totalDescontos + $dadosContaParcialDesc['registros'];					
						$totalRecebido = $totalRecebido + $dadosContaParcial['registros'];					
						$totalDeContas = $totalDeContas + $dadosConta['vParcela'];						
					}

					if($dadosConta['vencimentoConta'] < date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F'){
						$bold = "font-weight:bold;";
					}else{
						$bold = "";
					}
					if($dadosConta['vencimentoConta'] <= date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F'){
						$cor = "color:#FF0000;";
					}else{
						$cor = "";
					}
					
					if($dadosConta['statusConta'] == 'T' && $dadosConta['baixaConta'] == 'F'){
						$cor = "color:#8e8e8e; text-decoration:line-through;";
					}else{
						if($dadosConta['vencimentoConta'] <= date('Y-m-d') && $dadosConta['statusConta'] != 'F' && $dadosConta['baixaConta'] != 'F'){
							$cor = "color:#FF0000;";
						}else{
							$cor = "";
						}
					}	

					$limpaCelular = str_replace("(", "", $dadosConta['celularCliente']);
					$limpaCelular = str_replace(")", "", $limpaCelular);
					$limpaCelular = str_replace(" ", "", $limpaCelular);
					$limpaCelular = str_replace("-", "", $limpaCelular);					
?>
							<tr class="tr">
								<td class="vinte" style="width:17%;"><a style="<?php echo $cor;?> <?php echo $bold;?>" href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'><?php echo $dadosConta['nomeCliente'];?> <?php echo $dadosConta['sobrenomeCliente'];?></a></td>
								<td class="vinte" style="width:15%; text-align:center;"><a style="<?php echo $cor;?> <?php echo $bold;?>"  href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'><?php echo $dadosConta['nomeConta'];?></a></td>
								<td class="" style="width:15%; text-align:center;"><a style="<?php echo $cor;?> <?php echo $bold;?>"  href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></a></td>
								<td class="dez" style="text-align:center;"><a style="<?php echo $cor;?> <?php echo $bold;?>"  href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'><?php echo $dadosConta['parcelaConta'];?></a></td>
								<td class="dez" style="text-align:center;"><a style="<?php echo $cor;?> <?php echo $bold;?>"  href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'><?php echo data($dadosConta['vencimentoConta']);?></a></td>
								<td class="dez" style="text-align:center;"><a target="_blank" style="padding:0px; padding-top:4px; padding-bottom:4px; padding-left:30px; background:transparent url('<?php echo $configUrlGer;?>f/i/icon-whats.svg') left center no-repeat; background-size:25px;" href="https://api.whatsapp.com/send?1=pt_BR&phone=55<?php echo $limpaCelular;?>" title='Veja os detalhes da inscrição do <?php echo $dadosInscricaos['nomeInscricao'] ?>'><?php echo $dadosConta['celularCliente'];?></a></td>								
								<td class="dez" style="text-align:center;"><a style="<?php echo $cor;?> <?php echo $bold;?>"  href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'>R$ <?php echo number_format($valorAReceber, 2, ",", ".");?></a></td>
								<td class="dez" style="text-align:center;"><a style="<?php echo $cor;?> <?php echo $bold;?>"  href='<?php echo $configUrlGer; ?>financeiro/contas-receber/alterar/<?php echo $dadosConta['codConta'] ?>/' title='Veja os detalhes da conta receber <?php echo $dadosConta['nomeConta'] ?>'>R$ <?php echo number_format($dadosConta['vParcela'], 2, ",", ".");?></a></td>
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
					
					if($dadosConta['baixaConta'] == "T" && $dadosConta['statusConta'] == "T"){
?>
								<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>financeiro/contas-receber/baixa/<?php echo $dadosConta['codConta'];?>/' title='Deseja <?php echo $statusPergunta;?> na mensalidade do cliente <?php echo $dadosConta['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/icone<?php echo $baixa;?>" alt="icone" /></a></td>
<?php
					}else{
?>
								<td class="botoes" style="padding:0px;"><img style="margin-left:5px;" src="<?php echo $configUrl;?>f/i/icone<?php echo $baixa;?>" alt="icone" /></td>
<?php
					}
?>
							</tr>
<?php
				}
?>
							<script>
								 function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir a a conta receber "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>financeiro/contas-receber/excluir/'+cod+'/';
									}
								  }
							 
									function executaForm(cod){
										document.getElementById("manda-cod").value=cod;
										var pegaValue = document.getElementById("conta"+cod).value;
										document.getElementById("manda-conta").value=pegaValue;
										document.getElementById("form").submit();
									}
							</script>
							<style>
								.swal2-icon {
									border-color: #FFF;
								}
							</style>
							<script>
								function chamaBoleto(cod, codCliente, boletos) {
									const cancelButtonText = boletos >= 1 ? 'Segunda Via' : 'Fechar';
									Swal.fire({
										title: 'Escolha uma opção',
										text: 'O que deseja fazer?',
										iconHtml: `<img src="<?php echo $configUrlGer; ?>f/i/boleto.svg" alt="Ícone de Boleto" style="width:80px; height:80px;">`,
										showCancelButton: true,
										confirmButtonText: 'Gerar Boleto',
										cancelButtonText: cancelButtonText,
										customClass: {
											icon: '',
										},
									}).then((result) => {
										if (result.isConfirmed) {
											verificarCampos(codCliente).then((resposta) => {
												if (resposta.status === 'success') {
													gerarBoletoLoading(cod, codCliente, boletos);
												} else if (resposta.status === 'error') {
													const missingFields = resposta.missing_fields.join(', ');
													Swal.fire({
														title: 'Campos em Falta',
														text: `Os seguintes campos do cliente não estão preenchidos: ${missingFields}`,
														icon: 'warning',
														confirmButtonText: 'OK'
													});
												} else {
													Swal.fire({
														title: 'Erro!',
														text: 'Cliente não encontrado.',
														icon: 'error',
														confirmButtonText: 'OK'
													});
												}
											}).catch(() => {
												Swal.fire({
													title: 'Erro!',
													text: 'Não foi possível verificar os campos obrigatórios.',
													icon: 'error',
													confirmButtonText: 'OK'
												});
											});
										} else if (result.dismiss === Swal.DismissReason.cancel) {
											if (boletos >= 1) {
												// Buscar segunda via
												buscarSegundaViaBoleto(cod);
											} else {
												Swal.close();
											}
										}
									});
								}

								function buscarSegundaViaBoleto(codConta) {
									Swal.fire({
										title: 'Buscando Segunda Via...',
										text: 'Aguarde um momento.',
										icon: 'info',
										allowOutsideClick: false,
										showConfirmButton: false,
										willOpen: () => {
											Swal.showLoading();
										}
									});

									// Fazer a requisição para o arquivo que gera a segunda via do boleto
									fetch('<?php echo $configUrlGer;?>financeiro/contas-receber/segunda-via.php', {
										method: 'POST',
										headers: { 'Content-Type': 'application/json' },
										body: JSON.stringify({ codConta: codConta })
									})
									.then(response => response.json())
									.then(data => {
										Swal.close();
										if (data.status === 'success') {
											// Sucesso, exibe o link para a segunda via
											Swal.fire({
												title: 'Segunda Via Gerada!',
												text: 'Clique no link abaixo para baixar sua segunda via.',
												icon: 'success',
												confirmButtonText: 'Baixar Boleto',
											}).then(() => {
												// Iniciar o download da segunda via do boleto
												const link = document.createElement('a');
												link.href = "<?php echo $configUrlGer;?>f/boletos/" + data.boletoUrl;
												link.download = data.boletoUrl.split('/').pop(); // Nome do arquivo
												link.click();
											});
										} else {
											Swal.fire({
												title: 'Erro!',
												text: data.message || 'Não foi possível gerar a segunda via.',
												icon: 'error',
												confirmButtonText: 'Tentar novamente'
											});
										}
									})
									.catch(error => {
										Swal.close();
										Swal.fire({
											title: 'Erro!',
											text: 'Ocorreu um erro ao buscar a segunda via. Tente novamente.',
											icon: 'error',
											confirmButtonText: 'OK'
										});
									});
								}

								function verificarCampos(codCliente) {
									return fetch('<?php echo $configUrlGer;?>financeiro/contas-receber/validar-campos.php', {
										method: 'POST',
										headers: {
											'Content-Type': 'application/x-www-form-urlencoded'
										},
										body: `codCliente=${encodeURIComponent(codCliente)}`
									}).then(response => response.json());
								}

								function gerarBoletoLoading(cod, codCliente, boletos) {
									Swal.fire({
										title: 'Gerando Boleto...',
										text: 'Por favor, aguarde.',
										icon: 'info',
										allowOutsideClick: false,
										showConfirmButton: false,
										willOpen: () => {
											Swal.showLoading();
										}
									});

									gerarBoleto(cod).then((arquivo) => {
										Swal.fire({
											title: 'Sucesso!',
											text: 'Boleto gerado com sucesso.',
											icon: 'success',
											confirmButtonText: 'Baixar Boleto'
										}).then(() => {
											// Iniciar o download do arquivo
											const link = document.createElement('a');
											link.href = "<?php echo $configUrlGer;?>f/boletos/" + arquivo;
											link.download = arquivo.split('/').pop(); // Nome do arquivo
											link.click();
										});
									}).catch((error) => {
										Swal.fire({
											title: 'Erro!',
											text: error || 'Ocorreu um problema ao gerar o boleto.',
											icon: 'error',
											confirmButtonText: 'Tentar novamente'
										}).then(() => {
											chamaBoleto(cod, codCliente, boletos); // Chama novamente a função buscarSegundaVia
										});
									});
								}

								function gerarBoleto(cod) {
									return new Promise((resolve, reject) => {
										fetch('<?php echo $configUrlGer;?>financeiro/contas-receber/boleto.php', {
											method: 'POST',
											headers: { 'Content-Type': 'application/json' },
											body: JSON.stringify({ codConta: cod })
										})
										.then(response => response.json())
										.then(data => {
											if (data.status === 'success') {
												resolve(data.boletoUrl); // Retorna a URL do arquivo
											} else {
												reject(data.message); // Retorna a mensagem de erro
											}
										})
										.catch(error => {
											reject('Erro na requisição. Verifique sua conexão ou tente novamente.');
										});
									});
								}
							</script>
							<form id="form" action="<?php echo $configUrl;?>financeiro/contas-receber/" method="post">	
								<input type="hidden" value="" id="manda-cod" name="cod"/>
								<input type="hidden" value="" id="manda-conta" name="conta"/>
							</form>								  
						</table>
<?php
				$valorTotalGeralDesconto = 0;
				$valorTotalGeralAcrescimo = 0;
				$valorTotalGeralReceber = 0;
				$valorTotalGeralRecebido = 0;

				$sqlContaGeral = "SELECT SUM(C.vParcela) totalConta FROM contas C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T'";
				$resultContaGeral = $conn->query($sqlContaGeral);
				$dadosContaGeral = $resultContaGeral->fetch_assoc();
				
				$sqlContaGeralReceber = "SELECT SUM(C.vParcela) totalConta FROM contas C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T'";
				$resultContaGeralReceber = $conn->query($sqlContaGeralReceber);
				$dadosContaGeralReceber = $resultContaGeralReceber->fetch_assoc();
					
				$sqlContaParcialDescontoTotal = "SELECT SUM(CP.descontoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R'";
				$resultContaParcialDescontoTotal = $conn->query($sqlContaParcialDescontoTotal);
				$dadosContaParcialDescontoTotal = $resultContaParcialDescontoTotal->fetch_assoc();

				$valorTotalGeralDesconto = $valorTotalGeralDesconto + $dadosContaParcialDescontoTotal['totalConta'];

				$sqlContaParcialAcrescimoTotal = "SELECT SUM(CP.acrescimoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE C.areaPagamentoConta = 'R'";
				$resultContaParcialAcrescimoTotal = $conn->query($sqlContaParcialAcrescimoTotal);
				$dadosContaParcialAcrescimoTotal = $resultContaParcialAcrescimoTotal->fetch_assoc();

				$valorTotalGeralAcrescimo = $valorTotalGeralAcrescimo + $dadosContaParcialAcrescimoTotal['totalConta'];
									
				$sqlContaParcialDescontoAtivo = "SELECT SUM(CP.descontoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T'";
				$resultContaParcialDescontoAtivo = $conn->query($sqlContaParcialDescontoAtivo);
				$dadosContaParcialDescontoAtivo = $resultContaParcialDescontoAtivo->fetch_assoc();

				$sqlContaParcialAcrescimoAtivo = "SELECT SUM(CP.acrescimoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T'";
				$resultContaParcialAcrescimoAtivo = $conn->query($sqlContaParcialAcrescimoAtivo);
				$dadosContaParcialAcrescimoAtivo = $resultContaParcialAcrescimoAtivo->fetch_assoc();
								
				$sqlContaParcialAtivo = "SELECT SUM(CP.valorContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T'";
				$resultContaParcialAtivo = $conn->query($sqlContaParcialAtivo);
				$dadosContaParcialAtivo = $resultContaParcialAtivo->fetch_assoc();
					
				$valorTotalGeralReceber = $dadosContaGeralReceber['totalConta'] - $dadosContaParcialAtivo['totalConta'] - $dadosContaParcialDescontoAtivo['totalConta'] + $dadosContaParcialAcrescimoAtivo['totalConta'];
				
				$sqlContaGeralRecebido = "SELECT SUM(C.vParcela) totalConta FROM contas C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'F'";
				$resultContaGeralRecebido = $conn->query($sqlContaGeralRecebido);
				$dadosContaGeralRecebido = $resultContaGeralRecebido->fetch_assoc();
				
				$sqlContaParcialInativo = "SELECT SUM(CP.valorContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'F'";
				$resultContaParcialInativo = $conn->query($sqlContaParcialInativo);
				$dadosContaParcialInativo = $resultContaParcialInativo->fetch_assoc();	
				
				$valorTotalGeralRecebido = $valorTotalGeralRecebido + $dadosContaParcialInativo['totalConta'] + $dadosContaParcialAtivo['totalConta'];
				$valorGeral = $dadosContaGeral['totalConta'] - $dadosContaParcialDescontoTotal['totalConta'] + $dadosContaParcialAcrescimoTotal['totalConta'];
?>					
						<div id="total" style="width:50%; float:left; margin-top:20px; background-color:#f5f5f5;">
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-left:15px; padding-top:15px; text-align:left;">Total Contas Recebíveis Geral:</p>
							<p class="total" style="text-align:left; padding-left:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($dadosContaGeral['totalConta'], 2, ",", ".");?></p>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-left:15px; padding-top:15px;">Contas a Receber Geral:</p>
							<p class="total" style="padding-left:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($valorTotalGeralReceber, 2, ",", ".");?></p>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-left:15px; padding-top:15px;">Total Descontos Geral:</p>
							<p class="total" style="padding-left:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($valorTotalGeralDesconto, 2, ",", ".");?></p>							
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-left:15px; padding-top:15px;">Total Acréscimos Geral:</p>
							<p class="total" style="padding-left:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($valorTotalGeralAcrescimo, 2, ",", ".");?></p>							
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-left:15px; padding-top:15px;">Contas Recebidas Geral:</p>
							<p class="total" style="padding-left:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($valorTotalGeralRecebido, 2, ",", ".");?></p>							
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-left:15px; padding-top:20px;">Total de Contas a Receber Geral:</p>
							<p class="total" style="padding-left:15px; padding-top:5px; padding-bottom:15px; font-size:16px;">R$ <?php echo number_format($valorGeral, 2, ",", ".");?></p>
						</div>
<?php
				$valorTotalGeralDesconto = 0;
				$valorTotalGeralAcrescimo = 0;
				$valorTotalGeralReceber = 0;
				$valorTotalGeralRecebido = 0;
				
				$sqlContaGeral = "SELECT SUM(C.vParcela) totalConta FROM contas C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and (C.vencimentoConta < '".date('Y-m-d')."' and C.statusConta = 'T'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraStatus2.") or C.baixaConta = 'T' and C.codCliente != ''".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaGeral = $conn->query($sqlContaGeral);
				$dadosContaGeral = $resultContaGeral->fetch_assoc();
				
				$sqlContaGeralReceber = "SELECT SUM(C.vParcela) totalConta FROM contas C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T' and (C.vencimentoConta < '".date('Y-m-d')."' and C.statusConta = 'T'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraStatus2.") or C.baixaConta = 'T' and C.statusConta = 'T' and C.codCliente != ''".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaGeralReceber = $conn->query($sqlContaGeralReceber);
				$dadosContaGeralReceber = $resultContaGeralReceber->fetch_assoc();
					
				$sqlContaParcialDescontoTotal = "SELECT SUM(CP.descontoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaParcialDescontoTotal = $conn->query($sqlContaParcialDescontoTotal);
				$dadosContaParcialDescontoTotal = $resultContaParcialDescontoTotal->fetch_assoc();

				$valorTotalGeralDesconto = $valorTotalGeralDesconto + $dadosContaParcialDescontoTotal['totalConta'];

				$sqlContaParcialAcrescimoTotal = "SELECT SUM(CP.acrescimoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R'".$filtraCliente2.$filtraTipo2.$filtraData12.$filtroData22.$filtraStatus2."";
				$resultContaParcialAcrescimoTotal = $conn->query($sqlContaParcialAcrescimoTotal);
				$dadosContaParcialAcrescimoTotal = $resultContaParcialAcrescimoTotal->fetch_assoc();

				$valorTotalGeralAcrescimo = $valorTotalGeralAcrescimo + $dadosContaParcialAcrescimoTotal['totalConta'];
									
				$sqlContaParcialDescontoAtivo = "SELECT SUM(CP.descontoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T' and (C.vencimentoConta < '".date('Y-m-d')."' and C.statusConta = 'T'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraStatus2.") or C.baixaConta = 'T' and C.statusConta = 'T' and C.codCliente != ''".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaParcialDescontoAtivo = $conn->query($sqlContaParcialDescontoAtivo);
				$dadosContaParcialDescontoAtivo = $resultContaParcialDescontoAtivo->fetch_assoc();

				$sqlContaParcialAcrescimoAtivo = "SELECT SUM(CP.acrescimoContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T' and (C.vencimentoConta < '".date('Y-m-d')."' and C.statusConta = 'T'".$filtraExcluir2.$filtraCliente2.$filtraTipo2.$filtraStatus2.") or C.baixaConta = 'T' and C.statusConta = 'T' and C.codCliente != ''".$filtraCliente2.$filtraTipo2.$filtraData12.$filtraData22.$filtraStatus2."";
				$resultContaParcialAcrescimoAtivo = $conn->query($sqlContaParcialAcrescimoAtivo);
				$dadosContaParcialAcrescimoAtivo = $resultContaParcialAcrescimoAtivo->fetch_assoc();
				
				$sqlContaParcialAtivo = "SELECT SUM(CP.valorContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'T' and (C.vencimentoConta < '".date('Y-m-d')."' and C.statusConta = 'T'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraStatus2.") or C.baixaConta = 'T' and C.statusConta = 'T' and C.codCliente != ''".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaParcialAtivo = $conn->query($sqlContaParcialAtivo);
				$dadosContaParcialAtivo = $resultContaParcialAtivo->fetch_assoc();
					
				$valorTotalGeralReceber = $dadosContaGeralReceber['totalConta'] - $dadosContaParcialAtivo['totalConta'] - $dadosContaParcialDescontoAtivo['totalConta'] - $dadosContaParcialAcrescimoAtivo['totalConta'];
				
				$sqlContaGeralRecebido = "SELECT SUM(C.vParcela) totalConta FROM contas C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'F'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaGeralRecebido = $conn->query($sqlContaGeralRecebido);
				$dadosContaGeralRecebido = $resultContaGeralRecebido->fetch_assoc();
				
				$sqlContaParcialInativo = "SELECT SUM(CP.valorContaParcial) totalConta FROM contasParcial CP inner join contas C on CP.codConta = C.codConta inner join clientes CL on C.codCliente = CL.codCliente WHERE C.areaPagamentoConta = 'R' and C.baixaConta = 'T' and C.statusConta = 'F'".$filtraContrato2.$filtraCliente2.$filtraTipo2.$filtraDia.$filtraMes.$filtraAno.$filtraStatus2."";
				$resultContaParcialInativo = $conn->query($sqlContaParcialInativo);
				$dadosContaParcialInativo = $resultContaParcialInativo->fetch_assoc();	
				
				$valorTotalGeralRecebido = $dadosContaParcialInativo['totalConta'] + $dadosContaParcialAtivo['totalConta'];

				$valorGeral = $dadosContaGeral['totalConta'] - $dadosContaParcialDescontoTotal['totalConta'] + $dadosContaParcialAcrescimoTotal['totalConta'];								
?>
						<div id="total" style="background-color:#f5f5f5; margin-top:20px; width:100%;">
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total Contas Recebíveis Filtro:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($dadosContaGeral['totalConta'], 2, ",", ".");?></p>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Contas a Receber Filtro:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($valorTotalGeralReceber, 2, ",", ".");?></p>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total Descontos Filtro:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($valorTotalGeralDesconto, 2, ",", ".");?></p>							
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Total Acréscimo Filtro:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($valorTotalGeralAcrescimo, 2, ",", ".");?></p>							
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:15px; text-align:right;">Contas Recebidas Filtro:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; font-size:16px;">R$ <?php echo number_format($valorTotalGeralRecebido, 2, ",", ".");?></p>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; padding-top:20px; text-align:right;">Total de Contas a Receber Filtro:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; padding-bottom:15px; font-size:16px;">R$ <?php echo number_format($valorGeral, 2, ",", ".");?></p>
						</div>
<?php
				$regPorPagina = 60;
				$area = "financeiro/contas-receber";
				include ('f/conf/paginacao.php');	
				
				if($_POST['codVenda'] != ""){
?>
						<script>
							setTimeout('calculosConta()', 0);
							setTimeout('calculosConta()', 1000);
						</script>
<?php					
				}	
	
?>		
					</div>
				</div>
<?php
					if($_POST['codContrato'] != ""){
						$_SESSION['cod-contrato'] = $_POST['codContrato'];
						$_SESSION['clientes'] = $_POST['nomeCliente'];
						$_SESSION['nome'] = "";
						$_SESSION['tipo'] = "";
						$_SESSION['vencimento'] = "";
						$_SESSION['parcela'] = "";
						$_SESSION['tipo-pagamento'] = "";
						$_SESSION['formaPagamento'] = "";
						$_SESSION['total'] = number_format($_POST['valorVenda'], 2, ",", ".");
						$_SESSION['imovel'] = number_format(trim($_POST['valorVenda']), 2, ",", ".");
						$_SESSION['entrada'] = "";
						$_SESSION['desconto'] = "";
						$_SESSION['acrescimo'] = "";
						$_SESSION['Vparcela'] = "";
						$display = "block";						
					}
					
					echo "<script> calculosConta(); </script>";						
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
