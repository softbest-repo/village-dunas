<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "bancos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomePagamento = "SELECT codTipoPagamento, nomeTipoPagamento, statusTipoPagamento FROM tipoPagamento WHERE codTipoPagamento = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Tipos Pagamento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeTipoPagamento'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusTipoPagamento'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>financeiro/tipoPagamento/ativacao/<?php echo $dadosNomePagamento['codTipoPagamento'] ?>/' title='Deseja <?php echo $statusPergunta ?> o tipo Pagamento <?php echo $dadosNomePagamento['nomeTipoPagamento'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codTipoPagamento'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeTipoPagamento']) ?>");' title='Deseja excluir o tipo Pagamento <?php echo $dadosNomePagamento['nomeTipoPagamento'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o tipo Pagamento "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>financeiro/tipoPagamento/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a href="<?php echo $configUrl;?>financeiro/tipoPagamento/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){
																					
					$sql = "UPDATE tipoPagamento SET nomeTipoPagamento = '".$_POST['nome']."', tipoPagamento = '".$_POST['area-pagamento']."', tipoCategoria = '".$_POST['tipo-pagamento']."' WHERE codTipoPagamento = '".$url[6]."'";
					$result = $conn->query($sql); 
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/tipoPagamento/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar a tipo pagamento!</p>";
					}
				}else{
					$sql = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$url[6];
					$result = $conn->query($sql);
					$dadosTipoPagamento = $result->fetch_assoc();
					$_SESSION['nome'] = $dadosTipoPagamento['nomeTipoPagamento'];
					$_SESSION['area-pagamento'] = $dadosTipoPagamento['tipoPagamento'];
					$_SESSION['tipo-pagamento'] = $dadosTipoPagamento['tipoCategoria'];
					$_SESSION['status'] = $dadosTipoPagamento['statusTipoPagamento'];
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
								document.getElementById("area-pagamento").disabled = false;
								document.getElementById("tipo-pagamento").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						 </script>
						<form action="<?php echo $configUrlGer; ?>financeiro/tipoPagamento/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required class="campo" type="text" name="nome" style="width:375px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label>Área Pagamento: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="area-pagamento" name="area-pagamento" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:240px;" onChange="mudaTipo(this.value);">
									<option value="">Selecione</option>
									<option value="R" <?php echo $_SESSION['area-pagamento'] == 'R' ? '/SELECTED/' : '';?>>Contas a Receber</option>
									<option value="P" <?php echo $_SESSION['area-pagamento'] == 'P' ? '/SELECTED/' : '';?>>Contas a Pagar</option>
								</select>
							</p>
							
							<script type="text/javascript">
								function mudaTipo(area){
									if(area == "P"){
										document.getElementById("tipo-categoria").style.display="block";
										document.getElementById("tipo-pagamento").disabled=false;
									}else{
										document.getElementById("tipo-categoria").style.display="none";
										document.getElementById("tipo-pagamento").disabled=true;										
									}
								}
							</script>

							<p class="bloco-campo-float" id="tipo-categoria" style="<?php echo $_SESSION['area-pagamento'] == "R" ? 'display:none;' : 'display:block;';?>"><label>Tipo Categoria: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo-pagamento" name="tipo-pagamento" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required style="width:140px; ">
									<option value="">Selecione</option>
									<option value="F" <?php echo $_SESSION['tipo-pagamento'] == 'F' ? '/SELECTED/' : '';?>>Custo Fixo</option>
									<option value="V" <?php echo $_SESSION['tipo-pagamento'] == 'V' ? '/SELECTED/' : '';?>>Custo Variável</option>
								</select>
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
					$_SESSION['area-pagamento'] = "";
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
