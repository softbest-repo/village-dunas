<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "balnearioGaivota";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeBalnearioGaivota = "SELECT * FROM balnearioGaivota WHERE codBalnearioGaivota = '".$url[6]."'";
				$resultNomeBalnearioGaivota = $conn->query($sqlNomeBalnearioGaivota);
				$dadosNomeBalnearioGaivota = $resultNomeBalnearioGaivota->fetch_assoc();
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Site</p>
						<p class="flexa"></p>
						<p class="nome-lista">Balneário Gaivota</p>
						<p class="flexa"></p>
						<p class="nome-lista">Imagens</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeBalnearioGaivota['nomeBalnearioGaivota'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeBalnearioGaivota['statusBalnearioGaivota'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>site/balnearioGaivota/alterar/<?php echo $dadosNomeBalnearioGaivota['codBalnearioGaivota'] ?>/' title='Deseja alterar o banner capa <?php echo $dadosNomeBalnearioGaivota['nomeBalnearioGaivota'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
						</tr>
					</table>	
					<div class="botao-consultar"><a title="Consultar Balneário Gaivota" href="<?php echo $configUrl;?>site/balnearioGaivota/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
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
								$sqlConsultaDelete = "SELECT * FROM balnearioGaivotaImagens WHERE codBalnearioGaivotaImagem = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM balnearioGaivotaImagens WHERE codBalnearioGaivotaImagem = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/balnearioGaivota/".$dadosConsultaDelete['codBalnearioGaivota']."-".$dadosConsultaDelete['codBalnearioGaivotaImagem']."-O.".$dadosConsultaDelete['extBalnearioGaivotaImagem'])){
									unlink("f/balnearioGaivota/".$dadosConsultaDelete['codBalnearioGaivota']."-".$dadosConsultaDelete['codBalnearioGaivotaImagem']."-O.".$dadosConsultaDelete['extBalnearioGaivotaImagem']);
									unlink("f/balnearioGaivota/".$dadosConsultaDelete['codBalnearioGaivota']."-".$dadosConsultaDelete['codBalnearioGaivotaImagem']."-P.".$dadosConsultaDelete['extBalnearioGaivotaImagem']);
									unlink("f/balnearioGaivota/".$dadosConsultaDelete['codBalnearioGaivota']."-".$dadosConsultaDelete['codBalnearioGaivotaImagem']."-M.".$dadosConsultaDelete['extBalnearioGaivotaImagem']);
									unlink("f/balnearioGaivota/".$dadosConsultaDelete['codBalnearioGaivota']."-".$dadosConsultaDelete['codBalnearioGaivotaImagem']."-G.".$dadosConsultaDelete['extBalnearioGaivotaImagem']);
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}
					
					if($exclusao == ""){
						
						$pastaDestino = "f/balnearioGaivota/";
											
						$file = $_FILES['imagem'];
						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
							
						if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])){	
							
							$file_name = uniqid() . '.' . $ext;							
															
							$sqlBalnearioGaivota = "SELECT * FROM balnearioGaivota WHERE codBalnearioGaivota = ".$url[6]." ORDER BY codBalnearioGaivota DESC LIMIT 0,1";
							$resultBalnearioGaivota = $conn->query($sqlBalnearioGaivota);
							$dadosBalnearioGaivota = $resultBalnearioGaivota->fetch_assoc();
															
							$sql =  "INSERT INTO balnearioGaivotaImagens VALUES(0, ".$url[6].", 'F', 'F', '".$ext."')";
							$result = $conn->query($sql);
													
							if($result == 1){
								
								$sqlNome = "SELECT * FROM balnearioGaivotaImagens ORDER BY codBalnearioGaivotaImagem DESC";
								$resultNome = $conn->query($sqlNome);
								$dadosNome = $resultNome->fetch_assoc();
								
								$codBalnearioGaivotaImagem = $dadosNome['codBalnearioGaivotaImagem'];
								$codBalnearioGaivota = $dadosNome['codBalnearioGaivota'];
								$nomeBalnearioGaivotaImagem = $dadosNome['nomeBalnearioGaivotaImagem'];
								
								move_uploaded_file($file['tmp_name'], $pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);
								
								chmod ($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext, 0755);
																
								$sizes = [
									['width' => 200, 'height' => 100, 'tamanho' => 'P'],
									['width' => 800, 'height' => 600, 'tamanho' => 'M'],
									['width' => 1920, 'height' => 730, 'tamanho' => 'G'],
								];

								foreach ($sizes as $size) {
									list($width, $height) = getimagesize($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);

									$ratio = $width / $height;
									$new_width = $size['width'];
									$new_height = $new_width / $ratio;
									$tamanho = $size['tamanho'];

									$new_image = imagecreatetruecolor($new_width, $new_height);

									switch ($ext) {
										case 'jpg':
										case 'jpeg':
										$original_image = imagecreatefromjpeg($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);
										break;
										case 'png':
										$original_image = imagecreatefrompng($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);
										break;
										case 'gif':
										$original_image = imagecreatefromgif($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-O.".$ext);
										break;
									}

									imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

									switch ($ext) {
										case 'jpg':
										case 'jpeg':
										imagejpeg($new_image, $pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-".$tamanho.".".$ext, 100);
										break;
										case 'png':
										imagepng($new_image, $pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-".$tamanho.".".$ext);
										break;
										case 'gif':
										imagegif($new_image, $pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-".$tamanho.".".$ext);
										break;
									}

									imagedestroy($new_image);
									imagedestroy($original_image);

									chmod ($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-P.".$ext, 0755);
									chmod ($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-M.".$ext, 0755);
									chmod ($pastaDestino.$codBalnearioGaivota."-".$codBalnearioGaivotaImagem."-G.".$ext, 0755);								
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

						<form action="<?php echo $configUrlGer; ?>site/balnearioGaivota/imagens-f/<?php echo $url[6];?>/" enctype="multipart/form-data" method="post">
							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Observação:</label>As extensões permitidas estão listadas abaixo;<br/>Tamanho recomendado está listado abaixo;<br/>Para cadastrar imagens, clique em escolher arquivo e selecione uma ou mais imagens e clique em salvar;<br/>As imagens são salvas automaticamente;<br/>Para excluir as imagens, selecione a imagem e clique no botão salvar;</p>
							
							<p class="bloco-campo"><label class="label" style="font-size:15px; line-height:20px; font-weight:normal;"><strong>Extensão:</strong> png,jpg ou jpeg<br/><strong>Tamanho Desktop:</strong> 1920 x 932 | <strong>Tamanho Mobile:</strong> 932 x 932</labeL>
							<input class="campo" type="file" name="imagem" style="width:390px; margin-top:10px;" value="" /></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
							<br/>
							<br/>
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT * FROM balnearioGaivotaImagens WHERE codBalnearioGaivota = ".$url[6]." and tipoBalnearioGaivotaImagem = 'F'";
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = mysqli_num_rows($resultRegistro);
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM balnearioGaivotaImagens WHERE codBalnearioGaivota = ".$url[6]." and tipoBalnearioGaivotaImagem = 'F' ORDER BY codBalnearioGaivotaImagem ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT * FROM balnearioGaivotaImagens WHERE codBalnearioGaivota = ".$url[6]." and tipoBalnearioGaivotaImagem = 'F' ORDER BY codBalnearioGaivotaImagem ASC LIMIT ".$pgInicio.", 14";
				}

				$cont = 0;

				$resultConsulta = $conn->query($sqlConsulta);
				while($dadosImagem = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;		
?>       
								<div class="imagem" style="width:200px; height:200px; margin-right:30px;">
									<p style="width:200px; height:142px; display:table-cell; vertical-align:middle;"><img src="<?php echo $configUrl."f/balnearioGaivota/".$dadosImagem['codBalnearioGaivota'].'-'.$dadosImagem['codBalnearioGaivotaImagem'].'-P.'.$dadosImagem['extBalnearioGaivotaImagem'];?>" alt="Imagem BalnearioGaivota"/><br/></p>
									<label><input type="checkbox" name="excluir<?php echo $cont; ?>" value="<?php echo $dadosImagem['codBalnearioGaivotaImagem']; ?>" /> Excluir</label>
								</div>			
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
				$area = "site/balnearioGaivota/imagens-f/".$url[6];
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
