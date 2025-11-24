<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "fornecedores";
			if(validaAcesso($conn, $area) == "ok"){

				if($_SESSION['cadastrar'] == "ok"){
					$erroConteudo = "<p class='erro'>Fornecedor <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastrar'] = "";
					$_SESSION['nome'] = "";	
				}else	
				if($_SESSION['alterar'] == "ok"){
					$erroConteudo = "<p class='erro'>Fornecedor <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alterar'] = "";
					$_SESSION['nome'] = "";	
				}else	
				if($_SESSION['ativar'] == "ok"){
					$erroConteudo = "<p class='erro'>Fornecedor <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativar'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['excluir'] == "ok"){
					$erroConteudo = "<p class='erro'>Fornecedor <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
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
					$filtraStatus = " and statusFornecedor = '".$_SESSION['statusFiltro']."'";
				}	
?>

				<div id="filtro">							
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Fornecedores</p>	
						<br class="clear"/>
					</div>
					<div class="demoTarget">
						<script type="text/javascript">
							function alteraStatus(status){
								document.getElementById("filtroStatus").submit();
							}
						</script>
						<div id="formulario-filtro">
							<form id="filtroStatus" action="<?php echo $configUrl;?>cadastros/fornecedores/" method="post">

								<p class="nome-clientes-filtro" style="width:210px;"><label class="label">Nome ou CPF/CNPJ:</label>
								<input type="text" style="width:190px;" name="fornecedores" onKeyUp="buscaAvancada();" id="buscaNome" autocomplete="off" value="<?php echo $_SESSION['nome-fornecedores-filtro'];?>" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />
								
								<p class="bloco-campo-float"><label>Status: <span class="obrigatorio"> </span></label>
									<select class="campo" name="statusFiltro" style="width:155px; padding:6px;" required onChange="alteraStatus(this.value);">
										<option value="">Todos</option>
										<option value="T" <?php echo $_SESSION['statusFiltro'] == "T" ? '/SELECTED/' : '';?>>Ativo</option>
										<option value="F" <?php echo $_SESSION['statusFiltro'] == "F" ? '/SELECTED/' : '';?>>Inativo</option>
									</select>
								</p>	
								
								<div class="botao-novo" style="margin-top:17px; margin-left:0px;"><a title="Novo Fornecedor" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-fornecedor">Novo Fornecedor</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px; margin-top:18px;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-fornecedor">X</div><div class="direita-novo"></div></a></div>

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
					
					if($_POST['nascimento'] != ""){
						$data = data($_POST['nascimento']);
					}else{
						$data = NULL;
					}
																		
					$sql = "INSERT INTO fornecedores VALUES(0, '".$_POST['tipoPessoa']."', '".$_POST['razao']."', '".$_POST['nome']."', '".$_POST['cpf']."', '".$_POST['rg']."', '".$_POST['emissor']."', '".$_POST['sexo']."', '".$data."', '".$_POST['endereco']."', '".$_POST['numero']."', '".$_POST['bairro']."', '".$_POST['estado']."', '".$_POST['cidade']."', '".$_POST['cep']."', '".$_POST['email']."', '".$_POST['telefone']."', '".$_POST['celular']."', 'T')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastrar'] = "ok";
						$_SESSION['razao'] = "";
						$_SESSION['usuario'] = "";
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
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/fornecedores/'>";					
						$block = "none";		
					}else{
						$erroConteudo = "<p class='erro'>Problemas ao cadastrar fornecedor!</p>";
						$_SESSION['nome'] = "";
						$_SESSION['razao'] = "";
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
					}

				}else{
					$_SESSION['tipoPessoa'] = "F";
					$_SESSION['nome'] = "";
					$_SESSION['razao'] = "";
					$_SESSION['cpf'] = "";
					$_SESSION['rg'] = "";
					$_SESSION['emissor'] = "";
					$_SESSION['sexo'] = "";
					$_SESSION['nascimento'] = "";
					$_SESSION['endereco'] = "";
					$_SESSION['numero'] = "";
					$_SESSION['bairro'] = "";
					$_SESSION['estado'] = "24";
					$_SESSION['cidade'] = "8119";
					$_SESSION['cep'] = "";		
					$_SESSION['email'] = "";		
					$_SESSION['telefone'] = "";		
					$_SESSION['celular'] = "";					
					$block = "none";		
				}
