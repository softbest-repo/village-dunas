<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "banners";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Banner Capa <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Banner Capa <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nomeAlt'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Banner Capa <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Banner Capa <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}			
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Site</p>
						<p class="flexa"></p>
						<p class="nome-lista">Banners Capa</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>site/banners/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Banner Capa" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Banner Capa</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar'])){
					
					include ('f/conf/criaUrl.php');
					$urlBanner = criaUrl($_POST['nome']);

					$sqlUltimoBanner = "SELECT codOrdenacaoBanner FROM banners ORDER BY codOrdenacaoBanner DESC LIMIT 0,1";
					$resultUltimoBanner = $conn->query($sqlUltimoBanner);
					$dadosUltimoBanner = $resultUltimoBanner->fetch_assoc();
					
					$novoOrdem = $dadosUltimoBanner['codOrdenacaoBanner'] + 1;	

					$sql = "INSERT INTO banners VALUES(0, ".$novoOrdem.", '".preparaNome($_POST['nome'])."', '".$_POST['titulo']."', '".$_POST['descricao']."', '".$_POST['texto']."', '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $_POST['link']))."', '".$_POST['novaAba']."', 'T', '".$urlBanner."')";
					$result = $conn->query($sql);
					
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."site/banners/'>";
						}else{
							$erroData = "<p class='erro'>Banner Capa <strong>".$_POST['nome']."</strong> cadastrado com sucesso!</p>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar banner capa!</p>";
					}
				
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['texto'] = "";
					$_SESSION['descricao'] = "";
					$_SESSION['texto'] = "";
					$_SESSION['link'] = "";
					$_SESSION['novaAba'] = "";
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
						<form action="<?php echo $configUrlGer; ?>site/banners/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:400px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<p class="bloco-campo"><label>Título: <span class="em" style="font-weight:normal;"> Ex: Balneário Gaivota...</span></label>
							<input class="campo" type="text" name="titulo" style="width:400px;" value="<?php echo $_SESSION['titulo']; ?>" /></p>
							
							<p class="bloco-campo"><label>Link: <span class="em" style="font-weight:normal;"> Ex: http://www.softbest.com.br</span></label>
							<input class="campo" type="text" name="link" style="width:400px;" value="<?php echo $_SESSION['link']; ?>" /></p>

							<p class="bloco-campo"><label>Abrir link em nova aba:</label>
							<label style="float:left; font-weight:normal; margin-right:20px;"><input class="campo" type="radio" name="novaAba" value="N" <?php echo $_SESSION['novaAba'] == "N" || $_SESSION['novaAba'] == "" ? 'checked' : '';?>/> Não</label>
							<label style="float:left; font-weight:normal;"><input class="campo" type="radio" name="novaAba" value="S" <?php echo $_SESSION['novaAba'] == "S" ? 'checked' : '';?>/> Sim</label></p>							 
							<br class="clear"/>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Banner Capa" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT nomeBanner FROM banners WHERE codBanner != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeBanner'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Ordena</th>
								<th>Nome</th>
								<th>Imagens</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>
							<tbody id="tabela-itens">		
<?php
					$sqlBanner = "SELECT * FROM banners ORDER BY statusBanner ASC, codOrdenacaoBanner ASC, codBanner DESC";
					$resultBanner = $conn->query($sqlBanner);
					while($dadosBanner = $resultBanner->fetch_assoc()){
						
						if($dadosBanner['statusBanner'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}	

						$sqlImagem = "SELECT * FROM bannersImagens WHERE codBanner = ".$dadosBanner['codBanner']." ORDER BY codBannerImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();								
?>
								<tr class="tr">
									<td class="dez handle" style="width:5%; text-align:center; cursor:move;"><a style="text-decoration:none; font-size:22px;" title='Arraste para ordenar'>⇅ <input type="hidden" name="codBanner" value="<?php echo $dadosBanner['codBanner'];?>"/></a></td> 
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>site/banners/alterar/<?php echo $dadosBanner['codBanner'] ?>/' title='Veja os detalhes do banner capa <?php echo $dadosBanner['nomeBanner'] ?>'><?php echo $dadosBanner['nomeBanner'];?></a></td> 
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>site/banners/imagens/<?php echo $dadosBanner['codBanner'] ?>/' title='Deseja gerenciar imagens do banner <?php echo $dadosBanner['nomeBanner'] ?>?' ><img style="<?php echo $dadosImagem['codBannerImagem'] == "" ? 'display:none;' : 'padding-top:18px;';?>" src="<?php echo $configUrlGer.'f/banners/'.$dadosImagem['codBanner'].'-'.$dadosImagem['codBannerImagem'].'-W.webp';?>" height="30"/><img style="<?php echo $dadosImagem['codBannerImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>site/banners/ativacao/<?php echo $dadosBanner['codBanner'] ?>/' title='Deseja <?php echo $statusPergunta ?> o banner capa <?php echo $dadosBanner['nomeBanner'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>site/banners/alterar/<?php echo $dadosBanner['codBanner'] ?>/' title='Deseja alterar o banner capa <?php echo $dadosBanner['nomeBanner'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosBanner['codBanner'] ?>, "<?php echo htmlspecialchars($dadosBanner['nomeBanner']) ?>");' title='Deseja excluir o banner capa <?php echo $dadosBanner['nomeBanner'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>								 
							</tbody>					 
						</table>	
						<script type="text/javascript">
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o banner capa "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>site/banners/excluir/'+cod+'/';
								}
							}
																
							$tgb = jQuery.noConflict();
							const dragArea = document.querySelector("#tabela-itens");
							new Sortable(dragArea, {
								animation: 350,
								filter: '.disabled',
								handle: '.handle',
								onEnd: function(e) {
									var allinputs = document.querySelectorAll('input[name="codBanner"]');
									var myLength = allinputs.length;
									var cont = 0;
									for (i = 0; i < myLength; i++) {
										cont++;
										$tgb.post("<?php echo $configUrlGer;?>site/banners/ordena.php", {codBanner: allinputs[i].value, codOrdenacaoBanner: cont});
									}
								}
							});						
						</script>
						<p style="font-size:15px; color:#31625E; text-align:center; padding-top:20px;">Total de registros: <strong style="font-size:15px; color:#31625E;"><?php echo $registros;?></strong></p>
<?php
				}else{
?>							
						<p style="font-size:15px; color:#31625E; text-align:center; padding-top:20px;">Nenhum registro encontrado!</p>																				
<?php
				}
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
