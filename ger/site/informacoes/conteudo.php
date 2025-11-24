<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "informacoes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Informações alteradas com sucesso!</p>";
					$_SESSION['alteracao'] = "";
				}	
				
				$sqlNomePagamento = "SELECT * FROM informacoes WHERE codInformacao = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Site</p>
						<p class="flexa"></p>
						<p class="nome-lista">Informações</p>
						<br class="clear" />
					</div>
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){
																			
					 $sql = "UPDATE informacoes SET enderecoInformacao = '".$_POST['endereco']."', rotaInformacao = '".$_POST['rota']."', emailInformacao = '".$_POST['email']."', creciInformacao = '".$_POST['creci']."', telefoneInformacao = '".$_POST['telefone']."', celularInformacao = '".$_POST['celular']."', facebookInformacao = '".$_POST['facebook']."', instagramInformacao = '".$_POST['instagram']."', mapaInformacao = '".str_replace("'", "&#39;", $_POST['mapa'])."', tagsHeadInformacao = '".str_replace("'", "&#39;", $_POST['tagsHead'])."', tagsBodyInformacao = '".str_replace("'", "&#39;", $_POST['tagsBody'])."', tagsConversaoInformacao = '".str_replace("'", "&#39;", $_POST['tagsConversao'])."', analyticsInformacao = '".str_replace("'", "&#39;", $_POST['analytics'])."' WHERE codInformacao = 1";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."site/informacoes/'>";						
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar as informações!</p>";
					}
				}else{
					$sql = "SELECT * FROM informacoes WHERE codInformacao = 1";
					$result = $conn->query($sql);
					$dadosInformacao = $result->fetch_assoc();
					$_SESSION['endereco'] = $dadosInformacao['enderecoInformacao'];
					$_SESSION['filial'] = $dadosInformacao['filialInformacao'];
					$_SESSION['rota'] = $dadosInformacao['rotaInformacao'];
					$_SESSION['rota2'] = $dadosInformacao['rota2Informacao'];
					$_SESSION['email'] = $dadosInformacao['emailInformacao'];
					$_SESSION['creci'] = $dadosInformacao['creciInformacao'];
					$_SESSION['telefone'] = $dadosInformacao['telefoneInformacao'];
					$_SESSION['celular'] = $dadosInformacao['celularInformacao'];
					$_SESSION['facebook'] = $dadosInformacao['facebookInformacao'];
					$_SESSION['instagram'] = $dadosInformacao['instagramInformacao'];
					$_SESSION['youtube'] = $dadosInformacao['youtubeInformacao'];
					$_SESSION['tiktok'] = $dadosInformacao['tiktokInformacao'];
					$_SESSION['mapa'] = $dadosInformacao['mapaInformacao'];
					$_SESSION['tagsHead'] = $dadosInformacao['tagsHeadInformacao'];
					$_SESSION['tagsBody'] = $dadosInformacao['tagsBodyInformacao'];
					$_SESSION['tagsConversao'] = $dadosInformacao['tagsConversaoInformacao'];
					$_SESSION['analytics'] = $dadosInformacao['analyticsInformacao'];
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
?>						
					
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<script>
							function habilitaCampo(){
								document.getElementById("endereco").disabled = false;
								document.getElementById("rota").disabled = false;
								document.getElementById("email").disabled = false;
								document.getElementById("creci").disabled = false;
								document.getElementById("telefone").disabled = false;
								document.getElementById("celular").disabled = false;
								document.getElementById("facebook").disabled = false;
								document.getElementById("instagram").disabled = false;
								document.getElementById("mapa").disabled = false;
								document.getElementById("tagsHead").disabled = false;
								document.getElementById("tagsBody").disabled = false;
								document.getElementById("tagsConversao").disabled = false;
								document.getElementById("analytics").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script>
						<form action="<?php echo $configUrlGer; ?>site/informacoes/" method="post">

							<p class="bloco-campo"><label>Endereço: <span class="obrigatorio"> </span></label>
							<input id="endereco" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="endereco" style="width:497px;" value="<?php echo $_SESSION['endereco']; ?>" /></p>
							
							<p class="bloco-campo"><label>Link Rota: <span class="obrigatorio"> </span></label>
							<input id="rota" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="rota" style="width:497px;" value="<?php echo $_SESSION['rota']; ?>" /></p>
							
							<p class="bloco-campo-float"><label>E-mail: <span class="obrigatorio"> </span></label>
							<input id="email" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="email" style="width:235px;" value="<?php echo $_SESSION['email']; ?>" /></p>

							<p class="bloco-campo-float"><label>CRECI: <span class="obrigatorio"> </span></label>
							<input id="creci" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="creci" style="width:235px;" value="<?php echo $_SESSION['creci']; ?>" /></p>

							<br class="clear"/>
							
							<p class="bloco-campo-float"><label>Telefone: <span class="obrigatorio"> </span></label>
							<input id="telefone" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="telefone" style="width:235px;" value="<?php echo $_SESSION['telefone']; ?>" onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);"/></p>
																					
							<p class="bloco-campo-float"><label>Celular: <span class="obrigatorio"> </span></label>
							<input id="celular" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="celular" style="width:235px;" value="<?php echo $_SESSION['celular']; ?>" onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);"/></p>

							<br class="clear"/>
							
							<p class="bloco-campo-float"><label>Link Facebook: <span class="obrigatorio"> </span></label>
							<input id="facebook" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="facebook" style="width:235px;" value="<?php echo $_SESSION['facebook']; ?>"/></p>
																					
							<p class="bloco-campo-float"><label>Link Instagram: <span class="obrigatorio"> </span></label>
							<input id="instagram" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="instagram" style="width:235px;" value="<?php echo $_SESSION['instagram']; ?>" /></p>

							<br class="clear"/>
														
							<p class="bloco-campo"><label>Embed do Google Maps: <span class="obrigatorio" style="font-weight:normal;">Tamanho: width='100%' height='375'</span></label>
							<textarea class="campo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="mapa" name="mapa" type="text" style="width:497px; height:150px;" ><?php echo $_SESSION['mapa']; ?></textarea></p>

							<p class="bloco-campo"><label>Tags <-head->: <span class="obrigatorio" style="font-weight:normal;">(Google Analytics, Google Ads, Meta, etc..)</span></label>
							<textarea class="campo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="tagsHead" name="tagsHead" type="text" style="width:497px; height:150px;" ><?php echo $_SESSION['tagsHead']; ?></textarea></p>

							<p class="bloco-campo"><label>Tags <-body->: <span class="obrigatorio" style="font-weight:normal;">(Google Ads, Meta, etc...)</span></label>
							<textarea class="campo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="tagsBody" name="tagsBody" type="text" style="width:497px; height:150px;" ><?php echo $_SESSION['tagsBody']; ?></textarea></p>

							<p class="bloco-campo"><label>Tags de Conversão: <span class="obrigatorio" style="font-weight:normal;">(Google Ads, Meta, etc...)</span></label>
							<textarea class="campo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="tagsConversao" name="tagsConversao" type="text" style="width:497px; height:150px;" ><?php echo $_SESSION['tagsConversao']; ?></textarea></p>
														
							<p class="bloco-campo"><label>Embed Relatório Analytics: <span class="obrigatorio" style="font-weight:normal;"> Campo não disponível para edição</span></label>
							<textarea class="campo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> readonly id="analytics" name="analytics" type="text" style="width:497px; height:150px;" ><?php echo $_SESSION['analytics']; ?></textarea></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
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
