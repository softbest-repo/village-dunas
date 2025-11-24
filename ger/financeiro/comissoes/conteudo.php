<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "comissoes";
			if(validaAcesso($conn, $area) == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Comissão cadastrada com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['cadastroSalario'] == "ok"){
					$erroConteudo = "<p class='erro'>Salário do funcionário foi cadastrado com sucesso!</p>";
					$_SESSION['cadastroSalario'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Comissão alterada com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Pagamento da Comissão ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Comissão excluída com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}
				
				if(isset($_POST['data1-receber'])){
					if($_POST['data1-receber'] != ""){
						$_SESSION['data1-receber'] = $_POST['data1-receber'];
					}else{
						$_SESSION['data1-receber'] = "";
					}
				}
				
				if($_SESSION['data1-receber'] != ""){
					$filtraData1 = " and C.dataComissao >= '".data($_SESSION['data1-receber'])."'";
					$filtraDataSalario1 = " and S.mesSalario >= '".data($_SESSION['data1-receber'])."'";
				}												
				
				if(isset($_POST['data2-receber'])){
					if($_POST['data2-receber'] != ""){
						$_SESSION['data2-receber'] = $_POST['data2-receber'];
					}else{
						$_SESSION['data2-receber'] = "";
					}
				}
				
				if($_SESSION['data2-receber'] != ""){
					$filtraData2 = " and C.dataComissao <= '".data($_SESSION['data2-receber'])."'";
					$filtraDataSalario2 = " and S.mesSalario <= '".data($_SESSION['data2-receber'])."'";					
				}
				
				if(isset($_POST['cidades-filtro'])){
					if($_POST['cidades-filtro'] == ""){
						$_SESSION['cidades-filtro'] = "";
					}else{
						$_SESSION['cidades-filtro'] = $_POST['cidades-filtro'];
					}
				}
				
				if($_SESSION['cidades-filtro'] != ""){
					$filtraCidade = " and C.codCidade = '".$_SESSION['cidades-filtro']."'";
				}			
				
				if(isset($_POST['bairro-filtro'])){
					if($_POST['bairro-filtro'] == ""){
						$_SESSION['bairro-filtro'] = "";
					}else{
						$_SESSION['bairro-filtro'] = $_POST['bairro-filtro'];
					}
				}
				
				if($_SESSION['bairro-filtro'] != ""){
					$filtraBairro = " and C.codBairro = '".$_SESSION['bairro-filtro']."'";
				}			
				
				if(isset($_POST['quadras-filtro'])){
					if($_POST['quadras-filtro'] == ""){
						$_SESSION['quadras-filtro'] = "";
					}else{
						$_SESSION['quadras-filtro'] = $_POST['quadras-filtro'];
					}
				}
				
				if($_SESSION['quadras-filtro'] != ""){
					$filtraQuadra = " and C.codQuadra = '".$_SESSION['quadras-filtro']."'";
				}			
				
				if(isset($_POST['lotes-filtro'])){
					if($_POST['lotes-filtro'] == ""){
						$_SESSION['lotes-filtro'] = "";
					}else{
						$_SESSION['lotes-filtro'] = $_POST['lotes-filtro'];
					}
				}
				
				if($_SESSION['lotes-filtro'] != ""){
					$filtraLote = " and C.codLote = '".$_SESSION['lotes-filtro']."'";
				}									
				
				if(isset($_POST['comissoes-filtro'])){
					if($_POST['comissoes-filtro'] == ""){
						$_SESSION['comissoes-filtro'] = "";
					}else{
						$_SESSION['comissoes-filtro'] = $_POST['comissoes-filtro'];
					}
				}			
				
				if($_SESSION['comissoes-filtro'] != ""){
					$filtraComissao = " and pagamentoComissao = '".$_SESSION['comissoes-filtro']."'";
				}
				
				if(isset($_POST['pagamento-filtro'])){
					if($_POST['pagamento-filtro'] == ""){
						$_SESSION['pagamento-filtro'] = "";
					}else{
						$_SESSION['pagamento-filtro'] = $_POST['pagamento-filtro'];
					}
				}			
				
				if($_SESSION['pagamento-filtro'] != ""){
					$filtraPagamento = " and statusComissaoCorretor = '".$_SESSION['pagamento-filtro']."'";
					$filtraPagamentoSalario = " and S.statusSalario = '".$_SESSION['pagamento-filtro']."'";
				}
				
				if(isset($_POST['corretor-filtro'])){
					if($_POST['corretor-filtro'] == ""){
						$_SESSION['corretor-filtro'] = "";
					}else{
						$_SESSION['corretor-filtro'] = $_POST['corretor-filtro'];
					}
				}			
				
				if($_SESSION['corretor-filtro'] != ""){
					$filtraCorretor = " and (U.codUsuario = ".$_SESSION['corretor-filtro'].")";
					$filtraCorretorSalario = " and (S.codUsuario = ".$_SESSION['corretor-filtro'].")";
				}
				
				if(isset($_POST['tipoImovel-filtro'])){
					if($_POST['tipoImovel-filtro'] == ""){
						$_SESSION['tipoImovel-filtro'] = "";
					}else{
						$_SESSION['tipoImovel-filtro'] = $_POST['tipoImovel-filtro'];
					}
				}			
				
				if($_SESSION['tipoImovel-filtro'] != ""){
					$filtraTipoImovel = " and C.tipoImovelComissao = '".$_SESSION['tipoImovel-filtro']."'";
				}
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Comissões</p>
						<p style="float:right; margin-right:5px; margin-top:-8px; cursor:pointer;" onClick="abreImprimir();"><img src="<?php echo $configUrl;?>f/i/icones-imprimir2.gif" width="40"/></p>											
<?php
	if($usuario == "A"){
?>
						<div class="botao-novo" style="margin-left:0px; float:right; margin-top:-8px; margin-right:30px;"><a onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Comissão</div><div class="direita-novo"></div></a></div>
<?php
	}
?>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
							<script>
								function abreCadastrarSalario(){
									var $rfs = jQuery.noConflict();
									if(document.getElementById("cadastrarSalario").style.display=="none"){
										$rfs("#cadastrarSalario").slideDown(250);
									}else{
										$rfs("#cadastrarSalario").slideUp(250);
									}
								}
								
								function abreCadastrar(){
									var $rf = jQuery.noConflict();
									if(document.getElementById("cadastrar").style.display=="none"){
										$rf("#cadastrar").slideDown(250);
									}else{
										$rf("#cadastrar").slideUp(250);
									}
								}

								function carregaBairroFiltro(cod){
									var $tgfs = jQuery.noConflict();
									$tgfs.post("<?php echo $configUrl;?>financeiro/comissoes/carrega-bairro-filtro.php", {codCidade: cod}, function(data){
										$tgfs("#carrega-bairro-filtro").html(data);
										$tgfs("#sel-padrao-filtro").css("display", "none");																									
									});
								}
							</script>
							<form id="filtroStatus" name="filtro" action="<?php echo $configUrl;?>financeiro/comissoes/" method="post" >

								<p class="bloco-campo-float"><label>De: <span class="obrigatorio"> </span></label>
								<input class="campo" type="text" id="data1-receber" name="data1-receber" style="width:140px;" value="<?php echo $_SESSION['data1-receber']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

								<p class="bloco-campo-float"><label>Até: <span class="obrigatorio"> </span></label>
								<input class="campo" type="text" id="data2-receber" name="data2-receber" style="width:140px;" value="<?php echo $_SESSION['data2-receber']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

								<p class="bloco-campo-float"><label>Cidade: <span class="obrigatorio"> </span></label>
									<select class="campo" id="cidades-filtro" name="cidades-filtro" style="width:180px; height:34px; margin-right:0px;" onChange="carregaBairroFiltro(this.value);">
										<option value="">Todos</option>
<?php
				$sqlCidade = "SELECT nomeCidade, codCidade FROM cidades WHERE statusCidade = 'T' ORDER BY nomeCidade ASC";
				$resultCidade = $conn->query($sqlCidade);
				while($dadosCidade = $resultCidade->fetch_assoc()){
?>
										<option value="<?php echo $dadosCidade['codCidade'] ;?>" <?php echo $_SESSION['cidades-filtro'] == $dadosCidade['codCidade'] ? '/SELECTED/' : '';?>><?php echo $dadosCidade['nomeCidade'] ;?></option>
<?php
				}
?>					
									</select>
								</p>
							
								<div id="carrega-bairro-filtro">
									<p class="bloco-campo-float"><label class="label">Bairro: <span class="obrigatorio"> </span></label>
										<select class="campo" name="bairro-filtro" style="width:180px; margin-right:0px; height:34px;" id="bairro-filtro">
											<option value="">Todos</option>

<?php
					$sqlBairro = "SELECT * FROM bairros WHERE statusBairro = 'T' ORDER BY nomeBairro ASC";
					$resultBairro = $conn->query($sqlBairro);
					while($dadosBairro = $resultBairro->fetch_assoc()){			
?>
											<option value="<?php echo $dadosBairro['codBairro']; ?>" <?php echo $dadosBairro['codBairro'] == $_SESSION['bairro-filtro'] ? '/SELECTED/' : ''; ?>><?php echo $dadosBairro['nomeBairro']; ?></option>
<?php
					}
?>
										</select>
									</p>
								</div>

								<p class="bloco-campo-float"><label>Quadra: <span class="obrigatorio"> </span></label>
									<select class="campo" id="quadras-filtro" name="quadras-filtro" style="width:80px; height:34px; margin-right:0px;">
										<option value="">Todos</option>
<?php
				$sqlQuadra = "SELECT nomeQuadra, codQuadra FROM quadras ORDER BY nomeQuadra ASC";
				$resultQuadra = $conn->query($sqlQuadra);
				while($dadosQuadra = $resultQuadra->fetch_assoc()){
?>
										<option value="<?php echo $dadosQuadra['codQuadra'] ;?>" <?php echo $_SESSION['quadras-filtro'] == $dadosQuadra['codQuadra'] ? '/SELECTED/' : '';?>><?php echo $dadosQuadra['nomeQuadra'] ;?></option>
<?php
				}
?>					
									</select>
								</p>

								<p class="bloco-campo-float"><label>Lote: <span class="obrigatorio"> </span></label>
									<select class="campo" id="lotes-filtro" name="lotes-filtro" style="width:80px; height:34px; margin-right:0px;">
										<option value="">Todos</option>
<?php
				$sqlLote = "SELECT nomeLote, codLote FROM lotes ORDER BY nomeLote ASC";
				$resultLote = $conn->query($sqlLote);
				while($dadosLote = $resultLote->fetch_assoc()){
?>
										<option value="<?php echo $dadosLote['codLote'] ;?>" <?php echo $_SESSION['lotes-filtro'] == $dadosLote['codLote'] ? '/SELECTED/' : '';?>><?php echo $dadosLote['nomeLote'] ;?></option>
<?php
				}
?>					
									</select>
								</p>

								<p class="bloco-campo-float"><label>Tipo Imóvel: <span class="obrigatorio"> </span></label>
									<select class="campo" id="tipoImovel-filtro" name="tipoImovel-filtro" style="width:100px; height:34px; margin-right:0px;">
										<option value="">Todos</option>
										<option value="P" <?php echo $_SESSION['tipoImovel-filtro'] == "P" ? '/SELECTED/' : '';?>>Próprio</option>				
										<option value="A" <?php echo $_SESSION['tipoImovel-filtro'] == "A" ? '/SELECTED/' : '';?>>Agenciado</option>				
									</select>
								</p>

								<p class="bloco-campo-float"><label>Comissões Imobiliária: <span class="obrigatorio"> </span></label>
									<select class="campo" id="comissoes-filtro" name="comissoes-filtro" style="width:175px; height:34px; margin-right:0px;">
										<option value="">Todos</option>
										<option value="T" <?php echo $_SESSION['comissoes-filtro'] == "T" ? '/SELECTED/' : '';?>>Recebido</option>				
										<option value="F" <?php echo $_SESSION['comissoes-filtro'] == "F" ? '/SELECTED/' : '';?>>A Receber</option>				
									</select>
								</p>
<?php
				if($usuario == "A"){
?>
								<p class="bloco-campo-float"><label>Pagamento: <span class="obrigatorio"> </span></label>
									<select class="campo" id="pagamento-filtro" name="pagamento-filtro" style="width:95px; height:34px; margin-right:0px;">
										<option value="">Todos</option>
										<option value="F" <?php echo $_SESSION['pagamento-filtro'] == "F" ? '/SELECTED/' : '';?>>Pago</option>				
										<option value="T" <?php echo $_SESSION['pagamento-filtro'] == "T" ? '/SELECTED/' : '';?>>A Pagar</option>				
									</select>
								</p>
								
<?php
				}else{
?>
								<p class="bloco-campo-float"><label>Pagamento: <span class="obrigatorio"> </span></label>
									<select class="campo" id="pagamento-filtro" name="pagamento-filtro" style="width:95px; height:34px; margin-right:0px;">
										<option value="">Todos</option>
										<option value="F" <?php echo $_SESSION['pagamento-filtro'] == "F" ? '/SELECTED/' : '';?>>Recebido</option>				
										<option value="T" <?php echo $_SESSION['pagamento-filtro'] == "T" ? '/SELECTED/' : '';?>>A Receber</option>				
									</select>
								</p>
<?php					
				}	
				
				if($usuario == "A"){
?>
								<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> </span></label>
									<select class="campo" id="corretor-filtro" name="corretor-filtro" style="width:200px; height:34px; margin-right:0px;">
										<option value="">Todos</option>
<?php
					$sqlUsuario = "SELECT * FROM usuarios WHERE statusUsuario = 'T' ORDER BY nomeUsuario ASC";
					$resultUsuario = $conn->query($sqlUsuario);
					while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
										<option style="<?php echo $dadosUsuario['tipoUsuario'] == "G" ? 'background:yellow;' : '';?> <?php echo $dadosUsuario['tipoUsuario'] == "C" ? 'background:#60c6ff;' : '';?><?php echo $dadosUsuario['tipoUsuario'] == "CE" ? 'background:#4ee900;' : '';?>" value="<?php echo $dadosUsuario['codUsuario'] ;?>" <?php echo $_SESSION['corretor-filtro'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
					}
?>					
									</select>
								</p>
<?php
				}		
?>		
				

								<p class="botao-filtrar"><input type="submit" name="filtrar" value="Filtrar" onClick="enviar()" /></p>
																										
								<br class="clear" />
							</form>
						</div>
					</div>			
<?php			
				if($_POST['cadastrar'] != "" || $_POST['cadastrarAdicionar'] != ""){
					
					if($_POST['tipoImovel'] != "" || $_POST['negociacao'] == "C"){
										
						if($_POST['agrupadorNovo'] == ""){
							$sqlComissaoAgrupador = "SELECT * FROM comissoes ORDER BY codAgrupadorComissao DESC LIMIT 0,1";
							$resultComissaoAgrupador = $conn->query($sqlComissaoAgrupador);
							$dadosComissaoAgrupador = $resultComissaoAgrupador->fetch_assoc();
						
							if($dadosComissaoAgrupador['codAgrupadorComissao'] != ""){
								$codAgrupadorComissao = $dadosComissaoAgrupador['codAgrupadorComissao'] + 1;
							}else{
								$codAgrupadorComissao = 1;
							}
						}else{
							$codAgrupadorComissao = $_POST['agrupadorNovo'];
						}
																																					
						$valorImovel = str_replace(".", "", $_POST['valor-imovel']);																														
						$valorImovel = str_replace(",", ".", $valorImovel);																														
						
						$valorImobiliaria = str_replace(".", "", $_POST['comissao-imobiliaria']);																														
						$valorImobiliaria = str_replace(",", ".", $valorImobiliaria);	
						
						$insertComissao = "INSERT INTO comissoes VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", ".$codAgrupadorComissao.", '".$_POST['cod-contrato']."', '".$_POST['negociacao']."', '".$_POST['tipoImovel']."', ".$_POST['cidades'].", ".$_POST['bairro'].", '".$_POST['quadras']."', '".$_POST['lotes']."', '".data($_POST['data'])."', '".$valorImovel."', '".$valorImobiliaria."', '".$_POST['obs-imobiliaria']."', 'F', 'T')";
						$resultComissao = $conn->query($insertComissao);					
														
						if($resultComissao == 1){
							
							$sqlComissao = "SELECT codComissao FROM comissoes WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]." and codAgrupadorComissao = ".$codAgrupadorComissao." ORDER BY codComissao DESC LIMIT 0,1";
							$resultComissao = $conn->query($sqlComissao);
							$dadosComissao = $resultComissao->fetch_assoc();
							
							if($valorImovel != "0.00"){							
								if($_POST['totalCorretores'] >= 1){
									for($i=1; $i<=$_POST['totalCorretores']; $i++){
										$item = $_POST['itemComissao'.$i];
										if($_POST['corretor'.$item] != "" && $_POST['valor'.$item] != ""){
											$quebraCod = explode("-", $_POST['corretor'.$item]);

											$valorComissao = str_replace(".", "", $_POST['valor'.$item]);																														
											$valorComissao = str_replace(",", ".", $valorComissao);	
																
											$sqlInsere = "INSERT INTO comissoesCorretores VALUES(0, ".$dadosComissao['codComissao'].", ".$quebraCod[1].", '".$valorComissao."', '".$_POST['obs-corretor'.$item]."', '".$item."', 'T')";
											$resultInsere = $conn->query($sqlInsere);										
										}
									}
								}
							}
						
							$_SESSION['cadastro'] = "ok";
							$_SESSION['cidades'] = "";
							$_SESSION['bairro'] = "";
							$_SESSION['quadras'] = "";
							$_SESSION['lotes'] = "";
							$_SESSION['data'] = "";
							$_SESSION['valor-imovel'] = "";
							$_SESSION['comissao-imobiliaria'] = "";
							
							if($_POST['cadastrarAdicionar'] != ""){
								$_SESSION['agrupadorNovo'] = $codAgrupadorComissao;
								echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/comissoes/'>";
							}else{
								$_SESSION['agrupadorNovo'] = "";
								echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/comissoes/'>";
							}
						}else{
							$erroData = "<p class='erro'>Problemas ao cadastrar comissão!</p>";
							$_SESSION['cidades'] = "";
							$_SESSION['bairro'] = "";
							$_SESSION['quadras'] = "";
							$_SESSION['lotes'] = "";
							$_SESSION['data'] = "";
							$_SESSION['valor-imovel'] = "";
							$_SESSION['comissao-imobiliaria'] = "";									
							$display = "none";
						}
					}else{
						$erroData = "<p class='erro'>O tipo de imóvel não foi selecionado (Agenciado ou Litoral)!</p>";
						$_SESSION['cidades'] = "";
						$_SESSION['bairro'] = "";
						$_SESSION['quadras'] = "";
						$_SESSION['lotes'] = "";
						$_SESSION['data'] = "";
						$_SESSION['valor-imovel'] = "";
						$_SESSION['comissao-imobiliaria'] = "";									
						$display = "none";
					}						
				}else{
					$_SESSION['cidades'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['quadras'] = "";
					$_SESSION['lotes'] = "";
					$_SESSION['data'] = "";
					$_SESSION['valor-imovel'] = "";
					$_SESSION['comissao-imobiliaria'] = "";	
					if($_SESSION['agrupadorNovo'] != ""){		
						$display = "block";	
					}else{
						$display = "none";
					}
				}	
				
				if($_POST['codAgrupadorComissao'] != ""){
					$_SESSION['agrupadorNovo'] = $_POST['codAgrupadorComissao'];
					$display = "block";
				}
				
				if($_SESSION['agrupadorNovo'] != ""){
					$display = "block";
				}
					
				if($erroData != "" || $erro == "sim" || $erro == "ok"){
?>
						<div class="area-erro">
<?php
					echo $erroData;
					if($erro == "sim" || $erro == "ok"){
						include('f/conf/mostraErro.php');
					}
?>
						</div>
<?php
				}
?>
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
					<div id="cadastrar" style="display:<?php echo $display;?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">															

						<p class="obrigatorio" style="color:#FF0000;">Campos obrigatórios *</p>
<?php
				if($_SESSION['agrupadorNovo'] != ""){
?>
						<fieldset style="width:935px; float:left; padding:10px; margin-bottom:30px; margin-top:30px;">
							<legend style="color:#666; padding:0px 10px; font-weight:bold; font-size:16px;">Imóveis Agrupados</legend>
							<table class="tabela-menus">
								<tr class="titulo-tabela" border="none" style="background:none;">
									<th class="canto-esq" style="background:#275788; color:#FFF;">Data</th>
									<th style="background:#275788; color:#FFF;">Negociação</th>
									<th style="background:#275788; color:#FFF;">Valor do Imóvel</th>
									<th style="background:#275788; color:#FFF;">Loteamento</th>
									<th style="background:#275788; color:#FFF;">Quadra</th>
									<th class="canto-dir" style="background:#275788; color:#FFF;">Lote</th>
								</tr>										
<?php
					$sqlComissao = "SELECT C.* FROM comissoes C left join comissoesCorretores CC on C.codComissao = CC.codComissao left join usuarios U on CC.codUsuario = U.codUsuario WHERE C.codAgrupadorComissao =  ".$_SESSION['agrupadorNovo']." GROUP BY C.codComissao ORDER BY C.statusComissao ASC, C.dataComissao DESC, C.codComissao DESC";
					$resultComissao = $conn->query($sqlComissao);
					while($dadosComissao = $resultComissao->fetch_assoc()){
						$mostrando++;
												
						$sqlBairro = "SELECT * FROM bairros WHERE codBairro = ".$dadosComissao['codBairro']." LIMIT 0,1";
						$resultBairro = $conn->query($sqlBairro);
						$dadosBairro = $resultBairro->fetch_assoc();				
						
						$sqlQuadra = "SELECT * FROM quadras WHERE codQuadra = ".$dadosComissao['codQuadra']." LIMIT 0,1";
						$resultQuadra = $conn->query($sqlQuadra);
						$dadosQuadra = $resultQuadra->fetch_assoc();				
						
						$sqlLote = "SELECT * FROM lotes WHERE codLote = ".$dadosComissao['codLote']." LIMIT 0,1";
						$resultLote = $conn->query($sqlLote);
						$dadosLote = $resultLote->fetch_assoc();		

						if($dadosComissao['negociacaoComissao'] == "V"){
							if($dadosImoveisLitoral['codImovel'] != ""){
								$background = "background:#60c6ff;";
								$corBolinha = "background-color:#60c6ff;";
								$corBola = "color:#60c6ff;";	
							}else{
								$background = "background:#4ee900;";
								$corBolinha = "background-color:#4ee900;";
								$corBola = "color:#4ee900;";
							}
						}else{
							$background = "background:#ff7070;";
							$corBolinha = "background-color:#ff7070;";
							$corBola = "color:#ff7070;";	
						}	
?>
								<tr class="tr" style="height:30px; <?php echo $background;?>">
									<td class="vinte" style="width:5%; padding:0px; text-align:center;"><a style="font-size:14px; text-decoration:none;"><?php echo data($dadosComissao['dataComissao']);?></a></td>										
									<td class="vinte" style="padding:0px; text-align:center;"><a style="font-size:14px; text-decoration:none;"><?php echo $dadosComissao['negociacaoComissao'] == "V" ? 'Venda' : 'Compra';?></a></td>										
									<td class="vinte" style="padding:0px; text-align:center;"><a style="font-size:14px; text-decoration:none;">R$ <?php echo number_format($dadosComissao['valorImovelComissao'], 2, ",", ".");?></a></td>										
									<td class="vinte" style="padding:0px; text-align:center;"><a style="font-size:14px; text-decoration:none;"><?php echo $dadosBairro['nomeBairro'];?></a></td>										
									<td class="vinte" style="width:5%; padding:0px; text-align:center;"><a style="font-size:14px; text-decoration:none;"><?php echo $dadosQuadra['nomeQuadra'];?></a></td>										
									<td class="vinte" style="width:5%; padding:0px; text-align:center;"><a style="font-size:14px; text-decoration:none;"><?php echo $dadosLote['nomeLote'];?></a></td>										
								</tr>
<?php
					}
?>
							</table>
						</fieldset>	
<?php
				}
?>						

						<br/>
						<form name="formcomissoes" action="<?php echo $configUrlGer; ?>financeiro/comissoes/" method="post" enctype="multipart/form-data">

							<script type="text/javascript">
								function carregaBairro(cod){
									var $tgf = jQuery.noConflict();
									$tgf.post("<?php echo $configUrl;?>financeiro/comissoes/carrega-bairro.php", {codCidade: cod}, function(data){
										$tgf("#carrega-bairro").html(data);
										$tgf("#sel-padrao").css("display", "none");																									
									});
								}
								
								function liberaCampos(campo){
									var $ll = jQuery.noConflict();

									document.getElementById("liberaDup").value="F";

									if(campo == "C"){
										var cidade = document.getElementById("cidades").value;
									
										if(cidade != ""){
											document.getElementById("bairro").disabled=false;
										}else{
											document.getElementById("bairro").disabled=true;																					
										}									
									
										document.getElementById("bairro").value="";
										document.getElementById("quadras").value="";
										document.getElementById("lotes").value="";											
										document.getElementById("quadras").disabled=true;											
										document.getElementById("lotes").disabled=true;											
									}else
									if(campo == "B"){
										var bairro = document.getElementById("bairro").value;
										
										if(bairro != ""){
											document.getElementById("quadras").disabled=false;
										}else{
											document.getElementById("quadras").disabled=true;

										}

										document.getElementById("quadras").value="";
										document.getElementById("lotes").value="";										
										document.getElementById("lotes").disabled=true;
									}else
									if(campo == "Q"){	
										var quadras = document.getElementById("quadras").value;
										
										if(quadras != ""){							
											document.getElementById("lotes").disabled=false;
										}else{
											document.getElementById("lotes").disabled=true;											
										}
										
										document.getElementById("lotes").value="";										
									}

									if(campo == "L"){	
										var lotes = document.getElementById("lotes").value;									
										if(lotes == ""){
											document.getElementById("erro").innerHTML="";
											$ll("#carrega-corretores").html("");
											document.getElementById("data").disabled = true;
											document.getElementById("data").value = "";
											document.getElementById("valor-imovel").disabled = true;
											document.getElementById("valor-imovel").value = "";
											document.getElementById("comissao-imobiliaria").disabled = true;
											document.getElementById("comissao-imobiliaria").value = "";
											document.getElementById("obs-imobiliaria").disabled = true;																					
											document.getElementById("obs-imobiliaria").value = "";													
										}
									}else{
										document.getElementById("erro").innerHTML="";	
										$ll("#carrega-corretores").html("");
										document.getElementById("data").disabled = true;
										document.getElementById("data").value = "";
										document.getElementById("valor-imovel").disabled = true;
										document.getElementById("valor-imovel").value = "";
										document.getElementById("comissao-imobiliaria").disabled = true;
										document.getElementById("comissao-imobiliaria").value = "";
										document.getElementById("obs-imobiliaria").disabled = true;																					
										document.getElementById("obs-imobiliaria").value = "";																					
									}
								}
							</script>

							<style>
								.modal {
									display: none; /* Escondido por padrão */
									position: fixed;
									z-index: 1000;
									left: 0;
									top: 0;
									width: 100%;
									height: 100%;
									background-color: rgba(0, 0, 0, 0.5); /* Fundo semi-transparente */
								}

								.modal-content {
									background-color: white;
									position:relative;
									margin: 15% auto;
									padding: 20px;
									border: 1px solid #888;
									width: 30%;
									text-align: center;
								}

								.close {
									color: #aaa;
									float: right;
									font-size: 28px;
									font-weight: bold;
								}

								.close:hover,
								.close:focus {
									color: black;
									text-decoration: none;
									cursor: pointer;
								}	
								
								#modal h2 {color:#718B8F; font-size:18px; margin-bottom:15px;}						
								#modal2 h2 {color:#718B8F; font-size:18px; margin-bottom:15px;}						
								#modal label {color:#666; margin-left:10px; cursor:pointer; margin-right:10px; display:inline-block; font-size:14px;}						
							</style>

							<div id="modal" class="modal">
								<div class="modal-content">
									<span class="close" onClick="fechaTipo();">&times;</span>
									<h2>Selecione uma opção:</h2>
									<label for="agenciado"><input type="radio" id="agenciado" name="imovel" onClick="selecionaTipo('A');" value="agenciado"/> Imóvel Agenciado</label>
									<label for="litoral"><input type="radio" id="litoral" name="imovel" onClick="selecionaTipo('P');" value="litoral"/> Imóvel Próprio</label>	
									<br class="clear"/>									
									<div class="botao-expansivel" style="display:table; margin:0 auto; margin-top:20px;" onClick="consultaImovel();"><p class="esquerda-botao"></p><input class="botao" type="button" value="Selecionar" /><p class="direita-botao"></p></div>						
								</div>
							</div>

							<div id="modal2" class="modal">
								<div class="modal-content">
									<h2>Esta comissão ja foi cadastrada, você deseja inseri-la novamente?</h2>
									<p style="font-size:16px;"><strong>Comissão inserida dia:</strong> <span id="dataComissaoInserida"></span></p>
									<br class="clear"/>									
									<div style="display:table; margin:0 auto;">
										<div class="botao-expansivel" style="display:table; float:left; margin-top:10px; margin-right:10px;" onClick="insereDuplicado();"><p class="esquerda-botao"></p><input class="botao" type="button" value="Inserir mesmo assim" /><p class="direita-botao"></p></div>						
										<div class="botao-expansivel" style="display:table; float:left; margin-top:10px;" onClick="cancelaInserir();"><p class="esquerda-botao"></p><input class="botao" type="button" value="Cancelar" /><p class="direita-botao"></p></div>						
										<br class="clear"/>
									</div>
								</div>
							</div>
    
							<fieldset style="float:left; padding:10px; margin-bottom:20px; position:relative;">
								<legend style="color:#666; padding:0px 10px; font-weight:bold; font-size:16px;">Selecione um imóvel</legend>
								
								<input type="hidden" value="<?php echo $_SESSION['agrupadorNovo'];?>" name="agrupadorNovo"/>
								
								<input type="hidden" value="" id="tipoImovel" name="tipoImovel"/>
								
								<input type="hidden" value="" id="loteAtual"/>
						
								<input type="hidden" value="F" id="liberaDup"/>

								<p class="bloco-campo-float">
									<label>Contrato:</label>
									<span style="font-size:13px; position:absolute; top:38px; left:470px; color:#666;">Para imóveis próprios selecione o contrato!</span>
									<select class="selectContrato form-control campo" id="idSelectContrato" name="cod-contrato" style="width:450px; display: none;">
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

								<br class="clear"/>
								
								<p class="bloco-campo-float"><label>Negociação: <span class="obrigatorio"> * </span></label>
									<select class="campo" id="negociacao" name="negociacao" style="width:125px;" required onChange="consultaImovel();">
										<option value="V" <?php echo $_SESSION['negociacao'] == "V" ? '/SELECTED/' : '';?>>Venda</option>				
										<option value="C" <?php echo $_SESSION['negociacao'] == "C" ? '/SELECTED/' : '';?>>Compra</option>				
									</select>
								</p>
							
								<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Cidade: <span class="obrigatorio"> * </span></label>
									<select class="campo" id="cidades" name="cidades" style="width:220px;" required onChange="carregaBairro(this.value); liberaCampos('C');">
										<option value="">Selecione</option>
<?php
				$sqlCidade = "SELECT nomeCidade, codCidade FROM cidades WHERE statusCidade = 'T' ORDER BY nomeCidade ASC";
				$resultCidade = $conn->query($sqlCidade);
				while($dadosCidade = $resultCidade->fetch_assoc()){
?>
										<option value="<?php echo $dadosCidade['codCidade'] ;?>" <?php echo $_SESSION['cidades'] == $dadosCidade['codCidade'] ? '/SELECTED/' : '';?>><?php echo $dadosCidade['nomeCidade'] ;?></option>
<?php
				}
?>					
									</select>
								</p>
																			
								<div id="carrega-bairro" style="float:left;">
<?php
				if($_SESSION['cidades'] != ""){
?>
									<p class="bloco-campo-float" style="margin-bottom:0px;"><label class="label">Bairro: <span class="obrigatorio"> * </span></label>
										<select class="campo" name="bairro" style="width:250px;" disabled="disabled" id="bairro" required onChange="liberaCampos('B');">
											<option value="" style="color:#FFF;">Selecione</option>

<?php
					$sqlBairro = "SELECT * FROM bairros WHERE statusBairro = 'T' and codCidade = ".$_SESSION['cidades']." ORDER BY nomeBairro ASC";
					$resultBairro = $conn->query($sqlBairro);
					while($dadosBairro = $resultBairro->fetch_assoc()){			
?>
											<option value="<?php echo $dadosBairro['codBairro']; ?>" <?php echo $dadosBairro['codBairro'] == $_SESSION['bairro'] ? '/SELECTED/' : ''; ?>><?php echo $dadosBairro['nomeBairro']; ?></option>
<?php
					}
?>
										</select>
									</p>
<?php
				}else{
?>
									<p class="bloco-campo-float" style="margin-bottom:0px;"><label class="label">Bairro: <span class="obrigatorio"> * </span></label>
										<select class="campo" name="bairro" style="width:250px;" disabled="disabled" id="bairro" required onChange="liberaCampos('B');">
											<option value="" style="color:#FFF;">Selecione uma cidade primeiro</option>
										</select>
									</p>
<?php
				}
?>
								</div>

								<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Quadra: <span class="obrigatorio"> * </span></label>
									<select class="campo" id="quadras" name="quadras" disabled="disabled" style="width:150px;" required onChange="liberaCampos('Q');">
										<option value="">Selecione</option>
<?php
				$sqlQuadra = "SELECT nomeQuadra, codQuadra FROM quadras ORDER BY nomeQuadra ASC";
				$resultQuadra = $conn->query($sqlQuadra);
				while($dadosQuadra = $resultQuadra->fetch_assoc()){
?>
										<option value="<?php echo $dadosQuadra['codQuadra'] ;?>" <?php echo $_SESSION['quadras'] == $dadosQuadra['codQuadra'] ? '/SELECTED/' : '';?> ><?php echo $dadosQuadra['nomeQuadra'] ;?></option>
<?php
				}
?>					
									</select>
								</p>

								<p class="bloco-campo-float" style="margin-bottom:0px; margin-right:0px;"><label>Lote: <span class="obrigatorio"> * </span></label>
									<select class="campo" id="lotes" name="lotes" disabled="disabled" style="width:150px;" required onChange="consultaImovel(); liberaCampos('L');">
										<option value="">Selecione</option>
<?php
				$sqlLote = "SELECT nomeLote, codLote FROM lotes ORDER BY nomeLote ASC";
				$resultLote = $conn->query($sqlLote);
				while($dadosLote = $resultLote->fetch_assoc()){
?>
										<option value="<?php echo $dadosLote['codLote'] ;?>" <?php echo $_SESSION['lotes'] == $dadosLote['codLote'] ? '/SELECTED/' : '';?>><?php echo $dadosLote['nomeLote'] ;?></option>
<?php
				}
?>					
									</select>
								</p>
							
								<br class="clear"/>
								<p style="position:absolute; right:-80px; top:0; display:none;" id="loading"><img style="display:block;" src="<?php echo $configUrlGer;?>f/i/loading.svg" width="80"/></p>
								<p id="erro" style="display:none; color:#FF0000; font-size:14px; font-weight:bold; text-align:center;"></p>
							</fieldset>					

							<script type="text/javascript">
								function number_format(number, decimals = 0, decPoint = '.', thousandsSep = ',') {
									if (isNaN(number)) return '0';

									const fixedNumber = parseFloat(number).toFixed(decimals);
									const parts = fixedNumber.split('.');
									const integerPart = parts[0];
									const decimalPart = parts[1] || '';

									const formattedInteger = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, thousandsSep);

									return decimalPart ? `${formattedInteger}${decPoint}${decimalPart}` : formattedInteger;
								}

								function fechaTipo(){
									var $ggs = jQuery.noConflict();
									document.getElementById("tipoImovel").value="";
									document.getElementById("agenciado").checked=false;
									document.getElementById("litoral").checked=false;
									document.getElementById("lotes").value="";
									$ggs("#modal").fadeOut(250);
								}
								
								function selecionaTipo(cod){
									document.getElementById("tipoImovel").value=cod;
									var lote = document.getElementById("lotes").value;
									document.getElementById("loteAtual").value=lote;
								}
								
								function insereDuplicado(){
									var $jj = jQuery.noConflict();
									document.getElementById("liberaDup").value="T";
									$jj("#modal2").fadeOut(250);
									consultaImovel();
								}
								
								function cancelaInserir(){
									var $kk = jQuery.noConflict();
									document.getElementById("liberaDup").value="F";
									$kk("#modal2").fadeOut(250);
								}
								
								function consultaImovel() {
									var $gg = jQuery.noConflict();
									
									$gg("#modal").fadeOut(250);

									var negociacao = document.getElementById("negociacao").value;
									var lote = document.getElementById("lotes").value;
									var loteAtual = document.getElementById("loteAtual").value;
									
									if(negociacao == "V"){
										document.getElementById("label-comissao").innerHTML="Comissão Imobiliária: *";
									}else{
										document.getElementById("label-comissao").innerHTML="Custo Total: *";										
									}
									
									if(lote != ""){

										var tipoImovel = document.getElementById("tipoImovel").value;
										var cidade = document.getElementById("cidades").value;
										var bairro = document.getElementById("bairro").value;
										var quadra = document.getElementById("quadras").value;
										var liberaDup = document.getElementById("liberaDup").value;

										$gg.post("<?php echo $configUrlGer;?>financeiro/comissoes/verifica-corretores.php", {codCidade: cidade, codBairro: bairro, codQuadra: quadra, codLote: lote, liberaDup: liberaDup}, function(data){		
										
											var resultado = data.trim();
											var quebraData = resultado.split("-");
											if(quebraData[0] != "existe"){
												if(data.trim() != "erro" && lote == loteAtual || data.trim() != "erro" && lote != "" && loteAtual == "" || tipoImovel != "" && lote == loteAtual || tipoImovel != "" && lote != "" && loteAtual == "" || negociacao == "C"){
											
													document.getElementById("loading").style.display = "block";
													document.getElementById("loteAtual").value=lote;
													
													if(tipoImovel == ""){
														tipoImovel = "N";
													}

													var jqxhr = $gg.post(
														"<?php echo $configUrl; ?>financeiro/comissoes/carrega-corretores.php",
														{
															negociacaoComissao: negociacao,
															codCidade: cidade,
															codBairro: bairro,
															codQuadra: quadra,
															codLote: lote,
															tipoImovel: tipoImovel
														}
													);

													jqxhr.done(function (data) {
														var result = data.trim();
														
														if (result != "erro imovel") {
															$gg("#carrega-corretores").html(data);
															document.getElementById("data").disabled = false;
															document.getElementById("data").value = "<?php echo data(date('Y-m-d')); ?>";
															document.getElementById("valor-imovel").disabled = false;
															document.getElementById("comissao-imobiliaria").disabled = false;
															document.getElementById("obs-imobiliaria").disabled = false;
															$gg("#carrega-corretores").fadeIn(200);
															$gg("#erro").html("");
														}else{
															$gg("#erro").css("display", "block");
															$gg("#erro").html("Não foi encontrado nenhum imóvel!");
															$gg("#carrega-corretores").html("");
															document.getElementById("data").disabled = true;
															document.getElementById("data").value = "";
															document.getElementById("valor-imovel").disabled = true;
															document.getElementById("valor-imovel").value = "";
															document.getElementById("obs-imobiliaria").value = "";
															document.getElementById("comissao-imobiliaria").disabled = true;
															document.getElementById("obs-imobiliaria").disabled = true;													
														}

														document.getElementById("loading").style.display = "none";
													});

													jqxhr.fail(function () {
														document.getElementById("loading").style.display = "none";
													});
												}else{
													$gg("#modal").fadeIn(250);
													$gg("#carrega-corretores").html("");
													document.getElementById("data").disabled = true;
													document.getElementById("data").value = "";
													document.getElementById("obs-imobiliaria").value = "";
													document.getElementById("tipoImovel").value = "";
													document.getElementById("agenciado").checked=false;
													document.getElementById("litoral").checked=false;										
													document.getElementById("valor-imovel").disabled = true;
													document.getElementById("comissao-imobiliaria").disabled = true;
													document.getElementById("obs-imobiliaria").disabled = true;		
												}
											}else{
												$gg("#modal2").fadeIn(250);
												document.getElementById("dataComissaoInserida").innerHTML=quebraData[1];
												$gg("#carrega-corretores").html("");
												document.getElementById("data").disabled = true;
												document.getElementById("data").value = "";
												document.getElementById("obs-imobiliaria").value = "";
												document.getElementById("tipoImovel").value = "";
												document.getElementById("agenciado").checked=false;
												document.getElementById("litoral").checked=false;										
												document.getElementById("valor-imovel").disabled = true;
												document.getElementById("comissao-imobiliaria").disabled = true;
												document.getElementById("obs-imobiliaria").disabled = true;	
											}
										});
									}else{
										$gg("#carrega-corretores").html("");
										document.getElementById("data").disabled = true;
										document.getElementById("data").value = "";
										document.getElementById("tipoImovel").value = "";
										document.getElementById("agenciado").checked=false;
										document.getElementById("litoral").checked=false;										
										document.getElementById("valor-imovel").disabled = true;
										document.getElementById("comissao-imobiliaria").disabled = true;
										document.getElementById("obs-imobiliaria").disabled = true;										
									}
								}
								
								function atualizaComissao() {
									var tipoImovel = document.getElementById("tipoImovel").value;
									var indicacao = document.getElementById("corretorIN").value;
									var corretorVenda = document.getElementById("corretorCV").value;
									var corretorAgencia = document.getElementById("corretorCA").value;
									var tipoComissao = document.getElementById("tipoComissao").value;
									var imovelComissao = document.getElementById("imovelComissao").value;
									if(indicacao != ""){
										buscaComissao(indicacao, tipoComissao, imovelComissao, 'IN', '');
									}
									if(corretorVenda != ""){
										buscaComissao(corretorVenda, tipoComissao, imovelComissao, 'CV', '');
									}
									if(corretorAgencia != "" && imovelComissao == "A"){
										buscaComissao(corretorAgencia, tipoComissao, imovelComissao, 'CA', '');										
									}
								}
								
								function atualizaComissaoInd() {
									var indicacao = document.getElementById("corretorIN").value;
									var indicacaoValor = document.getElementById("valorIN").value;
									if(indicacaoValor != "0,00" && indicacaoValor != "0"){
										var tipoImovel = document.getElementById("tipoImovel").value;
										var corretorVenda = document.getElementById("corretorCV").value;
										var corretorAgencia = document.getElementById("corretorCA").value;
										var tipoComissao = document.getElementById("tipoComissao").value;
										var imovelComissao = document.getElementById("imovelComissao").value;
										if(corretorVenda != ""){
											buscaComissao(corretorVenda, tipoComissao, imovelComissao, 'CV', '');
										}
										if(corretorAgencia != "" && imovelComissao == "A"){
											buscaComissao(corretorAgencia, tipoComissao, imovelComissao, 'CA', '');										
										}
									}else{
										document.getElementById("corretorIN").value="";
										document.getElementById("valorIN").value=0;
										atualizaComissao();
									}
								}
								
								function buscaComissao(cod, tipo, imovel, linha, comissaoCorretor) {
									var $h = jQuery.noConflict();
																		
									if(cod != ""){

										var codArray = cod.split("-");
									
										document.getElementById("loading").style.display = "block";

										if (codArray.length < 2) {
											console.error("Código inválido.");
											document.getElementById("loading").style.display = "none";
											return;
										}
										var codUsuario = codArray[1];

										var valorImovel = document.getElementById("valor-imovel").value;
										valorImovel = valorImovel.replace(".", "");
										valorImovel = valorImovel.replace(",", ".");
										
										var comissaoImobiliaria = document.getElementById("comissao-imobiliaria").value;
										comissaoImobiliaria = comissaoImobiliaria.replace(".", "");
										comissaoImobiliaria = comissaoImobiliaria.replace(".", "");
										comissaoImobiliaria = comissaoImobiliaria.replace(",", ".");

										var tipoImovel = document.getElementById("tipoImovel").value;
										var enviaValor = comissaoImobiliaria;

										var tipoCorretor = document.getElementById("tipoCorretor").value;

										var url = "consulta-comissoes.php?codUsuario=" + encodeURIComponent(codUsuario) +
												  "&tipo=" + encodeURIComponent(tipo) +
												  "&imovel=" + encodeURIComponent(imovel) +
												  "&linha=" + encodeURIComponent(linha) +
												  "&comissao=" + encodeURIComponent(enviaValor) +
												  "&comissaoCorretor=" + encodeURIComponent(comissaoCorretor) +
												  "&tipoCorretor=" + encodeURIComponent(tipoCorretor) +
												  "&valorImovel=" + encodeURIComponent(valorImovel);

										$h.ajax({
											url: url,
											method: "GET",
											dataType: "json",
											success: function(response) {
												if (response.erro) {
													console.error(response.erro);
												} else {
													var indicacao = document.getElementById("corretorIN").value;
													var valorIndicacao = document.getElementById("valorIN").value;
													valorIndicacao = valorIndicacao.replace(/\./g, "");
													valorIndicacao = valorIndicacao.replace(",", ".");
													if(linha == "CV" && indicacao != ""){
														var novaComissao = parseFloat(enviaValor) - parseFloat(valorIndicacao);
														var novaComissaoValor = 0.4 * novaComissao;
														document.getElementById("valor"+linha).value = number_format(novaComissaoValor, 2, ",", ".");
													}else
													if(linha == "CA" && indicacao != ""){
														var novaComissao = parseFloat(enviaValor) - parseFloat(valorIndicacao);
														var novaComissaoValor = 0.1 * novaComissao;
														document.getElementById("valor"+linha).value = number_format(novaComissaoValor, 2, ",", ".");
													}else{
														document.getElementById("valor"+linha).value=response.comissao;
													}
												}
											},
											error: function(xhr, status, error) {
												console.error("Erro na requisição AJAX:", error);
											},
											complete: function() {
												document.getElementById("loading").style.display = "none";
											}
										});
									}else{
										document.getElementById("valor"+linha).value="";										
									}
								}
							</script>																														

							<br class="clear"/>
							
							<fieldset style="width:935px; float:left; padding:10px;">
								<legend style="color:#666; padding:0px 10px; font-weight:bold; font-size:16px;">Preencha as comissões</legend>

								<p class="bloco-campo-float"><label>Data: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" name="data" id="data" required disabled="disabled" style="width:150px; height:16px;" value="<?php echo $_SESSION['data'];?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>	
								
								<p class="bloco-campo-float"><label>Valor do Imóvel: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" name="valor-imovel" disabled="disabled" id="valor-imovel" required style="width:150px;" value="<?php echo $_SESSION['valor-imovel'];?>" onKeyup="moeda(this);"/></p>	
								
								<p class="bloco-campo-float"><label id="label-comissao">Comissão Imobiliária: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" name="comissao-imobiliaria" disabled="disabled" id="comissao-imobiliaria" required style="width:161px;" value="<?php echo $_SESSION['comissao-imobiliaria'];?>" onKeyup="moeda(this); atualizaComissao();"/></p>	

								<p class="bloco-campo-float" style="margin-right:0px;"><label>OBS Imobiliária: <span class="obrigatorio"> </span></label>
								<input class="campo" type="text" name="obs-imobiliaria" disabled="disabled" id="obs-imobiliaria" style="width:380px;" value="<?php echo $_SESSION['obs-imobiliaria'];?>"/></p>													
								<br class="clear"/>
								
								<div id="carrega-corretores" style="display:none;">
									
								</div>
							
							</fieldset>																												

							<br class="clear"/>
																					
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Comissão" value="Salvar" /><p class="direita-botao"></p></div></p>						
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrarAdicionar" title="Salvar e Adicionar um Imóvel a esta Venda ou Compra" value="Salvar e adicionar + um Imóvel" /><p class="direita-botao"></p></div></p>						
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
					
					function abreImprimir(){
						var $ee = jQuery.noConflict();
						$ee("#conteudo-imprimir").fadeIn("slow");
						document.getElementById("botao-imprimir").style.display="none";
					}
				</script>			
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
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; padding-top:5px; margin:0; font-family:Arial; font-size:24px; font-weight:bold;"><?php echo $nomeEmpresaMenor;?> - Comissões</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:20px;">
									<div id="mostra-dados" style="width:100%;">
