<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "imoveisS";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracaos'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracaos'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacaos'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacaos'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['capa'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']."!</p>";
					$_SESSION['capa'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['destaque'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']."!</p>";
					$_SESSION['destaque'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['lancamento'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']."!</p>";
					$_SESSION['lancamento'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusaos'] == "ok"){
					$erroConteudo = "<p class='erro'>Imóvel <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusaos'] = "";
					$_SESSION['nome'] = "";
				}
				
				if(isset($_POST['tipoFiltro'])){
					if($_POST['tipoFiltro'] != ""){
						$_SESSION['tipoFiltro'] = $_POST['tipoFiltro'];
					}else{
						$_SESSION['tipoFiltro'] = "";
					}
				}
				
				if($_SESSION['tipoFiltro'] != ""){
					$filtraTipo = " and codTipoImovel = '".$_SESSION['tipoFiltro']."'";
				}	
				
				if(isset($_POST['cidadeFiltro'])){
					if($_POST['cidadeFiltro'] != ""){
						$_SESSION['cidadeFiltro'] = $_POST['cidadeFiltro'];
					}else{
						$_SESSION['cidadeFiltro'] = "";
					}
				}
				
				if($_SESSION['cidadeFiltro'] != ""){
					$filtraCidade = " and codCidade = '".$_SESSION['cidadeFiltro']."'";
				}															
				
				if(isset($_POST['bairroFiltro'])){
					if($_POST['bairroFiltro'] != ""){
						$_SESSION['bairroFiltro'] = $_POST['bairroFiltro'];
					}else{
						$_SESSION['bairroFiltro'] = "";
					}
				}
				
				if($_SESSION['bairroFiltro'] != ""){
					$filtraBairro = " and codBairro = '".$_SESSION['bairroFiltro']."'";
				}															
				
				if(isset($_POST['quadraFiltro'])){
					if($_POST['quadraFiltro'] != ""){
						$_SESSION['quadraFiltro'] = $_POST['quadraFiltro'];
					}else{
						$_SESSION['quadraFiltro'] = "";
					}
				}
				
				if($_SESSION['quadraFiltro'] != ""){
					$filtraQuadra = " and quadraImovel = '".$_SESSION['quadraFiltro']."'";
				}															
				
				if(isset($_POST['loteFiltro'])){
					if($_POST['loteFiltro'] != ""){
						$_SESSION['loteFiltro'] = $_POST['loteFiltro'];
					}else{
						$_SESSION['loteFiltro'] = "";
					}
				}
				
				if($_SESSION['loteFiltro'] != ""){
					$filtraLote = " and loteImovel = '".$_SESSION['loteFiltro']."'";
				}															
				
				if(isset($_POST['tipoVendaFiltro'])){
					if($_POST['tipoVendaFiltro'] != ""){
						$_SESSION['tipoVendaFiltro'] = $_POST['tipoVendaFiltro'];
					}else{
						$_SESSION['tipoVendaFiltro'] = "";
					}
				}
				
				if($_SESSION['tipoVendaFiltro'] != ""){
					$filtraTipoVenda = " and tipoVendaImovel = '".$_SESSION['tipoVendaFiltro']."'";
				}				

				if(isset($_POST['corretorFiltro'])){
					if($_POST['corretorFiltro'] != ""){
						$_SESSION['corretorFiltro'] = $_POST['corretorFiltro'];
					}else{
						$_SESSION['corretorFiltro'] = "";
					}
				}
				
				if($_SESSION['corretorFiltro'] != ""){
					$filtraCorretor = " and codUsuario = '".$_SESSION['corretorFiltro']."'";
				}																							
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Imóveis</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
							<script type="text/javascript">
								function alteraFiltro(){
									document.getElementById("alteraFiltro").submit();
								}
							</script>
							<form id="alteraFiltro" action="<?php echo $configUrl;?>cadastros/imoveis/" method="post" >
								<p class="nome-clientes-filtro" style="width:291px;"><label class="label">Filtrar Código, Nome ou Endereço:</label>
								<input type="text" style="width:275px;" name="imoveis" onKeyUp="buscaAvancada();" id="busca" autocomplete="off" value="<?php echo $_SESSION['nome-imoveis-filtro'];?>" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />

								<p class="bloco-campo-float"><label>Filtrar Cidade: <span class="obrigatorio"> </span></label>
									<select class="campo" id="cidadeFiltro" name="cidadeFiltro" style="width:190px; padding:5.5px; margin-right:0px;" onChange="alteraFiltro();">
										<option value="">Todos</option>
<?php
				$sqlCidades = "SELECT nomeCidade, codCidade FROM cidades WHERE statusCidade = 'T' ORDER BY nomeCidade ASC";
				$resultCidades = $conn->query($sqlCidades);
				while($dadosCidades = $resultCidades->fetch_assoc()){
?>
										<option value="<?php echo $dadosCidades['codCidade'] ;?>" <?php echo $_SESSION['cidadeFiltro'] == $dadosCidades['codCidade'] ? '/SELECTED/' : '';?>><?php echo $dadosCidades['nomeCidade'] ;?></option>
<?php
}
?>					
									</select>
									<br class="clear"/>
								</p>

<?php
				if($_SESSION['cidadeFiltro'] == ""){
?>													
								<div id="sel-padrao-f">
									<p class="bloco-campo-float" style="width:189px;"><label>Filtrar Bairro: <span class="obrigatorio"> </span></label>
										<select id="default-usage-select" id="bairroFiltro" class="campo" name="bairroFiltro" style="width:190px; padding:5.5px;">
											<option id="option" value="">Todos</option>
											<option id="option" value="">Selecione uma cidade</option>
										</select>
										<br class="clear"/>
									</p>
								</div>
<?php
				}
?>													
								<div id="carrega-bairro-f">
<?php
				if($_SESSION['cidadeFiltro'] != ""){
?>
									<p class="bloco-campo-float" style="width:189px;"><label>Filtrar Bairro: <span class="obrigatorio"> </span></label>
										<select class="campo" name="bairroFiltro" style="width:190px; padding:5.5px;" id="bairroFiltro" onChange="alteraFiltro();">
											<option value="">Todos</option>

<?php
					$sqlBairro = "SELECT * FROM bairros WHERE statusBairro = 'T' and codCidade = ".$_SESSION['cidadeFiltro']." ORDER BY nomeBairro ASC";
					$resultBairro = $conn->query($sqlBairro);
					while($dadosBairro = $resultBairro->fetch_assoc()){			
?>
											<option value="<?php echo $dadosBairro['codBairro']; ?>" <?php echo $dadosBairro['codBairro'] == $_SESSION['bairroFiltro'] ? '/SELECTED/' : ''; ?>><?php echo $dadosBairro['nomeBairro']; ?></option>
<?php
					}
?>	
										</select>
									</p>
<?php
				}
?>
								</div>

								<p class="bloco-campo-float" style="width:130px;"><label>Filtrar Quadra: <span class="obrigatorio"> </span></label>
									<select class="campo" name="quadraFiltro" style="width:130px; padding:5.5px;" id="quadraFiltro" onChange="alteraFiltro();">
										<option value="">Todos</option>

<?php
					$sqlQuadra = "SELECT * FROM quadras ORDER BY (nomeQuadra REGEXP '^[0-9]+$') ASC, 
					             CASE WHEN nomeQuadra REGEXP '^[0-9]+$' THEN NULL ELSE nomeQuadra END ASC,
					             CASE WHEN nomeQuadra REGEXP '^[0-9]+$' THEN CAST(nomeQuadra AS UNSIGNED) END ASC";
					$resultQuadra = $conn->query($sqlQuadra);
					while($dadosQuadra = $resultQuadra->fetch_assoc()){			
?>
										<option value="<?php echo $dadosQuadra['codQuadra']; ?>" <?php echo $dadosQuadra['codQuadra'] == $_SESSION['quadraFiltro'] ? '/SELECTED/' : ''; ?>><?php echo $dadosQuadra['nomeQuadra']; ?></option>
<?php
					}
?>	
									</select>
								</p>

								<p class="bloco-campo-float" style="width:130px;"><label>Filtrar Lote: <span class="obrigatorio"> </span></label>
									<select class="campo" name="loteFiltro" style="width:130px; padding:5.5px;" id="loteFiltro" onChange="alteraFiltro();">
										<option value="">Todos</option>

<?php
					$sqlLote = "SELECT * FROM lotes ORDER BY (nomeLote REGEXP '^[A-Za-z]') DESC, 
					             CASE WHEN nomeLote REGEXP '^[A-Za-z]' THEN nomeLote END ASC, 
					             CASE WHEN nomeLote REGEXP '^[0-9]+$' THEN CAST(nomeLote AS UNSIGNED) END ASC";
					$resultLote = $conn->query($sqlLote);
					while($dadosLote = $resultLote->fetch_assoc()){			
?>
										<option value="<?php echo $dadosLote['codLote']; ?>" <?php echo $dadosLote['codLote'] == $_SESSION['loteFiltro'] ? '/SELECTED/' : ''; ?>><?php echo $dadosLote['nomeLote']; ?></option>
<?php
					}
?>	
									</select>
								</p>

								<p class="bloco-campo-float" style="margin-right:0px;"><label>Filtrar Tipo imóvel: <span class="obrigatorio"> </span></label>
									<select class="campo" id="tipoFiltro" name="tipoFiltro" style="width:155px; padding:5.5px;" onChange="alteraFiltro();">
										<option value="">Todos</option>
<?php
				$sqlTipoImovel = "SELECT * FROM tipoImovel WHERE statusTipoImovel = 'T' ORDER BY nomeTipoImovel ASC";
				$resultTipoImovel = $conn->query($sqlTipoImovel);
				while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){
?>
										<option value="<?php echo $dadosTipoImovel['codTipoImovel'] ;?>" <?php echo $_SESSION['tipoFiltro'] == $dadosTipoImovel['codTipoImovel'] ? '/SELECTED/' : '';?>><?php echo $dadosTipoImovel['nomeTipoImovel'] ;?></option>
<?php
				}
?>					
									</select>
									<br class="clear"/>
								</p>

								<p class="bloco-campo-float" style="margin-right:0px;"><label>Filtrar Tipo Venda: <span class="obrigatorio"> </span></label>
									<select class="campo" id="tipoVendaFiltro" name="tipoVendaFiltro" style="width:155px; padding:5.5px;" onChange="alteraFiltro();">
										<option value="">Todos</option>
										<option value="P" <?php echo $_SESSION['tipoVendaFiltro'] == "P" ? '/SELECTED/' : '';?> >Próprio</option>			
										<option value="A" <?php echo $_SESSION['tipoVendaFiltro'] == "A" ? '/SELECTED/' : '';?> >Agenciado</option>			
									</select>
								</p>

								<p class="bloco-campo-float" style="margin-right:0px;"><label>Filtrar Corretor: <span class="obrigatorio"> </span></label>
									<select class="campo" id="corretorFiltro" name="corretorFiltro" style="width:155px; padding:5.5px;" onChange="alteraFiltro();">
										<option value="">Todos</option>
<?php
				$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario != '' and codUsuario != 4 ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
										<option value="<?php echo $dadosUsuario['codUsuario'] ;?>" <?php echo $_SESSION['corretorFiltro'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
				}
?>					
									</select>
								</p>
								
								<div class="botao-novo" style="margin-top:17px; margin-left:0px;"><a title="Novo imóvel" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">Novo Imóvel</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px; margin-top:16px;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>						
						</div>
					</div>
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
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">			
						<div class="botao-novo" style="margin-left:0px; margin-top:-20px; margin-bottom:20px;"><a href="<?php echo $configUrlGer;?>cadastros/tipoImovel/1/"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Tipo Imóvel</div><div class="direita-novo"></div></a></div>
						<br class="clear"/>
<?php
				if($_POST['nome'] != ""){
							
					include ('f/conf/criaUrl.php');
					$urlImovel = criaUrl($_POST['nome']);					

					$sqlProprietario = "SELECT codProprietario FROM proprietarios WHERE nomeProprietario = '".$_POST['proprietarios']."' LIMIT 0,1";
					$resultProprietario = $conn->query($sqlProprietario);
					$dadosProprietario = $resultProprietario->fetch_assoc();

					$sqlCodigo = "SELECT * FROM imoveis WHERE  statusImovel = 'T' and  codigoImovel =  '".$_POST['codigo']."' LIMIT 0,1";
					$resultCodigo = $conn->query($sqlCodigo);
	
					
					if($dadosProprietario['codProprietario'] != "" && $resultCodigo->num_rows == 0 ){

						$descricao = str_replace("../../", $configUrlGer, $_POST['descricao']);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						$descricao = str_replace("../../", $configUrlGer, $descricao);
						
						$preco = $_POST['preco'];
						$preco = str_replace(".", "", $preco);
						$preco = str_replace(".", "", $preco);
						$preco = str_replace(",", ".", $preco);
						
						$precoC = $_POST['precoC'];
						$precoC = str_replace(".", "", $precoC);
						$precoC = str_replace(".", "", $precoC);
						$precoC = str_replace(",", ".", $precoC);

						$sqlUltimoImovel = "SELECT codOrdenacaoImovel FROM imoveis ORDER BY codOrdenacaoImovel DESC LIMIT 0,1";
						$resultUltimoImovel = $conn->query($sqlUltimoImovel);
						$dadosUltimoImovel = $resultUltimoImovel->fetch_assoc();
						
						$novoOrdem = $dadosUltimoImovel['codOrdenacaoImovel'] + 1;	

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
																									
					  	$sql = "INSERT INTO imoveis VALUES(0, '".date('Y-m-d')."', ".$novoOrdem.", '".$_POST['codigo']."', ".$_POST['usuario'].", ".$dadosProprietario['codProprietario'].", '".preparaNome($_POST['nome'])."', '".$preco."', '".$precoC."', '".$_POST['cidades']."', '".$_POST['bairro']."', '".$_POST['endereco']."', '".$_POST['nApartamento']."', '".$_POST['quadra']."', '".$lote."', '".$_POST['matricula']."', '".$quartos."', '".$banheiros."', '".$suite."', '".$garagem."', '".$metragem."', '".$metragemC."', '".$fundos."', '".$largura."','".$_POST['siglaMetragem']."', '".$_POST['frente']."', '".$_POST['posicao']."', '".$_POST['tipo']."', 'V', '".$_POST['tipo-venda']."', '".str_replace("'", "&#39;", $_POST['video'])."', '".str_replace("'", "&#39;", $_POST['mapa'])."', '".str_replace("'", "&#39;", $descricao)."', '".str_replace("'", "&#39;", $_POST['observacoes'])."', 'F', 'F', 'F', 'T', 'T', 0, '".$urlImovel."', '".date('Y-m-d H:i:s')."')";
						$result = $conn->query($sql);


						if($result == 1){
							
							$sqlProprietario = "UPDATE proprietarios SET celularProprietario = '".$_POST['numero']."' WHERE codProprietario = ".$dadosProprietario['codProprietario'];
							$resultProprietario = $conn->query($sqlProprietario);

							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							
							$sqlImovel = "SELECT * FROM imoveis ORDER BY codImovel DESC LIMIT 0,1";
							$resultImovel = $conn->query($sqlImovel);
							$dadosImovel = $resultImovel->fetch_assoc();

							if(isset($_POST["lote"])) {
								$optionArray = $_POST["lote"];
								for($i = 0; $i < count($optionArray); $i++){
									$sql = "INSERT INTO imoveisLotes VALUES(0, '".$dadosImovel['codImovel']."', '".$optionArray[$i]."')";
									$sql;
									$result = $conn->query($sql);						
								}
							}

							for($i=1; $i<=$_POST['quantas']; $i++){
								if($_POST['caracteristica'.$i] != ""){
									$sqlInsere = "INSERT INTO caracteristicasImoveis VALUES(0, ".$_POST['caracteristica'.$i].", ".$dadosImovel['codImovel'].")";
									$resultInsere = $conn->query($sqlInsere);
								}
							}
														
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/imoveis/imagens/".$dadosImovel['codImovel']."/'>";
						}else{
							$erroData = "<p class='erro'>Problemas ao cadastrar Imóvel!</p>";
						}
					}else{

						if($dadosProprietario['codProprietario'] == ""){
							$erroData = "<p class='erro'>Digite um o nome do!</p>";
						}else{
							$erroData = "<p class='erro'>Codigo já cadastrado!</p>";
						}
						
						$_SESSION['proprietarios'] = "";
						$_SESSION['codigo'] = $_POST['codigo'];
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['usuario'] = $_POST['usuario'];
						$_SESSION['preco'] = $_POST['preco'];
						$_SESSION['precoC'] = $_POST['precoC'];
						$_SESSION['cidades'] = $_POST['cidades'];
						$_SESSION['bairros'] = $_POST['bairro'];
						$_SESSION['endereco'] = $_POST['endereco'];
						$_SESSION['nApartamento'] = $_POST['nApartamento'];
						$_SESSION['quadra'] = $_POST['quadra'];
						$_SESSION['lote'] = $_POST['lote'];
						$_SESSION['matricula'] = $_POST['matricula'];
						$_SESSION['quartos'] = $_POST['quartos'];
						$_SESSION['banheiros'] = $_POST['banheiros'];
						$_SESSION['suite'] = $_POST['suite'];
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
					$_SESSION['proprietarios'] = "";
					$_SESSION['codigo'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['usuario'] = "";
					$_SESSION['preco'] = "";
					$_SESSION['precoC'] = "";
					$_SESSION['cidades'] = "";
					$_SESSION['bairros'] = "";
					$_SESSION['endereco'] = "";
					$_SESSION['nApartamento'] = "";
					$_SESSION['quadra'] = "";
					$_SESSION['lote'] = "";
					$_SESSION['matricula'] = "";
					$_SESSION['quartos'] = "";
					$_SESSION['banheiros'] = "";
					$_SESSION['suite'] = "";
					$_SESSION['garagem'] = "";
					$_SESSION['metragem'] = "";
					$_SESSION['metragemC'] = "";
					$_SESSION['fundos'] = "";
					$_SESSION['largura'] = "";
					$_SESSION['frente'] = "";
					$_SESSION['posicao'] = "";
					$_SESSION['tipo'] = "";
					$_SESSION['tipoc'] = "";
					$_SESSION['tipo-venda'] = "";
					$_SESSION['video'] = "";
					$_SESSION['mapa'] = "";
					$_SESSION['descricao'] = "";
					$_SESSION['observacoes'] = "";
					$_SESSION['siglaMetragem'] = "";

					function somarComZerosAEsquerda(string $numero1, string $numero2): string{
						$numero1Int = (int)$numero1;
						$numero2Int = (int)$numero2;

						$soma = $numero1Int + $numero2Int;
						$somaFormatada = sprintf('%04d', $soma);

						return $somaFormatada;
					}	
										
					$sqlCodigo = "SELECT * FROM imoveis WHERE statusImovel = 'T' ORDER BY codImovel DESC LIMIT 0,1";
					$resultCodigo = $conn->query($sqlCodigo);
					$dadosCodigo = $resultCodigo->fetch_assoc();
					
					if($dadosCodigo['codImovel'] != ""){
						
						$montaCodigo = somarComZerosAEsquerda($dadosCodigo['codigoImovel'], 0001);						
						
					}else{
						
						$montaCodigo = "0001";														
					}				
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
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<p style="color:#718B8F; font-weight:bold;">* Campos neste formato aparecerão no site</p>
						<p style="color:#718B8F;">* Campos neste formato não aparecerão no site</p>
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
						<form id="formulario" name="formImovel" action="<?php echo $configUrlGer; ?>cadastros/imoveis/" method="post">
							<input type="hidden" id="tipoEnvio" name="tipoEnvio" value="" />

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
								<select class="campo" id="tipo" name="tipo" style="width:150px; height:32px;" required onChange="exibeCamposTipo(this.value);">
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
							<input class="campo" type="text" id="codigo" name="codigo" style="width:80px;" required value="<?php echo $montaCodigo;?>" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer);"/></p>
						
							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="usuario" name="usuario" style="width:150px; height:32px;" required>
									<option value="">Selecione</option>
<?php
				$sqlUsuarios = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4".$filtraUsuario." ORDER BY nomeUsuario ASC";
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
								<p class="bloco-campo" style="margin-bottom:0px;"><label>Proprietário: <span class="obrigatorio">*</span></label>
								<input class="campo" type="text" name="proprietarios" required style="width:200px;" value="<?php echo $_SESSION['proprietarios']; ?>" onClick="auto_complete(this.value, 'proprietarios_c', event); setTimeout(buscarProprietario, 200);" onKeyUp="auto_complete(this.value, 'proprietarios_c', event); setTimeout(buscarProprietario, 200); " onkeydown="if (getKey(event) == 13) return false;" onBlur="fechaAutoComplete('proprietarios_c'); setTimeout(buscarProprietario, 200);" autocomplete="off" id="busca_autocomplete_softbest_proprietarios_c" /></p>
								
								<div id="exibe_busca_autocomplete_softbest_proprietarios_c" class="auto_complete_softbest" style="display:none;">

								</div>
							</div>
							<script>
								function buscarProprietario() {
									var valor = document.getElementById("busca_autocomplete_softbest_proprietarios_c").value;

									if (valor.trim() === "") {
										document.getElementById("numero").value = "";
										return;
									}

									const url = "<?php echo $configUrlGer.'cadastros/imoveis/verifica_numero.php' ?>?proprietario=" + encodeURIComponent(valor);

									fetch(url)
										.then(response => response.text())
										.then(data => {
											document.getElementById("numero").value = data.trim();
										})
										.catch(error => {
											console.error("Erro na requisição:", error);
										});
								}
							</script>


							<p class="bloco-campo-float"><label>Número: <span class="obrigatorio">*</span></label>
							<input class="campo" type="text" id="numero" name="numero" style="width:150px;" value="" required  onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);" /></p>

							<p class="bloco-campo-float"><label>Preço Custo: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="precoC" name="precoC" style="width:90px;" onKeyUp="moeda(this);" value="<?php echo $_SESSION['precoC']; ?>" /></p>
					
							<p class="bloco-campo-float"><label>Preço Venda: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="preco" name="preco" style="width:90px;" onKeyUp="moeda(this);" value="<?php echo $_SESSION['preco']; ?>" /></p>

							<br class="clear" />

							<p class="bloco-campo-float"><label>Título do Anúncio: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="nome" name="nome" style="width:230px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>

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
								<select class="campo" id="cidades" name="cidades" style="width:200px;" required onChange="carregaBairro(this.value);">
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
									<select id="default-usage-select" id="bairro" class="campo" name="bairro" style="width:230px;">
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
									<select class="campo" name="bairro" style="width:230px;" id="bairro" required onChange="carregaQuadra();">
										<option value="" style="color:#FFF;">Selecione</option>

<?php
					$sqlBairro = "SELECT * FROM bairros WHERE statusBairro = 'T' and codCidade = ".$_SESSION['cidades']." ORDER BY nomeBairro ASC";
					$resultBairro = $conn->query($sqlBairro);
					while($dadosBairro = $resultBairro->fetch_assoc()){			
?>
										<option value="<?php echo $dadosBairro['codBairro']; ?>" <?php echo $dadosBairro['codBairro'] == $_SESSION['bairros'] ? '/SELECTED/' : ''; ?>><?php echo $dadosBairro['nomeBairro']; ?></option>
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
<?php
				if($_SESSION['quadra'] != ""){
?>							
							<p class="bloco-campo-float"><label>Quadra: <span class="obrigatorio"> * </span></label>
								<select class="selectQuadra form-control campo" id="idSelectQuadra" name="quadra" style="width:150px; display: none;">
									<optgroup label="Selecione">
<?php
				$sqlQuadrasLista = "SELECT * FROM quadras ORDER BY codQuadra ASC";
				$resultQuadrasLista = $conn->query($sqlQuadrasLista);
				while($dadosQuadrasLista = $resultQuadrasLista->fetch_assoc()){				
?>
									<option value="<?php echo trim($dadosQuadrasLista['nomeQuadra']);?>" <?php echo trim($dadosQuadrasLista['nomeQuadra']) == $_SESSION['quadra'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosQuadrasLista['nomeQuadra']);?></option>	
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
							<div id="carrega-quadras">
								<p class="bloco-campo-float"><label>Quadra: <span class="obrigatorio"> * </span></label>
									<select class="selectQuadra form-control campo" id="idSelectQuadra" name="lote" multiple="" style="width:140px; display: none;">
										<optgroup label="Selecione">
									</select>										
								</p>
							</div>

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
							<div id="carrega-lotes">
<?php
				if($_SESSION['lote'] != ""){
					
					$codCidade = $_SESSION['cidades'];
					$codBairro = $_SESSION['bairro'];
					$quadraImovel = $_SESSION['quadra'];					
?>
								<p class="bloco-campo-float"><label>Lote(s): <span class="obrigatorio"> * </span></label>
									<select class="selectLote form-control campo" id="idSelectLote" name="lote[]" multiple="" style="width:140px; display: none;">
										<optgroup label="Selecione">
<?php
				$sqlLotesLista = "SELECT * FROM lotes ORDER BY codLote ASC";
				$resultLotesLista = $conn->query($sqlLotesLista);
				while($dadosLotesLista = $resultLotesLista->fetch_assoc()){
					
					$sqlImovel = "SELECT * FROM imoveis I inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$quadraImovel."' and I.loteImovel = ".trim($dadosLotesLista['nomeLote'])." GROUP BY I.codImovel ORDER BY I.codImovel DESC LIMIT 0,1";
					$resultImovel = $conn->query($sqlImovel);
					$dadosImovel = $resultImovel->fetch_assoc();

					$nomeCorretor = explode(" ", $dadosImovel['nomeUsuario']);

					$optionArray = $_SESSION['lote'];
					for($i = 0; $i < count($optionArray); $i++){
						if($optionArray[$i] == $dadosLotesLista['nomeLote']){
							$loteOk = "sim";
						}else{
							$loteOk = "";
						}
					}
																	
					if($dadosImovel['codImovel'] == ""){
						
						$sqlImovel = "SELECT * FROM imoveisLotes IL inner join imoveis I on IL.codImovel = I.codImovel inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$quadraImovel."' and IL.nomeLote = ".trim($dadosLotesLista['nomeLote'])." GROUP BY IL.codImovelLote ORDER BY I.codImovel DESC LIMIT 0,1";
						$resultImovel = $conn->query($sqlImovel);
						$dadosImovel = $resultImovel->fetch_assoc();
						
						$nomeCorretor = explode(" ", $dadosImovel['nomeUsuario']);
						
						if($dadosImovel['codImovel'] == ""){
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
										<option class="<?php echo $classColor;?>" value="<?php echo trim($dadosLotesLista['nomeLote']);?>" <?php echo $loteOk == "sim" ? '/SELECTED/' : '';?> <?php echo $disabled;?> ><?php echo trim($dadosLotesLista['nomeLote']).$corretor;?></option>	
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
									<select class="selectLote form-control campo" id="idSelectLote" name="lote[]" multiple="" style="width:140px; display: none;">
										<optgroup label="Selecione">
									</select>										
								</p>
<?php
				}
?>
							</div>	
							
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

							<br class="clear"/>

							<p class="bloco-campo-float coloca retira 6"><label>Quartos: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="quartos" name="quartos" style="width:70px;" value="<?php echo $_SESSION['quartos']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6"><label>Suítes: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="suite" name="suite" style="width:70px;" value="<?php echo $_SESSION['suite']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6"><label>Banheiros: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="banheiros" name="banheiros" style="width:80px;" value="<?php echo $_SESSION['banheiros']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6"><label>Garagem: <span class="obrigatorio"> </span></label>
							<input class="campo" type="number" id="garagem" name="garagem" style="width:90px;" value="<?php echo $_SESSION['garagem']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 5 6"><label>Posição Solar: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="posicao" name="posicao" style="width:102px;" value="<?php echo $_SESSION['posicao']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 6"><label>Área Construída: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="metragemC" name="metragemC" style="width:130px;" value="<?php echo $_SESSION['metragemC']; ?>" /></p>
							
							<p class="bloco-campo-float coloca retira 5 6"><label>Frente: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="frente" name="frente" style="width:60px;" value="<?php echo $_SESSION['frente']; ?>" onKeyup="calculaArea();" /></p>
							
							<p class="bloco-campo-float coloca retira 5"><label>Fundos: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="fundos" name="fundos" style="width:70px;" value="<?php echo $_SESSION['fundos']; ?>" onKeyup="calculaArea();" /></p>

							<p class="bloco-campo-float coloca retira 5"><label>Área Terreno: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="metragem" name="metragem" style="width:100px;" value="<?php echo $_SESSION['metragem']; ?>" /></p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label>Sigla Área: <span class="obrigatorio"> </span></label>
							<label style="font-weight:normal; font-size:14px; float:left; margin-top:10px; margin-right:20px;"><input type="radio" id="siglaMetragem" name="siglaMetragem" <?php echo $_SESSION['siglaMetragem'] == "m²" ? 'checked' : '';?> <?php echo $_SESSION['siglaMetragem'] == "" ? 'checked' : '';?> value="m²"/> m²</label> <label style="font-weight:normal; font-size:14px; float:left; margin-top:10px;"><input type="radio" <?php echo $_SESSION['siglaMetragem'] == "ha" ? 'checked' : '';?> id="siglaMetragem2" name="siglaMetragem" value="ha"/> ha</label><br class="clear"/></p>
							
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
							<input class="campo" type="text" id="precoC" name="precoC" style="width:120px;" onKeyUp="moeda(this);" value="<?php echo $_SESSION['precoC']; ?>" /></p>

							<p class="bloco-campo-float coloca retira 5 6"><label style="font-weight:normal;">Endereço: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="endereco" name="endereco" style="width:300px;" value="<?php echo $_SESSION['endereco']; ?>" /></p>

							<p class="bloco-campo-float retira 6"><label style="font-weight:normal;">Nº do Apartamento: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="nApartamento" id="nApartamento" name="nApartamento" style="width:130px;" value="<?php echo $_SESSION['nApartamento']; ?>" /></p>
														
							<p class="bloco-campo-float coloca retira 5 6"><label style="font-weight:normal;">Matrícula: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="matricula" name="matricula" style="width:100px;" value="<?php echo $_SESSION['matricula']; ?>" /></p>

							<p class="bloco-campo-float"><label style="font-weight:normal;">Tipo Venda: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo-venda" name="tipo-venda" style="width:242px; height:32px;" required>
									<option value="">Selecione</option>
									<option value="P" <?php echo $_SESSION['tipo-venda'] == "P" ? '/SELECTED/' : '';?> >Próprio</option>
									<option value="A" <?php echo $_SESSION['tipo-venda'] == "A" ? '/SELECTED/' : '';?> >Agenciado</option>
								</select>
								<br class="clear"/>
							</p>

							<br class="clear"/>
							
							<p class="bloco-campo-float"><label>Link do Vídeo (Youtube): <span class="em" style="font-weight:normal;"> EX: https://www.youtube.com/watch?v=VKtTSoC7o2I</span></label>
							<input class="campo" type="text" id="video" name="video" style="width:980px;" value="<?php echo $_SESSION['video']; ?>" /></p>

							<br class="clear"/>

							<div class="bloco-campo" style="margin-bottom:25px;"><label>Características:<span class="obrigatorio"> </span></label><br/>
<?php
				$cont = 0;
				$contTodas = 0;
				
				$sqlCaracteristicas = "SELECT * FROM caracteristicas WHERE statusCaracteristica = 'T' ORDER BY codOrdenacaoCaracteristica ASC";
				$resultOpcionais = $conn->query($sqlCaracteristicas);
				while($dadosOpcionais = $resultOpcionais->fetch_assoc()){
				
					$cont++;
					$contTodas++;
?>				
								<label style="font-weight:normal; float:left; width:200px; height:30px; cursor:pointer; font-size:14px;"><input type="checkbox" style="cursor:pointer;" value="<?php echo $dadosOpcionais['codCaracteristica'];?>" name="caracteristica<?php echo $contTodas;?>"/> <?php echo $dadosOpcionais['nomeCaracteristica'];?></label>

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
							
							<p class="bloco-campo" style="width:995px; margin-top:-20px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text"><?php echo $_SESSION['descricao']; ?></textarea></p>
							
							<p class="bloco-campo"><label style="font-weight:normal;">Observações:<span class="obrigatorio"> </span></label>
							<textarea class="desabilita campo" id="observacoes" name="observacoes" type="text" style="width:980px; height:150px;" ><?php echo $_SESSION['observacoes']; ?></textarea></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Imóvel" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
?>
						<script type="text/javascript">
							function buscaAvancada(){
								var $AGD = jQuery.noConflict();
								var busca = $AGD("#busca").val();
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								$AGD("#busca-carregada").load("<?php echo $configUrl;?>cadastros/imoveis/busca-imovel.php?busca="+busca);
								if(busca == ""){
									document.getElementById("paginacao").style.display="block";
								}else{
									document.getElementById("paginacao").style.display="none";
								}
							}	
						</script>
						<div id="busca-carregada">
<?php
	$sqlConta = "SELECT nomeImovel FROM imoveis WHERE codImovel !=''".$filtraCidade.$filtraBairro.$filtraTipo.$filtraTipoVenda.$filtraCorretor.$filtraQuadra.$filtraLote."";
	$resultConta = $conn->query($sqlConta);
	$dadosConta = $resultConta->fetch_assoc();
	$registros = mysqli_num_rows($resultConta);
	
	if($dadosConta['nomeImovel'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Código</th>
									<th>Título do Anúncio</th>
									<th>Tipo imóvel</th>
									<th>Bairro / Cidade</th>
									<th>Lote / Quadra</th>
									<th>Preço</th>
									<th>Ordenar</th>
									<th>Capa</th>
									<th>Destaques</th>
									<th>Status</th>
									<th>Imagens</th>
									<th>Anexos</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
		function verificarCor($dataImovel) {
			$dataImovel = new DateTime($dataImovel);
			$hoje = new DateTime();
			$intervalo = $dataImovel->diff($hoje);
			$meses = $intervalo->y * 12 + $intervalo->m;

			if ($meses < 3) {
				return "background:rgb(0, 128, 0); color:#FFF;"; // Verde
			} elseif ($meses >= 3 && $meses < 6) {
				return "background:rgb(205, 220, 57);"; // Amarelo
			} elseif ($meses >= 6 && $meses < 12) {
				return "background:rgb(243, 157, 0);"; // Laranja
			} else {
				return "background:rgb(255, 0, 0); color:#FFF;"; // Vermelho
			}
		}

		if($url[5] == 1 || $url[5] == ""){
			$pagina = 1;
			$sqlImovel = "SELECT * FROM imoveis WHERE codImovel !=''".$filtraCidade.$filtraBairro.$filtraTipo.$filtraTipoVenda.$filtraCorretor.$filtraQuadra.$filtraLote." ORDER BY statusImovel ASC, capaImovel ASC, codOrdenacaoImovel DESC, destaqueImovel ASC, codImovel DESC LIMIT 0,30";
		}else{
			$pagina = $url[5];
			$paginaFinal = $pagina * 30;
			$paginaInicial = $paginaFinal - 30;
			$sqlImovel = "SELECT * FROM imoveis WHERE codImovel !=''".$filtraCidade.$filtraBairro.$filtraTipo.$filtraTipoVenda.$filtraCorretor.$filtraQuadra.$filtraLote." ORDER BY statusImovel ASC, capaImovel ASC, codOrdenacaoImovel DESC, destaqueImovel ASC, codImovel DESC LIMIT ".$paginaInicial.",30";
		}		
		
	$resultImovel = $conn->query($sqlImovel);
	while($dadosImovel = $resultImovel->fetch_assoc()){
		$mostrando = $mostrando + 1;
				
		if($dadosImovel['statusImovel'] == "T"){
			$status = "status-ativo";
			$statusIcone = "ativado";
			$statusPergunta = "desativar";
		}else{
			$status = "status-desativado";
			$statusIcone = "desativado";
			$statusPergunta = "ativar";
		}					

		if($dadosImovel['capaImovel'] == "T"){
			$capa = "capa-ativo";
			$capaIcone = "ativado";
			$capaPergunta = "não destaque o imóvel ";
		}else{
			$capa = "capa-desativado";
			$statusIcone = "desativado";
			$capaPergunta = "destaque o imóvel";
		}	
		
		if($dadosImovel['destaqueImovel'] == "T"){
			$destaque = "destaque-ativado";
			$destaqueIcone = "ativado";
			$destaquePergunta = "retirar o imóvel ";
		}else{
			$destaque = "destaque-desativado";
			$destaqueIcone = "desativado";
			$destaquePergunta = "colocar o ";
		}	
		
		if($dadosImovel['lancamentoImovel'] == "T"){
			$lancamento = "lancamento-ativado";
			$lancamentoIcone = "ativado";
			$lancamentoPergunta = "retirar o imóvel ";
		}else{
			$lancamento = "lancamento-desativado";
			$lancamentoIcone = "desativado";
			$lancamentoPergunta = "colocar o ";
		}	
		
		if($dadosImovel['tipoCImovel'] == 'V'){
			$comercial = "Venda";
		}else{
			$comercial = "Aluguel";
		}
				
		$sqlCidade = "SELECT * FROM cidades WHERE statusCidade = 'T' and codCidade = ".$dadosImovel['codCidade']." and codCidade = ".$dadosImovel['codCidade']." ORDER BY codCidade DESC LIMIT 0,1";
		$resultCidade = $conn->query($sqlCidade);
		$dadosCidade = $resultCidade->fetch_assoc();
		
		$sqlBairro = "SELECT * FROM bairros WHERE statusBairro = 'T' and codBairro = ".$dadosImovel['codBairro']." ORDER BY codBairro DESC LIMIT 0,1";
		$resultBairro = $conn->query($sqlBairro);
		$dadosBairro = $resultBairro->fetch_assoc();
		
		$sqlTipo = "SELECT * FROM tipoImovel WHERE statusTipoImovel = 'T' and codTipoImovel = ".$dadosImovel['codTipoImovel']." ORDER BY codTipoImovel DESC LIMIT 0,1";
		$resultTipo = $conn->query($sqlTipo);
		$dadosTipo = $resultTipo->fetch_assoc();
		
		$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosImovel['codUsuario']." LIMIT 0,1";
		$resultUsuario = $conn->query($sqlUsuario);
		$dadosUsuario = $resultUsuario->fetch_assoc();

		$sqlImagem = "SELECT * FROM imoveisImagens WHERE codImovel = ".$dadosImovel['codImovel']." ORDER BY ordenacaoImovelImagem ASC LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();
		
		if($filtraUsuario == ""){						
?>
								<tr class="tr">
									<td class="dez" style="width:8%; text-align:center; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>"><a style="padding:0px; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['codigoImovel'];?><br/><span style="font-weight:bold; font-size:11px;"><?php echo $dadosUsuario['nomeUsuario'];?></span><br/><span style="font-size:10px; line-height:13px; display:block;"><?php echo date('d/m/Y', strtotime(substr($dadosImovel['alteracaoImovel'], 0, 10))); ?></span></a></td>
									<td class="trinta" style="text-align:left;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['nomeImovel'];?></a></td>
									<td class="dez" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosTipo['nomeTipoImovel'];?><br/><?php echo $comercial;?></a></td>
									<td class="trinta" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosBairro['nomeBairro'];?><br/><?php echo $dadosCidade['nomeCidade'];?></a></td>
									<td class="vinte" style="width:10%; text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>Quadra: <?php echo $dadosImovel['quadraImovel'];?><br/>Lote: <?php echo $dadosImovel['loteImovel'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>R$ <?php echo number_format($dadosImovel['precoImovel'], 2, ",", ".");?></a></td>
<?php
			if($dadosImovel['capaImovel'] == "T"){
?>
									<td class="dez" style="text-align:center;"><input type="number" class="campo" style="width:30px; text-align:center; border:1px solid #0000FF; outline:none;" value="<?php echo $dadosImovel['codOrdenacaoImovel'];?>" onClick="alteraCor(<?php echo $dadosImovel['codImovel'];?>);" onBlur="alteraOrdem(<?php echo $dadosImovel['codImovel'];?>, this.value);" id="codOrdena<?php echo $dadosImovel['codImovel'];?>"/></td>
<?php
			}else{
?>									  
									<td class="vinte" style="width:10%; padding:0px; text-align:center;">--</td>
<?php
			}
?>

									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/capa/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja <?php echo $capaPergunta ?> <?php echo $dadosImovel['nomeImovel'] ?> na capa do site?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $capa ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/destaque/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja <?php echo $destaquePergunta ?> <?php echo $dadosImovel['nomeImovel'] ?> do site ?' ><img src="<?php echo $configUrl; ?>f/i/<?php echo $destaque ?>.png" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/ativacao/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja <?php echo $statusPergunta ?> o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/imagens/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja gerenciar imagens do imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img style="<?php echo $dadosImagem['codImovelImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/imoveis/'.$dadosImagem['codImovel'].'-'.$dadosImagem['codImovelImagem'].'-W.webp';?>" height="50"/><img style="<?php echo $dadosImagem['codImovelImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/imoveis/anexos/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja cadastrar anexos para o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja alterar o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='javascript: confirmaExclusao(<?php echo $dadosImovel['codImovel'] ?>, "<?php echo htmlspecialchars($dadosImovel['nomeImovel']) ?>");' title='Deseja excluir o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
		}else{
			if($_COOKIE['codAprovado'.$cookie] == $dadosImovel['codUsuario']){
?>
								<tr class="tr">
									<td class="dez" style="width:8%; text-align:center; font-weight:bold; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>"><a style="padding:0px; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['codigoImovel'];?></a></td>
									<td class="trinta" style="text-align:left;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['nomeImovel'];?></a></td>
									<td class="dez" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosTipo['nomeTipoImovel'];?><br/><?php echo $comercial;?></a></td>
									<td class="trinta" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosBairro['nomeBairro'];?><br/><?php echo $dadosCidade['nomeCidade'];?></a></td>
									<td class="vinte" style="width:10%; text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>Quadra: <?php echo $dadosImovel['quadraImovel'];?><br/>Lote: <?php echo $dadosImovel['loteImovel'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>R$ <?php echo number_format($dadosImovel['precoImovel'], 2, ",", ".");?></a></td>
									<td class="dez" style="width:10%; padding:0px; text-align:center;">--</td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;"><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $capa ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;"><img src="<?php echo $configUrl; ?>f/i/<?php echo $destaque ?>.png" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/ativacao/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja <?php echo $statusPergunta ?> o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/imagens/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja gerenciar imagens do imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img style="<?php echo $dadosImagem['codImovelImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/imoveis/'.$dadosImagem['codImovel'].'-'.$dadosImagem['codImovelImagem'].'-W.webp';?>" height="50"/><img style="<?php echo $dadosImagem['codImovelImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/imoveis/anexos/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja cadastrar anexos para o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja alterar o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='javascript: confirmaExclusao(<?php echo $dadosImovel['codImovel'] ?>, "<?php echo htmlspecialchars($dadosImovel['nomeImovel']) ?>");' title='Deseja excluir o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
			}else{
?>
								<tr class="tr">
									<td class="dez" style="width:8%; text-align:center; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>"><a style="padding:0px; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['codigoImovel'];?></a></td>
									<td class="trinta" style="text-align:left;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['nomeImovel'];?></a></td>
									<td class="dez" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosTipo['nomeTipoImovel'];?><br/><?php echo $comercial;?></a></td>
									<td class="trinta" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosBairro['nomeBairro'];?><br/><?php echo $dadosCidade['nomeCidade'];?></a></td>
									<td class="vinte" style="width:10%; text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>Quadra: <?php echo $dadosImovel['quadraImovel'];?><br/>Lote: <?php echo $dadosImovel['loteImovel'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>R$ <?php echo number_format($dadosImovel['precoImovel'], 2, ",", ".");?></a></td>
									<td class="vinte" style="width:10%; padding:0px; text-align:center;">--</td>
									<td class="botoes" style="width:5%;"><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $capa ?>.gif" alt="icone"></td>
									<td class="botoes" style="width:5%;"><img src="<?php echo $configUrl; ?>f/i/<?php echo $destaque ?>.png" alt="icone"></td>
									<td class="botoes" style="width:5%;"><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></td>
									<td class="botoes" style="width:5%;"><img style="<?php echo $dadosImagem['codImovelImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/imoveis/'.$dadosImagem['codImovel'].'-'.$dadosImagem['codImovelImagem'].'-W.webp';?>" height="50"/><img style="<?php echo $dadosImagem['codImovelImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></td>
									<td class="botoes"><a><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja alterar o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="dez" style="width:5%; text-align:center;">--</td>
								</tr>
<?php			
			
			}
		}	
	}
?>
								<script type="text/javascript">
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o imóvel "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/imoveis/excluir/'+cod+'/';
										}
									}

									function alteraCor(cod){
										var $po2 = jQuery.noConflict();
										$po2("#codOrdena"+cod).css("border", "1px solid #FF0000");
									}

									function alteraOrdem(cod, ordem){
										var $po = jQuery.noConflict();
										$po.post("<?php echo $configUrlGer;?>cadastros/imoveis/ordem.php", {codImovel: cod, codOrdenacaoImovel: ordem}, function(data){		
											$po("#codOrdena"+cod).css("border", "1px solid #0000FF");
										});											
									}
								</script> 
							</table>
						</div>		
<?php
}
		$regPorPagina = 30;
		$area = "cadastros/imoveis";
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
