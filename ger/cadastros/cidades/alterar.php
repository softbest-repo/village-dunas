<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "cidades";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codCidade, nomeCidade, statusCidade FROM cidades WHERE codCidade = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Cidade</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeCidade'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusCidade'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/cidades/ativacao/<?php echo $dadosNomePagamento['codCidade'] ?>/' title='Deseja <?php echo $statusPergunta ?> a cidade <?php echo $dadosNomePagamento['nomeCidade'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codCidade'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeCidade']) ?>");' title='Deseja excluir a cidade <?php echo $dadosNomePagamento['nomeCidade'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir a cidade "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/cidades/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Cidade" href="<?php echo $configUrl;?>cadastros/cidades/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlCidade = criaUrl($_POST['nome']);	
																										
					$sql = "UPDATE cidades SET nomeCidade = '".$_POST['nome']."', estadoCidade = '".$_POST['estado']."', urlCidade = '".$urlCidade."' WHERE codCidade = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						$_SESSION['estado'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/cidades/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar o cidades!</p>";
					}
				}else{
					$sql = "SELECT * FROM cidades WHERE codCidade = ".$url[6];
					$result = $conn->query($sql);
					$dadosCidade = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosCidade['nomeCidade'];
					$_SESSION['estado'] = $dadosCidade['estadoCidade'];
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
								document.getElementById("estado").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script>
 
						<form action="<?php echo $configUrlGer; ?>cadastros/cidades/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" required type="text" name="nome" style="width:275px;" value="<?php echo $_SESSION['nome']; ?>" /></p>
						
							<p class="bloco-campo-float"><label>UF: <span class="obrigatorio"> * </span></label>
							<input id="estado" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" required type="text" name="estado" style="width:100px;" value="<?php echo $_SESSION['estado']; ?>" /></p>

							<br class="clear"/>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['estado'] = "";
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
