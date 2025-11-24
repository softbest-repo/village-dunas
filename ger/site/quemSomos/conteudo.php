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
						<p class="nome-lista">A Imobiliária</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
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
