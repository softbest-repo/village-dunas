<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "imoveisS";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlNomeDespesaImovel = "SELECT codDespesaImovel, nomeDespesaImovel, statusDespesaImovel FROM despesasImovel WHERE codDespesaImovel = '".$url[8]."' LIMIT 0,1";
				$resultNomeDespesaImovel = $conn->query($sqlNomeDespesaImovel);
				$dadosNomeDespesaImovel = $resultNomeDespesaImovel->fetch_assoc();

				$sqlNomePagamento = "SELECT codImovel, nomeImovel, statusImovel FROM imoveis WHERE codImovel = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();				
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Imóveis</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeImovel'];?></p>
						<p class="flexa"></p>
						<p class="nome-lista">Despesas do Imóvel</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeDespesaImovel['nomeDespesaImovel'] ;?></p>
						<br class="clear" />
					</div>					
					<table class="tabela-interno">
<?php
				if($dadosNomeDespesaImovel['statusDespesaImovel'] == "T"){
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
						<script>
							function confirmaEstornar(cod){
								var resultado = confirm("Você deseja estornar essa despesa? Fazendo isso todos os movimentos cadastross da despesa serão apagados!");
								if(resultado == true){
									location.href="<?php echo $configUrl;?>cadastros/imoveis/despesasImovel/ativacao/<?php echo $url[6];?>/";
								}
							}
							
							function confirmaFinalizar(cod){
								var resultado = confirm("Você deseja finalizar essa despesa?");
								if(resultado == true){
									location.href="<?php echo $configUrl;?>cadastros/imoveis/despesasImovel/finalizar/<?php echo $url[6];?>/";
								}
							}
							
						</script>
<?php
				if($dadosNomeDespesaImovel['statusDespesaImovel'] == "T"){
?>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeDespesaImovel['codDespesaImovel'] ?>, "<?php echo htmlspecialchars($dadosNomeDespesaImovel['nomeDespesaImovel']) ?>");' title='Deseja excluir a DespesaImovel <?php echo $dadosNomeDespesaImovel['nomeDespesaImovel'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
<?php
				}else{
?>
							<td class="botoes-interno"><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></td>
							<td class="botoes-interno"><a style="cursor:pointer;" title="Estornar despesa" onClick="confirmaEstornar(<?php echo $url[8];?>);" ><img src="<?php echo $configUrl;?>f/i/icone-estorno.gif" alt="Icone Estornar" /></a></td>					
<?php
				}
?>						

						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir a despesa imóvel "+nome+"?")){
									location.href='<?php echo $configUrlGer; ?>cadastros/imoveis/despesasImovel/<?php echo $url[7];?>/excluir/'+cod+'/';
								}
							}
							
							function confirmaEstornar(cod){
								var resultado = confirm("Você deseja estornar essa despesa? Fazendo isso todos os movimentos cadastross da despesa serão apagados!");
								if(resultado == true){
									location.href="<?php echo $configUrl;?>cadastros/imoveis/despesasImovel/ativacao/<?php echo $url[7];?>/<?php echo $url[8];?>/";
								}
							
							}	
						</script>
					</table>	
					<div style="float:left;" class="botao-consultar"><a title="Consultar Despesas Imovel" href="<?php echo $configUrl;?>cadastros/imoveis/alterar/<?php echo $url[7];?>/#despesas"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
					<br class="clear" />
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if($_POST['nome'] != ""){
					
					$sqlPegaFornecedor = "SELECT * FROM fornecedores WHERE statusFornecedor = 'T' and nomeFornecedor = '".$_POST['fornecedores']."' ORDER BY codFornecedor DESC LIMIT 0,1";
					$resultPegaFornecedor = $conn->query($sqlPegaFornecedor);
					$dadosPegaFornecedor = $resultPegaFornecedor->fetch_assoc();
					
					if($dadosPegaFornecedor['codFornecedor'] != ""){
					
						$sql = "UPDATE despesasImovel SET dataDespesaImovel = '".data($_POST['data'])."', codTipoPagamento = '".$_POST['tipo']."', codFornecedor = ".$dadosPegaFornecedor['codFornecedor'].", nomeDespesaImovel = '".$_POST['nome']."', valorDespesaImovel = '".$_POST['valor']."' WHERE codDespesaImovel = '".$url[8]."'";
						$result = $conn->query($sql); 
						
						if($result == 1){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['alteracao'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/imoveis/alterar/".$url[7]."/#despesas'>";
						}else{
							$erroData = "<p class='erro'>Problemas ao alterar Despesa Imovel!</p>";
						}

					}else{
						$erroData = "<p class='erro'>O Fornecedor <strong>".$_POST['fornecedores']."</strong> não foi encontrado.</p>";
						$_SESSION['fornecedores'] = "";
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['tipo'] = $_POST['tipo'];
						$_SESSION['valor'] = $_POST['valor'];						
					}
				}else{
					$sql = "SELECT * FROM despesasImovel WHERE codDespesaImovel = ".$url[8];
					$result = $conn->query($sql);
					$dadosDespesaImovel = $result->fetch_assoc();
				
					$_SESSION['nome'] = $dadosDespesaImovel['nomeDespesaImovel'];
					$_SESSION['tipo'] = $dadosDespesaImovel['codTipoPagamento'];
					$_SESSION['data'] = data($dadosDespesaImovel['dataDespesaImovel']);
					$_SESSION['hora'] = $dadosDespesaImovel['horaDespesaImovel'];
					$_SESSION['valor'] = $dadosDespesaImovel['valorDespesaImovel'];
					$_SESSION['status'] = $dadosDespesaImovel['statusDespesaImovel'];

					$sqlFornecedor = "SELECT nomeFornecedor FROM fornecedores WHERE codFornecedor = ".$dadosDespesaImovel['codFornecedor']." LIMIT 0,1";
					$resultFornecedor = $conn->query($sqlFornecedor);
					$dadosFornecedor = $resultFornecedor->fetch_assoc();
					
					$_SESSION['fornecedores'] = $dadosFornecedor['nomeFornecedor'];
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
					
<?php
				if($dadosNomeDespesaImovel['statusDespesaImovel'] == "T"){
?>
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
<?php
				}
?>
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<script>
							function habilitaCampo(){
								document.getElementById("nome").disabled = false;
								document.getElementById("data").disabled = false;
								document.getElementById("busca_autocomplete_softbest_fornecedores_c").disabled = false;
								document.getElementById("tipo").disabled = false;
								document.getElementById("valor").disabled = false;
								document.getElementById("alterar").disabled = false;
							}
						</script>
						<form name="formDespesaImovel" action="<?php echo $configUrlGer; ?>cadastros/imoveis/despesasImovel/alterar/<?php echo $url[7] ;?>/<?php echo $url[8] ;?>/" method="post">
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="text" name="nome" style="width:390px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label>Data: <span class="obrigatorio"> * </span></label>
							<input id="data" class="campo" type="text" name="data" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:138px;" value="<?php echo $_SESSION['data']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data)"/></p>

							<br class="clear"/>

							<div id="auto_complete_softbest" style="width:236px; float:left; margin-bottom:15px;">
								<p class="bloco-campo" style="margin-bottom:0px;"><label>Fornecedor: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" name="fornecedores" required style="width:220px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $_SESSION['fornecedores']; ?>" onClick="auto_complete(this.value, 'fornecedores_c', event);" onKeyUp="auto_complete(this.value, 'fornecedores_c', event);" onBlur="fechaAutoComplete('fornecedores_c');" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest_fornecedores_c" /></p>
								
								<div id="exibe_busca_autocomplete_softbest_fornecedores_c" class="auto_complete_softbest" style="width:234px; display:none;">

								</div>
							</div>	
								

							<p class="bloco-campo-float"><label>Tipo Pagamento: <span class="obrigatorio"> * </span></label>
								<select id="tipo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" style="padding:6px; width:160px;" name="tipo" >
									<option value="">Selecione</option>
<?php
				$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE statusTipoPagamento = 'T' and tipoPagamento = 'P' ORDER BY nomeTipoPagamento ASC";
				$resultTipoPagamento = $conn->query($sqlTipoPagamento);
				while($dadosTipoPagamento = $resultTipoPagamento->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoPagamento['codTipoPagamento'];?>" <?php echo $dadosTipoPagamento['codTipoPagamento'] == $_SESSION['tipo'] ? '/SELECTED/' : '';?> ><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></option>
<?php
				}
?>
								</select>

							</p>	

							<p class="bloco-campo-float"><label>Valor: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="valor" id="valor"style="width:138px;" value="<?php echo $_SESSION['valor']; ?>" onKeyDown="Mascara(this,Valor);" onKeyPress="Mascara(this,Valor);" onKeyUp="Mascara(this,Valor)"/></p>
							<br class="clear" />
							
<?php
				if($dadosNomeDespesaImovel['statusDespesaImovel'] == "T"){
?>
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" onClick="enviar();" /><p class="direita-botao"></p></div></p>						
<?php
				}
?>
							<br class="clear"/>
						</form>
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
