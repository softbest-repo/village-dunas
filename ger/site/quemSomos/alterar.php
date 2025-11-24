<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "quemSomos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codQuemSomos, nomeQuemSomos, statusQuemSomos FROM quemSomos WHERE codQuemSomos = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Site</p>
						<p class="flexa"></p>
						<p class="nome-lista">A Imobiliária</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo strip_tags($dadosNomePagamento['nomeQuemSomos']) ;?></p>
						<br class="clear" />
					</div>
					<div class="botao-consultar"><a title="Consultar A Imobiliária" href="<?php echo $configUrl;?>site/quemSomos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlQuemSomos = criaUrl($_POST['nome']);
																	
					$descricao = str_replace("../../../../", $configUrlGer, $_POST['descricao']);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);
					$descricao = str_replace("../../../../", $configUrlGer, $descricao);

					$sql = "UPDATE quemSomos SET nomeQuemSomos = '".$_POST['nome']."', descricaoCQuemSomos = '".$_POST['descricaoC']."', descricaoQuemSomos = '".str_replace("'", "&#39;", $descricao)."', urlQuemSomos = '".$urlQuemSomos."' WHERE codQuemSomos = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = strip_tags($_POST['nome']);
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."site/quemSomos/'>";
					}else{
						$erroData = "<p class='erro'>Problemas o alterar a imobiliária!</p>";
					}
				}else{
					$sql = "SELECT * FROM quemSomos WHERE codQuemSomos = ".$url[6];
					$result = $conn->query($sql);
					$dadosQuemSomos = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosQuemSomos['nomeQuemSomos'];
					$_SESSION['descricaoC'] = $dadosQuemSomos['descricaoCQuemSomos'];
					$_SESSION['descricao'] = $dadosQuemSomos['descricaoQuemSomos'];
					$_SESSION['status'] = $dadosQuemSomos['statusQuemSomos'];
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
					
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<script>
							function habilitaCampo(){
								document.getElementById("nome").disabled = false;
<?php
				if($url[6] == 1){				
?>
								document.getElementById("descricaoC").disabled = false;
<?php
				}
?>
								document.getElementById("alterar").disabled = false;
							}
						</script> 
						<form action="<?php echo $configUrlGer; ?>site/quemSomos/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:1042px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

<?php
				if($url[6] == 1){				
?>
							<p class="bloco-campo"><label>Descrição Capa:<span class="obrigatorio"> </span></label>
							<textarea class="campo" id="descricaoC" name="descricaoC" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="text" style="width:1042px; height:200px;" ><?php echo $_SESSION['descricaoC']; ?></textarea></p>
<?php
				}
				
				if($url[6] != 2){				
?>
							<p class="bloco-campo" style="width:1055px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:600px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>
<?php
				}
?>
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['descricaoC'] = "";
					$_SESSION['descricao'] = "";
				}

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
