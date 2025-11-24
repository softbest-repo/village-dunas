<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "bancos";
			if(validaAcesso($conn, $area) == "ok"){
		
				if($_SESSION['cadastrar'] == "ok"){
					$erroConteudo = "<p class='erro'>Banco <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastrar'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['alterar'] == "ok"){
					$erroConteudo = "<p class='erro'>Banco <strong>".$_SESSION['nomeAlt']."</strong> alterado com sucesso!</p>";
					$_SESSION['alterar'] = "";
					$_SESSION['nomeAlt'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['ativar'] == "ok"){
					$erroConteudo = "<p class='erro'>Banco <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativar'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['excluir'] == "ok"){
					$erroConteudo = "<p class='erro'>Banco <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['excluir'] = "";
					$_SESSION['nome'] = "";
				}	
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Bancos</p>
						<br class="clear" />
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
					<div class="demoTarget">
						<div id="formulario-filtro">
							<div class="botao-novo" style="margin-left:0px;"><a onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Banco</div><div class="direita-novo"></div></a></div>
							<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
							<br class="clear" />
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-top:30px; margin-left:30px;">
<?php
				if($_POST['nome'] != ""){

					$sql = "INSERT INTO bancosConta VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", '".$_POST['nome']."', '".$_POST['codigo']."', 'T')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastrar'] = "ok";
						$_SESSION['codigo'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/bancosConta/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar banco!</p>";
						$_SESSION['nome'] = "";
						$_SESSION['codigo'] = "";
					}		
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['codigo'] = "";
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
						<form name="formBancoConta" action="<?php echo $configUrlGer; ?>financeiro/bancosConta/" method="post">
							<input type="hidden" id="tipoEnvio" name="tipoEnvio" value="" />
							
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="nome" name="nome" required style="width:310px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo"><label>Código: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="codigo" name="codigo" required style="width:130px;" value="<?php echo $_SESSION['codigo'];?>" /></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
			
				$sqlConta = "SELECT count(codBancoConta) registros, nomeBancoConta FROM bancosConta";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeBancoConta'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Nome</th>
								<th>Código</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlBancoConta = "SELECT * FROM bancosConta ORDER BY statusBancoConta ASC, codBancoConta DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlBancoConta = "SELECT * FROM bancosConta ORDER BY statusBancoConta ASC, codBancoConta DESC LIMIT ".$paginaInicial.",30";
					}		
					

					$resultBancoConta = $conn->query($sqlBancoConta);
					while($dadosBancoConta = $resultBancoConta->fetch_assoc()){
						$mostrando++;
						
						if($dadosBancoConta['statusBancoConta'] == "T"){
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
								<td class="oitenta"><span class="campo-conteudo"><?php echo $dadosBancoConta['nomeBancoConta'];?></span></td>
								<td class="vinte" style="text-align:center;"><?php echo $dadosBancoConta['codigoBancoConta'];?></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>financeiro/bancosConta/ativacao/<?php echo $dadosBancoConta['codBancoConta'] ?>/' title='Deseja <?php echo $statusPergunta ?> o banco <?php echo $dadosBancoConta['nomeBancoConta'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>financeiro/bancosConta/alterar/<?php echo $dadosBancoConta['codBancoConta'] ?>/' title='Deseja alterar o banco <?php echo $dadosBancoConta['nomeBancoConta'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosBancoConta['codBancoConta'] ?>, "<?php echo htmlspecialchars($dadosBancoConta['nomeBancoConta']) ?>");' title='Deseja excluir o banco <?php echo $dadosBancoConta['nomeBancoConta'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
							</tr>
<?php
					}
?>
							<script>
								function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir o banco "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>financeiro/bancosConta/excluir/'+cod+'/';
									}
								}
							</script>	 
						</table>	
<?php
				}

				$regPorPagina = 30;
				$area = "financeiro/bancosConta";
				include ('f/conf/paginacao.php');		
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
