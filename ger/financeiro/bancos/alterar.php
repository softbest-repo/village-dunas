<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "bancos";
			if(validaAcesso($conn, $area) == "ok"){
				
				$sqlNomeBanco = "SELECT codBanco, nomeBanco, statusBanco FROM bancos WHERE codBanco = '".$url[6]."' LIMIT 0,1";
				$resultNomeBanco = $conn->query($sqlNomeBanco);
				$dadosNomeBanco = $resultNomeBanco->fetch_assoc();
?>
				<div id="localizacao-topo">					
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Contas</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeBanco['nomeBanco'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeBanco['statusBanco'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>financeiro/bancos/ativacao/<?php echo $dadosNomeBanco['codBanco'] ?>/' title='Deseja <?php echo $statusPergunta ?> a conta <?php echo $dadosNomeBanco['nomeBanco'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeBanco['codBanco'] ?>, "<?php echo htmlspecialchars($dadosNomeBanco['nomeBanco']) ?>");' title='Deseja excluir a conta <?php echo $dadosNomeBanco['nomeBanco'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir a conta "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>financeiro/bancos/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Contas" href="<?php echo $configUrl;?>financeiro/bancos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if($_POST['nome'] != ""){

					$sql = "UPDATE bancos SET nomeBanco = '".$_POST['nome']."' WHERE codBanco = '".$url[6]."'";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nomeAlt'] = $_POST['nome'];
						$_SESSION['alterar'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/bancos/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar Contas!</p>";
					}
				}else{
					$sql = "SELECT * FROM bancos WHERE codBanco = ".$url[6]." LIMIT 0,1";
					$result = $conn->query($sql);
					$dadosBanco = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosBanco['nomeBanco'];
					$_SESSION['codigo'] = $dadosBanco['codigoBanco'];
				
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
						<script>
							function habilitaCampo(){
								document.getElementById("nome").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script>							
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>					
						<form name="formBanco" action="<?php echo $configUrlGer; ?>financeiro/bancos/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required name="nome" style="width:310px;" value="<?php echo $_SESSION['nome']; ?>" /></p>		

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="alterar" title="Alterar" value="Alterar" onClick="verificaDados();"/><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['codigo'] = "";
					$_SESSION['status'] = "";
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
