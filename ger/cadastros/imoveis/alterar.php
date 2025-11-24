<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "imoveisS";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeImovel = "SELECT * FROM imoveis WHERE codImovel = '".$url[6]."' LIMIT 0,1";
				$resultNomeImovel = $conn->query($sqlNomeImovel);
				$dadosNomeImovel = $resultNomeImovel->fetch_assoc();
?>

				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Imóveis</p>
						<p class="flexa"></p>
						<p class="nome-lista">Imóveis</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeImovel['nomeImovel'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php	
				if($dadosNomeImovel['statusImovel'] == "T"){
					$statusImovel = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$statusImovel = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}	

				if($_COOKIE['codAprovado'.$cookie] == $dadosNomeImovel['codUsuario'] || $filtraUsuario == ""){
					
?>	
						<tr class="tr-interno">
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/imoveis/ativacao/<?php echo $dadosNomeImovel['codImovel'] ?>/' title='Deseja <?php echo $statusPergunta ?> o imóvel <?php echo $dadosNomeImovel['nomeImovel'];?> ?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $statusImovel ?>-branco.gif" alt="icone" /></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeImovel['codImovel'] ?>, "<?php echo htmlspecialchars($dadosNomeImovel['nomeImovel']) ?>");' title='Deseja excluir o imóvel <?php echo $dadosNomeImovel['nomeImovel'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
<?php
				}
?>
							<script>
									function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir o imóvel "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>cadastros/imoveis/excluir/'+cod+'/';
								}
							}
						 </script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Imóveis" href="<?php echo $configUrl;?>cadastros/imoveis/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if($_POST['nome'] != ""){
							
					include ('f/conf/criaUrl.php');
					$urlImovel = criaUrl($_POST['nome']);																						

					$sqlProprietario = "SELECT codProprietario FROM proprietarios WHERE nomeProprietario = '".$_POST['proprietarios']."' LIMIT 0,1";
					$resultProprietario = $conn->query($sqlProprietario);
					$dadosProprietario = $resultProprietario->fetch_assoc();
					
					if($dadosProprietario['codProprietario'] != ""){

						$sqlCodigo = "SELECT codigoImovel FROM imoveis WHERE codigoImovel = '".$_POST['codigo']."' and codImovel != ".$url[6]." LIMIT 0,1";
						$resultCodigo = $conn->query($sqlCodigo);
						$dadosCodigo = $resultCodigo->fetch_assoc();
						
						if($dadosCodigo['codigoImovel'] == ""){
							
							$preco = $_POST['preco'];	
							$preco = str_replace(".", "", $preco);	
							$preco = str_replace(".", "", $preco);	
							$preco = str_replace(",", ".", $preco);	

							$precoC = $_POST['precoC'];	
							$precoC = str_replace(".", "", $precoC);	
							$precoC = str_replace(".", "", $precoC);	
							$precoC = str_replace(",", ".", $precoC);	

							$descricao = str_replace("../../../../", $configUrlGer, $_POST['descricao']);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
							$descricao = str_replace("../../../../", $configUrlGer, $descricao);
													
							if($precoC == ""){
								$precoC = "0.00";
							}else{
								$precoC = $precoC;
							}						
							if($preco == ""){
								$preco = "0.00";
							}else{
								$preco = $preco;
							}						
							if($_POST['quartos'] == ""){
								$quartos = 0;
							}else{
								$quartos = $_POST['quartos'];
							}						
							if($_POST['suite'] == ""){
								$suite = 0;
							}else{
								$suite = $_POST['suite'];
							}						
							if($_POST['banheiros'] == ""){
								$banheiros = 0;
							}else{
								$banheiros = $_POST['banheiros'];
							}						
							if($_POST['garagem'] == ""){
								$garagem = 0;
							}else{
								$garagem = $_POST['garagem'];
							}						
							if($_POST['metragem'] == ""){
								$metragem = 0;
							}else{
								$metragem = $_POST['metragem'];
							}						
							if($_POST['metragemC'] == ""){
								$metragemC = 0;
							}else{
								$metragemC = $_POST['metragemC'];
							}						
							if($_POST['fundos'] == ""){
								$fundos = 0;
							}else{
								$fundos = $_POST['fundos'];
							}						
							if($_POST['largura'] == ""){
								$largura = 0;
							}else{
								$largura = $_POST['largura'];
							}											

							if(isset($_POST["lote"])) {
								$optionArray = $_POST["lote"];
								for($i = 0; $i < count($optionArray); $i++){
									if($lote == ""){
										$lote = $optionArray[$i];
									}else{
										$lote .= ", ".$optionArray[$i];
									}
								}
							}
							
							$sqlImovel = "SELECT * FROM imoveis WHERE codImovel = '".$url[6]."' LIMIT 0,1";
							$resultImovel = $conn->query($sqlImovel);
							$dadosImovel = $resultImovel->fetch_assoc();

							$alteracaoImovel = date('Y-m-d H:i:s');
																				
							 $sql = "UPDATE imoveis SET codUsuario = ".$_POST['usuario'].", codigoImovel = '".$_POST['codigo']."', codProprietario = ".$dadosProprietario['codProprietario'].", nomeImovel = '".preparaNome($_POST['nome'])."', precoImovel = '".$preco."', precoCImovel = '".$precoC."', codCidade = '".$_POST['cidades']."', codBairro = '".$_POST['bairro']."', enderecoImovel = '".$_POST['endereco']."', nApartamentoImovel = '".$_POST['nApartamento']."', quadraImovel = '".$_POST['quadra']."', loteImovel = '".$lote."', matriculaImovel = '".$_POST['matricula']."', quartosImovel = '".$quartos."', banheirosImovel = '".$banheiros."', suiteImovel = '".$suite."', garagemImovel = '".$garagem."', metragemImovel = '".$metragem."', metragemCImovel = '".$metragemC."', fundosImovel = '".$fundos."', larguraImovel = '".$largura."', siglaMetragem = '".$_POST['siglaMetragem']."', frenteImovel = '".$_POST['frente']."', posicaoImovel = '".$_POST['posicao']."', codTipoImovel = '".$_POST['tipo']."', tipoVendaImovel = '".$_POST['tipo-venda']."', videoImovel = '".str_replace("'", "&#39;", $_POST['video'])."', mapaImovel = '".str_replace("'", "&#39;", $_POST['mapa'])."', descricaoImovel = '".str_replace("'", "&#39;", $descricao)."', observacoesImovel = '".str_replace("'", "&#39;", $_POST['observacoes'])."', urlImovel = '".$urlImovel."', alteracaoImovel = '$alteracaoImovel' WHERE codImovel = '".$url[6]."'";
							$result = $conn->query($sql);
							
							if($result == 1){

								if($dadosImovel['precoImovel'] != $preco){
									$sqlImovel = "DELETE FROM imoveisNotifica WHERE codImovel = '".$url[6]."'";
									$resultImovel = $conn->query($sqlImovel);
								}

								$sqlProprietario = "UPDATE proprietarios SET celularProprietario = '".$_POST['numero']."' WHERE codProprietario = ".$dadosProprietario['codProprietario'];
								$resultProprietario = $conn->query($sqlProprietario);

								$_SESSION['nome'] = $_POST['nome'];
								$_SESSION['alteracaos'] = "ok";

								$sqlDelete = "DELETE FROM imoveisLotes WHERE codImovel = ".$url[6]."";
								$resultDelete = $conn->query($sqlDelete);

								if(isset($_POST["lote"])) {
									$optionArray = $_POST["lote"];
									for($i = 0; $i < count($optionArray); $i++){
										$sql = "INSERT INTO imoveisLotes VALUES(0, '".$url[6]."', '".$optionArray[$i]."')";
										$result = $conn->query($sql);						
									}
								}
								
								$sqlCaracteristicaImovel = "SELECT * FROM caracteristicasImoveis WHERE codImovel = ".$url[6]."";
								$resultCaracteristicaImovel = $conn->query($sqlCaracteristicaImovel);
								$dadosCaracteristicaImovel = $resultCaracteristicaImovel->fetch_assoc();

								$sqlCaracteristica = "SELECT *  FROM caracteristicasImoveis ORDER BY codCaracteristica ASC";
								$resultCaracteristica = $conn->query($sqlCaracteristica);
								while($dadosCaracteristicaLimpa = $resultCaracteristica->fetch_assoc()){
									$_SESSION['caracteristica'.$url[6].$dadosCaracteristicaLimpa['codCaracteristica']] = "";
								}
								
								for($i=1; $i<=$_POST['quantas']; $i++){
									if($i == 1){
										$sqlDelete = "DELETE FROM caracteristicasImoveis WHERE codImovel = ".$url[6]."";
										$resultDelete = $conn->query($sqlDelete);
									}
									if($_POST['caracteristica'.$i] != ""){
										$sqlInsere = "INSERT INTO caracteristicasImoveis VALUES(0, ".$_POST['caracteristica'.$i].", ".$url[6].")";
										$resultInsere = $conn->query($sqlInsere);
									}
								}

								echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/imoveis/'>";
							}else{
								$erroData = "<p class='erro'>Problemas ao alterar imóvel!</p>";
							}
					
						}else{
							$erroData = "<p class='erro'>Código ja utilizado em outro imóvel!</p>";
							$_SESSION['proprietarios'] = $_POST['proprietarios'];
							$_SESSION['codigo'] = "";
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['usuario'] = $_POST['usuario'];
							$_SESSION['preco'] = $_POST['preco'];
							$_SESSION['precoC'] = $_POST['precoC'];
							$_SESSION['cidades'] = $_POST['cidades'];
							$_SESSION['bairro'] = $_POST['bairro'];
							$_SESSION['endereco'] = $_POST['endereco'];
							$_SESSION['nApartamento'] = $_POST['nApartamento'];
							$_SESSION['quadra'] = $_POST['quadra'];
							$_SESSION['lote'] = $_POST['lote'];
							$_SESSION['matricula'] = $_POST['matricula'];
							$_SESSION['quartos'] = $_POST['quartos'];
							$_SESSION['suite'] = $_POST['suite'];
							$_SESSION['banheiros'] = $_POST['banheiros'];
							$_SESSION['garagem'] = $_POST['garagem'];
							$_SESSION['metragem'] = $_POST['metragem'];
							$_SESSION['metragemC'] = $_POST['metragemC'];
							$_SESSION['fundos'] = $_POST['fundos'];
							$_SESSION['largura'] = $_POST['largura'];
							$_SESSION['frente'] = $_POST['frente'];
							$_SESSION['posicao'] = $_POST['posicao'];							
							$_SESSION['tipo'] = $_POST['tipo'];
							$_SESSION['tipoc'] = $_POST['tipoc'];
							$_SESSION['tipo-venda'] = $_POST['tipo-venda'];
							$_SESSION['video'] = $_POST['video'];
							$_SESSION['mapa'] = $_POST['mapa'];
							$_SESSION['descricao'] = $_POST['descricao'];
							$_SESSION['observacoes'] = $_POST['observacoes'];
							$_SESSION['siglaMetragem'] = $_POST['siglaMetragem'];
						}	

					}else{
						$erroData = "<p class='erro'>Proprietario não encontrado!</p>";
						$_SESSION['proprietarios'] = "";
						$_SESSION['codigo'] = $_POST['codigo'];
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['usuario'] = $_POST['usuario'];
						$_SESSION['preco'] = $_POST['preco'];
						$_SESSION['precoC'] = $_POST['precoC'];
						$_SESSION['cidades'] = $_POST['cidades'];
						$_SESSION['bairro'] = $_POST['bairro'];
						$_SESSION['endereco'] = $_POST['endereco'];
						$_SESSION['nApartamento'] = $_POST['nApartamento'];
						$_SESSION['quadra'] = $_POST['quadra'];
						$_SESSION['lote'] = $_POST['lote'];
						$_SESSION['matricula'] = $_POST['matricula'];
						$_SESSION['quartos'] = $_POST['quartos'];
						$_SESSION['suite'] = $_POST['suite'];
						$_SESSION['banheiros'] = $_POST['banheiros'];
						$_SESSION['garagem'] = $_POST['garagem'];
						$_SESSION['metragem'] = $_POST['metragem'];
						$_SESSION['metragemC'] = $_POST['metragemC'];
						$_SESSION['fundos'] = $_POST['fundos'];
						$_SESSION['largura'] = $_POST['largura'];
						$_SESSION['frente'] = $_POST['frente'];
						$_SESSION['posicao'] = $_POST['posicao'];
						$_SESSION['tipo'] = $_POST['tipo'];
						$_SESSION['tipoc'] = $_POST['tipoc'];
						$_SESSION['tipo-venda'] = $_POST['tipo-venda'];
						$_SESSION['video'] = $_POST['video'];
						$_SESSION['mapa'] = $_POST['mapa'];
						$_SESSION['descricao'] = $_POST['descricao'];
						$_SESSION['observacoes'] = $_POST['observacoes'];
						$_SESSION['siglaMetragem'] = $_POST['siglaMetragem'];
						$erroAtiva = "ok";	
					}
				}else{
					$sql = "SELECT * FROM imoveis WHERE codImovel = ".$url[6];
					$result = $conn->query($sql);
					$dadosImovel = $result->fetch_assoc();
						
					$_SESSION['codigo'] = $dadosImovel['codigoImovel'];
					$_SESSION['nome'] = $dadosImovel['nomeImovel'];
					$_SESSION['usuario'] = $dadosImovel['codUsuario'];
					$_SESSION['cidades'] = $dadosImovel['codCidade'];
					$_SESSION['bairro'] = $dadosImovel['codBairro'];
					$_SESSION['quadra'] = $dadosImovel['quadraImovel'];
					$_SESSION['endereco'] = $dadosImovel['enderecoImovel'];
					$_SESSION['nApartamento'] = $dadosImovel['nApartamentoImovel'];
					$_SESSION['lote'] = $dadosImovel['loteImovel'];
					$_SESSION['matricula'] = $dadosImovel['matriculaImovel'];
					$_SESSION['quartos'] = $dadosImovel['quartosImovel'];
					$_SESSION['suite'] = $dadosImovel['suiteImovel'];
					$_SESSION['banheiros'] = $dadosImovel['banheirosImovel'];
					$_SESSION['garagem'] = $dadosImovel['garagemImovel'];
					$_SESSION['metragem'] = $dadosImovel['metragemImovel'];
					$_SESSION['metragemC'] = $dadosImovel['metragemCImovel'];
					$_SESSION['fundos'] = $dadosImovel['fundosImovel'];
					$_SESSION['largura'] = $dadosImovel['larguraImovel'];
					$_SESSION['frente'] = $dadosImovel['frenteImovel'];
					$_SESSION['posicao'] = $dadosImovel['posicaoImovel'];
					$_SESSION['tipo'] = $dadosImovel['codTipoImovel'];
					$_SESSION['tipoc'] = $dadosImovel['tipoCImovel'];
					$_SESSION['tipo-venda'] = $dadosImovel['tipoVendaImovel'];
					$_SESSION['video'] = $dadosImovel['videoImovel'];
					$_SESSION['mapa'] = $dadosImovel['mapaImovel'];
					$_SESSION['descricao'] = $dadosImovel['descricaoImovel'];
					$_SESSION['observacoes'] = $dadosImovel['observacoesImovel'];
					$_SESSION['preco'] = number_format($dadosImovel['precoImovel'], 2, ',', '.');
					$_SESSION['precoC'] = number_format($dadosImovel['precoCImovel'], 2, ',', '.');
					$_SESSION['siglaMetragem'] = $dadosImovel['siglaMetragem'];
												
					$sqlProprietario = "SELECT nomeProprietario, celularProprietario  FROM proprietarios WHERE codProprietario = '".$dadosImovel['codProprietario']."' LIMIT 0,1";
					$resultProprietario = $conn->query($sqlProprietario);
					$dadosProprietario = $resultProprietario->fetch_assoc();
					
					$_SESSION['proprietarios'] = $dadosProprietario['nomeProprietario'];
					$_SESSION['numero'] = $dadosProprietario['celularProprietario'];

					$sqlCaracteristica = "SELECT *  FROM caracteristicasImoveis ORDER BY codCaracteristica ASC";
					$resultCaracteristica = $conn->query($sqlCaracteristica);
					while($dadosCaracteristicaLimpa = $resultCaracteristica->fetch_assoc()){
						$_SESSION['caracteristica'.$url[6].$dadosCaracteristicaLimpa['codCaracteristica']] = "";
					}

					$sqlCaracteristica = "SELECT *  FROM caracteristicasImoveis WHERE codImovel = ".$dadosImovel['codImovel']." ORDER BY codCaracteristica ASC";
					$resultCaracteristica = $conn->query($sqlCaracteristica);
					while($dadosCaracteristica = $resultCaracteristica->fetch_assoc()){	
						$_SESSION['caracteristica'.$url[6].$dadosCaracteristica['codCaracteristica']] = "OK";
					}	
				}

				$sql = "SELECT * FROM imoveis WHERE codImovel = ".$url[6];
				$result = $conn->query($sql);
				$dadosImovel = $result->fetch_assoc();	
				
				$_SESSION['lote-antigo'] = $dadosImovel['loteImovel'];			
				
				$_SESSION['valor-imovel'] = $dadosImovel['precoImovel'];

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

				if($_COOKIE['codAprovado'.$cookie] == $dadosImovel['codUsuario'] || $filtraUsuario == ""){
?>				
					<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
<?php
				}
