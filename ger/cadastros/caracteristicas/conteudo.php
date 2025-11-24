<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "caracteristicas";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Característica <strong>".$_SESSION['nome']."</strong> cadastrada com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Característica <strong>".$_SESSION['nome']."</strong> alterada com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Característica <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Característica <strong>".$_SESSION['nome']."</strong> excluída com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}	
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Características</p>
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
						 
							<form name="filtro" action="<?php echo $configUrl;?>cadastros/caracteristicas/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Caracteristica" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Característica</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>
					
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if($_POST['nome'] != ""){

					$sqlUltimoCaracteristica = "SELECT codOrdenacaoCaracteristica FROM caracteristicas ORDER BY codOrdenacaoCaracteristica DESC LIMIT 0,1";
					$resultUltimoCaracteristica = $conn->query($sqlUltimoCaracteristica);
					$dadosUltimoCaracteristica = $resultUltimoCaracteristica->fetch_assoc();
					
					$novoOrdem = $dadosUltimoCaracteristica['codOrdenacaoCaracteristica'] + 1;	
					
					$sql = "INSERT INTO caracteristicas VALUES(0, ".$novoOrdem.", '".$_POST['nome']."', 'T')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastro'] = "ok";
						$_SESSION['estado'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/caracteristicas/'>";					
					}else{
						$erroConteudo = "<p class='erro'>Problemas ao cadastrar a característica!</p>";
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
						<form action="<?php echo $configUrlGer; ?>cadastros/caracteristicas/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:275px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
							 
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Caracteristica" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				$sqlConta = "SELECT * FROM caracteristicas WHERE codCaracteristica != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeCaracteristica'] != ""){
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Ordenação</th>
									<th>Nome</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlCaracteristica = "SELECT * FROM caracteristicas ORDER BY statusCaracteristica ASC, codOrdenacaoCaracteristica ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlCaracteristica = "SELECT * FROM caracteristicas ORDER BY statusCaracteristica ASC, codOrdenacaoCaracteristica ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultCaracteristica = $conn->query($sqlCaracteristica);
					while($dadosCaracteristica = $resultCaracteristica->fetch_assoc()){
						$mostrando++;
						
						if($dadosCaracteristica['statusCaracteristica'] == "T"){
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
									<td class="dez" style="text-align:center;"><input type="number" class="campo" style="width:30px; text-align:center; border:1px solid #0000FF; outline:none;" value="<?php echo $dadosCaracteristica['codOrdenacaoCaracteristica'];?>" onClick="alteraCor(<?php echo $dadosCaracteristica['codCaracteristica'];?>);" onBlur="alteraOrdem(<?php echo $dadosCaracteristica['codCaracteristica'];?>, this.value);" id="codOrdena<?php echo $dadosCaracteristica['codCaracteristica'];?>"/></td>
									<td class="oitenta"><a href='<?php echo $configUrlGer; ?>cadastros/caracteristicas/alterar/<?php echo $dadosCaracteristica['codCaracteristica'] ?>/' title='Veja os detalhes da característica <?php echo $dadosCaracteristica['nomeCaracteristica'] ?>'><?php echo $dadosCaracteristica['nomeCaracteristica'];?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/caracteristicas/ativacao/<?php echo $dadosCaracteristica['codCaracteristica'] ?>/' title='Deseja <?php echo $statusPergunta ?> a característica <?php echo $dadosCaracteristica['nomeCaracteristica'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/caracteristicas/alterar/<?php echo $dadosCaracteristica['codCaracteristica'] ?>/' title='Deseja alterar a característica <?php echo $dadosCaracteristica['nomeCaracteristica'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosCaracteristica['codCaracteristica'] ?>, "<?php echo htmlspecialchars($dadosCaracteristica['nomeCaracteristica']) ?>");' title='Deseja excluir a característica <?php echo $dadosCaracteristica['nomeCaracteristica'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
					}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir a característica "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/caracteristicas/excluir/'+cod+'/';
										}
									  }
								</script>
								<script type="text/javascript">
									function alteraCor(cod){
										var $po2 = jQuery.noConflict();
										$po2("#codOrdena"+cod).css("border", "1px solid #FF0000");
									}

									function alteraOrdem(cod, ordem){
										var $po = jQuery.noConflict();
										$po.post("<?php echo $configUrlGer;?>cadastros/caracteristicas/ordem.php", {codCaracteristica: cod, codOrdenacaoCaracteristica: ordem}, function(data){		
											$po("#codOrdena"+cod).css("border", "1px solid #0000FF");
										});											
									}
								</script>								 
							</table>	
<?php
				}	
?>							
						</div>
<?php
				$regPorPagina = 30;
				$area = "cadastros/caracteristicas";
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
