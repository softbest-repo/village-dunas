<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "balnearioGaivota";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Conheça <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nomeAlt'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Site</p>
						<p class="flexa"></p>
						<p class="nome-lista">Conheça Balneário Gaivota</p>
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
							<form name="filtro" action="<?php echo $configUrl;?>site/balnearioGaivota/" method="post" />
							</form>
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
				
				$sqlConta = "SELECT * FROM balnearioGaivota WHERE codBalnearioGaivota != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = mysqli_num_rows($resultConta);
				
				if($dadosConta['nomeBalnearioGaivota'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Nome</th>
								<th>Imagens</th>
								<th class="canto-dir">Alterar</th>
							</tr>					
<?php


					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlBalnearioGaivota = "SELECT * FROM balnearioGaivota ORDER BY codBalnearioGaivota DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlBalnearioGaivota = "SELECT * FROM balnearioGaivota ORDER BY codBalnearioGaivota DESC LIMIT ".$paginaInicial.",30";
					}		

					$resultBalnearioGaivota = $conn->query($sqlBalnearioGaivota);
					while($dadosBalnearioGaivota = $resultBalnearioGaivota->fetch_assoc()){
						$mostrando++;
						
						$sqlImagemF = "SELECT * FROM balnearioGaivotaImagens WHERE codBalnearioGaivota = ".$dadosBalnearioGaivota['codBalnearioGaivota']." and tipoBalnearioGaivotaImagem = 'F' ORDER BY capaBalnearioGaivotaImagem ASC, codBalnearioGaivotaImagem ASC LIMIT 0,1";
						$resultImagemF = $conn->query($sqlImagemF);
						$dadosImagemF = $resultImagemF->fetch_assoc();						
						
						$sqlImagem = "SELECT * FROM balnearioGaivotaImagens WHERE codBalnearioGaivota = ".$dadosBalnearioGaivota['codBalnearioGaivota']." and tipoBalnearioGaivotaImagem = 'I' ORDER BY capaBalnearioGaivotaImagem ASC, codBalnearioGaivotaImagem ASC LIMIT 0,1";
						$resultImagem = $conn->query($sqlImagem);
						$dadosImagem = $resultImagem->fetch_assoc();						
?>

								<tr class="tr">
									<td class="noventa"><a href='<?php echo $configUrlGer; ?>site/balnearioGaivota/alterar/<?php echo $dadosBalnearioGaivota['codBalnearioGaivota'] ?>/' title='Veja os detalhes do conheça <?php echo $dadosBalnearioGaivota['nomeBalnearioGaivota'] ?>'><?php echo $dadosBalnearioGaivota['nomeBalnearioGaivota'];?></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>site/balnearioGaivota/imagens/<?php echo $dadosBalnearioGaivota['codBalnearioGaivota'] ?>/' title='Deseja gerenciar imagens do imóvel <?php echo $dadosBalnearioGaivota['nomeBalnearioGaivota'] ?>?' ><img style="<?php echo $dadosImagem['codBalnearioGaivotaImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/balnearioGaivota/'.$dadosImagem['codBalnearioGaivota'].'-'.$dadosImagem['codBalnearioGaivotaImagem'].'-P.'.$dadosImagem['extBalnearioGaivotaImagem'];?>" height="50"/><img style="<?php echo $dadosImagem['codBalnearioGaivotaImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>site/balnearioGaivota/alterar/<?php echo $dadosBalnearioGaivota['codBalnearioGaivota'] ?>/' title='Deseja alterar o conheça <?php echo $dadosBalnearioGaivota['nomeBalnearioGaivota'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								</tr>
<?php
					}
?>
							</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "site/balnearioGaivota";
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
