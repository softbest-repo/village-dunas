<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "tipoImovel";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codTipoImovel, nomeTipoImovel, statusTipoImovel FROM tipoImovel WHERE codTipoImovel = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Tipo Imóvel</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeTipoImovel'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusTipoImovel'] == "T"){
					$status = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$status = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}		
?>	
						<tr class="tr-interno">
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/tipoImovel/ativacao/<?php echo $dadosNomePagamento['codTipoImovel'] ?>/' title='Deseja <?php echo $statusPergunta ?> o tipo imóvel <?php echo $dadosNomePagamento['nomeTipoImovel'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codTipoImovel'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeTipoImovel']) ?>");' title='Deseja excluir o tipo imóvel <?php echo $dadosNomePagamento['nomeTipoImovel'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o tipo imóvel "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/tipoImovel/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Tipo Imóvel" href="<?php echo $configUrl;?>cadastros/tipoImovel/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){
					
					include ('f/conf/criaUrl.php');
					$urlTipoImovel = criaUrl($_POST['nome']);	
											
					$sql = "UPDATE tipoImovel SET nomeTipoImovel = '".$_POST['nome']."', siglaTipoImovel = '".$_POST['sigla']."', urlTipoImovel = '".$urlTipoImovel."' WHERE codTipoImovel = '".$url[6]."'";
					echo $sql;
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/tipoImovel/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar a tipo imóvel!</p>";
					}
				
				}else{
					$sql = "SELECT * FROM tipoImovel WHERE codTipoImovel = ".$url[6];
					$result = $conn->query($sql);
					$dadosTipoImovel = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosTipoImovel['nomeTipoImovel'];
					$_SESSION['sigla'] = $dadosTipoImovel['siglaTipoImovel'];
					$_SESSION['status'] = $dadosTipoImovel['statusTipoImovel'];
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
								document.getElementById("sigla").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						 </script>
						<form action="<?php echo $configUrlGer; ?>cadastros/tipoImovel/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:310px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo"><label>Sigla: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="sigla" name="sigla" style="width:80px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required value="<?php echo $_SESSION['sigla']; ?>" /></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
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
