<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "contratos";
			if(validaAcesso($conn, $area) == "ok"){

				$_SESSION['nome'] = "";
				
				$sqlNomeContrato = "SELECT * FROM contratos WHERE codContrato = '".$url[6]."'";
				$resultNomeContrato = $conn->query($sqlNomeContrato);
				$dadosNomeContrato = $resultNomeContrato->fetch_assoc();

				$sqlCliente = "SELECT * FROM clientes WHERE codCliente = '".$dadosNomeContrato['codCliente']."' ORDER BY codCliente DESC LIMIT 0,1";
				$resultCliente = $conn->query($sqlCliente);
				$dadosCliente = $resultCliente->fetch_assoc();				
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Comercial</p>
						<p class="flexa"></p>
						<p class="nome-lista">Contratos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Gerenciar Documentos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Cliente</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosCliente['nomeCliente'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
						<tr class="tr-interno">
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>comercial/contratos/alterar/<?php echo $dadosNomeContrato['codContrato'] ?>/' title='Deseja alterar o fornecedor <?php echo $dadosNomeContrato['nomeContrato'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
						</tr>
					</table>	
					<div class="botao-consultar"><a title="Consultar Contratos" href="<?php echo $configUrl;?>comercial/contratos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
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
								$sqlConsultaDelete = "SELECT * FROM contratosAnexos WHERE codContratoAnexo = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM contratosAnexos WHERE codContratoAnexo = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/contratosAnexo/".$dadosConsultaDelete['codContrato']."-".$dadosConsultaDelete['codContratoAnexo']."-O.".$dadosConsultaDelete['extContratoAnexo'])){
									unlink("f/contratosAnexo/".$dadosConsultaDelete['codContrato']."-".$dadosConsultaDelete['codContratoAnexo']."-O.".$dadosConsultaDelete['extContratoAnexo']);
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}
					
					if($exclusao == ""){
						
						$pastaDestino = "f/contratosAnexo/";
											
						$file = $_FILES['imagem'];

						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
																				
						$file_name = uniqid() . '.' . $ext;							
														
						$sqlContrato = "SELECT * FROM contratos WHERE codContrato = ".$url[6]." ORDER BY codContrato DESC LIMIT 0,1";
						$resultContrato = $conn->query($sqlContrato);
						$dadosContrato = $resultContrato->fetch_assoc();
														
						$sql =  "INSERT INTO contratosAnexos VALUES(0, ".$url[6].", '".$file['name']."', '".$ext."')";
						$result = $conn->query($sql);
																				
						if($result == 1){
							
							$sqlNome = "SELECT * FROM contratosAnexos ORDER BY codContratoAnexo DESC";
							$resultNome = $conn->query($sqlNome);
							$dadosNome = $resultNome->fetch_assoc();
							
							$codContratoAnexo = $dadosNome['codContratoAnexo'];
							$codContrato = $dadosNome['codContrato'];
							$nomeContratoAnexo = $dadosNome['nomeContratoAnexo'];
							
							move_uploaded_file($file['tmp_name'], $pastaDestino.$codContrato."-".$codContratoAnexo."-O.".$ext);
							
							chmod ($pastaDestino.$codContrato."-".$codContratoAnexo."-O.".$ext, 0755);
																													
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

						<form action="<?php echo $configUrlGer; ?>comercial/contratos/gerenciar-documentos/<?php echo $url[6]; ?>/1/" enctype="multipart/form-data" method="post">
							<p class="bloco-campo"><label>Anexo: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="file" name="imagem" size="15" value="" /></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT * FROM contratosAnexos WHERE codContrato = ".$url[6];
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = mysqli_num_rows($resultRegistro);
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM contratosAnexos WHERE codContrato = ".$url[6]." ORDER BY codContratoAnexo ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT * FROM contratosAnexos WHERE codContrato = ".$url[6]." ORDER BY codContratoAnexo ASC LIMIT ".$pgInicio.", 14";
				}

				$resultConsulta = $conn->query($sqlConsulta);
				$cont = 0;
				while($dadosAnexo = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;
?>
        
								<p class="imagem" style="width:200px; height:170px; overflow:hidden; margin-left:20px; margin-right:20px; margin-top:30px;"><a download="<?php echo $dadosAnexo['nomeContratoAnexo'];?>.<?php echo $dadosAnexo['extContratoAnexo'];?>" href="<?php echo $configUrlGer;?>f/contratosAnexo/<?php echo $dadosAnexo['codContrato'].'-'.$dadosAnexo['codContratoAnexo'].'-O.'.$dadosAnexo['extContratoAnexo'];?>"><img src="<?php echo $configUrlGer;?>f/i/documento.gif" alt="Anexo Contrato"/></a><br/><br/><strong><?php echo $dadosAnexo['nomeContratoAnexo'];?></strong><br/><br/>
								<input type="checkbox" name="excluir<?php echo $cont;?>" value="<?php echo $dadosAnexo['codContratoAnexo']; ?>" /> Excluir</p>
				
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
				$area = "comercial/contratos/gerenciar-documentos/".$url[6];
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
