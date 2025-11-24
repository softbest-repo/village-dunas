<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "clientes";
			if(validaAcesso($conn, $area) == "ok"){

				$_SESSION['nome'] = "";
				$sqlNomeCliente = "SELECT * FROM clientes WHERE codCliente = '".$url[6]."'".$filtraUsuario."";
				$resultNomeCliente = $conn->query($sqlNomeCliente);
				$dadosNomeCliente = $resultNomeCliente->fetch_assoc();

				if($dadosNomeCliente['codUsuario'] == ""){
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/clientes/'>";					
				}
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Clientes</p>
						<p class="flexa"></p>
						<p class="nome-lista">Foto</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeCliente['nomeCliente'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeCliente['statusCliente'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/clientes/ativacao/<?php echo $dadosNomeCliente['codCliente'] ?>/' title='Deseja <?php echo $statusPergunta ?> o cliente <?php echo $dadosNomeCliente['nomeCliente'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/clientes/alterar/<?php echo $dadosNomeCliente['codCliente'] ?>/' title='Deseja alterar o cliente <?php echo $dadosNomeCliente['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
						</tr>
					</table>	
					<div class="botao-consultar"><a title="Consultar Clientes" href="<?php echo $configUrl;?>cadastros/clientes/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
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
								$sqlConsultaDelete = "SELECT * FROM clientesImagens WHERE codClienteImagem = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM clientesImagens WHERE codClienteImagem = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/clientes/".$dadosConsultaDelete['codCliente']."-".$dadosConsultaDelete['codClienteImagem']."-O.".$dadosConsultaDelete['extClienteImagem'])){
									unlink("f/clientes/".$dadosConsultaDelete['codCliente']."-".$dadosConsultaDelete['codClienteImagem']."-O.".$dadosConsultaDelete['extClienteImagem']);
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}
					
					if($exclusao == ""){
						
						$pastaDestino = "f/clientes/";
											
						$file = $_FILES['imagem'];

						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
													
						if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])){	
							
							$file_name = uniqid() . '.' . $ext;							
															
							$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$url[6]." ORDER BY codCliente DESC LIMIT 0,1";
							$resultCliente = $conn->query($sqlCliente);
							$dadosCliente = $resultCliente->fetch_assoc();
															
							$sql =  "INSERT INTO clientesImagens VALUES(0, ".$url[6].", '".$ext."')";
							$result = $conn->query($sql);
																				
							if($result == 1){
								
								$sqlNome = "SELECT * FROM clientesImagens ORDER BY codClienteImagem DESC";
								$resultNome = $conn->query($sqlNome);
								$dadosNome = $resultNome->fetch_assoc();
								
								$codClienteImagem = $dadosNome['codClienteImagem'];
								$codCliente = $dadosNome['codCliente'];
								$nomeClienteImagem = $dadosNome['nomeClienteImagem'];
								
								move_uploaded_file($file['tmp_name'], $pastaDestino.$codCliente."-".$codClienteImagem."-O.".$ext);
								
								chmod ($pastaDestino.$codCliente."-".$codClienteImagem."-O.".$ext, 0755);
				
								$erroData = "<p class='erro'>Imagem cadastrada com sucesso!</p>";														
						
							}else{
								$erroData = "<p class='erro'>Problemas ao cadastrar imagem!</p>";
							}
									
						}else{
							$erroData = "<p class='erro'>Extenção não permitida ou imagem não selecionada!</p>";
						}				
					}else{
						$erroData = "<p class='erro'>Imagem excluída com sucesso!</p>";
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

						<form action="<?php echo $configUrlGer; ?>cadastros/clientes/foto/<?php echo $url[6]; ?>/1/" enctype="multipart/form-data" method="post">
							<p class="bloco-campo"><label>Imagem: <span class="aviso"> PNG, JPG </span><span class="aviso">800 X 800</span><span class="obrigatorio"> * </span></label>
							<input class="campo" type="file" name="imagem" size="15" value="" /></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT count(codClienteImagem) registros FROM clientesImagens WHERE codCliente = ".$url[6];
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = $dadosRegistro['registros'];
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT codClienteImagem, codCliente, extClienteImagem FROM clientesImagens WHERE codCliente = ".$url[6]." ORDER BY codClienteImagem ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT codClienteImagem, codCliente, extClienteImagem FROM clientesImagens WHERE codCliente = ".$url[6]." ORDER BY codClienteImagem ASC LIMIT ".$pgInicio.", 14";
				}

				$resultConsulta = $conn->query($sqlConsulta);
				$cont = 0;
				while($dadosImagem = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;
?>
        
								<p class="imagem" style="width:150px; margin-right:30px;"><img src="<?php echo $configUrlGer; ?>f/clientes/<?php echo $dadosImagem['codCliente'].'-'.$dadosImagem['codClienteImagem'].'-O.'.$dadosImagem['extClienteImagem'];?>" alt="Imagem Cliente" width="150"/><br/>
								<input type="checkbox" name="excluir<?php echo $cont; ?>" value="<?php echo $dadosImagem['codClienteImagem']; ?>" /> Excluir</p>
				
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
				$area = "cadastros/clientes/foto/".$url[6];
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