?>					
					<p class="obrigatorio">Campos obrigatórios *</p>
					<br/>
					<p style="color:#718B8F; font-weight:bold;">* Campos nesta cor aparecerão no site</p>
					<p style="color:#718B8F;">* Campos nesta cor não aparecerão no site</p>
					<br/>
					<script>
						function habilitaCampo(){
							document.getElementById("usuario").disabled = false;
							document.getElementById("codigo").disabled = false;
							document.getElementById("nome").disabled = false;
							document.getElementById("busca_autocomplete_softbest_proprietarios_c").disabled = false;
							document.getElementById("preco").disabled = false;
							document.getElementById("precoC").disabled = false;
							document.getElementById("cidades").disabled = false;
							document.getElementById("bairro").disabled = false;
							document.getElementById("endereco").disabled = false;
							document.getElementById("nApartamento").disabled = false;
							document.getElementById("idSelectQuadra").disabled = false;
							document.getElementById("idSelectLote").disabled = false;
							document.getElementById("matricula").disabled = false;
							document.getElementById("quartos").disabled = false;
							document.getElementById("banheiros").disabled = false;
							document.getElementById("suite").disabled = false;
							document.getElementById("garagem").disabled = false;
							document.getElementById("metragem").disabled = false;
							document.getElementById("metragemC").disabled = false;
							document.getElementById("fundos").disabled = false;
							document.getElementById("siglaMetragem").disabled = false;
							document.getElementById("siglaMetragem2").disabled = false;
							document.getElementById("numero").disabled = false;
<?php
				$cont = 0;
				
				$sqlCaracteristica = "SELECT * FROM caracteristicas WHERE statusCaracteristica = 'T' ORDER BY codOrdenacaoCaracteristica ASC";
				$resultCaracteristica = $conn->query($sqlCaracteristica);
				while($dadosCaracteristica = $resultCaracteristica->fetch_assoc()){
					$cont++;
?>
							document.getElementById("caracteristica<?php echo $cont;?>").disabled = false;
<?php
				}
?>
							document.getElementById("frente").disabled = false;
							document.getElementById("tipo-venda").disabled = false;
							document.getElementById("posicao").disabled = false;
							document.getElementById("tipo").disabled = false;
							document.getElementById("video").disabled = false;
							document.getElementById("observacoes").disabled = false;
							document.getElementById("alterar").disabled = false;
						}
					</script>
		
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
						<form id="formulario" name="formImovel" action="<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $url[6] ;?>/" method="post">						

							<script type="text/javascript">
								function exibeCamposTipo(tipo){
									var $tg = jQuery.noConflict();
									if(tipo == 5){
										$tg("#formulario .retira").css("display", "none");
										$tg("#formulario .5").css("display", "block");
									}else
									if(tipo == 6){
										$tg("#formulario .retira").css("display", "none");
										$tg("#formulario .6").css("display", "block");
									}else
									if(tipo != ""){
										$tg("#formulario .retira").css("display", "none");
										$tg("#formulario .coloca").css("display", "block");
									}else{
										$tg("#formulario .coloca").css("display", "block");
										$tg("#formulario .6").css("display", "block");
									}
								}
							</script>

							<p class="bloco-campo-float"><label>Tipo Imóvel: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo" name="tipo" style="width:180px; height:32px;" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> onChange="exibeCamposTipo(this.value);">
									<option value="">Todos</option>
