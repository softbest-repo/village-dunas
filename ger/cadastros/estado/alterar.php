<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "estado";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlNomePagamento = "SELECT codEstado, nomeEstado, statusEstado FROM estado WHERE codEstado = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Estados</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeEstado'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusEstado'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/estado/ativacao/<?php echo $dadosNomePagamento['codEstado'] ?>/' title='Deseja <?php echo $statusPergunta ?> o estado <?php echo $dadosNomePagamento['nomeEstado'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codEstado'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeEstado']) ?>");' title='Deseja excluir o estado <?php echo $dadosNomePagamento['nomeEstado'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o estado "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/estado/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Estados" href="<?php echo $configUrl;?>cadastros/estado/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){
																					
					$sql = "UPDATE estado SET nomeEstado = '".$_POST['nome']."', siglaEstado = '".$_POST['sigla']."', codPais = '".$_POST['pais']."' WHERE codEstado = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						$_SESSION['pais'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/estado/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar o estado!</p>";
					}
				}else{
					$sql = "SELECT * FROM estado WHERE codEstado = ".$url[6];
					$result = $conn->query($sql);
					$dadosEstado = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosEstado['nomeEstado'];
					$_SESSION['sigla'] = $dadosEstado['siglaEstado'];
					$_SESSION['pais'] = $dadosEstado['codPais'];
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
								document.getElementById("pais").disabled = false;
								document.getElementById("sigla").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script>
 
						<form action="<?php echo $configUrlGer; ?>cadastros/estado/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" required type="text" name="nome" style="width:275px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo"><label>Sigla: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" id="sigla" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="sigla" style="width:275px;" value="<?php echo $_SESSION['sigla']; ?>" /></p>
						
							<p class="bloco-campo"><label>País: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="pais" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="pais" style="width:290px;" required>
									<option value="">Selecione</option>
<?php
				$sqlPais = "SELECT nomePais, codPais FROM pais WHERE statusPais = 'T' ORDER BY nomePais ASC";
				$resultPais = $conn->query($sqlPais);
				while($dadosPais = $resultPais->fetch_assoc()){
?>
									<option value="<?php echo $dadosPais['codPais'] ;?>" <?php echo $_SESSION['pais'] == $dadosPais['codPais'] ? '/SELECTED/' : '';?>><?php echo $dadosPais['nomePais'] ;?></option>
<?php
				}
?>					
								</select>
								<br class="clear"/>
							</p>
							
							<br class="clear"/>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['pais'] = "";
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
