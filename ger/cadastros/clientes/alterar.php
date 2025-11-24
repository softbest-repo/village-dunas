<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "clientes";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlNomeCliente = "SELECT * FROM clientes WHERE codCliente = '".$url[6]."' LIMIT 0,1";
				$resultNomeCliente = $conn->query($sqlNomeCliente);
				$dadosNomeCliente = $resultNomeCliente->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Clientes</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeCliente['nomeCliente'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeCliente['statusCliente'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/clientes/ativacao/<?php echo $dadosNomeCliente['codCliente'] ?>/' title='Deseja <?php echo $statusPergunta ?> o cliente <?php echo $dadosNomeCliente['nomeCliente'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeCliente['codCliente'] ?>, "<?php echo htmlspecialchars($dadosNomeCliente['nomeCliente']) ?>");' title='Deseja excluir o cliente <?php echo $dadosNomeCliente['nomeCliente'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o cliente "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/clientes/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar" style="float:left;"><a href="<?php echo $configUrl;?>cadastros/clientes/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
					<br class="clear"/>
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if($_POST['alterar'] != ""){

					$sql = "UPDATE clientes SET tipoCliente = '".$_POST['tipoPessoa']."', codUsuario = ".$_POST['corretor'].", razaoCliente = '".$_POST['razao']."', nomeCliente = '".$_POST['nome']."', cpfCliente = '".$_POST['cpf']."', rgCliente = '".$_POST['rg']."', emissorCliente = '".$_POST['emissor']."', sexoCliente = '".$_POST['sexo']."', nascimentoCliente = '".data($_POST['nascimento'])."', civilCliente = '".$_POST['civil']."', nacionalidadeCliente = '".$_POST['nacionalidade']."', profissaoCliente = '".$_POST['profissao']."', nomeConjugueCliente = '".$_POST['nomeConjugue']."', cpfConjugueCliente = '".$_POST['cpfConjugue']."', rgConjugueCliente = '".$_POST['rgConjugue']."', emissorConjugueCliente = '".$_POST['emissorConjugue']."', sexoConjugueCliente = '".$_POST['sexoConjugue']."', nascimentoConjugueCliente = '".data($_POST['nascimentoConjugue'])."', nacionalidadeConjugueCliente = '".$_POST['nacionalidadeConjugue']."', profissaoConjugueCliente = '".$_POST['profissaoConjugue']."', enderecoCliente = '".$_POST['endereco']."', numeroCliente = '".$_POST['numero']."', bairroCliente = '".$_POST['bairro']."', codPais = '".$_POST['pais']."', codEstado = '".$_POST['estado']."', codCidade = '".$_POST['cidade']."', cepCliente = '".$_POST['cep']."', emailCliente = '".$_POST['email']."', telefoneCliente = '".$_POST['telefone']."', celularCliente = '".$_POST['celular']."' WHERE codCliente = ".$url[6]."";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alterar'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/clientes/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar cliente!</p>";
					}

				}else{
					$sql = "SELECT * FROM clientes WHERE codCliente = ".$url[6]." LIMIT 0,1";
					$result = $conn->query($sql);
					$dadosCliente = $result->fetch_assoc();
					$_SESSION['tipoPessoa'] = $dadosCliente['tipoCliente'];
					$_SESSION['razao'] = $dadosCliente['razaoCliente'];
					$_SESSION['nome'] = $dadosCliente['nomeCliente'];
					$_SESSION['corretor'] = $dadosCliente['codUsuario'];
					$_SESSION['cpf'] = $dadosCliente['cpfCliente'];
					$_SESSION['rg'] = $dadosCliente['rgCliente'];
					$_SESSION['emissor'] = $dadosCliente['emissorCliente'];
					$_SESSION['sexo'] = $dadosCliente['sexoCliente'];
					if($dadosCliente['nascimentoCliente'] == "0000-00-00"){
						$_SESSION['nascimento'] = "";
					}else{
						$_SESSION['nascimento'] = data($dadosCliente['nascimentoCliente']);
					}
					$_SESSION['civil'] = $dadosCliente['civilCliente'];
					$_SESSION['nacionalidade'] = $dadosCliente['nacionalidadeCliente'];
					$_SESSION['profissao'] = $dadosCliente['profissaoCliente'];
					$_SESSION['nomeConjugue'] = $dadosCliente['nomeConjugueCliente'];
					$_SESSION['cpfConjugue'] = $dadosCliente['cpfConjugueCliente'];
					$_SESSION['rgConjugue'] = $dadosCliente['rgConjugueCliente'];
					$_SESSION['emissorConjugue'] = $dadosCliente['emissorConjugueCliente'];
					$_SESSION['sexoConjugue'] = $dadosCliente['sexoConjugueCliente'];
					$_SESSION['nacionalidadeConjugue'] = $dadosCliente['nacionalidadeConjugueCliente'];
					$_SESSION['profissaoConjugue'] = $dadosCliente['profissaoConjugueCliente'];
					if($dadosCliente['nascimentoConjugueCliente'] == "0000-00-00"){
						$_SESSION['nascimentoConjugue'] = "";
					}else{
						$_SESSION['nascimentoConjugue'] = data($dadosCliente['nascimentoConjugueCliente']);
					}
					$_SESSION['endereco'] = $dadosCliente['enderecoCliente'];
					$_SESSION['numero'] = $dadosCliente['numeroCliente'];
					$_SESSION['bairro'] = $dadosCliente['bairroCliente'];
					$_SESSION['pais'] = $dadosCliente['codPais'];
					$_SESSION['estado'] = $dadosCliente['codEstado'];
					$_SESSION['cidade'] = $dadosCliente['codCidade'];
					$_SESSION['cep'] = $dadosCliente['cepCliente'];
					$_SESSION['email'] = $dadosCliente['emailCliente'];
					$_SESSION['telefone'] = $dadosCliente['telefoneCliente'];
					$_SESSION['celular'] = $dadosCliente['celularCliente'];
					$_SESSION['loteFiltro'] = $dadosCliente['loteFiltroCliente'];
					$_SESSION['quadraFiltro'] = $dadosCliente['quadraFiltroCliente'];
					$_SESSION['bairroFiltro'] = $dadosCliente['bairroFiltroCliente'];
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
				}else{
?>
								document.getElementById("nomeConjugue").disabled = false;
								document.getElementById("cpfConjugue").disabled = false;
								document.getElementById("rgConjugue").disabled = false;
								document.getElementById("emissorConjugue").disabled = false;
								document.getElementById("sexo1Conjugue").disabled = false;
								document.getElementById("sexo2Conjugue").disabled = false;
								document.getElementById("nascimentoConjugue").disabled = false;
								document.getElementById("nacionalidadeConjugue").disabled = false;
								document.getElementById("profissaoConjugue").disabled = false;
								document.getElementById("civil").disabled = false;
<?php					
				}
?>
								document.getElementById("corretor").disabled = false;								
								document.getElementById("cpf").disabled = false;
								document.getElementById("rg").disabled = false;
								document.getElementById("emissor").disabled = false;
								document.getElementById("sexo1").disabled = false;
								document.getElementById("sexo2").disabled = false;
								document.getElementById("nascimento").disabled = false;
								document.getElementById("endereco").disabled = false;        
								document.getElementById("numero").disabled = false;        
								document.getElementById("bairro").disabled = false;        
								document.getElementById("nacionalidade").disabled = false;        
								document.getElementById("profissao").disabled = false;        
								document.getElementById("pais").disabled = false;
								document.getElementById("estado").disabled = false;
								document.getElementById("cidade").disabled = false;
								document.getElementById("cep").disabled = false;
								document.getElementById("email").disabled = false;
								document.getElementById("telefone").disabled = false;
								document.getElementById("celular").disabled = false;
								document.getElementById("alterar").disabled = false;
							}

							function carregaEstado(cod){
								var $tgf2 = jQuery.noConflict();
								$tgf2.post("<?php echo $configUrl;?>cadastros/clientes/carrega-estado.php", {codPais: cod}, function(data){
									$tgf2("#carrega-estado").html(data);
									$tgf2("#sel-padrao-estado").css("display", "none");																									
								});
								
								carregaCidade(0);
							}

							function carregaCidade(cod) {
								var $tgf = jQuery.noConflict();

								return new Promise((resolve, reject) => {
									$tgf.post("<?php echo $configUrl;?>cadastros/clientes/carrega-cidade.php", { codEstado: cod }, function(data) {
										$tgf("#carrega-cidade").html(data);
										$tgf("#sel-padrao-cidade").css("display", "none");

										resolve(data); 
									}).fail(function(jqXHR, textStatus, errorThrown) {
										reject(errorThrown);
									});
								});
							}

							function trocaLabel(cod){
								if(cod == 'F'){
									document.getElementById("label-nome").innerHTML="Nome *";
									document.getElementById("label-cpf").innerHTML="CPF:";
									document.getElementById("label-rg").innerHTML="RG:";
									document.getElementById("campo-razao").style.display="none";
									document.getElementById("br-cliente-1").style.display="none";
									document.getElementById("br-cliente-2").style.display="block";
									document.getElementById("br-cliente-3").style.display="block";
									document.getElementById("br-cliente-4").style.display="none";
									document.getElementById("br-cliente-5").style.display="block";
									document.getElementById("br-cliente-7").style.display="block";
									document.getElementById("campo-nascimento").style.display="block";
									document.getElementById("campo-civil").style.display="block";
									document.getElementById("campo-orgao").style.display="block";
									document.getElementById("campo-nacionalidade").style.display="block";
									document.getElementById("campo-profissao").style.display="block";
									document.getElementById("campo-sexo").style.display="block";
									if(document.getElementById("civil").value=="C"){
										document.getElementById("bloco-conjugue").style.display="table";
									}else{
										document.getElementById("bloco-conjugue").style.display="none";
									}							
									document.getElementById("razao").disabled="disabled";							
									document.getElementById("civil").disabled="";							
								}else{
									document.getElementById("label-nome").innerHTML="Nome Fantasia: *";
									document.getElementById("label-cpf").innerHTML="CNPJ";
									document.getElementById("label-rg").innerHTML="Inscrição Estadual:";
									document.getElementById("campo-razao").style.display="block";
									document.getElementById("br-cliente-1").style.display="block";
									document.getElementById("br-cliente-2").style.display="none";
									document.getElementById("br-cliente-3").style.display="none";
									document.getElementById("br-cliente-4").style.display="block";
									document.getElementById("br-cliente-5").style.display="none";
									document.getElementById("br-cliente-7").style.display="none";
									document.getElementById("campo-nascimento").style.display="none";
									document.getElementById("campo-civil").style.display="none";
									document.getElementById("campo-orgao").style.display="none";
									document.getElementById("campo-nacionalidade").style.display="none";
									document.getElementById("campo-profissao").style.display="none";
									document.getElementById("campo-sexo").style.display="none";		
									document.getElementById("bloco-conjugue").style.display="none";		
									document.getElementById("razao").disabled="";																					
									document.getElementById("civil").disabled="disabled";																					
								}
							}
							
							function trocaCivil(cod){
								if(cod == "C" || cod == "U"){
									document.getElementById("bloco-conjugue").style.display="table";
								}else{
									document.getElementById("bloco-conjugue").style.display="none";
								}
							}
						 </script>
		

						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>		
						<form name="formCliente" action="<?php echo $configUrlGer;?>cadastros/clientes/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Tipo Pessoa: </label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-right:25px; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> onClick="trocaLabel('F');" <?php echo $_SESSION['tipoPessoa'] == 'F' ? 'checked' : '';?> name="tipoPessoa" id="tipoPessoa1" value="F"/>Pessoa Física</label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" name="tipoPessoa" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="tipoPessoa2" onClick="trocaLabel('J');" <?php echo $_SESSION['tipoPessoa'] == 'J' ? 'checked' : '';?> value="J"/>Pessoa Jurídica</label>
								<br class="clear"/>
							</p>
							
							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="corretor" name="corretor" style="width:190px;" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>>
									<option value="">Selecione</option>
<?php
				$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
										<option value="<?php echo $dadosUsuario['codUsuario'] ;?>" <?php echo $_SESSION['corretor'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
}
?>			
								</select>
								<br class="clear"/>
							</p>

							<p class="bloco-campo-float" id="campo-razao" style="display:<?php echo $_SESSION['tipoPessoa'] == "F" ? 'none' : 'block';?>;"><label>Razão Social: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:247px;" <?php echo $_SESSION['tipoPessoa'] == "F" ? 'disabled' : 'disabled';?> id="razao" required name="razao" value="<?php echo $_SESSION['razao']; ?>" /></p>

							<p class="bloco-campo-float"><label id="label-nome"><?php echo $_SESSION['tipoPessoa'] == "F" ? 'Nome' : 'Nome Fantasia';?>: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:317px;" id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<br class="clear" id="br-cliente-1" style="display:<?php echo $_SESSION['tipoPessoa'] == "F" ? 'none' : 'block';?>;"/>

							<p class="bloco-campo-float"><label id="label-cpf">CPF: <span class="obrigatorio"> * </span></label>
							<input class="campo-5" type="text" style="width:150px;" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="cpf" name="cpf" value="<?php echo $_SESSION['cpf']; ?>" onKeyDown="mascaraMutuario(this,cpfCnpj);" onKeyPress="mascaraMutuario(this,cpfCnpj);" onKeyUp="mascaraMutuario(this,cpfCnpj);"/></p>

							<p class="bloco-campo-float"><label id="label-rg"><?php echo $_SESSION['tipoPessoa'] == "F" ? 'RG' : 'Inscrição Estadual';?>: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:130px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="rg" id="rg" value="<?php echo $_SESSION['rg']; ?>"/></p>

							<br class="clear" id="br-cliente-2" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"/>

							<p class="bloco-campo-float" id="campo-orgao" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"><label>Orgão Emissor: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:140px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="emissor" id="emissor" value="<?php echo $_SESSION['emissor']; ?>"/></p>

							<p class="bloco-campo-float" id="campo-sexo" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"><label>Sexo: <span class="obrigatorio"> * </span></label>
							<input class="caixa" name="sexo" id="sexo1" type="radio" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="M" <?php echo $_SESSION['sexo'] == "M" || $_SESSION['sexo'] == "" ? 'checked' : ''; ?> />Masculino   <input class="caixa" id="sexo2" name="sexo" type="radio" value="F" <?php echo $_SESSION['sexo'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
							
							<p class="bloco-campo-float" id="campo-nascimento" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"><label>Data de Nascimento: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="nascimento" id="nascimento" value="<?php echo $_SESSION['nascimento']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

							<p class="bloco-campo-float" id="campo-civil" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"><label>Estado Civil: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="civil" name="civil" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:190px;" required onChange="trocaCivil(this.value);">
									<option value="">Selecione</option>
									<option value="S" <?php echo $_SESSION['civil'] == "S" ? '/SELECTED/' : '';?>>Solteiro</option>
									<option value="C" <?php echo $_SESSION['civil'] == "C" ? '/SELECTED/' : '';?>>Casado</option>
									<option value="D" <?php echo $_SESSION['civil'] == "D" ? '/SELECTED/' : '';?>>Divorciado</option>
									<option value="V" <?php echo $_SESSION['civil'] == "V" ? '/SELECTED/' : '';?>>Viúvo</option>
									<option value="U" <?php echo $_SESSION['civil'] == "U" ? '/SELECTED/' : '';?>>União Estável</option>
								</select>
								<br class="clear"/>
							</p>

							<br class="clear" id="br-cliente-3" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"/>

							<p class="bloco-campo-float" id="campo-nacionalidade" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"><label>Nacionalidade: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:250px;" id="nacionalidade" name="nacionalidade" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['nacionalidade']; ?>"/></p>

							<p class="bloco-campo-float" id="campo-profissao" style="display:<?php echo $_SESSION['tipoPessoa'] == "J" ? 'none' : 'block';?>;"><label>Profissão: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:250px;" id="profissao" name="profissao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['profissao']; ?>"/></p>

							<br class="clear" id="br-cliente-7"/>

							<div id="bloco-conjugue" style="display:<?php echo $_SESSION['civil'] == "C" ? 'table' : 'none';?>; margin-bottom:15px; padding:10px; padding-bottom:0px; padding-right:0px; border:1px solid #ccc;">

								<p style="font-size:16px; color:#718B8F; text-decoration:underline; margin-bottom:10px;">Dados do Conjugue</p>

								<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> </span></label>
								<input class="campo-nomes" type="text" style="width:230px;" id="nomeConjugue" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="nomeConjugue" value="<?php echo $_SESSION['nomeConjugue']; ?>" /></p>

								<p class="bloco-campo-float"><label>CPF: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:150px;" id="cpfConjugue" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="cpfConjugue" value="<?php echo $_SESSION['cpfConjugue']; ?>" onKeyDown="mascaraMutuario(this,cpfCnpj);" onKeyPress="mascaraMutuario(this,cpfCnpj);" onKeyUp="mascaraMutuario(this,cpfCnpj);"/></p>

								<p class="bloco-campo-float"><label>RG: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:130px;" id="rgConjugue" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="rgConjugue" value="<?php echo $_SESSION['rgConjugue']; ?>"/></p>

								<br class="clear"/>

								<p class="bloco-campo-float"><label>Orgão Emissor: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:140px;" id="emissorConjugue" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="emissorConjugue" value="<?php echo $_SESSION['emissorConjugue']; ?>"/></p>

								<p class="bloco-campo-float"><label>Sexo: <span class="obrigatorio"> * </span></label>
								<input class="caixa" name="sexoConjugue" id="sexo1Conjugue" type="radio" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="M" <?php echo $_SESSION['sexo'] == "M" || $_SESSION['sexoConjugue'] == "" ? 'checked' : ''; ?> />Masculino   <input class="caixa" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="sexo2Conjugue" name="sexoConjugue" type="radio" value="F" <?php echo $_SESSION['sexoConjugue'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
								
								<p class="bloco-campo-float"><label>Data de Nascimento: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:150px;" id="nascimentoConjugue" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="nascimentoConjugue" value="<?php echo $_SESSION['nascimentoConjugue']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

								<br class="clear"/>

								<p class="bloco-campo-float"><label>Nacionalidade: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:250px;" id="nacionalidadeConjugue" name="nacionalidadeConjugue" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['nacionalidadeConjugue']; ?>"/></p>

								<p class="bloco-campo-float"><label>Profissão: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:250px;" id="profissaoConjugue" name="profissaoConjugue" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['profissaoConjugue']; ?>"/></p>

								<br class="clear"/>
							
							</div>
							<script type="text/javascript">
								function consultarCep() {
									var $cep = jQuery.noConflict();
									const cep = document.getElementById('cep').value;
									if (cep.length == 10) {
										fetch('https://brasilapi.com.br/api/cep/v1/'+cep.replace("-", ""))
											.then(response => response.json())
											.then(data => {
												if (data.type == "service_error") {
													document.getElementById('result').innerHTML = 'CEP não encontrado!';
													document.getElementById("confereCep").value="F";
												} else {
													document.getElementById("confereCep").value="T";
													if(data.street != ""){
														document.getElementById("endereco").value=data.street;
													}
													if(data.neighborhood != ""){
														document.getElementById("bairro").value=data.neighborhood;
													}
													if(data.state != ""){
														
														$cep.post("<?php echo $configUrlGer;?>cadastros/clientes/consulta-estado.php", {siglaEstado: data.state}, function(data1){	
															if(data1.trim() != "erro"){	

																document.getElementById("estado").value=data1.trim();		

																carregaCidade(data1).then(() => {
																
																  let city = data.city;

																  if (city != "") {
																	$cep.post("<?php echo $configUrlGer;?>cadastros/clientes/consulta-cidade.php", { nomeCidade: city }, function(data2) {
																	  if (data2.trim() != "erro") {  
																		document.getElementById("cidade").value = data2.trim();    
																	  } else {
																		document.getElementById("cidade").value = "";
																	  }
																	});
																  }
																}).catch((error) => {
																  console.error("Erro ao carregar a cidade:", error);
																});

															}else{
																document.getElementById("estado").value="";
															}

														});															
													}												
												}
											})
											.catch(error => console.error('Erro ao consultar o CEP:', error));
									} else {
										document.getElementById('result').innerHTML = '';
										document.getElementById('confereCep').value = 'F';
									}
								}							
							</script>

							<div class="bloco-campo-float"><label>CEP: <span class="obrigatorio"> * </span></label><p id="result" style="position:absolute; color:#FF0000; font-size:12px; margin-top:-15px; margin-left:50px;"><?php echo $_POST['confereCep'] == "F" ? 'CEP não encontrado!' : '';?></p><input type="hidden" value="F" name="confereCep" id="confereCep"/>
							<input class="campo-3" type="text" style="width:150px;" name="cep" id="cep" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['cep']; ?>" maxlength="9" minlength="9" onKeyDown="Mascara(this,Cep); consultarCep();" onKeyPress="Mascara(this,Cep); consultarCep();" onKeyUp="Mascara(this,Cep); consultarCep();"/></div>
							
							<p class="bloco-campo-float"><label>Rua:</label>
							<input class="campo-4" type="text" style="width:260px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="endereco" id="endereco" value="<?php echo $_SESSION['endereco']; ?>"/></p>

							<p class="bloco-campo-float"><label>Número:</label>
							<input class="campo-4" type="text" style="width:96px;"  <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="numero" id="numero" value="<?php echo $_SESSION['numero']; ?>"/></p>
							
							<p class="bloco-campo-float"><label>Bairro:</label>
							<input class="campo-3" type="text" style="width:165px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:175px;" name="bairro" id="bairro" value="<?php echo $_SESSION['bairro']; ?>"/></p>

							<br class="clear" id="br-cliente-5"/>
							
							<p class="bloco-campo-float"><label>Páis: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="pais" name="pais" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:190px;" required onChange="carregaEstado(this.value);">
									<option value="">Selecione</option>
<?php
				$sqlPais = "SELECT nomePais, codPais FROM pais WHERE statusPais = 'T' ORDER BY nomePais ASC";
				$resultPais = $conn->query($sqlPais);
				while($dadosPais = $resultPais->fetch_assoc()){
?>
									<option value="<?php echo $dadosPais['codPais'] ;?>" <?php echo $_SESSION['pais'] == $dadosPais['codPais'] ? '/SELECTED/' : '';?>><?php echo $dadosPais['nomePais'] ;?></option>
<?php
				}
?>					
								</select>
							</p>
<?php
				if($_SESSION['pais'] == ""){
?>													
							<div id="sel-padrao-estado">
								<p class="bloco-campo-float"><label class="label">Estado: <span class="obrigatorio"> * </span></label>
									<select id="default-usage-select" id="estado" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" required name="estado" style="width:215px;">
										<option id="option" value="">Selecione um Páis primeiro</option>
									</select>
									<br class="clear"/>
								</p>
							</div>
<?php
				}
?>
							<div id="carrega-estado">
<?php
				if($_SESSION['pais'] != ""){
?>
								<p class="bloco-campo-float"><label>Estado: <span class="obrigatorio"> * </span></label>
									<select class="campo" id="estado" name="estado" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:190px;" required onChange="carregaCidade(this.value);">
										<option value="">Selecione</option>
<?php
					$sqlEstado = "SELECT nomeEstado, codEstado FROM estado WHERE statusEstado = 'T' and codPais = ".$_SESSION['pais']." ORDER BY nomeEstado ASC";
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
				}
?>
							</div>
														
							
<?php
				if($_SESSION['estado'] == ""){
?>													
							<div id="sel-padrao-cidade">
								<p class="bloco-campo-float"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
									<select id="default-usage-select" id="cidade" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" required name="cidade" style="width:215px;">
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
									<select class="campo" name="cidade" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:215px;" required id="cidade">
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
					$_SESSION['sexo'] = "";
					$_SESSION['nascimento'] = "";
					$_SESSION['endereco'] = "";
					$_SESSION['numero'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['estado'] = "";
					$_SESSION['cidade'] = "";
					$_SESSION['cep'] = "";		
					$_SESSION['email'] = "";		
					$_SESSION['telefone'] = "";		
					$_SESSION['celular'] = "";	
					$_SESSION['corretor'] = "";	
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
