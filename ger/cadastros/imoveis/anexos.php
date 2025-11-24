<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "imoveisS";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				$sqlNomeImovel = "SELECT * FROM imoveis WHERE codImovel = '".$url[6]."'";
				$resultNomeImovel = $conn->query($sqlNomeImovel);
				$dadosNomeImovel = $resultNomeImovel->fetch_assoc();

				if(isset($_POST['cod-anexo'])){					
					$sqlUpdate = "UPDATE imoveisAnexos SET tipoImovelAnexo = '".$_POST['tipo-anexo']."' WHERE codImovelAnexo = ".$_POST['cod-anexo']."";
					$resultUpdate = $conn->query($sqlUpdate);
					
					if($resultUpdate == 1){
						$erroData = "<p class='erro'>Tipo do anexo alterado com sucesso!</p>";
					}else{
						$erroData = "<p class='erro'>Erro</p>";
					}
				}				
?>	
		
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Cadastros</p>
						<p class="flexa"></p>
						<p class="nome-lista">Imóveis</p>
						<p class="flexa"></p>
						<p class="nome-lista">Anexos</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeImovel['nomeImovel'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeImovel['statusImovel'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>cadastros/imoveis/alterar/<?php echo $dadosNomeImovel['codImovel'] ?>/' title='Deseja alterar <?php echo $dadosNomeImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
						</tr>
					</table>	
					<div class="botao-consultar"><a title="Consultar Imóveis" href="<?php echo $configUrl;?>cadastros/imoveis/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['cont']) && $_POST['cod-anexo'] == ""){
					
					$noErros = "";
					
					if($_POST['cont'] >  0){
													
						for($i=0; $i<=$_POST['cont']; $i++){
							$contadorDel = "excluir".$i;
							if(isset($_POST[$contadorDel])){
								$sqlConsultaDelete = "SELECT * FROM imoveisAnexos WHERE codImovelAnexo = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM imoveisAnexos WHERE codImovelAnexo = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/imoveisAnexo/".$dadosConsultaDelete['codImovel']."-".$dadosConsultaDelete['codImovelAnexo']."-O.".$dadosConsultaDelete['extImovelAnexo'])){
									unlink("f/imoveisAnexo/".$dadosConsultaDelete['codImovel']."-".$dadosConsultaDelete['codImovelAnexo']."-O.".$dadosConsultaDelete['extImovelAnexo']);								
								}
							
								if($resultDelete == 1){
									$noErros = "ok";
								}
							}
						}
					}

					$erroData = "<p class='erro'>Documento(s) excluídos com sucesso!</p>";
				}

				if($_POST['documento'] != ""){
										
					$pastaDestino = "f/imoveisAnexo/";
										
					$file = $_FILES['imagem'];

					$ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
																			
					$nomeAnexo = $file['name'];					
					
					$sqlPegaCliente = "SELECT * FROM clientes WHERE nomeCliente = '".$_POST['clientes']."' ORDER BY codCliente DESC LIMIT 0,1";
					$resultPegaCliente = $conn->query($sqlPegaCliente);
					$dadosPegaCliente = $resultPegaCliente->fetch_assoc();

					$sql =  "INSERT INTO imoveisAnexos VALUES(0, ".$url[6].", '".$dadosPegaCliente['codCliente']."', '".$_POST['documento']."', '".$nomeAnexo."', '".$ext."')";
					$result = $conn->query($sql);
																			
					if($result == 1){
						
						$sqlNome = "SELECT * FROM imoveisAnexos ORDER BY codImovelAnexo DESC";
						$resultNome = $conn->query($sqlNome);
						$dadosNome = $resultNome->fetch_assoc();
						
						$codImovel = $dadosNome['codImovel'];
						$codImovelAnexo = $dadosNome['codImovelAnexo'];
						$nomeImovelAnexo = $dadosNome['nomeImovelAnexo'];
						
						move_uploaded_file($file['tmp_name'], $pastaDestino.$codImovel."-".$codImovelAnexo."-O.".$ext);
						
						chmod ($pastaDestino.$codImovel."-".$codImovelAnexo."-O.".$ext, 0755);
																												
						$erroData = "<p class='erro'>Documento cadastrado com sucesso!</p>";														
					
					}else{
						$erroData = "<p class='erro'>Problemas ao cadastrar documento!</p>";
					}
				}				
?>

						<br class="clear"/>
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
<!--
						Novo Upload de Imagens sem Flash
