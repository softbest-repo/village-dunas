<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "usuarios";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Usuário <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";	
				}else
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Usuário <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Usuário <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Usuário <strong>".$_SESSION['nome']."</strong> exclúido com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}					
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Usuários</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
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
							
							function executaForm(){
								document.getElementById("filtro-cat").submit();
							}
		
							function carregaCidade(cod){
								var $tgf = jQuery.noConflict();
								$tgf.post("<?php echo $configUrl;?>cadastros/usuarios/carrega-cidade.php", {codEstado: cod}, function(data){
									$tgf("#carrega-cidade").html(data);
									$tgf("#sel-padrao").css("display", "none");																									
								});
							}						
						</script>
						<div id="formulario-filtro">
							<form action="<?php echo $configUrl;?>cadastros/usuarios/" method="post" >							
<?php
				if($filtraUsuario == ""){
?>
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Usuário" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Usuário</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
<?php
				}
?>								
								<br class="clear" />
							</form>
						</div>
					</div>					
<?php
				if(isset($_POST['cadastrar'])){
					if($_POST['senha'] != $_POST['confirma-senha']){
						$erroData = "<p class='erro'>As senhas digitadas estão diferentes.</p>";	
						$_SESSION['filial'] = $_POST['filial'];
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['sobrenome'] = $_POST['sobrenome'];
						$_SESSION['rua'] = $_POST['rua'];
						$_SESSION['numero'] = $_POST['numero'];
						$_SESSION['bairro'] = $_POST['bairro'];
						$_SESSION['cidade'] = $_POST['cidade'.$_POST['estado']];
						$_SESSION['estado'] = $_POST['estado'];
						$_SESSION['telefone'] = $_POST['telefone'];
						$_SESSION['celular'] = $_POST['celular'];
						$_SESSION['email'] = $_POST['email'];
						$_SESSION['cpfCol'] = $_POST['cpfCol'];
						$_SESSION['rg'] = $_POST['rg'];
						$_SESSION['data'] = $_POST['data'];
						$_SESSION['sexo'] = $_POST['sexo'];
						$_SESSION['usuario'] = $_POST['usuario'];
						$_SESSION['senha'] = $_POST['senha'];
						$_SESSION['confirma-senha'] = "";
						$_SESSION['status'] = $_POST['status'];
					}else{
						$sqlConta = "SELECT * FROM usuarios";
						$resultConta = $conn->query($sqlConta);
						$dadosConta = $resultConta->fetch_assoc();
						$registrosTotal = mysqli_num_rows($resultConta);				
										
						if($registrosTotal < $configLimite){
							
							$sqlConfereNome = "SELECT * FROM usuarios WHERE nomeUsuario = '".$_POST['nome']."' LIMIT 0,1";
							$resultConfereNome = $conn->query($sqlConfereNome);
							$dadosConfereNome = $resultConfereNome->fetch_assoc();
							$registrosNome = mysqli_num_rows($resultConfereNome);				
														
							if($registrosNome == 0 || $registrosNome >= 1){
							
								$sqlConfereUsuario = "SELECT * FROM usuarios WHERE usuarioUsuario = '".$_POST['usuario']."' LIMIT 0,1";
								$resultConfereUsuario = $conn->query($sqlConfereUsuario);
								$dadosConfereUsuario = $resultConfereUsuario->fetch_assoc();
								$registros = mysqli_num_rows($resultConfereUsuario);
								
								if($registros == 0){ 
																															
									$sql = "INSERT INTO usuarios VALUES(0, '".$_POST['filial']."', '".$_POST['nome']."', '".date("Y-m-d")."', '".$_POST['sobrenome']."', '".$_POST['tipo-usuario']."', '".$_POST['leads-usuario']."', '".$_POST['rua']."', '".$_POST['numero']."', '".$_POST['bairro']."', '".$_POST['cidade']."', '".$_POST['estado']."', '".$_POST['telefone']."', '".$_POST['celular']."', '".$_POST['email']."', '".$_POST['cpfCol']."', '".$_POST['rg']."', '".$_POST['sexo']."', '".$_POST['usuario']."', '".base64_encode($_POST['senha'])."', 'T')";
									$result = $conn->query($sql);

									if($result == 1){
										$_SESSION['nome'] = $_POST['nome'];
										$_SESSION['cadastro'] = "ok";
										$_SESSION['sobrenome'] = "";
										$_SESSION['filial'] = "";
										$_SESSION['tipo-usuario'] = "";
										$_SESSION['leads-usuario'] = "";
										$_SESSION['rua'] = "";
										$_SESSION['numero'] = "";
										$_SESSION['bairro'] = "";
										$_SESSION['estado'] = "";
										$_SESSION['cidade'] = "";
										$_SESSION['telefone'] = "";
										$_SESSION['celular'] = "";
										$_SESSION['email'] = "";
										$_SESSION['cpfCol'] = "";
										$_SESSION['rg'] = "";
										$_SESSION['data'] = "";
										$_SESSION['sexo'] = "";
										$_SESSION['usuario'] = "";
										$_SESSION['senha'] = "";
										$_SESSION['confirma-senha'] = "";
										echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/usuarios/'>";
									}else{
										$erroData = "<p class='erro'>Problemas ao cadastrar usuário!</p>";
										$_SESSION['nome'] = "";
										$_SESSION['sobrenome'] = "";
										$_SESSION['filial'] = "";
										$_SESSION['tipo-usuario'] = "";
										$_SESSION['leads-usuario'] = "";
										$_SESSION['rua'] = "";
										$_SESSION['numero'] = "";
										$_SESSION['bairro'] = "";
										$_SESSION['estado'] = "";
										$_SESSION['cidade'] = "";
										$_SESSION['telefone'] = "";
										$_SESSION['celular'] = "";
										$_SESSION['email'] = "";
										$_SESSION['cpfCol'] = "";
										$_SESSION['rg'] = "";
										$_SESSION['data'] = "";
										$_SESSION['sexo'] = "";
										$_SESSION['usuario'] = "";
										$_SESSION['senha'] = "";
										$_SESSION['confirma-senha'] = "";
									}
								}else{
									$erroData = "<p class='erro'>O usuário <strong>".$_POST['usuario']."</strong> já esta sendo utilizado em outro cadastro!</p>";
									$_SESSION['nome'] = $_POST['nome'];
									$_SESSION['sobrenome'] = $_POST['sobrenome'];
									$_SESSION['filial'] = $_POST['filial'];
									$_SESSION['tipo-usuario'] = $_POST['tipo-usuario'];
									$_SESSION['leads-usuario'] = $_POST['leads-usuario'];
									$_SESSION['rua'] = $_POST['rua'];
									$_SESSION['numero'] = $_POST['numero'];
									$_SESSION['bairro'] = $_POST['bairro'];
									$_SESSION['cidade'] = $_POST['cidade'];
									$_SESSION['estado'] = $_POST['estado'];
									$_SESSION['telefone'] = $_POST['telefone'];
									$_SESSION['celular'] = $_POST['celular'];
									$_SESSION['email'] = $_POST['email'];
									$_SESSION['cpfCol'] = $_POST['cpfCol'];
									$_SESSION['rg'] = $_POST['rg'];
									$_SESSION['data'] = $_POST['data'];
									$_SESSION['sexo'] = $_POST['sexo'];
									$_SESSION['usuario'] = "";
									$_SESSION['senha'] = $_POST['senha'];
									$_SESSION['confirma-senha'] = $_POST['confirma-senha'];
									$_SESSION['status'] = $_POST['status'];						
								}
							}else{
								$erroData = "<p class='erro'>O nome <strong>".$_POST['nome']."</strong> já esta sendo utilizado em outro cadastro!</p>";
								$_SESSION['nome'] = "";
								$_SESSION['sobrenome'] = $_POST['sobrenome'];
								$_SESSION['filial'] = $_POST['filial'];
								$_SESSION['tipo-usuario'] = $_POST['tipo-usuario'];
								$_SESSION['leads-usuario'] = $_POST['leads-usuario'];
								$_SESSION['rua'] = $_POST['rua'];
								$_SESSION['numero'] = $_POST['numero'];
								$_SESSION['bairro'] = $_POST['bairro'];
								$_SESSION['cidade'] = $_POST['cidade'];
								$_SESSION['estado'] = $_POST['estado'];
								$_SESSION['telefone'] = $_POST['telefone'];
								$_SESSION['celular'] = $_POST['celular'];
								$_SESSION['email'] = $_POST['email'];
								$_SESSION['cpfCol'] = $_POST['cpfCol'];
								$_SESSION['rg'] = $_POST['rg'];
								$_SESSION['data'] = $_POST['data'];
								$_SESSION['sexo'] = $_POST['sexo'];
								$_SESSION['usuario'] = $_POST['usuario'];
								$_SESSION['senha'] = $_POST['senha'];
								$_SESSION['confirma-senha'] = $_POST['confirma-senha'];
								$_SESSION['status'] = $_POST['status'];								
							}
						}else{
							$erroData = "<p class='erro'>Limite de usuários atingido.</p><p class='erro'>Para mais informações entre em contato com a SoftBest.</p>";						
							$_SESSION['nome'] = "";
							$_SESSION['sobrenome'] = "";
							$_SESSION['filial'] = "";
							$_SESSION['tipo-usuario'] = "";
							$_SESSION['leads-usuario'] = "";
							$_SESSION['rua'] = "";
							$_SESSION['numero'] = "";
							$_SESSION['bairro'] = "";
							$_SESSION['cidade'] = "";
							$_SESSION['estado'] = "";
							$_SESSION['telefone'] = "";
							$_SESSION['celular'] = "";
							$_SESSION['email'] = "";
							$_SESSION['cpfCol'] = "";
							$_SESSION['rg'] = "";
							$_SESSION['data'] = "";
							$_SESSION['sexo'] = "";
							$_SESSION['usuario'] = "";
							$_SESSION['senha'] = "";
							$_SESSION['confirma-senha'] = "";
							$_SESSION['status'] = "";
						}
					}
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['sobrenome'] = "";
					$_SESSION['filial'] = "";
					$_SESSION['tipo-usuario'] = "";
					$_SESSION['rua'] = "";
					$_SESSION['numero'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['cidade'] = "";
					$_SESSION['estado'] = "";
					$_SESSION['telefone'] = "";
					$_SESSION['celular'] = "";
					$_SESSION['email'] = "";
					$_SESSION['cpfCol'] = "";
					$_SESSION['rg'] = "";
					$_SESSION['data'] = "";
					$_SESSION['sexo'] = "";
					$_SESSION['usuario'] = "";
					$_SESSION['senha'] = "";
					$_SESSION['confirma-senha'] = "";
					$_SESSION['status'] = "";		
				}
?>
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
					</script>

					<div id="cadastrar" style="display:<?php echo $erroData != "" ? 'block' : 'none';?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">
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
						<form name="formUsuarioes" action="<?php echo $configUrlGer; ?>cadastros/usuarios/" method="post" onSubmit="return valida_dados2(this)">
														
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="nome" name="nome" style="width:200px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
						
							<p class="bloco-campo-float"><label>Sobrenome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="sobrenome" name="sobrenome" style="width:250px;" required value="<?php echo $_SESSION['sobrenome']; ?>" /></p>

							<p class="bloco-campo-float"><label>Filial: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="filial" name="filial" style="width:150px;" required >
									<option value="">Selecione</option>
<?php
				$sqlFilial = "SELECT * FROM filiais WHERE statusFilial = 'T' ORDER BY nomeFilial ASC";
				$resultFilial = $conn->query($sqlFilial);
				while($dadosFilial = $resultFilial->fetch_assoc()){
?>
									<option value="<?php echo $dadosFilial['codFilial'] ;?>" <?php echo $_SESSION['filiais'] == $dadosFilial['codFilial'] ? '/SELECTED/' : '';?>><?php echo $dadosFilial['nomeFilial'] ;?></option>
<?php
				}
?>					
								</select>
							</p>
							
							<p class="bloco-campo-float"><label>Tipo Usuário: <span class="obrigatorio"> * </span></label>
							<input class="caixa" name="tipo-usuario" type="radio" value="A" <?php echo $_SESSION['tipo-usuario'] == "A" || $_SESSION['tipo-usuario'] == "" ? 'checked' : ''; ?> />Administrador   <input class="caixa" name="tipo-usuario" type="radio" value="C" <?php echo $_SESSION['tipo-usuario'] == 'C' ? 'checked' : ''; ?> />Corretor <input class="caixa" name="tipo-usuario" type="radio" value="CE" <?php echo $_SESSION['tipo-usuario'] == 'CE' ? 'checked' : ''; ?> />Corretor Externo</p>
							
							<br class="clear" />
							
							<p class="bloco-campo-float"><label>Rua:</label>
							<input class="campo" type="text" id="rua" name="rua" style="width:155px;" value="<?php echo $_SESSION['rua']; ?>"/></p>

							<p class="bloco-campo-float"><label>Número:</label>
							<input class="campo" type="text" id="numero" name="numero" style="width:50px;" value="<?php echo $_SESSION['numero']; ?>"onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer);">

							<p class="bloco-campo-float"><label>Bairro:</label>
							<input class="campo" type="text" id="bairro" name="bairro" style="width:190px;" value="<?php echo $_SESSION['bairro']; ?>"/></p>

							<p class="bloco-campo-float"><label>Estado: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="estado" name="estado" style="width:150px;" required onChange="carregaCidade(this.value);">
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
							
							<div id="sel-padrao">
								<p class="bloco-campo-float"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
									<select id="default-usage-select" id="cidade" class="campo" name="cidade" style="width:200px;">
										<option id="option" value="">Selecione um Estado primeiro</option>
									</select>
									<br class="clear"/>
								</p>
							</div>
							
							<div id="carrega-cidade">

							</div>

							<br class="clear" />

							<p class="bloco-campo-float"><label>CPF:</label>
							<input class="campo" type="text" id="cpfCol" name="cpfCol" style="width:200px;" value="<?php echo $_SESSION['cpfCol']; ?>" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf)" /></p>

							<p class="bloco-campo-float"><label>RG:</label>
							<input class="campo" type="text" id="rg" name="rg" style="width:175px;" value="<?php echo $_SESSION['rg']; ?>"/></p>
							
							<p class="bloco-campo-float"><label>Telefone:</label>
							<input class="campo" type="text" id="telefone" name="telefone" style="width:100px;" value="<?php echo $_SESSION['telefone']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<p class="bloco-campo-float"><label>Celular: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="celular" name="celular" style="width:100px;" required value="<?php echo $_SESSION['celular']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<p class="bloco-campo-float"><label>Sexo: <span class="obrigatorio"> * </span></label>
							<input class="caixa" id="sexo" name="sexo" type="radio" value="M" checked <?php echo $_SESSION['sexo'] == 'M' ? 'checked' : ''; ?> />Masculino   <input class="caixa" id="sexo2" name="sexo" type="radio" value="F" <?php echo $_SESSION['sexo'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
	
							<br class="clear" />

							<p class="bloco-campo-float"><label>Receber Leads? <span class="obrigatorio"> * </span></label>
							<input class="caixa" name="leads-usuario" id="leads-usuario2" type="radio" value="S" <?php echo $_SESSION['leads-usuario'] == "S" || $_SESSION['leads-usuario'] == "" ? 'checked' : ''; ?> />Sim   <input class="caixa" name="leads-usuario" id="leads-usuario" type="radio" value="N" <?php echo $_SESSION['leads-usuario'] == 'N' ? 'checked' : ''; ?> />Não</p>	

							<p class="bloco-campo-float"><label>E-mail: <span class="obrigatorio"> </span></label>
							<input class="campo" type="email" id="email" name="email" style="width:200px;" value="<?php echo $_SESSION['email']; ?>"/></p>
							
							<p class="bloco-campo-float"><label>Usuário: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="usuario" name="usuario" required style="width:130px;" value="<?php echo $_SESSION['usuario']; ?>" /></p>

							<div class="bloco-campo-float"><label>Senha: <span class="obrigatorio"> * </span></label>
								<input id="senha" class="campo" type="password" name="senha" required style="width:130px;" onkeyUp="checa_seguranca('senha', 'pass'), checa_seguranca_nome('senha', 'pass2');"  onkeydown="javascript:mostraBloco('bloco-pass');" value="<?php echo $_SESSION['senha']; ?>"/><br/>
								<div id="bloco-pass" style="position:absolute;">	
									<p id="pass2"></p>
									<p id="pass"></p>
								</div>
								<br class="clear" />	
							</div>	

							<div class="bloco-campo-float"><label>Confirmar Senha:<span class="obrigatorio"> * </span> </label>
							<input id="senha2" class="campo" type="password" name="confirma-senha" required style="width:130px;" onBlur="confere()" value="<?php echo $_SESSION['confirma-senha']; ?>" />
								<div id="compara"></div>
								<br class="clear" />
							</div>
						<br class="clear"/>
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Usuário" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>					
					
				</div>
				<div id="dados-conteudo">
					<div id="usuarios">
						<div id="tabela-usuarios">
<?php
				if($erroConteudo != ""){
					echo "<div class='area-erro'>";
						echo $erroConteudo;
					echo "</div>";
				}
				
				$sqlConta = "SELECT nomeUsuario, codFilial FROM usuarios WHERE codUsuario != 4 ".$filtraUsuario2;
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);				
				
				if($dadosConta['nomeUsuario'] != ""){
?>						
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq" >Nome</th>
									<th>Tipo Usuário</th>
									<th>Recebe Leads?</th>
									<th>Filial</th>
<?php
					if($filtraUsuario == ""){
?>
									<th>Permissões</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
<?php
					}else{
?>									
									<th class="canto-dir">Alterar</th>
<?php
					}
?>
								</tr>					
<?php
					if($url[3] != ""){
						if($url[5] == 1 || $url[5] == ""){
							$pagina = 1;
							$sqlUsuarioes = "SELECT * FROM filiais E inner join usuarios Co on Co.codFilial = E.codFilial WHERE Co.codUsuario != 4".$filtraUsuario." ORDER BY Co.statusUsuario ASC, Co.nomeUsuario ASC, E.nomeFilial ASC, Co.codEstado ASC, Co.codCidade ASC LIMIT 0,30";
						}else{
							$pagina = $url[4];
							$paginaFinal = $pagina * 30;
							$paginaInicial = $paginaFinal - 30;
							$sqlUsuarioes = "SELECT * FROM filiais E inner join usuarios Co on Co.codFilial = E.codFilial WHERE Co.codUsuario != 4".$filtraUsuario." ORDER BY Co.statusUsuario ASC, Co.nomeUsuario ASC, E.nomeFilial ASC, Co.codEstado ASC, Co.codCidade ASC LIMIT ".$paginaInicial.",30";
						}		
					}

					$resultUsuarioes = $conn->query($sqlUsuarioes);
					while($dadosUsuarioes = $resultUsuarioes->fetch_assoc()){
						$mostrando++;
						
						if($dadosUsuarioes['statusUsuario'] == "T"){
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
									<td class="quarenta"><a href='<?php echo $configUrlGer; ?>cadastros/usuarios/alterar/<?php echo $dadosUsuarioes['codUsuario'] ?>/' title='Veja os detalhes do usuário <?php echo $dadosUsuarioes['nomeUsuario'] ?>'><?php echo $dadosUsuarioes['nomeUsuario'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/usuarios/alterar/<?php echo $dadosUsuarioes['codUsuario'] ?>/' title='Veja os detalhes do usuário <?php echo $dadosUsuarioes['nomeUsuario'] ?>'><?php echo $dadosUsuarioes['tipoUsuario'] == "A" ? 'Administrador' : '';?> <?php echo $dadosUsuarioes['tipoUsuario'] == "C" ? 'Corretor' : '';?> <?php echo $dadosUsuarioes['tipoUsuario'] == "CE" ? 'Corretor Externo' : '';?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/usuarios/alterar/<?php echo $dadosUsuarioes['codUsuario'] ?>/' title='Veja os detalhes do usuário <?php echo $dadosUsuarioes['nomeUsuario'] ?>'><?php echo $dadosUsuarioes['leadsUsuario'] == "S" ? 'Sim' : 'Não';?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/usuarios/alterar/<?php echo $dadosUsuarioes['codUsuario'] ?>/' title='Veja os detalhes do usuário <?php echo $dadosUsuarioes['nomeUsuario'] ?>'><?php echo $dadosUsuarioes['nomeFilial'];?></a></td>
<?php
					if($filtraUsuario == ""){
?>
									<td class="botoes"><a href='<?php echo $configUrl; ?>configuracoes/permissoes/detalhes/<?php echo $dadosUsuarioes['codUsuario'] ?>/' title='Deseja dar permissões para o usuário <?php echo $dadosUsuarioes['nomeUsuario'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/icones-permicoes.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/usuarios/ativacao/<?php echo $dadosUsuarioes['codUsuario'] ?>/' title='Deseja <?php echo $statusPergunta ?> o usuário <?php echo $dadosUsuarioes['nomeUsuario'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/usuarios/alterar/<?php echo $dadosUsuarioes['codUsuario'] ?>/' title='Deseja alterar o usuário <?php echo $dadosUsuarioes['nomeUsuario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosUsuarioes['codUsuario'] ?>, "<?php echo htmlspecialchars($dadosUsuarioes['nomeUsuario']) ?>");' title='Deseja excluir o usuário <?php echo $dadosUsuarioes['nomeUsuario'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>

<?php
					}else{
?>	
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/usuarios/alterar/<?php echo $dadosUsuarioes['codUsuario'] ?>/' title='Deseja alterar o usuário <?php echo $dadosUsuarioes['nomeUsuario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>

<?php
					}
?>
								</tr>
<?php
					}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o usuário "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/usuarios/excluir/'+cod+'/';
										}
									  }
								 </script>
								 
							</table>	
<?php
				}
				
				if($url[3] != ""){
					$regPorPagina = 30;
					$area = "cadastros/usuarios";
					include ('f/conf/paginacao.php');		
				}else{
					$regPorPagina = 30;
					$area = "";
					include ('f/conf/paginacao-capa.php');
				}
?>							
						</div>
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
