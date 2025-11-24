<?php
	ob_start();
	session_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');
	include ('../../f/conf/functions.php');

	$sqlUsuario = "SELECT * FROM usuarios WHERE statusUsuario = 'T' and codUsuario = ".$_COOKIE['codAprovado'.$cookie]." LIMIT 0,1";
	$resultUsuario = $conn->query($sqlUsuario);
	$dadosUsuario = $resultUsuario->fetch_assoc();	
	
	if($dadosUsuario['tipoUsuario'] == 'C'){
		$filtraUsuario = " and N.codUsuario = ".$dadosUsuario['codUsuario']."";
	}else
	if($_SESSION['colaborador-filtro-negociacoes']){
		$filtraUsuario = " and N.codUsuario = ".$_SESSION['colaborador-filtro-negociacoes']."";
	}	
?>
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
