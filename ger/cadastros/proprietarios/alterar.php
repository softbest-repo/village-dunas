<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "proprietarios";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeProprietario = "SELECT * FROM proprietarios WHERE codProprietario = '".$url[6]."'".$filtraUsuario." LIMIT 0,1";
				$resultNomeProprietario = $conn->query($sqlNomeProprietario);
				$dadosNomeProprietario = $resultNomeProprietario->fetch_assoc();
				
				if($dadosNomeProprietario['codUsuario'] == ""){
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/proprietarios/'>";					
				}
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Proprietários</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeProprietario['nomeProprietario'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeProprietario['statusProprietario'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/ativacao/<?php echo $dadosNomeProprietario['codProprietario'] ?>/' title='Deseja <?php echo $statusPergunta ?> o proprietário <?php echo $dadosNomeProprietario['nomeProprietario'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeProprietario['codProprietario'] ?>, "<?php echo htmlspecialchars($dadosNomeProprietario['nomeProprietario']) ?>");' title='Deseja excluir o proprietário <?php echo $dadosNomeProprietario['nomeProprietario'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o proprietário "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/proprietarios/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar" style="float:left;"><a href="<?php echo $configUrl;?>cadastros/proprietarios/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
					<br class="clear"/>
				</div>
				<script type="text/javascript">
					function imprimeRequisicao(id, pg) {
						 var oPrint, oJan;
						 var $r = jQuery.noConflict();
						 document.getElementById("botao-imprimir").style.display="table";
						 $r("#conteudo-imprimir").fadeOut("slow");
						 oPrint = window.document.getElementById(id).innerHTML;
						 oJan = window.open(pg);
						 oJan.document.write(oPrint);
						 oJan.history.go();
					}						

					function fechaArquivo(){
						var $rr = jQuery.noConflict();
						$rr("#conteudo-imprimir").fadeOut("slow");
					}
					
					function abrirImprimir(){
						var $ee = jQuery.noConflict();
						$ee("#conteudo-imprimir").fadeIn("slow");
						 document.getElementById("botao-imprimir").style.display="none";						
					}
					
					function abreValidade(){
						document.getElementById("validadeSpan").style.display="none";
						document.getElementById("validadeInput").style.display="unset";
						document.getElementById("validadeInput").focus();
					}
					
					function salvaValidade(){
						var $ss = jQuery.noConflict();

						var validade = document.getElementById("validadeInput").value;
						var codProprietario = "<?php echo $url[6];?>";
						
						$ss.post("<?php echo $configUrlGer;?>cadastros/proprietarios/salva-validade.php", {codProprietario: codProprietario, validade: validade}, function(data){	
							if(validade != ""){
								document.getElementById("validadeSpan").innerHTML=validade;
								document.getElementById("validadeSpan").style.display="unset";
							}else{
								document.getElementById("validadeSpan").innerHTML="<span onClick='abreValidade();' style='cursor:pointer; font-size:12px; border:1px solid #000; padding-left:5px; padding-right:5px;'>editar</span>";
								document.getElementById("validadeSpan").style.display="unset"								
							}
							document.getElementById("validadeInput").style.display="none";
						});													
					}
				</script>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if($_POST['alterar'] != ""){

					if($_POST['usuario'] == ""){
						$usuario = $_COOKIE['codAprovado'.$cookie];
					}else{
						$usuario = $_POST['usuario'];
					}

					$sql = "UPDATE proprietarios SET codUsuario = ".$usuario.", nomeProprietario = '".$_POST['nome']."', cpfProprietario = '".$_POST['cpf']."', rgProprietario = '".$_POST['rg']."', emissorProprietario = '".$_POST['emissor']."', sexoProprietario = '".$_POST['sexo']."', nascimentoProprietario = '".data($_POST['nascimento'])."', enderecoProprietario = '".$_POST['endereco']."', bairroProprietario = '".$_POST['bairro']."', codEstado = '".$_POST['estado']."', codCidade = '".$_POST['cidade']."', cepProprietario = '".$_POST['cep']."', emailProprietario = '".$_POST['email']."', telefoneProprietario = '".$_POST['telefone']."', celularProprietario = '".$_POST['celular']."' WHERE codProprietario = ".$url[6]."";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['fantasia'] = $_POST['fantasia'];
						$_SESSION['alterar'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/proprietarios/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar filiado!</p>";
					}

				}else{
					$sql = "SELECT * FROM proprietarios WHERE codProprietario = ".$url[6]." LIMIT 0,1";
					$result = $conn->query($sql);
					$dadosProprietario = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosProprietario['nomeProprietario'];
					$_SESSION['usuario'] = $dadosProprietario['codUsuario'];
					$_SESSION['cpf'] = $dadosProprietario['cpfProprietario'];
					$_SESSION['rg'] = $dadosProprietario['rgProprietario'];
					$_SESSION['emissor'] = $dadosProprietario['emissorProprietario'];
					$_SESSION['escola'] = $dadosProprietario['escolaProprietario'];
					$_SESSION['lotacao'] = $dadosProprietario['lotacaoProprietario'];
					$_SESSION['cargo'] = $dadosProprietario['cargoProprietario'];
					$_SESSION['matricula'] = $dadosProprietario['matriculaProprietario'];
					$_SESSION['sexo'] = $dadosProprietario['sexoProprietario'];
					$_SESSION['contratacao'] = $dadosProprietario['contratacaoProprietario'];
					$_SESSION['civil'] = $dadosProprietario['civilProprietario'];
					$_SESSION['situacao'] = $dadosProprietario['situacaoProprietario'];
					if($dadosProprietario['nascimentoProprietario'] == "0000-00-00"){
						$_SESSION['nascimento'] = "";
					}else{
						$_SESSION['nascimento'] = data($dadosProprietario['nascimentoProprietario']);
					}
					$_SESSION['endereco'] = $dadosProprietario['enderecoProprietario'];
					$_SESSION['bairro'] = $dadosProprietario['bairroProprietario'];
					$_SESSION['estado'] = $dadosProprietario['codEstado'];
					$_SESSION['cidade'] = $dadosProprietario['codCidade'];
					$_SESSION['cep'] = $dadosProprietario['cepProprietario'];
					$_SESSION['email'] = $dadosProprietario['emailProprietario'];
					$_SESSION['telefone'] = $dadosProprietario['telefoneProprietario'];
					$_SESSION['celular'] = $dadosProprietario['celularProprietario'];
					$_SESSION['dependentes'] = $dadosProprietario['dependentesProprietario'];
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
<?php
				if($usuario == "A"){
?>
								document.getElementById("usuario").disabled = false;
<?php
				}
?>								
								document.getElementById("cpf").disabled = false;
								document.getElementById("rg").disabled = false;
								document.getElementById("emissor").disabled = false;
								document.getElementById("sexo1").disabled = false;
								document.getElementById("sexo2").disabled = false;
								document.getElementById("nascimento").disabled = false;
								document.getElementById("endereco").disabled = false;        
								document.getElementById("bairro").disabled = false;        
								document.getElementById("estado").disabled = false;
								document.getElementById("cidade").disabled = false;
								document.getElementById("cep").disabled = false;
								document.getElementById("email").disabled = false;
								document.getElementById("telefone").disabled = false;
								document.getElementById("celular").disabled = false;
								document.getElementById("alterar").disabled = false;
							}

							function carregaCidade(cod){
								var $tgf = jQuery.noConflict();
								$tgf.post("<?php echo $configUrl;?>cadastros/proprietarios/carrega-cidade.php", {codEstado: cod}, function(data){
									$tgf("#carrega-cidade").html(data);
									$tgf("#sel-padrao").css("display", "none");																									
								});
							}	
						 </script>
		

						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>		
						<form name="formProprietario" action="<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="usuario" name="usuario" style="width:190px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required>
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

							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:240px;" id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label>CPF: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="cpf" id="cpf" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['cpf']; ?>" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);"/></p>

							<p class="bloco-campo-float"><label>RG: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="rg" id="rg" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['rg']; ?>"/></p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label>Orgão Emissor: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="emissor" id="emissor" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>  value="<?php echo $_SESSION['emissor']; ?>"/></p>

							<p class="bloco-campo-float"><label>Sexo: <span class="obrigatorio"> * </span></label>
							<input class="caixa" name="sexo" id="sexo1" type="radio" value="M" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> <?php echo $_SESSION['sexo'] == 'M' ? 'checked' : ''; ?> />Masculino   <input disabled="disabled" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="caixa" name="sexo" id="sexo2" type="radio" value="F" <?php echo $_SESSION['sexo'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
							
							<p class="bloco-campo-float"><label>Data de Nascimento: <span class="obrigatorio"> * </span></label>
							<input class="campo-5" type="text" style="width:150px;" required name="nascimento" id="nascimento" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['nascimento']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

							<p class="bloco-campo-float"><label>Endereço:</label>
							<input class="campo-4" type="text" style="width:285px;" name="endereco" id="endereco" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['endereco']; ?>"/></p>
							
							<br class="clear"/>

							<p class="bloco-campo-float"><label>Bairro:</label>
							<input class="campo-3" type="text" style="width:167px;" name="bairro" id="bairro" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['bairro']; ?>"/></p>
							
							<p class="bloco-campo-float"><label>Estado: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="estado" name="estado" style="width:190px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required onChange="carregaCidade(this.value);">
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
									<select id="default-usage-select" id="cidade" class="campo" name="cidade" style="width:288px;">
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
									<select class="campo" name="cidade" style="width:288px;" id="cidade" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>>
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
							
							<p class="bloco-campo-float"><label>CEP:</label>
							<input class="campo-3" type="text" style="width:99px;" name="cep" id="cep" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['cep']; ?>" onKeyDown="Mascara(this,Cep);" onKeyPress="Mascara(this,Cep);" onKeyUp="Mascara(this,Cep)"/></p>
								
							<br class="clear"/>	

							<p class="bloco-campo-float"><label>E-mail:</label>
							<input class="campo-7" type="email" style="width:240px;" name="email" id="email" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['email']; ?>"/></p>
								
							<p class="bloco-campo-float"><label>Telefone: </label>
							<input class="campo-6" type="text" style="width:110px;" name="telefone" id="telefone" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['telefone']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<p class="bloco-campo-float"><label>Celular: </label>
							<input class="campo-6" type="text" style="width:110px;" name="celular" id="celular" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['celular']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<br class="clear"/>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="botao" type="submit" name="alterar" title="Alterar" value="Alterar"/><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['cpf'] = "";
					$_SESSION['rg'] = "";
					$_SESSION['emissor'] = "";
					$_SESSION['escola'] = "";
					$_SESSION['lotacao'] = "";
					$_SESSION['cargo'] = "";
					$_SESSION['matricula'] = "";
					$_SESSION['sexo'] = "";
					$_SESSION['contratacao'] = "";
					$_SESSION['civil'] = "";
					$_SESSION['situacao'] = "";
					$_SESSION['nascimento'] = "";
					$_SESSION['endereco'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['estado'] = "";
					$_SESSION['cidade'] = "";
					$_SESSION['cep'] = "";		
					$_SESSION['email'] = "";		
					$_SESSION['telefone'] = "";		
					$_SESSION['celular'] = "";	
					$_SESSION['dependentes'] = "";	
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
