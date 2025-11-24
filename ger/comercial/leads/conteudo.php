<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "negociacoes";
			if(validaAcesso($conn, $area) == "ok"){

				if($_SESSION['lead-adicionado'] == "ok"){
					$erroConteudo = "<p class='erro'>Lead <strong>".$_SESSION['nome']."</strong> adicionado com sucesso!</p>";
					$_SESSION['lead-adicionado'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Lead <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Lead <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			

				if(isset($_POST['leads-confere'])){
					if($_POST['leads-confere'] != ""){
						$_SESSION['leads-confere'] = $_POST['leads-confere'];
					}else{
						$_SESSION['leads-confere'] = "";
					}
				}

				if($_SESSION['leads-confere'] == ""){
					// Define o primeiro e o último dia da semana atual
					$hoje = date('Y-m-d');
					$diaSemana = date('N', strtotime($hoje)); // 1 (segunda) até 7 (domingo)
					$primeiroDiaSemana = date('Y-m-d', strtotime($hoje . ' -' . ($diaSemana - 1) . ' days'));
					$ultimoDiaSemana = date('Y-m-d', strtotime($hoje . ' +' . (7 - $diaSemana) . ' days'));
					$_SESSION['data1-lead'] = $primeiroDiaSemana;
					$_SESSION['data2-lead'] = $ultimoDiaSemana;
				}

				if(isset($_POST['leads-filtro'])){
					if($_POST['leads-filtro'] != ""){
						$_SESSION['leads-filtro'] = $_POST['leads-filtro'];
					}else{
						$_SESSION['leads-filtro'] = "";
					}
				}
				
				if($_SESSION['leads-filtro'] != ""){
					$filtraNome = " and C.nome = '".$_SESSION['leads-filtro']."'";
				}												

				if(isset($_POST['leadsC-filtro'])){
					if($_POST['leadsC-filtro'] != ""){
						$_SESSION['leadsC-filtro'] = $_POST['leadsC-filtro'];
					}else{
						$_SESSION['leadsC-filtro'] = "";
					}
				}
				
				if($_SESSION['leadsC-filtro'] != ""){
					$filtraCelular = " and C.numero = '".$_SESSION['leadsC-filtro']."'";
				}												

				if(isset($_POST['data1-lead'])){
					if($_POST['data1-lead'] != ""){
						$_SESSION['data1-lead'] = $_POST['data1-lead'];
					}else{
						$_SESSION['data1-lead'] = "";
					}
				}
				
				if($_SESSION['data1-lead'] != ""){
					$filtraData1 = " and DATE(L.recebidoLead) >= '".$_SESSION['data1-lead']."'";
				}												
				
				if(isset($_POST['data2-lead'])){
					if($_POST['data2-lead'] != ""){
						$_SESSION['data2-lead'] = $_POST['data2-lead'];
					}else{
						$_SESSION['data2-lead'] = "";
					}
				}
				
				if($_SESSION['data2-lead'] != ""){
					$filtraData2 = " and DATE(L.recebidoLead) <= '".$_SESSION['data2-lead']."'";
					
				}				
			
				if(isset($_POST['tipo-lead'])){
					if($_POST['tipo-lead'] != ""){
						$_SESSION['tipo-lead'] = $_POST['tipo-lead'];
					}else{
						$_SESSION['tipo-lead'] = "";
					}
				}
				
				if($_SESSION['tipo-lead'] != ""){
					$filtraTipo = " and L.tipoLead = '".$_SESSION['tipo-lead']."'";
				}				
			
				if(isset($_POST['origem-lead'])){
					if($_POST['origem-lead'] != ""){
						$_SESSION['origem-lead'] = $_POST['origem-lead'];
					}else{
						$_SESSION['origem-lead'] = "";
					}
				}
				
				if($_SESSION['origem-lead'] != ""){
					if($_SESSION['origem-lead'] == "R"){
						$filtraOrigem = " and C.anuncio = 'R'";	
					}else
					if($_SESSION['origem-lead'] == "A"){
						$filtraOrigem = " and C.anuncio = 'T'";	
					}else
					if($_SESSION['origem-lead'] == "G"){
						$filtraOrigem = " and C.anuncio = 'F' and C.source = ''";	
					}else{
						$filtraOrigem = " and C.source = '".$_SESSION['origem-lead']."'";	
					}
				}				
			
				if(isset($_POST['status-lead'])){
					if($_POST['status-lead'] != ""){
						$_SESSION['status-lead'] = $_POST['status-lead'];
					}else{
						$_SESSION['status-lead'] = "";
					}
				}
				
				if($_SESSION['status-lead'] != ""){
					$filtraStatus = " and L.statusLead = '".$_SESSION['status-lead']."'";
				}				
			
				if(isset($_POST['lead-usuario'])){
					if($_POST['lead-usuario'] != "" || $_POST['lead-usuario'] == "TO"){
						$_SESSION['lead-usuario'] = $_POST['lead-usuario'];
					}else{
						$_SESSION['lead-usuario'] = "";
					}
				}
				
				if($_SESSION['lead-usuario'] != "" && $_SESSION['lead-usuario'] != "TO"){
					$filtraUsuarioLead = " and UL.codUsuario = '".$_SESSION['lead-usuario']."'";
				}	

				function formatarNumeroTelefone($numero) {
					$numero = preg_replace('/\D+/', '', $numero);
		
					if (substr($numero, 0, 2) === '55') {
						$ddd_e_numero = substr($numero, 2); // Remove o código do país
						if (strlen($ddd_e_numero) == 10) {
							$ddd_e_numero = substr_replace($ddd_e_numero, '9', 2, 0);
						}
						$numero = '55' . $ddd_e_numero;
					}
		
					if (preg_match('/^55(\d{2})(\d{5})(\d{4})$/', $numero, $matches)) {
						return "+55 ({$matches[1]}) {$matches[2]}-{$matches[3]}";
					}
		
					return $numero;
				}
?>			
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Comercial</p>
						<p class="flexa"></p>
						<p class="nome-lista">Leads</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
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
							<form name="filtro" action="<?php echo $configUrl;?>comercial/leads/" method="post" />
								
								<input type="hidden" value="T" name="leads-confere"/>

								<div id="auto_complete_softbest" style="width:216px; float:left; margin-bottom:15px; margin-right:10px;">
									<p class="bloco-campo" style="margin-bottom:0px;"><label>Filtrar Nome: <span class="obrigatorio"> </span></label>
									<input class="campo" type="text" name="leads-filtro" style="width:200px;" value="<?php echo $_SESSION['leads-filtro']; ?>" onClick="auto_complete(this.value, 'leads', event);" onKeyUp="auto_complete(this.value, 'leads', event);" onkeydown="if (getKey(event) == 13) return false;" onBlur="fechaAutoComplete('leads');" autocomplete="off" id="busca_autocomplete_softbest_leads" /></p>
									<br class="clear"/>
									
									<div id="exibe_busca_autocomplete_softbest_leads" class="auto_complete_softbest" style="display:none;">

									</div>
								</div>

								<div id="auto_complete_softbest" style="width:166px; float:left; margin-bottom:15px; margin-right:10px;">
									<p class="bloco-campo" style="margin-bottom:0px;"><label>Filtrar Celular: <span class="obrigatorio"> </span></label>
									<input class="campo" type="text" name="leadsC-filtro" style="width:150px;" value="<?php echo $_SESSION['leadsC-filtro']; ?>" onClick="auto_complete(this.value, 'leadsC', event);" onKeyUp="auto_complete(this.value, 'leadsC', event);" onkeydown="if (getKey(event) == 13) return false;" onBlur="fechaAutoComplete('leadsC');" autocomplete="off" id="busca_autocomplete_softbest_leadsC" /></p>
									<br class="clear"/>
									
									<div id="exibe_busca_autocomplete_softbest_leadsC" class="auto_complete_softbest" style="display:none;">

									</div>
								</div>

								<p class="bloco-campo-float"><label>De: <span class="obrigatorio"> </span></label>
								<input class="campo" type="date" id="data1-lead" name="data1-lead" style="width:130px; height:16px;" value="<?php echo $_SESSION['data1-lead']; ?>"/></p>

								<p class="bloco-campo-float"><label>Até: <span class="obrigatorio"> </span></label>
								<input class="campo" type="date" id="data2-lead" name="data2-lead" style="width:130px; height:16px;" size="10" value="<?php echo $_SESSION['data2-lead']; ?>"/></p>

								<p class="bloco-campo-float">
									<label>Corretor:</label>
									<select class="selectCorretor form-control campo" id="idSelectUsuario" name="lead-usuario" style="width:200px; display: none;">
										<option value="TO">Todos</option>	
<?php
				$sqlUsuario = "SELECT * FROM usuarios WHERE leadsUsuario = 'S' and statusUsuario = 'T' ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
										<option value="<?php echo $dadosUsuario['codUsuario'];?>" <?php echo $dadosUsuario['codUsuario'] == $_SESSION['lead-usuario'] ? 'selected' : ''; ?>><?php echo $dadosUsuario['nomeUsuario'];?></option>										
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
							
								<p><label class="label">Tipo:</label>							
									<select class="campo" id="default-usage-select4" style="width:150px; padding:6px; margin-right:0px;" name="tipo-lead">
										<option value="">Todos</option>
										<option value="A" <?php echo $_SESSION['tipo-lead'] == "A" ? '/SELECTED/' : '';?> >Automático</option>
										<option value="M" <?php echo $_SESSION['tipo-lead'] == "M" ? '/SELECTED/' : '';?> >Manual</option>
										<option value="D" <?php echo $_SESSION['tipo-lead'] == "D" ? '/SELECTED/' : '';?> >Direcionado</option>
										<option value="RM" <?php echo $_SESSION['tipo-lead'] == "RM" ? '/SELECTED/' : '';?> >Roleta Manual</option>
									</select>
								</p>

								
								<p><label class="label">Origem: <span class="obrigatorio"> </span></label>							
									<select class="campo" id="default-usage-select4" style="width:150px; padding:6px; margin-right:0px;" name="origem-lead">
										<option value="">Todos</option>
										<option value="A" <?php echo $_SESSION['origem-lead'] == "A" ? '/SELECTED/' : '';?> >Anúncio Meta</option>
										<option value="G" <?php echo $_SESSION['origem-lead'] == "G" ? '/SELECTED/' : '';?> >Google / Orgânico</option>
										<option value="WH" <?php echo $_SESSION['origem-lead'] == "WH" ? '/SELECTED/' : '';?> >WhatsApp</option>
										<option value="IN" <?php echo $_SESSION['origem-lead'] == "IN" ? '/SELECTED/' : '';?> >Instagram</option>
										<option value="ES" <?php echo $_SESSION['origem-lead'] == "ES" ? '/SELECTED/' : '';?> >Escritório</option>
										<option value="FA" <?php echo $_SESSION['origem-lead'] == "FA" ? '/SELECTED/' : '';?> >Facebook</option>
										<option value="SI" <?php echo $_SESSION['origem-lead'] == "SI" ? '/SELECTED/' : '';?> >Site</option>
										<option value="ID" <?php echo $_SESSION['origem-lead'] == "ID" ? '/SELECTED/' : '';?> >Indicação</option>
										<option value="R" <?php echo $_SESSION['origem-lead'] == "R" ? '/SELECTED/' : '';?> >Remarketing</option>
									</select>
								</p>

								<p><label class="label">Status:</label>							
									<select class="campo" id="default-usage-select4" style="width:150px; padding:6px;" name="status-lead">
										<option value="">Todos</option>
										<option value="F" <?php echo $_SESSION['status-lead'] == "F" ? '/SELECTED/' : '';?> >Atendido</option>
										<option value="T" <?php echo $_SESSION['status-lead'] == "T" ? '/SELECTED/' : '';?> >Aguardando</option>
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
																						
								<p class="botao-filtrar"><input type="submit" name="filtrar" value="Filtrar" onClick="enviar()" /></p>
								<div class="botao-novo" style="margin-left:0px;"><a title="Adicionar Lead" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Adicionar Lead</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>

								<br class="clear" />
		
							</form>
						</div>
					</div>				
<?php			
				if(isset($_POST['nome'])){
					$celular = str_replace(" ", "", $_POST['celular']);
					$celular = str_replace("+", "", $celular);
					$celular = str_replace("(", "", $celular);
					$celular = str_replace(")", "", $celular);
					$celular = str_replace("-", "", $celular);

					$sqlInsere = "INSERT INTO conversas VALUES(0, '', '', '".$_POST['nome']."', '".$celular."', '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 'F', '".$_POST['origem']."', 'C', 'T', 'T')";
					$resultInsere = $conn->query($sqlInsere);
					$idInserido = $conn->insert_id;

					if($resultInsere == 1){
						$sqlInsereM = "INSERT INTO mensagens VALUES(0, ".$idInserido.", '', '".$_POST['mensagem']."', 'text', '".date('Y-m-d H:i:s')."', 'S', 'F')";
						$resultInsereM = $conn->query($sqlInsereM);

						if($_POST['corretor'] == "R"){
							$sqlInsereLead = "INSERT INTO leads VALUES(0, 'RM', ".$idInserido.", 0, '".date('Y-m-d H:i:s')."', NULL, 'T')";
							$resultInsereLead = $conn->query($sqlInsereLead);		
						}else{
							$sqlInsereLead = "INSERT INTO leads VALUES(0, 'D', ".$idInserido.", 0, '".date('Y-m-d H:i:s')."', '".date('Y-m-d H:i:s')."', 'M')";
							$resultInsereLead = $conn->query($sqlInsereLead);
						
							$codLeadInserido = $conn->insert_id;
		
							if($resultInsereLead == 1){
								$sqlInsereULeads = "INSERT INTO usuariosLeads VALUES (0, ".$_POST['corretor'].", ".$codLeadInserido.", ".$idInserido.", '".date('Y-m-d H:i:s')."', NULL, 'F')";
								$resultInsereULeads = $conn->query($sqlInsereULeads);	

								$codULeadInserido = $conn->insert_id;

								$sqlInsereNegociacoes = "INSERT INTO negociacoes VALUES(0, 73, ".$_POST['corretor'].", 0, 0, ".$_POST['corretor'].", 0, '".$_POST['nome']."', '".date('Y-m-d')."', '".date('Y-m-d')."', '".date('Y-m-d')."', '".date('H:i:s')."', '".formatarNumeroTelefone($celular)."', 'N', '0.00', '0.00', 'C', 'EA', '', '', '".$_POST['mensagem']."', '".$_POST['origem']."', 'T')";
								$resultInsereNegociacoes = $conn->query($sqlInsereNegociacoes);
										
								if($resultInsereULeads == 1){
									$sqlUpdateFila = "UPDATE fila SET envioFila = '".date('Y-m-d H:i:s')."' WHERE codUsuario = ".$_POST['corretor']."";
									$resultUpdateFila = $conn->query($sqlUpdateFila);
									
									$sqlUpdateFila2 = "UPDATE filaLeads SET envioFilaLead = '".date('Y-m-d H:i:s')."' WHERE codUsuario = ".$_POST['corretor']." and codLead = ".$codLeadInserido."";
									$resultUpdateFila2 = $conn->query($sqlUpdateFila2);

									$url = $configUrlSite."wa/aceitar-lead.php?ref=".$codULeadInserido;
									
									$ch = curl_init();
									curl_setopt($ch, CURLOPT_URL, $url);
									curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
									curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
									curl_setopt($ch, CURLOPT_TIMEOUT, 10);
									$resultado = curl_exec($ch);
				
									curl_close($ch);

									$_SESSION['lead-adicionado'] = "ok";
								}
							}							
						}

						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/leads/'>";

					}
				}	
?>
					<div id="cadastrar" style="padding:10px 35px; display:none;">
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<form action="<?php echo $configUrlGer; ?>comercial/leads/1/" method="post">
						
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:300px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label>WhatsApp: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="celular" id="celular" style="width:300px;" placeholder="+55 (48) 98765-4321" required value="<?php echo $_SESSION['celular']; ?>" maxlength="20" /></p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label class="label">Origem: <span class="obrigatorio"> * </span></label>							
								<select class="campo" id="default-usage-select4" style="width:316px; padding:7px;" name="origem">
									<option value="">Todos</option>
									<option value="WH" <?php echo $_SESSION['origem'] == "WH" ? '/SELECTED/' : '';?> >WhatsApp</option>
									<option value="IN" <?php echo $_SESSION['origem'] == "IN" ? '/SELECTED/' : '';?> >Instagram</option>
									<option value="ES" <?php echo $_SESSION['origem'] == "ES" ? '/SELECTED/' : '';?> >Escritório</option>
									<option value="FA" <?php echo $_SESSION['origem'] == "FA" ? '/SELECTED/' : '';?> >Facebook</option>
									<option value="SI" <?php echo $_SESSION['origem'] == "SI" ? '/SELECTED/' : '';?> >Site</option>
									<option value="ID" <?php echo $_SESSION['origem'] == "ID" ? '/SELECTED/' : '';?> >Indicação</option>
									<option value="R" <?php echo $_SESSION['origem'] == "R" ? '/SELECTED/' : '';?> >Remarketing</option>
								</select>
							</p>

							<p class="bloco-campo-float">
								<label>Enviar para:</label>
									<select class="selectCorretor2 form-control campo" id="idSelectUsuario" name="corretor" style="width:315px; display: none;">
										<option value="R">Roleta</option>	
<?php
				$sqlUsuario = "SELECT * FROM usuarios WHERE tipoUsuario = 'C' and statusUsuario = 'T' ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
										<option value="<?php echo $dadosUsuario['codUsuario'];?>" <?php echo $dadosUsuario['codUsuario'] == $_SESSION['lead-usuario'] ? 'selected' : ''; ?>><?php echo $dadosUsuario['nomeUsuario'];?></option>										
<?php
				}
?>
								</select>										
							</p>

							<br class="clear"/>

							<p class="bloco-campo" style="width:1055px;"><label>Mensagem:<span class="obrigatorio"> </span></label>
							<textarea class="campo" id="mensagem" name="mensagem" type="text" style="width:625px; height:50px;" ><?php echo $_SESSION['mensagem']; ?></textarea></p>

							<script>
								var $rfg = jQuery.noConflict();

								$rfg(".selectCorretor2").select2({
									placeholder: "Selecione",
									multiple: false
								});
							</script>

							<script>
								function mascaraTelefoneUniversal(valor) {
									// Remove tudo que não for número
									valor = valor.replace(/\D/g, '');

									// Adiciona o +
									if(valor.length > 0) {
										valor = '+' + valor;
									}

									// Mascara para DDI (1 a 3 dígitos)
									if(valor.length > 1) {
										valor = valor.replace(/^(\+\d{1,2})(\d)/, "$1 $2");
									}

									// Máscara para DDD (2 dígitos) com parênteses
									if(valor.length > 5) {
										valor = valor.replace(/^(\+\d{1,3}) (\d{2})(\d)/, "$1 ($2) $3");
									}

									// Máscara para número (coloca parênteses no DDD, 4 ou 5 dígitos + hífen + 4 dígitos)
									if(valor.length > 10) {
										valor = valor.replace(/^(\+\d{1,3}) \((\d{2})\) (\d{4,5})(\d{4})/, "$1 ($2) $3-$4");
										// Se ainda não tem parênteses, adiciona
										if(!/\(\d{2}\)/.test(valor)) {
											valor = valor.replace(/^(\+\d{1,3}) (\d{2}) (\d{4,5})(\d{4})/, "$1 ($2) $3-$4");
										}
									}

									return valor;
								}

								document.addEventListener('DOMContentLoaded', function() {
									var input = document.getElementById('celular');
									input.addEventListener('input', function(e) {
										this.value = mascaraTelefoneUniversal(this.value);
									});
								});
							</script>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Lead" value="Salvar Lead" /><p class="direita-botao"></p></div></p>						
							
							<br class="clear"/>
						</form>	

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
				
				$sqlConta = "SELECT COUNT(DISTINCT L.codLead) AS registros, L.codLead FROM leads L inner join conversas C on L.codConversa = C.codConversa left join mensagens M on C.codConversa = M.codConversa left join usuariosLeads UL on L.codLead = L.codLead WHERE L.codLead != ''".$filtraData1.$filtraData2.$filtraTipo.$filtraCelular.$filtraOrigem.$filtraStatus.$filtraUsuarioLead.$filtraNome."";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['codLead'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Nome</th>
								<th>Tipo</th>
								<th>WhatsApp</th>
								<th>Origem</th>
								<th>Recebido em</th>
								<th>Atendido por</th>
								<th>Tempo de Resposta</th>
								<th>Histórico</th>
								<th class="canto-dir">Status</th>
							</tr>					
<?php
					function getDateTimeDifference($start, $end) {
						$startDateTime = new DateTime($start);
						$endDateTime = new DateTime($end);

						$interval = $startDateTime->diff($endDateTime);

						return [
							'years' => $interval->y,
							'months' => $interval->m,
							'days' => $interval->d,
							'hours' => $interval->h,
							'minutes' => $interval->i,
							'seconds' => $interval->s,
							'inverted' => $interval->invert // 1 se a diferença é negativa
						];
					}

					function displayDifference($difference) {
						$output = '';

						if ($difference['years'] > 0) {
							$output .= "{$difference['years']} anos\n";
						}
						if ($difference['months'] > 0) {
							$output .= "{$difference['months']} meses\n";
						}
						if ($difference['days'] > 0) {
							$output .= "{$difference['days']} dia\n";
						}
						if ($difference['hours'] > 0) {
							$output .= "{$difference['hours']} hr\n";
						}
						if ($difference['minutes'] > 0) {
							$output .= "{$difference['minutes']} min\n";
						}
						if ($difference['seconds'] > 0) {
							$output .= "{$difference['seconds']} seg\n";
						}

						if ($difference['inverted']) {
							$output .= "A data de início é maior que a data de término.\n";
						}

						return $output;
					}				

					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlLead = "SELECT L.codLead, L.recebidoLead, L.codUsuario, L.tipoLead, L.statusLead, C.nome, C.numero, C.anuncio, C.source FROM leads L inner join conversas C on L.codConversa = C.codConversa left join mensagens M on C.codConversa = M.codConversa left join usuariosLeads UL on L.codLead = L.codLead WHERE L.codLead != ''".$filtraData1.$filtraData2.$filtraTipo.$filtraOrigem.$filtraCelular.$filtraStatus.$filtraUsuarioLead.$filtraNome." GROUP BY L.codLead ORDER BY UL.codUsuarioLead DESC, L.statusLead ASC, L.recebidoLead DESC, L.codLead DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlLead = "SELECT L.codLead, L.recebidoLead, L.codUsuario, L.tipoLead, L.statusLead, C.nome, C.numero, C.anuncio, C.source FROM leads L inner join conversas C on L.codConversa = C.codConversa left join mensagens M on C.codConversa = M.codConversa left join usuariosLeads UL on L.codLead = L.codLead WHERE L.codLead != ''".$filtraData1.$filtraData2.$filtraTipo.$filtraOrigem.$filtraCelular.$filtraStatus.$filtraUsuarioLead.$filtraNome." GROUP BY L.codLead ORDER BY UL.codUsuarioLead DESC, L.statusLead ASC, L.recebidoLead DESC, L.codLead DESC LIMIT ".$paginaInicial.",30";
					}		

					$resultLead = $conn->query($sqlLead);
					while($dadosLead = $resultLead->fetch_assoc()){
						$mostrando++;
						
						if($dadosLead['statusLead'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}	
						
						$sqlUsuarioLead = "SELECT * FROM usuariosLeads WHERE codLead = ".$dadosLead['codLead']." and statusUsuarioLead = 'T' ORDER BY codUsuarioLead DESC LIMIT 0,1";
						$resultUsuarioLead = $conn->query($sqlUsuarioLead);
						$dadosUsuarioLead = $resultUsuarioLead->fetch_assoc();

						$dataLead = explode(" ", $dadosLead['recebidoLead']);

						if($dadosUsuarioLead['codUsuarioLead'] != ""){
						
							if($dadosLead['tipoLead'] == "A" || $dadosLead['tipoLead'] == "RM"){

								$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$dadosUsuarioLead['codUsuario']."' ORDER BY codUsuario DESC LIMIT 0,1";
								$resultUsuario = $conn->query($sqlUsuario);
								$dadosUsuario = $resultUsuario->fetch_assoc();
													
								if($dadosUsuarioLead['interacaoUsuarioLead'] != "NULL" && $dadosUsuarioLead['codUsuarioLead']){
									$dataLeadA = explode(" ", $dadosUsuarioLead['interacaoUsuarioLead']);
									$dataLeadA = data($dataLeadA[0])." ás ".$dataLeadA[1];
									
									$difference = displayDifference(getDateTimeDifference($dadosLead['recebidoLead'], $dadosUsuarioLead['interacaoUsuarioLead']));
								}else{
									$dataLeadA = "Aguardando";
									$difference = "Aguardando";
								}
							
							}else
							if($dadosLead['tipoLead'] == "D"){
								$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$dadosUsuarioLead['codUsuario']."' ORDER BY codUsuario DESC LIMIT 0,1";
								$resultUsuario = $conn->query($sqlUsuario);
								$dadosUsuario = $resultUsuario->fetch_assoc();
													
								if($dadosUsuarioLead['interacaoUsuarioLead'] != "NULL" && $dadosUsuarioLead['codUsuarioLead']){
									$dataLeadA = explode(" ", $dadosUsuarioLead['interacaoUsuarioLead']);
									$dataLeadA = data($dataLeadA[0])." ás ".$dataLeadA[1];
									
									$difference = displayDifference(getDateTimeDifference($dadosLead['recebidoLead'], $dadosUsuarioLead['interacaoUsuarioLead']));
								}else{
									$dataLeadA = "Erro!";
									$difference = "Erro!";
								}							
							}else{
								$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$dadosLead['codUsuario']."' ORDER BY codUsuario DESC LIMIT 0,1";
								$resultUsuario = $conn->query($sqlUsuario);
								$dadosUsuario = $resultUsuario->fetch_assoc();	

								$dataLeadA = '--';
								$difference = "--";						
							}
						}else{
							$dataLeadA = '--';
							$difference = "--";								
						}
						
						if($dadosLead['statusLead'] == "T"){
							$color = "color:green;";
						}else{
							$color = "color:#000;";
						}

						
						if($dadosLead['anuncio'] == "T"){
							$origem = "Anúncio Meta<br/><a target='_blank' style='text-decoration:underline; font-size:12px; color:#000;' href='".$dadosLead['source']."'>".$dadosLead['source']."</a>";
						}else if($dadosLead['anuncio'] == "F" && $dadosLead['source'] == ""){
							$origem = "Google / Orgânico";
						}else if($dadosLead['anuncio'] == "R"){
							$origem = "Remarketing";
						}else if($dadosLead['source'] == "WH"){
							$origem = "WhatsApp";
						}else if($dadosLead['source'] == "IN"){
							$origem = "Instagram";
						}else if($dadosLead['source'] == "ES"){
							$origem = "Escritório";
						}else if($dadosLead['source'] == "FA"){
							$origem = "Facebook";
						}else if($dadosLead['source'] == "SI"){
							$origem = "Site";
						}else if($dadosLead['source'] == "ID"){
							$origem = "Indicação";
						}else{
							$origem = $dadosLead['source'];
						}					
?>
								<tr class="tr">
									<td class="vinte"><a style="<?php echo $color;?> font-weight:bold;"><?php echo $dadosLead['nome'];?></a></td>
									<td class="dez" style="text-align:center;"><a style="<?php echo $color;?>"><?php echo $dadosLead['tipoLead'] == "M" ? 'Manual' : '';?> <?php echo $dadosLead['tipoLead'] == "A" ? 'Automático' : '';?> <?php echo $dadosLead['tipoLead'] == "D" ? 'Direcionado' : '';?> <?php echo $dadosLead['tipoLead'] == "RM" ? 'Roleta Manual' : '';?></a></td>
									<td class="dez" style="text-align:center;"><a style="padding:0px; <?php echo $color;?>"><?php echo formatarNumeroTelefone($dadosLead['numero']);?></a></td>
									<td class="vinte" style="width:15%; text-align:center;"><a style="padding:0px; <?php echo $color;?>"><?php echo $origem;?></a></td>
									<td class="vinte" style="width:15%; text-align:center;"><a style="padding:0px; <?php echo $color;?>"><?php echo data($dataLead[0]);?> ás <?php echo $dataLead[1];?></a></td>
									<td class="vinte" style="width:15%; text-align:center;"><a style="padding:0px; <?php echo $color;?>"><strong style="font-weight:bold; <?php echo $color;?>"><?php echo $dadosUsuario['nomeUsuario'];?> <?php echo $dadosUsuario['sobrenomeUsuario'];?></strong><br/><?php echo $dataLeadA;?></a></td>
									<td class="vinte" style="width:15%; text-align:center;"><a style="padding:0px; <?php echo $color;?>"><?php echo $difference;?></a></td>
									<td class="botoes"><a style="cursor:pointer;" onClick="abreHistorico(<?php echo $dadosLead['codLead'];?>);"><img style="display:block;" src="<?php echo $configUrl; ?>f/i/documento.svg" alt="icone" width="40"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>comercial/leads/ativacao/<?php echo $dadosLead['codLead'] ?>/' title='Deseja <?php echo $statusPergunta ?> o lead <?php echo $dadosLead['nomeLead'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
								</tr>
								<tbody id="usuariosLeads<?php echo $dadosLead['codLead'];?>" style="display:none; opacity:0; transition: all .2s;">
<?php
						$sqlUsuarioLeadC = "SELECT * FROM usuariosLeads WHERE codLead = ".$dadosLead['codLead']." ORDER BY dataUsuarioLead ASC, codUsuarioLead ASC LIMIT 0,1";
						$resultUsuarioLeadC = $conn->query($sqlUsuarioLeadC);
						$dadosUsuarioLeadC = $resultUsuarioLeadC->fetch_assoc();
						
						if($dadosUsuarioLeadC['codUsuarioLead'] != ""){
?>
									<tr style="height:25px;">
										<th style="background-image: linear-gradient(#336699, #1d4b79); color:#FFF; font-size:13px; border-radius:10px 0px 0px 10px;" colspan="3">Corretor</th>
										<th style="background-image: linear-gradient(#336699, #1d4b79); color:#FFF; font-size:13px;" colspan="3">Enviado ás</th>
										<th style="background-image: linear-gradient(#336699, #1d4b79); color:#FFF; font-size:13px; border-radius:0px 10px 10px 0px;" colspan="3">Status</th>
									</tr>
<?php
							$contBack = 0;
							
							$sqlUsuariosLead = "SELECT * FROM usuariosLeads WHERE codLead = ".$dadosLead['codLead']." ORDER BY dataUsuarioLead ASC, codUsuarioLead ASC";
							$resultUsuariosLead = $conn->query($sqlUsuariosLead);
							while($dadosUsuariosLead = $resultUsuariosLead->fetch_assoc()){
								
								$contBack++;

								$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$dadosUsuariosLead['codUsuario']."' ORDER BY codUsuario DESC LIMIT 0,1";
								$resultUsuario = $conn->query($sqlUsuario);
								$dadosUsuario = $resultUsuario->fetch_assoc();
							
								$dataUsuarioLead = explode(" ", $dadosUsuariosLead['dataUsuarioLead']);
								
								if($dadosUsuariosLead['statusUsuarioLead'] == "T"){
									$statusUsuarioLead = "Atendido";
									$colorLead = "color:green;";
								}else
								if($dadosUsuariosLead['statusUsuarioLead'] == "F" && $dadosUsuariosLead['interacaoUsuarioLead'] != NULL){
									$statusUsuarioLead = "Recusado";
									$colorLead = "color:red;";
								}else
								if($dadosUsuariosLead['statusUsuarioLead'] == "F"){
									$statusUsuarioLead = "Não Atendido";
									$colorLead = "color:#666;";
								}else{
									$statusUsuarioLead = "Aguardando";
									$colorLead = "color:blue;";
								}
								
								if($contBack == 2){
									$contBack = 0;
									$background = "background:#f5f5f5;";
								}else{
									$background = "background:#e1dfdf;";
								}
?>									
									<tr class="tr" style="<?php echo $background;?>">
										<td class="trinta" style="text-align:center;" colspan="3"><a style="padding:0px; <?php echo $colorLead;?>"><?php echo $dadosUsuario['nomeUsuario'];?></a></td>
										<td class="vinte" style="text-align:center;" colspan="3"><a style="padding:0px; <?php echo $colorLead;?>"><?php echo data($dataUsuarioLead[0]);?> ás <?php echo $dataUsuarioLead[1];?></a></td>
										<td class="vinte" style="text-align:center;" colspan="3"><a style="padding:0px; <?php echo $colorLead;?>"><strong style="<?php echo $colorLead;?>"><?php echo $statusUsuarioLead;?></strong></td>
									</tr>									
<?php
							}
						}else{
?>									
									<tr>
										<td>Não há movimentações nesse Lead!</td>
									</tr>
<?php
						}
?>
								</tbody>
<?php
					}
?>
							</table>	
							<script type="text/javascript">
								function abreHistorico(cod){
									var $bg = jQuery.noConflict();
									if(document.getElementById("usuariosLeads"+cod).style.display=="none"){
										$bg("#usuariosLeads"+cod).slideDown(250);
										$bg("#usuariosLeads"+cod).css("opacity", "1");
									}else{
										$bg("#usuariosLeads"+cod).slideUp(250);
										$bg("#usuariosLeads"+cod).css("opacity", "0");
									}
								}
							</script>
<?php
				}
				
				$regPorPagina = 30;
				$area = "comercial/leads";
				include ('f/conf/paginacao.php');		
?>							
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
