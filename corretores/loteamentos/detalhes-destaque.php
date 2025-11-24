	<?php
	if($_COOKIE['codAprovado'.$cookie] != ""){

		$_SESSION['voltaMapa'] = "";		

		function calcularParcela($valorFinanciado, $taxa, $parcelas) {
			if ($taxa == "0.00") {
				// Sem taxa, apenas divisão simples
				$parcela = $valorFinanciado / $parcelas;
			} else {
				// Aplica a fórmula de juros compostos
				$taxa = $taxa / 100;
				$parcela = ($valorFinanciado * $taxa) / (1 - pow(1 + $taxa, -$parcelas));
			}
			
			// Retorna o valor da parcela formatado
			return $parcela;
		}

		function calcularParcelaComReforco($valorFinanciado, $taxaPercent, $parcelas, $valorReforco, $qtdReforcos) {
			$i = $taxaPercent / 100;
			
			// meses em que caem os reforços (de 12 em 12)
			$mesesReforcos = [];
			for ($k = 1; $k <= $qtdReforcos; $k++) {
				$mesesReforcos[] = $k * 12;
			}
		
			// valor presente dos reforços
			$pvReforcos = 0;
			foreach ($mesesReforcos as $m) {
				$pvReforcos += $valorReforco / pow(1 + $i, $m);
			}
		
			// fator de anuidade (parcela mensal sem reforço)
			$fator = 0;
			for ($t = 1; $t <= $parcelas; $t++) {
				$fator += 1 / pow(1 + $i, $t);
			}
		
			// resolve PMT
			$pmt = ($valorFinanciado - $pvReforcos) / $fator;
		
			return $pmt;
		}
?>
							<div id="conteudo-interno">
								<div id="conteudo-loteamentos-detalhes">
									<p class="msg-reservar">Faça reserva e preencha a intenção de compra de um lote clicando no item "<strong style="color:#FFF; font-weight:600;">STATUS</strong>" na tabela abaixo!</p>
									<p class="botao-topo"><a href="<?php echo $configUrl;?>loteamentos/">Ver todos os Loteamentos</a></p>
									<div id="mostra-detalhes">
										<p class="titulo">Lotes em Destaque</p>
										<div id="mostra-lotes">
											<p class="titulo-lotes">Confira os lotes disponíveis</p>
<?php
				if(isset($_POST['quadraFiltroSite'])){
					if($_POST['quadraFiltroSite'] != ""){
						$_SESSION['quadraFiltroSite'] = $_POST['quadraFiltroSite'];
					}else{
						$_SESSION['quadraFiltroSite'] = "";
					}
				}
				
				if($_SESSION['quadraFiltroSite'] != ""){
					$filtraQuadra = " and L.codQuadra = ".$_SESSION['quadraFiltroSite']."";
				}
				
				if(isset($_POST['loteFiltroSite'])){
					if($_POST['loteFiltroSite'] != ""){
						$_SESSION['loteFiltroSite'] = $_POST['loteFiltroSite'];
					}else{
						$_SESSION['loteFiltroSite'] = "";
					}
				}
				
				if($_SESSION['loteFiltroSite'] != ""){
					$filtraLote = " and L.codLote = ".$_SESSION['loteFiltroSite']."";
				}
				
				if(isset($_POST['bairroFiltroSite'])){
					if($_POST['bairroFiltroSite'] != ""){
						$_SESSION['bairroFiltroSite'] = $_POST['bairroFiltroSite'];
					}else{
						$_SESSION['bairroFiltroSite'] = "";
					}
				}
				
				if($_SESSION['bairroFiltroSite'] != ""){
					$filtraBairro = " and L.codBairro = ".$_SESSION['bairroFiltroSite']."";
				}
				
				if(isset($_POST['posicaoFiltroSite'])){
					if($_POST['posicaoFiltroSite'] != ""){
						$_SESSION['posicaoFiltroSite'] = $_POST['posicaoFiltroSite'];
					}else{
						$_SESSION['posicaoFiltroSite'] = "";
					}
				}
				
				if($_SESSION['posicaoFiltroSite'] != ""){
					$filtraPosicao = " and L.posicaoLote = '".$_SESSION['posicaoFiltroSite']."'";
				}
				
				if(isset($_POST['valor1'])){
					if($_POST['valor1'] != ""){
						$_SESSION['valor1'] = $_POST['valor1'];
					}else{
						$_SESSION['valor1'] = "";
					}
				}
				
				if($_SESSION['valor1'] != ""){
					if($_SESSION['valor1'] == "acima"){
						$filtraPrecoDe = " and L.precoLote >= '1000000.00";
					}else{
						$filtraPrecoDe = " and L.precoLote >= '".$_SESSION['valor1']."'";
					}
				}
				
				if(isset($_POST['valor2'])){
					if($_POST['valor2'] != ""){
						$_SESSION['valor2'] = $_POST['valor2'];
					}else{
						$_SESSION['valor2'] = "";
					}
				}
				
				if($_SESSION['valor2'] != ""){
					if($_SESSION['valor2'] == "acima"){
						$filtraPrecoAte = "";
					}else{
						$filtraPrecoAte = " and L.precoLote <= '".$_SESSION['valor2']."'";
					}
				}
				
				if(isset($_POST['statusFiltroSite'])){
					if($_POST['statusFiltroSite'] != ""){
						$_SESSION['statusFiltroSite'] = $_POST['statusFiltroSite'];
					}else{
						$_SESSION['statusFiltroSite'] = "";
					}
				}
				
				if($_SESSION['statusFiltroSite'] != ""){
					if($_SESSION['statusFiltroSite'] == "D"){
						$filtraStatus = " and L.vendidoLote = 'F'";
					}else
					if($_SESSION['statusFiltroSite'] == "R"){
						$innerJoin = "inner JOIN lotesReservas LR ON L.codLote = LR.codLote";
						$filtraStatus = " and L.vendidoLote = 'F' and LR.dataOutLoteReserva IS NULL";
					}else
					if($_SESSION['statusFiltroSite'] == "V"){
						$filtraStatus = " and L.vendidoLote = 'T'";						
					}
					
				}

				if(isset($_POST['ordenarFiltro'])){
					if($_POST['ordenarFiltro'] != ""){
						$_SESSION['ordenarFiltro'] = $_POST['ordenarFiltro'];
					}else{
						$_SESSION['ordenarFiltro'] = "";
					}
				}
				
				if($_SESSION['ordenarFiltro'] != ""){
					if($_SESSION['ordenarFiltro'] == "PA"){
						$ordenar = ", L.precoLote ASC";
					}else
					if($_SESSION['ordenarFiltro'] == "PD"){
						$ordenar = ", L.precoLote DESC";
					}else{
						$ordenar = "";
					}
				}							
?>
											<div id="bloco-filtro">
												<form id="alteraFiltro" action="<?php echo $configUrl.'loteamentos/'.$url[3].'/';?>" method="post" >								
													<p class="bloco-campo"><label>Quadra:</label><br/>
														<select class="selectQuadra form-control campo" id="idSelectQuadra" name="quadraFiltroSite" style="width:130px; display: none;">
															<optgroup label="Selecione">
															<option value="">Todos</option>	
<?php
				$sqlQuadrasLote = "SELECT * FROM quadras Q inner join lotes L on Q.codQuadra = L.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.statusLote = 'T' and L.destaqueLote = 'T' GROUP BY Q.codQuadra ORDER BY Q.nomeQuadra ASC";
				$resultQuadrasLote = $conn->query($sqlQuadrasLote);
				while($dadosQuadrasLote = $resultQuadrasLote->fetch_assoc()){				
?>
															<option value="<?php echo trim($dadosQuadrasLote['codQuadra']);?>" <?php echo trim($dadosQuadrasLote['codQuadra']) == $_SESSION['quadraFiltroSite'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosQuadrasLote['nomeQuadra']);?></option>	
<?php
				}
?>
														</select>										
													</p>

													<script>
														var $rfs = jQuery.noConflict();
														
														$rfs(".selectQuadra").select2({
															placeholder: "Todos",
															multiple: false									
														});	

														$rfs(".selectQuadra").on("select2:select", function (e) {
															var quadraSeleciona = document.getElementById("idSelectQuadra").value;

															$rfs.post("<?php echo $configUrl;?>loteamentos/carrega-lotes.php", {codLoteamento: 0, codQuadra: quadraSeleciona}, function(data){
																$rfs("#carrega-lotes").html(data);
															});							
														});																															
													</script>
													
													<div id="carrega-lotes">
<?php
				if($_SESSION['quadraFiltroSite'] != ""){
?>														
														<p class="bloco-campo"><label>Lote:</label><br/>
															<select class="selectLote form-control campo" id="idSelectLote" name="loteFiltroSite" style="width:130px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
					$sqlLotesLote = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.statusLote = 'T' and L.destaqueLote = 'T' and L.codQuadra = ".$_SESSION['quadraFiltroSite']." GROUP BY L.codLote ORDER BY L.nomeLote ASC";
					$resultLotesLote = $conn->query($sqlLotesLote);
					while($dadosLotesLote = $resultLotesLote->fetch_assoc()){				
?>
																<option value="<?php echo trim($dadosLotesLote['codLote']);?>" <?php echo trim($dadosLotesLote['codLote']) == $_SESSION['loteFiltroSite'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLote['nomeLote']);?></option>	
<?php
					}
?>
															</select>										
														</p>
<?php
				}else{
?>
														<p class="bloco-campo"><label>Lote:</label><br/>
															<select class="selectLote form-control campo" id="idSelectLote" name="loteFiltroSite" style="width:130px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
					$sqlLotesLote = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.statusLote = 'T' and L.destaqueLote = 'T' GROUP BY L.codLote ORDER BY L.nomeLote ASC";
					$resultLotesLote = $conn->query($sqlLotesLote);
					while($dadosLotesLote = $resultLotesLote->fetch_assoc()){				
?>
																<option value="<?php echo trim($dadosLotesLote['codLote']);?>" <?php echo trim($dadosLotesLote['codLote']) == $_SESSION['loteFiltroSite'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLote['nomeLote']);?></option>	
<?php
					}
?>
															</select>										
														</p>
<?php
				}
?>
														<script>
															var $rfh = jQuery.noConflict();
															
															$rfh(".selectLote").select2({
																placeholder: "Todos",
																multiple: false									
															});																	
														</script>														
													</div>

													<p class="bloco-campo"><label>Bairro:</label><br/>
														<select class="selectBairro form-control campo" id="idSelectBairro" name="bairroFiltroSite" style="width:250px; display: none;">
															<optgroup label="Selecione">
															<option value="">Todos</option>	
<?php
					$sqlBairros = "SELECT * FROM bairros B inner join lotes L on B.codBairro = L.codBairro WHERE B.statusBairro = 'T' and L.statusLote = 'T' and L.destaqueLote = 'T' GROUP BY B.codBairro ORDER BY B.nomeBairro ASC";
					$resultBairros = $conn->query($sqlBairros);
					while($dadosBairros = $resultBairros->fetch_assoc()){				
?>
															<option value="<?php echo trim($dadosBairros['codBairro']);?>" <?php echo trim($dadosBairros['codBairro']) == $_SESSION['bairroFiltroSite'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosBairros['nomeBairro']);?></option>	
<?php
					}
?>
														</select>										
													</p>
													<script>
														var $rfsh = jQuery.noConflict();
														
														$rfsh(".selectBairro").select2({
															placeholder: "Todos",
															multiple: false									
														});																	
													</script>
														
													<p class="bloco-campo"><label>Posição Solar:</label><br/>
														<select class="select" style="width:120px;" name="posicaoFiltroSite">
															<option value="">Todos</option>
															<option value="Sul" <?php echo $_SESSION['posicaoFiltroSite'] == 'Sul' ? '/SELECTED/' : '';?> >Sul</option>
															<option value="Norte" <?php echo $_SESSION['posicaoFiltroSite'] == 'Norte' ? '/SELECTED/' : '';?>>Norte</option>
															<option value="Leste" <?php echo $_SESSION['posicaoFiltroSite'] == 'Leste' ? '/SELECTED/' : '';?>>Leste</option>
															<option value="Oeste" <?php echo $_SESSION['posicaoFiltroSite'] == 'Oeste' ? '/SELECTED/' : '';?>>Oeste</option>
													   </select>
													</p>

													<p class="bloco-campo campo-select"><label>Preço de:</label><br/>
														<select class="select" style="width:170px;" name="valor1">
															<option value="">Todos</option>
															<option value="15000.00" <?php echo $_SESSION['valor1'] == '15000.00' ? '/SELECTED/' : '';?> >R$ 15.000,00</option>
															<option value="20000.00" <?php echo $_SESSION['valor1'] == '20000.00' ? '/SELECTED/' : '';?> >R$ 20.000,00</option>
															<option value="25000.00" <?php echo $_SESSION['valor1'] == '25000.00' ? '/SELECTED/' : '';?> >R$ 25.000,00</option>
															<option value="30000.00" <?php echo $_SESSION['valor1'] == '30000.00' ? '/SELECTED/' : '';?> >R$ 30.000,00</option>
															<option value="35000.00" <?php echo $_SESSION['valor1'] == '35000.00' ? '/SELECTED/' : '';?> >R$ 35.000,00</option>
															<option value="40000.00" <?php echo $_SESSION['valor1'] == '40000.00' ? '/SELECTED/' : '';?> >R$ 40.000,00</option>
															<option value="45000.00" <?php echo $_SESSION['valor1'] == '45000.00' ? '/SELECTED/' : '';?> >R$ 45.000,00</option>
															<option value="50000.00" <?php echo $_SESSION['valor1'] == '50000.00' ? '/SELECTED/' : '';?> >R$ 50.000,00</option>
															<option value="60000.00" <?php echo $_SESSION['valor1'] == '60000.00' ? '/SELECTED/' : '';?> >R$ 60.000,00</option>
															<option value="70000.00" <?php echo $_SESSION['valor1'] == '70000.00' ? '/SELECTED/' : '';?> >R$ 70.000,00</option>
															<option value="80000.00" <?php echo $_SESSION['valor1'] == '80000.00' ? '/SELECTED/' : '';?> >R$ 80.000,00</option>
															<option value="90000.00" <?php echo $_SESSION['valor1'] == '90000.00' ? '/SELECTED/' : '';?> >R$ 90.000,00</option>
															<option value="100000.00" <?php echo $_SESSION['valor1'] == '100000.00' ? '/SELECTED/' : '';?> >R$ 100.000,00</option>
															<option value="120000.00" <?php echo $_SESSION['valor1'] == '120000.00' ? '/SELECTED/' : '';?> >R$ 120.000,00</option>
															<option value="140000.00" <?php echo $_SESSION['valor1'] == '140000.00' ? '/SELECTED/' : '';?> >R$ 140.000,00</option>
															<option value="160000.00" <?php echo $_SESSION['valor1'] == '160000.00' ? '/SELECTED/' : '';?> >R$ 160.000,00</option>
															<option value="180000.00" <?php echo $_SESSION['valor1'] == '180000.00' ? '/SELECTED/' : '';?> >R$ 180.000,00</option>
															<option value="200000.00" <?php echo $_SESSION['valor1'] == '200000.00' ? '/SELECTED/' : '';?> >R$ 200.000,00</option>
															<option value="250000.00" <?php echo $_SESSION['valor1'] == '250000.00' ? '/SELECTED/' : '';?> >R$ 250.000,00</option>
															<option value="300000.00" <?php echo $_SESSION['valor1'] == '300000.00' ? '/SELECTED/' : '';?> >R$ 300.000,00</option>
															<option value="350000.00" <?php echo $_SESSION['valor1'] == '350000.00' ? '/SELECTED/' : '';?> >R$ 350.000,00</option>
															<option value="400000.00" <?php echo $_SESSION['valor1'] == '400000.00' ? '/SELECTED/' : '';?> >R$ 400.000,00</option>
															<option value="450000.00" <?php echo $_SESSION['valor1'] == '450000.00' ? '/SELECTED/' : '';?> >R$ 450.000,00</option>
															<option value="500000.00" <?php echo $_SESSION['valor1'] == '500000.00' ? '/SELECTED/' : '';?> >R$ 500.000,00</option>
															<option value="600000.00" <?php echo $_SESSION['valor1'] == '600000.00' ? '/SELECTED/' : '';?> >R$ 600.000,00</option>
															<option value="700000.00" <?php echo $_SESSION['valor1'] == '700000.00' ? '/SELECTED/' : '';?> >R$ 700.000,00</option>
															<option value="800000.00" <?php echo $_SESSION['valor1'] == '800000.00' ? '/SELECTED/' : '';?> >R$ 800.000,00</option>
															<option value="900000.00" <?php echo $_SESSION['valor1'] == '900000.00' ? '/SELECTED/' : '';?> >R$ 900.000,00</option>
															<option value="acima" <?php echo $_SESSION['valor1'] == 'acima' ? '/SELECTED/' : '';?>>+ de R$ 1.000.000,00</option>
													   </select>
													</p>
													
													<p class="bloco-campo campo-select"><label>Preço até:</label><br/>
														<select class="select" style="width:170px;" name="valor2">
															<option value="">Todos</option>
															<option value="15000.00" <?php echo $_SESSION['valor2'] == '15000.00' ? '/SELECTED/' : '';?> >R$ 15.000,00</option>
															<option value="20000.00" <?php echo $_SESSION['valor2'] == '20000.00' ? '/SELECTED/' : '';?> >R$ 20.000,00</option>
															<option value="25000.00" <?php echo $_SESSION['valor2'] == '25000.00' ? '/SELECTED/' : '';?> >R$ 25.000,00</option>
															<option value="30000.00" <?php echo $_SESSION['valor2'] == '30000.00' ? '/SELECTED/' : '';?> >R$ 30.000,00</option>
															<option value="35000.00" <?php echo $_SESSION['valor2'] == '35000.00' ? '/SELECTED/' : '';?> >R$ 35.000,00</option>
															<option value="40000.00" <?php echo $_SESSION['valor2'] == '40000.00' ? '/SELECTED/' : '';?> >R$ 40.000,00</option>
															<option value="45000.00" <?php echo $_SESSION['valor2'] == '45000.00' ? '/SELECTED/' : '';?> >R$ 45.000,00</option>
															<option value="50000.00" <?php echo $_SESSION['valor2'] == '50000.00' ? '/SELECTED/' : '';?> >R$ 50.000,00</option>
															<option value="60000.00" <?php echo $_SESSION['valor2'] == '60000.00' ? '/SELECTED/' : '';?> >R$ 60.000,00</option>
															<option value="70000.00" <?php echo $_SESSION['valor2'] == '70000.00' ? '/SELECTED/' : '';?> >R$ 70.000,00</option>
															<option value="80000.00" <?php echo $_SESSION['valor2'] == '80000.00' ? '/SELECTED/' : '';?> >R$ 80.000,00</option>
															<option value="90000.00" <?php echo $_SESSION['valor2'] == '90000.00' ? '/SELECTED/' : '';?> >R$ 90.000,00</option>
															<option value="100000.00" <?php echo $_SESSION['valor2'] == '100000.00' ? '/SELECTED/' : '';?> >R$ 100.000,00</option>
															<option value="120000.00" <?php echo $_SESSION['valor2'] == '120000.00' ? '/SELECTED/' : '';?> >R$ 120.000,00</option>
															<option value="140000.00" <?php echo $_SESSION['valor2'] == '140000.00' ? '/SELECTED/' : '';?> >R$ 140.000,00</option>
															<option value="160000.00" <?php echo $_SESSION['valor2'] == '160000.00' ? '/SELECTED/' : '';?> >R$ 160.000,00</option>
															<option value="180000.00" <?php echo $_SESSION['valor2'] == '180000.00' ? '/SELECTED/' : '';?> >R$ 180.000,00</option>
															<option value="200000.00" <?php echo $_SESSION['valor2'] == '200000.00' ? '/SELECTED/' : '';?> >R$ 200.000,00</option>
															<option value="250000.00" <?php echo $_SESSION['valor2'] == '250000.00' ? '/SELECTED/' : '';?> >R$ 250.000,00</option>
															<option value="300000.00" <?php echo $_SESSION['valor2'] == '300000.00' ? '/SELECTED/' : '';?> >R$ 300.000,00</option>
															<option value="350000.00" <?php echo $_SESSION['valor2'] == '350000.00' ? '/SELECTED/' : '';?> >R$ 350.000,00</option>
															<option value="400000.00" <?php echo $_SESSION['valor2'] == '400000.00' ? '/SELECTED/' : '';?> >R$ 400.000,00</option>
															<option value="450000.00" <?php echo $_SESSION['valor2'] == '450000.00' ? '/SELECTED/' : '';?> >R$ 450.000,00</option>
															<option value="500000.00" <?php echo $_SESSION['valor2'] == '500000.00' ? '/SELECTED/' : '';?> >R$ 500.000,00</option>
															<option value="600000.00" <?php echo $_SESSION['valor2'] == '600000.00' ? '/SELECTED/' : '';?> >R$ 600.000,00</option>
															<option value="700000.00" <?php echo $_SESSION['valor2'] == '700000.00' ? '/SELECTED/' : '';?> >R$ 700.000,00</option>
															<option value="800000.00" <?php echo $_SESSION['valor2'] == '800000.00' ? '/SELECTED/' : '';?> >R$ 800.000,00</option>
															<option value="900000.00" <?php echo $_SESSION['valor2'] == '900000.00' ? '/SELECTED/' : '';?> >R$ 900.000,00</option>
															<option value="acima" <?php echo $_SESSION['valor1'] == 'acima' ? '/SELECTED/' : '';?>>+ de R$ 1.000.000,00</option>
													   </select>
													</p>

													<p class="bloco-campo"><label>Ordenar Por:</label><br/>
														<select class="select" style="width:130px;" name="ordenarFiltro">
															<option value="">Quadra e Lote</option>
															<option value="PA" <?php echo $_SESSION['ordenarFiltro'] == 'PA' ? '/SELECTED/' : '';?> >Menor Preço</option>
															<option value="PD" <?php echo $_SESSION['ordenarFiltro'] == 'PD' ? '/SELECTED/' : '';?>>Maior Preço</option>
													   </select>
													</p>
													
													<p class="bloco-campo"><label>Status:</label><br/>
														<select class="select" style="width:130px;" name="statusFiltroSite">
															<option value="">Todos</option>
															<option value="D" <?php echo $_SESSION['statusFiltroSite'] == 'D' ? '/SELECTED/' : '';?> >Disponível</option>
															<option value="R" <?php echo $_SESSION['statusFiltroSite'] == 'R' ? '/SELECTED/' : '';?>>Reservado</option>
															<option value="V" <?php echo $_SESSION['statusFiltroSite'] == 'V' ? '/SELECTED/' : '';?>>Vendido</option>
													   </select>
													</p>
																										
													<p class="botao-filtrar"><input type="submit" name="filtrar" value="Filtrar" /></p>
													
													<p class="icone-imprimir" onClick="abrirImprimir();"><img style="display:block;" src="<?php echo $configUrl;?>f/i/quebrado/imprimir.png" width="40"/></p>
													
													<br class="clear"/>
												</form>																	
											</div>
											<script type="text/javascript">
												function imprimeRequisicao(id, pg) {
													var $tg = jQuery.noConflict();

													document.body.style.backgroundColor="#FFFFFF";
													var printContents = document.getElementById(id).innerHTML;
													var originalContents = document.body.innerHTML;
													document.body.innerHTML = printContents;

													window.print();

													document.body.innerHTML = originalContents;
													document.body.style.backgroundColor="#316767";
												}					

												function fechaArquivo(){
													var $rr = jQuery.noConflict();
													$rr("#fundo-imprimir").fadeOut("slow");
													$rr("#conteudo-imprimir").fadeOut("slow");
												}
												
												function abrirImprimir(){
													var $ee = jQuery.noConflict();
													$ee("#fundo-imprimir").fadeIn("slow");
													$ee("#conteudo-imprimir").fadeIn("slow");
												}
											</script>
											<p id="fundo-imprimir" onClick="fechaArquivo();" style="width:100%; height:100%; position:fixed; top:0; left:0; z-index:100; background:rgba(0,0,0,0.7); display:none;"></p>
											<div id="conteudo-imprimir" style="width:900px; min-height:500px; display:none; position:fixed; left:50%; top:50%; margin-top:15px; transform:translate(-50%, -50%); z-index:101;">
												<div id="conteudo-scroll" style="width:900px; height:500px; overflow-y:auto; overflow-x:hidden; background-color:#FFF; border-radius:10px;">
													<p class="botao-fechar" onClick="fechaArquivo();" style="width:30px; color:#FFFFFF; text-align: center; cursor: pointer; position: absolute; z-index:1; background-color:#FF0000; border-radius:235px; font-size:20px; margin-left:880px; margin-top:-15px;">X</p>
													<p class="botao-imprimir" style="position:absolute; z-index:2; cursor:pointer; margin-left:418px; margin-top:-35px;" onClick="imprimeRequisicao('imprime-requisicao', 'imprime.html')"><img src="<?php echo $configUrlGer;?>f/i/icon-impressora2.png" alt="Imagem" /></p>
													<div id="imprime-requisicao" style="width:850px; padding-top:20px; padding-bottom:20px; margin:0 25px auto; background-color:#FFF;">
														<div style="width:850px; margin:0 auto; background-color:#FFF;">
<?php
				$totalItens = 0;
				
				$sqlDisponivel = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra ".$innerJoin." WHERE L.statusLote = 'T' and L.destaqueLote = 'T'".$filtraQuadra.$filtraLote.$filtraBairro.$filtraPosicao.$filtraPrecoDe.$filtraPrecoAte.$filtraStatus."";
				$resultDisponivel = $conn->query($sqlDisponivel);
				while($dadosDisponivel = $resultDisponivel->fetch_assoc()){
					
					$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosDisponivel['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
					$resultReservas = $conn->query($sqlReservas);
					$dadosReservas = $resultReservas->fetch_assoc();

					if($_SESSION['statusFiltroSite'] == "D" && $dadosReservas['codLoteReserva'] == "" || $_SESSION['statusFiltroSite'] != "D"){
						$totalItens++;
					}					
				}
				
				$total = $totalItens / 25;
				$totalNovo = ceil($total);
				
				if($totalNovo == 0){
					$totalNovo = 1;
				}
?>
															<div id="topo-requisicao" style="padding:5px 10px; height:65px; border:1px solid #002c23; border-radius:10px;">	
																<p style="display:table; float:left; margin-right:10px;"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/logo.png" height="65"/></p>
																<div style="float:left; display:contents;">
																	<p style="font-family:Arial; margin:0; font-size:18px; text-align:left; color:#002c23; font-weight:bold;">Lotes em Destaque</span></p>
																	<p style="float:left; font-family:Arial; margin:0; font-size:13px; text-align:left; color:#002c23; padding-top:5px;">Oportunidades</p>
																	<p style="width:60%; float:right; text-align:right; font-family:Arial; margin:0; font-size:13px; padding-top:3px; color:#002c23;"><strong style="font-size:13px; color:#002c23; font-weight:600;"><?php echo $totalItens;?></strong> lotes(s) listados</p>
																	<p style="float:left; font-family:Arial; margin:0; font-size:13px; text-align:left; color:#002c23; padding-top:5px;">Corretor: <?php echo $dadosCorretor['nomeCorretor'];?></p>
																	<p style="width:50%; float:right; text-align:right; font-family:Arial; margin:0; font-size:13px; padding-top:1px; color:#002c23;">Impresso em <strong style="font-size:13px; color:#002c23; font-weight:600;"><?php echo data(date('Y-m-d'));?></strong></p>
																</div>
																<br class="clear"/>	
															</div>
															<p class="topoBaixo" style="font-size:13px; text-align:center; padding-top:5px; font-weight:normal; color:#002c23;">Página <strong style="color:#002c23;">1</strong> de <strong style="color:#002c23;"><?php echo $totalNovo;?></strong></p>
															<div id="conteudo-requisicao" style="width:850px; margin-top:5px;">
																<div id="mostra-dados" style="width:100%; width:100%; display:flex; flex-direction:column; flex-wrap:nowrap; align-content:center; justify-content:center; align-items:center;">				
																	<div id="nomes" style="width:100%;">
																		<p style="width:13%; float:left; margin:0; padding:0.6% 1%; font-size:13px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF;">Nº Lote e Quadra</p>
																		<p style="width:20.15%; float:left; margin:0; padding:0.6% 1%; font-size:13px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF; border-left:0px;">Bairro</p>
																		<p style="width:12%; float:left; margin:0; padding:0.6% 1%; font-size:13px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF; border-left:0px;">Área m²</p>
																		<p style="width:12%; float:left; margin:0; padding:0.6% 1%; font-size:13px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF; border-left:0px;">Posição Solar</p>
																		<p style="width:15%; float:left; margin:0; padding:0.6% 1%; font-size:13px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF; border-left:0px;">Preço</p>
																		<p style="width:15%; float:left; margin:0; padding:0.6% 1%; font-size:13px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #002c23; border-left:0px;">Status</p>
																		<br style="clear:both;"/>
																	</div>
<?php	
				$totalPessoas = 0;
				$mostrando = 0;
				$acompanhantes = 0;
				$cont = 0;
				$contPagina = 0;
				$contPagina2 = 1;
				$totalNao = 0;
				$totalSim = 0;
				
				$sql = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra ".$innerJoin." WHERE L.statusLote = 'T' and L.destaqueLote = 'T'".$filtraQuadra.$filtraLote.$filtraBairro.$filtraPosicao.$filtraPrecoDe.$filtraPrecoAte.$filtraStatus." ORDER BY L.statusLote ASC".$ordenar.", CAST(Q.nomeQuadra AS UNSIGNED) ASC, Q.nomeQuadra ASC, CAST(L.nomeLote AS UNSIGNED) ASC, L.nomeLote ASC";
				$result = $conn->query($sql);
				while($dadosLote = $result->fetch_assoc()){

					$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLote['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
					$resultReservas = $conn->query($sqlReservas);
					$dadosReservas = $resultReservas->fetch_assoc();
				
					$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosLote['codLote']." or codUnido = ".$dadosLote['codLote']." ORDER BY codLote ASC LIMIT 0,1";
					$resultUniao = $conn->query($sqlUniao);
					$dadosUniao = $resultUniao->fetch_assoc();
					
					$sqlLoteamento = "SELECT * FROM loteamentos L inner join cidades C on L.codCidade = C.codCidade WHERE L.statusLoteamento = 'T' and L.codLoteamento = '".$dadosLote['codLoteamento']."' ORDER BY L.codLoteamento ASC LIMIT 0,1";
					$resultLoteamento = $conn->query($sqlLoteamento);
					$dadosLoteamento = $resultLoteamento->fetch_assoc();

					if($dadosUniao['codLote'] != ""){
						$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosUniao['codLote']." ORDER BY codLote ASC LIMIT 0,1";
						$resultUniao = $conn->query($sqlUniao);
						while($dadosUniao = $resultUniao->fetch_assoc()){
							$sqlContrato = "SELECT * FROM contratos WHERE (codLote = ".$dadosUniao['codUnido']." or codLote = ".$dadosUniao['codLote'].") and tipoContrato = 'AA' ORDER BY codContrato DESC LIMIT 0,1";
							$resultContrato = $conn->query($sqlContrato);
							$dadosContrato = $resultContrato->fetch_assoc();
							
							if($dadosContrato['codContrato'] != ""){
								$diasReservaSql = 6;
								break;
							}else{
								$diasReservaSql = $diasReserva;
							}
						}
					
						$frase = "Unido";
					}else{

						$sqlContrato = "SELECT * FROM contratos WHERE codLote = ".$dadosLote['codLote']." and tipoContrato = 'AA' ORDER BY codContrato DESC LIMIT 0,1";
						$resultContrato = $conn->query($sqlContrato);
						$dadosContrato = $resultContrato->fetch_assoc();

						if($dadosContrato['codContrato'] != ""){
							$diasReservaSql = 6;
						}else{
							$diasReservaSql = $diasReserva;
						}
												
						$frase = "";
					}
					
					$sqlBairro = "SELECT * FROM bairros WHERE codBairro = ".$dadosLote['codBairro']." ORDER BY codBairro DESC LIMIT 0,1";
					$resultBairro = $conn->query($sqlBairro);
					$dadosBairro = $resultBairro->fetch_assoc();

					if($_SESSION['statusFiltroSite'] == "D" && $dadosReservas['codLoteReserva'] == "" || $_SESSION['statusFiltroSite'] != "D"){

						$mostrando = $mostrando + 1;
						
						$cont++;
						$contPagina++;
								
						if($cont == 2){
							$background = "background-color:#f5f5f5;";			
							$cont = 0;
						}else{
							$background = "";
						}
						
						if($dadosLote['vendidoLote'] == "T"){
							if($dadosLote['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
								$acoes = "Sua Venda";
								$backgroundColor = "background:#FF0000;";
								$color = "color:#FFF; font-size:13px; font-weight:600;";					
							}else{
								$acoes = "Vendido";
								$backgroundColor = "background:#FF0000;";
								$color = "color:#FFF; font-size:13px; font-weight:600;";
							}
						}else																				
						if($dadosReservas['codLoteReserva'] != ""){
							$data_inicio = new DateTime($dadosReservas['dataInLoteReserva']);
							$data_fim = clone $data_inicio;
							$data_fim->modify('+'.$diasReservaSql.' days');
							$data_atual = new DateTime();
							$dateInterval = $data_atual->diff($data_fim);
							$dateInterval = $dateInterval->days + 1;

							if($dadosReservas['statusLoteReserva'] == "C"){
								$acaba = "Congelado";
							}else															
							if($dateInterval == 1){
								$acaba = "1 dia";
							}else
							if($dateInterval == 2){
								$acaba = "2 dias";
							}else{
								$acaba = $dateInterval." dias";
							}

							if($dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
								$acoes = "Reserva <span style='font-weight:normal; font-size:12px;'>(".$acaba.")</span>";
							}else{								
								$acoes = "Reservado <span style='font-weight:normal; font-size:12px;'>(".$acaba.")</span>";
							}
							
							$backgroundColor = "background:#FFFF00;";
							$color = "color:#000; font-size:13px; font-weight:600;";				
						}else{
							$acoes = "Disponível";
							$backgroundColor = "background:#91b16c;";
							$color = "color:#FFF; font-size:13px; font-weight:600;";
						}

				if($dadosLote['entradaLote'] == "0.00" && $dadosLote['entradaELote'] == "0"){
					if($dadosLoteamento['entradaLoteamento'] == "0.00" && $dadosLoteamento['entradaELoteamento'] == "0"){
						$entrada = "";
					}else{
						if($dadosLoteamento['tipoELoteamento'] == "P"){
							$entrada = ($dadosLote['precoLote'] * $dadosLoteamento['entradaELoteamento']) / 100;
						}else{
							$entrada = $dadosLoteamento['entradaLoteamento'];
						}
					}
				}else{
					if($dadosLote['tipoELote'] == "P"){
						$entrada = ($dadosLote['precoLote'] * $dadosLote['entradaELote']) / 100;
					}else{
						$entrada = $dadosLote['entradaLote'];
					}
				}
					
						if($dadosLote['taxaLote'] == "0.00"){
							$taxa = $dadosLoteamento['taxaLoteamento'];
						}else{
							$taxa = $dadosLote['taxaLote'];					
						}
						if($taxa == "0.00" || $taxa == ""){
							$taxa = 0;
						}
																	
						if($dadosLote['parcelasLote'] == "0"){
							if($dadosLoteamento['parcelasLoteamento'] != "0"){
								$parcela = $dadosLoteamento['parcelasLoteamento'];
							}else{
								$parcela = "0";
							}
						}else{
							$parcela = $dadosLote['parcelasLote'];					
						}
						
						
						if($entrada == ""){
							if($dadosLote['precoLote'] != "0.00"){
								if($dadosLote['vendidoLote'] == "F"){
									$exibeValores = "R$ ".number_format($dadosLote['precoLote'], 2, ",", ".")."<br/>A vista";
								}else{
									$exibeValores = "--";
								}
							}else{
								$exibeValores = "Consulte";
							}
						}else{
							if($dadosLote['precoLote'] != "0.00"){
								$valorFinanciado = $dadosLote['precoLote'] - $entrada;
								$parcelasArray = explode(",", $parcela);
								$maiorParcela = max($parcelasArray);						
								if($dadosLoteamento['reforcoLoteamento'] != "0.00"){
									$reforcoText = " reforços +";
									if($maiorParcela == 12){
										$reforco = 1;
									}else
									if($maiorParcela == 24){
										$reforco = 2;
									}else
									if($maiorParcela == 36){
										$reforco = 3;
									}else
									if($maiorParcela == 48){
										$reforco = 4;
									}else
									if($maiorParcela == 60){
										$reforco = 5;
									}else
									if($maiorParcela == 72){
										$reforco = 6;
									}else
									if($maiorParcela == 90){
										$reforco = 7;
									}else
									if($maiorParcela == 108){
										$reforco = 9;
									}else
									if($maiorParcela == 120){
										$reforco = 10;
									}
		
									$taxaReforco = $dadosLoteamento['reforcoLoteamento'];
									$valorReforco = $taxaReforco / 100 * $dadosLote['precoLote'];
									$parcelaReforco = $valorReforco / $reforco;	
									$parcela = calcularParcelaComReforco($valorFinanciado, $taxa, $maiorParcela, $parcelaReforco, $reforco);
									$valorParcela = number_format($parcela, 2, ",", ".");
								}else{
									$reforcoText = "";
									$valorParcela = number_format(calcularParcela($valorFinanciado, $taxa, $maiorParcela), 2, ",", ".");
								}								
								if($dadosLote['vendidoLote'] == "F"){
									$exibeValores = "R$ ".number_format($entrada, 2, ",", ".")." +".$reforcoText."<br/><strong style='font-size:12px;'>".$maiorParcela."x</strong> de <strong style='font-size:12px;'>R$ ".$valorParcela."</strong>";
								}else{
									$exibeValores = "--";
								}
							}else{
								$exibeValores = "Consulte";						
							}
						}			

						$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosLote['codLote']." or codUnido = ".$dadosLote['codLote']." ORDER BY codLote ASC LIMIT 0,1";
						$resultUniao = $conn->query($sqlUniao);
						$dadosUniao = $resultUniao->fetch_assoc();
						
						if($dadosUniao['codLote'] != ""){
							$background = "background-color:#e2e2e2;";
							$frase = "Unido";
						}else{
							$frase = "";
						}												
?>
																	<div id="clientes" style="width:100%; display:flex; flex-direction:row; flex-wrap:nowrap; justify-content:center; <?php echo $background;?>">
																		<p style="width:13%; float:left; margin:0; font-size:12px; padding:1.7% 1%; font-family:Arial; border:1px dashed #000; text-align:center; border-top:none; font-weight:bold;">[ <?php echo $dadosLote['nomeLote'];?> ] - <?php echo $dadosLote['nomeQuadra'];?><span style="font-size:11px; font-weight:normal;"> - <?php echo $frase;?></span></p>
																		<p style="width:20.15%; float:left; margin:0; padding:0.6% 1%; border:1px dashed #000; border-left:none; border-top:none; text-align:center;"><span style="width:inherit; height:32px; display:table-cell; vertical-align:middle; font-size:12px; font-family:Arial;"><?php echo $dadosBairro['nomeBairro'];?></span></p>
																		<p style="width:12%; float:left; margin:0; font-size:12px; padding:1.7% 1%; font-family:Arial; text-align:center; text-align:center; border:1px dashed #000; border-left:none; border-top:none;"><?php echo $dadosLote['frenteLote'];?> <?php echo $dadosLote['frenteLote'] != "" ? 'x' : '';?> <?php echo $dadosLote['fundosLote'];?> <?php echo $dadosLote['frenteLote'] != "" ? '=' : '';?> <?php echo $dadosLote['areaLote'];?>m²</p>
																		<p style="width:12%; float:left; margin:0; font-size:12px; padding:1.7% 1%; font-family:Arial; text-align:center; text-align:center; border:1px dashed #000; border-left:none; border-top:none;"><?php echo $dadosLote['posicaoLote'];?></p>
																		<p style="width:15%; float:left; margin:0; font-size:12px; padding:0.6% 1%; font-family:Arial; text-align:center; text-align:center; border:1px dashed #000; border-left:none; border-top:none;"><span style="width:inherit; height:32px; display:table-cell; vertical-align:middle; font-size:12px; font-family:Arial; letter-spacing:-0.6px;"><?php echo $exibeValores;?></span></p>
																		<p style="width:15%; float:left; margin:0; font-size:12px; padding:0.6% 1%; font-family:Arial; text-align:center; text-align:center; border:1px dashed #000; border-left:none; border-top:none; <?php echo $backgroundColor;?>"><span style="width:inherit; height:32px; display:table-cell; vertical-align:middle; font-size:12px; font-family:Arial; <?php echo $color;?>"><?php echo $acoes;?></span></p>
																		<br style="clear:both;"/>
																	</div>					
<?php
						if($contPagina == 25 && $mostrando < $totalItens){
							$contPagina = 0;
							$contPagina2++;
?>
																</div>
															</div>
															<div id="topo-requisicao" style="padding:5px 10px; height:65px; border:1px solid #002c23; border-radius:10px;">	
																<p style="display:table; float:left; margin-right:10px;"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/logo.png" height="65"/></p>
																<div style="float:left; display:contents;">
																	<p style="font-family:Arial; margin:0; font-size:18px; text-align:left; color:#002c23; font-weight:bold;">Lotes em Destaque</span></p>
																	<p style="float:left; font-family:Arial; margin:0; font-size:13px; text-align:left; color:#002c23; padding-top:5px;">Oportunidades</p>
																	<p style="width:60%; float:right; text-align:right; font-family:Arial; margin:0; font-size:13px; padding-top:3px; color:#002c23;"><strong style="font-size:13px; color:#002c23; font-weight:600;"><?php echo $totalItens;?></strong> lotes(s) listados</p>
																	<p style="float:left; font-family:Arial; margin:0; font-size:13px; text-align:left; color:#002c23; padding-top:5px;">Corretor: <?php echo $dadosCorretor['nomeCorretor'];?></p>
																	<p style="width:50%; float:right; text-align:right; font-family:Arial; margin:0; font-size:13px; padding-top:1px; color:#002c23;">Impresso em <strong style="font-size:13px; color:#002c23; font-weight:600;"><?php echo data(date('Y-m-d'));?></strong></p>
																</div>
																<br class="clear"/>	
															</div>
															<p class="topoBaixo" style="font-size:13px; text-align:center; padding-top:5px; font-weight:normal; color:#002c23;">Página <strong style="color:#002c23;"><?php echo $contPagina2;?></strong> de <strong style="color:#002c23;"><?php echo $totalNovo;?></strong></p>								
															<div id="conteudo-requisicao" style="width:850px; margin-top:5px;">
																<div id="mostra-dados" style="width:100%; width:100%; display:flex; flex-direction:column; flex-wrap:nowrap; align-content:center; justify-content:center; align-items:center;">				
																	<div id="nomes" style="width:100%;">
																		<p style="width:11.17%; float:left; margin:0; padding:0.6% 1%; font-size:14px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF;">Nº do Lote</p>
																		<p style="width:11%; float:left; margin:0; padding:0.6% 1%; font-size:14px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF; border-left:0px;">Quadra</p>
																		<p style="width:15%; float:left; margin:0; padding:0.6% 1%; font-size:14px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF; border-left:0px;">Frente x Fundo</p>
																		<p style="width:15%; float:left; margin:0; padding:0.6% 1%; font-size:14px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF; border-left:0px;">Posição Solar</p>
																		<p style="width:15%; float:left; margin:0; padding:0.6% 1%; font-size:14px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #FFF; border-left:0px;">Preço</p>
																		<p style="width:20%; float:left; margin:0; padding:0.6% 1%; font-size:14px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; background-color:#002c23; border-bottom:0px; border:1px solid #002c23; border-right:1px solid #002c23; border-left:0px;">Status</p>
																		<br style="clear:both;"/>
																	</div>
<?php			
						}
					}
				}	
?>
																	<p style="margin-top:10px; font-size:13px;">Total de <strong style="font-size:13px;"><?php echo $mostrando;?></strong> lote(s)!</p>
																</div>
															</div>
														</div>
													</div>
												</div>	
												<p style="color:#FFF; text-align:center; font-size:11.5px; padding-top:10px;">Se as cores do cabeçalho não estiverem aparecendo vá nas configurações de impressão do navegador e ative "Elementos gráficos em segundo plano".</p>
											</div>				
											<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
											<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
											<div id="lista-lotes">
												<table id="tabela-lotes">
													<tr class="tr-titulo">
														<th class="esq">Nº Lote</th>
														<th>Quadra</th>
														<th>Bairro</th>
														<th>Área m²</th>
														<th>Posição Solar</th>
														<th>Preço</th>
														<th>Fotos</th>
														<th class="dir">Status</th>
													</tr>
<?php
		$cont = 0;
		$contTotal = 0;
		
		$sqlLotes = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra ".$innerJoin." WHERE L.statusLote = 'T' and L.destaqueLote = 'T'".$filtraQuadra.$filtraLote.$filtraBairro.$filtraPosicao.$filtraPrecoDe.$filtraPrecoAte.$filtraStatus." GROUP BY L.codLote ORDER BY L.statusLote ASC".$ordenar.", CAST(Q.nomeQuadra AS UNSIGNED) ASC, Q.nomeQuadra ASC, CAST(L.nomeLote AS UNSIGNED) ASC, L.nomeLote ASC";
		$resultLotes = $conn->query($sqlLotes);
		while($dadosLotes = $resultLotes->fetch_assoc()){
			
			$sqlBairro = "SELECT * FROM bairros WHERE codBairro = ".$dadosLotes['codBairro']." ORDER BY codBairro DESC LIMIT 0,1";
			$resultBairro = $conn->query($sqlBairro);
			$dadosBairro = $resultBairro->fetch_assoc();
			
			$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
			$resultReservas = $conn->query($sqlReservas);
			$dadosReservas = $resultReservas->fetch_assoc();

			$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosLotes['codLote']." or codUnido = ".$dadosLotes['codLote']." ORDER BY codLote ASC LIMIT 0,1";
			$resultUniao = $conn->query($sqlUniao);
			$dadosUniao = $resultUniao->fetch_assoc();
			
			$sqlLoteamento = "SELECT * FROM loteamentos L inner join cidades C on L.codCidade = C.codCidade WHERE L.statusLoteamento = 'T' and L.codLoteamento = '".$dadosLotes['codLoteamento']."' ORDER BY L.codLoteamento ASC LIMIT 0,1";
			$resultLoteamento = $conn->query($sqlLoteamento);
			$dadosLoteamento = $resultLoteamento->fetch_assoc();

			if($dadosUniao['codLote'] != ""){
				$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosUniao['codLote']." ORDER BY codLote ASC LIMIT 0,1";
				$resultUniao = $conn->query($sqlUniao);
				while($dadosUniao = $resultUniao->fetch_assoc()){
					$sqlContrato = "SELECT * FROM contratos WHERE (codLote = ".$dadosUniao['codUnido']." or codLote = ".$dadosUniao['codLote'].") and tipoContrato = 'AA' ORDER BY codContrato DESC LIMIT 0,1";
					$resultContrato = $conn->query($sqlContrato);
					$dadosContrato = $resultContrato->fetch_assoc();
					
					if($dadosContrato['codContrato'] != ""){
						$diasReservaSql = 6;
						break;
					}else{
						$diasReservaSql = $diasReserva;
					}
				}
			
				$frase = "Unido";
			}else{

				$sqlContrato = "SELECT * FROM contratos WHERE codLote = ".$dadosLotes['codLote']." and tipoContrato = 'AA' ORDER BY codContrato DESC LIMIT 0,1";
				$resultContrato = $conn->query($sqlContrato);
				$dadosContrato = $resultContrato->fetch_assoc();

				if($dadosContrato['codContrato'] != ""){
					$diasReservaSql = 6;
				}else{
					$diasReservaSql = $diasReserva;
				}
										
				$frase = "";
			}
								
			if($_SESSION['statusFiltroSite'] == "D" && $dadosReservas['codLoteReserva'] == "" || $_SESSION['statusFiltroSite'] != "D"){

				$cont++;
				$contTotal++;
						
				if($dadosLotes['vendidoLote'] == "T"){
					if($dadosLotes['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
						$acoes = "Sua Venda";
						$backgroundColor = "background:#FF0000;";
						$color = "color:#FFF; font-size:15px; font-weight:600;";					
					}else{
						$acoes = "Vendido";
						$backgroundColor = "background:#FF0000;";
						$color = "color:#FFF; font-size:15px; font-weight:600;";
					}
				}else																				
				if($dadosReservas['codLoteReserva'] != ""){
					$data_inicio = new DateTime($dadosReservas['dataInLoteReserva']);
					$data_fim = clone $data_inicio;
					$data_fim->modify('+'.$diasReservaSql.' days');
					$data_atual = new DateTime();
					$dateInterval = $data_atual->diff($data_fim);
					$dateInterval = $dateInterval->days + 1;

					if($dadosReservas['statusLoteReserva'] == "C"){
						$acaba = "Congelado";
					}else															
					if($dateInterval == 1){
						$acaba = "1 dia";
					}else
					if($dateInterval == 2){
						$acaba = "2 dias";
					}else{
						$acaba = $dateInterval." dias";
					}

					if($dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
						$acoes = "Reserva <span style='font-weight:normal; font-size:12px;'>(".$acaba.")</span>";
					}else{								
						$acoes = "Reservado <span style='font-weight:normal; font-size:12px;'>(".$acaba.")</span>";
					}
					
					$backgroundColor = "background:#FFFF00;";
					$color = "color:#002c23; font-size:15px; font-weight:600;";				
				}else{
					$acoes = "Disponível";
					$backgroundColor = "background:#91b16c;";
					$color = "color:#FFF; font-size:15px; font-weight:600;";
				}
				
				if($cont == 2){
					$background = "background-color:#e6e6e6;";
					$cont = 0;
				}else{
					$background = "background-color:#f5f5f5;";
				}	
				
				$libera = "";

				if($dadosReservas['codLoteReserva'] == ""){
				
					$sqlUltima = "SELECT * FROM lotesReservas WHERE codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and codLote = ".$dadosLotes['codLote']." ORDER BY codLoteReserva DESC LIMIT 0,1";
					$resultUltima = $conn->query($sqlUltima);
					$dadosUltima = $resultUltima->fetch_assoc();
					
					if($dadosUltima['codLoteReserva'] != ""){
					
						$dateTime = new DateTime($dadosUltima['dataOutLoteReserva']);
						$dateTime->modify('+24 hours');
						$dataLibera = $dateTime->format('Y-m-d H:i:s');
						
						if($dataLibera <= date('Y-m-d')){
							$libera = "";
						}else{
							$libera = $dataLibera;
						}	
					}					
				}

				$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosLotes['codLote']." or codUnido = ".$dadosLotes['codLote']." ORDER BY codLote ASC LIMIT 0,1";
				$resultUniao = $conn->query($sqlUniao);
				$dadosUniao = $resultUniao->fetch_assoc();
				
				if($dadosUniao['codLote'] != ""){
					$background = "background-color:#e2e2e2;";
					$frase = "Unido";
				}else{
					$frase = "";
				}														
?>													
													<tr class="tr-lista" style="<?php echo $background;?>">
														<td style="font-weight:bold;"><?php echo $dadosLotes['nomeLote'];?> <span style="font-size:11px; font-weight:normal; display:block;"><?php echo $frase;?></span></td>
														<td><?php echo $dadosLotes['nomeQuadra'];?></td>
														<td><?php echo $dadosBairro['nomeBairro'];?></td>
														<td><?php echo $dadosLotes['frenteLote'];?> <?php echo $dadosLotes['frenteLote'] != "" ? 'x' : '';?> <?php echo $dadosLotes['fundosLote'];?> <?php echo $dadosLotes['frenteLote'] != "" ? '=' : '';?> <?php echo $dadosLotes['areaLote'];?>m²</td>
														<td><?php echo $dadosLotes['posicaoLote'] != "" ? $dadosLotes['posicaoLote'] : '';?></td>
<?php
				if($dadosLotes['entradaLote'] == "0.00" && $dadosLotes['entradaELote'] == "0"){
					if($dadosLoteamento['entradaLoteamento'] == "0.00" && $dadosLoteamento['entradaELoteamento'] == "0"){
						$entrada = "";
					}else{
						if($dadosLoteamento['tipoELoteamento'] == "P"){
							$entrada = ($dadosLote['precoLote'] * $dadosLoteamento['entradaELoteamento']) / 100;
						}else{
							$entrada = $dadosLoteamento['entradaLoteamento'];
						}
					}
				}else{
					if($dadosLotes['tipoELote'] == "P"){
						$entrada = ($dadosLotes['precoLote'] * $dadosLotes['entradaELote']) / 100;
					}else{
						$entrada = $dadosLotes['entradaLote'];
					}
				}
			
				if($dadosLotes['taxaLote'] == "0.00"){
					$taxa = $dadosLoteamento['taxaLoteamento'];
				}else{
					$taxa = $dadosLotes['taxaLote'];					
				}
				if($taxa == "0.00" || $taxa == ""){
					$taxa = 0;
				}				
			
				if($dadosLotes['parcelasLote'] == "0"){
					if($dadosLoteamento['parcelasLoteamento'] != "0"){
						$parcela = $dadosLoteamento['parcelasLoteamento'];
					}else{
						$parcela = "0";
					}
				}else{
					$parcela = $dadosLotes['parcelasLote'];					
				}
			
				if($entrada == ""){
					if($dadosLotes['precoLote'] != "0.00"){
						if($dadosLotes['vendidoLote'] == "F"){
							$exibeValores = "R$ ".number_format($dadosLotes['precoLote'], 2, ",", ".")."<br/>A vista";
						}else{
							$exibeValores = "--";
						}
					}else{
						$exibeValores = "Consulte";
					}
				}else{
					if($dadosLotes['precoLote'] != "0.00"){
						$valorFinanciado = $dadosLotes['precoLote'] - $entrada;
						$parcelasArray = explode(",", $parcela);
						$maiorParcela = max($parcelasArray);						
						if($dadosLoteamento['reforcoLoteamento'] != "0.00"){
							$reforcoText = " reforços +";
							if($maiorParcela == 12){
								$reforco = 1;
							}else
							if($maiorParcela == 24){
								$reforco = 2;
							}else
							if($maiorParcela == 36){
								$reforco = 3;
							}else
							if($maiorParcela == 48){
								$reforco = 4;
							}else
							if($maiorParcela == 60){
								$reforco = 5;
							}else
							if($maiorParcela == 72){
								$reforco = 6;
							}else
							if($maiorParcela == 90){
								$reforco = 7;
							}else
							if($maiorParcela == 108){
								$reforco = 9;
							}else
							if($maiorParcela == 120){
								$reforco = 10;
							}

							$taxaReforco = $dadosLoteamento['reforcoLoteamento'];
							$valorReforco = $taxaReforco / 100 * $dadosLotes['precoLote'];
							$parcelaReforco = $valorReforco / $reforco;	
							$parcela = calcularParcelaComReforco($valorFinanciado, $taxa, $maiorParcela, $parcelaReforco, $reforco);
							$valorParcela = number_format($parcela, 2, ",", ".");
						}else{
							$reforcoText = "";
							$valorParcela = number_format(calcularParcela($valorFinanciado, $taxa, $maiorParcela), 2, ",", ".");
						}
						if($dadosReservas['codLoteReserva'] == "" && $dadosLotes['vendidoLote'] == "F"){
							$exibeValores = 'R$ ' . number_format($entrada, 2, ',', '.').' +'.$reforcoText.'<br/><strong>' . $maiorParcela . 'x</strong> de <strong>R$ '.$valorParcela.'</strong><br/>'.'<span onClick="perguntaNotifica(' . $dadosLotes['codLote'] . ', \'D\', \'\', \'' . $libera . '\');">mais informações</span>';
						}else
						if($dadosReservas['codCorretor'] != ""){
							if($dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
								if($dadosLotes['vendidoLote'] == "F"){
									$exibeValores = 'R$ ' . number_format($entrada, 2, ',', '.').' +'.$reforcoText.'<br/><strong>' . $maiorParcela . 'x</strong> de <strong>R$ '.$valorParcela.'</strong><br/>'.'<span onClick="perguntaNotifica(' . $dadosLotes['codLote'] . ', \'R\', '.$dadosReservas['codCorretor'].', \'\');">mais informações</span>';
								}else{
									$exibeValores = "--";									
								}
							}else{
								$exibeValores = 'R$ ' . number_format($entrada, 2, ',', '.').' +'.$reforcoText.'<br/><strong>' . $maiorParcela . 'x</strong> de <strong>R$ '.$valorParcela.'</strong><br/>'.'<span onClick="perguntaNotifica(' . $dadosLotes['codLote'] . ', \'R\', \'\', \'\');">mais informações</span>';								
							}
						}else{
							$exibeValores = "--";
						}
					}else{
						$exibeValores = "Consulte";						
					}
				}
?>
														<td><?php echo $exibeValores;?></td>
<?php
				$sqlImagem = "SELECT * FROM lotesImagens WHERE codLote = ".$dadosLotes['codLote']." ORDER BY codLoteImagem ASC LIMIT 0,1";
				$resultImagem = $conn->query($sqlImagem);
				$dadosImagem = $resultImagem->fetch_assoc();
				
				if($dadosImagem['codLote'] != ""){
?>
														<td style="width:5%; padding:0px; cursor:pointer;" onClick="carregaFotos(<?php echo $dadosImagem['codLote'];?>)"><span style="width:60px; height:60px; margin:0 auto; display:block; background:transparent url('<?php echo $configUrlGer.'f/lotes/'.$dadosImagem['codLote'].'-'.$dadosImagem['codLoteImagem'].'-W.webp';?>') center center no-repeat; background-size:100%;"></span></td>
<?php
				}else{
?>
														<td style="width:5%; padding:0px;">--</td>
<?php
				}														

				if($dadosReservas['codLoteReserva'] == "" && $dadosLotes['vendidoLote'] == "F"){
?>
														<td style="width:15%; padding:0px;" onClick="perguntaNotifica(<?php echo $dadosLotes['codLote'];?>, 'D', '', '<?php echo $libera;?>');"><span class="botao" style="<?php echo $color;?> <?php echo $backgroundColor;?>"><?php echo $acoes;?></span></td>
<?php
				}else
				if($dadosReservas['codCorretor'] != ""){
				
					if($dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
																				
						if($dadosLotes['vendidoLote'] == "F"){
?>														
														<td style="width:15%; padding:0px;" onClick="perguntaNotifica(<?php echo $dadosLotes['codLote'];?>, 'R', <?php echo $dadosReservas['codCorretor'];?>, '');"><span class="botao" style="<?php echo $color;?> <?php echo $backgroundColor;?>"><?php echo $acoes;?></span></td>
<?php
						}else{
?>
														<td style="width:15%; padding:0px;" onClick="perguntaNotifica(<?php echo $dadosLotes['codLote'];?>, 'V', '', '');"><span class="botao" style="<?php echo $color;?> <?php echo $backgroundColor;?>"><?php echo $acoes;?></span></td>
<?php							
						}

					}else{
?>
														<td style="width:15%; padding:0px;" onClick="perguntaNotifica(<?php echo $dadosLotes['codLote'];?>, 'R', '', '');"><span class="botao" style="<?php echo $color;?> <?php echo $backgroundColor;?>"><?php echo $acoes;?></span></td>
<?php					
					}
				}else{
?>
														<td style="width:15%; padding:0px;" onClick="perguntaNotifica(<?php echo $dadosLotes['codLote'];?>, 'V', <?php echo $dadosReservas['codCorretor'];?>, '');"><span class="botao" style="<?php echo $color;?> <?php echo $backgroundColor;?>"><?php echo $acoes;?></span></td>
<?php					
				}
?>
													</tr>
<?php
			}
		}
?>
												</table>
<?php
		if($contTotal == 0){
?>
												<p class="mensagem-erro">Nenhum lote foi encontrado!</p>
<?php
		}else{
?>
												<p class="mensagem-erro" style="font-size:13px;">Exibindo um total de <strong><?php echo $contTotal;?></strong> lote(s).</p>
<?php
		}
?>
											</div>
											<p class="fundo-acoes" style="display:none;" onClick="fechaPopup();"></p>
											<div id="popup-acoes" style="display:none;">
											
											</div>
											<p class="fundo-fotos" onClick="fechaFotos();" style="display:none;"></p>
											<div id="popup-fotos" style="display:none;">

											</div>
											<p class="fundo-mapa" onClick="fechaMapa();" style="display:none;"></p>
											<div id="popup-mapa" style="display:none;">
												
											</div>
											<script type="text/javascript">											
												function fechaFotos(){
													var $hg = jQuery.noConflict();
													$hg(".fundo-fotos").fadeOut(250);
													$hg("#popup-fotos").fadeOut(250);
												}
												
												function fechaPopup(){
													var $hg = jQuery.noConflict();
													$hg(".fundo-acoes").fadeOut(250);
													$hg("#popup-acoes").fadeOut(250);
												}
												
												function fechaMapa(){
													var $hggg = jQuery.noConflict();
													$hggg(".fundo-mapa").fadeOut(250);
													$hggg("#popup-mapa").fadeOut(250);
												}
												
												function carregaFotos(cod){
													var $tgs = jQuery.noConflict();
													$tgs(".fundo-fotos").fadeIn(250);
													$tgs("#popup-fotos").fadeIn(250);
													$tgs.post("<?php echo $configUrl;?>loteamentos/carrega-fotos.php", {codLote: cod}, function(data){													
														$tgs("#popup-fotos").html(data);
													});
												}
												
												function carregaMapa(loteamento){
													var $tgsgg = jQuery.noConflict();
													$tgsgg(".fundo-mapa").fadeIn(250);
													$tgsgg("#popup-mapa").fadeIn(250);
													$tgsgg.post("<?php echo $configUrl;?>loteamentos/carrega-mapa.php", {codLoteamento: loteamento}, function(data){													
														$tgsgg("#popup-mapa").html(data);
													});
												}

												function perguntaNotifica(codLote) {
												  buscaLoteData(codLote).then((data) => {
													if (data) {
													  Swal.fire({
														title: '<span style="color:#002c23; font-size:20px;">Informações de Pagamento</span>',
														html: "<p style='border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;'><strong style='font-size:15px; color:#002c23; font-weight:600;'>Valor a vista:</strong> R$ "+data.valor+"</p><p><strong style='font-size:15px; color:#002c23; font-weight:600;'>Entrada:</strong> R$ "+data.entrada+"</p><p><strong style='font-size:15px; color:#002c23; font-weight:600;'>Taxa:</strong> "+data.taxa+"%</p><p><strong style='font-size:15px; color:#002c23; font-weight:600;'>Parcelas:</strong> "+data.parcelas+"x</p><p><strong style='font-size:15px; color:#002c23; font-weight:600;'>Valor da Parcela:</strong> R$ "+data.valor_parcela+"</p><br/><p>Faça uma nova simulação abaixo:<br/><a target='_blank' style='color:#002c23; text-decoration:underline; display:block;' href='https://www.idinheiro.com.br/calculadoras/calculadora-financiamento-price/'>Acessar Calculadora</a></p>",
														iconHtml: '<i class="fas fa-money-bill-wave" style="font-size: 50px; color:green;"></i>',
														confirmButtonText: 'Fechar'
													  });
													}
												  });
												}

												let countdownInterval = null; // Variável global para o intervalo

												function startCountdown(targetDate, callback) {
													let targetTime = new Date(targetDate).getTime();

													// Limpa qualquer contagem regressiva anterior antes de iniciar uma nova
													if (countdownInterval) {
														clearInterval(countdownInterval);
													}

													countdownInterval = setInterval(() => {
														// Obtém o tempo atual
														let now = new Date().getTime();

														// Calcula o tempo restante
														let timeLeft = targetTime - now;

														if (timeLeft <= 0) {
															clearInterval(countdownInterval); // Para o intervalo quando o tempo acabar
															countdownInterval = null; // Reseta a variável
															callback("00:00:00"); // Define o valor final para 00:00:00
														} else {
															// Converte o tempo restante para horas, minutos e segundos
															let hours = Math.floor(timeLeft / (1000 * 60 * 60));
															let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
															let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

															// Formata a contagem regressiva
															let countdownString = `${padZero(hours)}:${padZero(minutes)}:${padZero(seconds)}`;

															// Chama o callback para atualizar o valor da variável
															callback(countdownString);
														}
													}, 1000);
												}

												function stopCountdown() {
													if (countdownInterval) {
														clearInterval(countdownInterval); // Para o intervalo
														countdownInterval = null; // Reseta a variável
													}
												}

												// Função auxiliar para adicionar zeros à esquerda
												function padZero(num) {
													return num < 10 ? `0${num}` : num;
												}
																		
												function perguntaNotifica(codLote, status, corretor, tempo) {
													const countdownValue = "";
													if(status == "V"){
														Swal.fire('Aviso', 'Este lote já foi vendido!', 'warning');
													}else{													
														stopCountdown();
														  var corretorLogado = <?php echo $_COOKIE['codAprovado'.$cookie];?>;
														  buscaLoteData(codLote).then((data) => {
															if (data) {
															  Swal.fire({
																title: '<span style="color:#002c23; font-size:20px;">Informações do Lote</span>',
																html: `
																<div class="swal-custom-popup">
																  <div style="display: flex; justify-content: space-between;">
																	<div style="width: 48%; border-right: 1px solid #ccc; text-align:left; padding-right: 20px;">
																	  <p style="border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;">
																		<strong style="font-size:16px; color:#002c23; font-weight:600;">Lote:</strong> ${data.nomeLote} 
																	  </p>
																	  <p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#002c23; font-weight:600;">Quadra: </strong>${data.nomeQuadra}</p>
																	  <p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#002c23; font-weight:600;">Bairro: </strong>${data.bairro}</p>
																	  <p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#002c23; font-weight:600;">Posição Solar:</strong> ${data.posicaoSolar}</p>
																	  <p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#002c23; font-weight:600;">Área m²: </strong>${data.frenteFundo}</p>
																	  ${data.obs ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#002c23; font-weight:600;">Observação: </strong>${data.obs}</p>` : ''}
																	</div>
																	<div style="width: 48%; padding-left: 20px; text-align:left;">
																	  ${data.desconto > 0 ? `<p style="border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;">
																		<strong style="font-size:16px; color:#002c23; font-weight:600;">Valor total:</strong> ${data.valor}
																	  </p>
																	  <p style="padding-bottom:5px; margin-bottom:5px;">
																		<strong style="font-size:15px; color:#002c23; font-weight:600;">Valor a vista:</strong> ${data.valorVista} (- ${data.desconto}%)
																	  </p>` : ''}
																	  ${data.desconto == 0 ? `<p style="border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;">
																		<strong style="font-size:15px; color:#002c23; font-weight:600;">Valor a vista:</strong> ${data.valor}
																	  </p>` : ''}
																	  ${data.entrada ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#002c23; font-weight:600;">Entrada:</strong> R$ ${data.entrada}
																	  </p>` : ''}
																	  
																	  ${parseFloat(data.taxa.trim()) > 0 ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#002c23; font-weight:600;">Taxa:</strong> ${data.taxa}%
																	  </p>` : ''}
																	  
																	  ${data.parcelas ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#002c23; font-weight:600;">Parcelas:</strong> ${data.parcelas}
																	  </p>` : ''}
																	  
																	  ${data.valor_parcela ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#002c23; font-weight:600;">Valor da Parcela:</strong> ${data.valor_parcela}
																	  </p>` : ''}

																		${data.reforcos ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#002c23; font-weight:600;">Reforços Anuais:</strong> ${data.reforcos}
																	  </p>` : ''}
																	</div>					
																  </div>
																  <br/>
																  <p>
																	${data.unido == 'T' ? `<strong style="color:#FF0000;">Este lote possui união com um ou mais lotes!</strong><br/><br/>` : ''}
																	${data.taxa ? `Faça uma nova simulação abaixo:<br/>
																	<a target='_blank' style='color:#002c23; text-decoration:underline; display:block;' href='https://www.idinheiro.com.br/calculadoras/calculadora-financiamento-price/'>
																	  Acessar Calculadora
																	</a>` : ''}
																	 ${status === "R" && corretor === corretorLogado || status === "D" ? `
																	<br/>
																	A conta para o sinal de arras você poderá visualizar<br/>clicando no botão <strong>Realizar Contrato</strong>!` : ''}
																  </p>
																</div>`,
																iconHtml: '<i class="fas fa-draw-polygon" style="font-size: 50px; color:green;"></i>',
																showCloseButton: true,
																showCancelButton: true,
																confirmButtonText: 'Fechar',
																cancelButtonText: tempo != "" ? 'Reservar em 00:00:00' : (status === "R" && corretor === corretorLogado) ? 'Cancelar Reserva' : (status === "D" ? 'Fazer Reserva' : 'Reservado'),
																buttonsStyling: false,
																customClass: {
																  popup: 'swal-custom-popup',
																  confirmButton: 'btn-confirmar',
																  cancelButton: 'btn-reservar',
																},
																width: '680px',
																padding: '20px',
																didOpen: () => {
																  const cancelButton = Swal.getCancelButton();

																  // Se o status for 'R' e o corretor for o mesmo do cookie, muda o estilo do botão
																  if(tempo != ""){
																	cancelButton.style.backgroundColor = '#ccc';
																	cancelButton.style.color = '#000';
																	cancelButton.style.cursor = 'pointer';
																	cancelButton.disabled = false;																  
																  }else
																  if (status === "R" && corretor === corretorLogado) {
																	cancelButton.style.backgroundColor = '#FFD700';
																	cancelButton.style.color = '#000';
																	cancelButton.style.cursor = 'pointer';
																	cancelButton.disabled = false;

																	// Adiciona a função 'cancelarReserva' ao botão de cancelar reserva
																	cancelButton.addEventListener('click', () => cancelarReserva(codLote));
																  } else if (status === "R") {
																	cancelButton.style.backgroundColor = '#FFD700';
																	cancelButton.style.color = '#000';
																	cancelButton.style.cursor = 'not-allowed';
																	cancelButton.disabled = true;
																  }

																  // Oculta o botão "Fazer Contrato" se o status for 'R'
																  if (status !== "R" || (status === "R" && corretor === corretorLogado)) {
																	Swal.getCancelButton().insertAdjacentHTML('afterend', `
																	  <button id="fazer-contrato" class="btn-reservar swal2-styled" style="margin-left: 10px;">Realizar Contrato</button>
																	`);

																	document.getElementById('fazer-contrato').addEventListener('click', () => {
																	  fazerContrato(codLote);
																	});
																  }
																}
															  }).then((result) => {
																if (result.isConfirmed) {
																  // Ação para o botão "Fechar"
																} else if (result.dismiss === Swal.DismissReason.cancel && status !== "R") {
																	if(tempo != ""){
																		bloqueado(tempo);
																	}else{
																		reservarLote(codLote); // Chama a função de reserva, exceto se o status for 'R'
																	}
																}
															  });
															  
																if(tempo != ""){
																	startCountdown(tempo, function(countdownValue) {
																		regressivo = countdownValue;
																		document.querySelector('.swal2-cancel').textContent = "Reservar em "+regressivo;
																	});
																}														  
															}
														});
													}
												}		

												function bloqueado(tempo) {
													var $tgs = jQuery.noConflict();

													Swal.fire({
														title: 'Reserva de Lote',
														allowOutsideClick: false,
														html: '<p class="texto" style="font-size:15px; text-align:center;">Você não pode realizar a reserva deste lote pois você realizou uma recentemente! Aguarde o tempo abaixo para reservar novamente</p><p class="countdown" style="margin-top:20px; font-size:20px; font-weight:bold;">Disponível em 00:00:00</p>'
													});

													startCountdown(tempo, function(countdownValue) {
														regressivo = countdownValue;
														console.log("Contagem regressiva:", regressivo); // Exibe a contagem a cada segundo
														// Você pode atualizar o HTML com a variável 'regressivo'
														document.querySelector('.countdown').textContent = "Disponível em "+regressivo;
													});														
												}

												function reservarLote(codLote) {
													var $tgs = jQuery.noConflict();

													Swal.fire({
														title: 'Reservando Lote...',
														text: 'Por favor, aguarde...',
														allowOutsideClick: false,
														didOpen: () => {
															Swal.showLoading();
														}
													});

													$tgs.post("<?php echo $configUrl;?>loteamentos/cadastra-reserva.php", { codLote: codLote }, function (data) {
														if (data.trim() == "ok") {
															Swal.fire({
																icon: 'success',
																title: 'Reserva realizada com sucesso!',
																showConfirmButton: false,
																timer: 3000
															});

															setTimeout("carregaPagina()", 3000);
														} else {
															if(data.trim() == "erro login"){
																Swal.fire({
																	icon: 'error',
																	title: 'Erro',
																	text: 'Você não está logado, clique em OK e faça o seu login!',
																	confirmButtonText: 'OK'
																}).then((result) => {
																	if (result.isConfirmed) {
																		window.location.href = '<?php echo $configUrl;?>login'; // Insira o link desejado aqui
																	}
																});					
															}else{

																Swal.fire({
																	icon: 'error',
																	title: 'Erro',
																	text: 'Não foi possível realizar a reserva.'
																});
															}
														}
													});
												}

												function carregaPagina(){
													location.href="<?php echo $configUrl.'loteamentos/'.$url[3].'/';?>";
												}
																							
												function fazerContrato(codLote) {
													document.getElementById("loteContrato").value=codLote;
													document.getElementById("formContrato").submit();
												}

												function cancelarReserva(codLote){
													var $tgsh = jQuery.noConflict();

													Swal.fire({
														title: 'Cancelando Reserva...',
														text: 'Por favor, aguarde...',
														allowOutsideClick: false,
														didOpen: () => {
															Swal.showLoading();
														}
													});		
														
													$tgsh.post("<?php echo $configUrl;?>loteamentos/cancela-reserva.php", {codLote: codLote}, function(data){
														if(data.trim() == "ok"){
															Swal.fire({
																icon: 'success',
																title: 'Reserva cancelada com sucesso!',
																showConfirmButton: false,
																timer: 3000
															});					
															setTimeout("carregaPagina()", 3000);
														}else{
															Swal.fire({
																icon: 'error',
																title: 'Erro',
																text: 'Não foi possível cancelar a reserva.'
															});
														}
													});															
												}		

												// Estilo CSS para os botões
												const style = document.createElement('style');
												style.textContent = `
												  .btn-confirmar {
													background-color: #FF0000; /* Cor de fundo do botão "Fechar" */
													color: white; /* Cor do texto */
													border: none; /* Sem borda */
													border-radius: 5px; /* Bordas arredondadas */
													padding: 10px 20px; /* Padding */
													margin:10px;
													cursor: pointer; /* Cursor em forma de mão */
													font-size: 16px; /* Tamanho da fonte */
												  }

												  .btn-confirmar:hover {
													background-color: #fd4545; /* Cor de fundo ao passar o mouse */
												  }

												  .btn-reservar {
													background-color: #421717; /* Cor de fundo */
													color: white; /* Cor do texto */
													border: none; /* Sem borda */
													border-radius: 5px; /* Bordas arredondadas */
													padding: 10px 20px; /* Padding */
													margin:10px;
													cursor: pointer; /* Cursor em forma de mão */
													font-size: 16px; /* Tamanho da fonte */
												  }

												  .btn-reservar:hover {
													background-color: #462222; /* Cor de fundo ao passar o mouse */
												  }

												  .swal2-cancel {
													background-color: #91b16c; /* Cor de fundo do botão "Fazer Contrato" */
													color: white; /* Cor do texto */
													border: none; /* Sem borda */
													border-radius: 5px; /* Bordas arredondadas */
													padding: 10px 20px; /* Padding */
													margin:10px;
													cursor: pointer; /* Cursor em forma de mão */
													font-size: 16px; /* Tamanho da fonte */
												  }

												  .swal2-cancel:hover {
													background-color: #acbd98; /* Cor de fundo ao passar o mouse */
												  }
												`;
												document.head.appendChild(style); 


												function buscaLoteData(codLote) {
												  return fetch('<?php echo $configUrl;?>loteamentos/busca-lote-mapa.php', {
													method: 'POST',
													headers: {
													  'Content-Type': 'application/x-www-form-urlencoded'
													},
													body: 'codLote=' + encodeURIComponent(codLote)
												  })
												  .then(response => response.json())
												  .then(data => {
													if (data.success) {
													  return data;
													} else {
													  Swal.fire('Erro', 'Não foi possível obter os dados do lote.', 'error');
													  return null;
													}
												  })
												  .catch(error => {
													console.error('Erro:', error);
													Swal.fire('Erro', 'Ocorreu um erro ao buscar os dados.', 'error');
												  });
												}			
																						
											</script>
											</div>
											<form id="formContrato" action="<?php echo $configUrl;?>minha-conta/negociacoes/" method="post">
												<input type="hidden" value="" name="loteContrato" id="loteContrato"/>
											</form>
									</div>
									<br class="clear"/>
								</div>
							</div>
<?php
	}else{
		$_SESSION['voltar'] = $arquivoRetornar;
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login/'>";		
	}
?>
