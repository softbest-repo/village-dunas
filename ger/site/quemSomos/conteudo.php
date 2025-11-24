<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "quemSomos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){
					
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'><strong>".$_SESSION['nome']."</strong> alterada com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['descricao'] = "";
				}		
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Site</p>
						<p class="flexa"></p>
						<p class="nome-lista">Quem Somos</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>site/quemSomos/" method="post" />
								<div class="botao-novo" style="margin-left:0px;"><a title="Nova Área de Atuação" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Adicionar desempenhos </div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>				
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar'])){
					
					include ('f/conf/criaUrl.php');
					$urlServico = criaUrl($_POST['nome']);

					$sqlUltimoServico = "SELECT codOrdenacaoServico FROM quemSomos ORDER BY codOrdenacaoServico DESC LIMIT 0,1";
					$resultUltimoServico = $conn->query($sqlUltimoServico);
					$dadosUltimoServico = $resultUltimoServico->fetch_assoc();
					
					$novoOrdem = $dadosUltimoServico['codOrdenacaoServico'] + 1;	

					$descricao = str_replace("../../", $configUrlGer, $_POST['descricao']);
					$descricao = str_replace("../../", $configUrlGer, $descricao);

					
					$sql = "INSERT INTO quemSomos VALUES(0, ".$novoOrdem.", '".preparaNome($_POST['nome'])."', '".str_replace("'", "&#39;", $descricao)."', 'T', '".$urlServico."')";
					$result = $conn->query($sql);
					
					if($result == 1){
						if(isset($_POST['cadastrar'])){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastro'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."site/quemSomos/'>";
						}else{
							$erroData = "<p class='erro'>Área de Atuação <strong>".$_POST['nome']."</strong> cadastrada com sucesso!</p>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar área de atuação!</p>";
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
						<form action="<?php echo $configUrlGer; ?>site/quemSomos/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:842px;" required value="" /></p>

							<p class="bloco-campo" style="width:855px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:200px;" ></textarea></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Servico" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT nomeQuemSomos FROM quemSomos WHERE codQuemSomos != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeQuemSomos'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Nome</th>
								<th>Imagens</th>
								<th class="canto-dir">Alterar</th>
							</tr>					
<?php
					$sqlQuemSomos = "SELECT * FROM quemSomos";
					$resultQuemSomos = $conn->query($sqlQuemSomos);
					while($dadosQuemSomos = $resultQuemSomos->fetch_assoc()){
						
						$sqlImagem = "SELECT * FROM quemSomosImagens WHERE codQuemSomos = ".$dadosQuemSomos['codQuemSomos']." ORDER BY capaQuemSomosImagem ASC, codQuemSomosImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();													
?>
								<tr class="tr">
									<td class="noventa"><a href='<?php echo $configUrlGer; ?>site/quemSomos/alterar/<?php echo $dadosQuemSomos['codQuemSomos'] ?>/' title='Veja os detalhes <?php echo $dadosQuemSomos['nomeQuemSomos'] ?>'><?php echo strip_tags($dadosQuemSomos['nomeQuemSomos']);?></a></td>  
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>site/quemSomos/imagens/<?php echo $dadosQuemSomos['codQuemSomos'] ?>/' title='Deseja gerenciar imagens <?php echo $dadosQuemSomos['nomeQuemSomos'] ?>?' ><img style="<?php echo $dadosImagem['codQuemSomosImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/quemSomos/'.$dadosImagem['codQuemSomos'].'-'.$dadosImagem['codQuemSomosImagem'].'-W.webp';?>" height="50"/><img style="<?php echo $dadosImagem['codQuemSomosImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>site/quemSomos/alterar/<?php echo $dadosQuemSomos['codQuemSomos'] ?>/' title='Deseja alterar <?php echo $dadosQuemSomos['nomeQuemSomos'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								</tr>
<?php							
					}
?>							 
							</table>	
<?php
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
