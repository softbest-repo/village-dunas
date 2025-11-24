<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "bairros";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codBairro, nomeBairro, statusBairro FROM bairros WHERE codBairro = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Bairros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeBairro'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusBairro'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/bairros/ativacao/<?php echo $dadosNomePagamento['codBairro'] ?>/' title='Deseja <?php echo $statusPergunta ?> o bairro <?php echo $dadosNomePagamento['nomeBairro'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codBairro'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeBairro']) ?>");' title='Deseja excluir o bairro <?php echo $dadosNomePagamento['nomeBairro'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o bairro "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>cadastros/bairros/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Bairros" href="<?php echo $configUrl;?>cadastros/bairros/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){

					include ('f/conf/criaUrl.php');
					$urlBairro = criaUrl($_POST['nome']);

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
																										
					$sql = "UPDATE bairros SET codCidade = '".$_POST['cidade']."', nomeBairro = '".$_POST['nome']."', descricaoBairro = '".str_replace("'", "&#39;", $descricao)."', urlBairro = '".$urlBairro."' WHERE codBairro = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						$_SESSION['cidade'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/bairros/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar o bairros!</p>";
					}
				}else{
					$sql = "SELECT * FROM bairros WHERE codBairro = ".$url[6];
					$result = $conn->query($sql);
					$dadosBairro = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosBairro['nomeBairro'];
					$_SESSION['cidade'] = $dadosBairro['codCidade'];
					$_SESSION['descricao'] = $dadosBairro['descricaoBairro'];
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
								document.getElementById("cidade").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script>
 
						<form action="<?php echo $configUrlGer; ?>cadastros/bairros/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" required type="text" name="nome" style="width:560px;" value="<?php echo $_SESSION['nome']; ?>" /></p>
						
							<p class="bloco-campo-float"><label>Cidade: <span class="obrigatorio"> </span></label>
								<select class="campo" id="cidade" name="cidade" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required style="width:315px; padding:6px;">
									<option value="">Selecione</option>
<?php
				$sqlCidades = "SELECT * FROM cidades WHERE statusCidade = 'T' ORDER BY nomeCidade ASC";
				$resultCidades = $conn->query($sqlCidades);
				while($dadosCidades = $resultCidades->fetch_assoc()){
?>
										<option value="<?php echo $dadosCidades['codCidade'] ;?>" <?php echo $_SESSION['cidade'] == $dadosCidades['codCidade'] ? '/SELECTED/' : '';?>><?php echo $dadosCidades['nomeCidade'] ;?></option>
<?php
				}
?>					
								</select>
							</p>

							<br class="clear"/>

							<p class="bloco-campo" style="width:900px;"><label>Descrição:<span class="obrigatorio"> </span></label>
							<textarea class="campo textarea" id="descricao" name="descricao" type="text" style="width:400px; height:600px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['cidade'] = "";
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
