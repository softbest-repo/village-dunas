<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "cidade";
			if(validaAcesso($conn, $area) == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Cidade <strong>".$_SESSION['nome']."</strong> cadastrada com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Cidade <strong>".$_SESSION['nome']."</strong> alterada com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Cidade <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Cidade <strong>".$_SESSION['nome']."</strong> excluída com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}	
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Cidades</p>
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
						 
							<form name="filtro" action="<?php echo $configUrl;?>cadastros/cidade/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Nova Cidade" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Cidade</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>
					
					<div id="cadastrar" style="display:none; margin-top:30px;">
<?php
				if($_POST['nome'] != ""){

					include ('f/conf/criaUrl.php');
					$urlCidade = criaUrl($_POST['nome']);	
										
					$sql = "INSERT INTO cidade VALUES(0, '".$_POST['estado']."', '".$_POST['nome']."', 'T', '".$urlCidade."')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastro'] = "ok";
						$_SESSION['estado'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/cidade/'>";					
					}else{
						$erroConteudo = "<p class='erro'>Problemas ao cadastrar o cidade!</p>";
					}
					
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['estado'] = "";
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
						<form action="<?php echo $configUrlGer; ?>cadastros/cidade/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:275px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<p class="bloco-campo"><label>Estado: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="estado" name="estado" style="width:290px;" required>
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
							</p>
														  
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Cidade" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				$sqlConta = "SELECT count(codCidade) registros, nomeCidade FROM cidade WHERE codCidade != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeCidade'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq" >Nome</th>
									<th>Estado</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlCidade = "SELECT * FROM cidade ORDER BY statusCidade ASC, codEstado ASC, nomeCidade ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlCidade = "SELECT * FROM cidade ORDER BY statusCidade ASC, codEstado ASC, nomeCidade ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultCidade = $conn->query($sqlCidade);
					while($dadosCidade = $resultCidade->fetch_assoc()){
						$mostrando++;
						
						if($dadosCidade['statusCidade'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}	
						
						$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosCidade['codEstado']." LIMIT 0,1";
						$resultEstado = $conn->query($sqlEstado);
						$dadosEstado = $resultEstado->fetch_assoc();	
?>

								<tr class="tr">
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>cadastros/cidade/alterar/<?php echo $dadosCidade['codCidade'] ?>/' title='Veja os detalhes da cidade <?php echo $dadosCidade['nomeCidade'] ?>'><?php echo $dadosCidade['nomeCidade'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/cidade/alterar/<?php echo $dadosCidade['codCidade'] ?>/' title='Veja os detalhes da cidade <?php echo $dadosCidade['nomeCidade'] ?>'><?php echo $dadosEstado['nomeEstado'];?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/cidade/ativacao/<?php echo $dadosCidade['codCidade'] ?>/' title='Deseja <?php echo $statusPergunta ?> a cidade <?php echo $dadosCidade['nomeCidade'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/cidade/alterar/<?php echo $dadosCidade['codCidade'] ?>/' title='Deseja alterar a cidade <?php echo $dadosCidade['nomeCidade'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosCidade['codCidade'] ?>, "<?php echo htmlspecialchars($dadosCidade['nomeCidade']) ?>");' title='Deseja excluir a cidade <?php echo $dadosCidade['nomeCidade'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir a cidade "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/cidade/excluir/'+cod+'/';
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
				$area = "cadastros/cidade";
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
