<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "preferencias";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){
?>
				<script type="text/javascript" src="<?php echo $configUrl;?>configuracoes/minha-foto/js/jquery.min.js"></script>
				<script type="text/javascript" src="<?php echo $configUrl;?>configuracoes/minha-foto/js/jquery.Jcrop.js"></script>
				<link rel="stylesheet" href="<?php echo $configUrl;?>configuracoes/minha-foto/css/exemplo.css" type="text/css" />
				<link rel="stylesheet" href="<?php echo $configUrl;?>configuracoes/minha-foto/css/jquery.Jcrop.css" type="text/css" />
		
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Configurações</p>
						<p class="flexa"></p>
						<p class="nome-lista">Minha Foto</p>
						<br class="clear" />
					</div>
				</div>
				<div id="dados-conteudo">
					<div id="col-esq-pref" style="width:20%;">
						<p class="titulo-menu-pref">Alterar preferências</p>
						<p class="<?php echo $url[4] == 'minha-foto' ? 'menu-pref-foto-ativo' : 'menu-pref-foto' ;?>"><a href="<?php echo $configUrl;?>configuracoes/minha-foto/" title="Minha foto" >Minha foto</a></p>
						<p class="<?php echo $url[4] == 'email' ? 'menu-pref-email-ativo' : 'menu-pref-email' ;?>"><a href="<?php echo $configUrl;?>configuracoes/email/" title="Email" >Email</a></p>
						<p class="<?php echo $url[4] == 'permissoes' ? 'menu-pref-permissoes-ativo' : 'menu-pref-permissoes' ;?>"><a href="<?php echo $configUrl;?>configuracoes/permissoes/" title="Permissões" >Permissões</a></p>
						<p class="<?php echo $url[4] == 'usuarios' ? 'menu-pref-usuarios-ativo' : 'menu-pref-usuarios' ;?>"><a href="<?php echo $configUrl;?>cadastros/usuarios/" title="Usuários">Usuários</a></p>
					</div>
<?php
				// memory limit (nem todo server aceita)
				ini_set("memory_limit","50M");
				set_time_limit(0);
				
				// processa arquivo
				$imagem		= ( isset( $_FILES['imagem'] ) && is_array( $_FILES['imagem'] ) ) ? $_FILES['imagem'] : NULL;
				$tem_crop	= false;
				$img		= '';
				
				$pastaDestino = "configuracoes/minha-foto/";

				// valida a imagem enviada
				if( $imagem['tmp_name'] ){

					// armazena dimensões da imagem
					$imagesize = getimagesize( $imagem['tmp_name'] );
					
					if( $imagesize !== false ){
						
						$ext = strtolower(pathinfo($imagem['name'], PATHINFO_EXTENSION));
						
						if($ext == "jpg" || $ext == "JPG" || $ext == "jpeg" || $ext == "JPEG" || $ext == "png" || $ext == "PNG" || $ext == "gif" || $ext == "gif"){
							
							$sqlConsulta = "SELECT * FROM usuariosImagens WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]." LIMIT 0,1";
							$resultConsulta = $conn->query($sqlConsulta);
							$dadosConsulta = $resultConsulta->fetch_assoc();
												
							if($dadosConsulta['codConsulta'] != ""){
								$sqlDelete = "DELETE FROM usuariosImagens WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]."";
								$resultDelete = $conn->query($sqlDelete);							
							}
																		
							$sqlImagem = "INSERT INTO usuariosImagens VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", '".$ext."')";
							$resultImagem = $conn->query($sqlImagem);

							$sqlConsultaNova = "SELECT * FROM usuariosImagens WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY codUsuarioImagem DESC LIMIT 0,1";
							$resultConsultaNova = $conn->query($sqlConsultaNova);
							$dadosConsultaNova = $resultConsultaNova->fetch_assoc();

							$nomeImagem = $_COOKIE['codAprovado'.$cookie].'-'.$dadosConsultaNova['codUsuarioImagem']."-O.".$ext;
							
							if(move_uploaded_file($imagem['tmp_name'], $pastaDestino.$nomeImagem)){

								chmod ($pastaDestino.$nomeImagem, 0755);

								list($width, $height) = getimagesize($pastaDestino.$_COOKIE['codAprovado'.$cookie]."-".$dadosConsultaNova['codUsuarioImagem']."-O.".$ext);

								$ratio = $width / $height;
								$new_width = 300;
								$new_height = $new_width / $ratio;
								$tamanho = "G";

								$new_image = imagecreatetruecolor($new_width, $new_height);

								switch ($ext) {
									case 'jpg':
									case 'jpeg':
									$original_image = imagecreatefromjpeg($pastaDestino.$_COOKIE['codAprovado'.$cookie]."-".$dadosConsultaNova['codUsuarioImagem']."-O.".$ext);
									break;
									case 'png':
									$original_image = imagecreatefrompng($pastaDestino.$_COOKIE['codAprovado'.$cookie]."-".$dadosConsultaNova['codUsuarioImagem']."-O.".$ext);
									break;
									case 'gif':
									$original_image = imagecreatefromgif($pastaDestino.$_COOKIE['codAprovado'.$cookie]."-".$dadosConsultaNova['codUsuarioImagem']."-O.".$ext);
									break;
								}

								imagecopyresampled($new_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

								switch ($ext) {
									case 'jpg':
									case 'jpeg':
									imagejpeg($new_image, $pastaDestino.$_COOKIE['codAprovado'.$cookie]."-".$dadosConsultaNova['codUsuarioImagem']."-".$tamanho.".".$ext, 100);
									break;
									case 'png':
									imagepng($new_image, $pastaDestino.$_COOKIE['codAprovado'.$cookie]."-".$dadosConsultaNova['codUsuarioImagem']."-".$tamanho.".".$ext);
									break;
									case 'gif':
									imagegif($new_image, $pastaDestino.$_COOKIE['codAprovado'.$cookie]."-".$dadosConsultaNova['codUsuarioImagem']."-".$tamanho.".".$ext);
									break;
								}

								imagedestroy($new_image);
								imagedestroy($original_image);

								chmod ($pastaDestino.$_COOKIE['codAprovado'.$cookie]."-".$dadosConsultaNova['codUsuarioImagem']."-G.".$ext, 0755);
																
								$imagesize 	= getimagesize($pastaDestino.$_COOKIE['codAprovado'.$cookie]."-".$dadosConsultaNova['codUsuarioImagem']."-G.".$ext);
								$img		= '<img src="'.$configUrl.'configuracoes/minha-foto/'.$nomeImagem.'" id="jcrop" '.$imagesize[3].' />';
								$preview	= '<img src="'.$configUrl.'configuracoes/minha-foto/'.$nomeImagem.'" id="preview" '.$imagesize[3].' />';
								$tem_crop 	= true;	
							}
						}else{
							$style = "style='display:block;'";
?>
					<script>
						alert("Selecione uma imagem em jpg, jpeg, png ou gif.");
					</script>
<?php
						}
					}
				}else{
					$style = "style='display:none;'";
				}
?>
					<div id="col-dir-pref">
<?php if( $tem_crop === true ): ?>
					
						<p id="tit-jcrop">Recorte a imagem</p>
						<div id="div-jcrop">
						
							<div id="div-preview">
								<?php echo $preview; ?>
							</div>
							
							<?php echo $img; ?>
							<br class="clear" />
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="btn-crop" type="button" name="salvar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div></p>

						</div>
						<div id="debug" class="oculto">
							<p><strong>X</strong> <input type="text" id="x" size="5" value=""/> x <input type="text" id="x2" size="5" value="" /> </p>
							<p><strong>Y</strong> <input type="text" id="y" size="5" value="" /> x <input type="text" id="y2" size="5" value="" /> </p>
							<p><strong>Dimensões</strong> <input type="text" id="h" size="5" value="" /> x <input type="text" id="w" size="5" value="" /></p>
						</div>

						<script type="text/javascript">
							var img = "<?php echo $_COOKIE['codAprovado'.$cookie].'-'.$dadosConsultaNova['codUsuarioImagem'].'-G.'.$ext; ?>";
							
							const origin = [10,20,30,15];
							
							$(function(){
								$('#jcrop').Jcrop({
									onChange: exibePreview,
									onSelect: exibePreview,
									minSize		: [ 100, 100 ],
									maxSize		: [ 300, 300 ],
									allowResize	: true,
									aspectRatio: 4/4,
									setSelect: [100, 100, 200, 100 ],
									addClas: 'custom'
								});
								
								$('#btn-crop').click(function(){
									$.post( 'crop.php', {
										img:img, 
										x: $('#x').val(), 
										y: $('#y').val(), 
										w: $('#w').val(), 
										h: $('#h').val()
									}, function(){
											$('#div-jcrop').html( '<img src="' + img + '?' + Math.random() + '" width="'+$('#w').val()+'" height="'+$('#h').val()+'" />' );
											$('#debug').hide();
											$('#tit-jcrop').html('Feito!<br />');
										});
									return false;
								});
							});
										
							function exibePreview(c){
								var rx = 200 / c.w;
								var ry = 200 / c.h;
										
								$('#preview').css({
									width: Math.round(rx * <?php echo $imagesize[0]; ?>) + 'px',
									height: Math.round(ry * <?php echo $imagesize[1]; ?>) + 'px',
									marginLeft: '-' + Math.round(rx * c.x) + 'px',
									marginTop: '-' + Math.round(ry * c.y) + 'px'
								});
																														
								$('#x').val(c.x);
								$('#y').val(c.y);
								$('#x2').val(c.x2);
								$('#y2').val(c.y2);
								$('#w').val(c.w);
								$('#h').val(c.h);
								
											
							};
						</script>

<?php else: ?>
						<div id="foto-atual">
							<p class="titulo-col-dir-pref">Minha foto</p>
<?php
				$sql = "SELECT * FROM usuariosImagens WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY codUsuarioImagem DESC LIMIT 0,1";
				$result = $conn->query($sql);
				$dados = $result->fetch_assoc();
				if($dados['codUsuario'] != ""){
?>
							<p class="imagem-altera" style="width:auto; height:auto; min-width:100px; min-height:100px;"><img src="<?php echo $configUrl.'configuracoes/minha-foto/'.$dados['codUsuario'].'-'.$dados['codUsuarioImagem'].'-G.'.$dados['extUsuarioImagem'];?>" alt="Imagem Usuario" style="max-width:300px; max-height:300px;"/></p>
							<p class="nome-altera"><?php echo $_COOKIE['loginAprovado'.$cookie];?></p>
							<br class="clear" />
<?php
				}else{
?>
							<p class="imagem-altera"><img src="<?php echo $configUrl.'f/i/default/topo-default/cabecalho-avatar.gif';?>" alt="Imagem Usuario" /></p>
							<p class="nome-altera"><?php echo $_COOKIE['loginAprovado'.$cookie];?></p>
							<br class="clear" />
<?php
				}
?>
							<script>
								function mostraFile(){
									document.getElementById("alteraFoto").style.display = "block";
								}
							</script>

							<p class="link-alterar"><a href="javascript:mostraFile();" title="Alterar" >Alterar</a></p>						
							<div id="alteraFoto" <?php echo $style;?>>
								<div id="escolhe-foto">
									<p class="titulo-alterar-foto">Alterar foto</p>
									<form name="frm-jcrop" id="frm-jcrop" method="post" action="<?php echo $configUrl;?>configuracoes/minha-foto/" enctype="multipart/form-data">
										<p>
											<label>Envie uma imagem: JPG, jpg</label>
											<input type="file" name="imagem" id="imagem" />
											<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="enviar" title="Enviar" value="Enviar" /><p class="direita-botao"></p></div></p>
										</p>
									</form>
								</div>
							</div>
						</div>
<?php endif; ?>
					</div>
					<br class="clear" />
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

