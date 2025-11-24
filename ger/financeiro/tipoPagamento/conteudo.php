<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "bancos";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Tipo Pagamento <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Tipo Pagamento <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['data'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Tipo Pagamento <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['descricao'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Tipo Pagamento <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = ""; 
				}
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Tipos Pagamento</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
					<div id="formulario-filtro">
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
					 
						<form name="filtro" action="<?php echo $configUrl;?>financeiro/tipoPagamento/" method="post" />
							<div class="botao-novo" style="margin-left:0px;"><a href="<?php echo $configUrlGer;?>financeiro/<?php echo $_SESSION['voltarContasUrl'];?>/"><div class="esquerda-novo"></div><div class="conteudo-novo">Voltar <?php echo $_SESSION['voltarContasTitulo'];?></div><div class="direita-novo"></div></a></div>
							<div class="botao-novo" style="margin-left:0px;"><a onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Tipo Pagamento</div><div class="direita-novo"></div></a></div>
							<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar Cadastrar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>
							<br class="clear" />
						</form>
					</div>
					</div>
					
					<div id="cadastrar" style="display:<?php echo $url[5] == 1 ? 'block' : 'none';?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">
<?php
				if(isset($_POST['cadastrar'])){
					
					$sql = "INSERT INTO tipoPagamento VALUES(0, '".$_POST['area-pagamento']."', '".$_POST['nome']."', '".$_POST['tipo-pagamento']."', 'T')";
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['cadastro'] = "ok";
						$_SESSION['area-pagamento'] = "";
						$_SESSION['tipo-pagamento'] = "";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/tipoPagamento/'>";					
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar a tipo pagamento!</p>";
						$_SESSION['nome'] = "";
						$_SESSION['area-pagamento'] = "";
						$_SESSION['tipo-pagamento'] = "";
					}
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['area-pagamento'] = "";					
					$_SESSION['tipo-pagamento'] = "";					
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
						<form action="<?php echo $configUrlGer; ?>financeiro/tipoPagamento/" method="post">
							<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="nome" style="width:375px;" required value="<?php echo $_SESSION['nome']; ?>" /></p>

							<p class="bloco-campo-float"><label>Área Pagamento: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="area-pagamento" name="area-pagamento" style="width:240px;" onChange="mudaTipo(this.value);">
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

							<p class="bloco-campo-float" id="tipo-categoria" style="display:none;"><label>Tipo Categoria: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="tipo-pagamento" name="tipo-pagamento" disabled="disabled" required style="width:140px; ">
									<option value="">Selecione</option>
									<option value="F" <?php echo $_SESSION['tipo-pagamento'] == 'F' ? '/SELECTED/' : '';?>>Custo Fixo</option>
									<option value="V" <?php echo $_SESSION['tipo-pagamento'] == 'V' ? '/SELECTED/' : '';?>>Custo Variável</option>
								</select>
							</p>

							<br class="clear"/>
							 
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar TipoPagamento" value="Salvar" /><p class="direita-botao"></p></div></p>						
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
				
				$sqlConta = "SELECT count(codTipoPagamento) registros, nomeTipoPagamento FROM tipoPagamento WHERE codTipoPagamento != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeTipoPagamento'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq" >Nome</th>
								<th>Conta</th>
								<th>Tipo</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlTipoPagamento = "SELECT * FROM tipoPagamento ORDER BY statusTipoPagamento ASC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlTipoPagamento = "SELECT * FROM tipoPagamento ORDER BY statusTipoPagamento ASC LIMIT ".$paginaInicial.",30";
					}		

					$resultTipoPagamento = $conn->query($sqlTipoPagamento);
					while($dadosTipoPagamento = $resultTipoPagamento->fetch_assoc()){
						$mostrando++;
						
						if($dadosTipoPagamento['statusTipoPagamento'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}			
?>

							<tr class="tr">
								<td class="sessenta"><a href='<?php echo $configUrlGer; ?>financeiro/tipoPagamento/alterar/<?php echo $dadosTipoPagamento['codTipoPagamento'] ?>/' title='Veja os detalhes do tipo pagamento <?php echo $dadosTipoPagamento['nomeTipoPagamento'] ?>'><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></a></td>
								<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>financeiro/tipoPagamento/alterar/<?php echo $dadosTipoPagamento['codTipoPagamento'] ?>/' title='Veja os detalhes do tipo pagamento <?php echo $dadosTipoPagamento['nomeTipoPagamento'] ?>'><?php echo $dadosTipoPagamento['tipoPagamento'] == "R" ? 'Conta a Receber' : 'Conta a Pagar';?></a></td>
								<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>financeiro/tipoPagamento/alterar/<?php echo $dadosTipoPagamento['codTipoPagamento'] ?>/' title='Veja os detalhes do tipo pagamento <?php echo $dadosTipoPagamento['nomeTipoPagamento'] ?>'><?php echo $dadosTipoPagamento['tipoCategoria'] == "F" && $dadosTipoPagamento['tipoPagamento'] == "P" ? 'Custo Fixo' : '';?> <?php echo $dadosTipoPagamento['tipoCategoria'] == "V" && $dadosTipoPagamento['tipoPagamento'] == "P" ? 'Custo Variável' : '';?> <?php echo $dadosTipoPagamento['tipoPagamento'] == "R" ? '--' : '';?></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>financeiro/tipoPagamento/ativacao/<?php echo $dadosTipoPagamento['codTipoPagamento'] ?>/' title='Deseja <?php echo $statusPergunta ?> o tipo pagamento <?php echo $dadosTipoPagamento['nomeTipoPagamento'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>financeiro/tipoPagamento/alterar/<?php echo $dadosTipoPagamento['codTipoPagamento'] ?>/' title='Deseja alterar o tipo pagamento <?php echo $dadosTipoPagamento['nomeTipoPagamento'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosTipoPagamento['codTipoPagamento'] ?>, "<?php echo htmlspecialchars($dadosTipoPagamento['nomeTipoPagamento']) ?>");' title='Deseja excluir o tipo pagamento <?php echo $dadosTipoPagamento['nomeTipoPagamento'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
							</tr>
<?php
					}
?>
							<script>
								 function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir o a tipo pagamento "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>financeiro/tipoPagamento/excluir/'+cod+'/';
									}
								  }
							 </script>	 
						</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "financeiro/tipoPagamento";
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