?>						 
					<div id="cadastrar" style="display:<?php echo $block;?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">			
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
						<form name="formFornecedor" action="<?php echo $configUrlGer; ?>cadastros/fornecedores/" method="post">

							<p class="bloco-campo"><label>Tipo Pessoa: </label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-right:25px; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" onClick="trocaLabel('F');" <?php echo $_SESSION['tipoPessoa'] == 'F' ? 'checked' : '';?> name="tipoPessoa" value="F"/>Pessoa Física</label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" name="tipoPessoa" onClick="trocaLabel('J');" <?php echo $_SESSION['tipoPessoa'] == 'J' ? 'checked' : '';?> value="J"/>Pessoa Jurídica</label>
								<br class="clear"/>
							</p>

							<p class="bloco-campo-float" id="campo-razao" style="display:none;"><label>Razão Social: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:247px;" disabled id="razao" required name="razao" value="<?php echo $_SESSION['razao']; ?>" /></p>

							<p class="bloco-campo-float"><label id="label-nome">Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo-nomes" type="text" style="width:257px;" id="nome" required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label id="label-cpf">CPF: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="cpf" value="<?php echo $_SESSION['cpf']; ?>" onKeyDown="mascaraMutuario(this,cpfCnpj);" onKeyPress="mascaraMutuario(this,cpfCnpj);" onKeyUp="mascaraMutuario(this,cpfCnpj);"/></p>

							<br class="clear" id="br-fornecedor-1" style="display:none;"/>

							<p class="bloco-campo-float"><label id="label-rg">RG: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:130px;" name="rg" value="<?php echo $_SESSION['rg']; ?>"/></p>

							<p class="bloco-campo-float" id="campo-orgao"><label>Orgão Emissor: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:100px;" name="emissor" value="<?php echo $_SESSION['emissor']; ?>"/></p>

							<br class="clear" id="br-fornecedor-2"/>

							<p class="bloco-campo-float" id="campo-sexo"><label>Sexo: <span class="obrigatorio"> * </span></label>
							<input class="caixa" name="sexo" id="sexo1" type="radio" value="M" <?php echo $_SESSION['sexo'] == "M" || $_SESSION['sexo'] == "" ? 'checked' : ''; ?> />Masculino   <input class="caixa" id="sexo2" name="sexo" type="radio" value="F" <?php echo $_SESSION['sexo'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
							
							<p class="bloco-campo-float" id="campo-nascimento"><label>Data de Nascimento: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="nascimento" value="<?php echo $_SESSION['nascimento']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

							<p class="bloco-campo-float"><label>Endereço:</label>
							<input class="campo-4" type="text" style="width:257px;" name="endereco" value="<?php echo $_SESSION['endereco']; ?>"/></p>

							<p class="bloco-campo-float"><label>Número:</label>
							<input class="campo-4" type="text" style="width:96px;" name="numero" value="<?php echo $_SESSION['numero']; ?>"/></p>
							
							<br class="clear"/>

							<p class="bloco-campo-float"><label>Bairro:</label>
							<input class="campo-3" type="text" style="width:165px;" style="width:175px;" name="bairro" value="<?php echo $_SESSION['bairro']; ?>"/></p>
							
							<p class="bloco-campo-float"><label>Estado: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="estado" name="estado" style="width:190px;" required onChange="carregaCidade(this.value);">
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
									<select id="default-usage-select" id="cidade" class="campo" name="cidade" style="width:215px;">
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
									<select class="campo" name="cidade" style="width:215px;" id="cidade">
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
							<input class="campo-3" type="text" style="width:99px;" name="cep" value="<?php echo $_SESSION['cep']; ?>" onKeyDown="Mascara(this,Cep);" onKeyPress="Mascara(this,Cep);" onKeyUp="Mascara(this,Cep)"/></p>
								
							<br class="clear"/>	

							<p class="bloco-campo-float"><label>E-mail:</label>
							<input class="campo-7" type="email" style="width:240px;" name="email" value="<?php echo $_SESSION['email']; ?>"/></p>
								
							<p class="bloco-campo-float"><label>Telefone: </label>
							<input class="campo-6" type="text" style="width:110px;" name="telefone" value="<?php echo $_SESSION['telefone']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<p class="bloco-campo-float"><label>Celular: </label>
							<input class="campo-6" type="text" style="width:110px;" name="celular" value="<?php echo $_SESSION['celular']; ?>"   onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone)"/></p>

							<br class="clear" />						

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Paciente" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
									<p style="display:table; margin:0 auto; padding-bottom:10px;"><img src="<?php echo $configUrlGer;?>f/i/logo-imprimir.png" height="60"/></p>
									<p class="titulo-requisicao" style="text-align:center; padding-bottom:10px; padding-top:5px; margin:0; font-size:24px; font-family:Arial; font-weight:bold;">Fornecedores</p>
								</div>
								<div id="conteudo-requisicao" style="width:800px; overflow-y:auto; margin-top:40px;">
									<div id="mostra-dados" style="width:100%;">
										<div id="nomes" style="width:100%; margin-bottom:15px;">
											<p style="width:25%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000;">Fornecedor</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">CPF/CNPJ</p>
											<p style="width:20%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Cidade / UF</p>
											<p style="width:15%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Telefone</p>
											<p style="width:9%; float:left; margin:0; padding:1%; font-size:14px; font-weight:bold; font-family:Arial; text-align:center; border:1px dashed #000; border-left:0px;">Status</p>
											<br style="clear:both;"/>
										</div>
