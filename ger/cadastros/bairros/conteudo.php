<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "bairros";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Bairro <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Bairro <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Bairro <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Bairro <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}	
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Bairros</p>
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
						 
							<form name="filtro" action="<?php echo $configUrl;?>cadastros/bairros/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Bairro" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Bairro</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>
					
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if($_POST['nome'] != ""){

					include ('f/conf/criaUrl.php');
					$urlBairro = criaUrl($_POST['nome']);

					$descricao = str_replace("../../", $configUrlGer, $_POST['descricao']);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../", $configUrlGer, $descricao);
						
					$sqlUltimoBairro = "SELECT codOrdenacaoBairro FROM bairros ORDER BY codOrdenacaoBairro DESC LIMIT 0,1";
					$resultUltimoBairro = $conn->query($sqlUltimoBairro);
					$dadosUltimoBairro = $resultUltimoBairro->fetch_assoc();
					
					$novoOrdem = $dadosUltimoBairro['codOrdenacaoBairro'] + 1;
															
					$sql = "INSERT INTO bairros VALUES(0, ".$novoOrdem.", '".$_POST['cidade']."', '".$_POST['nome']."', '".str_replace("'", "&#39;", $descricao)."', 'T', '".$urlBairro."')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastro'] = "ok";
						$_SESSION['cidade'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/bairros/'>";					
					}else{
						$erroConteudo = "<p class='erro'>Problemas ao cadastrar o bairro!</p>";
					}
					
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['cidade'] = "";
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
						<form action="<?php echo $configUrlGer; ?>cadastros/bairros/" method="post">
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:575px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<p class="bloco-campo-float"><label>Cidade: <span class="obrigatorio"> </span></label>
								<select class="campo" id="cidade" required name="cidade" style="width:300px; padding:6px;">
									<option value="">Selecione</option>
<?php
				$sqlCidades = "SELECT * FROM cidades WHERE statusCidade = 'T' ORDER BY nomeCidade ASC";
				$resultCidades = $conn->query($sqlCidades);
				while($dadosCidades = $resultCidades->fetch_assoc()){
?>
										<option value="<?php echo $dadosCidades['codCidade'] ;?>" <?php echo $_SESSION['cidade'] == $dadosCidades['codCidade'] ? '/SELECTED/' : '';?>><?php echo $dadosCidades['nomeCidade'] ;?></option>
<?php
				}
?>					
								</select>
							</p>
							
							<br class="clear"/>

							<p class="bloco-campo" style="width:900px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:600px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>
																							 
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Bairro" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				$sqlConta = "SELECT nomeBairro FROM bairros WHERE codBairro != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeBairro'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Nome</th>
									<th>Cidade</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlBairro = "SELECT * FROM bairros ORDER BY statusBairro ASC, nomeBairro ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlBairro = "SELECT * FROM bairros ORDER BY statusBairro ASC, nomeBairro ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultBairro = $conn->query($sqlBairro);
					while($dadosBairro = $resultBairro->fetch_assoc()){
						$mostrando++;
						
						if($dadosBairro['statusBairro'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}	

						$sqlCidades = "SELECT * FROM cidades WHERE statusCidade = 'T' and codCidade = ".$dadosBairro['codCidade']." ORDER BY nomeCidade ASC";
						$resultCidades = $conn->query($sqlCidades);
						$dadosCidades = $resultCidades->fetch_assoc();

						$sqlImagem = "SELECT * FROM bairrosImagens WHERE codBairro = ".$dadosBairro['codBairro']." ORDER BY capaBairroImagem ASC, codBairroImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();							
?>

								<tr class="tr">
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>cadastros/bairros/alterar/<?php echo $dadosBairro['codBairro'] ?>/' title='Veja os detalhes do bairro <?php echo $dadosBairro['nomeBairro'] ?>'><?php echo $dadosBairro['nomeBairro'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/bairros/alterar/<?php echo $dadosBairro['codBairro'] ?>/' title='Veja os detalhes do bairro <?php echo $dadosBairro['nomeBairro'] ?>'><?php echo $dadosCidades['nomeCidade'];?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/bairros/ativacao/<?php echo $dadosBairro['codBairro'] ?>/' title='Deseja <?php echo $statusPergunta ?> o bairro <?php echo $dadosBairro['nomeBairro'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/bairros/alterar/<?php echo $dadosBairro['codBairro'] ?>/' title='Deseja alterar o bairro <?php echo $dadosBairro['nomeBairro'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosBairro['codBairro'] ?>, "<?php echo htmlspecialchars($dadosBairro['nomeBairro']) ?>");' title='Deseja excluir o bairro <?php echo $dadosBairro['nomeBairro'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o bairro "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/bairros/excluir/'+cod+'/';
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
				$area = "cadastros/bairros";
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
