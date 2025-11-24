<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "usuarios";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$url[6]."'";
				$resultNomeUsuario = $conn->query($sqlNomeUsuario);
				$dadosNomeUsuario = $resultNomeUsuario->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Configurações</p>
						<p class="flexa"></p>
						<p class="nome-lista">Usuários</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeUsuario['nomeUsuario'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeUsuario['statusUsuario'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>configuracoes/usuarios/ativacao/<?php echo $dadosNomeUsuario['codUsuario'] ?>/' title='Deseja <?php echo $statusPergunta ?> o usuário <?php echo $dadosNomeUsuario['nomeUsuario'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeUsuario['codUsuario'] ?>, "<?php echo htmlspecialchars($dadosNomeUsuario['nomeUsuario']) ?>");' title='Deseja excluir o usuário <?php echo $dadosNomeUsuario['nomeUsuario'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>configuracoes/detalhes/<?php echo $dadosNomeUsuario['codUsuario'] ?>/' title='Gerenciar permissões do usuário <?php echo $dadosNomeUsuario['nomeUsuario'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/permicoes-branco.gif" alt="icone"></a></td>
						</tr>
							<script>
									function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir o usuário "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>configuracoes/usuarios/excluir/'+cod+'/';
								}
							}
						 </script>
					</table>	
					<script type="text/javascript">
						function checa_seguranca(pass, campo){ 
							var senha = document.getElementById(pass).value.length; 
							var resultadoado; 

							
							if(senha == 0){ 
											resultado = '<p class="imagem-barra" style="width:0px;">&nbsp;</p>';
							} else if(senha == 1){ 
											resultado = '<p class="imagem-barra" style="width:16.666666667px;">&nbsp;</p>'; 
							} else if(senha == 2){ 
											resultado = '<p class="imagem-barra" style="width:33.333333334px;">&nbsp;</p>'; 
							} else if(senha == 3){ 
											resultado = '<p class="imagem-barra" style="width:50.000000001px;">&nbsp;</p>';  
							} else if(senha == 4){ 
											resultado = '<p class="imagem-barra" style="width:66.666666668px;">&nbsp;</p>'; 
							} else if(senha == 5){ 
											resultado = '<p class="imagem-barra" style="width:83.333333335px;">&nbsp;</p>'; 
							} else if(senha == 6){ 
											resultado = '<p class="imagem-barra" style="width:100.000000002px;">&nbsp;</p>';  
							} else if(senha == 7){ 
											resultado = '<p class="imagem-barra" style="width:116.666666669px;">&nbsp;</p>'; 
							} else if(senha == 8){ 
											resultado = '<p class="imagem-barra" style="width:133.333333336px;">&nbsp;</p>'; 
							} else if(senha == 9){ 
											resultado = '<p class="imagem-barra" style="width:150.000000003px;">&nbsp;</p>';  
							} else if(senha == 10){ 
											resultado = '<p class="imagem-barra" style="width:166.66666667px;">&nbsp;</p>'; 
							} else if(senha == 11){ 
											resultado = '<p class="imagem-barra" style="width:183.333333337px;">&nbsp;</p>'; 
							} else if(senha == 12){ 
											resultado = '<p class="imagem-barra" style="width:200px;">&nbsp;</p>';  
							} else if(senha == 13){ 
											resultado = '<p class="imagem-barra" style="width:200px;">&nbsp;</p>';  
							} else if(senha >= 14){ 
											resultado = '<p class="imagem-barra" style="width:200px;">&nbsp;</p>';  
							}
							
							document.getElementById(campo).innerHTML = resultado; 
							
							return; 
						}

						function checa_seguranca_nome(pass2, campo){ 
							var senha = document.getElementById(pass2).value.length; 
							var resultadoado2; 

							
							if(senha == 0){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Baixa</p>';
							} else if(senha == 1){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Baixa</p>'; 
							} else if(senha == 2){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Baixa</p>'; 
							} else if(senha == 3){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Baixa</p>';  
							} else if(senha == 4){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Baixa</p>'; 
							} else if(senha == 5){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Média</p>'; 
							} else if(senha == 6){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Média</p>';  
							} else if(senha == 7){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Média</p>'; 
							} else if(senha == 8){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Média</p>'; 
							} else if(senha == 9){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Média</p>';  
							} else if(senha == 10){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Bom</p>'; 
							} else if(senha == 11){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Bom</p>'; 
							} else if(senha == 12){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Bom</p>';  
							} else if(senha == 13){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Excelente</p>';  
							} else if(senha >= 14){ 
											resultado2 = '<p class="forca"><strong>Força:</strong> Excelente</p>';  
							}
							
							document.getElementById(campo).innerHTML = resultado2; 
							
							return; 
						}

						function confere(){
							senha = document.getElementById("senha").value;
							resultado3 = document.getElementById("senha2").value;
							
							if(senha == resultado3){
								resultado3 = "";
							}else{
								resultado3 = "<p style='margin-top:50px; position:absolute; margin-left:-130px; color:#FF0000;'>As senhas digitadas estão diferentes.</p>";
							}

							document.getElementById("compara").innerHTML = resultado3; 
											
							return;
						}

						function mostraBloco(id){
							document.getElementById('bloco-pass').style.display="block";		
						}

						function carregaCidade(cod){
							var $tgf = jQuery.noConflict();
							$tgf.post("<?php echo $configUrl;?>configuracoes/usuarios/carrega-cidade.php", {codEstado: cod}, function(data){
								$tgf("#carrega-cidade").html(data);
								$tgf("#sel-padrao").css("display", "none");																									
							});
						}						
					</script>
					<div class="botao-consultar"><a href="<?php echo $configUrl;?>configuracoes/usuarios/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){
					$sqlConfereNome = "SELECT * FROM usuarios WHERE nomeUsuario = '".$_POST['nome']."' and codUsuario != ".$url[6]." LIMIT 0,1";
					$resultConfereNome = $conn->query($sqlConfereNome);
					$dadosConfereNome = $resultConfereNome->fetch_assoc();					
					$registrosNome = mysqli_num_rows($resultConfereNome);				
					
					if($registrosNome == 0){		
						
						$sqlConfereUsuario = "SELECT * FROM usuarios WHERE usuarioUsuario = '".$_POST['usuario']."' and codUsuario != ".$url[6]." LIMIT 0,1";
						$resultConfereUsuario = $conn->query($sqlConfereUsuario);
						$dadosConfereUsuario = $resultConfereUsuario->fetch_assoc(); 
						$registros = mysqli_num_rows($resultConfereUsuario);
						
						if($registros == 0){
							if($_POST['senha'] == $_POST['confirma-senha']){
								include ('f/conf/criaUrl.php');										
						
								$sql = "UPDATE usuarios SET nomeUsuario = '".preparaNome($_POST['nome'])."', dataCadastro = '".$_POST['dataCadastro']."', sobrenomeUsuario = '".preparaNome($_POST['sobrenome'])."', tipoUsuario = '".$_POST['tipo-usuario']."', ruaUsuario = '".$_POST['rua']."', numeroUsuario = '".$_POST['numero']."', bairroUsuario = '".$_POST['bairro']."', codCidade = '".$_POST['cidade']."', codEstado = '".$_POST['estado']."', telefoneUsuario = '".$_POST['telefone']."', celularUsuario = '".$_POST['celular']."', emailUsuario = '".$_POST['email']."', cpfUsuario = '".$_POST['cpf']."', rgUsuario = '".$_POST['rg']."', sexoUsuario = '".$_POST['sexo']."', usuarioUsuario = '".$_POST['usuario']."', senhaUsuario = '".base64_encode($_POST['senha'])."' WHERE codUsuario = '".$url[6]."'";
								$result = $conn->query($sql);
						
								if($result == 1){
									$_SESSION['nome'] = $_POST['nome'];
									$_SESSION['alteracao'] = "ok";
									echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."configuracoes/usuarios/'>";
								}else{
									$erroData = "<p class='erro'>Problemas ao alterar Usuario!</p>";
								}
							}else{
								$erroData = "<p class='erro'>As <strong>senhas</strong> digitadas estão diferentes!</p>";
								$_SESSION['nome']  = $_POST['nome'];
								$_SESSION['sobrenome']  = $_POST['sobrenome'];
								$_SESSION['tipo-usuario'] = $_POST['tipo-usuario'];
								$_SESSION['rua'] = $_POST['rua'];
								$_SESSION['numero'] = $_POST['numero'];
								$_SESSION['bairro'] = $_POST['bairro'];
								$_SESSION['cidade'] = $_POST['cidade'];
								$_SESSION['estado'] = $_POST['estado'];
								$_SESSION['telefone'] = $_POST['telefone'];
								$_SESSION['celular'] = $_POST['celular'];
								$_SESSION['cpf'] = $_POST['cpf'];
								$_SESSION['rg'] = $_POST['rg'];
								$_SESSION['data'] = data($_POST['data']);
								$_SESSION['dataCadastro'] = $_POST['dataCadastro'];
								$_SESSION['sexo'] = $_POST['sexo'];
								$_SESSION['usuario'] = $_POST['usuario'];
								$_SESSION['senha'] = $_POST['senha'];
								$_SESSION['confirma-senha'] = "";
								$_SESSION['status'] = $_POST['status'];
								$_SESSION['notificar'] = $_POST['notificar'];
								$erroAtiva = "ok";				
							}
						}else{
							$erroData = "<p class='erro'>O usuário <strong>".$_POST['usuario']."</strong> já esta sendo utilizado em outro cadastro!</p>";
							$_SESSION['nome']  = $_POST['nome'];
							$_SESSION['sobrenome']  = $_POST['sobrenome'];
							$_SESSION['tipo-usuario'] = $_POST['tipo-usuario'];
							$_SESSION['rua'] = $_POST['rua'];
							$_SESSION['numero'] = $_POST['numero'];
							$_SESSION['bairro'] = $_POST['bairro'];
							$_SESSION['cidade'] = $_POST['cidade'];
							$_SESSION['estado'] = $_POST['estado'];
							$_SESSION['telefone'] = $_POST['telefone'];
							$_SESSION['celular'] = $_POST['celular'];
							$_SESSION['cpf'] = $_POST['cpf'];
							$_SESSION['rg'] = $_POST['rg'];
							$_SESSION['data'] = data($_POST['data']);
							$_SESSION['dataCadastro'] = $_POST['dataCadastro'];
							$_SESSION['sexo'] = $_POST['sexo'];
							$_SESSION['usuario'] = $_POST['usuario'];
							$_SESSION['senha'] = $_POST['senha'];
							$_SESSION['confirma-senha'] = "";
							$_SESSION['status'] = $_POST['status'];
							$_SESSION['notificar'] = $_POST['notificar'];
							$erroAtiva = "ok";				
						}
					}else{
						$erroData = "<p class='erro'>O nome <strong>".$_POST['nome']."</strong> já esta sendo utilizado em outro cadastro!</p>";
						$_SESSION['nome'] = "";
						$_SESSION['sobrenome'] = "";
						$_SESSION['tipo-usuario'] = $_POST['tipo-usuario'];
						$_SESSION['rua'] = $_POST['rua'];
						$_SESSION['numero'] = $_POST['numero'];
						$_SESSION['bairro'] = $_POST['bairro'];
						$_SESSION['cidade'] = $_POST['cidade'];
						$_SESSION['estado'] = $_POST['estado'];
						$_SESSION['telefone'] = $_POST['telefone'];
						$_SESSION['celular'] = $_POST['celular'];
						$_SESSION['cpf'] = $_POST['cpf'];
						$_SESSION['rg'] = $_POST['rg'];
						$_SESSION['data'] = data($_POST['data']);
						$_SESSION['dataCadastro'] = $_POST['dataCadastro'];
						$_SESSION['sexo'] = $_POST['sexo'];
						$_SESSION['usuario'] = $_POST['usuario'];
						$_SESSION['senha'] = $_POST['senha'];
						$_SESSION['confirma-senha'] = $_POST['usuario'];
						$_SESSION['status'] = $_POST['status'];
						$_SESSION['notificar'] = $_POST['notificar'];
						$erroAtiva = "ok";				
					}
				}else{
					$sql = "SELECT * FROM usuarios WHERE codUsuario = ".$url[6];
					$result = $conn->query($sql);
					$dadosUsuario = $result->fetch_assoc();
					$_SESSION['usuarioAntigo'] = $dadosUsuario['usuarioUsuario'];
					$_SESSION['nome'] = $dadosUsuario['nomeUsuario'];
					$_SESSION['sobrenome'] = $dadosUsuario['sobrenomeUsuario'];
					$_SESSION['tipo-usuario'] = $dadosUsuario['tipoUsuario'];
					$_SESSION['rua'] = $dadosUsuario['ruaUsuario'];
					$_SESSION['numero'] = $dadosUsuario['numeroUsuario'];
					$_SESSION['bairro'] = $dadosUsuario['bairroUsuario'];
					$_SESSION['cidade'] = $dadosUsuario['codCidade'];
					$_SESSION['estado'] = $dadosUsuario['codEstado'];
					$_SESSION['telefone'] = $dadosUsuario['telefoneUsuario'];
					$_SESSION['celular'] = $dadosUsuario['celularUsuario'];
					$_SESSION['email'] = $dadosUsuario['emailUsuario'];
					$_SESSION['cpf'] = $dadosUsuario['cpfUsuario'];
					$_SESSION['rg'] = $dadosUsuario['rgUsuario'];
					$_SESSION['data'] = data($dadosUsuario['dataNascUsuario']);
					$_SESSION['dataCadastro'] = $dadosUsuario['dataCadastro'];
					$_SESSION['sexo'] = $dadosUsuario['sexoUsuario'];
					$_SESSION['usuario'] = $dadosUsuario['usuarioUsuario'];
					$_SESSION['senha'] = base64_decode($dadosUsuario['senhaUsuario']);
					$_SESSION['confirma-senha'] = base64_decode($dadosUsuario['senhaUsuario']);
					$_SESSION['status'] = $dadosUsuario['statusUsuario'];
					if($_SESSION['data'] == "00/00/0000"){
						$_SESSION['data'] = "";
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
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
						<script>
							function habilitaCampo(){
								document.getElementById("nome").disabled = false;
								document.getElementById("sobrenome").disabled = false;
								document.getElementById("tipo-usuario").disabled = false;
								document.getElementById("tipo-usuario2").disabled = false;
								document.getElementById("rua").disabled = false;
								document.getElementById("numero").disabled = false;
								document.getElementById("bairro").disabled = false;
								document.getElementById("estado").disabled = false;
								document.getElementById("cidade").disabled = false;
								document.getElementById("cpf").disabled = false;
								document.getElementById("rg").disabled = false;
								document.getElementById("telefone").disabled = false;
								document.getElementById("celular").disabled = false;
								document.getElementById("sexo").disabled = false;
								document.getElementById("sexos").disabled = false;
								document.getElementById("email").disabled = false;
								document.getElementById("usuario").disabled = false;
								document.getElementById("senha").disabled = false;
								document.getElementById("senha2").disabled = false;
								document.getElementById("idAlterar").disabled = false;
								document.getElementById("notificar").disabled = false;
								
							}
						</script> 
	
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<form name="formUsuarioes" action="<?php echo $configUrlGer; ?>configuracoes/usuarios/alterar/<?php echo $url[6] ;?>/" method="post">
							<input type="hidden" name="dataCadastro" value="<?php echo $_SESSION['dataCadastro'];?>" />
							<input type="hidden" name="usuarioAntigo" value="<?php echo $_SESSION['usuarioAntigo'];?>" />
														
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="nome" style="width:250px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
						
							<p class="bloco-campo-float"><label>Sobrenome: <span class="obrigatorio"> * </span></label>
							<input id="sobrenome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="sobrenome" style="width:315px;" required value="<?php echo $_SESSION['sobrenome']; ?>" /></p>

							<p class="bloco-campo-float"><label>Tipo Usuário: <span class="obrigatorio"> * </span></label>
							<input class="caixa" name="tipo-usuario" id="tipo-usuario2" type="radio" value="A" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> <?php echo $_SESSION['tipo-usuario'] == "A" || $_SESSION['tipo-usuario'] == "" ? 'checked' : ''; ?> />Administrador   <input class="caixa" name="tipo-usuario" id="tipo-usuario" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="radio" value="C" <?php echo $_SESSION['tipo-usuario'] == 'C' ? 'checked' : ''; ?> />Corretor</p>	
							
							<br class="clear" />
							
							<p class="bloco-campo-float"><label>Rua:</label>
							<input id="rua" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="rua" style="width:155px;" value="<?php echo $_SESSION['rua']; ?>" /></p>

							<p class="bloco-campo-float"><label>Número:</label>
							<input id="numero" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="numero" style="width:50px;" value="<?php echo $_SESSION['numero']; ?>" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer);">

							<p class="bloco-campo-float"><label>Bairro:</label>
							<input id="bairro" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="bairro" style="width:140px;" value="<?php echo $_SESSION['bairro']; ?>"/></p>

							<p class="bloco-campo-float"><label>Estado: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="estado" name="estado" style="width:150px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required onChange="carregaCidade(this.value);">
									<option value="">Selecione</option>
<?php
				$sqlEstado = "SELECT nomeEstado, codEstado FROM estado WHERE statusEstado = 'T' ORDER BY nomeEstado ASC";
				$resultEstado = $conn->query($sqlEstado);
				while($dadosEstado = $resultEstado->fetch_assoc()){
?>
									<option value="<?php echo $dadosEstado['codEstado'] ;?>" <?php echo $_SESSION['estado'] == $dadosEstado['codEstado'] ? '/SELECTED/' : '';?>><?php echo $dadosEstado['nomeEstado'] ;?></option>
<?php
				}
?>					
								</select>
								<br class="clear"/>
							</p>
							
<?php
				if($_SESSION['cidade'] == ""){
?>													
							<div id="sel-padrao">
								<p class="bloco-campo-float"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
									<select id="default-usage-select" id="cidade" class="campo" name="cidade" style="width:200px;">
										<option id="option" value="">Selecione um Estado primeiro</option>
									</select>
									<br class="clear"/>
								</p>
							</div>
<?php
				}
?>													
							<div id="carrega-cidade">
<?php
				if($_SESSION['estado'] != "" && $_SESSION['cidade'] != ""){
?>
								<p class="bloco-campo-float"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
									<select class="campo" name="cidade" style="width:200px;" id="cidade" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>>
										<option value="" style="color:#FFF;">Selecione</option>

<?php
					$sqlCidade = "SELECT * FROM cidade WHERE statusCidade = 'T' and codEstado = ".$_SESSION['estado']." ORDER BY nomeCidade ASC";
					$resultCidade = $conn->query($sqlCidade);
					while($dadosCidade = $resultCidade->fetch_assoc()){			
?>
										<option value="<?php echo $dadosCidade['codCidade']; ?>" <?php echo $dadosCidade['codCidade'] == $_SESSION['cidade'] ? '/SELECTED/' : ''; ?>><?php echo $dadosCidade['nomeCidade']; ?></option>
<?php
					}
?>
									</select>
								</p>
<?php
				}
?>
							</div>
							
							<br class="clear" />

							<p class="bloco-campo-float"><label>CPF:</label>
							<input id="cpf" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="cpf" style="width:110px;" value="<?php echo $_SESSION['cpf']; ?>"   onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf)"/></p>

							<p class="bloco-campo-float"><label>RG:</label>
							<input id="rg" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="rg" style="width:110px;" value="<?php echo $_SESSION['rg']; ?>"/></p>

							<p class="bloco-campo-float"><label>Telefone: </label>
							<input id="telefone" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="telefone" style="width:100px;" value="<?php echo $_SESSION['telefone']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<p class="bloco-campo-float"><label>Celular: </label>
							<input id="celular" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="celular" style="width:100px;" value="<?php echo $_SESSION['celular']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<p class="bloco-campo-float"><label>Sexo: <span class="obrigatorio"> * </span></label>
							<input id="sexo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="caixa" name="sexo" type="radio" value="M" <?php echo $_SESSION['sexo'] == 'M' ? 'checked' : ''; ?> />Masculino   <input id="sexos" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="caixa" name="sexo" type="radio" value="F" <?php echo $_SESSION['sexo'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
	
							<br class="clear" />

							<p class="bloco-campo-float"><label>E-mail: </label>
							<input id="email" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="email" name="email" required style="width:300px;" value="<?php echo $_SESSION['email']; ?>"/></p>
							
							<p class="bloco-campo-float"><label>Usuário: <span class="obrigatorio"> * </span></label>
							<input id="usuario" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="usuario" required style="width:130px;" value="<?php echo $_SESSION['usuario']; ?>" /></p>

							<div class="bloco-campo-float"><label>Senha: <span class="obrigatorio"> * </span></label>
								<input id="senha" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="password" name="senha" required style="width:130px;" onkeyUp="checa_seguranca('senha', 'pass'), checa_seguranca_nome('senha', 'pass2');"  onkeydown="javascript:mostraBloco('bloco-pass');" value="<?php echo $_SESSION['senha']; ?>"/><br/>
								<div id="bloco-pass" style="position:absolute;">	
									<p id="pass2"></p>
									<p id="pass"></p>
								</div>
								<br class="clear" />	
							</div>	

							<div class="bloco-campo-float"><label>Confirmar Senha: <span class="obrigatorio"> * </span> </label>
							<input id="senha2" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="password" name="confirma-senha" style="width:130px;" required onBlur="confere()" value="<?php echo $_SESSION['confirma-senha']; ?>" />
								<div id="compara"></div>
								<br class="clear" />
							</div>
							<br class="clear" />
														
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="idAlterar" type="submit" name="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>

<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['rua'] = "";
					$_SESSION['numero'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['cidade'] = "";
					$_SESSION['estado'] = "";
					$_SESSION['telefone'] = "";
					$_SESSION['celular'] = "";
					$_SESSION['email'] = "";
					$_SESSION['cpf'] = "";
					$_SESSION['rg'] = "";
					$_SESSION['data'] = "";
					$_SESSION['dataCadastro'] = "";
					$_SESSION['sexo'] = "";
					$_SESSION['status'] = "";
				}
?>
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