<?php
				$sqlTipoImovel = "SELECT * FROM tipoImovel WHERE statusTipoImovel = 'T' ORDER BY nomeTipoImovel ASC";
				$resultTipoImovel = $conn->query($sqlTipoImovel);
				while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoImovel['codTipoImovel'] ;?>" <?php echo $_SESSION['tipo'] == $dadosTipoImovel['codTipoImovel'] ? '/SELECTED/' : '';?>><?php echo $dadosTipoImovel['nomeTipoImovel'] ;?></option>
<?php
				}
?>					
								</select>
								<br class="clear"/>
							</p>

							<p class="bloco-campo-float"><label>Código: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="codigo" name="codigo" required style="width:80px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>  value="<?php echo $_SESSION['codigo']; ?>" /></p>
														
							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="usuario" name="usuario" style="width:150px;" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>>
									<option value="">Selecione</option>
<?php
				if($_COOKIE['codAprovado'.$cookie] == $dadosImovel['codUsuario'] || $filtraUsuario == ""){
					$sqlUsuarios = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4".$filtraUsuario." ORDER BY nomeUsuario ASC";
				}else{
					$sqlUsuarios = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4 ORDER BY nomeUsuario ASC";					
				}
				$resultUsuarios = $conn->query($sqlUsuarios);
				while($dadosUsuarios = $resultUsuarios->fetch_assoc()){
?>
									<option value="<?php echo $dadosUsuarios['codUsuario'] ;?>" <?php echo $_SESSION['usuario'] == $dadosUsuarios['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuarios['nomeUsuario'] ;?></option>
<?php
}
?>					
								</select>
								<br class="clear"/>
							</p>
														
							<div id="auto_complete_softbest" style="width:219px; float:left; margin-right:10px; margin-bottom:15px; position:relative;">
								<p class="bloco-campo" style="margin-bottom:0px;"><label>Proprietário: <span class="obrigatorio"> </span></label>
								<input class="campo" type="text" name="proprietarios" style="width:200px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['proprietarios']; ?>" onClick="auto_complete(this.value, 'proprietarios_c', event); setTimeout(buscarProprietario, 200);" onKeyUp="auto_complete(this.value, 'proprietarios_c', event); setTimeout(buscarProprietario, 200);" onkeydown="if (getKey(event) == 13) return false;" onBlur="fechaAutoComplete('proprietarios_c'); setTimeout(buscarProprietario, 200); " autocomplete="off" id="busca_autocomplete_softbest_proprietarios_c" /></p>
								
								<div id="exibe_busca_autocomplete_softbest_proprietarios_c" class="auto_complete_softbest" style="display:none;">

								</div>
							</div>
							<script>
								function buscarProprietario() {
									var valor = document.getElementById("busca_autocomplete_softbest_proprietarios_c").value.trim();

									if (valor.trim() === "") {
										document.getElementById("numero").value = "";
										return;
									}

									const url = "<?php echo $configUrlGer.'cadastros/imoveis/verifica_numero.php' ?>?proprietario=" + encodeURIComponent(valor);

									fetch(url)
										.then(response => response.text())
										.then(data => {
											document.getElementById("numero").value = data;
										})
										.catch(error => {
											console.error("Erro na requisição:", error);
										});
								}
							</script>


							<p class="bloco-campo-float"><label>Celular: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="numero" name="numero" style="width:100px;" value="<?php echo $_SESSION['numero']; ?>"  onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);" /></p>

														
							<p class="bloco-campo-float"><label>Preço Custo: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="precoC" name="precoC" style="width:150px;" onKeyUp="moeda(this);" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['precoC']; ?>" /></p>
														
							<p class="bloco-campo-float"><label>Preço Venda: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="preco" name="preco" style="width:150px;" onKeyUp="moeda(this);" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['preco']; ?>" /></p>
							
							<br class="clear" />

							<p class="bloco-campo-float"><label>Título do Anúncio: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="nome" name="nome" required style="width:220px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>  value="<?php echo $_SESSION['nome']; ?>" /></p>

							<script type="text/javascript">
								function carregaBairro(cod){
									var $tgf = jQuery.noConflict();
									$tgf.post("<?php echo $configUrl;?>cadastros/imoveis/carrega-bairro.php", {codCidade: cod}, function(data){
										$tgf("#carrega-bairro").html(data);
										$tgf("#sel-padrao").css("display", "none");																									
									});
								}
							</script>
							
							<p class="bloco-campo-float"><label>Cidade: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="cidades" name="cidades" style="width:200px;" required onChange="carregaBairro(this.value);" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>>
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
								<br class="clear"/>
							</p>
							
