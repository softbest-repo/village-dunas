<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "email";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$_SESSION['email'] = "";
				$_SESSION['senha'] = "";
				$_SESSION['status'] = "";
?>		
				<div id="localizacao-topo-cadastrar">
					<div id="conteudo-localizacao-topo-cadastrar">
						<p class="nome-lista">Configurações</p>
						<p class="flexa"></p>
						<p class="nome-lista">E-mail</p>
						<p class="flexa"></p>
						<p class="nome-lista">Cadastrar</p>
						<br class="clear" />
					</div>
					<div class="botao-consultar"><a title="Consultar E-mails" href="<?php echo $configUrl;?>configuracoes/email/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['cadastrar']) || isset($_POST['cadastrar-novo'])){
					
					$confereObrigatorio = array( $_POST['email'], $_POST['senha']);
					$nomesConfereObrigatorio = array('E-mail', 'Senha');
					include ('f/conf/verificaObrigatorio.php');
					
					if($erro != "ok"){
						if(ValidaEmail($_POST['email']) == 1){
							include ('f/conf/criaUrl.php');
										
							if($_POST['status'] == 'T'){
								$ativar = 'T';
							}else{
								$ativar = 'F';
							}							
							$sql = "INSERT INTO emails VALUES(0, '".$_POST['email']."', '".$_POST['senha']."', 'T')";
							$result = $conn->query($sql);
							
							if($result == 1){
								if(isset($_POST['cadastrar'])){
									$_SESSION['email'] = $_POST['email'];
									$_SESSION['cadastrar'] = "ok";
									echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."configuracoes/email/'>";
								}else{
									$erroData = "<p class='erro'>E-mail <strong>".$_POST['email']."</strong> cadastrado com sucesso!</p>";
								}
							}else{
								$erroData = "<p class='erro'>Problemas ao cadastrar e-mail!</p>";
							}
						}else{
							$erroData = "<p class='erro'><strong>E-mail</strong> não está em um formato válido!</p>";
							$_SESSION['email'] = $_POST['email'];
							$_SESSION['senha'] = $_POST['senha'];
						}
					}else{
						$_SESSION['email'] = $_POST['email'];
						$_SESSION['senha'] = $_POST['senha'];
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
						<form action="<?php echo $configUrlGer; ?>configuracoes/email/cadastrar/" method="post" onSubmit="return confereGmail();">
							<p class="bloco-campo"><label>E-mail: <span class="obrigatorio"> * </span><span style="color:#666666;">teste@dominio.com.br</span></label>
							<input class="campo" type="text" name="email" id="valueEmail" style="width:310px;" value="<?php echo $_SESSION['email']; ?>" /></p>

							<p class="bloco-campo"><label>Senha: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="password" name="senha" style="width:210px;" value="<?php echo $_SESSION['senha']; ?>"/></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar e-mail" value="Salvar" /><p class="direita-botao"></p></div> <div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar-novo" title="Salvar e cadastrar novo e-mail" value="Salvar e cadastrar novo e-mail" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if(isset($_POST['cadastrar-novo']) || $erro == "ok"){
					$_SESSION['email'] = "";
					$_SESSION['senha'] = "";
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
