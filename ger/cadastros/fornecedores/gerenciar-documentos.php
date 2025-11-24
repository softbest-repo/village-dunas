<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "fornecedores";
			if(validaAcesso($conn, $area) == "ok"){

				$_SESSION['nome'] = "";
				$sqlNomeFornecedor = "SELECT * FROM fornecedores WHERE codFornecedor = '".$url[6]."'";
				$resultNomeFornecedor = $conn->query($sqlNomeFornecedor);
				$dadosNomeFornecedor = $resultNomeFornecedor->fetch_assoc();
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Fornecedores</p>
						<p class="flexa"></p>
						<p class="nome-lista">Gerenciar Documentos</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeFornecedor['nomeFornecedor'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeFornecedor['statusFornecedor'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/ativacao/<?php echo $dadosNomeFornecedor['codFornecedor'] ?>/' title='Deseja <?php echo $statusPergunta ?> o fornecedor <?php echo $dadosNomeFornecedor['nomeFornecedor'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/alterar/<?php echo $dadosNomeFornecedor['codFornecedor'] ?>/' title='Deseja alterar o fornecedor <?php echo $dadosNomeFornecedor['nomeFornecedor'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
						</tr>
					</table>	
					<div class="botao-consultar"><a title="Consultar Fornecedores" href="<?php echo $configUrl;?>cadastros/fornecedores/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['cadastrar'])){
					
					$exclusao = "";
					
					if($_POST['cont'] >  0){
												
						for($i=0; $i<=$_POST['cont']; $i++){
							$contadorDel = "excluir".$i;
							if(isset($_POST[$contadorDel])){
								$exclusao = "ok";
								$sqlConsultaDelete = "SELECT * FROM fornecedoresAnexos WHERE codFornecedorAnexo = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM fornecedoresAnexos WHERE codFornecedorAnexo = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/fornecedoresAnexo/".$dadosConsultaDelete['codFornecedor']."-".$dadosConsultaDelete['codFornecedorAnexo']."-O.".$dadosConsultaDelete['extFornecedorAnexo'])){
									unlink("f/fornecedoresAnexo/".$dadosConsultaDelete['codFornecedor']."-".$dadosConsultaDelete['codFornecedorAnexo']."-O.".$dadosConsultaDelete['extFornecedorAnexo']);
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}
					
					if($exclusao == ""){
						
						$pastaDestino = "f/fornecedoresAnexo/";
											
						$file = $_FILES['imagem'];

						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
																				
						$file_name = uniqid() . '.' . $ext;							
														
						$sqlFornecedor = "SELECT * FROM fornecedores WHERE codFornecedor = ".$url[6]." ORDER BY codFornecedor DESC LIMIT 0,1";
						$resultFornecedor = $conn->query($sqlFornecedor);
						$dadosFornecedor = $resultFornecedor->fetch_assoc();
														
						$sql =  "INSERT INTO fornecedoresAnexos VALUES(0, ".$url[6].", '".$file['name']."', '".$ext."')";
						$result = $conn->query($sql);
																				
						if($result == 1){
							
							$sqlNome = "SELECT * FROM fornecedoresAnexos ORDER BY codFornecedorAnexo DESC";
							$resultNome = $conn->query($sqlNome);
							$dadosNome = $resultNome->fetch_assoc();
							
							$codFornecedorAnexo = $dadosNome['codFornecedorAnexo'];
							$codFornecedor = $dadosNome['codFornecedor'];
							$nomeFornecedorAnexo = $dadosNome['nomeFornecedorAnexo'];
							
							move_uploaded_file($file['tmp_name'], $pastaDestino.$codFornecedor."-".$codFornecedorAnexo."-O.".$ext);
							
							chmod ($pastaDestino.$codFornecedor."-".$codFornecedorAnexo."-O.".$ext, 0755);
																													
							$erroData = "<p class='erro'>Documento cadastrado com sucesso!</p>";														
						
						}else{
							$erroData = "<p class='erro'>Problemas ao cadastrar documento!</p>";
						}

					}else{
						$erroData = "<p class='erro'>Documento excluído com sucesso!</p>";
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

						<form action="<?php echo $configUrlGer; ?>cadastros/fornecedores/gerenciar-documentos/<?php echo $url[6]; ?>/1/" enctype="multipart/form-data" method="post">
							<p class="bloco-campo"><label>Anexo: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="file" name="imagem" size="15" value="" /></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT * FROM fornecedoresAnexos WHERE codFornecedor = ".$url[6];
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = mysqli_num_rows($resultRegistro);
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM fornecedoresAnexos WHERE codFornecedor = ".$url[6]." ORDER BY codFornecedorAnexo ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT * FROM fornecedoresAnexos WHERE codFornecedor = ".$url[6]." ORDER BY codFornecedorAnexo ASC LIMIT ".$pgInicio.", 14";
				}

				$resultConsulta = $conn->query($sqlConsulta);
				$cont = 0;
				while($dadosAnexo = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;
?>
        
								<p class="imagem" style="width:200px; height:170px; overflow:hidden; margin-left:20px; margin-right:20px; margin-top:30px;"><a download="<?php echo $dadosAnexo['nomeFornecedorAnexo'];?>.<?php echo $dadosAnexo['extFornecedorAnexo'];?>" href="<?php echo $configUrlGer;?>f/fornecedoresAnexo/<?php echo $dadosAnexo['codFornecedor'].'-'.$dadosAnexo['codFornecedorAnexo'].'-O.'.$dadosAnexo['extFornecedorAnexo'];?>"><img src="<?php echo $configUrlGer;?>f/i/documento.gif" alt="Anexo Fornecedor"/></a><br/><br/><strong><?php echo $dadosAnexo['nomeFornecedorAnexo'];?></strong><br/><br/>
								<input type="checkbox" name="excluir<?php echo $cont;?>" value="<?php echo $dadosAnexo['codFornecedorAnexo']; ?>" /> Excluir</p>
				
<?php
					$cont = $cont + 1;
				}
?>
								<input type="hidden" name="cont" value="<?php echo $cont; ?>" />
							</div>
						</form>
					</div>
					<br class="clear" />
					<br/>
<?php
				if($erro == "ok"){
					$_SESSION['erroDados'] = ""; 
					
					
				}
				
				$regPorPag = 14;
				$area = "cadastros/fornecedores/gerenciar-documentos/".$url[6];
				include('f/conf/paginacao-imagens.php');
?>	
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