<?php
				if($_SESSION['cidades'] == ""){
?>													
							<div id="sel-padrao">
								<p class="bloco-campo-float"><label class="label">Bairro: <span class="obrigatorio"> * </span></label>
									<select id="default-usage-select" id="bairro" class="campo" name="bairro" style="width:230px;" onChange="carregaQuadra();">
										<option id="option" value="">Selecione uma cidade primeiro</option>
									</select>
									<br class="clear"/>
								</p>
							</div>
<?php
				}
?>													
							<div id="carrega-bairro">
<?php
				if($_SESSION['cidades'] != ""){
?>
								<p class="bloco-campo-float"><label class="label">Bairro: <span class="obrigatorio"> * </span></label>
									<select class="campo" name="bairro" style="width:230px;" id="bairro" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> onChange="carregaQuadra();">
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
				}
?>
							</div>
							
							<script>
								function carregaQuadra(){
									var $pos = jQuery.noConflict();
									$pos.post("<?php echo $configUrlGer;?>cadastros/imoveis/quadras.php", {codQuadra: 1}, function(data){	
										var prepara = data.trim();	
										$pos("#carrega-quadras").html(prepara);
									});											
								}								
							</script>
							
							<div id="carrega-quadras">
<?php
				if($_SESSION['bairro'] != ""){
?>
								<p class="bloco-campo-float"><label>Quadra: <span class="obrigatorio"> * </span></label>
									<select class="selectQuadra form-control campo" id="idSelectQuadra" disabled="disabled" name="quadra" style="width:150px; display: none;">
										<optgroup label="Selecione">
<?php
					$sqlQuadrasLista = "SELECT * FROM quadras ORDER BY codQuadra ASC";
					$resultQuadrasLista = $conn->query($sqlQuadrasLista);
					while($dadosQuadrasLista = $resultQuadrasLista->fetch_assoc()){				
?>
										<option value="<?php echo trim($dadosQuadrasLista['nomeQuadra']);?>" <?php echo $_SESSION['quadra'] == trim($dadosQuadrasLista['nomeQuadra']) ? '/SELECTED/' : '';?> ><?php echo trim($dadosQuadrasLista['nomeQuadra']);?></option>	
<?php
					}
?>
									</select>										
								</p>

								<script>
									var $rfs = jQuery.noConflict();
									
									$rfs(".selectQuadra").select2({
										placeholder: "Selecione",
										multiple: false									
									});	
																		
									$rfs(".selectQuadra").on("select2:select", function (e) {
										var cidadeSeleciona = document.getElementById("cidades").value;
										var bairroSeleciona = document.getElementById("bairro").value;
										var quadraSeleciona = document.getElementById("idSelectQuadra").value;

										var $tgfs = jQuery.noConflict();
										$tgfs.post("<?php echo $configUrl;?>cadastros/imoveis/lotes.php", {codCidade: cidadeSeleciona, codBairro: bairroSeleciona, quadraImovel: quadraSeleciona}, function(data){
											$tgfs("#carrega-lotes").html(data);
										});									
									});																	
								</script>

<?php
				}else{
?>
								<p class="bloco-campo-float"><label>Quadra: <span class="obrigatorio"> * </span></label>
									<select class="selectQuadra form-control campo" id="idSelectQuadra" name="lote" multiple="" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:150px; display: none;">
										<optgroup label="Selecione">
									</select>										
								</p>

								<script>
									var $rfs = jQuery.noConflict();
									
									$rfs(".selectQuadra").select2({
										placeholder: "Selecione",
										multiple: false,
										templateResult: function (data, container) {
											if (data.element) {
												$rfs(container).addClass($rf(data.element).attr("class"));
											}
											return data.text;
										}									
									});										
								</script>								
<?php
				}