<?php			
				if($usuario != "A"){
					if($usuario == "C"){
						$filtraUsuarioComissoes = " and U.codUsuario = ".$_COOKIE['codAprovado'.$cookie]."";
					}else
					if($usuario == "CE"){
						$filtraUsuarioComissoes = " and U.codUsuario = ".$_COOKIE['codAprovado'.$cookie]."";
					}
				}
										
				$sqlConta = "SELECT count(C.codComissao) registros, C.codComissao FROM comissoes C left join comissoesCorretores CC on C.codComissao = CC.codComissao left join usuarios U on CC.codUsuario = U.codUsuario WHERE C.codComissao != ''".$filtraData1.$filtraData2.$filtraCidade.$filtraBairro.$filtraQuadra.$filtraLote.$filtraComissao.$filtraPagamento.$filtraCorretor.$filtraUsuarioComissoes.$filtraTipoImovel." GROUP BY C.codComissao";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['codComissao'] != ""){
?>
										<div id="nomes" style="width:100%; background-color:#275788;">
											<p style="width:10.376%; float:left; margin:0; padding:1% 0.5%; font-size:11px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; border:1px solid #FFF; border-left:none; border-bottom:none; background-color:#275788;">Identificador</p>
											<p style="width:18%; float:left; margin:0; padding:1% 0.5%; font-size:11px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; border:1px solid #FFF; border-left:0px; border-bottom:none; background-color:#275788;">Tipo Comissão</p>
											<p style="width:15%; float:left; margin:0; padding:1% 0.5%; font-size:11px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; border:1px solid #FFF; border-left:0px; border-bottom:none; background-color:#275788;">Comissão / Custos</p>
											<p style="width:15%; float:left; margin:0; padding:1% 0.5%; font-size:11px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; border:1px solid #FFF; border-left:0px; border-bottom:none; background-color:#275788;">Corretor</p>
											<p style="width:25%; float:left; margin:0; padding:1% 0.5%; font-size:11px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; border:1px solid #FFF; border-left:0px; border-bottom:none; background-color:#275788;">Observação</p>
											<p style="width:10%; float:left; margin:0; padding:1% 0.5%; font-size:11px; font-weight:bold; color:#FFF; font-family:Arial; text-align:center; border:1px solid #FFF; border-left:0px; border-bottom:none; border-right:none; background-color:#275788;">Pagamento</p>
											<br style="clear:both;"/>
										</div>
<?php
				}
			
				if($usuario == "C"){
					$filtraUsuarioComissoes = " and U.codUsuario = ".$_COOKIE['codAprovado'.$cookie]."";
				}else{
					$filtraUsuarioComissoes = "";
				}
			
				$totalImoveisVenda = 0;
				$totalImoveisCompra = 0;
				$totalImobiliaria = 0;
				$totalVendedor = 0;
				$totalAgenciador = 0;
				$totalGerenteVenda = 0;
				$totalGerenteAgenciador = 0;
				$totalAgenciadorCompra = 0;
				$totalGerenteAgenciadorCompra = 0;
				
				$sqlComissao = "SELECT C.* FROM comissoes C left join comissoesCorretores CC on C.codComissao = CC.codComissao left join usuarios U on CC.codUsuario = U.codUsuario WHERE C.codComissao != ''".$filtraData1.$filtraData2.$filtraCidade.$filtraBairro.$filtraQuadra.$filtraLote.$filtraComissao.$filtraPagamento.$filtraCorretor.$filtraUsuarioComissoes.$filtraTipoImovel." GROUP BY C.codComissao ORDER BY C.statusComissao ASC, C.dataComissao DESC, C.codAgrupadorComissao ASC, C.codComissao DESC";
				$resultComissao = $conn->query($sqlComissao);
				while($dadosComissao = $resultComissao->fetch_assoc()){
																
					$sqlBairro = "SELECT * FROM bairros WHERE codBairro = ".$dadosComissao['codBairro']." LIMIT 0,1";
					$resultBairro = $conn->query($sqlBairro);
					$dadosBairro = $resultBairro->fetch_assoc();				
					
					$sqlQuadra = "SELECT * FROM quadras WHERE codQuadra = ".$dadosComissao['codQuadra']." LIMIT 0,1";
					$resultQuadra = $conn->query($sqlQuadra);
					$dadosQuadra = $resultQuadra->fetch_assoc();				
					
					$sqlLote = "SELECT * FROM lotes WHERE codLote = ".$dadosComissao['codLote']." LIMIT 0,1";
					$resultLote = $conn->query($sqlLote);
					$dadosLote = $resultLote->fetch_assoc();										

					if($dadosComissao['negociacaoComissao'] == "V"){
						if($dadosImoveisLitoral['codImovel'] != ""){
							$background = "background:#60c6ff;";
							$corBolinha = "background-color:#60c6ff;";
							$corBola = "color:#60c6ff;";	
						}else{
							$background = "background:#4ee900;";
							$corBolinha = "background-color:#4ee900;";
							$corBola = "color:#4ee900;";
						}
					}else{
						$background = "background:#ff7070;";
						$corBolinha = "background-color:#ff7070;";
						$corBola = "color:#ff7070;";	
					}											
?>
										<div id="clientes" style="width:100%; <?php echo $background;?>">
											<p class="nome-cliente" style="width:10.3%; float:left; margin:0; padding:1% 0.5%; font-family:Arial; font-size:10px; border:1px dashed #000; border-top:none; border-right:none;"><?php echo $dadosComissao['valorImovelComissao'] != "0.00" ? data($dadosComissao['dataComissao']) : '--';?></p>
											<p class="nome-cliente" style="width:18%; float:left; margin:0; padding:1% 0.5%; font-family:Arial; font-size:10px; border:1px dashed #000; border-top:none; border-right:none;"><strong style="font-size:10px;">Negociação:</strong> <?php echo $dadosComissao['valorImovelComissao'] != "0.00" ? $dadosComissao['negociacaoComissao'] == "V" ? 'Venda' : 'Compra' : '--';?></p>
											<p class="nome-cliente" style="width:20%; float:left; margin:0; padding:1% 0.5%; font-family:Arial; font-size:10px; border:1px dashed #000; border-top:none; border-right:none;"><strong style="font-size:10px;">Valor do Imóvel:</strong> <?php echo $dadosComissao['valorImovelComissao'] != "0.00" ? number_format($dadosComissao['valorImovelComissao'], 2, ",", ".") : '--';?></p>
											<p class="nome-cliente" style="width:25%; float:left; margin:0; padding:1% 0.5%; font-family:Arial; font-size:10px; border:1px dashed #000; border-top:none; border-right:none;"><strong style="font-size:10px;">Bairro:</strong> <?php echo $dadosBairro['nomeBairro'];?></p>
											<p class="nome-cliente" style="width:9.955%; float:left; margin:0; padding:1% 0.5%; font-family:Arial; font-size:10px; border:1px dashed #000; border-top:none; border-right:none;"><strong style="font-size:10px;">Quadra:</strong> <?php echo $dadosQuadra['nomeQuadra'];?></p>
											<p class="nome-cliente" style="width:9.874%; float:left; margin:0; padding:1% 0.5%; font-family:Arial; font-size:10px; border:1px dashed #000; border-top:none;"><strong style="font-size:10px;">Lote:</strong> <?php echo $dadosLote['nomeLote'];?></p>
											<br style="clear:both;"/>
										</div>
<?php
					if($usuario == "A" && $dadosComissao['valorImovelComissao'] != "0.00"){
?>
										<div id="clientes" style="width:100%;">
											<p class="nome-cliente" style="width:10.3%; float:left; margin:0; padding:0.5% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;"><span style="width:30px; height:30px; display:block; margin:0 auto; <?php echo $corBolinha;?> border-radius:100%; color:#FFF; position:relative;"><span style="position:absolute; top:50%; font-size:16px; left:50%; font-family:Impact; transform:translate(-50%, -50%);"><?php echo $dadosComissao['codAgrupadorComissao'];?></span></span></p>
											<p class="nome-cliente" style="width:18%; float:left; margin:0; padding:1.6% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;">Imobiliária</p>
											<p class="nome-cliente" style="width:15%; float:left; margin:0; padding:1.6% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;">R$ <?php echo number_format($dadosComissao['valorImovelComissao'], 2, ",", ".");?></p>
											<p class="nome-cliente" style="width:15%; float:left; margin:0; padding:1.6% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;">Markan Imóveis</p>
											<p class="nome-cliente" style="width:24.997%; float:left; margin:0; padding:0% 0.5%; height:38px; overflow:hidden; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;"><span style="height:38px; font-size:11px; display:table-cell; vertical-align:middle;"><?php echo $dadosComissao['obsImobiliariaComissao'];?></span></p>
											<p class="cidade-cliente" style="width:9.832%; float:left; margin:0; padding:1.6% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none;"><?php echo $dadosComissao['statusComissao'] == "T" ? 'A Pagar' : 'Pago';?></p>
											<br style="clear:both;"/>
										</div>
<?php
					}

					$sqlCorretores = "SELECT * FROM comissoesCorretores CC inner join usuarios U on CC.codUsuario = U.codUsuario WHERE CC.codComissao = ".$dadosComissao['codComissao']."".$filtraCorretor.$filtraUsuarioComissoes." GROUP BY CC.codComissaoCorretor ORDER BY CC.linhaComissaoCorretor ASC, CC.codComissaoCorretor ASC";
					$resultCorretores = $conn->query($sqlCorretores);
					while($dadosCorretores = $resultCorretores->fetch_assoc()){
					
						$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosCorretores['codUsuario']." ORDER BY codUsuario ASC LIMIT 0,1";
						$resultUsuario = $conn->query($sqlUsuario);
						$dadosUsuario = $resultUsuario->fetch_assoc();
													
						if($dadosCorretores['linhaComissaoCorretor'] == "IN"){
							$linha = "Indicação";
						}else
						if($dadosCorretores['linhaComissaoCorretor'] == "CV"){
							$linha = "Corretor Venda";
						}else
						if($dadosCorretores['linhaComissaoCorretor'] == "CA"){
							$linha = "Corretor Agenciamento";
						}					
?>
										<div id="clientes" style="width:100%;">
											<p class="nome-cliente" style="width:10.3%; float:left; margin:0; padding:0.55% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;"><span style="width:30px; height:30px; display:block; margin:0 auto; border-radius:100%; <?php echo $corBola;?> border:1px solid #ccc; position:relative;"><span style="position:absolute; top:50%; font-size:16px; left:50%; font-family:Impact; transform:translate(-50%, -50%);"><?php echo $dadosComissao['codAgrupadorComissao'];?></span></span></p>
											<p class="nome-cliente" style="width:18%; float:left; margin:0; padding:1.8% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;"><?php echo $linha;?></p>
											<p class="nome-cliente" style="width:15%; float:left; margin:0; padding:1.8% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;">R$ <?php echo number_format($dadosCorretores['valorComissaoCorretor'], 2, ",", ".");?></p>
											<p class="nome-cliente" style="width:15%; float:left; margin:0; padding:1.8% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;"><?php echo mb_strimwidth($dadosUsuario['nomeUsuario'], 0, 21, "...");?></p>
											<p class="nome-cliente" style="width:24.997%; float:left; margin:0; padding:0% 0.5%; height:41px; overflow:hidden; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none; border-right:none;"><span style="height:38px; font-size:11px; display:table-cell; vertical-align:middle;"><?php echo $dadosCorretores['obsComissaoCorretor'] != "" ? $dadosCorretores['obsComissaoCorretor'] : '--';?></span></p>
											<p class="cidade-cliente" style="width:9.832%; float:left; margin:0; padding:1.8% 0.5%; font-family:Arial; font-size:11px; border:1px dashed #000; border-top:none;"><?php echo $dadosCorretores['statusComissaoCorretor'] == "T" ? 'A Pagar' : 'Pago';?></p>
											<br style="clear:both;"/>
										</div>
<?php						
					}
				}
					
					$totalImoveisCompra = 0;
					$totalVendedor = 0;
					$totalAgenciador = 0;
					$totalGerenteVenda = 0;
					$totalGerenteAgenciador = 0;
					$totalImobiliaria = 0;
					$totalAgenciadorCompra = 0;
					$totalGerenteAgenciadorCompra = 0;
					$totalGerenteAgenciadorCompra = 0;
					$totalImobiliariaAgenciador = 0;
					$totalImoveisVenda = 0;
					$totalImoveisCompra = 0;
					
					$sqlComissao = "SELECT C.* FROM comissoes C inner join comissoesCorretores CC on C.codComissao = CC.codComissao left join usuarios U on CC.codUsuario = U.codUsuario WHERE C.codComissao != ''".$filtraData1.$filtraData2.$filtraCidade.$filtraBairro.$filtraQuadra.$filtraLote.$filtraComissao.$filtraPagamento.$filtraCorretor.$filtraUsuarioComissoes.$filtraTipoImovel." GROUP BY C.codComissao";
					$resultComissao = $conn->query($sqlComissao);
					while($dadosComissao = $resultComissao->fetch_assoc()){

						$sqlCorretores = "SELECT * FROM comissoesCorretores CC inner join usuarios U on CC.codUsuario = U.codUsuario WHERE CC.codComissao = ".$dadosComissao['codComissao']."".$filtraCorretor.$filtraUsuarioComissoes." GROUP BY CC.codComissaoCorretor ORDER BY CC.linhaComissaoCorretor ASC, CC.codComissaoCorretor ASC";
						$resultCorretores = $conn->query($sqlCorretores);
						while($dadosCorretores = $resultCorretores->fetch_assoc()){						
							
							if($dadosComissao['negociacaoComissao'] == "V"){

								if($dadosCorretores['linhaComissaoCorretor'] == "CV"){
									$totalVendedor = $totalVendedor + $dadosCorretores['valorComissaoCorretor'];
								}else
								if($dadosCorretores['linhaComissaoCorretor'] == "CA"){
									$totalAgenciador = $totalAgenciador + $dadosCorretores['valorComissaoCorretor'];
								}else
								if($dadosCorretores['linhaComissaoCorretor'] == "GV"){
									$totalGerenteVenda = $totalGerenteVenda + $dadosCorretores['valorComissaoCorretor'];
								}else
								if($dadosCorretores['linhaComissaoCorretor'] == "GA"){
									$totalGerenteAgenciador = $totalGerenteAgenciador + $dadosCorretores['valorComissaoCorretor'];
								}else{
									$totalOutras = $totalOutras + $dadosCorretores['valorComissaoCorretor'];
								}
							
							}else{
								if($dadosCorretores['linhaComissaoCorretor'] == "CA"){
									$totalAgenciadorCompra = $totalAgenciadorCompra + $dadosCorretores['valorComissaoCorretor'];
								}
								
								if($dadosCorretores['linhaComissaoCorretor'] == "GA"){
									$totalGerenteAgenciadorCompra = $totalGerenteAgenciadorCompra + $dadosCorretores['valorComissaoCorretor'];
								}			
								
							}
							
							if($dadosCorretores['codUsuario'] == $_COOKIE['codAprovado'.$cookie]){
								
								if($dadosCorretores['statusComissaoCorretor'] == "T"){
									$totalComissaoCorretorA = $totalComissaoCorretorA + $dadosCorretores['valorComissaoCorretor'];
								}else
								if($dadosCorretores['statusComissaoCorretor'] == "F"){
									$totalComissaoCorretorR = $totalComissaoCorretorR + $dadosCorretores['valorComissaoCorretor'];							
								}
								
								$totalComissaoCorretor = $totalComissaoCorretor + $dadosCorretores['valorComissaoCorretor'];
							}
							
							if($dadosCorretores['statusComissaoCorretor'] == "T"){
								$totalAComissaoCorretorA = $totalAComissaoCorretorA + $dadosCorretores['valorComissaoCorretor'];
							}else
							if($dadosCorretores['statusComissaoCorretor'] == "F"){
								$totalAComissaoCorretorR = $totalAComissaoCorretorR + $dadosCorretores['valorComissaoCorretor'];							
							}
							
							$totalAComissaoCorretor = $totalAComissaoCorretor + $dadosCorretores['valorComissaoCorretor'];

						}

						if($dadosComissao['negociacaoComissao'] == "V"){
							$totalImobiliaria = $totalImobiliaria + $dadosComissao['imobiliariaComissao'];
						}else{
							$totalImobiliariaAgenciador = $totalImobiliariaAgenciador + $dadosComissao['imobiliariaComissao'];								
						}						
						
						if($dadosComissao['negociacaoComissao'] == "V"){
							$totalImoveisVenda = $totalImoveisVenda + $dadosComissao['valorImovelComissao'];							
						}else{
							$totalImoveisCompra = $totalImoveisCompra + $dadosComissao['valorImovelComissao'];															
						}
				
					}
										
					$totalCusto = $totalAComissaoCorretor;
					$totalCustoAgenciador = $totalAgenciadorCompra + $totalGerenteAgenciadorCompra;
				
					$lucro = $totalImobiliaria - $totalCusto;
					$custo = $totalImobiliariaAgenciador + $totalCustoAgenciador;
					$custoExtra = $totalImobiliariaAgenciador - $totalImoveisCompra;
					
					$custoComissao = $totalCusto + $totalCustoAgenciador;
					$custoImoveis = $custoComissao + $totalImobiliariaAgenciador;
				
					$totalCustoComissao = $custoImoveis;	
					$lucroGeral = $totalImobiliaria - $custoImoveis;
