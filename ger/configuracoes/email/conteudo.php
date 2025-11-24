<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "email";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastrar'] == "ok"){
					$erroConteudo = "<p class='erro'>E-mail <strong>".$_SESSION['email']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastrar'] = "";
					$_SESSION['email'] = "";
					$_SESSION['senha'] = "";
					$_SESSION['status'] = "";		
				}else	
				if($_SESSION['alterar'] == "ok"){
					$erroConteudo = "<p class='erro'>E-mail <strong>".$_SESSION['email']."</strong> alterado com sucesso!</p>";
					$_SESSION['alterar'] = "";
					$_SESSION['email'] = "";
					$_SESSION['senha'] = "";
					$_SESSION['status'] = "";		
				}else	
				if($_SESSION['ativar'] == "ok"){
					$erroConteudo = "<p class='erro'>E-mail <strong>".$_SESSION['email']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativar'] = "";
					$_SESSION['email'] = "";
				}else
				if($_SESSION['excluir'] == "ok"){
					$erroConteudo = "<p class='erro'>E-mail <strong>".$_SESSION['email']."</strong> excluído com sucesso!</p>";
					$_SESSION['excluir'] = "";
					$_SESSION['email'] = "";
				}	
?>

				<div id="filtro" style="padding-bottom:5px;">
					<div id="localizacao-filtro">
						<p class="nome-lista">Configurações</p>
						<p class="flexa"></p>
						<p class="nome-lista">E-mail</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
							<script type="text/javascript">
								function mensagem(){	
									alert("Você só pode ser um e-mail cadastrado!");
								}
							</script>
						</div>
					</div>					
				</div>
				<div id="dados-conteudo">
					<div id="col-esq-pref" style="width:20%;">
						<p class="titulo-menu-pref">Alterar preferências</p>
						<p class="<?php echo $url[4] == 'minha-foto' ? 'menu-pref-foto-ativo' : 'menu-pref-foto' ;?>"><a href="<?php echo $configUrl;?>configuracoes/minha-foto/" title="Minha foto" >Minha foto</a></p>
						<p class="<?php echo $url[4] == 'email' ? 'menu-pref-email-ativo' : 'menu-pref-email' ;?>"><a href="<?php echo $configUrl;?>configuracoes/email/" title="Email" >Email</a></p>
						<p class="<?php echo $url[4] == 'permissoes' ? 'menu-pref-permissoes-ativo' : 'menu-pref-permissoes' ;?>"><a href="<?php echo $configUrl;?>configuracoes/permissoes/" title="Permissões" >Permissões</a></p>
						<p class="<?php echo $url[4] == 'usuarios' ? 'menu-pref-usuarios-ativo' : 'menu-pref-usuarios' ;?>"><a href="<?php echo $configUrl;?>cadastros/usuarios/" title="Usuários">Usuários</a></p>
					</div>				
					<div id="consultas" style="float:left; width:76%;">
					
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
				
				$sqlEmail = "SELECT * FROM emails";
				$resultEmail = $conn->query($sqlEmail);
				$dadosEmail = $resultEmail->fetch_assoc();
				
				if($dadosEmail['codEmail'] == ""){
?>							
						<div class="botao-novo" style="margin-bottom:20px;"><a title="Novo E-mail" href="<?php echo $configUrl;?>configuracoes/email/cadastrar/"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo E-mail</div><div class="direita-novo"></div></a></div>
<?php
				}else{
?>
						<div class="botao-novo" style="margin-bottom:20px;" onClick="mensagem()"><a title="Novo E-mail" href="#"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo E-mail</div><div class="direita-novo"></div></a></div>
<?php
				}
?>
						<br class="clear" />
<?php
				$sqlConta = "SELECT enderecoEmail FROM emails WHERE codEmail != '' ".$filtraCliente;
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);			
				
				if($dadosConta['enderecoEmail'] != ""){
?>
						<table class="tabela-menus">
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >E-mails</th>
								<th>Senha</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlEmails = "SELECT * FROM emails WHERE codEmail != ''".$filtraCliente." ORDER BY statusEmail ASC, enderecoEmail ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlEmails = "SELECT * FROM emails WHERE codEmail != ''".$filtraCliente." ORDER BY statusEmail ASC, enderecoEmail ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultEmails = $conn->query($sqlEmails);
					while($dadosEmail = $resultEmails->fetch_assoc()){
						$mostrando++;
						
						if($dadosEmail['statusEmail'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}		
?>

							<tr class="tr">
								<td><span class="campo-conteudo"><?php echo $dadosEmail['enderecoEmail'];?></span></td>
								<td><span class="campo-conteudo">********</span></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>configuracoes/email/alterar/<?php echo $dadosEmail['codEmail'] ?>/' title='Deseja alterar o e-mail <?php echo $dadosEmail['enderecoEmail'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosEmail['codEmail'] ?>, "<?php echo htmlspecialchars($dadosEmail['enderecoEmail']) ?>");' title='Deseja excluir o e-mail <?php echo $dadosEmail['enderecoEmail'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
							</tr>
<?php
					}
?>
							<script>
								function confirmaExclusao(cod, nome){
									if(confirm("Deseja Excluir o e-mail "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>configuracoes/email/excluir/'+cod+'/';
									}
								}
							</script>	 
						</table>	
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
