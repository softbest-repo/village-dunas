<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "banners";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeBanner = "SELECT * FROM banners WHERE codBanner = '".$url[6]."'";
				$resultNomeBanner = $conn->query($sqlNomeBanner);
				$dadosNomeBanner = $resultNomeBanner->fetch_assoc();
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Site</p>
						<p class="flexa"></p>
						<p class="nome-lista">Banners Capa</p>
						<p class="flexa"></p>
						<p class="nome-lista">Imagens</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeBanner['nomeBanner'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeBanner['statusBanner'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>site/banners/ativacao/<?php echo $dadosNomeBanner['codBanner'] ?>/' title='Deseja <?php echo $statusPergunta ?> o banner capa <?php echo $dadosNomeBanner['nomeBanner'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>site/banners/alterar/<?php echo $dadosNomeBanner['codBanner'] ?>/' title='Deseja alterar o banner capa <?php echo $dadosNomeBanner['nomeBanner'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeBanner['codBanner'] ?>, "<?php echo htmlspecialchars($dadosNomeBanner['nomeBanner']) ?>");' title='Deseja excluir o banner capa <?php echo $dadosNomeBanner['nomeBanner'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){
								if(confirm("Deseja excluir o banner capa "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>site/banners/excluir/'+cod+'/';
								}
							}
						 </script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Banners Capa" href="<?php echo $configUrl;?>site/banners/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
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
								$sqlConsultaDelete = "SELECT * FROM bannersImagens WHERE codBannerImagem = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM bannersImagens WHERE codBannerImagem = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/banners/".$dadosConsultaDelete['codBanner']."-".$dadosConsultaDelete['codBannerImagem']."-O.".$dadosConsultaDelete['extBannerImagem'])){
									unlink("f/banners/".$dadosConsultaDelete['codBanner']."-".$dadosConsultaDelete['codBannerImagem']."-O.".$dadosConsultaDelete['extBannerImagem']);
									unlink("f/banners/".$dadosConsultaDelete['codBanner']."-".$dadosConsultaDelete['codBannerImagem']."-W.webp");
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}
					
					if($exclusao == ""){
						
						$pastaDestino = "f/banners/";
											
						$file = $_FILES['imagem'];
						$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
							
						if(in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])){	
							
							$file_name = uniqid() . '.' . $ext;							
															
							$sqlBanner = "SELECT * FROM banners WHERE codBanner = ".$url[6]." ORDER BY codBanner DESC LIMIT 0,1";
							$resultBanner = $conn->query($sqlBanner);
							$dadosBanner = $resultBanner->fetch_assoc();
															
							$sql =  "INSERT INTO bannersImagens VALUES(0, ".$url[6].", '', '".$ext."')";
							$result = $conn->query($sql);
													
							if($result == 1){

								function saveWebPImage($original_image, $new_image_path, $quality = 100) {
									if (imagewebp($original_image, $new_image_path, $quality)) {
										return true;
									} else {
										return false;
									}
								}
																
								$sqlNome = "SELECT * FROM bannersImagens ORDER BY codBannerImagem DESC";
								$resultNome = $conn->query($sqlNome);
								$dadosNome = $resultNome->fetch_assoc();
								
								$codBannerImagem = $dadosNome['codBannerImagem'];
								$codBanner = $dadosNome['codBanner'];
								$nomeBannerImagem = $dadosNome['nomeBannerImagem'];
								
								move_uploaded_file($file['tmp_name'], $pastaDestino.$codBanner."-".$codBannerImagem."-O.".$ext);
								
								chmod ($pastaDestino.$codBanner."-".$codBannerImagem."-O.".$ext, 0755);
																
								$imagemWebP = $pastaDestino.$codBanner."-".$codBannerImagem."-W.webp";

								switch ($ext) {
									case 'jpg':
									case 'jpeg':
									$original_image = imagecreatefromjpeg($pastaDestino.$codBanner."-".$codBannerImagem."-O.".$ext);
									break;
									case 'png':
									$original_image = imagecreatefrompng($pastaDestino.$codBanner."-".$codBannerImagem."-O.".$ext);
									break;
									case 'gif':
									$original_image = imagecreatefromgif($pastaDestino.$codBanner."-".$codBannerImagem."-O.".$ext);
									break;
								}

								saveWebPImage($original_image, $imagemWebP, 95);

								imagedestroy($original_image);

								chmod ($pastaDestino.$codBanner."-".$codBannerImagem."-W.webp", 0755);								
														
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
?>
<?php	
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

						<form action="<?php echo $configUrlGer; ?>site/banners/imagens/<?php echo $url[6];?>/" enctype="multipart/form-data" method="post">
							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Observação:</label>As extensões permitidas estão listadas abaixo;<br/>Tamanho recomendado está listado abaixo;<br/>Para cadastrar imagens, clique em escolher arquivo e selecione uma ou mais imagens e clique em salvar;<br/>As imagens são salvas automaticamente;<br/>Para excluir as imagens, selecione a imagem e clique no botão excluir;</p>

							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Importante:</label>A primeira imagem cadastrada será mostrada na Versão Desktop e a segunda será mostrada na versão Mobile.</p>
							
							<p class="bloco-campo"><label class="label" style="font-size:15px; line-height:20px; font-weight:normal;"><strong>Extensão:</strong> png,jpg ou jpeg<br/><strong>Tamanho Desktop:</strong> 1920 x 1080 | <strong>Tamanho Mobile:</strong> 1080 x 1080</labeL>
							<input class="campo" type="file" name="imagem" style="width:390px; margin-top:10px;" value="" /></p>
							
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
							<br/>
							<br/>
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT * FROM bannersImagens WHERE codBanner = ".$url[6]."";
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = mysqli_num_rows($resultRegistro);
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM bannersImagens WHERE codBanner = ".$url[6]." ORDER BY codBannerImagem ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT * FROM bannersImagens WHERE codBanner = ".$url[6]." ORDER BY codBannerImagem ASC LIMIT ".$pgInicio.", 14";
				}

				$cont = 0;

				$resultConsulta = $conn->query($sqlConsulta);
				while($dadosImagem = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;		
?>       
								<div class="imagem" style="width:300px; height:200px; margin-right:30px;">
									<p style="width:300px; height:150px; display:table-cell; vertical-align:middle;"><img src="<?php echo $configUrl."f/banners/".$dadosImagem['codBanner'].'-'.$dadosImagem['codBannerImagem'].'-W.webp';?>" alt="Imagem Banner" style="max-width:300px; max-height:150px;"/><br/></p>
									<label><input type="checkbox" name="excluir<?php echo $cont; ?>" value="<?php echo $dadosImagem['codBannerImagem']; ?>" /> Excluir</label>
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
				$area = "site/banners/imagens/".$url[6];
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