?>
										<div id="total" style="margin-top:20px;">
<?php
					if($usuario == "A"){
?>					
											<div style="margin-bottom:20px;">
												<p class="total" style="font-size:13px; text-align:center; font-weight:bold; color:#000; border:1px solid #000; padding:5px 10px; border-bottom:none;">Comissões Corretores</p>
												<table style="width:100%; border:1px solid #444;">
													<tr>
														<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 10px; font-weight:bold; font-size:13px;">Total em Vendas</td>
														<td style="padding:5px 10px; color:#000; border-bottom:1px solid #000; font-size:13px;">R$ <?php echo number_format($totalImoveisVenda, 2, ",", ".");?></td>
													</tr>
													<tr>
														<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 10px; font-weight:bold; font-size:14px;">Total de Comissões</td>
														<td style="padding:5px 10px; color:#000; border-bottom:1px solid #000; font-size:14px;">R$ <?php echo number_format($totalAComissaoCorretor, 2, ",", ".");?></td>
													</tr>
													<tr>
														<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 10px; font-weight:bold; font-size:13px;">Comissões Pagas</td>
														<td style="padding:5px 10px; color:#000; border-bottom:1px solid #000; font-size:13px;">R$ <?php echo number_format($totalAComissaoCorretorR, 2, ",", ".");?></td>
													</tr>
<?php
					if($filtraCorretorSalario != "" && $dadosSalariosConfere['codSalario'] != "" || $filtraUsuarioComissoes != "" && $dadosSalariosConfere['codSalario'] != "" && $usuario == "C"){
?>
													<tr>
														<td style="border-right:1px solid #000; font-size:13px; border-bottom:1px solid #000; color:#000; padding:5px 10px; font-weight:bold;">Salário</td>
														<td style="padding:5px 10px; color:#000; font-size:13px; border-bottom:1px solid #000;">R$ <?php echo number_format($totalSalario, 2, ",", ".");?></td>
													</tr>
<?php
					}
?>
													<tr>
														<td style="border-right:1px solid #000; color:#FFF; padding:5px 10px; background-color:#FF0000; font-weight:bold; font-size:14px;">A Pagar</td>
														<td style="padding:5px 10px; color:#FFF; font-size:14px; background-color:#FF0000;">R$ <?php echo number_format($totalAComissaoCorretorA+$totalSalario, 2, ",", ".");?></td>
													</tr>
												</table>
											</div>
<?php
					}else{
?>
											<div style="float:right;">
												<p class="total" style="font-size:13px; text-align:center; font-weight:bold; color:#FFF; border:1px solid #000; background-color:#000; padding:5px 15px; border-bottom:none;">Suas Comissões</p>
												<table style="border:1px solid #444;">
													<tr>
														<td style="border-right:1px solid #000; font-size:13px; border-bottom:1px solid #000; color:#000; padding:5px 10px; font-weight:bold;">Total em Vendas</td>
														<td style="padding:5px 10px; color:#000; font-size:13px; border-bottom:1px solid #000;">R$ <?php echo number_format($totalImoveisVenda, 2, ",", ".");?></td>
													</tr>
													<tr>
														<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 10px; font-weight:bold; font-size:14px;">Total de Comissões</td>
														<td style="padding:5px 10px; color:#000; border-bottom:1px solid #000; font-size:14px;">R$ <?php echo number_format($totalComissaoCorretor, 2, ",", ".");?></td>
													</tr>
													<tr>
														<td style="border-right:1px solid #000; font-size:13px; border-bottom:1px solid #000; color:#000; padding:5px 10px; font-weight:bold;">Comissões Recebidas</td>
														<td style="padding:5px 10px; color:#000; font-size:13px; border-bottom:1px solid #000;">R$ <?php echo number_format($totalComissaoCorretorR, 2, ",", ".");?></td>
													</tr>
<?php
					if($filtraCorretorSalario != "" && $dadosSalariosConfere['codSalario'] != "" || $filtraUsuarioComissoes != "" && $dadosSalariosConfere['codSalario'] != "" && $usuario == "C"){
?>
													<tr>
														<td style="border-right:1px solid #000; font-size:13px; border-bottom:1px solid #000; color:#000; padding:5px 10px; font-weight:bold;">Salário</td>
														<td style="padding:5px 10px; color:#000; font-size:13px; border-bottom:1px solid #000;">R$ <?php echo number_format($totalSalario, 2, ",", ".");?></td>
													</tr>
<?php
					}
?>
													<tr>
														<td style="border-right:1px solid #000; color:#FFF; padding:5px 10px; font-weight:bold; font-size:14px; background-color:#0000FF;">A Receber</td>
														<td style="padding:5px 20px; color:#FFF; font-size:14px; background-color:#0000FF;">R$ <?php echo number_format($totalComissaoCorretorA+$totalSalario, 2, ",", ".");?></td>
													</tr>
												</table>
											</div>
<?php
					}
