<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "negociacoes";
			if(validaAcesso($conn, $area) == "ok"){
				
				if(isset($_POST['exibir-filtro-negociacoes'])){
					$_SESSION['exibir-filtro-negociacoes'] = $_POST['exibir-filtro-negociacoes'];
				}
				
				if(isset($_POST['clientesNegociacao-filtro'])){
					if($_POST['clientesNegociacao-filtro'] != ""){
						$_SESSION['clientesNegociacao-filtro'] = $_POST['clientesNegociacao-filtro'];
					}else{
						$_SESSION['clientesNegociacao-filtro'] = "";
					}
				}
				
				if($_SESSION['clientesNegociacao-filtro'] != ""){
					$filtraCliente = " and N.nomeClienteNegociacao = '".$_SESSION['clientesNegociacao-filtro']."'";
				}

				if(isset($_POST['usuario-filtro-negociacoes'])){
					if($_POST['usuario-filtro-negociacoes'] != ""){
						$_SESSION['usuario-filtro-negociacoes'] = $_POST['usuario-filtro-negociacoes'];
					}else{
						$_SESSION['usuario-filtro-negociacoes'] = "";
					}
				}								

				if($_SESSION['usuario-filtro-negociacoes'] != ""){
					$filtraUsuario = " and N.codUsuario = ".$_SESSION['usuario-filtro-negociacoes']."";
				}


				if(isset($_POST['ramo-filtro-negociacoes'])){
					if($_POST['ramo-filtro-negociacoes'] != ""){
						$_SESSION['ramo-filtro-negociacoes'] = $_POST['ramo-filtro-negociacoes'];
					}else{
						$_SESSION['ramo-filtro-negociacoes'] = "";
					}
				}	
								
				if($_SESSION['ramo-filtro-negociacoes'] != ""){
					$filtraRamo = " and N.codRamo = ".$_SESSION['ramo-filtro-negociacoes']."";
				}

				if(isset($_POST['tipoPagamento-filtro-negociacoes'])){
					if($_POST['tipoPagamento-filtro-negociacoes'] != ""){
						$_SESSION['tipoPagamento-filtro-negociacoes'] = $_POST['tipoPagamento-filtro-negociacoes'];
					}else{
						$_SESSION['tipoPagamento-filtro-negociacoes'] = "";
					}
				}	
												
				if($_SESSION['tipoPagamento-filtro-negociacoes'] != ""){
					$filtraTipoPagamento = " and CA.codTipoPagamento = ".$_SESSION['tipoPagamento-filtro-negociacoes']."";
				}

				if(isset($_POST['resultado-filtro-negociacoes'])){
					if($_POST['resultado-filtro-negociacoes'] != ""){
						$_SESSION['resultado-filtro-negociacoes'] = $_POST['resultado-filtro-negociacoes'];
					}else{
						$_SESSION['resultado-filtro-negociacoes'] = "";
					}
				}
				
				if($_SESSION['resultado-filtro-negociacoes'] != ""){
					$filtraNegociacao = " and N.resultadoNegociacao = '".$_SESSION['resultado-filtro-negociacoes']."'";
				}

				if(isset($_POST['fechamento-filtro-negociacoes'])){
					if($_POST['fechamento-filtro-negociacoes'] != ""){
						$_SESSION['fechamento-filtro-negociacoes'] = $_POST['fechamento-filtro-negociacoes'];
					}else{
						$_SESSION['fechamento-filtro-negociacoes'] = "";
					}
				}
				
				if($_SESSION['fechamento-filtro-negociacoes'] != ""){
					$filtraFechamento = " and N.fechamentoNegociacao = '".$_SESSION['fechamento-filtro-negociacoes']."'";
				}

				if(isset($_POST['mes-filtro-negociacoes'])){
					if($_POST['mes-filtro-negociacoes'] != ""){
						$_SESSION['mes-filtro-negociacoes'] = $_POST['mes-filtro-negociacoes'];
					}else{
						$_SESSION['mes-filtro-negociacoes'] = "";
					}
				}
				
				if($_SESSION['mes-filtro-negociacoes'] != ""){
					$filtraMes = " and date_format(dataFimNegociacao, '%m') = '".$_SESSION['mes-filtro-negociacoes']."'";
				}

				if(isset($_POST['ano-filtro-negociacoes'])){
					if($_POST['ano-filtro-negociacoes'] != ""){
						$_SESSION['ano-filtro-negociacoes'] = $_POST['ano-filtro-negociacoes'];
					}else{
						$_SESSION['ano-filtro-negociacoes'] = "";
					}
				}

				if($_SESSION['ano-filtro-negociacoes'] != ""){
					$filtraAno = " and date_format(dataFimNegociacao, '%Y') = '".$_SESSION['ano-filtro-negociacoes']."'";
				}
				
				if($_SESSION['exibir-filtro-negociacoes'] == ""){
					$_SESSION['exibir-filtro-negociacoes'] = "C";
				}
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Comercial</p>
						<p class="flexa"></p>
						<p class="nome-lista">Negociações</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
							<script type="text/javascript">
								function habilitaFiltros(exibir){
									if(exibir == "C"){
										document.getElementById("usuario-filtro-negociacoes").disabled = false;									
										document.getElementById("busca_autocomplete_softbest_clientesNegociacao").disabled = true;									
										document.getElementById("ramo-filtro-negociacoes").disabled = true;									
										document.getElementById("tipoPagamento-filtro-negociacoes").disabled = true;									
										document.getElementById("resultado-filtro-negociacoes").disabled = true;									
										document.getElementById("fechamento-filtro-negociacoes").disabled = true;									
										document.getElementById("mes-filtro-negociacoes").disabled = true;									
										document.getElementById("ano-filtro-negociacoes").disabled = true;									
									}else{
										document.getElementById("usuario-filtro-negociacoes").disabled = false;									
										document.getElementById("busca_autocomplete_softbest_clientesNegociacao").disabled = false;									
										document.getElementById("ramo-filtro-negociacoes").disabled = false;									
										document.getElementById("tipoPagamento-filtro-negociacoes").disabled = false;									
										document.getElementById("resultado-filtro-negociacoes").disabled = false;									
										document.getElementById("fechamento-filtro-negociacoes").disabled = false;									
										document.getElementById("mes-filtro-negociacoes").disabled = false;									
										document.getElementById("ano-filtro-negociacoes").disabled = false;											
									}
								}
							 </script>	
							<form name="filtro" action="<?php echo $configUrl;?>comercial/negociacoes/" method="post" >
								<p><label class="label">Exibir:</label>
									<select class="campo" id="exibir" style="width:100px; margin-right:0px;" name="exibir-filtro-negociacoes" onChange="habilitaFiltros(this.value);">
										<option value="C" <?php echo $_SESSION['exibir-filtro-negociacoes'] == "C" ? '/SELECTED/' : '';?> >Coluna</option>
										<option value="T" <?php echo $_SESSION['exibir-filtro-negociacoes'] == "T" ? '/SELECTED/' : '';?> >Tabela</option>
									</select>
								</p>
								
								<div id="auto_complete_softbest" style="width:167px; float:left; margin-bottom:15px;">
									<p class="bloco-campo" style="margin-bottom:0px;"><label>Filtrar Cliente: <span class="obrigatorio"> </span></label>
									<input class="campo" <?php echo $_SESSION['exibir-filtro-negociacoes'] == "C" ? 'disabled="disabled"' : '';?> type="text" name="clientesNegociacao-filtro" style="width:150px;" value="<?php echo $_SESSION['clientesNegociacao-filtro']; ?>" onClick="auto_complete(this.value, 'clientesNegociacao', event);" onKeyUp="auto_complete(this.value, 'clientesNegociacao', event);" onkeydown="if (getKey(event) == 13) return false;" onBlur="fechaAutoComplete('clientesNegociacao');" autocomplete="off" id="busca_autocomplete_softbest_clientesNegociacao" /></p>
									<br class="clear"/>
									
									<div id="exibe_busca_autocomplete_softbest_clientesNegociacao" class="auto_complete_softbest" style="width:165px; display:none;">

									</div>
								</div>
																
								<p><label class="label">Corretor(a):</label>
<?php
				if($dadosUsuario['tipoUsuario'] != "C"){
?>
									<select class="campo" id="usuario-filtro-negociacoes" style="width:115px; margin-right:0px;" name="usuario-filtro-negociacoes">
										<option value="">Todos</option>
<?php
					$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4 ORDER BY nomeUsuario ASC, codUsuario ASC";
					$resultUsuario = $conn->query($sqlUsuario);
					while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
										<option value="<?php echo $dadosUsuario['codUsuario'];?>" <?php echo $_SESSION['usuario-filtro-negociacoes'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?> ><?php echo $dadosUsuario['nomeUsuario'];?></option>
<?php
					}
?>
									</select>
<?php
				}else{
					$filtraUsuario = " and N.codUsuario = ".$dadosUsuario['codUsuario']."";
?>
									<label style="font-weight:normal;"><?php echo $dadosUsuario['nomeUsuario'];?></label>
<?php
				}
?>	
								</p>
								
								<p><label class="label">Categoria:</label>							
									<select class="campo" <?php echo $_SESSION['exibir-filtro-negociacoes'] == "C" ? 'disabled="disabled"' : '';?> id="tipoPagamento-filtro-negociacoes" style="width:133px; margin-right:0px;" name="tipoPagamento-filtro-negociacoes">
										<option value="">Todos</option>
<?php
				$sqlTipoPagamento = "SELECT nomeTipoPagamento, codTipoPagamento FROM tipoPagamento WHERE statusTipoPagamento = 'T' and tipoPagamento = 'R' ORDER BY nomeTipoPagamento ASC, codTipoPagamento ASC";
				$resultTipoPagamento = $conn->query($sqlTipoPagamento);
				while($dadosTipoPagamento = $resultTipoPagamento->fetch_assoc()){
?>
										<option value="<?php echo $dadosTipoPagamento['codTipoPagamento'];?>" <?php echo $_SESSION['tipoPagamento-filtro-negociacoes'] == $dadosTipoPagamento['codTipoPagamento'] ? '/SELECTED/' : '';?> ><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></option>
<?php
				}
?>

									</select>
								</p>
															
								<p><label class="label">Etapa:</label>
									<select class="campo" id="resultado-filtro-negociacoes" <?php echo $_SESSION['exibir-filtro-negociacoes'] == "C" ? 'disabled="disabled"' : '';?> style="width:160px; margin-right:0px;" name="resultado-filtro-negociacoes">
										<option value="">Todos</option>
										<option value="C" <?php echo $_SESSION['resultado-filtro-negociacoes'] == "C" ? '/SELECTED/' : '';?> >Lead/Contato</option>
										<option value="EM" <?php echo $_SESSION['resultado-filtro-negociacoes'] == "EM" ? '/SELECTED/' : '';?> >Apresentação</option>
										<option value="V" <?php echo $_SESSION['resultado-filtro-negociacoes'] == "V" ? '/SELECTED/' : '';?> >Visita</option>
										<option value="EP" <?php echo $_SESSION['resultado-filtro-negociacoes'] == "EP" ? '/SELECTED/' : '';?> >Fechamento</option>
										<option value="AC" <?php echo $_SESSION['resultado-filtro-negociacoes'] == "AC" ? '/SELECTED/' : '';?> >Contrato</option>
										<option value="R" <?php echo $_SESSION['resultado-filtro-negociacoes'] == "R" ? '/SELECTED/' : '';?> >Retorno</option>
									</select>
								</p>
							
								<p><label class="label">Fechamento:</label>
									<select class="campo" id="fechamento-filtro-negociacoes" <?php echo $_SESSION['exibir-filtro-negociacoes'] == "C" ? 'disabled="disabled"' : '';?> style="width:120px; margin-right:0px;" name="fechamento-filtro-negociacoes">
										<option value="">Todos</option>
										<option value="EA" <?php echo $_SESSION['fechamento-filtro-negociacoes'] == "EA" ? '/SELECTED/' : '';?> >Em Aberto</option>
										<option value="F" <?php echo $_SESSION['fechamento-filtro-negociacoes'] == "F" ? '/SELECTED/' : '';?> >Fechado</option>
										<option value="NF" <?php echo $_SESSION['fechamento-filtro-negociacoes'] == "NF" ? '/SELECTED/' : '';?> >Não Fechado</option>
									</select>
								</p>

								<p><label class="label">Mês:</label>
									<select class="campo" id="mes-filtro-negociacoes" <?php echo $_SESSION['exibir-filtro-negociacoes'] == "C" ? 'disabled="disabled"' : '';?> name="mes-filtro-negociacoes" style="width:100px; margin-right:0px;">
										<option value="">Todos</option>
										<option value="01" <?php echo $_SESSION['mes-filtro-negociacoes'] == '01' ? '/SELECTED/' : '';?>>Janeiro</option>
										<option value="02" <?php echo $_SESSION['mes-filtro-negociacoes'] == '02' ? '/SELECTED/' : '';?>>Fevereiro</option>
										<option value="03" <?php echo $_SESSION['mes-filtro-negociacoes'] == '03' ? '/SELECTED/' : '';?>>Março</option>
										<option value="04" <?php echo $_SESSION['mes-filtro-negociacoes'] == '04' ? '/SELECTED/' : '';?>>Abril</option>
										<option value="05" <?php echo $_SESSION['mes-filtro-negociacoes'] == '05' ? '/SELECTED/' : '';?>>Maio</option>
										<option value="06" <?php echo $_SESSION['mes-filtro-negociacoes'] == '06' ? '/SELECTED/' : '';?>>Junho</option>
										<option value="07" <?php echo $_SESSION['mes-filtro-negociacoes'] == '07' ? '/SELECTED/' : '';?>>Julho</option>
										<option value="08" <?php echo $_SESSION['mes-filtro-negociacoes'] == '08' ? '/SELECTED/' : '';?>>Agosto</option>
										<option value="09" <?php echo $_SESSION['mes-filtro-negociacoes'] == '09' ? '/SELECTED/' : '';?>>Setembro</option>
										<option value="10" <?php echo $_SESSION['mes-filtro-negociacoes'] == '10' ? '/SELECTED/' : '';?>>Outubro</option>
										<option value="11" <?php echo $_SESSION['mes-filtro-negociacoes'] == '11' ? '/SELECTED/' : '';?>>Novembro</option>
										<option value="12" <?php echo $_SESSION['mes-filtro-negociacoes'] == '12' ? '/SELECTED/' : '';?>>Dezembro</option>
									</select>
								</p>
								
								<p><label class="label">Ano:</label>
									<select class="campo" id="ano-filtro-negociacoes" <?php echo $_SESSION['exibir-filtro-negociacoes'] == "C" ? 'disabled="disabled"' : '';?> name="ano-filtro-negociacoes" style="width:75px; margin-right:0px;">
										<option value="">Todos</option>
										<option value="2011" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2011' ? '/SELECTED/' : '';?>>2011</option>
										<option value="2012" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2012' ? '/SELECTED/' : '';?>>2012</option>
										<option value="2013" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2013' ? '/SELECTED/' : '';?>>2013</option>
										<option value="2014" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2014' ? '/SELECTED/' : '';?>>2014</option>
										<option value="2015" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2015' ? '/SELECTED/' : '';?>>2015</option>
										<option value="2016" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2016' ? '/SELECTED/' : '';?>>2016</option>
										<option value="2017" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2017' ? '/SELECTED/' : '';?>>2017</option>
										<option value="2018" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2018' ? '/SELECTED/' : '';?>>2018</option>
										<option value="2019" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2019' ? '/SELECTED/' : '';?>>2019</option>
										<option value="2020" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2020' ? '/SELECTED/' : '';?>>2020</option>
										<option value="2021" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2021' ? '/SELECTED/' : '';?>>2021</option>
										<option value="2022" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2022' ? '/SELECTED/' : '';?>>2022</option>
										<option value="2023" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2023' ? '/SELECTED/' : '';?>>2023</option>
										<option value="2024" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2024' ? '/SELECTED/' : '';?>>2024</option>
										<option value="2025" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2025' ? '/SELECTED/' : '';?>>2025</option>
										<option value="2026" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2026' ? '/SELECTED/' : '';?>>2026</option>
										<option value="2027" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2027' ? '/SELECTED/' : '';?>>2027</option>
										<option value="2028" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2028' ? '/SELECTED/' : '';?>>2028</option>
										<option value="2029" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2029' ? '/SELECTED/' : '';?>>2029</option>
										<option value="2030" <?php echo $_SESSION['ano-filtro-negociacoes'] == '2030' ? '/SELECTED/' : '';?>>2030</option>
									</select>
								</p>
								
								<p class="botao-filtrar" style="margin-right:0px; margin-top:19px;"><input type="submit" name="filtrar" value="Filtrar" /></p>
																
								<div class="botao-novo" style="margin-top:18px;"><a title="Nova Negociação" onClick="abreCadastraNegociacao();"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Negociação</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>			
				</div>
				<div id="dados-conteudo">
<?php
				if($_SESSION['exibir-filtro-negociacoes'] == "C"){
?>
					<div id="carrega-negociacoes">
						<script>
							var $tg = jQuery.noConflict();
							
							var dragged;
							var codNegociacao;

							/* events fired on the draggable target */
							document.addEventListener("drag", function(event) {
								console.log("entra");
							}, false);

							function getInicio(event, etapa){
								console.log(etapa);
							};

							function getDiv(event, cod){
								dragged = event.target;
								codNegociacao = cod;
								event.target.style.opacity = "0.4";
							};

							document.addEventListener("dragend", function(event) {
								$tg(".dropzone").css("background", "#f5f5f5");
								$tg(".dropzone").css("padding-top", "0px");
								$tg(".dropzone").css("height", "557px");						  
								event.target.style.opacity = 1;
							}, false);

							/* events fired on the drop targets */
							document.addEventListener("dragover", function(event) {
							  // prevent default to allow drop
							  event.preventDefault();
							}, false);

							function hoverDiv(event, etapa){
								$tg(".dropzone").css("background", "#f5f5f5");
								$tg(".dropzone").css("padding-top", "0px");
								$tg(".dropzone").css("height", "557px");
								$tg("#mostra-negociacoes"+etapa).css("background", "#ccc");
								$tg("#mostra-negociacoes"+etapa).css("padding-top", "130px");
								$tg("#mostra-negociacoes"+etapa).css("height", "427px");
							}
							
							function dropDiv(event, etapa){
								event.preventDefault();
								if (event.target.className == "dropzone") {
									event.target.style.background = "#f5f5f5";
									event.target.style.paddingTop = "0px";								
									event.target.style.height = "557px";								
									dragged.parentNode.removeChild(dragged);
									event.target.prepend(dragged);
									
									$tg.post("<?php echo $configUrl;?>comercial/negociacoes/altera-resultado.php", {codNegociacao: codNegociacao, resultado: etapa}, function(data){
										if(etapa == "5"){	
											abrirCompromisso(codNegociacao, "T");
										}
									});										
								}
							}					
						</script>
<?php
					$sqlConta = "SELECT count(N.codNegociacao) registros, N.nomeClienteNegociacao FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.codNegociacao != '' ".$filtraUsuario;
					$resultConta = $conn->query($sqlConta);
					$dadosConta = $resultConta->fetch_assoc();
					$registros = $dadosConta['registros'];
					
					if($dadosConta['nomeClienteNegociacao'] != ""){
?>
						<div id="consultas" style="background-color:#406993; border-radius:15px 15px 0px 0px;">
							<div id="exibe-etapa" class="esq-bloco">
								<p class="titulo-etapa esq">Lead</p>
								<div id="mostra-negociacoes1" class="dropzone" ondrop="dropDiv(event, 'C');" ondragenter="hoverDiv(event, 'C');">
<?php
						$sqlNegociacoes = "SELECT * FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.fechamentoNegociacao = 'EA' and N.resultadoNegociacao = 'C'".$filtraUsuario." ORDER BY N.dataAtualizaNegociacao DESC, N.horaAtualizaNegociacao DESC";
						$resultNegociacoes = $conn->query($sqlNegociacoes);
						while($dadosNegociacoes = $resultNegociacoes->fetch_assoc()){
							
							$data1 = new DateTime(date('Y-m-d'));							
							$data2 = new DateTime($dadosNegociacoes['dataCadastroNegociacao']);
							$intervalo = $data1->diff( $data2 );

							if($intervalo->y >= 2){
								$anos = "anos";
							}else{
								$anos = "ano";
							}
							
							if($intervalo->m >= 2){
								$meses = "meses";
							}else{
								$meses = "mês";
							}
							
							if($intervalo->d >= 2){
								$dias = "dias";
							}else{
								$dias = "dia";
							}
															
							if($intervalo->y >= 1){
								
								if($intervalo->m >= 1){
									$tempo = "{$intervalo->y} $anos e {$intervalo->m} $meses";
								}else{
									$tempo = "{$intervalo->y} $anos";
								}
								
							}else
							if($intervalo->m >= 1){
								if($intervalo->d >= 1){	
									$tempo = "{$intervalo->m} $meses e {$intervalo->d} $dias";
								}else{
									$tempo = "{$intervalo->m} $meses";										
								}									
							}else
							if($intervalo->d >= 1){
								$tempo = "{$intervalo->d} $dias";																		
							}else
							if($intervalo->d == 0){
								$tempo = "Hoje";
							}

							$sqlCompromisso = "SELECT * FROM compromissos WHERE codNegociacao = ".$dadosNegociacoes['codNegociacao']." and dataCompromisso >= '".date('Y-m-d')."' ORDER BY dataCompromisso ASC, codCompromisso DESC LIMIT 0,1";
							$resultCompromisso = $conn->query($sqlCompromisso);
							$dadosCompromisso = $resultCompromisso->fetch_assoc();								
?>
									<div class="bloco-negociacao<?php echo $dadosNegociacoes['codNegociacao'];?>" id="draggable" draggable="true" ondragstart="getDiv(event, <?php echo $dadosNegociacoes['codNegociacao'];?>);">
										<p class="cliente"><span>Cliente</span><br/><?php echo $dadosNegociacoes['nomeClienteNegociacao'];?></p>
										<p class="servico"><span>Categoria</span><br/><?php echo $dadosNegociacoes['nomeTipoPagamento'];?></p>
										<p class="vendedor"><span>Corretor(a)</span><br/><?php echo $dadosNegociacoes['nomeUsuario'];?></p>
										<br class="clear"/>
										<p class="tempo"><span>Tempo</span><br/><?php echo $tempo;?></p>
										<div class="acoes">
											<p class="fechado" onClick="fechamentoNegociacao('F', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="nao-fechado" onClick="fechamentoNegociacao('NF', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="editar" onClick="editarNegociacao(<?php echo $dadosNegociacoes['codNegociacao'];?>)"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/icone-editar.svg" width="22"/></p>
											<p class="compromisso<?php echo $dadosCompromisso['codCompromisso'] != "" ? '-ativo' : '';?>" onClick="abrirCompromisso(<?php echo $dadosNegociacoes['codNegociacao'];?>, 'F');"></p>
										</div>
										<br class="clear"/>
									</div>									
<?php
						}
?>								
								</div>
							</div>	
							<div id="exibe-etapa">
								<p class="titulo-etapa">Apresentação</p>
								<div id="mostra-negociacoes2" class="dropzone" ondrop="dropDiv(event, 'EM');" ondragenter="hoverDiv(event, 'EM');">
<?php
						$sqlNegociacoes = "SELECT * FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.fechamentoNegociacao = 'EA' and N.resultadoNegociacao = 'EM'".$filtraUsuario." ORDER BY N.dataAtualizaNegociacao DESC, N.horaAtualizaNegociacao DESC";
						$resultNegociacoes = $conn->query($sqlNegociacoes);
						while($dadosNegociacoes = $resultNegociacoes->fetch_assoc()){
							
							$data1 = new DateTime(date('Y-m-d'));							
							$data2 = new DateTime($dadosNegociacoes['dataCadastroNegociacao']);
							$intervalo = $data1->diff( $data2 );

							if($intervalo->y >= 2){
								$anos = "anos";
							}else{
								$anos = "ano";
							}
							
							if($intervalo->m >= 2){
								$meses = "meses";
							}else{
								$meses = "mês";
							}
							
							if($intervalo->d >= 2){
								$dias = "dias";
							}else{
								$dias = "dia";
							}
															
							if($intervalo->y >= 1){
								
								if($intervalo->m >= 1){
									$tempo = "{$intervalo->y} $anos e {$intervalo->m} $meses";
								}else{
									$tempo = "{$intervalo->y} $anos";
								}
								
							}else
							if($intervalo->m >= 1){
								if($intervalo->d >= 1){	
									$tempo = "{$intervalo->m} $meses e {$intervalo->d} $dias";
								}else{
									$tempo = "{$intervalo->m} $meses";										
								}									
							}else
							if($intervalo->d >= 1){
								$tempo = "{$intervalo->d} $dias";																		
							}else
							if($intervalo->d == 0){
								$tempo = "Hoje";
							}

							$sqlCompromisso = "SELECT * FROM compromissos WHERE codNegociacao = ".$dadosNegociacoes['codNegociacao']." and dataCompromisso >= '".date('Y-m-d')."' ORDER BY dataCompromisso ASC, codCompromisso DESC LIMIT 0,1";
							$resultCompromisso = $conn->query($sqlCompromisso);
							$dadosCompromisso = $resultCompromisso->fetch_assoc();														
?>
									<div class="bloco-negociacao<?php echo $dadosNegociacoes['codNegociacao'];?>" id="draggable" draggable="true" ondragstart="getDiv(event, <?php echo $dadosNegociacoes['codNegociacao'];?>);">
										<p class="cliente"><span>Cliente</span><br/><?php echo $dadosNegociacoes['nomeClienteNegociacao'];?></p>
										<p class="servico"><span>Categoria</span><br/><?php echo $dadosNegociacoes['nomeTipoPagamento'];?></p>
										<p class="vendedor"><span>Corretor(a)</span><br/><?php echo $dadosNegociacoes['nomeUsuario'];?></p>
										<br class="clear"/>
										<p class="tempo"><span>Tempo</span><br/><?php echo $tempo;?></p>
										<div class="acoes">
											<p class="fechado" onClick="fechamentoNegociacao('F', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="nao-fechado" onClick="fechamentoNegociacao('NF', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="editar" onClick="editarNegociacao(<?php echo $dadosNegociacoes['codNegociacao'];?>)"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/icone-editar.svg" width="22"/></p>
											<p class="compromisso<?php echo $dadosCompromisso['codCompromisso'] != "" ? '-ativo' : '';?>" onClick="abrirCompromisso(<?php echo $dadosNegociacoes['codNegociacao'];?>, 'F');"></p>
										</div>
										<br class="clear"/>
									</div>									
<?php
						}
?>															
								</div>
							</div>	
							<div id="exibe-etapa">
								<p class="titulo-etapa">Visita</p>
								<div id="mostra-negociacoes6" class="dropzone" ondrop="dropDiv(event, 'V');" ondragenter="hoverDiv(event, 'V');">
<?php
						$sqlNegociacoes = "SELECT * FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.fechamentoNegociacao = 'EA' and N.resultadoNegociacao = 'V'".$filtraUsuario." ORDER BY N.dataAtualizaNegociacao DESC, N.horaAtualizaNegociacao DESC";
						$resultNegociacoes = $conn->query($sqlNegociacoes);
						while($dadosNegociacoes = $resultNegociacoes->fetch_assoc()){
							
							$data1 = new DateTime(date('Y-m-d'));							
							$data2 = new DateTime($dadosNegociacoes['dataCadastroNegociacao']);
							$intervalo = $data1->diff( $data2 );

							if($intervalo->y >= 2){
								$anos = "anos";
							}else{
								$anos = "ano";
							}
							
							if($intervalo->m >= 2){
								$meses = "meses";
							}else{
								$meses = "mês";
							}
							
							if($intervalo->d >= 2){
								$dias = "dias";
							}else{
								$dias = "dia";
							}
															
							if($intervalo->y >= 1){
								
								if($intervalo->m >= 1){
									$tempo = "{$intervalo->y} $anos e {$intervalo->m} $meses";
								}else{
									$tempo = "{$intervalo->y} $anos";
								}
								
							}else
							if($intervalo->m >= 1){
								if($intervalo->d >= 1){	
									$tempo = "{$intervalo->m} $meses e {$intervalo->d} $dias";
								}else{
									$tempo = "{$intervalo->m} $meses";										
								}									
							}else
							if($intervalo->d >= 1){
								$tempo = "{$intervalo->d} $dias";																		
							}else
							if($intervalo->d == 0){
								$tempo = "Hoje";
							}

							$sqlCompromisso = "SELECT * FROM compromissos WHERE codNegociacao = ".$dadosNegociacoes['codNegociacao']." and dataCompromisso >= '".date('Y-m-d')."' ORDER BY dataCompromisso ASC, codCompromisso DESC LIMIT 0,1";
							$resultCompromisso = $conn->query($sqlCompromisso);
							$dadosCompromisso = $resultCompromisso->fetch_assoc();														
?>
									<div class="bloco-negociacao<?php echo $dadosNegociacoes['codNegociacao'];?>" id="draggable" draggable="true" ondragstart="getDiv(event, <?php echo $dadosNegociacoes['codNegociacao'];?>);">
										<p class="cliente"><span>Cliente</span><br/><?php echo $dadosNegociacoes['nomeClienteNegociacao'];?></p>
										<p class="servico"><span>Categoria</span><br/><?php echo $dadosNegociacoes['nomeTipoPagamento'];?></p>
										<p class="vendedor"><span>Corretor(a)</span><br/><?php echo $dadosNegociacoes['nomeUsuario'];?></p>
										<br class="clear"/>
										<p class="tempo"><span>Tempo</span><br/><?php echo $tempo;?></p>
										<div class="acoes">
											<p class="fechado" onClick="fechamentoNegociacao('F', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="nao-fechado" onClick="fechamentoNegociacao('NF', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="editar" onClick="editarNegociacao(<?php echo $dadosNegociacoes['codNegociacao'];?>)"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/icone-editar.svg" width="22"/></p>
											<p class="compromisso<?php echo $dadosCompromisso['codCompromisso'] != "" ? '-ativo' : '';?>" onClick="abrirCompromisso(<?php echo $dadosNegociacoes['codNegociacao'];?>, 'F');"></p>
										</div>
										<br class="clear"/>
									</div>									
<?php
						}
?>															
								</div>
							</div>								
							<div id="exibe-etapa">
								<p class="titulo-etapa">Fechamento</p>
								<div id="mostra-negociacoes3" class="dropzone" ondrop="dropDiv(event, 'EP');" ondragenter="hoverDiv(event, 'EP');">						
<?php
						$sqlNegociacoes = "SELECT * FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.fechamentoNegociacao = 'EA' and N.resultadoNegociacao = 'EP'".$filtraUsuario." ORDER BY N.dataAtualizaNegociacao DESC, N.horaAtualizaNegociacao DESC";
						$resultNegociacoes = $conn->query($sqlNegociacoes);
						while($dadosNegociacoes = $resultNegociacoes->fetch_assoc()){
							
							$data1 = new DateTime(date('Y-m-d'));							
							$data2 = new DateTime($dadosNegociacoes['dataCadastroNegociacao']);
							$intervalo = $data1->diff( $data2 );

							if($intervalo->y >= 2){
								$anos = "anos";
							}else{
								$anos = "ano";
							}
							
							if($intervalo->m >= 2){
								$meses = "meses";
							}else{
								$meses = "mês";
							}
							
							if($intervalo->d >= 2){
								$dias = "dias";
							}else{
								$dias = "dia";
							}
															
							if($intervalo->y >= 1){
								
								if($intervalo->m >= 1){
									$tempo = "{$intervalo->y} $anos e {$intervalo->m} $meses";
								}else{
									$tempo = "{$intervalo->y} $anos";
								}
								
							}else
							if($intervalo->m >= 1){
								if($intervalo->d >= 1){	
									$tempo = "{$intervalo->m} $meses e {$intervalo->d} $dias";
								}else{
									$tempo = "{$intervalo->m} $meses";										
								}									
							}else
							if($intervalo->d >= 1){
								$tempo = "{$intervalo->d} $dias";																		
							}else
							if($intervalo->d == 0){
								$tempo = "Hoje";
							}	

							$sqlCompromisso = "SELECT * FROM compromissos WHERE codNegociacao = ".$dadosNegociacoes['codNegociacao']." and dataCompromisso >= '".date('Y-m-d')."' ORDER BY dataCompromisso ASC, codCompromisso DESC LIMIT 0,1";
							$resultCompromisso = $conn->query($sqlCompromisso);
							$dadosCompromisso = $resultCompromisso->fetch_assoc();													
?>
									<div class="bloco-negociacao<?php echo $dadosNegociacoes['codNegociacao'];?>" id="draggable" draggable="true" ondragstart="getDiv(event, <?php echo $dadosNegociacoes['codNegociacao'];?>);">
										<p class="cliente"><span>Cliente</span><br/><?php echo $dadosNegociacoes['nomeClienteNegociacao'];?></p>
										<p class="servico"><span>Categoria</span><br/><?php echo $dadosNegociacoes['nomeTipoPagamento'];?></p>
										<p class="vendedor"><span>Corretor(a)</span><br/><?php echo $dadosNegociacoes['nomeUsuario'];?></p>
										<br class="clear"/>
										<p class="tempo"><span>Tempo</span><br/><?php echo $tempo;?></p>
										<div class="acoes">
											<p class="fechado" onClick="fechamentoNegociacao('F', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="nao-fechado" onClick="fechamentoNegociacao('NF', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="editar" onClick="editarNegociacao(<?php echo $dadosNegociacoes['codNegociacao'];?>)"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/icone-editar.svg" width="22"/></p>
											<p class="compromisso<?php echo $dadosCompromisso['codCompromisso'] != "" ? '-ativo' : '';?>" onClick="abrirCompromisso(<?php echo $dadosNegociacoes['codNegociacao'];?>, 'F');"></p>
										</div>
										<br class="clear"/>
									</div>									
<?php
						}
?>															
								</div>
							</div>	
							<div id="exibe-etapa">
								<p class="titulo-etapa">Contrato</p>
								<div id="mostra-negociacoes4" class="dropzone" ondrop="dropDiv(event, 'AC');" ondragenter="hoverDiv(event, 'AC');">
<?php
						$sqlNegociacoes = "SELECT * FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.fechamentoNegociacao = 'EA' and N.resultadoNegociacao = 'AC'".$filtraUsuario." ORDER BY N.dataAtualizaNegociacao DESC, N.horaAtualizaNegociacao DESC";
						$resultNegociacoes = $conn->query($sqlNegociacoes);
						while($dadosNegociacoes = $resultNegociacoes->fetch_assoc()){
							
							$data1 = new DateTime(date('Y-m-d'));							
							$data2 = new DateTime($dadosNegociacoes['dataCadastroNegociacao']);
							$intervalo = $data1->diff( $data2 );

							if($intervalo->y >= 2){
								$anos = "anos";
							}else{
								$anos = "ano";
							}
							
							if($intervalo->m >= 2){
								$meses = "meses";
							}else{
								$meses = "mês";
							}
							
							if($intervalo->d >= 2){
								$dias = "dias";
							}else{
								$dias = "dia";
							}
															
							if($intervalo->y >= 1){
								
								if($intervalo->m >= 1){
									$tempo = "{$intervalo->y} $anos e {$intervalo->m} $meses";
								}else{
									$tempo = "{$intervalo->y} $anos";
								}
								
							}else
							if($intervalo->m >= 1){
								if($intervalo->d >= 1){	
									$tempo = "{$intervalo->m} $meses e {$intervalo->d} $dias";
								}else{
									$tempo = "{$intervalo->m} $meses";										
								}									
							}else
							if($intervalo->d >= 1){
								$tempo = "{$intervalo->d} $dias";																		
							}else
							if($intervalo->d == 0){
								$tempo = "Hoje";
							}		

							$sqlCompromisso = "SELECT * FROM compromissos WHERE codNegociacao = ".$dadosNegociacoes['codNegociacao']." and dataCompromisso >= '".date('Y-m-d')."' ORDER BY dataCompromisso ASC, codCompromisso DESC LIMIT 0,1";
							$resultCompromisso = $conn->query($sqlCompromisso);
							$dadosCompromisso = $resultCompromisso->fetch_assoc();												
?>
									<div class="bloco-negociacao<?php echo $dadosNegociacoes['codNegociacao'];?>" id="draggable" draggable="true" ondragstart="getDiv(event, <?php echo $dadosNegociacoes['codNegociacao'];?>);">
										<p class="cliente"><span>Cliente</span><br/><?php echo $dadosNegociacoes['nomeClienteNegociacao'];?></p>
										<p class="servico"><span>Categoria</span><br/><?php echo $dadosNegociacoes['nomeTipoPagamento'];?></p>
										<p class="vendedor"><span>Corretor(a)</span><br/><?php echo $dadosNegociacoes['nomeUsuario'];?></p>
										<br class="clear"/>
										<p class="tempo"><span>Tempo</span><br/><?php echo $tempo;?></p>
										<div class="acoes">
											<p class="fechado" onClick="fechamentoNegociacao('F', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="nao-fechado" onClick="fechamentoNegociacao('NF', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="editar" onClick="editarNegociacao(<?php echo $dadosNegociacoes['codNegociacao'];?>)"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/icone-editar.svg" width="22"/></p>
											<p class="compromisso<?php echo $dadosCompromisso['codCompromisso'] != "" ? '-ativo' : '';?>" onClick="abrirCompromisso(<?php echo $dadosNegociacoes['codNegociacao'];?>, 'F');"></p>
										</div>
										<br class="clear"/>
									</div>									
<?php
						}
?>																						
								</div>
							</div>	
							<div id="exibe-etapa" class="dir-bloco" style="margin-right:0px;">
								<p class="titulo-etapa dir">Retorno</p>
								<div id="mostra-negociacoes5" class="dropzone" ondrop="dropDiv(event, 'R');" ondragenter="hoverDiv(event, 'R');"> 
<?php
						$sqlNegociacoes = "SELECT * FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.fechamentoNegociacao = 'EA' and N.resultadoNegociacao = 'R'".$filtraUsuario." ORDER BY N.dataAtualizaNegociacao DESC, N.horaAtualizaNegociacao DESC";
						$resultNegociacoes = $conn->query($sqlNegociacoes);
						while($dadosNegociacoes = $resultNegociacoes->fetch_assoc()){
							
							$data1 = new DateTime(date('Y-m-d'));							
							$data2 = new DateTime($dadosNegociacoes['dataCadastroNegociacao']);
							$intervalo = $data1->diff( $data2 );

							if($intervalo->y >= 2){
								$anos = "anos";
							}else{
								$anos = "ano";
							}
							
							if($intervalo->m >= 2){
								$meses = "meses";
							}else{
								$meses = "mês";
							}
							
							if($intervalo->d >= 2){
								$dias = "dias";
							}else{
								$dias = "dia";
							}
															
							if($intervalo->y >= 1){
								
								if($intervalo->m >= 1){
									$tempo = "{$intervalo->y} $anos e {$intervalo->m} $meses";
								}else{
									$tempo = "{$intervalo->y} $anos";
								}
								
							}else
							if($intervalo->m >= 1){
								if($intervalo->d >= 1){	
									$tempo = "{$intervalo->m} $meses e {$intervalo->d} $dias";
								}else{
									$tempo = "{$intervalo->m} $meses";										
								}									
							}else
							if($intervalo->d >= 1){
								$tempo = "{$intervalo->d} $dias";																		
							}else
							if($intervalo->d == 0){
								$tempo = "Hoje";
							}	

							$sqlCompromisso = "SELECT * FROM compromissos WHERE codNegociacao = ".$dadosNegociacoes['codNegociacao']." and dataCompromisso >= '".date('Y-m-d')."' ORDER BY dataCompromisso ASC, codCompromisso DESC LIMIT 0,1";
							$resultCompromisso = $conn->query($sqlCompromisso);
							$dadosCompromisso = $resultCompromisso->fetch_assoc();														
?>
									<div class="bloco-negociacao<?php echo $dadosNegociacoes['codNegociacao'];?>" id="draggable" draggable="true" ondragstart="getDiv(event, <?php echo $dadosNegociacoes['codNegociacao'];?>);">
										<p class="cliente"><span>Cliente</span><br/><?php echo $dadosNegociacoes['nomeClienteNegociacao'];?></p>
										<p class="servico"><span>Categoria</span><br/><?php echo $dadosNegociacoes['nomeTipoPagamento'];?></p>
										<p class="vendedor"><span>Corretor(a)</span><br/><?php echo $dadosNegociacoes['nomeUsuario'];?></p>
										<br class="clear"/>
										<p class="tempo"><span>Tempo</span><br/><?php echo $tempo;?></p>
										<div class="acoes">
											<p class="fechado" onClick="fechamentoNegociacao('F', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="nao-fechado" onClick="fechamentoNegociacao('NF', <?php echo $dadosNegociacoes['codNegociacao'];?>)"></p>
											<p class="editar" onClick="editarNegociacao(<?php echo $dadosNegociacoes['codNegociacao'];?>)"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/icone-editar.svg" width="22"/></p>
											<p class="compromisso<?php echo $dadosCompromisso['codCompromisso'] != "" ? '-ativo' : '';?>" onClick="abrirCompromisso(<?php echo $dadosNegociacoes['codNegociacao'];?>, 'F');"></p>
										</div>
										<br class="clear"/>
									</div>									
<?php
						}
?>																													
								</div>
							</div>	
							<br class="clear"/>
						</div>
<?php
					}else{
?>	
						<p class="msg">Nenhuma negociação foi encontra para o usuário selecionado!</p>
<?php
					}
?>
					</div>
<?php
				}else{
?>
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
				
					$sqlConta = "SELECT count(N.codNegociacao) registros, N.nomeClienteNegociacao FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.codNegociacao != '' ".$filtraCliente.$filtraUsuario.$filtraTipoPagamento.$filtraNegociacao.$filtraFechamento.$filtraDia.$filtraMes.$filtraAno.$filtraMidia;
					$resultConta = $conn->query($sqlConta);
					$dadosConta = $resultConta->fetch_assoc();
					$registros = $dadosConta['registros'];
					
					if($dadosConta['nomeClienteNegociacao'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Categoria</th>
								<th>Cliente</th>
								<th>Corretor(a)</th>
								<th>Tempo</th>
								<th>Cidade/UF</th>
								<th>Etapa</th>
								<th>Fechamento</th>
								<th class="canto-dir">Alterar</th>
							</tr>					
<?php
						if($url[5] == 1 || $url[5] == ""){
							$pagina = 1;
							$sqlNegociacao = "SELECT N.*, CO.nomeUsuario, CI.nomeCidade, ES.siglaEstado, CA.nomeTipoPagamento FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.codNegociacao != '' ".$filtraCliente.$filtraUsuario.$filtraTipoPagamento.$filtraNegociacao.$filtraFechamento.$filtraDia.$filtraMes.$filtraAno.$filtraMidia." ORDER BY N.fechamentoNegociacao ASC, N.dataAtualizaNegociacao DESC, N.horaAtualizaNegociacao DESC LIMIT 0,30";
						}else{
							$pagina = $url[5];
							$paginaFinal = $pagina * 30;
							$paginaInicial = $paginaFinal - 30;
							$sqlNegociacao = "SELECT N.*, CO.nomeUsuario, CI.nomeCidade, ES.siglaEstado, CA.nomeTipoPagamento FROM negociacoes N inner join usuarios CO on N.codUsuario = CO.codUsuario left join cidade CI on N.codCidade = CI.codCidade left join estado ES on CI.codEstado = ES.codEstado inner join tipoPagamento CA on N.codTipoPagamento = CA.codTipoPagamento WHERE N.codNegociacao != '' ".$filtraCliente.$filtraUsuario.$filtraTipoPagamento.$filtraNegociacao.$filtraFechamento.$filtraDia.$filtraMes.$filtraAno.$filtraMidia." ORDER BY N.fechamentoNegociacao ASC, N.dataAtualizaNegociacao DESC, N.horaAtualizaNegociacao DESC LIMIT ".$paginaInicial.",30";
						}		

						$resultNegociacao = $conn->query($sqlNegociacao);
						while($dadosNegociacao = $resultNegociacao->fetch_assoc()){
							$mostrando++;
							
							if($dadosNegociacao['statusNegociacao'] == "T"){
								$status = "status-ativo";
								$statusIcone = "ativado";
								$statusPergunta = "desativar";
							}else{
								$status = "status-desativado";
								$statusIcone = "desativado";
								$statusPergunta = "ativar";
							}		
							
							if($dadosNegociacao['resultadoNegociacao'] == "EP" || $dadosNegociacao['resultadoNegociacao'] == "AC"){
								$cor = "color:#FF0000; font-weight:bold;";
							}else
							if($dadosNegociacao['resultadoNegociacao'] == "EM" || $dadosNegociacao['resultadoNegociacao'] == "C"){
								$cor = "color:#FF0000;";
							}else
							if($dadosNegociacao['resultadoNegociacao'] == "R"){
								$cor = "color:#0000FF;";
							}else{
								$cor = "color:#000;";
							}
							
							if($dadosNegociacao['fechamentoNegociacao'] == "F"){
								$cor = "color:#000;";
							}else
							if($dadosNegociacao['fechamentoNegociacao'] == "NF"){
								$cor = "color:#444;";
							}

							$data1 = new DateTime(date('Y-m-d'));							
							$data2 = new DateTime($dadosNegociacao['dataCadastroNegociacao']);
							$intervalo = $data1->diff( $data2 );

							if($intervalo->y >= 2){
								$anos = "anos";
							}else{
								$anos = "ano";
							}
							
							if($intervalo->m >= 2){
								$meses = "meses";
							}else{
								$meses = "mês";
							}
							
							if($intervalo->d >= 2){
								$dias = "dias";
							}else{
								$dias = "dia";
							}
															
							if($intervalo->y >= 1){
								
								if($intervalo->m >= 1){
									$tempo = "{$intervalo->y} $anos e {$intervalo->m} $meses";
								}else{
									$tempo = "{$intervalo->y} $anos";
								}
								
							}else
							if($intervalo->m >= 1){
								if($intervalo->d >= 1){	
									$tempo = "{$intervalo->m} $meses e {$intervalo->d} $dias";
								}else{
									$tempo = "{$intervalo->m} $meses";										
								}									
							}else
							if($intervalo->d >= 1){
								$tempo = "{$intervalo->d} $dias";																		
							}else
							if($intervalo->d == 0){
								$tempo = "Hoje";
							}
							
							if($dadosNegociacao['fechamentoNegociacao'] != "EA"){
								if($dadosNegociacao['fechamentoNegociacao'] == "F"){
									$tempo = "<strong style='font-size:13px;'>Fechado</strong><br/>".data($dadosNegociacao['dataFimNegociacao']);
								}else{
									$tempo = "<strong style='font-size:13px;'>Não Fechado</strong><br/>".data($dadosNegociacao['dataFimNegociacao']);									
								}
							}						
?>

							<tr class="tr">
								<td class="vinte" style="width:15%;"><a class="corNegociacao<?php echo $dadosNegociacao['codNegociacao'];?>" style="padding:0px; <?php echo $cor;?>"><?php echo $dadosNegociacao['nomeTipoPagamento'];?></a></td>
								<td class="vinte" style="text-align:left;"><a class="corNegociacao<?php echo $dadosNegociacao['codNegociacao'];?>" style="padding:0px; <?php echo $cor;?>"><strong><?php echo $dadosNegociacao['nomeClienteNegociacao'].'</strong><br/>'.$dadosNegociacao['telefoneNegociacao'];?></a></td>
								<td class="dez" style="text-align:left;"><a class="corNegociacao<?php echo $dadosNegociacao['codNegociacao'];?>" style="padding:0px; <?php echo $cor;?>"><?php echo $dadosNegociacao['nomeUsuario'];?></a></td>
								<td class="dez" style="text-align:left;"><a class="dataNegociacao<?php echo $dadosNegociacao['codNegociacao'];?> corNegociacao<?php echo $dadosNegociacao['codNegociacao'];?>" style="padding:0px; <?php echo $cor;?>"><?php echo $tempo;?></a></td>
								<td class="vinte" style="text-align:left;"><a class="corNegociacao<?php echo $dadosNegociacao['codNegociacao'];?>" style="padding:0px; <?php echo $cor;?>"><?php echo $dadosNegociacao['nomeCidade']." / ".$dadosNegociacao['siglaEstado'];?></a></td>
								<td class="botoes">
									<form action="" method="post">
										<select class="campo" name="andamentoNegociacao"  onChange="alterarResultado(<?php echo $dadosNegociacao['codNegociacao'];?>, this.value);">
											<option value="C" <?php echo $dadosNegociacao['resultadoNegociacao'] == "C" ? '/SELECTED/' : '';?> >Lead/Contato</option>
											<option value="EM" <?php echo $dadosNegociacao['resultadoNegociacao'] == "EM" ? '/SELECTED/' : '';?> >Visita/Apresentação</option>
											<option value="EP" <?php echo $dadosNegociacao['resultadoNegociacao'] == "EP" ? '/SELECTED/' : '';?> >Fechamento</option>
											<option value="AC" <?php echo $dadosNegociacao['resultadoNegociacao'] == "AC" ? '/SELECTED/' : '';?> >Contrato</option>
											<option value="R" <?php echo $dadosNegociacao['resultadoNegociacao'] == "R" ? '/SELECTED/' : '';?> >Retorno</option>
										</select>
									</form>	
								</td>
								<td class="botoes">
									<div style="display:table; margin:0 auto;">
										<p id="fechado-lista<?php echo $dadosNegociacao['codNegociacao'];?>" class="fechado-lista<?php echo $dadosNegociacao['fechamentoNegociacao'] == "F" ? '-ativo' : '';?>" onClick="fechamentoNegociacao('F', <?php echo $dadosNegociacao['codNegociacao'];?>)"></p>
										<p id="nao-fechado-lista<?php echo $dadosNegociacao['codNegociacao'];?>" class="nao-fechado-lista<?php echo $dadosNegociacao['fechamentoNegociacao'] == "NF" ? '-ativo' : '';?>" onClick="fechamentoNegociacao('NF', <?php echo $dadosNegociacao['codNegociacao'];?>)"></p>
									</div>
								</td>
								<td class="botoes"><a style="cursor:pointer;" title='Deseja alterar a negociação com o cliente <?php echo $dadosNegociacao['nomeCliente'] ?>?'onClick="editarNegociacao(<?php echo $dadosNegociacao['codNegociacao'];?>)" ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
							</tr>
<?php
						}
?>						
						</table>	
<?php
					}
				
					$regPorPagina = 30;
					$area = "comercial/negociacoes";
					include ('f/conf/paginacao.php');
?>
					</div>
<?php
				}		
?>							
					<script src="https://code.jquery.com/jquery-3.0.0.min.js"></script>																							
					<script type="text/javascript">			
						function FormataStringData(data) {
						  var dia  = data.split("-")[2];
						  var mes  = data.split("-")[1];
						  var ano  = data.split("-")[0];

						  return ("0"+dia).slice(-2) + '/' + ("0"+mes).slice(-2) + '/' + ano;
						}

						function abrirCompromisso(cod, confere){
							var $trsvs6 = jQuery.noConflict();
							$trsvs6("#caixa-compromissos").fadeIn(200);
							$trsvs6("#caixa-compromissos").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-compromissos.php?codNegociacao="+cod+"&confere="+confere);																
						}

						function fecharCompromisso(){
							var $trsvs7 = jQuery.noConflict();
							$trsvs7("#caixa-compromissos").fadeOut(200, function(){
								$trsvs7("#caixa-compromissos").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Carregando aguarde...</p>");								
							});									
						}
												
						function cadastraCompromisso(){
							var $trs = jQuery.noConflict();
							
							var codNegociacao = document.getElementById("codNegociacao").value;
							var nomeCompromisso = document.getElementById("nomeCompromisso").value;
							var codUsuario = document.getElementById("usuario").value;
							var codTipoCompromisso = document.getElementById("codTipoCompromisso").value;
							var data = document.getElementById("data").value;
							var hora = document.getElementById("hora").value;
							var descricaoCompromisso = document.getElementById("descricaoCompromisso").value;
							
							$trs.post("<?php echo $configUrl;?>comercial/negociacoes/cadastra-compromisso.php", {codNegociacao: codNegociacao, nomeCompromisso: nomeCompromisso, codUsuario: codUsuario, codTipoCompromisso: codTipoCompromisso, data: data, hora: hora, descricaoCompromisso: descricaoCompromisso}, function(data){	
								if(data.trim() == "ok"){
									$trs("#caixa-compromissos").fadeOut(200, function(){
										$trs("#caixa-compromissos").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Carregando aguarde...</p>");										
									});
									$trs("#carrega-negociacoes").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-negociacoes.php");									
								}else{
									alert("Erro!");
								}
							});	
							
							return false;												
						}
												
						function alterarCompromisso(){
							var $trs9 = jQuery.noConflict();
							
							var codNegociacao = document.getElementById("codNegociacao").value;
							var nomeCompromisso = document.getElementById("nomeCompromisso").value;
							var codUsuario = document.getElementById("usuario").value;
							var codTipoCompromisso = document.getElementById("codTipoCompromisso").value;
							var data = document.getElementById("data").value;
							var hora = document.getElementById("hora").value;
							var descricaoCompromisso = document.getElementById("descricaoCompromisso").value;
							
							$trs9.post("<?php echo $configUrl;?>comercial/negociacoes/altera-compromisso.php", {codNegociacao: codNegociacao, nomeCompromisso: nomeCompromisso, codUsuario: codUsuario, codTipoCompromisso: codTipoCompromisso, data: data, hora: hora, descricaoCompromisso: descricaoCompromisso}, function(data){	
								if(data.trim() == "ok"){
									$trs9("#caixa-compromissos").fadeOut(200, function(){
										$trs9("#caixa-compromissos").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Carregando aguarde...</p>");										
									});
									$trs9("#carrega-negociacoes").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-negociacoes.php");									
								}else{
									alert("Erro!");
								}
							});	
							
							return false;												
						}

						
						function alterarResultado(cod, value){
							var $trsv = jQuery.noConflict();
							$trsv.post("<?php echo $configUrl;?>comercial/negociacoes/altera-resultado.php", {codNegociacao: cod, resultado: value}, function(data){	
								if(data.trim() == "ok"){
									if(value == "EP" || value == "AC"){
										$trsv(".corNegociacao"+cod).css("color", "#FF0000");
										$trsv(".corNegociacao"+cod).css("font-weight", "bold");
									}else
									if(value == "EM" || value == "C"){
										$trsv(".corNegociacao"+cod).css("color", "#FF0000");
										$trsv(".corNegociacao"+cod).css("font-weight", "normal");													
									}else{
										$trsv(".corNegociacao"+cod).css("color", "#0000FF");
										$trsv(".corNegociacao"+cod).css("font-weight", "normal");																										
									}	
								}else{
									alert("erro");
								}
							});											
						}

						function carregaCidade(cod){
							var $tgf = jQuery.noConflict();
							$tgf.post("<?php echo $configUrl;?>comercial/negociacoes/carrega-cidade.php", {codEstado: cod}, function(data){
								$tgf("#carrega-cidade").html(data);
								$tgf("#sel-padrao").css("display", "none");																									
							});
						}

						function abreCadastraNegociacao(){
							var $trsvs2 = jQuery.noConflict();
							$trsvs2("#cadastra-negociacao").fadeIn(200);
							$trsvs2("#cadastra-negociacao").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-cadastrar.php");																
						}

						function fechaCadastraNegociacao(){
							var $trsvs = jQuery.noConflict();
							$trsvs("#cadastra-negociacao").fadeOut(200, function(){
								$trsvs("#cadastra-negociacao").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Carregando aguarde...</p>");								
							});									
						}

						function editarNegociacao(cod){
							var $trsvs3 = jQuery.noConflict();
							$trsvs3("#altera-negociacao").fadeIn(200);
							$trsvs3("#altera-negociacao").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-alterar.php?codNegociacao="+cod);																
						}

						function fechaAlterarNegociacao(){
							var $trsvs4 = jQuery.noConflict();
							$trsvs4("#altera-negociacao").fadeOut(200, function(){
								$trsvs4("#altera-negociacao").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Carregando aguarde...</p>");								
							});									
						}

						function cadastraNegociacao(){
							var $trc = jQuery.noConflict();
							
							var nomeCliente = document.getElementById("cliente").value;
							var codTipoPagamento = document.getElementById("tipoPagamento").value;
							var codUsuario = document.getElementById("usuario").value;
							var tipoCliente = document.getElementById("tipoCliente").value;
							var tipoImovel = document.getElementById("tipoImovel").value;
							var fPrecoD = document.getElementById("fPrecoD").value;
							var fPrecoA = document.getElementById("fPrecoA").value;
							var resultado = document.getElementById("resultado").value;
							var fechamento = document.getElementById("fechamento").value;
							var midia = document.getElementById("midia").value;
							var codTipoCompromisso = document.getElementById("codTipoCompromisso").value;
							var data = document.getElementById("data").value;
							var hora = document.getElementById("hora").value;
							var descricaoCompromisso = document.getElementById("descricaoCompromisso").value;							
							var telefone = document.getElementById("telefone").value;
							var estado = document.getElementById("estado").value;
							var cidade = document.getElementById("cidade").value;
							var descricao = document.getElementById("descricao").value;
						
							$trc.post("<?php echo $configUrl;?>comercial/negociacoes/cadastra-negociacao.php", {nomeCliente: nomeCliente, codTipoPagamento: codTipoPagamento, codUsuario: codUsuario, tipoCliente: tipoCliente, tipoImovel: tipoImovel, fPrecoD: fPrecoD, fPrecoA: fPrecoA, resultado: resultado, fechamento: fechamento, midia: midia, codTipoCompromisso: codTipoCompromisso, data: data, hora: hora, descricaoCompromisso: descricaoCompromisso, telefone: telefone, estado: estado, cidade: cidade, descricao: descricao}, function(data){	
								if(data.trim() != "erro"){
<?php
				if($_SESSION['exibir-filtro-negociacoes'] == "C"){
?>	
									$trc("#carrega-negociacoes").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-negociacoes.php");
<?php
				}else{
?>
									location.href="<?php echo $configUrlGer;?>comercial/negociacoes/";
<?php
				}
?>
									$trc("#cadastra-negociacao").fadeOut(200, function(){
										$trc("#cadastra-negociacao").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Carregando aguarde...</p>");										
									});
								}
							});	
							
							return false;												
						}
						
						function alteraNegociacao(){
							var $trg = jQuery.noConflict();
							
							var codNegociacao = document.getElementById("codNegociacao").value;
							var nomeCliente = document.getElementById("cliente").value;
							var codTipoPagamento = document.getElementById("tipoPagamento").value;
							var codUsuario = document.getElementById("usuario").value;
							var tipoCliente = document.getElementById("tipoCliente").value;
							var tipoImovel = document.getElementById("tipoImovel").value;
							var fPrecoD = document.getElementById("fPrecoD").value;
							var fPrecoA = document.getElementById("fPrecoA").value;
							var resultado = document.getElementById("resultado").value;
							var fechamento = document.getElementById("fechamento").value;
							var midia = document.getElementById("midia").value;
							var telefone = document.getElementById("telefone").value;
							var estado = document.getElementById("estado").value;
							var cidade = document.getElementById("cidade").value;
						
							$trg.post("<?php echo $configUrl;?>comercial/negociacoes/altera-negociacao.php", {codNegociacao: codNegociacao, nomeCliente: nomeCliente, codTipoPagamento: codTipoPagamento, codUsuario: codUsuario, tipoCliente: tipoCliente, tipoImovel: tipoImovel, fPrecoD: fPrecoD, fPrecoA: fPrecoA, resultado: resultado, fechamento: fechamento, midia: midia, telefone: telefone, estado: estado, cidade: cidade}, function(data){	
								if(data.trim() == "ok"){
<?php
				if($_SESSION['exibir-filtro-negociacoes'] == "C"){
?>	
									$trg("#carrega-negociacoes").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-negociacoes.php");
<?php
				}else{
?>
									location.href="<?php echo $configUrlGer;?>comercial/negociacoes/";
<?php
				}
?>
									$trg("#altera-negociacao").fadeOut(200, function(){
										$trg("#altera-negociacao").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Carregando aguarde...</p>");										
									});
								}else{
									alert("Erro!");
								}
							});	
							
							return false;												
						}
						
						function cadastraAndamentoNegociacao(cod){
							var $trj = jQuery.noConflict();
							
							var codNegociacao = document.getElementById("codNegociacao").value;
							var descricaoAndamento = document.getElementById("descricaoAndamento").value;
							
							if(descricaoAndamento != ""){
						
								$trj.post("<?php echo $configUrl;?>comercial/negociacoes/cadastra-andamento.php", {codNegociacao: codNegociacao, descricaoAndamento: descricaoAndamento}, function(data){	
									if(data.trim() == "ok"){
										$trj("#carrega-andamentos").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-andamentos.php?codNegociacao="+cod);
										document.getElementById("descricaoAndamento").value="";
									}else{
										alert("Erro!");
									}
								});	
							}else{
								alert("Digite uma descrição antes de clicar em Salvar!");
							}
							
						}

						function abreCompromissos(etapa){
							var $trc3 = jQuery.noConflict();
							if(etapa == "R"){
								document.getElementById("compromisso").checked=true;
								if(document.getElementById("cadastra-compromisso").style.display=="none"){
									$trc3("#cadastra-compromisso").slideDown(200);		
									document.getElementById("codTipoCompromisso").disabled = false;									
									document.getElementById("data").disabled = false;									
									document.getElementById("hora").disabled = false;									
									document.getElementById("descricaoCompromisso").disabled = false;									
								}
							}else{
								if(etapa == "S" && document.getElementById("cadastra-compromisso").style.display=="none"){
									$trc3("#cadastra-compromisso").slideDown(200);		
									document.getElementById("codTipoCompromisso").disabled = false;									
									document.getElementById("data").disabled = false;									
									document.getElementById("hora").disabled = false;									
									document.getElementById("descricaoCompromisso").disabled = false;									
								}else
								if(etapa == "S"){
									$trc3("#cadastra-compromisso").slideUp(200);											
									document.getElementById("codTipoCompromisso").disabled = true;									
									document.getElementById("data").disabled = true;									
									document.getElementById("hora").disabled = true;									
									document.getElementById("descricaoCompromisso").disabled = true;
								}								
							}
						}	
						
						function fecharComentario(){
							var $trsvs8 = jQuery.noConflict();
							$trsvs8("#cadastra-comentario").fadeOut(200, function(){
								$trsvs8("#cadastra-comentario").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Carregando aguarde...</p>");								
							});									
						}
						
						function excluirNegociacao(codNegociacao, nome){
							var $trsvs22 = jQuery.noConflict();
							if(confirm("Você tem certeza que quer excluir a negociação do cliente "+nome)){
								$trsvs22("#altera-negociacao").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Excluíndo aguarde...</p>");								
								$trsvs22.post("<?php echo $configUrl;?>comercial/negociacoes/exclui-negociacoes.php", {codNegociacao: codNegociacao}, function(data){
									if(data.trim() == "ok"){
										$trsvs22("#altera-negociacao").fadeOut(200);
										$trsvs22("#carrega-negociacoes").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-negociacoes.php");
									}
								});
							}
						}

						function cadastraComentario(){
							var $trs10 = jQuery.noConflict();
							
							var codNegociacao = document.getElementById("codNegociacao").value;
							var motivo = document.getElementById("motivo").value;
							var comentario = document.getElementById("comentario").value;
							
							$trs10.post("<?php echo $configUrl;?>comercial/negociacoes/cadastra-comentario.php", {codNegociacao: codNegociacao, motivo: motivo, comentario: comentario}, function(data){
								if(data.trim() == "ok"){
<?php
				if($_SESSION['exibir-filtro-negociacoes'] == "C"){
?>
									$trs10("#cadastra-comentario").fadeOut(200, function(){
										$trs10("#cadastra-comentario").html("<p class='loading' style='color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:55px;'><img src='<?php echo $configUrl;?>f/i/loading.svg' width='100'/><br/>Carregando aguarde...</p>");										
									});
									$trs10("#carrega-negociacoes").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-negociacoes.php");									
<?php
				}else{
?>
									location.href="<?php echo $configUrlGer;?>comercial/negociacoes/";
<?php
				}
?>
								}else{
									alert("Erro!");
								}
							});	
							
							return false;												
						}
						
						function fechamentoNegociacao(fechamento, cod){
							var $trk = jQuery.noConflict();

							if(fechamento == "F"){
								var msg = "Deseja colocar esta negociação como Fechado ?";
							}else{
								var msg = "Deseja colocar esta negociação como Não Fechado ?";
							}

							if(confirm(msg)){
										
								if(fechamento == "F"){
																				
									$trk.post("<?php echo $configUrl;?>comercial/negociacoes/altera-fechamento.php", {codNegociacao: cod, fechamento: fechamento}, function(data){	
										if(data.trim() == "ok"){
<?php
				if($_SESSION['exibir-filtro-negociacoes'] == "C"){
?>
											$trk(".bloco-negociacao"+cod).fadeOut(200);
											setTimeout("editarNegociacao("+cod+")", 0);										
											setTimeout("ancoraAndamento()", 1000);										
<?php
				}else{
?>									
											if(fechamento == "F"){
												$trk("#fechado-lista"+cod).removeClass("fechado-lista").addClass("fechado-lista-ativo");										
												$trk("#nao-fechado-lista"+cod).removeClass("nao-fechado-lista-ativo").addClass("nao-fechado-lista");
												$trk(".corNegociacao"+cod).css("color", "#000");
												$trk(".corNegociacao"+cod).css("font-weight", "normal");																				
											}else{
												$trk("#fechado-lista"+cod).removeClass("fechado-lista-ativo").addClass("fechado-lista");										
												$trk("#nao-fechado-lista"+cod).removeClass("nao-fechado-lista").addClass("nao-fechado-lista-ativo");
												$trk(".corNegociacao"+cod).css("color", "#444");
												$trk(".corNegociacao"+cod).css("font-weight", "normal");
											}
<?php
				}
?>
										}else{
											alert("Erro!");
										}
									});	
								}else{
									$trk("#cadastra-comentario").fadeIn(200);
									$trk("#cadastra-comentario").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-comentario.php?codNegociacao="+cod);																									
								}							
							}
						}
						
						function ancoraAndamento(){
							location.href='#ancora-andamento';																				
						}	

						function loadingUpload(){
							var $trs66 = jQuery.noConflict();
							var codNegociacao = document.getElementById("codNegociacao").value;
							var arquivo = document.getElementById("arquivo").files[0];
							if(arquivo!=""){
								document.getElementById("carregamento-upload").style.display="block";

								var formData = new FormData($trs66("#form-negociacao").get(0));

								$trs66.ajax({ 												
									url: "<?php echo $configUrl;?>comercial/negociacoes/upload.php", 
									data : formData, 
									type : "POST", 
									async: false, 
									cache: false, 
									contentType: false, 
									processData: false, 
									dateType : "html", 
									success: function(data) { 
										document.getElementById("carregamento-upload").style.display="none";
										document.getElementById("arquivo").value="";
										$trs66("#carrega-anexos").load("<?php echo $configUrl;?>comercial/negociacoes/carrega-anexos.php?codNegociacao="+codNegociacao);									
									} 
								}).done(function(data){
									// In this callback you get the AJAX response to check
									// if everything is right...
								}).fail(function(){
									// Here you should treat the http errors (e.g., 403, 404)
								}).always(function(){
								});
							}
						}
						
						function excluiAnexo(codNegociacaoAnexo){
							var $trs77 = jQuery.noConflict();
							var codNegociacao = document.getElementById("codNegociacao").value;
							if(confirm("Deseja excluir o anexo ?")){
								$trs77("#carrega-anexos").load("<?php echo $configUrl;?>comercial/negociacoes/exclui-anexos.php?codNegociacao="+codNegociacao+"&codNegociacaoAnexo="+codNegociacaoAnexo);									
							}							
						}						
					</script>
					<div id="caixa-compromissos" style="display:none;">
						<p class="loading" style="color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;"><img src="<?php echo $configUrl;?>f/i/loading.svg" width="100"/><br/>Carregando aguarde...</p>
					</div>
					<div id="cadastra-negociacao" style="display:none;">
						<p class="loading" style="color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;"><img src="<?php echo $configUrl;?>f/i/loading.svg" width="100"/><br/>Carregando aguarde...</p>
					</div>
					<div id="altera-negociacao" style="display:none;">
						<p class="loading" style="color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;"><img src="<?php echo $configUrl;?>f/i/loading.svg" width="100"/><br/>Carregando aguarde...</p>
					</div>
					<div id="cadastra-comentario" style="display:none;">
						<p class="loading" style="color:#006bc8; display:table; margin:0 auto; text-align:center; margin-top:95px;"><img src="<?php echo $configUrl;?>f/i/loading.svg" width="100"/><br/>Carregando aguarde...</p>						
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