?>
							</div>
							
							<div id="carrega-lotes">
<?php
				if($_SESSION['lote'] != ""){

					$codCidade = $_SESSION['cidades'];
					$codBairro = $_SESSION['bairro'];
					$quadraImovel = $_SESSION['quadra'];					
?>
								<p class="bloco-campo-float"><label>Lote(s): <span class="obrigatorio"> * </span></label>
									<select class="selectLote form-control campo" id="idSelectLote" name="lote[]" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> multiple="" style="width:140px; display: none;">
										<optgroup label="Selecione">
<?php					
					$sqlLotesLista = "SELECT * FROM lotes ORDER BY codLote ASC";
					$resultLotesLista = $conn->query($sqlLotesLista);
					while($dadosLotesLista = $resultLotesLista->fetch_assoc()){
						
						$sqlImovel = "SELECT * FROM imoveis I inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$quadraImovel."' and I.loteImovel = '".trim($dadosLotesLista['nomeLote'])."' GROUP BY I.codImovel ORDER BY I.codImovel DESC LIMIT 0,1";
						$resultImovel = $conn->query($sqlImovel);
						$dadosImovel = $resultImovel->fetch_assoc();

						$nomeCorretor = explode(" ", $dadosImovel['nomeUsuario']);
																								
						$lotes = explode(",", $_SESSION['lote-antigo']);
						$loteOk = "";
						$loteOkConf = "";
						foreach($lotes as $lote) {
							$lote = trim($lote);
							if($lote == trim($dadosLotesLista['nomeLote'])){
								$loteOk = "sim";
								$loteOkConf = "sim";
							}
						}
																
						if($dadosImovel['codImovel'] == "" || $loteOk == "sim"){
							
							$sqlImovel = "SELECT * FROM imoveisLotes IL inner join imoveis I on IL.codImovel = I.codImovel inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$quadraImovel."' and IL.nomeLote = '".trim($dadosLotesLista['nomeLote'])."' GROUP BY IL.codImovelLote ORDER BY I.codImovel DESC LIMIT 0,1";
							$resultImovel = $conn->query($sqlImovel);
							$dadosImovel = $resultImovel->fetch_assoc();

							$nomeCorretor = explode(" ", $dadosImovel['nomeUsuario']);
							
							if($dadosImovel['codImovel'] == "" || $loteOk == "sim"){
								$classColor = "select2-green";
								$corretor = "";
								$disabled = "";					
							}else{
								$classColor = "select2-red";
								$corretor = " - ".$nomeCorretor[0];
								$disabled = "disabled='disabled'";								
							}			
						}else{
							$classColor = "select2-red";
							$corretor = " - ".$nomeCorretor[0];
							$disabled = "disabled='disabled'";							
						}					
?>
										<option class="<?php echo $classColor;?>" value="<?php echo trim($dadosLotesLista['nomeLote']);?>" <?php echo $loteOkConf == "sim" ? '/SELECTED/' : '';?> <?php echo $loteOkSe == "sim" ? '/SELECTED/' : '';?> <?php echo $disabled;?> ><?php echo trim($dadosLotesLista['nomeLote']).$corretor;?></option>	
<?php
					}
?>
									</select>										
								</p>
								<script>
									var $rf = jQuery.noConflict();
									
									$rf(".selectLote").select2({
										placeholder: "Selecione",
										multiple: true,
										allowClear: true,
										templateResult: function (data, container) {
											if (data.element) {
												$rf(container).addClass($rf(data.element).attr("class"));
											}
											return data.text;
										}									
									});										
								</script>
<?php
				}else{
?>
								<p class="bloco-campo-float"><label>Lote(s): <span class="obrigatorio"> * </span></label>
									<select class="selectLote form-control campo" id="idSelectLote" name="lote[]" multiple="" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:140px; display: none;">
										<optgroup label="Selecione">
									</select>										
								</p>

								<script>
									var $rf = jQuery.noConflict();
									
									$rf(".selectLote").select2({
										placeholder: "Selecione",
										multiple: true,
										templateResult: function (data, container) {
											if (data.element) {
												$rf(container).addClass($rf(data.element).attr("class"));
											}
											return data.text;
										}									
									});										
								</script>								
<?php
				}