?>
											<br class="clear"/>														

										</div>											
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<script type="text/javascript">
					function buscaAvancada(area){
						var $AGD = jQuery.noConflict();
						var buscaLote = $AGD("#buscaLote").val();
						buscaLote = buscaLote.replace(" ", "-");
						var buscaQuadra = $AGD("#buscaQuadra").val();
						buscaQuadra = buscaQuadra.replace(" ", "-");
						var buscaBairro = $AGD("#buscaBairro").val();
						buscaBairro = buscaBairro.replace(" ", "-");

						$AGD("#busca-carregada").load("<?php echo $configUrl;?>financeiro/comissoes/busca-comissao.php?buscaLote="+buscaLote+"&buscaQuadra="+buscaQuadra+"&buscaBairro="+buscaBairro);
						if(buscaLote == "" && buscaQuadra == "" && buscaBairro == ""){
							document.getElementById("paginacao").style.display="block";
						}else{
							document.getElementById("paginacao").style.display="none";
						}
					}
							
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

					function imprimeRecibo(id, pg, cod) {
						var printContents = document.getElementById(id).innerHTML;
						var originalContents = document.body.innerHTML;

						document.body.innerHTML = printContents;

						window.print();

						document.body.innerHTML = originalContents;
					}
				</script>				
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
?>
						<div id="busca-carregada">
							<form id="formComissao" action="<?php echo $configUrlGer;?>financeiro/comissoes/" method="post">
								<input type="hidden" value="OK" name="formComissao"/>
								<table class="tabela-menus" >
