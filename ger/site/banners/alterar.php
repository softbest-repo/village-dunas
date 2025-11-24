<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "banners";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codBanner, nomeBanner, statusBanner FROM banners WHERE codBanner = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Site</p>
						<p class="flexa"></p>
						<p class="nome-lista">Banners Capa</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeBanner'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusBanner'] == "T"){
					$status = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$status = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}		
?>	
						<tr class="tr-interno">
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>site/banners/ativacao/<?php echo $dadosNomePagamento['codBanner'] ?>/' title='Deseja <?php echo $statusPergunta ?> o banner capa <?php echo $dadosNomePagamento['nomeBanner'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codBanner'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeBanner']) ?>");' title='Deseja excluir o banner capa <?php echo $dadosNomePagamento['nomeBanner'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir o banner capa "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>site/banners/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Banners Capa" href="<?php echo $configUrl;?>site/banners/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlBanner = criaUrl($_POST['nome']);
																	
					$sql = "UPDATE banners SET nomeBanner = '".preparaNome($_POST['nome'])."', tituloBanner = '".$_POST['titulo']."', descricaoBanner = '".$_POST['descricao']."', textoBanner = '".$_POST['texto']."', linkBanner = '".str_replace("\"", "&quot;", str_replace("'", "&#39;", $_POST['link']))."', novaAbaBanner = '".$_POST['novaAba']."', urlBanner = '".$urlBanner."' WHERE codBanner = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."site/banners/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar banner capa!</p>";
					}
				}else{
					$sql = "SELECT * FROM banners WHERE codBanner = ".$url[6];
					$result = $conn->query($sql);
					$dadosBanner = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosBanner['nomeBanner'];
					$_SESSION['titulo'] = $dadosBanner['tituloBanner'];
					$_SESSION['descricao'] = $dadosBanner['descricaoBanner'];
					$_SESSION['texto'] = $dadosBanner['textoBanner'];
					$_SESSION['link'] = $dadosBanner['linkBanner'];
					$_SESSION['novaAba'] = $dadosBanner['novaAbaBanner'];
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
					
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<script>
							function habilitaCampo(){
								document.getElementById("nome").disabled = false;
								document.getElementById("titulo").disabled = false;
								document.getElementById("link").disabled = false;
								document.getElementById("novaAba1").disabled = false;
								document.getElementById("novaAba2").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script> 
						<form action="<?php echo $configUrlGer; ?>site/banners/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:400px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo"><label>Título: <span class="em" style="font-weight:normal;"> Ex: Balneário Gaivota...</span></label>
							<input class="campo" type="text" id="titulo" name="titulo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:400px;" value="<?php echo $_SESSION['titulo']; ?>" /></p>
						
							<p class="bloco-campo"><label>Link: <span class="em" style="font-weight:normal;"> Ex: http://www.softbest.com.br </span></label>
							<input id="link" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="link" style="width:400px;" value="<?php echo $_SESSION['link']; ?>" /></p>

							<p class="bloco-campo"><label>Abrir link em nova aba:</label>
							<label style="float:left; font-weight:normal; margin-right:20px;"><input class="campo" type="radio" id="novaAba1" name="novaAba" value="N" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> <?php echo $_SESSION['novaAba'] == "N" || $_SESSION['novaAba'] == "" ? 'checked' : '';?>/>Não</label>
							<label style="float:left; font-weight:normal;"><input class="campo" type="radio" id="novaAba2" name="novaAba" value="S" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> <?php echo $_SESSION['novaAba'] == "S" ? 'checked' : '';?>/>Sim</label></p>							 
							
							<br class="clear"/>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['link'] = "";
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
