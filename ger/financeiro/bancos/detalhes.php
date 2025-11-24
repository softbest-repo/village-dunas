<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){
		
		if(controleUsuario($conn) == "tem usuario"){
		
			$area = "bancos";
			if(validaAcesso($conn, $area) == "ok"){
							
				if(isset($_POST['mes-filtro-contas'])){
					$_SESSION['dia-filtro-contas'] = $_POST['dia-filtro-contas'];
					$_SESSION['mes-filtro-contas'] = $_POST['mes-filtro-contas'];
					$_SESSION['ano-filtro-contas'] = $_POST['ano-filtro-contas'];
				}	

				if($_SESSION['dia-filtro-contas'] == ""){
					$_SESSION['dia-filtro-contas'] = "";
				}

				if($_SESSION['mes-filtro-contas'] == ""){
					$_SESSION['mes-filtro-contas'] = date('m');
				}
				if($_SESSION['ano-filtro-contas'] == ""){
					$_SESSION['ano-filtro-contas'] = date('Y');
				}
				
				if($_SESSION['dia-filtro-contas'] != "" && $_SESSION['dia-filtro-contas'] != "T"){
					$filtraDia = " and date_format(CP.dataContaParcial, '%d') = '".$_SESSION['dia-filtro-contas']."'";
				}
				
				if($_SESSION['mes-filtro-contas'] != "" && $_SESSION['mes-filtro-contas'] != "T"){
					$filtraMes = " and date_format(CP.dataContaParcial, '%m') = '".$_SESSION['mes-filtro-contas']."'";
				}
				if($_SESSION['ano-filtro-contas'] != "" && $_SESSION['ano-filtro-contas'] != "T"){
					$filtraAno = " and date_format(CP.dataContaParcial, '%Y') = '".$_SESSION['ano-filtro-contas']."'";
				}						
				
				$sqlBanco = "SELECT * FROM bancos WHERE codBanco = ".$url[6]." LIMIT 0,1";
				$resultBanco = $conn->query($sqlBanco);
				$dadosBanco = $resultBanco->fetch_assoc();
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Contas</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosBanco['nomeBanco'];?></p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
					<div id="formulario-filtro">
						<script>
							function enviar(){
								document.filtro.submit(); 
							}
						</script>
						<form name="filtro" action="<?php echo $configUrl;?>financeiro/bancos/detalhes/<?php echo $url[6];?>/" method="post" >																																	
							<p><label class="label">Dia:</label>
								<select class="campo" id="default-usage-select2" name="dia-filtro-contas" style="width:50px; margin-right:0px;">
									<option value="" <?php echo $_SESSION['dia-filtro-contas'] == '' ? '/SELECTED/' : '';?>>*</option>
									<option value="1" <?php echo $_SESSION['dia-filtro-contas'] == '1' ? '/SELECTED/' : '';?>>1</option>
									<option value="2" <?php echo $_SESSION['dia-filtro-contas'] == '2' ? '/SELECTED/' : '';?>>2</option>
									<option value="3" <?php echo $_SESSION['dia-filtro-contas'] == '3' ? '/SELECTED/' : '';?>>3</option>
									<option value="4" <?php echo $_SESSION['dia-filtro-contas'] == '4' ? '/SELECTED/' : '';?>>4</option>
									<option value="5" <?php echo $_SESSION['dia-filtro-contas'] == '5' ? '/SELECTED/' : '';?>>5</option>
									<option value="6" <?php echo $_SESSION['dia-filtro-contas'] == '6' ? '/SELECTED/' : '';?>>6</option>
									<option value="7" <?php echo $_SESSION['dia-filtro-contas'] == '7' ? '/SELECTED/' : '';?>>7</option>
									<option value="8" <?php echo $_SESSION['dia-filtro-contas'] == '8' ? '/SELECTED/' : '';?>>8</option>
									<option value="9" <?php echo $_SESSION['dia-filtro-contas'] == '9' ? '/SELECTED/' : '';?>>9</option>
									<option value="10" <?php echo $_SESSION['dia-filtro-contas'] == '10' ? '/SELECTED/' : '';?>>10</option>
									<option value="11" <?php echo $_SESSION['dia-filtro-contas'] == '11' ? '/SELECTED/' : '';?>>11</option>
									<option value="12" <?php echo $_SESSION['dia-filtro-contas'] == '12' ? '/SELECTED/' : '';?>>12</option>
									<option value="13" <?php echo $_SESSION['dia-filtro-contas'] == '13' ? '/SELECTED/' : '';?>>13</option>
									<option value="14" <?php echo $_SESSION['dia-filtro-contas'] == '14' ? '/SELECTED/' : '';?>>14</option>
									<option value="15" <?php echo $_SESSION['dia-filtro-contas'] == '15' ? '/SELECTED/' : '';?>>15</option>
									<option value="16" <?php echo $_SESSION['dia-filtro-contas'] == '16' ? '/SELECTED/' : '';?>>16</option>
									<option value="17" <?php echo $_SESSION['dia-filtro-contas'] == '17' ? '/SELECTED/' : '';?>>17</option>
									<option value="18" <?php echo $_SESSION['dia-filtro-contas'] == '18' ? '/SELECTED/' : '';?>>18</option>
									<option value="19" <?php echo $_SESSION['dia-filtro-contas'] == '19' ? '/SELECTED/' : '';?>>19</option>
									<option value="20" <?php echo $_SESSION['dia-filtro-contas'] == '20' ? '/SELECTED/' : '';?>>20</option>
									<option value="21" <?php echo $_SESSION['dia-filtro-contas'] == '21' ? '/SELECTED/' : '';?>>21</option>
									<option value="22" <?php echo $_SESSION['dia-filtro-contas'] == '22' ? '/SELECTED/' : '';?>>22</option>
									<option value="23" <?php echo $_SESSION['dia-filtro-contas'] == '23' ? '/SELECTED/' : '';?>>23</option>
									<option value="24" <?php echo $_SESSION['dia-filtro-contas'] == '24' ? '/SELECTED/' : '';?>>24</option>
									<option value="25" <?php echo $_SESSION['dia-filtro-contas'] == '25' ? '/SELECTED/' : '';?>>25</option>
									<option value="26" <?php echo $_SESSION['dia-filtro-contas'] == '26' ? '/SELECTED/' : '';?>>26</option>
									<option value="27" <?php echo $_SESSION['dia-filtro-contas'] == '27' ? '/SELECTED/' : '';?>>27</option>
									<option value="28" <?php echo $_SESSION['dia-filtro-contas'] == '28' ? '/SELECTED/' : '';?>>28</option>
									<option value="29" <?php echo $_SESSION['dia-filtro-contas'] == '29' ? '/SELECTED/' : '';?>>29</option>
									<option value="30" <?php echo $_SESSION['dia-filtro-contas'] == '30' ? '/SELECTED/' : '';?>>30</option>
									<option value="31" <?php echo $_SESSION['dia-filtro-contas'] == '31' ? '/SELECTED/' : '';?>>31</option>
								</select>
							</p>
							<p><label class="label">Mês:</label>
								<select class="campo" id="default-usage-select2" name="mes-filtro-contas" style="width:105px; margin-right:0px;">
									<option value="01" <?php echo $_SESSION['mes-filtro-contas'] == '01' ? '/SELECTED/' : '';?>>Janeiro</option>
									<option value="02" <?php echo $_SESSION['mes-filtro-contas'] == '02' ? '/SELECTED/' : '';?>>Fevereiro</option>
									<option value="03" <?php echo $_SESSION['mes-filtro-contas'] == '03' ? '/SELECTED/' : '';?>>Março</option>
									<option value="04" <?php echo $_SESSION['mes-filtro-contas'] == '04' ? '/SELECTED/' : '';?>>Abril</option>
									<option value="05" <?php echo $_SESSION['mes-filtro-contas'] == '05' ? '/SELECTED/' : '';?>>Maio</option>
									<option value="06" <?php echo $_SESSION['mes-filtro-contas'] == '06' ? '/SELECTED/' : '';?>>Junho</option>
									<option value="07" <?php echo $_SESSION['mes-filtro-contas'] == '07' ? '/SELECTED/' : '';?>>Julho</option>
									<option value="08" <?php echo $_SESSION['mes-filtro-contas'] == '08' ? '/SELECTED/' : '';?>>Agosto</option>
									<option value="09" <?php echo $_SESSION['mes-filtro-contas'] == '09' ? '/SELECTED/' : '';?>>Setembro</option>
									<option value="10" <?php echo $_SESSION['mes-filtro-contas'] == '10' ? '/SELECTED/' : '';?>>Outubro</option>
									<option value="11" <?php echo $_SESSION['mes-filtro-contas'] == '11' ? '/SELECTED/' : '';?>>Novembro</option>
									<option value="12" <?php echo $_SESSION['mes-filtro-contas'] == '12' ? '/SELECTED/' : '';?>>Dezembro</option>
								</select>
							</p>
							<p><label class="label">Ano:</label>
								<select class="campo" id="default-usage-select3" name="ano-filtro-contas" style="width:80px; margin-right:0px;">
									<option value="2011" <?php echo $_SESSION['ano-filtro-contas'] == '2011' ? '/SELECTED/' : '';?>>2011</option>
									<option value="2012" <?php echo $_SESSION['ano-filtro-contas'] == '2012' ? '/SELECTED/' : '';?>>2012</option>
									<option value="2013" <?php echo $_SESSION['ano-filtro-contas'] == '2013' ? '/SELECTED/' : '';?>>2013</option>
									<option value="2014" <?php echo $_SESSION['ano-filtro-contas'] == '2014' ? '/SELECTED/' : '';?>>2014</option>
									<option value="2015" <?php echo $_SESSION['ano-filtro-contas'] == '2015' ? '/SELECTED/' : '';?>>2015</option>
									<option value="2016" <?php echo $_SESSION['ano-filtro-contas'] == '2016' ? '/SELECTED/' : '';?>>2016</option>
									<option value="2017" <?php echo $_SESSION['ano-filtro-contas'] == '2017' ? '/SELECTED/' : '';?>>2017</option>
									<option value="2018" <?php echo $_SESSION['ano-filtro-contas'] == '2018' ? '/SELECTED/' : '';?>>2018</option>
									<option value="2019" <?php echo $_SESSION['ano-filtro-contas'] == '2019' ? '/SELECTED/' : '';?>>2019</option>
									<option value="2020" <?php echo $_SESSION['ano-filtro-contas'] == '2020' ? '/SELECTED/' : '';?>>2020</option>
									<option value="2021" <?php echo $_SESSION['ano-filtro-contas'] == '2021' ? '/SELECTED/' : '';?>>2021</option>
									<option value="2022" <?php echo $_SESSION['ano-filtro-contas'] == '2022' ? '/SELECTED/' : '';?>>2022</option>
									<option value="2023" <?php echo $_SESSION['ano-filtro-contas'] == '2023' ? '/SELECTED/' : '';?>>2023</option>
									<option value="2024" <?php echo $_SESSION['ano-filtro-contas'] == '2024' ? '/SELECTED/' : '';?>>2024</option>
									<option value="2025" <?php echo $_SESSION['ano-filtro-contas'] == '2025' ? '/SELECTED/' : '';?>>2025</option>
									<option value="2026" <?php echo $_SESSION['ano-filtro-contas'] == '2026' ? '/SELECTED/' : '';?>>2026</option>
									<option value="2027" <?php echo $_SESSION['ano-filtro-contas'] == '2027' ? '/SELECTED/' : '';?>>2027</option>
									<option value="2028" <?php echo $_SESSION['ano-filtro-contas'] == '2028' ? '/SELECTED/' : '';?>>2028</option>
									<option value="2029" <?php echo $_SESSION['ano-filtro-contas'] == '2029' ? '/SELECTED/' : '';?>>2029</option>
									<option value="2030" <?php echo $_SESSION['ano-filtro-contas'] == '2030' ? '/SELECTED/' : '';?>>2030</option>
								</select>
							</p>
																					
							<p class="botao-filtrar" style="margin-top:18px;"><input type="button" name="filtrar" value="Filtrar" onClick="enviar()" /></p>
							<div class="botao-consultar" style="margin-top:18px; float:left; margin-bottom:5px; margin-left:0px;"><a title="Consultar Contas" href="<?php echo $configUrl;?>financeiro/bancos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>												

							<p style="float:right; margin-right:5px; margin-top:15px; cursor:pointer;" onClick="abrirImprimir();"><img src="<?php echo $configUrl;?>f/i/icones-imprimir2.gif" width="50"/></p>											

							<br class="clear" />
						</form>
					</div>
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
								<div id="topo-requisicao" style="width:800px;">	
									<p style="display:table; margin:0 auto;"><img src="<?php echo $configUrlGer;?>f/i/comp.png" height="80"/></p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:10px;">
									<div id="mostra-dados" style="width:100%;">
<?php
				$dia = "";
				$mes = "";
				$ano = "";
				
				if($_SESSION['dia-filtro-contas'] != ""){
					$dia = $_SESSION['dia-filtro-contas']." de ";
				}
				
				$months = [
					1 => "Janeiro",
					2 => "Fevereiro",
					3 => "Março",
					4 => "Abril",
					5 => "Maio",
					6 => "Junho",
					7 => "Julho",
					8 => "Agosto",
					9 => "Setembro",
					10 => "Outubro",
					11 => "Novembro",
					12 => "Dezembro"
				];
				
				$monthNumber = ltrim($_SESSION['mes-filtro-contas'], '0');

				$mes = $months[(int)$monthNumber] ?? "Mês inválido";
				
				$ano = $_SESSION['ano-filtro-contas'];
?>
										<p style="padding:0; margin:0; font-size:18px; font-weight:bold; text-align:center; text-decoration:underline; font-family:Arial; margin-bottom:20px;"><?php echo $dia.$mes;?> / <?php echo $ano;?> - <?php echo $dadosBanco['nomeBanco'];?></p>
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Cliente / Fornecedor</p>
											<p style="width:17%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Nome</p>
											<p style="width:16%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Tipo</p>
											<p style="width:7%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Data</p>
											<p style="width:12%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Tipo Pagamento</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:12px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Valor</p>
											<br style="clear:both;"/>
										</div>
<?php
							if($_SESSION['dia-filtro-contas'] != ""){
								if($_SESSION['dia-filtro-contas'] == "1"){
									if($_SESSION['mes-filtro-contas'] == "01"){
										$mes = "12";
										$diminuiAno = $_SESSION['ano-filtro-contas'] - 01;
										$ano = $diminuiAno;
									}else{
										$diminuiMes = $_SESSION['mes-filtro-contas'] - 01;
										$mes = $diminuiMes;
										$ano = $_SESSION['ano-filtro-contas'];
									}
								
									$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); // Retorna 31						
								}else{
									$dia = $_SESSION['dia-filtro-contas'] - 1;
									$mes = $_SESSION['mes-filtro-contas'];
									$ano = $_SESSION['ano-filtro-contas'];
								}
							}else{
								if($_SESSION['mes-filtro-contas'] == "01"){
									$mes = "12";
									$diminuiAno = $_SESSION['ano-filtro-contas'] - 01;
									$ano = $diminuiAno;
								}else{
									$diminuiMes = $_SESSION['mes-filtro-contas'] - 01;
									$mes = $diminuiMes;
									$ano = $_SESSION['ano-filtro-contas'];
								}

								$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); // Retorna 31						
							}
							
							$filtroAnterior = $ano."-".$mes."-".$dia;
											
							$sqlSomaR = "SELECT SUM(CP.valorContaParcial) total FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE CP.contaPagamentoConta = ".$dadosBanco['codBanco']." and C.areaPagamentoConta = 'R' and CP.dataContaParcial <= '".$filtroAnterior."'";
							$resultSomaR = $conn->query($sqlSomaR);
							$dadosSomaR = $resultSomaR->fetch_assoc();
								
							$sqlSomaP = "SELECT SUM(CP.valorContaParcial) total FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE CP.contaPagamentoConta = ".$dadosBanco['codBanco']." and C.areaPagamentoConta = 'P' and CP.dataContaParcial <= '".$filtroAnterior."'";
							$resultSomaP = $conn->query($sqlSomaP);
							$dadosSomaP = $resultSomaP->fetch_assoc();
							
							$saldoDia = $dadosSomaR['total'] - $dadosSomaP['total'];

							if($saldoDia <= 0){
								$cor = "color:#FF0000;";
							}else{
								$cor = "color:#030AB0;";
							}
?>
										<div id="clientes" style="width:100%; margin-bottom:10px; padding-top:8px; padding-bottom:8px; border-bottom:2px solid #000; border-top:2px solid #000;">
											<p style="width:69%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $cor;?>">--</p>
											<p style="width:13.7%; float:left; margin:0; font-size:13px; text-align:center; font-family:Arial; font-weight:bold; <?php echo $cor;?>">Saldo Anterior</p>
											<p style="width:17%; float:left; margin:0; font-size:13px; text-align:center; font-family:Arial; font-weight:bold; <?php echo $cor;?>">R$ <?php echo number_format($saldoDia, 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php							
							$_SESSION['data'] = "";
							
							$sqlContas = "SELECT CP.*, C.* FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE CP.contaPagamentoConta = ".$dadosBanco['codBanco']."".$filtraDia.$filtraMes.$filtraAno." ORDER BY CP.dataContaParcial ASC, CP.horarioContaParcial ASC";
							$resultContas = $conn->query($sqlContas);
							while($dadosContas = $resultContas->fetch_assoc()){
								
								if($_SESSION['data'] == ""){	
									$_SESSION['data'] = data($dadosContas['dataContaParcial']);
								}
								
								if($dadosContas['formaContaParcial'] == 'PI'){
									$tipoPagamento = "Pix";
								}else
								if($dadosContas['formaContaParcial'] == 'D'){
									$tipoPagamento = "Dinheiro";
								}else
								if($dadosContas['formaContaParcial'] == 'C'){
									$tipoPagamento = "Cartão";
								}else
								if($dadosContas['formaContaParcial'] == 'CH'){
									$tipoPagamento = "Cheque";
								}else					
								if($dadosContas['formaContaParcial'] == 'B'){
									$tipoPagamento = "Boleto";
								}else
								if($dadosContas['formaContaParcial'] == 'DE'){
									$tipoPagamento = "Transf/Depósito";
								}
								
								if($dadosContas['areaPagamentoConta'] == 'R'){
									$corRepresenta = "color:#030AB0;";
								}else{
									$corRepresenta = "color:#FF0000;";
								}
								$dataAlt = explode("/", data($dadosContas['dataContaParcial']));

								
								$data = data($dadosContas['dataContaParcial']);
									
								
								$sqlCliente = "SELECT nomeCliente FROM clientes WHERE codCliente = ".$dadosContas['codCliente']." LIMIT 0,1";
								$resultCliente = $conn->query($sqlCliente);
								$dadosCliente = $resultCliente->fetch_assoc();
								
								$sqlFornecedor = "SELECT nomeFornecedor FROM fornecedores WHERE codFornecedor = ".$dadosContas['codFornecedor']." LIMIT 0,1";
								$resultFornecedor = $conn->query($sqlFornecedor);
								$dadosFornecedor = $resultFornecedor->fetch_assoc();
								
								$sqlTipo = "SELECT nomeTipoPagamento FROM tipoPagamento WHERE codTipoPagamento = ".$dadosContas['codTipoPagamento']." LIMIT 0,1";
								$resultTipo = $conn->query($sqlTipo);
								$dadosTipo = $resultTipo->fetch_assoc();	
								
								if($data != $_SESSION['data']){
									if($saldoDia <= 0){
										$cor = "color:#FF0000;";
									}else{
										$cor = "color:#030AB0;";
									}
?>
										<div id="clientes" style="width:100%; margin-bottom:10px; margin-top:-11px; padding-top:8px; padding-bottom:8px; border-bottom:2px solid #000; border-top:2px solid #000;">
											<p style="width:69%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $cor;?> font-weight:bold;">--</p>
											<p style="width:13.7%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $cor;?> font-weight:bold; font-family:Arial;">Saldo Dia <?php echo $_SESSION['data-anterior'];?></p>
											<p style="width:17%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $cor;?> font-weight:bold; font-family:Arial;">R$ <?php echo number_format($saldoDia, 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php
			
								}	

								if($dadosContas['areaPagamentoConta'] == 'R'){
									$saldoDia = $saldoDia + $dadosContas['valorContaParcial'];
								}else{
									$saldoDia = $saldoDia - $dadosContas['valorContaParcial'];		
								}
?>
										<div id="clientes" style="width:100%; margin-bottom:10px; padding-bottom:10px; border-bottom:1px dashed #000;">
											<p style="width:22%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $corRepresenta;?> font-family:Arial;"><?php echo $dadosContas['codCliente'] != '0' ? $dadosCliente['nomeCliente'] : $dadosFornecedor['nomeFornecedor'];?></p>
											<p style="width:19%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $corRepresenta;?> font-family:Arial;"><?php echo $dadosContas['nomeConta'];?></p>
											<p style="width:18%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $corRepresenta;?> font-family:Arial;"><?php echo $dadosTipo['nomeTipoPagamento'];?></p>
											<p style="width:10%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $corRepresenta;?> font-family:Arial;"><?php echo $dataAlt[0]."/".$dataAlt[1];?></p>
											<p style="width:13%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $corRepresenta;?> font-family:Arial;"><?php echo $tipoPagamento ;?></p>
											<p style="width:18%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $corRepresenta;?> font-family:Arial;">R$ <?php echo number_format($dadosContas['valorContaParcial'], 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
<?php	
									$_SESSION['data'] = data($dadosContas['dataContaParcial']);
									$quebraDataAnterior = explode("/", $_SESSION['data']);
									$_SESSION['data-anterior'] = $quebraDataAnterior[0]."/".$quebraDataAnterior[1];
								
								}	
								
								if($saldoDia <= 0){
									$cor = "color:#FF0000;";
								}else{
									$cor = "color:#030AB0;";
								}									
?>
										<div id="clientes" style="width:100%; margin-top:-11px; padding-top:8px; padding-bottom:8px; border-bottom:2px solid #000; border-top:2px solid #000;">
											<p style="width:69%; float:left; margin:0; font-size:13px; text-align:center; <?php echo $cor;?>">--</p>
											<p style="width:13.7%; float:left; margin:0; font-size:13px; text-align:center; font-weight:bold; <?php echo $cor;?> font-family:Arial;">Saldo Atual</p>
											<p style="width:17%; float:left; margin:0; font-size:13px; text-align:center; font-weight:bold; <?php echo $cor;?> font-family:Arial;">R$ <?php echo number_format($saldoDia, 2, ",", ".");?></p>
											<br style="clear:both;"/>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div id="dados-conteudo">
					<div id="consultas">					
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Cliente / Fornecedor</th>
								<th>Nome</th>
								<th>Tipo</th>
								<th>Data</th>
								<th>Tipo Pagamento</th>
								<th class="canto-dir">Valor</th>
							</tr>					
<?php
				if($_SESSION['dia-filtro-contas'] != ""){
					if($_SESSION['dia-filtro-contas'] == "1"){
						if($_SESSION['mes-filtro-contas'] == "01"){
							$mes = "12";
							$diminuiAno = $_SESSION['ano-filtro-contas'] - 01;
							$ano = $diminuiAno;
						}else{
							$diminuiMes = $_SESSION['mes-filtro-contas'] - 01;
							$mes = $diminuiMes;
							$ano = $_SESSION['ano-filtro-contas'];
						}
					
						$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); // Retorna 31						
					}else{
						$dia = $_SESSION['dia-filtro-contas'] - 1;
						$mes = $_SESSION['mes-filtro-contas'];
						$ano = $_SESSION['ano-filtro-contas'];
					}
				}else{
					if($_SESSION['mes-filtro-contas'] == "01"){
						$mes = "12";
						$diminuiAno = $_SESSION['ano-filtro-contas'] - 01;
						$ano = $diminuiAno;
					}else{
						$diminuiMes = $_SESSION['mes-filtro-contas'] - 01;
						$mes = $diminuiMes;
						$ano = $_SESSION['ano-filtro-contas'];
					}

					$dia = cal_days_in_month(CAL_GREGORIAN, $mes, $ano); // Retorna 31						

				}
				
				$filtroAnterior = $ano."-".$mes."-".$dia;
								
				$sqlSomaR = "SELECT SUM(CP.valorContaParcial) total FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE CP.contaPagamentoConta = ".$dadosBanco['codBanco']." and C.areaPagamentoConta = 'R' and CP.dataContaParcial <= '".$filtroAnterior."'";
				$resultSomaR = $conn->query($sqlSomaR);
				$dadosSomaR = $resultSomaR->fetch_assoc();
					
				$sqlSomaP = "SELECT SUM(CP.valorContaParcial) total FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE CP.contaPagamentoConta = ".$dadosBanco['codBanco']." and C.areaPagamentoConta = 'P' and CP.dataContaParcial <= '".$filtroAnterior."'";
				$resultSomaP = $conn->query($sqlSomaP);
				$dadosSomaP = $resultSomaP->fetch_assoc();
				
				$saldoDia = $dadosSomaR['total'] - $dadosSomaP['total'];

				if($saldoDia <= 0){
					$cor = "color:#FF0000;";
				}else{
					$cor = "color:#030AB0;";
				}
?>
							<tr style="height:50px; background-color:#ccc;">
								<td colspan="4"></td>
								<td colspan="1" style="font-size:18px; text-align:center; <?php echo $cor;?>">Saldo Anterior</td>
								<td colspan="1" style="font-size:18px; text-align:center; <?php echo $cor;?>">R$ <?php echo number_format($saldoDia, 2, ",", ".");?></td>
							</tr>		
<?php
				$_SESSION['data'] = "";
				
				$sqlContas = "SELECT CP.*, C.* FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE CP.contaPagamentoConta = ".$dadosBanco['codBanco']."".$filtraDia.$filtraMes.$filtraAno." ORDER BY CP.dataContaParcial ASC, CP.horarioContaParcial ASC";
				$resultContas = $conn->query($sqlContas);
				while($dadosContas = $resultContas->fetch_assoc()){
				
					if($_SESSION['data'] == ""){	
						$_SESSION['data'] = data($dadosContas['dataContaParcial']);
					}
					
					if($dadosContas['formaContaParcial'] == 'PI'){
						$tipoPagamento = "Pix";
					}else
					if($dadosContas['formaContaParcial'] == 'D'){
						$tipoPagamento = "Dinheiro";
					}else
					if($dadosContas['formaContaParcial'] == 'C'){
						$tipoPagamento = "Cartão";
					}else
					if($dadosContas['formaContaParcial'] == 'CH'){
						$tipoPagamento = "Cheque";
					}else					
					if($dadosContas['formaContaParcial'] == 'B'){
						$tipoPagamento = "Boleto";
					}else
					if($dadosContas['formaContaParcial'] == 'DE'){
						$tipoPagamento = "Transf/Depósito";
					}
					
					if($dadosContas['areaPagamentoConta'] == 'R'){
						$corRepresenta = "color:#030AB0;";
					}else{
						$corRepresenta = "color:#FF0000;";
					}
					$dataAlt = explode("/", data($dadosContas['dataContaParcial']));

					
					$data = data($dadosContas['dataContaParcial']);
						
					
					$sqlCliente = "SELECT nomeCliente FROM clientes WHERE codCliente = ".$dadosContas['codCliente']." LIMIT 0,1";
					$resultCliente = $conn->query($sqlCliente);
					$dadosCliente = $resultCliente->fetch_assoc();
					
					$sqlFornecedor = "SELECT nomeFornecedor FROM fornecedores WHERE codFornecedor = ".$dadosContas['codFornecedor']." LIMIT 0,1";
					$resultFornecedor = $conn->query($sqlFornecedor);
					$dadosFornecedor = $resultFornecedor->fetch_assoc();
					
					$sqlTipo = "SELECT nomeTipoPagamento FROM tipoPagamento WHERE codTipoPagamento = ".$dadosContas['codTipoPagamento']." LIMIT 0,1";
					$resultTipo = $conn->query($sqlTipo);
					$dadosTipo = $resultTipo->fetch_assoc();	
					
					if($data != $_SESSION['data']){
						if($saldoDia <= 0){
							$cor = "color:#FF0000;";
						}else{
							$cor = "color:#030AB0;";
						}
?>
							<tr style="height:45px; background-color:#EAE3E3;">
								<td style="text-align:center; <?php echo $cor;?> font-weight:bold;">---</td>
								<td style="text-align:center; <?php echo $cor;?> font-weight:bold;">---</td>
								<td style="text-align:center; <?php echo $cor;?> font-weight:bold;">---</td>
								<td style="text-align:center; <?php echo $cor;?> font-weight:bold;">---</td>
								<td style="text-align:center; <?php echo $cor;?> font-weight:bold;">Saldo Dia <?php echo $_SESSION['data-anterior'];?></td>
								<td style="text-align:center; width:15%; <?php echo $cor;?> font-weight:bold;">R$ <?php echo number_format($saldoDia, 2, ",", ".");?></td>
							</tr>	
<?php
			
					}	

					if($dadosContas['areaPagamentoConta'] == 'R'){
						$saldoDia = $saldoDia + $dadosContas['valorContaParcial'];
					}else{
						$saldoDia = $saldoDia - $dadosContas['valorContaParcial'];		
					}
?>							
							<tr class="tr" style="height:45px;">
								<td class="vinte" style="text-align:center; <?php echo $corRepresenta;?>"><?php echo $dadosContas['codCliente'] != '0' ? $dadosCliente['nomeCliente'] : $dadosFornecedor['nomeFornecedor'];?></td>
								<td class="vinte" style="text-align:center; <?php echo $corRepresenta;?>"><?php echo $dadosContas['nomeConta'];?></td>
								<td class="vinte" style="text-align:center; <?php echo $corRepresenta;?>"><?php echo $dadosTipo['nomeTipoPagamento'];?></td>
								<td class="dez" style="text-align:center; <?php echo $corRepresenta;?>"><?php echo $dataAlt[0]."/".$dataAlt[1];?></td>
								<td class="vinte" style="width:15%; text-align:center; <?php echo $corRepresenta;?>"><?php echo $tipoPagamento ;?></td>
								<td class="vinte" style="text-align:center; <?php echo $corRepresenta;?>"><span onClick="abreEditarValor(<?php echo $dadosContas['codContaParcial'];?>);" id="valorHtmlConta<?php echo $dadosContas['codContaParcial'];?>">R$ <?php echo number_format($dadosContas['valorContaParcial'], 2, ",", ".");?></span> <input class="campo" type="text" onBlur="salvaEdicaoValor(<?php echo $dadosContas['codContaParcial'];?>, this.value);" style="width:94%; display:none; text-align:center; <?php echo $corRepresenta;?>" value="<?php echo number_format($dadosContas['valorContaParcial'], 2, ",", ".");?>" id="campoValor<?php echo $dadosContas['codContaParcial'];?>" onKeyup="moeda(this);"/></td>
							</tr>
<?php	
		
					$_SESSION['data'] = data($dadosContas['dataContaParcial']);
					$quebraDataAnterior = explode("/", $_SESSION['data']);
					$_SESSION['data-anterior'] = $quebraDataAnterior[0]."/".$quebraDataAnterior[1];
				
				}	
				
				if($saldoDia <= 0){
					$cor = "color:#FF0000;";
				}else{
					$cor = "color:#030AB0;";
				}	
?>					
							<tr style="height:50px; background-color:#ccc;">
								<td colspan="4"></td>
								<td colspan="1" style="font-size:18px; text-align:center; <?php echo $cor;?>">Saldo Atual</td>
								<td colspan="1" style="font-size:18px; text-align:center; <?php echo $cor;?>">R$ <?php echo number_format($saldoDia, 2, ",", ".");?></td>
							</tr>			 							 
						</table>							
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