<?php									
				$sqlConta = "SELECT count(C.codComissao) registros, C.codComissao FROM comissoes C left join comissoesCorretores CC on C.codComissao = CC.codComissao left join usuarios U on CC.codUsuario = U.codUsuario WHERE C.codComissao != ''".$filtraData1.$filtraData2.$filtraCidade.$filtraBairro.$filtraQuadra.$filtraLote.$filtraComissao.$filtraPagamento.$filtraCorretor.$filtraUsuarioComissoes.$filtraTipoImovel." GROUP BY C.codComissao";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['codComissao'] != ""){
?>
									<tr class="titulo-tabela" border="none" style="background:none;">
										<th class="canto-esq" style="background:#275788; color:#FFF;">Idenficador</th>
										<th style="background:#275788; color:#FFF;">Tipo Comissão</th>
										<th style="background:#275788; color:#FFF;">Comissão / Custo</th>
										<th style="background:#275788; color:#FFF;" colspan="2">Corretor</th>
										<th style="background:#275788; color:#FFF;" colspan="3">Observação</th>
										<th style="background:#275788; color:#FFF;">Anexos</th>
										<th style="background:#275788; color:#FFF;">Pagamento</th>
										<th class="canto-dir" style="background:#275788; color:#FFF;">Excluir</th>
									</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlComissao = "SELECT C.* FROM comissoes C left join comissoesCorretores CC on C.codComissao = CC.codComissao left join usuarios U on CC.codUsuario = U.codUsuario WHERE C.codComissao != ''".$filtraData1.$filtraData2.$filtraCidade.$filtraBairro.$filtraQuadra.$filtraLote.$filtraComissao.$filtraPagamento.$filtraCorretor.$filtraUsuarioComissoes.$filtraTipoImovel." GROUP BY C.codComissao ORDER BY C.statusComissao ASC, C.dataComissao DESC, C.codAgrupadorComissao ASC, C.codComissao DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 60;
						$paginaInicial = $paginaFinal - 60;
						$sqlComissao = "SELECT C.* FROM comissoes C left join comissoesCorretores CC on C.codComissao = CC.codComissao left join usuarios U on CC.codUsuario = U.codUsuario WHERE C.codComissao != ''".$filtraData1.$filtraData2.$filtraCidade.$filtraBairro.$filtraQuadra.$filtraLote.$filtraComissao.$filtraPagamento.$filtraCorretor.$filtraUsuarioComissoes.$filtraTipoImovel." GROUP BY C.codComissao ORDER BY C.statusComissao ASC, C.dataComissao DESC, C.codAgrupadorComissao ASC, C.codComissao DESC LIMIT ".$paginaInicial.",60";
					}		

					$resultComissao = $conn->query($sqlComissao);
					while($dadosComissao = $resultComissao->fetch_assoc()){
						$mostrando++;

						$sqlCorretores = "SELECT * FROM comissoesCorretores WHERE codUsuario = 0 ORDER BY codComissaoCorretor ASC";
						$resultCorretores = $conn->query($sqlCorretores);
						while($dadosCorretores = $resultCorretores->fetch_assoc()){	
							
							$sqlDelete = "DELETE FROM comissoesCorretores WHERE codComissaoCorretor = ".$dadosCorretores['codComissaoCorretor']."";
							$resultDelete = $conn->query($sqlDelete);
							
						}
																	
						$sqlBairro = "SELECT * FROM bairros WHERE codBairro = ".$dadosComissao['codBairro']." LIMIT 0,1";
						$resultBairro = $conn->query($sqlBairro);
						$dadosBairro = $resultBairro->fetch_assoc();				
						
						$sqlQuadra = "SELECT * FROM quadras WHERE codQuadra = ".$dadosComissao['codQuadra']." LIMIT 0,1";
						$resultQuadra = $conn->query($sqlQuadra);
						$dadosQuadra = $resultQuadra->fetch_assoc();				
						
						$sqlLote = "SELECT * FROM lotes WHERE codLote = ".$dadosComissao['codLote']." LIMIT 0,1";
						$resultLote = $conn->query($sqlLote);
						$dadosLote = $resultLote->fetch_assoc();					

						if($dadosComissao['negociacaoComissao'] == "V"){
							if($dadosComissao['tipoImovelComissao'] == "P"){
								$background = "background:#60c6ff;";
								$corBolinha = "background-color:#60c6ff;";
								$corBola = "color:#60c6ff;";	
							}else{
								$background = "background:#4ee900;";
								$corBolinha = "background-color:#4ee900;";
								$corBola = "color:#4ee900;";
							}
						}else{
							$background = "background:#ff7070;";
							$corBolinha = "background-color:#ff7070;";
							$corBola = "color:#ff7070;";	
						}							
			
?>
									<tbody id="body<?php echo $dadosComissao['codAgrupadorComissao'];?>">
										<tr class="tr" style="height:30px; <?php echo $background;?>">
											<input type="hidden" value="<?php echo $dadosComissao['codAgrupadorComissao'];?>" id="agrupadorComissao<?php echo $dadosComissao['codComissao'];?>"/>
											<td class="vinte" style="width:5%; padding:0px;" colspan="1"><a style="font-size:14px; text-decoration:none;"><span style="font-weight:bold; font-size:14px;">Data:</span> <?php echo $dadosComissao['valorImovelComissao'] != "0.00" ? data($dadosComissao['dataComissao']) : '--';?></a></td>										
											<td class="vinte" style="width:10%; padding:0px;" colspan="1"><a style="font-size:14px; text-decoration:none;"><span style="font-weight:bold; font-size:14px;">Negociação:</span> <?php echo $dadosComissao['valorImovelComissao'] != "0.00" ? $dadosComissao['negociacaoComissao'] == "V" ? 'Venda' : 'Compra' : '--';?></a></td>										
											<td class="vinte" style="width:10%; padding:0px;" colspan="1"><a style="font-size:14px; text-decoration:none; display:table; margin:0 auto;"><input style="background: #ccc; cursor:pointer; color: #444444; border: none; padding: 3px 10px; font-size: 13px; border-radius: 5px; margin: 0 auto;" type="button" value="Alterar Comissão" onClick="alteraComissaoGeral(<?php echo $dadosComissao['codComissao'];?>, '<?php echo $dadosComissao['codContrato'];?>', '<?php echo $dadosComissao['dataComissao'];?>', '<?php echo number_format($dadosComissao['valorImovelComissao'], 2, ",", ".");?>', '<?php echo number_format($dadosComissao['imobiliariaComissao'], 2, ",", ".");?>', '<?php echo $dadosComissao['codCidade'];?>', '<?php echo $dadosComissao['codBairro'];?>', '<?php echo $dadosComissao['codQuadra'];?>', '<?php echo $dadosComissao['codLote'];?>');"/><input type="hidden" value="<?php echo $dadosComissao['codComissao'];?>" id="codComissaoAltera"/></a></td>										
											<td class="vinte" style="padding:0px;" colspan="2"><a style="font-size:14px; text-decoration:none;"><span style="font-weight:bold; font-size:14px;">Valor do Imóvel:</span> R$ <?php echo $dadosComissao['valorImovelComissao'] != "0.00" ? number_format($dadosComissao['valorImovelComissao'], 2, ",", ".") : '--';?></a></td>										
											<td class="vinte" style="padding:0px;" colspan="3"><a style="font-size:14px; text-decoration:none;"><span style="font-weight:bold; font-size:14px;">Loteamento:</span> <?php echo $dadosBairro['nomeBairro'];?></a></td>										
											<td class="vinte" style="width:5%; padding:0px;" colspan="1"><a style="font-size:14px; text-decoration:none;"><span style="font-weight:bold; font-size:14px;">Quadra:</span> <?php echo $dadosQuadra['nomeQuadra'];?></a></td>										
											<td class="vinte" style="width:5%; padding:0px;" colspan="1"><a style="font-size:14px; text-decoration:none;"><span style="font-weight:bold; font-size:14px;">Lote:</span> <?php echo $dadosLote['nomeLote'];?></a></td>										
<?php
						if($usuario == "A"){
							if($dadosComissao['valorImovelComissao'] != "0.00"){
?>
											<td class="vinte" style="width:5%; padding:0px;" colspan="1"><a style="font-size:14px; text-decoration:none; display:table; margin:0 auto;"><span style="font-weight:normal; font-size:12px; background-color:#FFF; border-radius:10px; padding:3px 10px; cursor:pointer;" onClick="adicionarImovel(<?php echo $dadosComissao['codAgrupadorComissao'];?>);">Ad + Imóvel</span></a></td>																				
<?php
							}else{
?>
											<td class="vinte" style="width:5%; padding:0px;" colspan="1"><a style="font-size:14px; text-decoration:none; display:table; margin:0 auto;"><span style="font-weight:normal; font-size:12px; background-color:#FFF; border-radius:10px; padding:3px 10px; cursor:pointer;" onClick='confirmaExclusao(<?php echo $dadosComissao['codComissao'] ?>, "loteamento <?php echo htmlspecialchars($dadosBairro['nomeBairro']);?>, quadra <?php echo $dadosQuadra['nomeQuadra'];?>, lote <?php echo $dadosLote['nomeLote'];?>");' title='Deseja excluir as comissões do loteamento <?php echo htmlspecialchars($dadosBairro['nomeBairro']);?>, quadra <?php echo $dadosQuadra['nomeQuadra'];?>, lote <?php echo $dadosLote['nomeLote'];?>?'>Excluir Lote</span></a></td>																												
<?php
							}
						}else{
?>
											<td class="vinte" style="width:5%; padding:0px; text-align:center;" colspan="1"><a style="font-size:14px; text-decoration:none;">--</a></td>										
<?php
						}
?>
										</tr>
<?php
						if($usuario == "A" && $dadosComissao['valorImovelComissao'] != "0.00"){
?>
										<tr class="tr" style="height:20px;">
											<td class="vinte" style="width:7%; min-width:120px; padding:0px; position:relative;"><span style="position:absolute; opacity:0.5; left:10px; top:10px; cursor:pointer;" onCLick="recebeComissao(<?php echo $dadosComissao['codComissao'];?>);"><img src="<?php echo $configUrlGer;?>f/i/dinheiro.svg" width="30"/></span><a style="padding:0px; text-decoration:none;"><span style="width:45px; height:45px; display:block; margin:0 auto; <?php echo $corBolinha;?> border-radius:100%; color:#FFF; position:relative;"><span style="position:absolute; top:50%; font-size:20px; left:50%; font-family:Impact; transform:translate(-50%, -50%);"><?php echo $dadosComissao['codAgrupadorComissao'];?></span></span></a></td>
											<td class="vinte" style="width:10%; padding:0px;"><a style="text-decoration:none;" >Imobiliária</a></td>
											<td class="vinte" style="width:10%; padding:0px; <?php echo $dadosComissao['pagamentoComissao'] == "T" ? 'background-color:#0000FF;' : '';?>" id="valor-comissao<?php echo $dadosComissao['codComissao'];?>"><a id="valor-comissao-a<?php echo $dadosComissao['codComissao'];?>" style="text-decoration:none; <?php echo $dadosComissao['pagamentoComissao'] == "T" ? 'color:#FFF;' : '';?>" >R$ <?php echo number_format($dadosComissao['imobiliariaComissao'], 2, ",", ".");?></a></td>
											<td class="vinte" style="width:20%; padding:0px;" colspan="2"><a style="display:block; text-decoration:none;">Markan Imóveis</a></td>
											<td class="vinte" style="width:20%; padding:0px;" colspan="3"><a style="display:block; text-decoration:none;"><?php echo $dadosComissao['obsImobiliariaComissao'];?></a></td>
											<td class="dez" style="width:6%; min-width:105px; padding:0px; text-align:center;"><a style="padding:0px; display:table; margin:0 auto;"><span style="font-weight:normal; font-size:12px; background-color:#275788; border-radius:10px; color:#FFF; padding:3px 10px; cursor:pointer;" onClick="cadastraAltera(<?php echo $dadosComissao['codComissao'];?>, 0);">Ad + Comissão</span></a></td>
<?php
							if($dadosComissao['negociacaoComissao'] == "C"){
?>
											<td class="dez" style="width:5%; padding:0px; text-align:center;"><a>--</a></td>
<?php
							}else{
?>
											<td class="botoes">
<?php
								if($dadosComissao['statusComissao'] == "T"){
?>		
												<input type="button" onClick="recebeComissaoContas(<?php echo $dadosComissao['codComissao'];?>, '<?php echo $dadosBairro['nomeBairro'];?>, Quadra: <?php echo $dadosQuadra['nomeQuadra'];?>, Lote: <?php echo $dadosLote['nomeLote'];?>', '<?php echo $dadosComissao['imobiliariaComissao'];?>');" value="" style="width:50px; height:42px; border:none; outline:none; cursor:pointer; background:transparent url('<?php echo $configUrl; ?>f/i/pagar-dinheiro.svg') center center no-repeat; background-size:40px;" alt="icone">
<?php	
								}else{
?>	
												<input type="button" value="" style="width:50px; height:42px; filter: grayscale(100%); border:none; outline:none; background:transparent url('<?php echo $configUrl; ?>f/i/pagar-dinheiro.svg') center center no-repeat; background-size:40px;" alt="icone"><a style="font-size:13px; text-decoration:underline;" href="<?php echo $configUrlGer;?>financeiro/comissoes/estornar-comissao/<?php echo $dadosComissao['codComissao'];?>/">Estornar</a>
<?php
								}
?>
											</td>
<?php
							}
?>
											<td class="botoes" style="width:6%; min-width:88px; padding:0px;"><a href='javascript: confirmaExclusao(<?php echo $dadosComissao['codComissao'] ?>, "loteamento <?php echo htmlspecialchars($dadosBairro['nomeBairro']);?>, quadra <?php echo $dadosQuadra['nomeQuadra'];?>, lote <?php echo $dadosLote['nomeLote'];?>");' title='Deseja excluir as comissões do loteamento <?php echo htmlspecialchars($dadosBairro['nomeBairro']);?>, quadra <?php echo $dadosQuadra['nomeQuadra'];?>, lote <?php echo $dadosLote['nomeLote'];?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone" height="50"></a></td>
										</tr>
<?php
						}
						
						$linha = "";
						
						$sqlCorretores = "SELECT * FROM comissoesCorretores CC inner join usuarios U on CC.codUsuario = U.codUsuario WHERE CC.codComissao = ".$dadosComissao['codComissao']."".$filtraCorretor.$filtraUsuarioComissoes." GROUP BY CC.codComissaoCorretor ORDER BY CC.linhaComissaoCorretor ASC, CC.codComissaoCorretor ASC";
						$resultCorretores = $conn->query($sqlCorretores);
						while($dadosCorretores = $resultCorretores->fetch_assoc()){

							if($dadosCorretores['statusComissaoCorretor'] == "T"){
								$status = "status-ativo";
								$statusIcone = "ativado";
								$statusPergunta = "desativar";
							}else{
								$status = "status-desativado";
								$statusIcone = "desativado";
								$statusPergunta = "ativar";
							}
						
							$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosCorretores['codUsuario']." ORDER BY codUsuario ASC LIMIT 0,1";
							$resultUsuario = $conn->query($sqlUsuario);
							$dadosUsuario = $resultUsuario->fetch_assoc();
														
							if($dadosCorretores['linhaComissaoCorretor'] == "IN"){
								$linha = "Indicação";
							}else
							if($dadosCorretores['linhaComissaoCorretor'] == "CV"){
								$linha = "Corretor Venda";
							}else
							if($dadosCorretores['linhaComissaoCorretor'] == "CA"){
								$linha = "Corretor Agenciamento";
							}
?>									
										<tr class="tr" style="height:20px;" id="linhaComissao<?php echo $dadosComissao['codComissao'].$dadosCorretores['codComissaoCorretor'];?>">
<?php
							if($usuario == "A"){
?>
											<td class="vinte" style="width:7%; padding:0px; position:relative;"><a style="padding:0px; text-decoration:none; position:relative; display:block;"><span style="width:45px; height:45px; display:block; margin:0 auto; border-radius:100%; <?php echo $corBola;?> position:relative; border:1px solid #ccc;"><span style="position:absolute; top:50%; font-size:20px; left:50%; font-family:Impact; transform:translate(-50%, -50%);"><?php echo $dadosComissao['codAgrupadorComissao'];?></span></span><span style="position:absolute; top:10px; left:10px; opacity:0.1; cursor:pointer;" onMouseover="mouseIn(<?php echo $dadosCorretores['codComissaoCorretor'];?>);" onMouseout="mouseOut(<?php echo $dadosCorretores['codComissaoCorretor'];?>);" id="editar<?php echo $dadosCorretores['codComissaoCorretor'];?>" onClick="cadastraAltera(<?php echo $dadosComissao['codComissao'];?>, <?php echo $dadosCorretores['codComissaoCorretor'];?>);"><img src="<?php echo $configUrlGer;?>f/i/icone-editar.svg" width="25"/></span></a></td>
<?php
							}else{
?>
											<td class="vinte" style="width:7%; padding:0px; position:relative;"><a style="padding:0px; text-decoration:none; position:relative; display:block;"><span style="width:45px; height:45px; display:block; margin:0 auto; border-radius:100%; <?php echo $corBola;?> position:relative; border:1px solid #ccc;"><span style="position:absolute; top:50%; font-size:20px; left:50%; font-family:Impact; transform:translate(-50%, -50%);"><?php echo $dadosComissao['codAgrupadorComissao'];?></span></span></a></td>
<?php
							}
?>
											<td class="vinte" style="width:10%; padding:0px;"><a style="text-decoration:none;"><?php echo $linha;?></a></td>
											<td class="vinte" style="width:10%; padding:0px; <?php echo $dadosComissao['pagamentoComissao'] == "T" && $usuario != "A" && $dadosUsuario['codUsuario'] == $_COOKIE['codAprovado'.$cookie] ? 'background-color:#0000FF;' : '';?>"><a style="text-decoration:none; <?php echo $dadosComissao['pagamentoComissao'] == "T" && $usuario != "A" && $dadosUsuario['codUsuario'] == $_COOKIE['codAprovado'.$cookie] ? 'color:#FFF;' : '';?>">R$ <?php echo number_format($dadosCorretores['valorComissaoCorretor'], 2, ",", ".");?></a></td>
											<td class="vinte" style="width:20%; padding:0px;" colspan="2"><a style="display:block; text-decoration:none;"><?php echo $dadosUsuario['nomeUsuario'];?></a></td>
											<td class="vinte" style="width:20%; padding:0px;" colspan="3"><a style="display:block; text-decoration:none;"><?php echo $dadosCorretores['obsComissaoCorretor'];?></a></td>
											<td class="botoes" style="width:5%; padding:0px;"><a href='<?php echo $configUrl; ?>financeiro/comissoes/gerenciar-documentos/<?php echo $dadosComissao['codAgrupadorComissao'] ?>/' title='Deseja cadastrar anexo para a comissão do corretor <?php echo $dadosCorretor['nomeUsuario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone" height="50"/></a></td>
<?php
							if($usuario == "A"){
?>
											<td class="botoes">
<?php
						if($dadosCorretores['statusComissaoCorretor'] == "T"){
?>		
												<input type="button" onClick="pagaCorretor(<?php echo $dadosCorretores['codComissaoCorretor'];?>, '<?php echo $dadosUsuario['nomeUsuario'];?>', '<?php echo $dadosCorretores['valorComissaoCorretor'];?>');" value="" style="width:50px; height:42px; border:none; outline:none; cursor:pointer; background:transparent url('<?php echo $configUrl; ?>f/i/pagar-dinheiro.svg') center center no-repeat; background-size:40px;" alt="icone">
<?php
						}else{
?>	
												<input type="button" value="" style="width:50px; height:42px; filter: grayscale(100%); border:none; outline:none; background:transparent url('<?php echo $configUrl; ?>f/i/pagar-dinheiro.svg') center center no-repeat; background-size:40px;" alt="icone"><a style="font-size:13px; text-decoration:underline;" href="<?php echo $configUrlGer;?>financeiro/comissoes/estornar/<?php echo $dadosCorretores['codComissaoCorretor'];?>/">Estornar</a>
<?php
						}
?>
											</td>
											<td class="botoes" style="width:5%; padding:0px;"><a href='javascript: confirmaExclusaoCorretor(<?php echo $dadosCorretores['codComissaoCorretor'] ?>, "<?php echo htmlspecialchars($dadosUsuario['nomeUsuario']) ?>");' title='Deseja excluir a comissão do corretor <?php echo $dadosUsuario['nomeUsuario'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone" height="50"></a></td>
<?php
							}else{
?>										
											<td class="botoes">
<?php
						if($dadosCorretores['statusComissaoCorretor'] == "T"){
?>
												<input type="button" value="" style="width:50px; height:42px; border:none; outline:none; cursor:pointer; background:transparent url('<?php echo $configUrl; ?>f/i/pagar-dinheiro.svg') center center no-repeat; background-size:40px;" alt="icone">
<?php
						}else{
?>	
												<input type="button" value="" style="width:50px; height:42px; filter: grayscale(100%); border:none; outline:none; background:transparent url('<?php echo $configUrl; ?>f/i/pagar-dinheiro.svg') center center no-repeat; background-size:40px;" alt="icone">
<?php
						}
?>
											</td>
											<td class="dez" style="width:5%; padding:0px; text-align:center;"><a>--</a></td>
<?php
							}
?>
										</tr>
<?php						
						}
?>
									</tbody>
<?php
						if($linha != ""){
?>									
									<tr border="none" style="height:40px; background-color:#FFF;">
										<th colspan="10"></th>
									</tr>										
<?php						
						}
					}
				}
