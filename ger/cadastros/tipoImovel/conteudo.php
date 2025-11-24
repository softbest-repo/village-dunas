<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "tipoImovel";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Tipo Imóvel <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Tipo Imóvel <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['data'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Tipo Imóvel <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['descricao'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Tipo Imóvel <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = ""; 
				}
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Tipo Imóvel</p>
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
					 
						<form name="filtro" action="<?php echo $configUrl;?>cadastros/tipoImovel/" method="post" />
							<div class="botao-novo" style="margin-left:0px;"><a onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Tipo Imóvel</div><div class="direita-novo"></div></a></div>
							<div class="botao-novo" style="display:<?php echo $url[5] == 1 ? 'block' : 'none';?>; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
							<br class="clear" />
						</form>
					</div>
					</div>			
					<div id="cadastrar" style="display:<?php echo $url[5] == 1 ? 'block' : 'none';?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar'])){

					include ('f/conf/criaUrl.php');
					$urlTipoImovel = criaUrl($_POST['nome']);
					
					$sql = "INSERT INTO tipoImovel VALUES(0, '".$_POST['nome']."', '".$_POST['sigla']."', 'T', '".$urlTipoImovel."')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastro'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/tipoImovel/'>";					
					}else{
						$erroConteudo = "<p class='erro'>Problemas ao cadastrar o tipo imóvel!</p>";
					}		
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
						<form action="<?php echo $configUrlGer; ?>cadastros/tipoImovel/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:375px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>
							
							<p class="bloco-campo"><label>Sigla: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="sigla" style="width:80px;" required value="<?php echo $_SESSION['sigla']; ?>" /></p>
							 
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Tipo Imóvel" value="Salvar" /><p class="direita-botao"></p></div></p>						
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

				$sqlConta = "SELECT * FROM tipoImovel WHERE codTipoImovel != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);

				if($dadosConta['nomeTipoImovel'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Nome</th>
								<th>Sigla</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php


					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlTipoImovel = "SELECT * FROM tipoImovel ORDER BY statusTipoImovel ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlTipoImovel = "SELECT * FROM tipoImovel ORDER BY statusTipoImovel ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultTipoImovel = $conn->query($sqlTipoImovel);
					while($dadosTipoImovel = $resultTipoImovel->fetch_assoc()){
						$mostrando++;
						
						if($dadosTipoImovel['statusTipoImovel'] == "T"){
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
								<td class="oitenta"><a href='<?php echo $configUrlGer; ?>cadastros/tipoImovel/alterar/<?php echo $dadosTipoImovel['codTipoImovel'] ?>/' title='Veja os detalhes do tipo imóvel <?php echo $dadosTipoImovel['nomeTipoImovel'] ?>'><?php echo $dadosTipoImovel['nomeTipoImovel'];?></a></td>
								<td class="dez" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/tipoImovel/alterar/<?php echo $dadosTipoImovel['codTipoImovel'] ?>/' title='Veja os detalhes do tipo imóvel <?php echo $dadosTipoImovel['nomeTipoImovel'] ?>'><?php echo $dadosTipoImovel['siglaTipoImovel'];?></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/tipoImovel/ativacao/<?php echo $dadosTipoImovel['codTipoImovel'] ?>/' title='Deseja <?php echo $statusPergunta ?> o tipo imóvel <?php echo $dadosTipoImovel['nomeTipoImovel'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/tipoImovel/alterar/<?php echo $dadosTipoImovel['codTipoImovel'] ?>/' title='Deseja alterar o tipo imóvel <?php echo $dadosTipoImovel['nomeTipoImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosTipoImovel['codTipoImovel'] ?>, "<?php echo htmlspecialchars($dadosTipoImovel['nomeTipoImovel']) ?>");' title='Deseja excluir o tipo imóvel <?php echo $dadosTipoImovel['nomeTipoImovel'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
							</tr>
<?php
					}
?>
							<script>
								 function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir o tipo imóvel "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>cadastros/tipoImovel/excluir/'+cod+'/';
									}
								  }
							 </script> 
						</table>	
<?php
				}
			
				$regPorPagina = 30;
				$area = "cadastros/tipoImovel";
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