<?php
				$cont = 0;
				$cont2 = 0;
				
				$sqlFornecedors = "SELECT * FROM fornecedores WHERE codFornecedor != ''".$filtraStatus." ORDER BY statusFornecedor ASC, nomeFornecedor ASC, codFornecedor ASC";
				$resultFornecedors = $conn->query($sqlFornecedors);
				while($dadosFornecedors = $resultFornecedors->fetch_assoc()){
				
					$cont++;
					$cont2++;
						
					$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosFornecedors['codEstado']." LIMIT 0,1";
					$resultEstado = $conn->query($sqlEstado);
					$dadosEstado = $resultEstado->fetch_assoc();	
					
					$sqlCidade = "SELECT * FROM cidade WHERE codCidade = ".$dadosFornecedors['codCidade']." LIMIT 0,1";
					$resultCidade = $conn->query($sqlCidade);
					$dadosCidade = $resultCidade->fetch_assoc();
?>
										<div id="fornecedores" style="width:100%; padding-bottom:10px; margin-bottom:10px; border-bottom:1px dashed #000;">
											<p class="nome-fornecedor" style="width:27%; float:left; font-size:13px; margin:0; font-family:Arial; text-align:left;"><?php echo $dadosFornecedors['nomeFornecedor'];?></p>
											<p class="cidade-fornecedor" style="width:22%; float:left; font-size:13px; margin:0; font-family:Arial; text-align:center;"><?php echo $dadosFornecedors['cpfFornecedor'] ? $dadosFornecedors['cpfFornecedor'] : '--';?></p>
											<p class="cidade-fornecedor" style="width:22%; float:left; font-size:13px; margin:0; font-family:Arial; text-align:center;"><?php echo $dadosCidade['nomeCidade'] ? $dadosCidade['nomeCidade'].' / '.$dadosEstado['siglaEstado'] : '--';?></p>
											<p class="cidade-fornecedor" style="width:18%; float:left; font-size:13px; margin:0; font-family:Arial; text-align:center;"><?php echo $dadosFornecedors['telefoneFornecedor'] != "" ? $dadosFornecedors['telefoneFornecedor'] : $dadosFornecedors['celularFornecedor'];?><?php echo $dadosFornecedors['telefoneFornecedor'] == "" && $dadosFornecedors['celularFornecedor'] == "" ? '--' : '';?></p>
											<p class="cidade-fornecedor" style="width:11%; float:left; font-size:13px; margin:0; font-family:Arial; text-align:center;"><?php echo $dadosFornecedors['statusFornecedor'] == "T" ? 'Ativo' : 'Inativo';?></p>
											<br style="clear:both;"/>
										</div>
<?php
				}
?>
										<p class="total" style="padding-top:10px; margin-top:40px; font-family:Arial; font-size:13px; border-top:2px solid #000;">Total de Fornecedores: <strong><?php echo $cont;?></strong></p>
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

								$AGD("#busca-carregada").load("<?php echo $configUrl;?>cadastros/fornecedores/busca-fornecedores.php?buscaNome="+buscaNome);
								if(buscaNome == "" && buscaLote == "" && buscaQuadra == "" && buscaBairro == ""){
									document.getElementById("paginacao").style.display="block";
								}else{
									document.getElementById("paginacao").style.display="none";
								}
							}	
						</script>
						<div id="busca-carregada">