?>
							</div>	

							<br class="clear"/>						

							<p class="bloco-campo-float coloca retira 6" style="<?php echo $_SESSION['tipo'] != 5 ? 'display:block;' : 'display:none;';?>"><label>Quartos: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="quartos" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="quartos" style="width:70px;" value="<?php echo $_SESSION['quartos']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6" style="<?php echo $_SESSION['tipo'] != 5 ? 'display:block;' : 'display:none;';?>"><label>Suítes: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="suite" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="suite" style="width:70px;" value="<?php echo $_SESSION['suite']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6" style="<?php echo $_SESSION['tipo'] != 5 ? 'display:block;' : 'display:none;';?>"><label>Banheiros: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="banheiros" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="banheiros" style="width:80px;" value="<?php echo $_SESSION['banheiros']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6" style="<?php echo $_SESSION['tipo'] != 5 ? 'display:block;' : 'display:none;';?>"><label>Garagem: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="garagem" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="garagem" style="width:90px;" value="<?php echo $_SESSION['garagem']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6" style="<?php echo $_SESSION['tipo'] != 5 ? 'display:block;' : 'display:none;';?>"><label>Área Construída: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="metragemC" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="metragemC" style="width:130px;" value="<?php echo $_SESSION['metragemC']; ?>" /></p>
							
							<p class="bloco-campo-float coloca retira 5" style="<?php echo $_SESSION['tipo'] != 6 ? 'display:block;' : 'display:none;';?>"><label>Frente: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="frente" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="frente" style="width:70px;" value="<?php echo $_SESSION['frente']; ?>" onKeyup="calculaArea();" /></p>
							
							<p class="bloco-campo-float coloca retira 5" style="<?php echo $_SESSION['tipo'] != 6 ? 'display:block;' : 'display:none;';?>"><label>Fundos: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="fundos" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="fundos" style="width:70px;" value="<?php echo $_SESSION['fundos']; ?>"  onKeyup="calculaArea();"/></p>

							<p class="bloco-campo-float coloca retira 5" style="<?php echo $_SESSION['tipo'] != 6 ? 'display:block;' : 'display:none;';?>"><label>Área Terreno: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="metragem" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="metragem" style="width:100px;" value="<?php echo $_SESSION['metragem']; ?>" /></p>

							<p class="bloco-campo-float"><label>Sigla Área: <span class="obrigatorio"> </span></label>
							<label style="font-weight:normal; font-size:14px; float:left; margin-top:10px; margin-right:20px;"><input type="radio" id="siglaMetragem" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="siglaMetragem" <?php echo $_SESSION['siglaMetragem'] == "m²" ? 'checked' : '';?> <?php echo $_SESSION['siglaMetragem'] == "" ? 'checked' : '';?> value="m²"/> m²</label> <label style="font-weight:normal; font-size:14px; float:left; margin-top:10px;"><input type="radio" <?php echo $_SESSION['siglaMetragem'] == "ha" ? 'checked' : '';?> id="siglaMetragem2" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="siglaMetragem" value="ha"/> ha</label><br class="clear"/></p>
																					
							<p class="bloco-campo-float coloca retira 5 6"><label>Posição Solar: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="posicao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="posicao" style="width:102px;" value="<?php echo $_SESSION['posicao']; ?>" /></p>

							<script type="text/javascript">
								function calculaArea(){
									var frente = document.getElementById("frente").value;
									var fundos = document.getElementById("fundos").value;
									
									if(frente != "" && fundos != ""){
										calcula = frente * fundos;
										document.getElementById("metragem").value=calcula;
									}
								}
							</script>
														
							<br class="clear"/>
						
							<p class="bloco-campo-float"><label style="font-weight:normal;">Preço Custo: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="precoC" name="precoC" style="width:120px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> onKeyUp="moeda(this);" value="<?php echo $_SESSION['preco']; ?>" /></p>
							
							<p class="bloco-campo-float coloca retira 5 6"><label style="font-weight:normal;">Endereço: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="endereco" name="endereco" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:300px;" value="<?php echo $_SESSION['endereco']; ?>" /></p>

							<p class="bloco-campo-float retira 6" style="<?php echo $_SESSION['tipo'] == 6 ? 'display:block;' : 'display:none;';?>"><label style="font-weight:normal;">Nº Apartam.: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="nApartamento" id="nApartamento" name="nApartamento" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:130px;" value="<?php echo $_SESSION['nApartamento']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 5 6"><label style="font-weight:normal;">Matrícula: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="matricula" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="matricula" style="width:100px;" value="<?php echo $_SESSION['matricula']; ?>" /></p>

							<p class="bloco-campo-float"><label style="font-weight:normal;">Tipo Venda: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo-venda" name="tipo-venda" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:242px; height:32px;" required>
									<option value="">Selecione</option>
									<option value="P" <?php echo $_SESSION['tipo-venda'] == "P" ? '/SELECTED/' : '';?> >Próprio</option>
									<option value="A" <?php echo $_SESSION['tipo-venda'] == "A" ? '/SELECTED/' : '';?> >Agenciado</option>
								</select>
								<br class="clear"/>
							</p>

							<br class="clear"/>
							
							<p class="bloco-campo"><label>Link do Vídeo (Youtube): <span class="em" style="font-weight:normal;"> EX: https://www.youtube.com/watch?v=VKtTSoC7o2I</span></label>
							<input class="campo" type="text" id="video" name="video" style="width:980px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>  value="<?php echo $_SESSION['video']; ?>" /></p>

							<br class="clear"/>

							<div class="bloco-campo" style="margin-bottom:25px;"><label>Características:<span class="obrigatorio"> </span></label><br/>
<?php
				$cont = 0;
				$contTodas = 0;
				
				$sqlCaracteristica = "SELECT * FROM caracteristicas WHERE statusCaracteristica = 'T' ORDER BY codOrdenacaoCaracteristica ASC";
				$resultCaracteristica = $conn->query($sqlCaracteristica);
				while($dadosCaracteristica = $resultCaracteristica->fetch_assoc()){
					
					$cont++;
					$contTodas++;
?>				
								<label style="font-weight:normal; float:left; width:200px; height:20px; cursor:pointer; font-size:14px; margin-top:10px;"><input type="checkbox" style="cursor:pointer;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $dadosCaracteristica['codCaracteristica'];?>" <?php echo $_SESSION['caracteristica'.$url[6].$dadosCaracteristica['codCaracteristica']] == 'OK' ? 'checked' : '';?> id="caracteristica<?php echo $contTodas;?>" name="caracteristica<?php echo $contTodas;?>"/> <?php echo $dadosCaracteristica['nomeCaracteristica'];?></label>

<?php
					if($cont == 5){
						$cont = 0;
?>
								<br class="clear"/>
<?php
					}

				}
?>
								<input type="hidden" value="<?php echo $contTodas;?>" name="quantas"/>
								<br class="clear"/>
							</div>
							
							<p class="bloco-campo" style="width:997px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:855px; height:200px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>
							
							<p class="bloco-campo"><label style="font-weight:normal;">Observações:<span class="obrigatorio"> </span></label>
							<textarea class="desabilita campo" id="observacoes" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="observacoes" type="text" style="width:981px; height:150px;" ><?php echo $_SESSION['observacoes']; ?></textarea></p>

							<br class="clear"/>

							<div class="botao-expansivel"><p class="esquerda-botao"></p><input id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="botao" type="submit" name="alterar" title="Alterar" value="Alterar"/><p class="direita-botao"></p></div>						
							<br class="clear"/>
						</form>						
					</div>					
					<br/>
					<p id="despesas"></p>
					<br/>
