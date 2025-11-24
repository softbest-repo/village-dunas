<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "bancos";
			if(validaAcesso($conn, $area) == "ok"){
		
				if($_SESSION['cadastrar'] == "ok"){
					$erroConteudo = "<p class='erro'>Conta <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastrar'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['alterar'] == "ok"){
					$erroConteudo = "<p class='erro'>Conta <strong>".$_SESSION['nomeAlt']."</strong> alterado com sucesso!</p>";
					$_SESSION['alterar'] = "";
					$_SESSION['nomeAlt'] = "";
					$_SESSION['data'] = "";
					$_SESSION['descricao'] = "";
				}else	
				if($_SESSION['ativar'] == "ok"){
					$erroConteudo = "<p class='erro'>Conta <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativar'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['excluir'] == "ok"){
					$erroConteudo = "<p class='erro'>Conta <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['excluir'] = "";
					$_SESSION['nome'] = "";
				}		
?>
				<div id="filtro">			
					<div id="localizacao-filtro">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Contas</p>
						<br class="clear" />
					</div>
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
					<div class="demoTarget">
						<div id="formulario-filtro">
							<div class="botao-novo" style="margin-left:0px;"><a onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Nova Conta</div><div class="direita-novo"></div></a></div>
							<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
							<br class="clear" />
						</div>
					</div>					
					<div id="cadastrar" style="display:none; margin-top:30px; margin-left:30px;">
<?php
				if($_POST['nome'] != ""){

					$sql = "INSERT INTO bancos VALUES(0, '".$_POST['nome']."', 'T')";
					$result = $conn->query($sql);
					
					if($result == 1){
						if($_POST['tipoEnvio'] == "salvar"){
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['cadastrar'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/bancos/'>";
						}else{
							$erroData = "<p class='erro'>Conta <strong>".$_POST['nome']."</strong> cadastrado com sucesso!</p>";
						}
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar conta!</p>";
					}		
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
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<form name="formBanco" action="<?php echo $configUrlGer; ?>financeiro/bancos/" method="post">
							<input type="hidden" id="tipoEnvio" name="tipoEnvio" value="" />
							
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="nome" name="nome" required style="width:310px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>			
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
				
				$sqlConta = "SELECT count(codBanco) registros, nomeBanco FROM bancos WHERE codBanco != '' ".$filtraBanco;
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeBanco'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Conta</th>
								<th>Total</th>
								<th>Alterar</th>
								<th class="canto-dir">Status</th>
							</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlBanco = "SELECT * FROM bancos ORDER BY statusBanco ASC,codBanco DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlBanco = "SELECT * FROM bancos ORDER BY statusBanco ASC,codBanco DESC LIMIT ".$paginaInicial.",30";
					}		
	

					$resultBanco = $conn->query($sqlBanco);
					while($dadosBanco = $resultBanco->fetch_assoc()){
						$mostrando++;
						
						if($dadosBanco['statusBanco'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}	

						$sqlSomaRB = "SELECT SUM(CP.valorContaParcial) total FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE CP.contaPagamentoConta = ".$dadosBanco['codBanco']." and C.areaPagamentoConta = 'R'";
						$resultSomaRB = $conn->query($sqlSomaRB);
						$dadosSomaRB = $resultSomaRB->fetch_assoc();
							
						$sqlSomaPB = "SELECT SUM(CP.valorContaParcial) total FROM contasParcial CP inner join contas C on CP.codConta = C.codConta WHERE CP.contaPagamentoConta = ".$dadosBanco['codBanco']." and C.areaPagamentoConta = 'P'";
						$resultSomaPB = $conn->query($sqlSomaPB);
						$dadosSomaPB = $resultSomaPB->fetch_assoc();
							
						$saldoAtualB = $dadosSomaRB['total'] - $dadosSomaPB['total'];	

						if($saldoAtualB <= 0){
							$corB = "color:#FF0000;";
						}else{
							$corB = "color:#030AB0;";
						}				
?>
							<tr class="tr">
								<td class="quarenta" style="text-align:center;"><a style="font-size:22px; <?php echo $corB;?>" href='<?php echo $configUrl; ?>financeiro/bancos/detalhes/<?php echo $dadosBanco['codBanco'] ?>/' title='Deseja ver os detalhes da conta <?php echo $dadosBanco['nomeBanco'] ?>?'><?php echo $dadosBanco['nomeBanco'];?></a></td>
								<td class="quarenta" style="text-align:center;"><a style="font-size:22px; <?php echo $corB;?>" href='<?php echo $configUrl; ?>financeiro/bancos/detalhes/<?php echo $dadosBanco['codBanco'] ?>/' title='Deseja ver os detalhes da conta <?php echo $dadosBanco['nomeBanco'] ?>?'>R$ <?php echo number_format($saldoAtualB,2);?></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>financeiro/bancos/alterar/<?php echo $dadosBanco['codBanco'] ?>/' title='Deseja alterar a conta <?php echo $dadosBanco['nomeBanco'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>financeiro/bancos/ativacao/<?php echo $dadosBanco['codBanco'] ?>/' title='Deseja <?php echo $statusPergunta ?> a conta <?php echo $dadosBanco['nomeBanco'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
							</tr>
<?php
					}
?>
							<script>
								function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir a conta "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>financeiro/bancos/excluir/'+cod+'/';
									}
								}
							</script>
						</table>	
<?php
				}

				$regPorPagina = 30;
				$area = "financeiro/bancos";
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