?>					
								</table>
								<br/>
								<br/>
							</form>		
							<form id="formPaga" action="<?php echo $configUrlGer;?>financeiro/contas-pagar/" method="post">
								<input type="hidden" value="" name="codComissaoCorretor" id="codComissaoCorretor"/>
								<input type="hidden" value="" name="nomeComissao" id="nomeComissao"/>
								<input type="hidden" value="" name="valorComissao" id="valorComissao"/>							
							</form>
							<form id="formRecebe" action="<?php echo $configUrlGer;?>financeiro/contas-receber/" method="post">
								<input type="hidden" value="" name="codComissaoRecebe" id="codComissaoRecebe"/>
								<input type="hidden" value="Comissão Imobiliária" name="tipoPagamento" id="tipoPagamento"/>
								<input type="hidden" value="" name="nomeComissaoRecebe" id="nomeComissaoRecebe"/>
								<input type="hidden" value="" name="valorComissaoRecebe" id="valorComissaoRecebe"/>							
							</form>
							<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
							<script type="text/javascript">
								function alteraComissaoGeral(codComissao, contratoAtual, dataAtual, valorImovelAtual, valorComissaoAtual, cidadeAtual, bairroAtual, quadraAtual, loteAtual) {
									Swal.fire({
										title: 'Alterar Comissão',
										html:
											'<div style="display: flex; flex-wrap: wrap; gap: 15px 2%; justify-content: space-between;">' +
												// Adicionado select de Contrato, seguindo @file_context_0
												'<div style="width: 100%;">' +
													'<label style="float:left; padding-bottom:5px;">Contrato:</label>' +
													'<span style="font-size:13px; position:absolute; color:#666; left:105px; top:69px;">Para imóveis próprios selecione o contrato!</span>' +
													'<select class="campo swal2-input" id="swal-input-contrato" name="cod-contrato" style="width: 100%; outline:none; background:#FFF;">' +
														'<option value="">Selecione</option>' +
<?php
				$sqlContratos = "SELECT * FROM contratos C inner join clientes CL on C.codCliente = CL.codCliente ORDER BY C.dataContrato DESC";
				$resultContratos = $conn->query($sqlContratos);
				while($dadosContratos = $resultContratos->fetch_assoc()){
?>
														'<optgroup label="Contrato #<?php echo $dadosContratos['codContrato'];?> - <?php echo addslashes($dadosContratos['nomeCliente']);?>">' +
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
															'<option value="<?php echo trim($dadosContratos['codContrato']);?>" ' + ("<?php echo $dadosContratos['codContrato']; ?>" == (typeof contratoAtual !== "undefined" ? contratoAtual : "") ? "selected" : "") + '><?php echo addslashes($lotes);?> - <?php echo data($dadosContratos['dataContrato']);?> - R$ <?php echo number_format($dadosContratos['valorContrato'], 2, ",", ".");?></option>' +
														'</optgroup>' +
<?php
				}
?>
													'</select>' +
												'</div>' +

												'<div style="width:100%;">' +
													'<label style="float:left; padding-bottom:5px;">Data:</label>' +
													'<input id="swal-input-data" class="swal2-input" style="width:-webkit-fill-available; margin:0 auto;" type="date" value="' + dataAtual + '">' +
												'</div>' +
												'<div style="flex:1 1 47%;">' +
													'<label style="float:left;">Valor do Imóvel:</label>' +
													'<input id="swal-input-valorImovel" class="swal2-input" style="width:-webkit-fill-available; margin:0 auto;" type="text" value="' + (valorImovelAtual !== undefined && valorImovelAtual !== null ? valorImovelAtual : "") + '" placeholder="Valor Imóvel" onkeyup="moeda(this)">' +
												'</div>' +

												'<div style="flex:1 1 47%;">' +
													'<label style="float:left;">Valor da Comissão:</label>' +
													'<input id="swal-input-valorComissao" class="swal2-input" style="width:-webkit-fill-available; margin:0 auto;" type="text" value="' + (valorComissaoAtual !== undefined && valorComissaoAtual !== null ? valorComissaoAtual : "") + '" placeholder="Valor Comissão" onkeyup="moeda(this)">' +
												'</div>' +

												'<div style="flex:1 1 47%; text-align:left; margin-bottom:5px; font-family:Arial,sans-serif;">' +
													'<label class="label" style="font-weight:bold;">Cidade: <span class="obrigatorio" style="color:#E74C3C;"> * </span></label>' +
													'<select class="campo" id="swal-input-cidade" name="cidades" style="width: 100%; padding:7px 8px; background:#FFF; border:1px solid #ced4da; border-radius:4px; margin-top:3px; color: #444; font-size: 16px;" required onChange="filtraBairroPorCidade(this.value);">' +
														'<option value="">Selecione</option>' +
<?php
				$sqlCidade = "SELECT nomeCidade, codCidade FROM cidades WHERE statusCidade = 'T' ORDER BY nomeCidade ASC";
				$resultCidade = $conn->query($sqlCidade);
				while($dadosCidade = $resultCidade->fetch_assoc()){
?>
														'<option value="<?php echo $dadosCidade['codCidade']; ?>" ' + ('<?php echo $dadosCidade['codCidade']; ?>' == cidadeAtual ? "selected" : "") + '><?php echo $dadosCidade['nomeCidade']; ?></option>' +
<?php
				}
?>
													'</select>' +
												'</div>' +

												'<div style="flex:1 1 47%; text-align:left; margin-bottom:5px; font-family:Arial,sans-serif;">' +
													'<label class="label" style="font-weight:bold;">Loteamento: <span class="obrigatorio" style="color:#E74C3C;"> * </span></label>' +
													'<select class="campo" id="swal-input-loteamento" name="bairro" style="width: 100%; padding:7px 8px; background:#FFF; border:1px solid #ced4da; border-radius:4px; margin-top:3px; color: #444; font-size: 16px;" required>' +
														'<option value="">Selecione</option>' +
<?php
				$sqlBairro = "SELECT nomeBairro, codBairro, codCidade FROM bairros WHERE statusBairro = 'T' ORDER BY nomeBairro ASC";
				$resultBairro = $conn->query($sqlBairro);
				while($dadosBairro = $resultBairro->fetch_assoc()){
?>
														'<option value="<?php echo $dadosBairro['codBairro']; ?>" data-cidade="<?php echo $dadosBairro['codCidade']; ?>" ' + (
															('<?php echo $dadosBairro['codCidade']; ?>' == cidadeAtual) 
															? (('<?php echo $dadosBairro['codBairro']; ?>' == bairroAtual) ? 'selected ' : '') + 'style="display:block;"' 
															: 'style="display:none;"'
														) + '><?php echo addslashes($dadosBairro['nomeBairro']); ?></option>' +
<?php
				}
?>
													'</select>' +
												'</div>' +

												'<div style="flex:1 1 47%; text-align:left; margin-bottom:5px; font-family:Arial,sans-serif;">' +
													'<label class="label" style="font-weight:bold;">Quadra: <span class="obrigatorio" style="color:#E74C3C;"> * </span></label>' +
													'<select class="campo" id="swal-input-quadra" name="quadras" style="width: 100%; padding:7px 8px; background:#FFF; border:1px solid #ced4da; border-radius:4px; margin-top:3px; color: #444; font-size: 16px;" required>' +
														'<option value="">Selecione</option>' +
<?php
				$sqlQuadra = "SELECT nomeQuadra, codQuadra FROM quadras ORDER BY nomeQuadra ASC";
				$resultQuadra = $conn->query($sqlQuadra);
				while($dadosQuadra = $resultQuadra->fetch_assoc()){
?>
														'<option value="<?php echo $dadosQuadra['codQuadra']; ?>" ' + (quadraAtual == '<?php echo $dadosQuadra['codQuadra']; ?>' ? 'selected' : '') + '><?php echo $dadosQuadra['nomeQuadra']; ?></option>' +
<?php
				}
?>
													'</select>' +
												'</div>' +
												
												'<div style="flex:1 1 47%; text-align:left; margin-bottom:5px; font-family:Arial,sans-serif;">' +
													'<label class="label" style="font-weight:bold;">Lote: <span class="obrigatorio" style="color:#E74C3C;"> * </span></label>' +
													'<select class="campo" id="swal-input-lote" name="lotes" style="width: 100%; padding:7px 8px; background:#FFF; border:1px solid #ced4da; border-radius:4px; margin-top:3px; color: #444; font-size: 16px;" required>' +
														'<option value="">Selecione</option>' +
<?php
				$sqlLote = "SELECT nomeLote, codLote FROM lotes ORDER BY nomeLote ASC";
				$resultLote = $conn->query($sqlLote);
				while($dadosLote = $resultLote->fetch_assoc()){
?>
														'<option value="<?php echo $dadosLote['codLote']; ?>" ' + (loteAtual == '<?php echo $dadosLote['codLote']; ?>' ? 'selected' : '') + '><?php echo $dadosLote['nomeLote']; ?></option>' +
<?php
				}
?>
													'</select>' +
												'</div>' +
											'</div>',
										focusConfirm: false,
										showCancelButton: true,
										confirmButtonText: 'Salvar',
										cancelButtonText: 'Cancelar',
										preConfirm: () => {
											return {
												contrato: document.getElementById('swal-input-contrato').value,
												data: document.getElementById('swal-input-data').value,
												valorImovel: document.getElementById('swal-input-valorImovel').value,
												valorComissao: document.getElementById('swal-input-valorComissao').value,
												cidade: document.getElementById('swal-input-cidade').value,
												bairro: document.getElementById('swal-input-loteamento').value,
												quadra: document.getElementById('swal-input-quadra').value,
												lote: document.getElementById('swal-input-lote').value,
											};
										}
									}).then((result) => {
										if (result.isConfirmed) {
											var $ac = jQuery.noConflict();
											$ac.post("<?php echo $configUrlGer;?>financeiro/comissoes/altera-comissao-geral.php", {
												codComissao: codComissao,
												contrato: result.value.contrato,
												data: result.value.data,
												valorImovel: result.value.valorImovel,
												valorComissao: result.value.valorComissao,
												cidade: result.value.cidade,
												bairro: result.value.bairro,
												quadra: result.value.quadra,
												lote: result.value.lote
											}, function(response){
												if(response.trim() === "ok"){
													Swal.fire('Alterado!','Comissão atualizada com sucesso!','success').then(()=>{
														location.reload();
													});
												}else{
													Swal.fire('Erro!','Falha ao atualizar a comissão.','error');
												}
											});
										}
									});
								}
							</script>
							<script>
								function filtraBairroPorCidade(cidadeId) {
									const bairroSelect = document.getElementById('swal-input-loteamento');
									const options = bairroSelect.querySelectorAll('option[data-cidade]');
									bairroSelect.value = "";
									options.forEach(opt => {
										if (cidadeId && opt.getAttribute('data-cidade') === cidadeId) {
											opt.style.display = '';
										} else {
											opt.style.display = 'none';
										}
									});
								}
								// Ao abrir o modal, se já há cidade preenchida, filtra os bairros corretamente:
								setTimeout(function() {
									try {
										const selCidade = document.getElementById('swal-input-cidade');
										if(selCidade && selCidade.value) {
											filtraBairroPorCidade(selCidade.value);
											const bairroSelect = document.getElementById('swal-input-loteamento');
											const selected = bairroSelect.getAttribute("data-selected");
											if(selected) bairroSelect.value = selected;
										}
									} catch(e){}
								}, 200);
							</script>							
							<script type="text/javascript">
								function recebeComissaoContas(cod, nome, valor){
									document.getElementById("codComissaoRecebe").value=cod;
									document.getElementById("nomeComissaoRecebe").value=nome;
									document.getElementById("valorComissaoRecebe").value=valor;
									document.getElementById("formRecebe").submit();
								}
								
								function pagaCorretor(cod, nome, valor){
									document.getElementById("codComissaoCorretor").value=cod;
									document.getElementById("nomeComissao").value=nome;
									document.getElementById("valorComissao").value=valor;
									document.getElementById("formPaga").submit();
								}
							</script>
								<script>
									function recebeComissao(codComissao){
										var $hg = jQuery.noConflict();
										$hg.post("<?php echo $configUrlGer;?>financeiro/comissoes/recebe-comissao.php", {codComissao: codComissao}, function(data){		
											if(data.trim() == "T"){
												$hg("#valor-comissao"+codComissao).css("background", "#0000FF");
												$hg("#valor-comissao-a"+codComissao).css("color", "#FFF");
											}else{
												$hg("#valor-comissao"+codComissao).css("background", "none");
												$hg("#valor-comissao-a"+codComissao).css("color", "#31625E");												
											}
										});	
									}
									
									function cadastraAltera(codComissao, codComissaoCorretor){
										var $rts = jQuery.noConflict();
										var codAgrupador = document.getElementById("agrupadorComissao"+codComissao).value;
										$rts.post("<?php echo $configUrlGer;?>financeiro/comissoes/adiciona-comissao.php", {codComissao: codComissao, codComissaoCorretor: codComissaoCorretor}, function(data){		
											if(data.trim() != "erro"){
												if(codComissaoCorretor == 0){
													document.getElementById("body"+codAgrupador).insertAdjacentHTML('beforeend', data);
												}else{
													$rts("#linhaComissao"+codComissao+codComissaoCorretor).fadeIn(250);
													$rts("#linhaComissao"+codComissao+codComissaoCorretor).html(data);
												}
											}else{
												alert("Erro ao Adicionar / Alterar Comissão");
											}
										});	
									}
									
									function alteraComissao(codComissao, codComissaoCorretor){
										var $rtsg = jQuery.noConflict();
										var tipoAltera = document.getElementById("tipoAltera"+codComissaoCorretor).value;
										var comissaoAltera = document.getElementById("comissaoAltera"+codComissaoCorretor).value;
										var corretorAltera = document.getElementById("corretorAltera"+codComissaoCorretor).value;
										var observacaoAltera = document.getElementById("observacaoAltera"+codComissaoCorretor).value;
										$rtsg.post("<?php echo $configUrlGer;?>financeiro/comissoes/altera-comissao.php", {codComissao: codComissao, codComissaoCorretor: codComissaoCorretor, tipoAltera: tipoAltera, comissaoAltera: comissaoAltera, corretorAltera: corretorAltera, observacaoAltera: observacaoAltera}, function(data){		
											if(data.trim() != "erro"){
												$rtsg("#linhaComissao"+codComissao+codComissaoCorretor).fadeIn(250);
												$rtsg("#linhaComissao"+codComissao+codComissaoCorretor).html(data);
											}else{
												alert("Erro ao Alterar Comissão");
											}
										});	
									}
																		
									function confirmaExclusaoCorretor(cod, nome){
										if(confirm("Deseja excluir a comissão do corretor "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>financeiro/comissoes/excluir-corretor/'+cod+'/';
										}
									}
																		
									function confirmaExclusaoSalario(cod, nome){
										if(confirm("Deseja excluir o salário do funcionário "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>financeiro/comissoes/excluir-salario/'+cod+'/';
										}
									}
									
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir as comissões do "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>financeiro/comissoes/excluir/'+cod+'/';
										}
									}
								
									function ativacao(cod, pergunta, codAgrupadorComissao){
										var $rt = jQuery.noConflict();
										var status = document.getElementById("status"+cod).value;
										if(confirm("Deseja "+pergunta+" essa comissão ?")){
											$rt.post("<?php echo $configUrlGer;?>financeiro/comissoes/ativacao.php", {codComissaoCorretor: cod}, function(data){		
												if(status == "T"){
													document.getElementById("status"+cod).value="F";
													document.getElementById("imgStatus"+cod).src="<?php echo $configUrl; ?>f/i/default/corpo-default/status-desativado.gif";
												}else{
													document.getElementById("status"+cod).value="T";
													document.getElementById("imgStatus"+cod).src="<?php echo $configUrl; ?>f/i/default/corpo-default/status-ativo.gif";												
												}
												
											});	
										}										

									}
								
									function ativacaoSalario(cod, pergunta){
										var $rts = jQuery.noConflict();
										var status = document.getElementById("statusSalario"+cod).value;
										if(confirm("Deseja "+pergunta+" esse salário ?")){
											$rts.post("<?php echo $configUrlGer;?>financeiro/comissoes/ativacao-salario.php", {codSalario: cod}, function(data){		
												if(status == "T"){
													document.getElementById("statusSalario"+cod).value="F";
													document.getElementById("imgStatusSalario"+cod).src="<?php echo $configUrl; ?>f/i/default/corpo-default/status-desativado.gif";
												}else{
													document.getElementById("statusSalario"+cod).value="T";
													document.getElementById("imgStatusSalario"+cod).src="<?php echo $configUrl; ?>f/i/default/corpo-default/status-ativo.gif";												
												}
												
											});	
										}										

									}
									
									function enviaForm(cod){
										document.getElementById("formComissao"+cod).submit();
									}	
									
									function adicionarImovel(codAgrupador){
										document.getElementById("codAgrupadorComissao").value=codAgrupador;
										document.getElementById("formImovel").submit();
									}			
									
									function mouseIn(cod){
										var $tg = jQuery.noConflict();
										$tg("#editar"+cod).css("opacity", "0.5");
									}	
													
									function mouseOut(cod){
										var $tgs = jQuery.noConflict();
										$tgs("#editar"+cod).css("opacity", "0.1");
									}					
								</script>
								<form id="formImovel" action="<?php echo $configUrlGer;?>financeiro/comissoes/" method="post">
									<input type="hidden" value="" id="codAgrupadorComissao" name="codAgrupadorComissao"/>
								</form> 
								<div id="total" style="padding:30px; background-color:#f5f5f5; margin-top:20px;">
