<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "email";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlEmails = "SELECT * FROM emails WHERE codEmail = '".$url[6]."' LIMIT 0,1";
				$resultEmails = $conn->query($sqlEmails);
				$dadosEmails = $resultEmails->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Configurações</p>
						<p class="flexa"></p>
						<p class="nome-lista">E-mail</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosEmails['enderecoEmail'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosEmails['statusEmail'] == "T"){
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
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosEmails['codEmail'] ?>, "<?php echo htmlspecialchars($dadosEmails['enderecoEmail']) ?>");' title='Deseja excluir o e-mail <?php echo $dadosEmails['enderecoEmail'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o e-mail "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>configuracoes/email/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar E-mails" href="<?php echo $configUrl;?>configuracoes/email/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){
					if(ValidaEmail($_POST['email']) == 1){
						include ('f/conf/criaUrl.php');
									
						if($_POST['status'] == 'T'){
							$ativar = 'T';
						}else{
							$ativar = 'F';
						}											
						$sql = "UPDATE emails SET enderecoEmail = '".$_POST['email']."', senhaEmail = '".$_POST['senha']."' WHERE codEmail = '".$url[6]."'";
						$result = $conn->query($sql);
						
						if($result == 1){
							$_SESSION['email'] = $_POST['email'];
							$_SESSION['alterar'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."configuracoes/email/'>";
						}else{
							$erroData = "<p class='erro'>Problemas ao alterar e-mail!</p>";
						}
					}else{
						$erroAtiva = "ok";
						$erroData = "<p class='erro'><strong>E-mail</strong> não está em um formato válido!</p>";
						$_SESSION['senha'] = $_POST['senha'];
					}
				}else{
					$_SESSION['email'] = $dadosEmails['enderecoEmail'];
					$_SESSION['senha'] = $dadosEmails['senhaEmail'];
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
						<script>	
							function habilitaCampo(){
								document.getElementById("email").disabled = false;
								document.getElementById("senha").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script>
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>						
						<form action="<?php echo $configUrlGer; ?>configuracoes/email/alterar/<?php echo $url[6] ;?>/" method="post" onSubmit="return confereGmail();">
							<p class="bloco-campo"><label>E-mail: <span class="obrigatorio"> * </span><span style="color:#666666;">teste@dominio.com.br</span></label>
							<input class="campo" style="width:310px;" type="text" id="email" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="email" size="40" value="<?php echo $_SESSION['email']; ?>" /></p>

							<p class="bloco-campo"><label>Senha: <span class="obrigatorio"> * </span></label>
							<input class="campo" style="width:210px;" type="password" id="senha" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="senha" size="25" value="<?php echo $_SESSION['senha']; ?>"/></p>		
			
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['senha'] = "";
					$_SESSION['email'] = "";
					$_SESSION['status'] = "";
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
