<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "proprietarios";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastrar'] == "ok"){
					$erroConteudo = "<p class='erro'>Proprietário <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastrar'] = "";
					$_SESSION['nome'] = "";	
				}else	
				if($_SESSION['alterar'] == "ok"){
					$erroConteudo = "<p class='erro'>Proprietário <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alterar'] = "";
					$_SESSION['nome'] = "";	
				}else	
				if($_SESSION['ativar'] == "ok"){
					$erroConteudo = "<p class='erro'>Proprietário <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativar'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['excluir'] == "ok"){
					$erroConteudo = "<p class='erro'>Proprietário <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
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
					$filtraStatus = " and statusProprietario = '".$_SESSION['statusFiltro']."'";
				}	
				
				if(isset($_POST['usuarioFiltro'])){
					if($_POST['usuarioFiltro'] != ""){
						$_SESSION['usuarioFiltro'] = $_POST['usuarioFiltro'];
					}else{
						$_SESSION['usuarioFiltro'] = "";
					}
				}
				
				if($_SESSION['usuarioFiltro'] != ""){
					$filtraUsuarioF = " and codUsuario = '".$_SESSION['usuarioFiltro']."'";
				}	
?>

				<div id="filtro">							
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Proprietários</p>	
						<br class="clear"/>
					</div>
					<div class="demoTarget">
						<script type="text/javascript">
							function alteraStatus(status){
								document.getElementById("filtroStatus").submit();
							}
						</script>
						<div id="formulario-filtro">
							<form id="filtroStatus" action="<?php echo $configUrl;?>cadastros/proprietarios/" method="post">

								<p class="nome-clientes-filtro" style="width:220px;"><label class="label">Filtrar Nome:</label>
								<input type="text" style="width:200px;" name="proprietarios" onKeyUp="buscaAvancada();" id="busca" autocomplete="off" value="<?php echo $_SESSION['nome-proprietarios-filtro'];?>" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />

								<p class="bloco-campo-float"><label>Filtrar Corretor: <span class="obrigatorio"> </span></label>
									<select class="campo" id="usuarioFiltro" name="usuarioFiltro" style="width:190px; padding:6px; margin-right:0px;" onChange="alteraStatus();">
										<option value="">Todos</option>
