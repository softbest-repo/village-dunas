<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "fornecedores";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlNomeFornecedor = "SELECT * FROM fornecedores WHERE codFornecedor = '".$url[6]."' LIMIT 0,1";
				$resultNomeFornecedor = $conn->query($sqlNomeFornecedor);
				$dadosNomeFornecedor = $resultNomeFornecedor->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Fornecedores</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeFornecedor['nomeFornecedor'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeFornecedor['statusFornecedor'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/ativacao/<?php echo $dadosNomeFornecedor['codFornecedor'] ?>/' title='Deseja <?php echo $statusPergunta ?> o fornecedor <?php echo $dadosNomeFornecedor['nomeFornecedor'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeFornecedor['codFornecedor'] ?>, "<?php echo htmlspecialchars($dadosNomeFornecedor['nomeFornecedor']) ?>");' title='Deseja excluir o fornecedor <?php echo $dadosNomeFornecedor['nomeFornecedor'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o fornecedor "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/fornecedores/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar" style="float:left;"><a href="<?php echo $configUrl;?>cadastros/fornecedores/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
					<br class="clear"/>
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if($_POST['alterar'] != ""){

					if($_POST['nascimento'] != ""){
						$data = data($_POST['nascimento']);
					}else{
						$data = NULL;
					}					

					$sql = "UPDATE fornecedores SET tipoFornecedor = '".$_POST['tipoPessoa']."', razaoFornecedor = '".$_POST['razao']."', nomeFornecedor = '".$_POST['nome']."', cpfFornecedor = '".$_POST['cpf']."', rgFornecedor = '".$_POST['rg']."', emissorFornecedor = '".$_POST['emissor']."', sexoFornecedor = '".$_POST['sexo']."', nascimentoFornecedor = '".$data."', enderecoFornecedor = '".$_POST['endereco']."', numeroFornecedor = '".$_POST['numero']."', bairroFornecedor = '".$_POST['bairro']."', codEstado = '".$_POST['estado']."', codCidade = '".$_POST['cidade']."', cepFornecedor = '".$_POST['cep']."', emailFornecedor = '".$_POST['email']."', telefoneFornecedor = '".$_POST['telefone']."', celularFornecedor = '".$_POST['celular']."' WHERE codFornecedor = ".$url[6]."";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['fantasia'] = $_POST['fantasia'];
						$_SESSION['alterar'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/fornecedores/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar fornecedor!</p>";
					}

				}else{
					$sql = "SELECT * FROM fornecedores WHERE codFornecedor = ".$url[6]." LIMIT 0,1";
					$result = $conn->query($sql);
					$dadosFornecedor = $result->fetch_assoc();
					$_SESSION['tipoPessoa'] = $dadosFornecedor['tipoFornecedor'];
					$_SESSION['razao'] = $dadosFornecedor['razaoFornecedor'];
					$_SESSION['nome'] = $dadosFornecedor['nomeFornecedor'];
					$_SESSION['cpf'] = $dadosFornecedor['cpfFornecedor'];
					$_SESSION['rg'] = $dadosFornecedor['rgFornecedor'];
					$_SESSION['emissor'] = $dadosFornecedor['emissorFornecedor'];
					$_SESSION['sexo'] = $dadosFornecedor['sexoFornecedor'];
					if($dadosFornecedor['nascimentoFornecedor'] == "0000-00-00"){
						$_SESSION['nascimento'] = "";
					}else{
						$_SESSION['nascimento'] = data($dadosFornecedor['nascimentoFornecedor']);
					}
					$_SESSION['endereco'] = $dadosFornecedor['enderecoFornecedor'];
					$_SESSION['numero'] = $dadosFornecedor['numeroFornecedor'];
					$_SESSION['bairro'] = $dadosFornecedor['bairroFornecedor'];
					$_SESSION['estado'] = $dadosFornecedor['codEstado'];
					$_SESSION['cidade'] = $dadosFornecedor['codCidade'];
					$_SESSION['cep'] = $dadosFornecedor['cepFornecedor'];
					$_SESSION['email'] = $dadosFornecedor['emailFornecedor'];
					$_SESSION['telefone'] = $dadosFornecedor['telefoneFornecedor'];
					$_SESSION['celular'] = $dadosFornecedor['celularFornecedor'];				
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
							function mascaraMutuario(o,f){
								v_obj=o
								v_fun=f
								setTimeout('execmascara()',1)
							}
							 
							function execmascara(){
								v_obj.value=v_fun(v_obj.value)
							}
							 
							function cpfCnpj(v){
							 
								//Remove tudo o que não é dígito
								v=v.replace(/\D/g,"")
							 
								if (v.length <= 13) { //CPF
							 
									//Coloca um ponto entre o terceiro e o quarto dígitos
									v=v.replace(/(\d{3})(\d)/,"$1.$2")
							 
									//Coloca um ponto entre o terceiro e o quarto dígitos
									//de novo (para o segundo bloco de números)
									v=v.replace(/(\d{3})(\d)/,"$1.$2")
							 
									//Coloca um hífen entre o terceiro e o quarto dígitos
									v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
							 
								} else { //CNPJ
							 
									//Coloca ponto entre o segundo e o terceiro dígitos
									v=v.replace(/^(\d{2})(\d)/,"$1.$2")
							 
									//Coloca ponto entre o quinto e o sexto dígitos
									v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
							 
									//Coloca uma barra entre o oitavo e o nono dígitos
									v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
							 
									//Coloca um hífen depois do bloco de quatro dígitos
									v=v.replace(/(\d{4})(\d)/,"$1-$2")
							 
								}
							 
								return v
							 
							}
							
							function habilitaCampo(){
								document.getElementById("tipoPessoa1").disabled = false;
								document.getElementById("tipoPessoa2").disabled = false;
								document.getElementById("nome").disabled = false;
<?php
				if($_SESSION['tipoPessoa'] == "J"){
?>
								document.getElementById("razao").disabled = false;
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
								document.getElementById("numero").disabled = false;        
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
								$tgf.post("<?php echo $configUrl;?>cadastros/fornecedores/carrega-cidade.php", {codEstado: cod}, function(data){
									$tgf("#carrega-cidade").html(data);
									$tgf("#sel-padrao").css("display", "none");																									
								});
							}	

							function trocaLabel(cod){
								if(cod == 'F'){
									document.getElementById("label-nome").innerHTML="Nome *";
									document.getElementById("label-cpf").innerHTML="CPF: *";
									document.getElementById("label-rg").innerHTML="RG:";
									document.getElementById("campo-razao").style.display="none";
									document.getElementById("razao").value="";
									document.getElementById("br-fornecedor-1").style.display="none";
									document.getElementById("br-fornecedor-2").style.display="block";
									document.getElementById("campo-nascimento").style.display="block";
									document.getElementById("campo-orgao").style.display="block";
									document.getElementById("campo-sexo").style.display="block";							
									document.getElementById("razao").disabled="disabled";							
								}else{
									document.getElementById("label-nome").innerHTML="Nome Fantasia: *";
									document.getElementById("label-cpf").innerHTML="CNPJ *";
									document.getElementById("label-rg").innerHTML="Inscrição Estadual:";
									document.getElementById("campo-razao").style.display="block";
									document.getElementById("br-fornecedor-1").style.display="block";
									document.getElementById("br-fornecedor-2").style.display="none";
									document.getElementById("campo-nascimento").style.display="none";
									document.getElementById("campo-orgao").style.display="none";
									document.getElementById("campo-sexo").style.display="none";		
									document.getElementById("razao").disabled="";																					
								}
							}
						 </script>
		

						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>		
						<form name="formFornecedor" action="<?php echo $configUrlGer; ?>cadastros/fornecedores/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Tipo Pessoa: </label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-right:25px; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> onClick="trocaLabel('F');" <?php echo $_SESSION['tipoPessoa'] == 'F' ? 'checked' : '';?> name="tipoPessoa" id="tipoPessoa1" value="F"/>Pessoa Física</label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" name="tipoPessoa" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="tipoPessoa2" onClick="trocaLabel('J');" <?php echo $_SESSION['tipoPessoa'] == 'J' ? 'checked' : '';?> value="J"/>Pessoa Jurídica</label>
								<br class="clear"/>
							</p>

							<p class="bloco-campo-float" id="campo-razao" style="display:<?php echo $_SESSION['tipoPessoa'] == "F" ? 'none' : 'block';?>;"><label>Razão Social: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:247px;" <?php echo $_SESSION['tipoPessoa'] == "F" ? 'disabled' : 'disabled';?> id="razao" required name="razao" value="<?php echo $_SESSION['razao']; ?>" /></p>

							<p class="bloco-campo-float"><label id="label-nome"><?php echo $_SESSION['tipoPessoa'] == "F" ? 'Nome' : 'Nome Fantasia';?>: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:257px;" id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label id="label-cpf">CPF: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="cpf" name="cpf" value="<?php echo $_SESSION['cpf']; ?>" onKeyDown="mascaraMutuario(this,cpfCnpj);" onKeyPress="mascaraMutuario(this,cpfCnpj);" onKeyUp="mascaraMutuario(this,cpfCnpj);"/></p>

							<br class="clear" id="br-fornecedor-1" style="display:<?php echo $_SESSION['tipoPessoa'] == "F" ? 'none' : 'block';?>;"/>

							<p class="bloco-campo-float"><label id="label-rg"><?php echo $_SESSION['tipoPessoa'] == "F" ? 'RG' : 'Inscrição Estadual';?>: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:130px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="rg" id="rg" value="<?php echo $_SESSION['rg']; ?>"/></p>

							<p class="bloco-campo-float" id="campo-orgao" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"><label>Orgão Emissor: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:100px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="emissor" id="emissor" value="<?php echo $_SESSION['emissor']; ?>"/></p>

							<br class="clear" id="br-fornecedor-2" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"/>

							<p class="bloco-campo-float" id="campo-sexo" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"><label>Sexo: <span class="obrigatorio"> * </span></label>
							<input class="caixa" name="sexo" id="sexo1" type="radio" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="M" <?php echo $_SESSION['sexo'] == "M" || $_SESSION['sexo'] == "" ? 'checked' : ''; ?> />Masculino   <input class="caixa" id="sexo2" name="sexo" type="radio" value="F" <?php echo $_SESSION['sexo'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
							
							<p class="bloco-campo-float" id="campo-nascimento" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"><label>Data de Nascimento: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="nascimento" id="nascimento" value="<?php echo $_SESSION['nascimento']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

							<p class="bloco-campo-float"><label>Endereço:</label>
							<input class="campo-4" type="text" style="width:260px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="endereco" id="endereco" value="<?php echo $_SESSION['endereco']; ?>"/></p>

							<p class="bloco-campo-float"><label>Número:</label>
							<input class="campo-4" type="text" style="width:96px;"  <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="numero" id="numero" value="<?php echo $_SESSION['numero']; ?>"/></p>
							
							<br class="clear"/>

							<p class="bloco-campo-float"><label>Bairro:</label>
							<input class="campo-3" type="text" style="width:165px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:175px;" name="bairro" id="bairro" value="<?php echo $_SESSION['bairro']; ?>"/></p>
							
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
				if($_SESSION['estado'] == ""){
?>													
							<div id="sel-padrao">
								<p class="bloco-campo-float"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
									<select id="default-usage-select" id="cidade" class="campo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="cidade" style="width:215px;">
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
				if($_SESSION['estado'] != ""){
?>
								<p class="bloco-campo-float"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
									<select class="campo" name="cidade" style="width:215px;" id="cidade" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>>
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

							<br class="clear" />						

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
					$_SESSION['loteFiltro'] = "";
					$_SESSION['quadraFiltro'] = "";
					$_SESSION['bairroFiltro'] = "";					
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
