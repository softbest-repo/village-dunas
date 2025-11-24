<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "filiais";
			if(validaAcesso($conn, $area) == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Filial <strong>".$_SESSION['nome']."</strong> cadastrada com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Filial <strong>".$_SESSION['nome']."</strong> alterada com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Filial <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Filial <strong>".$_SESSION['nome']."</strong> excluída com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}	
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Filiais</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
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
						 
							<form name="filtro" action="<?php echo $configUrl;?>cadastros/filiais/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Nova Filial" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Filial</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>
					
					<div id="cadastrar" style="display:none; margin-top:30px; margin-left:30px;">
<?php
				if($_POST['nome'] != ""){
					
					$sql = "INSERT INTO filiais VALUES(0, '".$_POST['nome']."', 'T')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastro'] = "ok";
						$_SESSION['filiais'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/filiais/'>";					
					}else{
						$erroConteudo = "<p class='erro'>Problemas ao cadastrar a filial!</p>";
					}
					
				}else{
					$_SESSION['nome'] = "";
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
						<form action="<?php echo $configUrlGer; ?>cadastros/filiais/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:275px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
													  
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Filial" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
						<div id="busca-carregada">
<?php				
				$sqlConta = "SELECT count(codFilial) registros, nomeFilial FROM filiais WHERE codFilial != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeFilial'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq" >Nome</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlFilial = "SELECT * FROM filiais ORDER BY statusFilial ASC, codFilial ASC, nomeFilial ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlFilial = "SELECT * FROM filiais ORDER BY statusFilial ASC, codFilial ASC, nomeFilial ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultFilial = $conn->query($sqlFilial);
					while($dadosFilial = $resultFilial->fetch_assoc()){
						$mostrando++;
						
						if($dadosFilial['statusFilial'] == "T"){
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
									<td class="noventa"><a href='<?php echo $configUrlGer; ?>cadastros/filiais/alterar/<?php echo $dadosFilial['codFilial'] ?>/' title='Veja os detalhes da filial <?php echo $dadosFilial['nomeFilial'] ?>'><?php echo $dadosFilial['nomeFilial'];?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/filiais/ativacao/<?php echo $dadosFilial['codFilial'] ?>/' title='Deseja <?php echo $statusPergunta ?> a filial <?php echo $dadosFilial['nomeFilial'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/filiais/alterar/<?php echo $dadosFilial['codFilial'] ?>/' title='Deseja alterar a filial <?php echo $dadosFilial['nomeFilial'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosFilial['codFilial'] ?>, "<?php echo htmlspecialchars($dadosFilial['nomeFilial']) ?>");' title='Deseja excluir a filial <?php echo $dadosFilial['nomeFilial'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir a filial "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/filiais/excluir/'+cod+'/';
										}
									  }
								 </script>
								 
							</table>	
<?php
				}	
?>							
						</div>
<?php
				$regPorPagina = 30;
				$area = "cadastros/filiais";
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