<?php
				$sqlUsuarios = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4".$filtraUsuario." ORDER BY nomeUsuario ASC";
				$resultUsuarios = $conn->query($sqlUsuarios);
				while($dadosUsuarios = $resultUsuarios->fetch_assoc()){
?>
										<option value="<?php echo $dadosUsuarios['codUsuario'] ;?>" <?php echo $_SESSION['usuarioFiltro'] == $dadosUsuarios['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuarios['nomeUsuario'] ;?></option>
<?php
}
?>					
									</select>
									<br class="clear"/>
								</p>

								<p class="bloco-campo-float"><label>Filtrar Status: <span class="obrigatorio"> </span></label>
									<select class="campo" name="statusFiltro" style="width:155px; padding:6px;" required onChange="alteraStatus(this.value);">
										<option value="">Todos</option>
										<option value="T" <?php echo $_SESSION['statusFiltro'] == "T" ? '/SELECTED/' : '';?>>Ativo</option>
										<option value="F" <?php echo $_SESSION['statusFiltro'] == "F" ? '/SELECTED/' : '';?>>Inativo</option>
									</select>
								</p>	
								
								<div class="botao-novo" style="margin-top:17px; margin-left:0px;"><a title="Novo Proprietário" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">Novo Proprietário</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px; margin-top:18px;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>

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
				$sqlProprietario = "SELECT * FROM proprietarios WHERE nomeProprietario = '".$_POST['nome']."' LIMIT 0,1";
				$resultProprietario = $conn->query($sqlProprietario);
		
				if($_POST['nome'] != "" && $resultProprietario->num_rows == 0){
													
					$sql = "INSERT INTO proprietarios VALUES(0, '".$_POST['usuario']."', '".$_POST['nome']."', '".$_POST['cpf']."', '".$_POST['rg']."', '".$_POST['emissor']."', '".$_POST['sexo']."', '".data($_POST['nascimento'])."', '".$_POST['endereco']."', '".$_POST['bairro']."', '".$_POST['estado']."', '".$_POST['cidade']."', '".$_POST['cep']."', '".$_POST['email']."', '".$_POST['telefone']."', '".$_POST['celular']."', 'T')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastrar'] = "ok";
						$_SESSION['usuario'] = "";
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
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/proprietarios/'>";					
						$block = "none";		
					}else{
						$erroConteudo = "<p class='erro'>Problemas ao cadastrar proprietário!</p>";
						$_SESSION['nome'] = "";
						$_SESSION['usuario'] = "";
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

					if($_POST['nome'] == "" && isset($_POST['nome'])){
						$erroData = "<p class='erro'>Preencha o campo do nome do proprietário!</p>";
					}else
					if($_POST['nome'] != "" && $resultProprietario->num_rows >= 1){
						$erroData = "<p class='erro'>Proprietário já cadastrado!</p>";
					}
					$_SESSION['nome'] = "";
					$_SESSION['usuario'] = "";
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
					$_SESSION['estado'] = "24";
					$_SESSION['cidade'] = "";
					$_SESSION['cep'] = "";		
					$_SESSION['email'] = "";		
					$_SESSION['telefone'] = "";		
					$_SESSION['celular'] = "";	
					$_SESSION['dependentes'] = "";	
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
								$tgf.post("<?php echo $configUrl;?>cadastros/proprietarios/carrega-cidade.php", {codEstado: cod}, function(data){
									$tgf("#carrega-cidade").html(data);
									$tgf("#sel-padrao").css("display", "none");																									
								});
							}

						</script>	
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
						<form name="formProprietario" action="<?php echo $configUrlGer; ?>cadastros/proprietarios/" method="post">

							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="usuario" name="usuario" style="width:190px;" required>
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
							<input class="campo-nomes" type="text" style="width:237px;" id="nome" required name="nome" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label>CPF: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="cpf" value="<?php echo $_SESSION['cpf']; ?>" onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);"/></p>

							<p class="bloco-campo-float"><label>RG: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="rg" value="<?php echo $_SESSION['rg']; ?>"/></p>

							<br class="clear"/>

							<p class="bloco-campo-float"><label>Orgão Emissor: <span class="obrigatorio"> </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="emissor" value="<?php echo $_SESSION['emissor']; ?>"/></p>

							<p class="bloco-campo-float"><label>Sexo: <span class="obrigatorio"> * </span></label>
							<input class="caixa" name="sexo" type="radio" value="M" <?php echo $_SESSION['sexo'] == "M" || $_SESSION['sexo'] == "" ? 'checked' : ''; ?> />Masculino   <input class="caixa" name="sexo" type="radio" value="F" <?php echo $_SESSION['sexo'] == 'F' ? 'checked' : ''; ?> />Feminino</p>
							
							<p class="bloco-campo-float"><label>Data de Nascimento: <span class="obrigatorio"> * </span></label>
							<input class="campo-5" type="text" style="width:150px;" name="nascimento" required value="<?php echo $_SESSION['nascimento']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

							<p class="bloco-campo-float"><label>Endereço:</label>
							<input class="campo-4" type="text" style="width:280px;" name="endereco" value="<?php echo $_SESSION['endereco']; ?>"/></p>
							
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
				if($_SESSION['estado'] != ""){
?>
								<p class="bloco-campo-float"><label class="label">Cidade: <span class="obrigatorio"> * </span></label>
									<select class="campo" name="cidade" style="width:288px;" id="cidade">
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
							function buscaAvancada(){
								var $AGD = jQuery.noConflict();
								var busca = $AGD("#busca").val();
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								busca = busca.replace(" ", "-");
								$AGD("#busca-carregada").load("<?php echo $configUrl;?>cadastros/proprietarios/busca-proprietarios.php?busca="+busca);
								if(busca == ""){
									document.getElementById("paginacao").style.display="block";
								}else{
									document.getElementById("paginacao").style.display="none";
								}
							}	
						</script>
						<div id="busca-carregada">
<?php
				$sqlConta = "SELECT nomeProprietario, codProprietario FROM proprietarios WHERE nomeProprietario != ''".$filtraStatus.$filtraUsuario.$filtraUsuarioF."";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeProprietario'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Proprietário</th>
									<th>Corretor</th>
									<th>Cidade / Estado</th>
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
					$sqlProprietarios = "SELECT * FROM proprietarios WHERE nomeProprietario != ''".$filtraStatus.$filtraUsuario.$filtraUsuarioF." ORDER BY statusProprietario ASC, CASE WHEN codProprietario = 0 THEN codProprietario ELSE nomeProprietario END ASC LIMIT 0,30";
				}else{
					$pagina = $url[5];
					$paginaFinal = $pagina * 30;
					$paginaInicial = $paginaFinal - 30;
					$sqlProprietarios = "SELECT * FROM proprietarios WHERE nomeProprietario != ''".$filtraStatus.$filtraUsuario.$filtraUsuarioF." ORDER BY statusProprietario ASC, CASE WHEN codProprietario = 0 THEN codProprietario ELSE nomeProprietario END ASC LIMIT ".$paginaInicial.",30";
				}		

				$resultProprietarios = $conn->query($sqlProprietarios);
				while($dadosProprietarios = $resultProprietarios->fetch_assoc()){
					$mostrando++;
					
					if($dadosProprietarios['statusProprietario'] == "T"){
						$status = "status-ativo";
						$statusIcone = "ativado";
						$statusPergunta = "desativar";
					}else{
						$status = "status-desativado";
						$statusIcone = "desativado";
						$statusPergunta = "ativar";
					}	
					
					$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosProprietarios['codUsuario']." LIMIT 0,1";
					$resultUsuario = $conn->query($sqlUsuario);
					$dadosUsuario = $resultUsuario->fetch_assoc();	
					
					$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosProprietarios['codEstado']." LIMIT 0,1";
					$resultEstado = $conn->query($sqlEstado);
					$dadosEstado = $resultEstado->fetch_assoc();	
					
					$sqlCidade = "SELECT * FROM cidade WHERE codCidade = ".$dadosProprietarios['codCidade']." LIMIT 0,1";
					$resultCidade = $conn->query($sqlCidade);
					$dadosCidade = $resultCidade->fetch_assoc();	
					
					$sqlImagem = "SELECT * FROM proprietariosImagens WHERE codProprietario = ".$dadosProprietarios['codProprietario']." LIMIT 0,1";
					$resultImagem = $conn->query($sqlImagem);
					$dadosImagem = $resultImagem->fetch_assoc();	
					
					$aniversario = explode("-", $dadosProprietarios['nascimentoProprietario']);
					$novaData = $aniversario[2]."/".$aniversario[1];

					if($dadosProprietarios['codProprietario'] == 0){
?>
								<tr class="tr">
									<td class="trinta" colspan="9" style="font-weight:bold;"><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosProprietarios['nomeProprietario'];?></a></td>
								</tr>
<?php
					}else{
?>
								<tr class="tr">
									<td class="trinta"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> padding-right:10px; cursor:pointer;" title="Clique para ver o numero" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosProprietarios['nomeProprietario'];?></a></td>
									<td class="vinte" style="text-align:center;"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> padding-right:10px; cursor:pointer;" title="Clique para ver o numero" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosUsuario['nomeUsuario'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosCidade['nomeCidade'];?> / <?php echo $dadosEstado['siglaEstado'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosProprietarios['telefoneProprietario'] != "" ? $dadosProprietarios['telefoneProprietario'] : $dadosProprietarios['celularProprietario'];?> <?php echo $dadosProprietarios['telefoneProprietario'] == "" && $dadosProprietarios['celularProprietario'] == "" ? '--' : '';?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/foto/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Deseja cadastrar fotos para o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?'><img style="margin-left:-8px; <?php echo $dadosImagem['codProprietario'] == "" ? 'display:none;' : '';?>" src="<?php echo $configUrlGer.'f/proprietarios/'.$dadosImagem['codProprietario'].'-'.$dadosImagem['codProprietarioImagem'].'-P.'.$dadosImagem['extProprietarioImagem'];?>" alt="icone" height="60"/><img style="<?php echo $dadosImagem['codProprietario'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl;?>f/i/gerenciar-imagens.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/gerenciar-documentos/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Deseja cadastrar documentos para o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/ativacao/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Deseja <?php echo $statusPergunta ?> o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Deseja alterar o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosProprietarios['codProprietario'] ?>, "<?php echo htmlspecialchars($dadosProprietarios['nomeProprietario']) ?>");' title='Deseja excluir o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}

				}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o proprietário "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/proprietarios/excluir/'+cod+'/';
										}
									  }
								 </script>	 
							</table>							
						</div>
<?php
				if($url[3] != ""){
					$regPorPagina = 30;
					$area = "cadastros/proprietarios";
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
