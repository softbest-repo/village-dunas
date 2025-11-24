<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "proprietarios";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$_SESSION['nome'] = "";
				$sqlNomeProprietario = "SELECT * FROM proprietarios WHERE codProprietario = '".$url[6]."'".$filtraUsuario."";
				$resultNomeProprietario = $conn->query($sqlNomeProprietario);
				$dadosNomeProprietario = $resultNomeProprietario->fetch_assoc();

				if($dadosNomeProprietario['codUsuario'] == ""){
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/proprietarios/'>";					
				}
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Proprietários</p>
						<p class="flexa"></p>
						<p class="nome-lista">Foto</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeProprietario['nomeProprietario'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeProprietario['statusProprietario'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/ativacao/<?php echo $dadosNomeProprietario['codProprietario'] ?>/' title='Deseja <?php echo $statusPergunta ?> o proprietário <?php echo $dadosNomeProprietario['nomeProprietario'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/alterar/<?php echo $dadosNomeProprietario['codProprietario'] ?>/' title='Deseja alterar o proprietário <?php echo $dadosNomeProprietario['nomeProprietario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
						</tr>
					</table>	
					<div class="botao-consultar"><a title="Consultar Proprietários" href="<?php echo $configUrl;?>cadastros/proprietarios/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
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
								$sqlConsultaDelete = "SELECT * FROM proprietariosImagens WHERE codProprietarioImagem = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM proprietariosImagens WHERE codProprietarioImagem = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/proprietarios/".$dadosConsultaDelete['codProprietario']."-".$dadosConsultaDelete['codProprietarioImagem']."-O.".$dadosConsultaDelete['extProprietarioImagem'])){
									unlink("f/proprietarios/".$dadosConsultaDelete['codProprietario']."-".$dadosConsultaDelete['codProprietarioImagem']."-O.".$dadosConsultaDelete['extProprietarioImagem']);
									unlink("f/proprietarios/".$dadosConsultaDelete['codProprietario']."-".$dadosConsultaDelete['codProprietarioImagem']."-P.".$dadosConsultaDelete['extProprietarioImagem']);
									unlink("f/proprietarios/".$dadosConsultaDelete['codProprietario']."-".$dadosConsultaDelete['codProprietarioImagem']."-M.".$dadosConsultaDelete['extProprietarioImagem']);
									unlink("f/proprietarios/".$dadosConsultaDelete['codProprietario']."-".$dadosConsultaDelete['codProprietarioImagem']."-G.".$dadosConsultaDelete['extProprietarioImagem']);
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}
					
					if($exclusao == ""){
						
						$pastaDestino = "f/proprietarios/";
											
						$file = $_FILES['imagem'];

						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
													
						if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])){	
							
							$file_name = uniqid() . '.' . $ext;							
															
							$sqlProprietario = "SELECT * FROM proprietarios WHERE codProprietario = ".$url[6]." ORDER BY codProprietario DESC LIMIT 0,1";
							$resultProprietario = $conn->query($sqlProprietario);
							$dadosProprietario = $resultProprietario->fetch_assoc();
															
							$sql =  "INSERT INTO proprietariosImagens VALUES(0, ".$url[6].", '".$ext."')";
							$result = $conn->query($sql);
																				
							if($result == 1){
								
								$sqlNome = "SELECT * FROM proprietariosImagens ORDER BY codProprietarioImagem DESC";
								$resultNome = $conn->query($sqlNome);
								$dadosNome = $resultNome->fetch_assoc();
								
								$codProprietarioImagem = $dadosNome['codProprietarioImagem'];
								$codProprietario = $dadosNome['codProprietario'];
								$nomeProprietarioImagem = $dadosNome['nomeProprietarioImagem'];
								
								move_uploaded_file($file['tmp_name'], $pastaDestino.$codProprietario."-".$codProprietarioImagem."-O.".$ext);
								
								chmod ($pastaDestino.$codProprietario."-".$codProprietarioImagem."-O.".$ext, 0755);
																
								$sizes = [
									['width' => 200, 'height' => 200, 'tamanho' => 'P'],
									['width' => 400, 'height' => 400, 'tamanho' => 'M'],
									['width' => 800, 'height' => 800, 'tamanho' => 'G'],
								];

								foreach ($sizes as $size) {
									list($width, $height) = getimagesize($pastaDestino.$codProprietario."-".$codProprietarioImagem."-O.".$ext);

									$ratio = $width / $height;
									$new_width = $size['width'];
									$new_height = $new_width / $ratio;
									$tamanho = $size['tamanho'];

									$new_image = imagecreatetruecolor($new_width, $new_height);

									switch ($ext) {
										case 'jpg':
										case 'jpeg':
										$original_image = imagecreatefromjpeg($pastaDestino.$codProprietario."-".$codProprietarioImagem."-O.".$ext);
										break;
										case 'png':
										$original_image = imagecreatefrompng($pastaDestino.$codProprietario."-".$codProprietarioImagem."-O.".$ext);
										break;
										case 'gif':
										$original_image = imagecreatefromgif($pastaDestino.$codProprietario."-".$codProprietarioImagem."-O.".$ext);
										break;
									}

									imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

									switch ($ext) {
										case 'jpg':
										case 'jpeg':
										imagejpeg($new_image, $pastaDestino.$codProprietario."-".$codProprietarioImagem."-".$tamanho.".".$ext, 100);
										break;
										case 'png':
										imagepng($new_image, $pastaDestino.$codProprietario."-".$codProprietarioImagem."-".$tamanho.".".$ext);
										break;
										case 'gif':
										imagegif($new_image, $pastaDestino.$codProprietario."-".$codProprietarioImagem."-".$tamanho.".".$ext);
										break;
									}

									imagedestroy($new_image);
									imagedestroy($original_image);

									chmod ($pastaDestino.$codProprietario."-".$codProprietarioImagem."-P.".$ext, 0755);
									chmod ($pastaDestino.$codProprietario."-".$codProprietarioImagem."-M.".$ext, 0755);
									chmod ($pastaDestino.$codProprietario."-".$codProprietarioImagem."-G.".$ext, 0755);								
								}
														
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

						<form action="<?php echo $configUrlGer; ?>cadastros/proprietarios/foto/<?php echo $url[6]; ?>/1/" enctype="multipart/form-data" method="post">
							<p class="bloco-campo"><label>Imagem: <span class="aviso"> PNG, JPG </span><span class="aviso">800 X 800</span><span class="obrigatorio"> * </span></label>
							<input class="campo" type="file" name="imagem" size="15" value="" /></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT count(codProprietarioImagem) registros FROM proprietariosImagens WHERE codProprietario = ".$url[6];
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = $dadosRegistro['registros'];
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT codProprietarioImagem, codProprietario, extProprietarioImagem FROM proprietariosImagens WHERE codProprietario = ".$url[6]." ORDER BY codProprietarioImagem ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT codProprietarioImagem, codProprietario, extProprietarioImagem FROM proprietariosImagens WHERE codProprietario = ".$url[6]." ORDER BY codProprietarioImagem ASC LIMIT ".$pgInicio.", 14";
				}

				$resultConsulta = $conn->query($sqlConsulta);
				$cont = 0;
				while($dadosImagem = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;
?>
        
								<p class="imagem"><img src="<?php echo $configUrlGer; ?>f/proprietarios/<?php echo $dadosImagem['codProprietario'].'-'.$dadosImagem['codProprietarioImagem'].'-P.'.$dadosImagem['extProprietarioImagem'];?>" alt="Imagem Proprietario" /><br/>
								<input type="checkbox" name="excluir<?php echo $cont; ?>" value="<?php echo $dadosImagem['codProprietarioImagem']; ?>" /> Excluir</p>
				
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
				$area = "cadastros/proprietarios/foto/".$url[6];
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
