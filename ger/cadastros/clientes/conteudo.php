<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "clientes";
			if(validaAcesso($conn, $area) == "ok"){

				if($_SESSION['cadastrar'] == "ok"){
					$erroConteudo = "<p class='erro'>Cliente <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastrar'] = "";
					$_SESSION['nome'] = "";	
				}else	
				if($_SESSION['alterar'] == "ok"){
					$erroConteudo = "<p class='erro'>Cliente <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alterar'] = "";
					$_SESSION['nome'] = "";	
				}else	
				if($_SESSION['ativar'] == "ok"){
					$erroConteudo = "<p class='erro'>Cliente <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativar'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['excluir'] == "ok"){
					$erroConteudo = "<p class='erro'>Cliente <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['excluir'] = "";
					$_SESSION['nome'] = "";
				}
				
				if(isset($_POST['statusFiltro'])){
					if($_POST['statusFiltro'] != ""){
						$_SESSION['statusFiltro'] = $_POST['statusFiltro'];
					}else{
						$_SESSION['statusFiltro'] = "";
					}
				}
				
				if($_SESSION['statusFiltro'] != ""){
					$filtraStatus = " and statusCliente = '".$_SESSION['statusFiltro']."'";
				}	
				
				if(isset($_POST['corretorFiltro'])){
					if($_POST['corretorFiltro'] != ""){
						$_SESSION['corretorFiltro'] = $_POST['corretorFiltro'];
					}else{
						$_SESSION['corretorFiltro'] = "";
					}
				}
				
				if($_SESSION['corretorFiltro'] != ""){
					$filtraUsuario = " and codUsuario = '".$_SESSION['corretorFiltro']."'";
				}	
?>

				<div id="filtro">							
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Clientes</p>	
						<br class="clear"/>
					</div>
					<div class="demoTarget">
						<script type="text/javascript">
							function alteraStatus(status){
								document.getElementById("filtroStatus").submit();
							}
						</script>
						<div id="formulario-filtro">
							<form id="filtroStatus" action="<?php echo $configUrl;?>cadastros/clientes/" method="post">

								<p class="nome-clientes-filtro" style="width:210px;"><label class="label">Nome ou CPF/CNPJ:</label>
								<input type="text" style="width:190px;" name="clientes" onKeyUp="buscaAvancada();" id="buscaNome" autocomplete="off" value="<?php echo $_SESSION['nome-clientes-filtro'];?>" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />
								
								<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> </span></label>
									<select class="campo" id="corretorFiltro" name="corretorFiltro" style="width:150px; padding:6px; margin-right:0px;" onChange="alteraStatus();">
										<option value="">Todos</option>
<?php
				$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4 ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
										<option value="<?php echo $dadosUsuario['codUsuario'] ;?>" <?php echo $_SESSION['corretorFiltro'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
}
?>					
									</select>
									<br class="clear"/>
								</p>

								<p class="bloco-campo-float"><label>Status: <span class="obrigatorio"> </span></label>
									<select class="campo" name="statusFiltro" style="width:100px; padding:6px;" required onChange="alteraStatus(this.value);">
										<option value="">Todos</option>
										<option value="T" <?php echo $_SESSION['statusFiltro'] == "T" ? '/SELECTED/' : '';?>>Ativo</option>
										<option value="F" <?php echo $_SESSION['statusFiltro'] == "F" ? '/SELECTED/' : '';?>>Inativo</option>
									</select>
								</p>	
								
								<div class="botao-novo" style="margin-top:17px; margin-left:0px;"><a title="Novo Cliente" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">Novo Cliente</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px; margin-top:18px;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>

								<p style="float:right; margin-right:5px; margin-top:15px; cursor:pointer;" onClick="abrirImprimir();"><img src="<?php echo $configUrl;?>f/i/icones-imprimir2.gif" width="50"/></p>											

								<br class="clear" />
							</form>
						</div>
					</div>
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
					 </script>
<?php
				if($_POST['nome'] != ""){

					if($_POST['confereCep'] == "T"){
					
						if($_POST['nascimento'] == ""){
							$nascimento = "NULL";
						}else{
							$nascimento = "'".$_POST['nascimento']."'";
						}
						
						if($_POST['nascimentoConjugue'] == ""){
							$nascimentoConjugue = "NULL";
						}else{
							$nascimentoConjugue = "'".$_POST['nascimentoConjugue']."'";
						}
																			
						$sql = "INSERT INTO clientes VALUES(0, '".date('Y-m-d')."', '".$_POST['tipoPessoa']."', '".$_POST['corretor']."', '".$_POST['razao']."', '".$_POST['nome']."', '".$_POST['cpf']."', '".$_POST['rg']."', '".$_POST['emissor']."', '".$_POST['sexo']."', ".$nascimento.", '".$_POST['civil']."', '".$_POST['nacionalidade']."', '".$_POST['profissao']."', '".$_POST['nomeConjugue']."', '".$_POST['cpfConjugue']."', '".$_POST['rgConjugue']."', '".$_POST['emissorConjugue']."', '".$_POST['sexoConjugue']."', ".$nascimentoConjugue.", '".$_POST['nacionalidadeConjugue']."', '".$_POST['profissaoConjugue']."', '".$_POST['endereco']."', '".$_POST['numero']."', '".$_POST['bairro']."', '".$_POST['pais']."', '".$_POST['estado']."', '".$_POST['cidade']."', '".$_POST['cep']."', '".$_POST['email']."', '".$_POST['telefone']."', '".$_POST['celular']."', 'T')";
						$result = $conn->query($sql);
						
						if($result == 1){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastrar'] = "ok";
							$_SESSION['razao'] = "";
							$_SESSION['corretor'] = "";
							$_SESSION['cpf'] = "";
							$_SESSION['rg'] = "";
							$_SESSION['emissor'] = "";
							$_SESSION['sexo'] = "";
							$_SESSION['nascimento'] = "";
							$_SESSION['nomeConjugue'] = "";
							$_SESSION['cpfConjugue'] = "";
							$_SESSION['rgConjugue'] = "";
							$_SESSION['emissorConjugue'] = "";
							$_SESSION['sexoConjugue'] = "";
							$_SESSION['nascimentoConjugue'] = "";
							$_SESSION['nacionalidadeConjugue'] = "";
							$_SESSION['profissaoConjugue'] = "";
							$_SESSION['civil'] = "";
							$_SESSION['nacionalidade'] = "";
							$_SESSION['profissao'] = "";
							$_SESSION['endereco'] = "";
							$_SESSION['numero'] = "";
							$_SESSION['bairro'] = "";
							$_SESSION['pais'] = "";
							$_SESSION['estado'] = "";
							$_SESSION['cidade'] = "";
							$_SESSION['cep'] = "";		
							$_SESSION['email'] = "";		
							$_SESSION['telefone'] = "";		
							$_SESSION['celular'] = "";
							$_SESSION['loteFiltro'] = "";
							$_SESSION['quadraFiltro'] = "";
							$_SESSION['bairroFiltro'] = "";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/clientes/'>";					
							$block = "none";		
						}else{
							$erroConteudo = "<p class='erro'>Problemas ao cadastrar cliente!</p>";
							$_SESSION['nome'] = "";
							$_SESSION['razao'] = "";
							$_SESSION['corretor'] = "";
							$_SESSION['cpf'] = "";
							$_SESSION['rg'] = "";
							$_SESSION['emissor'] = "";
							$_SESSION['sexo'] = "";
							$_SESSION['nascimento'] = "";
							$_SESSION['nomeConjugue'] = "";
							$_SESSION['cpfConjugue'] = "";
							$_SESSION['rgConjugue'] = "";
							$_SESSION['emissorConjugue'] = "";
							$_SESSION['sexoConjugue'] = "";
							$_SESSION['nascimentoConjugue'] = "";
							$_SESSION['nacionalidadeConjugue'] = "";
							$_SESSION['profissaoConjugue'] = "";
							$_SESSION['civil'] = "";
							$_SESSION['nacionalidade'] = "";
							$_SESSION['profissao'] = "";
							$_SESSION['endereco'] = "";
							$_SESSION['numero'] = "";
							$_SESSION['bairro'] = "";
							$_SESSION['pais'] = "";
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
						$erroConteudo = "<p class='erro'>O CEP <strong>".$_POST['cep']."</strong> digitado não existe!</p>";
						$_SESSION['tipoPessoa'] = $_POST['tipoPessoa'];
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['razao'] = $_POST['razao'];
						$_SESSION['funcionario'] = $_POST['funcionario'];
						$_SESSION['cpf'] = $_POST['cpf'];
						$_SESSION['rg'] = $_POST['rg'];
						$_SESSION['emissor'] = $_POST['emissor'];
						$_SESSION['sexo'] = $_POST['sexo'];
						$_SESSION['nascimento'] = $_POST['nascimento'];
						$_SESSION['nomeConjugue'] = $_POST['nomeConjugue'];
						$_SESSION['cpfConjugue'] = $_POST['cpfConjugue'];
						$_SESSION['rgConjugue'] = $_POST['rgConjugue'];
						$_SESSION['emissorConjugue'] = $_POST['emissorConjugue'];
						$_SESSION['sexoConjugue'] = $_POST['sexoConjugue'];
						$_SESSION['nascimentoConjugue'] = $_POST['nascimentoConjugue'];
						$_SESSION['nacionalidadeConjugue'] = $_POST['nacionalidadeConjugue'];
						$_SESSION['profissaoConjugue'] = $_POST['profissaoConjugue'];
						$_SESSION['civil'] = $_POST['civil'];
						$_SESSION['nacionalidade'] = $_POST['nacionalidade'];
						$_SESSION['profissao'] = $_POST['profissao'];
						$_SESSION['endereco'] = $_POST['endereco'];
						$_SESSION['numero'] = $_POST['numero'];
						$_SESSION['bairro'] = $_POST['bairro'];
						$_SESSION['pais'] = $_POST['pais'];
						$_SESSION['estado'] = $_POST['estado'];
						$_SESSION['cidade'] = $_POST['cidade'];
						$_SESSION['cep'] = $_POST['cep'];		
						$_SESSION['email'] = $_POST['email'];		
						$_SESSION['telefone'] = $_POST['telefone'];		
						$_SESSION['celular'] = $_POST['celular'];	
						$_SESSION['loteFiltro'] = $_POST['loteFiltro'];
						$_SESSION['quadraFiltro'] = $_POST['quadraFiltro'];
						$_SESSION['bairroFiltro'] = $_POST['bairroFiltro'];
						$block = "block";		
					}
				}else{
					$_SESSION['tipoPessoa'] = "F";
					$_SESSION['nome'] = "";
					$_SESSION['razao'] = "";
					$_SESSION['corretor'] = "";
					$_SESSION['cpf'] = "";
					$_SESSION['rg'] = "";
					$_SESSION['emissor'] = "";
					$_SESSION['sexo'] = "";
					$_SESSION['nascimento'] = "";
					$_SESSION['nomeConjugue'] = "";
					$_SESSION['cpfConjugue'] = "";
					$_SESSION['rgConjugue'] = "";
					$_SESSION['emissorConjugue'] = "";
					$_SESSION['sexoConjugue'] = "";
					$_SESSION['nascimentoConjugue'] = "";
					$_SESSION['nacionalidadeConjugue'] = "";
					$_SESSION['profissaoConjugue'] = "";
					$_SESSION['civil'] = "";
					$_SESSION['nacionalidade'] = "";
					$_SESSION['profissao'] = "";
					$_SESSION['endereco'] = "";
					$_SESSION['numero'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['pais'] = "1";
					$_SESSION['estado'] = "24";
					$_SESSION['cidade'] = "";
					$_SESSION['cep'] = "";		
					$_SESSION['email'] = "";		
					$_SESSION['telefone'] = "";		
					$_SESSION['celular'] = "";	
					$_SESSION['loteFiltro'] = "";
					$_SESSION['quadraFiltro'] = "";
					$_SESSION['bairroFiltro'] = "";
					$block = "none";		
				}
?>						 
					<div id="cadastrar" style="display:<?php echo $block;?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">			
<?php	
				if($erroConteudo != "" && $block == "block"){
?>	
						<div class="area-erro">
<?php
					echo $erroConteudo;	
?>
						</div>
<?php
					$erroConteudo = "";
				}
?>
						<script type="text/javascript">
						
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
									document.getElementById("label-cpf").innerHTML="CPF: *";
									document.getElementById("label-rg").innerHTML="RG:";
									document.getElementById("campo-razao").style.display="none";
									document.getElementById("br-cliente-1").style.display="none";
									document.getElementById("br-cliente-2").style.display="block";
									document.getElementById("br-cliente-3").style.display="block";
									document.getElementById("br-cliente-4").style.display="none";
									document.getElementById("br-cliente-5").style.display="block";
									document.getElementById("br-clientes-7").style.display="block";
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
									document.getElementById("label-cpf").innerHTML="CNPJ: *";
									document.getElementById("label-rg").innerHTML="Inscrição Estadual:";
									document.getElementById("campo-razao").style.display="block";
									document.getElementById("br-cliente-1").style.display="block";
									document.getElementById("br-cliente-2").style.display="none";
									document.getElementById("br-cliente-3").style.display="none";
									document.getElementById("br-cliente-4").style.display="block";
									document.getElementById("br-cliente-5").style.display="none";
									document.getElementById("br-clientes-7").style.display="none";
									document.getElementById("campo-nascimento").style.display="none";
									document.getElementById("campo-civil").style.display="none";
									document.getElementById("campo-nacionalidade").style.display="none";
									document.getElementById("campo-profissao").style.display="none";
									document.getElementById("campo-orgao").style.display="none";
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
						<form name="formCliente" action="<?php echo $configUrlGer; ?>cadastros/clientes/" method="post">

							<p class="bloco-campo"><label>Tipo Pessoa: </label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-right:25px; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" onClick="trocaLabel('F');" <?php echo $_SESSION['tipoPessoa'] == 'F' ? 'checked' : '';?> name="tipoPessoa" value="F"/>Pessoa Física</label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" name="tipoPessoa" onClick="trocaLabel('J');" <?php echo $_SESSION['tipoPessoa'] == 'J' ? 'checked' : '';?> value="J"/>Pessoa Jurídica</label>
								<br class="clear"/>
							</p>
							
							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="corretor" name="corretor" style="width:190px;" required>
									<option value="">Selecione</option>
<?php
				$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T'".$filtraUsuario." ORDER BY nomeUsuario ASC";
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

							<p class="bloco-campo-float" id="campo-razao" style="display:none;"><label>Razão Social: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:247px;" disabled id="razao" required name="razao" value="<?php echo $_SESSION['razao']; ?>" /></p>

							<p class="bloco-campo-float"><label id="label-nome">Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:317px;" id="nome" required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<br class="clear" id="br-cliente-1" style="display:none;"/>

							<p class="bloco-campo-float"><label id="label-cpf">CPF: <span class="obrigatorio"> * </span></label>
							<input class="campo-5" type="text" style="width:150px;" required name="cpf" value="<?php echo $_SESSION['cpf']; ?>" onKeyDown="mascaraMutuario(this,cpfCnpj);" onKeyPress="mascaraMutuario(this,cpfCnpj);" onKeyUp="mascaraMutuario(this,cpfCnpj);"/></p>

							<p class="bloco-campo-float"><label id="label-rg">RG: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:130px;" name="rg" value="<?php echo $_SESSION['rg']; ?>"/></p>

							<br class="clear" id="br-cliente-2"/>

							<p class="bloco-campo-float" id="campo-orgao"><label>Orgão Emissor: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:140px;" name="emissor" value="<?php echo $_SESSION['emissor']; ?>"/></p>

							<p class="bloco-campo-float" id="campo-sexo"><label>Sexo: <span class="obrigatorio"> * </span></label>
							<input class="caixa" name="sexo" id="sexo1" type="radio" value="M" <?php echo $_SESSION['sexo'] == "M" || $_SESSION['sexo'] == "" ? 'checked' : ''; ?> />Masculino   <input class="caixa" id="sexo2" name="sexo" type="radio" value="F" <?php echo $_SESSION['sexo'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
							
							<p class="bloco-campo-float" id="campo-nascimento"><label>Data de Nascimento: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="nascimento" value="<?php echo $_SESSION['nascimento']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

							<p class="bloco-campo-float" id="campo-civil"><label>Estado Civil: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="civil" name="civil" style="width:190px;" required onChange="trocaCivil(this.value);">
									<option value="">Selecione</option>
									<option value="S" <?php echo $_SESSION['civil'] == "S" ? '/SELECTED/' : '';?>>Solteiro</option>
									<option value="C" <?php echo $_SESSION['civil'] == "C" ? '/SELECTED/' : '';?>>Casado</option>
									<option value="D" <?php echo $_SESSION['civil'] == "D" ? '/SELECTED/' : '';?>>Divorciado</option>
									<option value="V" <?php echo $_SESSION['civil'] == "V" ? '/SELECTED/' : '';?>>Viúvo</option>
									<option value="U" <?php echo $_SESSION['civil'] == "U" ? '/SELECTED/' : '';?>>União Estável</option>
								</select>
								<br class="clear"/>
							</p>

							<br class="clear" id="br-cliente-3"/>

							<p class="bloco-campo-float" id="campo-nacionalidade"><label>Nacionalidade: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:250px;" name="nacionalidade" value="<?php echo $_SESSION['nacionalidade']; ?>"/></p>

							<p class="bloco-campo-float" id="campo-profissao"><label>Profissão: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:250px;" name="profissao" value="<?php echo $_SESSION['profissao']; ?>"/></p>

							<br class="clear" id="br-clientes-7"/>

							<div id="bloco-conjugue" style="display:none; margin-bottom:15px; padding:10px; padding-bottom:0px; padding-right:0px; border:1px solid #ccc;">

								<p style="font-size:16px; color:#718B8F; text-decoration:underline; margin-bottom:10px;">Dados do Conjugue</p>

								<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> </span></label>
								<input class="campo-nomes" type="text" style="width:230px;" id="nomeConjugue" name="nomeConjugue" value="<?php echo $_SESSION['nomeConjugue']; ?>" /></p>

								<p class="bloco-campo-float"><label>CPF: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:150px;" id="cpfConjugue" name="cpfConjugue" value="<?php echo $_SESSION['cpfConjugue']; ?>" onKeyDown="mascaraMutuario(this,cpfCnpj);" onKeyPress="mascaraMutuario(this,cpfCnpj);" onKeyUp="mascaraMutuario(this,cpfCnpj);"/></p>

								<p class="bloco-campo-float"><label>RG: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:130px;" id="rgConjugue" name="rgConjugue" value="<?php echo $_SESSION['rgConjugue']; ?>"/></p>

								<br class="clear"/>

								<p class="bloco-campo-float"><label>Orgão Emissor: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:140px;" id="emissorConjugue" name="emissorConjugue" value="<?php echo $_SESSION['emissorConjugue']; ?>"/></p>

								<p class="bloco-campo-float"><label>Sexo: <span class="obrigatorio"> * </span></label>
								<input class="caixa" name="sexoConjugue" id="sexo1Conjugue" type="radio" value="M" <?php echo $_SESSION['sexo'] == "M" || $_SESSION['sexoConjugue'] == "" ? 'checked' : ''; ?> />Masculino   <input class="caixa" id="sexo2Conjugue" name="sexoConjugue" type="radio" value="F" <?php echo $_SESSION['sexoConjugue'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
								
								<p class="bloco-campo-float"><label>Data de Nascimento: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:150px;" id="nascimentoConjugue" name="nascimentoConjugue" value="<?php echo $_SESSION['nascimentoConjugue']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

								<br class="clear"/>

								<p class="bloco-campo-float"><label>Nacionalidade: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:250px;" id="nacionalidadeConjugue" name="nacionalidadeConjugue" value="<?php echo $_SESSION['nacionalidadeConjugue']; ?>"/></p>

								<p class="bloco-campo-float"><label>Profissão: <span class="obrigatorio"> </span></label>
								<input class="campo-5" type="text" style="width:250px;" id="profissaoConjugue" name="profissaoConjugue" value="<?php echo $_SESSION['profissaoConjugue']; ?>"/></p>

								<br class="clear"/>
							
							</div>

							<div class="bloco-campo-float"><label>CEP: <span class="obrigatorio"> * </span></label><p id="result" style="position:absolute; color:#FF0000; font-size:12px; margin-top:-15px; margin-left:50px;"><?php echo $_POST['confereCep'] == "F" ? 'CEP não encontrado!' : '';?></p><input type="hidden" value="F" name="confereCep" id="confereCep"/>
							<input class="campo-3" type="text" style="width:150px;" name="cep" id="cep" value="<?php echo $_SESSION['cep']; ?>" maxlength="9" minlength="9" onKeyDown="Mascara(this,Cep); consultarCep();" onKeyPress="Mascara(this,Cep); consultarCep();" onKeyUp="Mascara(this,Cep); consultarCep();"/></div>

							<p class="bloco-campo-float"><label>Rua: <span class="obrigatorio"> * </span></label>
							<input class="campo-4" type="text" style="width:260px;" required name="endereco" value="<?php echo $_SESSION['endereco']; ?>"/></p>

							<p class="bloco-campo-float"><label>Número: <span class="obrigatorio"> * </span></label>
							<input class="campo-4" type="text" style="width:96px;" required name="numero" value="<?php echo $_SESSION['numero']; ?>"/></p>
							
							<br class="clear" id="br-cliente-4" style="display:none;"/>

							<p class="bloco-campo-float"><label>Bairro: <span class="obrigatorio"> * </span></label>
							<input class="campo-3" type="text" style="width:165px;" style="width:175px;" required name="bairro" value="<?php echo $_SESSION['bairro']; ?>"/></p>

							<script type="text/javascript">
								function consultarCep() {
									var $cep = jQuery.noConflict();
									const cep = document.getElementById('cep').value;
									if (cep.length == 9) {
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

							<br class="clear" id="br-cliente-5"/>

							<p class="bloco-campo-float"><label>Páis: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="pais" name="pais" style="width:190px;" required onChange="carregaEstado(this.value);">
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
								<br class="clear"/>
							</p>
<?php
				if($_SESSION['pais'] == ""){
?>													
							<div id="sel-padrao-estado">
								<p class="bloco-campo-float"><label class="label">Estado: <span class="obrigatorio"> * </span></label>
									<select id="default-usage-select" id="estado" class="campo" required name="estado" style="width:215px;">
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
									<select class="campo" id="estado" name="estado" style="width:190px;" required onChange="carregaCidade(this.value);">
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
									<select id="default-usage-select" id="cidade" class="campo" required name="cidade" style="width:215px;">
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
									<select class="campo" name="cidade" style="width:215px;" required id="cidade">
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
							<input class="campo-7" type="email" style="width:225px;" name="email" value="<?php echo $_SESSION['email']; ?>"/></p>
								
							<p class="bloco-campo-float"><label>Telefone: </label>
							<input class="campo-6" type="text" style="width:110px;" name="telefone" value="<?php echo $_SESSION['telefone']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<p class="bloco-campo-float"><label>Celular: </label>
							<input class="campo-6" type="text" style="width:110px;" name="celular" value="<?php echo $_SESSION['celular']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<br class="clear" />											

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Cliente" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>					
					</div>
				</div>
				<script type="text/javascript">
					function imprimeRequisicao(id, pg) {
						var printContents = document.getElementById(id).innerHTML;
						var originalContents = document.body.innerHTML;

						document.body.innerHTML = printContents;

						window.print();

						document.body.innerHTML = originalContents;
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
				</script>
				<div id="conteudo-imprimir" style="width:900px; margin-top:-100px; min-height:500px; display:none; position:absolute; z-index:1; left:50%; margin-left:-450px; box-shadow:0px 0px 20px #528585; border-radius:10px; background-color:#FFFFFF;">
					<div id="conteudo-scroll" style="width:900px; height:500px; overflow-y:auto;">
						<p class="botao-fechar" onClick="fechaArquivo();" style="width:25px; color:#FFFFFF; padding:1px; padding-top:2px; text-align: center; cursor: pointer; position: absolute; z-index:1; background-color:#718B8F; border-radius:235px; font-size:20px; margin-left:892px; margin-top:-15px;">X</p>
						<p class="botao-imprimir" style="position:absolute; z-index:2; cursor:pointer; margin-left:418px; margin-top:-30px;" onClick="imprimeRequisicao('imprime-requisicao', 'imprime.html')"><img src="<?php echo $configUrlGer;?>f/i/icon-impressora2.png" alt="Imagem" /></p>
						<div id="imprime-requisicao" style="width:800px; padding-top:20px; padding-bottom:20px; margin:0 45px auto;">
							<div style="width:800px; margin:0 auto;">
								<script type="text/javascript">
									function imprime() {
										var oJan;
										oJan.window.print();
									}
																	
									function tiraBotao() {
										document.getElementById("botao-imprimir").style.display="none";									 
									}								
								</script>
								<p style="display:none; margin: auto; margin-bottom:20px;" id="botao-imprimir"><input type="submit" value="Imprimir" onClick="tiraBotao(); imprime(window.print());"/></p>
								<div id="topo-requisicao" style="width:800px; border-bottom:2px solid #000000;">	
									<p style="display:table; margin:0 auto; padding-bottom:10px;"><img src="<?php echo $configUrlGer;?>f/i/comp.png" height="80"/></p>
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; padding-top:5px; margin:0; font-family:Arial; font-size:24px; font-weight:bold;"><?php echo $nomeEmpresaMenor;?> - Clientes</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:40px;">
									<div id="mostra-dados" style="width:100%;">
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:19%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Cliente</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">CPF/CNPJ</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Corretor</p>
											<p style="width:18%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Cidade / UF</p>
											<p style="width:11%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Telefone</p>
											<p style="width:9%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Status</p>
											<br style="clear:both;"/>
										</div>
<?php
				$cont = 0;
				$cont2 = 0;
				
				$sqlClientes = "SELECT * FROM clientes WHERE codCliente != '' ".$filtraStatus.$filtraUsuario." ORDER BY statusCliente ASC, nomeCliente ASC, codCliente ASC";
				$resultClientes = $conn->query($sqlClientes);
				while($dadosClientes = $resultClientes->fetch_assoc()){
				
					$cont++;
					$cont2++;

					$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosClientes['codEstado']."";
					$resultEstado = $conn->query($sqlEstado);
					$dadosEstado = $resultEstado->fetch_assoc();
				
					$sqlCidade = "SELECT * FROM cidade WHERE codCidade = ".$dadosClientes['codCidade']."";
					$resultCidade = $conn->query($sqlCidade);
					$dadosCidade = $resultCidade->fetch_assoc();
					
					$sqlUsuario = "SELECT * FROM usuarios WHERE statusUsuario = 'T' and codUsuario = ".$dadosClientes['codUsuario']."";
					$resultUsuario = $conn->query($sqlUsuario);
					$dadosUsuario = $resultUsuario->fetch_assoc();
?>
										<div id="clientes" style="width:100%; padding-bottom:10px; margin-bottom:10px; border-bottom:1px dashed #000;">
											<p class="nome-cliente" style="width:21%; float:left; margin:0; font-family:Arial; font-size:13px; text-align:center;"><?php echo $dadosClientes['nomeCliente'];?></p>
											<p class="nome-cliente" style="width:17%; float:left; margin:0; font-family:Arial; font-size:13px; text-align:center;"><?php echo $dadosClientes['cpfCliente'];?></p>
											<p class="nome-cliente" style="width:18%; float:left; margin:0; font-family:Arial; font-size:13px; text-align:center;"><?php echo $dadosUsuario['nomeUsuario'];?></p>
											<p class="cidade-cliente" style="width:19.5%; float:left; margin:0; font-family:Arial; font-size:13px; text-align:center;"><?php echo $dadosCidade['nomeCidade'];?> / <?php echo $dadosEstado['siglaEstado'];?></p>
											<p class="cidade-cliente" style="width:13%; float:left; margin:0; font-family:Arial; font-size:13px; text-align:center;"><?php echo $dadosClientes['telefoneCliente'] != "" ? $dadosClientes['telefoneCliente'] : $dadosClientes['celularCliente'];?><?php echo $dadosClientes['telefoneCliente'] == "" && $dadosClientes['celularCliente'] == "" ? '--' : '';?></p>
											<p class="cidade-cliente" style="width:11%; float:left; margin:0; font-family:Arial; font-size:13px; text-align:center;"><?php echo $dadosClientes['statusCliente'] == "T" ? 'Ativo' : 'Inativo';?></p>
											<br style="clear:both;"/>
										</div>
<?php
				}
?>
										<p class="total" style="padding-top:10px; margin-top:40px; font-family:Arial; font-size:13px; border-top:2px solid #000;">Total de Clientes: <strong><?php echo $cont;?></strong></p>
									</div>
								</div>
							</div>
						</div>
					</div>	
				</div>
				<div id="dados-conteudo">
					<div id="consultas">
					
					
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
?>
						<script type="text/javascript">
							function buscaAvancada(area){
								var $AGD = jQuery.noConflict();
								var buscaNome = $AGD("#buscaNome").val();
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");

								$AGD("#busca-carregada").load("<?php echo $configUrl;?>cadastros/clientes/busca-clientes.php?buscaNome="+buscaNome);
								if(buscaNome == "" && buscaLote == "" && buscaQuadra == "" && buscaBairro == ""){
									document.getElementById("paginacao").style.display="block";
								}else{
									document.getElementById("paginacao").style.display="none";
								}
							}	
						</script>
						<div id="busca-carregada">
<?php
				$sqlConta = "SELECT count(codCliente) registros, nomeCliente, codCliente FROM clientes WHERE codCliente != ''".$filtraStatus.$filtraUsuario."";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeCliente'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Nome</th>
									<th>CPF/CNPJ</th>
									<th>Corretor</th>
									<th>Cidade / UF</th>
									<th>Telefone</th>
									<th>Foto</th>
									<th>Documentos</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
				}
				
				if($url[5] == 1 || $url[5] == ""){
					$pagina = 1;
					$sqlClientes = "SELECT * FROM clientes WHERE codCliente != ''".$filtraStatus.$filtraUsuario." ORDER BY statusCliente ASC, nomeCliente ASC LIMIT 0,30";
				}else{
					$pagina = $url[5];
					$paginaFinal = $pagina * 30;
					$paginaInicial = $paginaFinal - 30;
					$sqlClientes = "SELECT * FROM clientes WHERE codCliente != ''".$filtraStatus.$filtraUsuario." ORDER BY statusCliente ASC, nomeCliente ASC LIMIT ".$paginaInicial.",30";
				}		

				$resultClientes = $conn->query($sqlClientes);
				while($dadosClientes = $resultClientes->fetch_assoc()){
					$mostrando++;
					
					if($dadosClientes['statusCliente'] == "T"){
						$status = "status-ativo";
						$statusIcone = "ativado";
						$statusPergunta = "desativar";
					}else{
						$status = "status-desativado";
						$statusIcone = "desativado";
						$statusPergunta = "ativar";
					}	
						
					$sqlUsuario = "SELECT * FROM usuarios WHERE statusUsuario = 'T' and codUsuario = ".$dadosClientes['codUsuario']."";
					$resultUsuario = $conn->query($sqlUsuario);
					$dadosUsuario = $resultUsuario->fetch_assoc();
				
					$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosClientes['codEstado']."";
					$resultEstado = $conn->query($sqlEstado);
					$dadosEstado = $resultEstado->fetch_assoc();
				
					$sqlCidade = "SELECT * FROM cidade WHERE codCidade = ".$dadosClientes['codCidade']."";
					$resultCidade = $conn->query($sqlCidade);
					$dadosCidade = $resultCidade->fetch_assoc();
										
					$sqlImagem = "SELECT * FROM clientesImagens WHERE codCliente = ".$dadosClientes['codCliente']." LIMIT 0,1";
					$resultImagem = $conn->query($sqlImagem);
					$dadosImagem = $resultImagem->fetch_assoc();	
					
					$aniversario = explode("-", $dadosClientes['nascimentoCliente']);
					$novaData = $aniversario[2]."/".$aniversario[1];
?>
								<tr class="tr">
									<td class="vinte" style="padding:0px;"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> cursor:pointer;" title="Aniversariante" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo2.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosClientes['nomeCliente'];?></a></td>
									<td class="vinte" style="padding:0px; width:13%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosClientes['cpfCliente'];?></a></td>
									<td class="vinte" style="padding:0px; width:15%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosUsuario['nomeUsuario'];?></a></td>
									<td class="vinte" style="padding:0px; width:15%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosCidade['nomeCidade'];?> / <?php echo $dadosEstado['siglaEstado'];?></a></td>
									<td class="vinte" style="padding:0px; width:10%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosClientes['telefoneCliente'] != "" ? $dadosClientes['telefoneCliente'] : $dadosClientes['celularCliente'];?> <?php echo $dadosClientes['telefoneCliente'] == "" && $dadosClientes['celularCliente'] == "" ? '--' : '';?></a></td>
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>cadastros/clientes/foto/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja cadastrar fotos para o cliente <?php echo $dadosClientes['nomeCliente'] ?>?'><img style="margin-left:-8px; <?php echo $dadosImagem['codCliente'] == "" ? 'display:none;' : '';?>" src="<?php echo $configUrlGer.'f/clientes/'.$dadosImagem['codCliente'].'-'.$dadosImagem['codClienteImagem'].'-O.'.$dadosImagem['extClienteImagem'];?>" alt="icone" height="60"/><img style="<?php echo $dadosImagem['codCliente'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl;?>f/i/gerenciar-imagens.gif" alt="icone" /></a></td>
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>cadastros/clientes/gerenciar-documentos/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja cadastrar documentos para o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>cadastros/clientes/ativacao/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja <?php echo $statusPergunta ?> o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja alterar o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes" style="padding:0px;"><a href='javascript: confirmaExclusao(<?php echo $dadosClientes['codCliente'] ?>, "<?php echo htmlspecialchars($dadosClientes['nomeCliente']) ?>");' title='Deseja excluir o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
				}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o cliente "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/clientes/excluir/'+cod+'/';
										}
									  }
								 </script>	 
							</table>							
						</div>
<?php
				if($url[3] != ""){
					$regPorPagina = 30;
					$area = "cadastros/clientes";
					include ('f/conf/paginacao.php');
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
				echo "<p><strong>Vocês não tem permissão para acessar essa área!</strong></p>";
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