<?php
			if($usuario == "A"){
?>
					<script>
						function abreCadastrar(){
							var $rf = jQuery.noConflict();
							if(document.getElementById("cadastrarDespesa").style.display=="none"){
								$rf("#cadastrarDespesa").slideDown(250);
							}else{
								document.getElementById("botaoFechar").style.display="none";
								$rf("#cadastrarDespesa").slideUp(250);
							}
						}
					</script>
					<div id="consultas" style="width:96%; padding:30px;">
						<p class="titulo" style="font-size:20px; font-weight:bold; color:#718B8F;">Despesas do Imóvel</p>					
						<div class="botao-novo" style="margin-left:0px;"><a title="Nova Despesa Imovel" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Despesa Imovel</div><div class="direita-novo"></div></a></div>					
						<br class="clear"/>
						<br/>
<?php
				if($_SESSION['cadastro'] == "ok"){
					$erroData = "<p class='erro'>Despesa ".$_POST['nomeDespesa']." do Imovel ".$dadosNomePagamento['nomeImovel']." cadastrada com sucesso!</p>";
					$_SESSION['cadastro'] = "";
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

				if($_POST['nomeDespesa'] != ""){

					$sqlPegaFornecedor = "SELECT * FROM fornecedores WHERE statusFornecedor = 'T' and nomeFornecedor = '".$_POST['fornecedores']."' ORDER BY codFornecedor DESC LIMIT 0,1";
					$resultPegaFornecedor = $conn->query($sqlPegaFornecedor);
					$dadosPegaFornecedor = $resultPegaFornecedor->fetch_assoc();
					
					if($dadosPegaFornecedor['codFornecedor'] != ""){
						
						$valor = str_replace(".", "", $_POST['valor']);
						$valor = str_replace(",", ".", $valor);
						
						$sql = "INSERT INTO despesasImovel VALUES(0, ".$dadosPegaFornecedor['codFornecedor'].", ".$url[6].", '".$_POST['tipo']."', '".$_POST['nomeDespesa']."','".date("Y-m-d")."', '".date("H:m:i")."', '".$valor."', 'T')";
						$result = $conn->query($sql);
						
						if($result == 1){
							$_SESSION['nomeDespesa'] = $_POST['nomeDespesa'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/imoveis/alterar/".$url[6]."/#despesas'>";
						}else{
							$erroData = "<p class='erro'>Problemas ao cadastrar despesa do loteamento!</p>";
							$block = "block";
						}
					}else{
						$erroData = "<p class='erro'>O Fornecedor <strong>".$_POST['fornecedores']."</strong> não foi encontrado.</p>";
						$_SESSION['fornecedores'] = "";
						$_SESSION['nomeDespesa'] = $_POST['nomeDespesa'];
						$_SESSION['tipo'] = $_POST['tipo'];
						$_SESSION['valor'] = $_POST['valor'];				

						$block = "block";
					}
				}else{
					$_SESSION['fornecedores'] = "";
					$_SESSION['nomeDespesa'] = "";
					$_SESSION['tipo'] = "";
					$_SESSION['valor'] = "";					
					
					$block = "none";
				}
			
				if($_SESSION['data'] == ""){
					$_SESSION['data'] = data(date("Y-m-d"));
				}	
?>
						<div id="cadastrarDespesa" style="display:<?php echo $block;?>;">					
<?php
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
							<p class="obrigatorio">Campos obrigatórios *</p>
							<br/>
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
							<form name="formDespesaImovel" action="<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $url[6];?>/" method="post">
								<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
								<input id="nomeDespesa" class="campo" type="text" name="nomeDespesa" required style="width:390px;" value="<?php echo $_SESSION['nomeDespesa']; ?>" /></p>

								<p class="bloco-campo-float"><label>Data: <span class="obrigatorio"> * </span></label>
								<input id="data" class="campo" type="text" name="data" required style="width:138px;" value="<?php echo $_SESSION['data']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data)"/></p>

								<br class="clear"/>

								<div id="auto_complete_softbest" style="width:236px; float:left; margin-bottom:15px;">
									<p class="bloco-campo" style="margin-bottom:0px;"><label>Fornecedor: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="text" name="fornecedores" required style="width:220px;" value="<?php echo $_SESSION['fornecedores']; ?>" onClick="auto_complete(this.value, 'fornecedores_c', event);" onKeyUp="auto_complete(this.value, 'fornecedores_c', event);" onBlur="fechaAutoComplete('fornecedores_c');" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest_fornecedores_c" /></p>
									
									<div id="exibe_busca_autocomplete_softbest_fornecedores_c" class="auto_complete_softbest" style="width:234px; display:none;">

									</div>
								</div>	


								<p class="bloco-campo-float"><label>Tipo Pagamento: <span class="obrigatorio"> * </span></label>
									<select id="tipo" class="campo" style="padding:6px; width:160px;" required name="tipo" >
										<option value="">Selecione</option>
<?php
				$sqlTipoPagamento = "SELECT codTipoPagamento, nomeTipoPagamento FROM tipoPagamento WHERE statusTipoPagamento = 'T' and tipoPagamento = 'P' ORDER BY nomeTipoPagamento ASC";
				$resultTipoPagamento = $conn->query($sqlTipoPagamento);
				while($dadosTipoPagamento = $resultTipoPagamento->fetch_assoc()){
?>
										<option value="<?php echo $dadosTipoPagamento['codTipoPagamento'];?>" <?php echo $dadosTipoPagamento['codTipoPagamento'] == $_SESSION['tipo'] ? '/SELECTED/' : '';?> ><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></option>
<?php
				}
?>
									</select>
								</p>							

								<p class="bloco-campo-float"><label>Valor: <span class="obrigatorio"> * </span></label>
								<input id="valor" class="campo" type="text" name="valor" required style="width:138px;" value="<?php echo $_SESSION['valor']; ?>" onkeyup="moeda(this);"/></p>
								
								<br class="clear"/>
																
								<div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Despesas" value="Salvar" /><p class="direita-botao"></p></div>						
								<br class="clear"/>
								<br/>
							</form>
						</div>						
<?php	
				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Imovel <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Imovel <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Imovel <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Imovel <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}
				
				if($erroConteudo != ""){
?>
						<div class="area-erro">
<?php
					echo $erroConteudo;	
?>
						</div>
<?php
				}
	
				$sqlConta = "SELECT count(codDespesaImovel) registros, nomeDespesaImovel FROM despesasImovel WHERE codDespesaImovel != '' and codImovel = ".$url[6]."".$filtraTipoPagamento;
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeDespesaImovel'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Nome</th>
								<th>Fornecedor</th>
								<th>Tipo Pagamento</th>
								<th>Data</th>
								<th>Valor</th>
								<th>Pagar</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php
					if($url[7] == 1 || $url[7] == ""){
						$pagina = 1;
						$sqlDespesaImovel = "SELECT * FROM despesasImovel WHERE codDespesaImovel != '' and codImovel = ".$url[6]."".$filtraTipoPagamento." ORDER BY statusDespesaImovel ASC, codDespesaImovel DESC";
					}else{
						$pagina = $url[7];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlDespesaImovel = "SELECT * FROM despesasImovel WHERE codDespesaImovel != '' and codImovel = ".$url[6]."".$filtraTipoPagamento." ORDER BY statusDespesaImovel ASC, codDespesaImovel DESC";
					}		

					$resultDespesaImovel = $conn->query($sqlDespesaImovel);
					while($dadosDespesaImovel = $resultDespesaImovel->fetch_assoc()){
						$mostrando++;
						
						if($dadosDespesaImovel['statusDespesaImovel'] == "T"){
							$status = "icone-pagamento";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "icone-pagamento-inativo";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}

						$somaDespesaImovels = $somaDespesaImovels + $dadosDespesaImovel['valorDespesaImovel'];

						
						$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosDespesaImovel['codTipoPagamento']." LIMIT 0,1";
						$resultTipoPagamento = $conn->query($sqlTipoPagamento);
						$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();		
						
						$sqlFornecedor = "SELECT * FROM fornecedores WHERE codFornecedor = ".$dadosDespesaImovel['codFornecedor']." LIMIT 0,1";
						$resultFornecedor = $conn->query($sqlFornecedor);
						$dadosFornecedor = $resultFornecedor->fetch_assoc();
						
						$limpaValor = str_replace(".", "", $dadosDespesaImovel['valorDespesaImovel']);		
						$limpaValor = str_replace(".", "", $limpaValor);		
						$limpaValor = str_replace(",", ".", $limpaValor);		
?>

							<tr class="tr">
								<td class="quarenta"><a href='<?php echo $configUrlGer; ?>cadastros/imoveis/despesasImovel/alterar/<?php echo $url[6];?>/<?php echo $dadosDespesaImovel['codDespesaImovel'] ?>/' title='Veja os detalhes da despesa <?php echo $dadosDespesaImovel['nomeDespesaImovel'] ?>'><?php echo $dadosDespesaImovel['nomeDespesaImovel'];?></a></td>
								<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/imoveis/despesasImovel/alterar/<?php echo $url[6];?>/<?php echo $dadosDespesaImovel['codDespesaImovel'] ?>/' title='Veja os detalhes da despesa <?php echo $dadosDespesaImovel['nomeDespesaImovel'] ?>'><?php echo $dadosFornecedor['nomeFornecedor'];?></a></td>
								<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/imoveis/despesasImovel/alterar/<?php echo $url[6];?>/<?php echo $dadosDespesaImovel['codDespesaImovel'] ?>/' title='Veja os detalhes da despesa <?php echo $dadosDespesaImovel['nomeDespesaImovel'] ?>'><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></a></td>
								<td class="data" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/imoveis/despesasImovel/alterar/<?php echo $url[6];?>/<?php echo $dadosDespesaImovel['codDespesaImovel'] ?>/' title='Veja os detalhes da despesa <?php echo $dadosDespesaImovel['nomeDespesaImovel'] ?>'><?php echo data($dadosDespesaImovel['dataDespesaImovel']);?></a></td>
								<td class="treze" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/imoveis/despesasImovel/alterar/<?php echo $url[6];?>/<?php echo $dadosDespesaImovel['codDespesaImovel'] ?>/' title='Veja os detalhes da despesa <?php echo $dadosDespesaImovel['nomeDespesaImovel'] ?>'>R$<span style="color:#f5f5f5;">_</span><?php echo number_format($dadosDespesaImovel['valorDespesaImovel'], 2, ",", ".");?></a></td>
								<td class="botoes">
									<form action="<?php echo $configUrlGer;?>financeiro/contas-pagar/" method="post">
										<input type="hidden" value="<?php echo $url[6];?>" name="imovel"/>
										<input type="hidden" value="<?php echo $dadosDespesaImovel['codDespesaImovel'];?>" name="codDespesaImovel"/>
										<input type="hidden" value="<?php echo $dadosDespesaImovel['nomeDespesaImovel'];?>" name="nomeDespesaImovel"/>
										<input type="hidden" value="<?php echo $dadosFornecedor['nomeFornecedor'];?>" name="nomeFornecedor"/>
										<input type="hidden" value="<?php echo $dadosDespesaImovel['valorDespesaImovel'];?>" name="valorDespesaImovel"/>
										<input type="hidden" value="<?php echo $dadosTipoPagamento['nomeTipoPagamento'];?>" name="tipoPagamento"/>
<?php
						if($dadosDespesaImovel['statusDespesaImovel'] == "T"){
?>
										<input type="submit" value="" style="width:61px; height:62px; border:none; outline:none; cursor:pointer; background:transparent url('<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif') center center no-repeat" alt="icone">
<?php
						}else{
?>	
										<input type="button" value="" style="width:61px; height:62px; border:none; outline:none; background:transparent url('<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif') center center no-repeat" alt="icone">
<?php
						}
?>
										<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/imoveis/despesasImovel/alterar/<?php echo $url[6];?>/<?php echo $dadosDespesaImovel['codDespesaImovel'];?>/' title='Deseja alterar a despesa <?php echo $dadosDespesaImovel['nomeDespesaImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
<?php
						if($dadosDespesaImovel['statusDespesaImovel'] == "T"){
?>
										<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosDespesaImovel['codDespesaImovel'] ?>, "<?php echo htmlspecialchars($dadosDespesaImovel['nomeDespesaImovel']) ?>");' title='Deseja excluir a despesa <?php echo $dadosDespesaImovel['nomeDespesaImovel'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
<?php
						}else{
?>
										<td class="botoes"><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></td>
<?php
						}
?>
									</form>
								</td>
							</tr>
<?php
					}
?>
							<script>
								 function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir a despesa "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>cadastros/imoveis/despesasImovel/<?php echo $url[6];?>/excluir/'+cod+'/';
									}
								  }
							 </script>
								 
						</table>
<?php
	}
