<?php
	ob_start();
	
	include('../f/conf/config.php');
	include('../f/conf/functions.php');
	
	$codLote = $_POST['codLote'];	
	
	$sqlLote = "SELECT * FROM lotes WHERE codLote = ".$codLote." LIMIT 0,1";
	$resultLote = $conn->query($sqlLote);
	$dadosLote = $resultLote->fetch_assoc();					
	
	$sqlLoteamento = "SELECT * FROM loteamentos WHERE codLoteamento = ".$dadosLote['codLoteamento']." LIMIT 0,1";
	$resultLoteamento = $conn->query($sqlLoteamento);
	$dadosLoteamento = $resultLoteamento->fetch_assoc();	

	$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLote['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
	$resultReservas = $conn->query($sqlReservas);
	$dadosReservas = $resultReservas->fetch_assoc();	
	
	if($dadosReservas['codLoteReserva'] == ""){				
?>
												<script type="text/javascript" src="<?php echo $configUrl;?>f/j/js/jquery.js"></script>			
												<p class="fechar" onClick="fechaPopup();">X</p>
												<p class="titulo-acao">Lote nº <?php echo $dadosLote['nomeLote'];?></p>
												<p class="mensagem">Você deseja?</p>
												<div id="botoes">
													<p class="botao-sim" onClick="reservaLote(<?php echo $codLote;?>);"><input type="submit" value="Reservar" name="sim" id="sim"/></p>
													<p class="botao-contrato" onClick="contratoLote(<?php echo $codLote;?>);"><input type="submit" value="Fazer Contrato" name="contrato" id="contrato"/></p>
													<p class="botao-contrato" onClick="contratoLote(<?php echo $codLote;?>);"><input type="submit" value="Dados para Contrato" name="contrato" id="contrato"/></p>
													<p class="botao-nao"><input onClick="cancelaReserva();" type="submit" value="Nenhum" name="nao" id="nao"/></p>
													<br class="clear"/>
												</div>	
												<p class="messagem-2">Caso você deseje cancelar a reserva<br/>basta clicar em cima do status do lote reservado!</p>
												<script type="text/javascript">
													function reservaLote(cod){
														var $tgs = jQuery.noConflict();
														$tgs("#popup-acoes").html("<p class='loading' style='display:table; margin:0 auto; padding-top:40px; padding-bottom:30px;'><img src='<?php echo $configUrl;?>f/i/quebrado/loading.svg' width='80'/></p>");
														$tgs.post("<?php echo $configUrl;?>loteamentos/cadastra-reserva.php", {codLote: cod}, function(data){
															if(data.trim() == "ok"){
																$tgs("#popup-acoes").html("<p class='icone'><img style='display:block;' src='<?php echo $configUrl;?>f/i/quebrado/icone-certo.png' width='80'/></p><p class='ok'>Lote reservado com sucesso!<br/></p><p class='restante'>Tempo restante <?php echo $diasReserva;?> dias.<br/><br/></p><p class='msg-final'>Você será redirecionado em instantes...</p>");
																setTimeout("carregaPagina()", 3000);
															}else{
																$tgs("#popup-acoes").html("<p class='erro'>Ocorreu algum problema ao reservar este lote. Tente novamente.</p>");
															}
														});															
													}
													
													function contratoLote(cod){
														document.getElementById("loteContrato").value=cod;
														document.getElementById("formContrato").submit();
													}
													
													function cancelaReserva(){
														var $tgb = jQuery.noConflict();
														$tgb(".fundo-acoes").fadeOut("250");
														$tgb("#popup-acoes").fadeOut("250");														
													}
													
													function carregaPagina(){
														location.href="<?php echo $configUrl.'loteamentos/'.$dadosLoteamento['urlLoteamento'].'/';?>";
													}
												</script>
												<form id="formContrato" action="<?php echo $configUrl;?>minha-conta/contratos/" method="post">
													<input type="hidden" value="" name="loteContrato" id="loteContrato"/>
												</form>
<?php
	}else
	if($dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
?>
												<script type="text/javascript" src="<?php echo $configUrl;?>f/j/js/jquery.js"></script>			
												<p class="fechar" onClick="fechaPopup();">X</p>
												<p class="titulo-acao">Lote nº <?php echo $dadosLote['nomeLote'];?></p>
												<p class="mensagem">Você deseja?</p>
												<div id="botoes">
													<p class="botao-sim" onClick="cancelarReserva(<?php echo $codLote;?>);"><input type="submit" value="Cancelar Reserva" name="sim" id="sim"/></p>
													<p class="botao-contrato" onClick="contratoLote(<?php echo $codLote;?>);"><input type="submit" value="Fazer Contrato" name="contrato" id="contrato"/></p>
													<p class="botao-nao"><input onClick="cancelaReserva();" type="submit" value="Nenhum" name="nao" id="nao"/></p>
													<br class="clear"/>
												</div>	
												<p class="messagem-2">Caso mude de ideia você poderá<br/>reservar este lote novamente!</p>
												<script type="text/javascript">
													function cancelarReserva(cod){
														var $tgs = jQuery.noConflict();
														$tgs("#popup-acoes").html("<p class='loading' style='display:table; margin:0 auto; padding-top:40px; padding-bottom:30px;'><img src='<?php echo $configUrl;?>f/i/quebrado/loading.svg' width='80'/></p>");
														$tgs.post("<?php echo $configUrl;?>loteamentos/cancela-reserva.php", {codLote: cod}, function(data){
															if(data.trim() == "ok"){
																$tgs("#popup-acoes").html("<p class='icone'><img style='display:block;' src='<?php echo $configUrl;?>f/i/quebrado/icone-certo.png' width='80'/></p><p class='ok'>Reserva cancelada com sucesso!<br/></p><p class='msg-final'>Você será redirecionado em instantes...</p>");
																setTimeout("carregaPagina()", 3000);
															}else{
																$tgs("#popup-acoes").html("<p class='erro'>Ocorreu algum problema ao cancelar reserva deste lote. Tente novamente.</p>");
															}
														});															
													}

													function contratoLote(cod){
														document.getElementById("loteContrato").value=cod;
														document.getElementById("formContrato").submit();
													}
																										
													function cancelaReserva(){
														var $tgb = jQuery.noConflict();
														$tgb(".fundo-acoes").fadeOut("250");
														$tgb("#popup-acoes").fadeOut("250");														
													}
													
													function carregaPagina(){
														location.href="<?php echo $configUrl.'loteamentos/'.$dadosLoteamento['urlLoteamento'].'/';?>";
													}
												</script>
												<form id="formContrato" action="<?php echo $configUrl;?>minha-conta/contratos/" method="post">
													<input type="hidden" value="" name="loteContrato" id="loteContrato"/>
												</form>												
<?php
	}
?>