<?php
					if($usuario == "A"){
?>					
									<div style="float:right;">
										<p class="total" style="font-size:15px; text-align:center; font-weight:bold; color:#FFF; border:1px solid #000; background-color:#000; padding:5px 15px; border-bottom:none;">Comissões Corretores</p>
										<table style="border:1px solid #444;">
											<tr>
												<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 20px; font-weight:bold;">Total em Vendas</td>
												<td style="padding:5px 20px; color:#000; border-bottom:1px solid #000;">R$ <?php echo number_format($totalImoveisVenda, 2, ",", ".");?></td>
											</tr>
											<tr>
												<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 20px; font-weight:bold; font-size:18px;">Total de Comissões</td>
												<td style="padding:5px 20px; color:#000; border-bottom:1px solid #000; font-size:18px;">R$ <?php echo number_format($totalAComissaoCorretor, 2, ",", ".");?></td>
											</tr>
											<tr>
												<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 20px; font-weight:bold;">Comissões Pagas</td>
												<td style="padding:5px 20px; color:#000; border-bottom:1px solid #000;">R$ <?php echo number_format($totalAComissaoCorretorR, 2, ",", ".");?></td>
											</tr>
											<tr>
												<td style="border-right:1px solid #000; color:#FFF; padding:5px 20px; background-color:#FF0000; font-weight:bold; font-size:18px;">A Pagar</td>
												<td style="padding:5px 20px; color:#FFF; font-size:18px; background-color:#FF0000;">R$ <?php echo number_format($totalAComissaoCorretorA+$totalSalario, 2, ",", ".");?></td>
											</tr>
										</table>
									</div>
<?php
					}else{
?>
									<div style="float:right;">
										<p class="total" style="font-size:15px; text-align:center; font-weight:bold; color:#FFF; border:1px solid #000; background-color:#000; padding:5px 15px; border-bottom:none;">Suas Comissões</p>
										<table style="border:1px solid #444;">
											<tr>
												<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 20px; font-weight:bold;">Total em Vendas</td>
												<td style="padding:5px 20px; color:#000; border-bottom:1px solid #000;">R$ <?php echo number_format($totalImoveisVenda, 2, ",", ".");?></td>
											</tr>
											<tr>
												<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 20px; font-weight:bold; font-size:18px;">Total de Comissões</td>
												<td style="padding:5px 20px; color:#000; border-bottom:1px solid #000; font-size:18px;">R$ <?php echo number_format($totalComissaoCorretor, 2, ",", ".");?></td>
											</tr>
											<tr>
												<td style="border-right:1px solid #000; border-bottom:1px solid #000; color:#000; padding:5px 20px; font-weight:bold;">Comissões Recebidas</td>
												<td style="padding:5px 20px; color:#000; border-bottom:1px solid #000;">R$ <?php echo number_format($totalComissaoCorretorR, 2, ",", ".");?></td>
											</tr>
											<tr>
												<td style="border-right:1px solid #000; color:#FFF; padding:5px 20px; font-weight:bold; font-size:18px; background-color:#0000FF;">A Receber</td>
												<td style="padding:5px 20px; color:#FFF; font-size:18px; background-color:#0000FF;">R$ <?php echo number_format($totalComissaoCorretorA+$totalSalario, 2, ",", ".");?></td>
											</tr>
										</table>
									</div>
<?php
					}
?>
									<br class="clear"/>														
								</div>														
						</div>
<?php				
				$regPorPagina = 60;
				$area = "financeiro/comissoes";
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
?>
<?php
		}else{
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."controle-acesso.php'>";
		}

	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login.php'>";
	}
?>