-->
						<div id="carregamento-upload" style="display:none;">
							<p class="texto">Carregando...</p>
						</div>
						<style>
							#carregamento-upload {width:300px; height:200px; position:fixed; z-index:100; left:50%; margin-left:-150px; top:50%; margin-top:-100px; background-color:#FFF; box-shadow:0px 0px 10px -3px #000; border:1px solid #ccc; border-radius:10px;}
							#carregamento-upload .texto {font-size:16px; color:#666; margin-top:65px; padding-top:50px; font-family:Arial; text-align:center; background:transparent url('<?php echo $configUrlGer;?>cadastros/imoveis/loading.gif') center top no-repeat;}
						</style>
						<script type="text/javascript">
							function loadingUpload(){
								if(document.getElementById("arquivo").value!=""){
									document.getElementById("carregamento-upload").style.display="block";
								}
							}
						</script>
						<form id="formulario-anexo" action="<?php echo $configUrlGer; ?>cadastros/imoveis/anexos/<?php echo $url[6]; ?>/1/" onSubmit="confereFormulario(); return false;" enctype="multipart/form-data" method="post">							
							<div id="auto_complete_softbest" style="width:315px; float:left; margin-bottom:15px;">
								<p class="bloco-campo" style="margin-bottom:0px;"><label>Cliente: <span class="obrigatorio"> </span></label>
								<input class="campo" type="text" name="clientes" style="width:300px; height:22px;" value="<?php echo $_SESSION['clientes']; ?>" onClick="auto_complete(this.value, 'clientes_c', event);" onKeyUp="auto_complete(this.value, 'clientes_c', event);" onBlur="fechaAutoComplete('clientes_c');" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest_clientes_c" /></p>
								
								<div id="exibe_busca_autocomplete_softbest_clientes_c" class="auto_complete_softbest" style="width:314px; display:none;">

								</div>
							</div>	

							<p class="bloco-campo-float"><label>Tipo de Documento: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="documento" required name="documento" style="width:230px; height:38px; margin-top:0px;">
									<option value="">Selecione</option>
									<option value="Contrato" <?php echo $_SESSION['documento'] == "Contrato" ? '/SELECTED/' : '';?>>Contrato</option>				
									<option value="Procuração" <?php echo $_SESSION['documento'] == "Procuração" ? '/SELECTED/' : '';?>>Procuração</option>				
									<option value="Escritura" <?php echo $_SESSION['documento'] == "Escritura" ? '/SELECTED/' : '';?>>Escritura</option>				
									<option value="Matrícula" <?php echo $_SESSION['documento'] == "Matrícula" ? '/SELECTED/' : '';?>>Matrícula</option>				
									<option value="Parecer Ambiental" <?php echo $_SESSION['documento'] == "Parecer Ambiental" ? '/SELECTED/' : '';?>>Parecer Ambiental</option>				
									<option value="Projeto Edificação" <?php echo $_SESSION['documento'] == "Projeto Edificação" ? '/SELECTED/' : '';?>>Projeto Edificação</option>				
									<option value="Boletos" <?php echo $_SESSION['documento'] == "Boletos" ? '/SELECTED/' : '';?>>Boletos</option>				
									<option value="Outros Documentos" <?php echo $_SESSION['documento'] == "Outros Documentos" ? '/SELECTED/' : '';?>>Outros Documentos</option>				
								</select>
							</p>

							<p class="bloco-campo-float"><label>Anexo: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="file" required name="imagem" size="15" value="" /></p>

							<div class="botao-expansivel" style="padding-top:23px;"><p class="esquerda-botao"></p><input class="botao" onClick="loadingUpload();" type="submit" name="salvar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div>						
							<br class="clear"/>
						</form>
<!--
						Novo Upload de Imagens sem Flash