<?php
				$sqlConta = "SELECT count(codFornecedor) registros, nomeFornecedor, codFornecedor FROM fornecedores WHERE codFornecedor != ''".$filtraStatus."";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeFornecedor'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Nome</th>
									<th>CPF/CNPJ</th>									
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
					$sqlFornecedors = "SELECT * FROM fornecedores WHERE codFornecedor != ''".$filtraStatus." ORDER BY statusFornecedor ASC, nomeFornecedor ASC LIMIT 0,30";
				}else{
					$pagina = $url[5];
					$paginaFinal = $pagina * 30;
					$paginaInicial = $paginaFinal - 30;
					$sqlFornecedors = "SELECT * FROM fornecedores WHERE codFornecedor != ''".$filtraStatus." ORDER BY statusFornecedor ASC, nomeFornecedor ASC LIMIT ".$paginaInicial.",30";
				}		

				$resultFornecedors = $conn->query($sqlFornecedors);
				while($dadosFornecedors = $resultFornecedors->fetch_assoc()){
					$mostrando++;
					
					if($dadosFornecedors['statusFornecedor'] == "T"){
						$status = "status-ativo";
						$statusIcone = "ativado";
						$statusPergunta = "desativar";
					}else{
						$status = "status-desativado";
						$statusIcone = "desativado";
						$statusPergunta = "ativar";
					}	
					
					$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosFornecedors['codEstado']." LIMIT 0,1";
					$resultEstado = $conn->query($sqlEstado);
					$dadosEstado = $resultEstado->fetch_assoc();	
					
					$sqlCidade = "SELECT * FROM cidade WHERE codCidade = ".$dadosFornecedors['codCidade']." LIMIT 0,1";
					$resultCidade = $conn->query($sqlCidade);
					$dadosCidade = $resultCidade->fetch_assoc();	
					
					$sqlImagem = "SELECT * FROM fornecedoresImagens WHERE codFornecedor = ".$dadosFornecedors['codFornecedor']." LIMIT 0,1";
					$resultImagem = $conn->query($sqlImagem);
					$dadosImagem = $resultImagem->fetch_assoc();	
					
					$aniversario = explode("-", $dadosFornecedors['nascimentoFornecedor']);
					$novaData = $aniversario[2]."/".$aniversario[1];
?>
								<tr class="tr">
									<td class="vinte"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> cursor:pointer;" title="Aniversariante" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo2.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Veja os detalhes do fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>'><?php echo $dadosFornecedors['nomeFornecedor'];?></a></td>
									<td class="vinte" style="padding:0px; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosFornecedors['nomeFornecedor'] ?>'><?php echo $dadosFornecedors['cpfFornecedor'] != "" ? $dadosFornecedors['cpfFornecedor'] : '--';?></a></td>									
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Veja os detalhes do fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>'><?php echo $dadosCidade['nomeCidade'];?> / <?php echo $dadosEstado['siglaEstado'];?></a></td>
									<td class="vinte" style="width:15%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Veja os detalhes do fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>'><?php echo $dadosFornecedors['telefoneFornecedor'] != "" ? $dadosFornecedors['telefoneFornecedor'] : $dadosFornecedors['celularFornecedor'];?> <?php echo $dadosFornecedors['telefoneFornecedor'] == "" && $dadosFornecedors['celularFornecedor'] == "" ? '--' : '';?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/foto/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Deseja cadastrar fotos para o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?'><img style="margin-left:-8px; <?php echo $dadosImagem['codFornecedor'] == "" ? 'display:none;' : '';?>" src="<?php echo $configUrlGer.'f/fornecedores/'.$dadosImagem['codFornecedor'].'-'.$dadosImagem['codFornecedorImagem'].'-P.'.$dadosImagem['extFornecedorImagem'];?>" alt="icone" height="60"/><img style="<?php echo $dadosImagem['codFornecedor'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl;?>f/i/gerenciar-imagens.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/gerenciar-documentos/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Deseja cadastrar documentos para o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/ativacao/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Deseja <?php echo $statusPergunta ?> o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Deseja alterar o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosFornecedors['codFornecedor'] ?>, "<?php echo htmlspecialchars($dadosFornecedors['nomeFornecedor']) ?>");' title='Deseja excluir o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
				}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o fornecedor "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/fornecedores/excluir/'+cod+'/';
										}
									  }
								 </script>	 
							</table>							
						</div>
<?php
				if($url[3] != ""){
					$regPorPagina = 30;
					$area = "cadastros/fornecedores";
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
