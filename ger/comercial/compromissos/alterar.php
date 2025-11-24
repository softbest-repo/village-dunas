<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "compromissos";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlNomeCompromisso = "SELECT * FROM compromissos WHERE codCompromisso = '".$url[6]."'";
				$resultNomeCompromisso = $conn->query($sqlNomeCompromisso);
				$dadosNomeCompromisso = $resultNomeCompromisso->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Comercial</p>
						<p class="flexa"></p>
						<p class="nome-lista">Compromissos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeCompromisso['nomeCompromisso'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeCompromisso['statusCompromisso'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>comercial/compromissos/ativacao/<?php echo $dadosNomeCompromisso['codCompromisso'] ?>/' title='Deseja <?php echo $statusPergunta ?> o compromisso <?php echo $dadosNomeCompromisso['nomeCompromisso'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeCompromisso['codCompromisso'] ?>, "<?php echo htmlspecialchars($dadosNomeCompromisso['nomeCompromisso']) ?>");' title='Deseja excluir o compromisso <?php echo $dadosNomeCompromisso['nomeCompromisso'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o cliente "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>comercial/compromissos/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar compromissos" href="<?php echo $configUrl;?>comercial/compromissos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php		
				if($_POST['nome'] != ""){
				
					$sql = "UPDATE compromissos SET codTipoCompromisso = '".$_POST['tipo']."', codUsuario = '".$_POST['colaborador']."', nomeCompromisso = '".$_POST['nome']."', dataCompromisso = '".$_POST['data']."', horaCompromisso = '".$_POST['hora']."', statusCompromisso = 'T', descricaoCompromisso = '".$_POST['descricao']."' WHERE codCompromisso = '".$url[6]."'";
					$result = $conn->query($sql);

					if($result == 1){
						$_SESSION['nome'] = $_POST['nome'];
						$_SESSION['alteracao'] = "ok";
						 echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/compromissos/'>";
					}else{
						$erroData = "<p class='erro'>Problemas ao alterar compromisso!</p>";
					}		
				}else{
					$sqlCompromisso = "SELECT * FROM compromissos WHERE codCompromisso = '".$url[6]."'";
					$resultCompromisso = $conn->query($sqlCompromisso);
					$dadosCompromisso = $resultCompromisso->fetch_assoc();
				
					$_SESSION['nome'] = $dadosCompromisso['nomeCompromisso'];
					$_SESSION['colaborador'] = $dadosCompromisso['codUsuario'];
					$_SESSION['data'] = $dadosCompromisso['dataCompromisso'];
					$_SESSION['hora'] = $dadosCompromisso['horaCompromisso'];
					$_SESSION['descricao'] = $dadosCompromisso['descricaoCompromisso'];
					$_SESSION['tipo'] = $dadosCompromisso['codTipoCompromisso'];
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
								document.getElementById("tipo").disabled = false;
								document.getElementById("data").disabled = false;
								document.getElementById("hora").disabled = false;
								document.getElementById("descricao").disabled = false;
								document.getElementById("alterar").disabled = false;
							}	
							
							function enviar(){	
								document.altera.submit(); 
							}	
						</script>				
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>			
						<form name="altera" action="<?php echo $configUrlGer; ?>comercial/compromissos/alterar/<?php echo $url[6] ;?>/" method="post">
							<p class="bloco-campo-float"><label>Título: <span class="obrigatorio"> * </span></label>
							<input id="nome" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>  required class="campo" type="text" name="nome"style="width:270px;" value="<?php echo $_SESSION['nome']; ?>" /></p>	
								

							<p class="bloco-campo-float"><label>Usuário(s): <span class="obrigatorio"> * </span></label>
								<script>
									function enviaCol(cod){
										document.getElementById("colaborador").value = cod;
										
									}
								</script>
								<input id="colaborador" class="oculto" name="mostraCol" value="<?php echo $_SESSION['colaborador'];?>" />
<?php
				$sqlCompromisso = "SELECT * FROM compromissos WHERE codCompromisso = ".$url[6]." LIMIT 0,1";
				$resultCompromisso = $conn->query($sqlCompromisso);
				$dadosCompromisso = $resultCompromisso->fetch_assoc();
								
				if($dadosCompromisso['codUsuario'] == "0"){
					$enviado = "Todos";
				}else{
					$sqlCompromissoUsuario = "SELECT * FROM compromissosUsuario WHERE codCompromisso = ".$dadosCompromisso['codCompromisso']."";
					$resultCompromissoUsuario = $conn->query($sqlCompromissoUsuario);
					while($dadosCompromissoUsuario = $resultCompromissoUsuario->fetch_assoc()){
						
						$sqlUsuario = "SELECT nomeUsuario FROM usuarios WHERE codUsuario = ".$dadosCompromissoUsuario['codUsuario']." ORDER BY nomeUsuario ASC";
						$resultUsuario = $conn->query($sqlUsuario);
						$dadosUsuario = $resultUsuario->fetch_assoc();
						
						if($enviado == ""){	
							$enviado = $dadosUsuario['nomeUsuario'];	
						}else{
							$enviado .= ", ".$dadosUsuario['nomeUsuario'];
						}
					}						
				}	
?>					
								<?php echo $enviado;?>
							</p>
							
							<br class="clear" />

							<p class="bloco-campo-float"><label>Tipo Compromisso: <span class="obrigatorio"> * </span></label>
								<select id="tipo" class="campo" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="tipo" style="width:248px;">
									<option value="">Selecione um tipo de compromisso</option>
<?php
				$sqlTipo = "SELECT nomeTipoCompromisso, codTipoCompromisso FROM tipoCompromisso ORDER BY nomeTipoCompromisso ASC";
				$resultTipo = $conn->query($sqlTipo);
				while($dadosTipo = $resultTipo->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipo['codTipoCompromisso'] ;?>" <?php echo $_SESSION['tipo'] == $dadosTipo['codTipoCompromisso'] ? '/SELECTED/' : '';?>><?php echo $dadosTipo['nomeTipoCompromisso'];?></option>
<?php
				}
?>					
								</select>
								<br class="clear"/>
							</p>						
													
							<p class="bloco-campo-float"><label>Data: <span class="obrigatorio"> * </span></label>
							<input required id="data" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="date" name="data" style="width:135px; height:16px;" value="<?php echo $_SESSION['data']; ?>"/></p>

							<p class="bloco-campo-float"><label>Horário: <span class="obrigatorio"> * </span></label>
							<input required id="hora" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo" type="time" name="hora" style="width:140px; height:16px;" value="<?php echo $_SESSION['hora']; ?>"/></p>
							
							<br class="clear"/>	
							
							<p class="bloco-campo"><label>Descrição: <span class="obrigatorio"></span></label>
							<textarea id="descricao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="campo desabilita" name="descricao" style="width:566px; height:120px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="botao" type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['alteracao'] != "ok"){
					$_SESSION['nome'] = "";		
				}
			
				$_SESSION['escritorio'] = "";
				$_SESSION['colaborador'] = "";
				$_SESSION['cliente'] = "";
				$_SESSION['tipo'] = "";
				$_SESSION['hora'] = "";
				$_SESSION['data'] = "";
				$_SESSION['descricao'] = "";
				$_SESSION['status'] = "";
?>
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