?>
						<?php
							$precoVenda = isset($_SESSION['valor-imovel']) ? floatval($_SESSION['valor-imovel']) : 0;
							$despesas = isset($somaDespesaImovels) ? floatval($somaDespesaImovels) : 0;
							$lucroEsperado = $precoVenda - $despesas;
						?>
						<div id="total" style="background-color:#f5f5f5; margin-top:20px; width:100%;">
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; color:#0000FF; padding-top:15px; text-align:right;">Preço de Venda:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; color:#0000FF; padding-bottom:15px; font-size:16px;">R$ <?php echo number_format($precoVenda, 2, ",", ".");?></p>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; color:#FF0000; padding-top:15px; text-align:right;">Despesas:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; color:#FF0000; padding-bottom:15px; font-size:16px;">R$ <?php echo number_format($despesas, 2, ",", ".");?></p>
							<?php
								$corLucro = $lucroEsperado > 0 ? '#0000FF' : '#FF0000';
							?>
							<p class="titulo" style="font-weight:bold; font-size:16px; padding-right:15px; color:<?php echo $corLucro; ?>; padding-top:15px; text-align:right;">Lucro Esperado:</p>
							<p class="total" style="text-align:right; padding-right:15px; padding-top:5px; color:<?php echo $corLucro; ?>; padding-bottom:15px; font-size:16px;">R$ <?php echo number_format($lucroEsperado, 2, ",", ".");?></p>
						</div>					
					</div>
<?php
			}
?>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['codigo'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['usuario'] = "";
					$_SESSION['proprietario'] = "";
					$_SESSION['preco'] = "";
					$_SESSION['precoC'] = "";
					$_SESSION['cidades'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['endereco'] = "";
					$_SESSION['nApartamento'] = "";
					$_SESSION['lote'] = "";
					$_SESSION['quadra'] = "";
					$_SESSION['matricula'] = "";
					$_SESSION['metragem'] = "";
					$_SESSION['tipo'] = "";
					$_SESSION['tipoc'] = "";
					$_SESSION['video'] = "";
					$_SESSION['mapa'] = "";
					$_SESSION['descricao'] = "";
					$_SESSION['observacoes'] = "";
				}

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