-->
						<br/>
						<br/>
						<form action="<?php echo $configUrlGer; ?>cadastros/imoveis/anexos/<?php echo $url[6]; ?>/" enctype="multipart/form-data" method="post">
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT * FROM imoveisAnexos WHERE codImovel = ".$url[6]."";
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = mysqli_num_rows($resultRegistro);
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM imoveisAnexos WHERE codImovel = ".$url[6]." ORDER BY codImovelAnexo ASC LIMIT 0, 30";
					$somaLimite = "30";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 30;
					$pgInicio = $somaLimite - 30;
					$sqlConsulta = "SELECT * FROM imoveisAnexos WHERE codImovel = ".$url[6]." ORDER BY codImovelAnexo ASC LIMIT ".$pgInicio.", 30";
				}

				$resultConsulta = $conn->query($sqlConsulta);
				$cont = 0;
				while($dadosAnexo = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;

					$sqlCliente = "SELECT * FROM clientes WHERE codCliente = ".$dadosAnexo['codCliente']." ORDER BY codCliente DESC LIMIT 0,1";
					$resultCliente = $conn->query($sqlCliente);
					$dadosCliente = $resultCliente->fetch_assoc();
?>
        
								<div class="imagem-sem" style="width:200px; float:left; margin-right:20px; margin-bottom:20px; height:195px;">
									<p class="imagem-pequena" style="width:100px; margin:0 auto; height:100px; overflow:hidden; margin-bottom:10px;"><a target="_blank" title="Clique aqui para baixar o arquivo" download="<?php echo $dadosAnexo['nomeImovelAnexo'];?>" href="<?php echo $configUrlGer; ?>f/imoveisAnexo/<?php echo $dadosAnexo['codImovel'].'-'.$dadosAnexo['codImovelAnexo'].'-O.'.$dadosAnexo['extImovelAnexo'];?>"><img id="imagem-imovel<?php echo $contAnexo;?>" src="<?php echo $configUrlGer; ?>f/i/documento.gif" alt="Anexo Imovel" width="100"/></a></p>
									<label style="color:#000; font-size:14px; text-align:center;"><?php echo $dadosAnexo['nomeImovelAnexo'];?></label>				
									<select class="campo" id="documento2" name="documento2" <?php echo $filtraUsuario != "" ? 'disabled="disabled"' : '';?> style="width:200px; text-align:center; padding:0px; margin-top:10px; font-size:14px; height:25px; margin-bottom:5px;" onChange="tipoSubmit(<?php echo $dadosAnexo['codImovelAnexo'];?>, this.value);">
										<option value="">Tipo Documento *</option>
										<option value="Contrato" <?php echo $dadosAnexo['tipoImovelAnexo'] == "Contrato" ? '/SELECTED/' : '';?>>Contrato</option>				
										<option value="Procuração" <?php echo $dadosAnexo['tipoImovelAnexo'] == "Procuração" ? '/SELECTED/' : '';?>>Procuração</option>				
										<option value="Escritura" <?php echo $dadosAnexo['tipoImovelAnexo'] == "Escritura" ? '/SELECTED/' : '';?>>Escritura</option>				
										<option value="Matrícula" <?php echo $dadosAnexo['tipoImovelAnexo'] == "Matrícula" ? '/SELECTED/' : '';?>>Matrícula</option>				
										<option value="Parecer Ambiental" <?php echo $dadosAnexo['tipoImovelAnexo'] == "Parecer Ambiental" ? '/SELECTED/' : '';?>>Parecer Ambiental</option>				
										<option value="Projeto Edificação" <?php echo $dadosAnexo['tipoImovelAnexo'] == "Projeto Edificação" ? '/SELECTED/' : '';?>>Projeto Edificação</option>				
										<option value="Boletos" <?php echo $dadosAnexo['tipoImovelAnexo'] == "Boletos" ? '/SELECTED/' : '';?>>Boletos</option>				
										<option value="Outros Documentos" <?php echo $dadosAnexo['tipoImovelAnexo'] == "Outros Documentos" ? '/SELECTED/' : '';?>>Outros Documentos</option>				
									</select>
									<label style="color:#666; font-size:12px; text-align:center; font-weight:normal;">Cliente: <?php echo $dadosCliente['nomeCliente'];?></label>
									<label class="excluir" style="display:table; margin:0 auto; margin-top:10px; cursor:pointer;"><input style="cursor:pointer;" type="checkbox" name="excluir<?php echo $cont; ?>" value="<?php echo $dadosAnexo['codImovelAnexo']; ?>" />Excluir</label>
								</div>				
				
<?php
					$cont = $cont + 1;
				}
?>
								<br class="clear"/>
								<input type="hidden" name="cont" value="<?php echo $cont; ?>" />
<?php
				if($cont > 0){
?>			
								<p class="bloco-campo"><input class="apagar" type="submit" style="margin-top:26px; background-color:#31625E; padding:5px; border:none; color:#FFF;" name="apagar" title="Apagar Imagens" value="Excluir" />
<?php
				}
?>	
							</div>
						</form>
						<script>
							function tipoSubmit(cod, tipo){
								document.getElementById("tipo-anexo").value=tipo;
								document.getElementById("cod-anexo").value=cod;
								document.getElementById("submit2").submit();
							}
						</script>
						<form id="submit2" action="<?php echo $configUrlGer; ?>cadastros/imoveis/anexos/<?php echo $url[6]; ?>/1/" method="post">
							<input type="hidden" value="" name="tipo-anexo" id="tipo-anexo"/>
							<input type="hidden" value="" name="cod-anexo" id="cod-anexo"/>
						</form>
					</div>
					<br class="clear" />
					<br/>
 <?php
				if($erro == "ok"){
					$_SESSION['erroDados'] = ""; 
					
					
				}
				
				$regPorPag = 30;
				$area = "cadastros/imoveis/anexos/".$url[6];
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
