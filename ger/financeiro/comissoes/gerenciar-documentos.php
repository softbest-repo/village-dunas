<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "comissoes";
			if(validaAcesso($conn, $area) == "ok"){

				$_SESSION['nome'] = "";
			
				$sqlNomeComissao = "SELECT * FROM comissoes WHERE codAgrupadorComissao = '".$url[6]."' LIMIT 0,1";
				$resultNomeComissao = $conn->query($sqlNomeComissao);
				$dadosNomeComissao = $resultNomeComissao->fetch_assoc();

				$sqlBairro = "SELECT * FROM bairros WHERE codBairro = ".$dadosNomeComissao['codBairro']." LIMIT 0,1";
				$resultBairro = $conn->query($sqlBairro);
				$dadosBairro = $resultBairro->fetch_assoc();				
				
				$sqlQuadra = "SELECT * FROM quadras WHERE codQuadra = ".$dadosNomeComissao['codQuadra']." LIMIT 0,1";
				$resultQuadra = $conn->query($sqlQuadra);
				$dadosQuadra = $resultQuadra->fetch_assoc();				
				
				$sqlLote = "SELECT * FROM lotes WHERE codLote = ".$dadosNomeComissao['codLote']." LIMIT 0,1";
				$resultLote = $conn->query($sqlLote);
				$dadosLote = $resultLote->fetch_assoc();
										
				if($dadosNomeComissao['codComissao'] == ""){		

					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/comissoes/'>";
					
				}else{				
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Comissões</p>
						<p class="flexa"></p>
						<p class="nome-lista">Anexos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Loteamento: <?php echo $dadosBairro['nomeBairro'] ;?> - Quadra: <?php echo $dadosQuadra['nomeQuadra'];?> - Lote: <?php echo $dadosLote['nomeLote'];?></p>
						<br class="clear" />
					</div>
					<div class="botao-consultar"><a title="Consultar Comissões" href="<?php echo $configUrl;?>financeiro/comissoes/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">

<?php
					if(isset($_POST['apagar'])){
						
						if($_POST['cont'] >  0){
							
							for($i=0; $i<=$_POST['cont']; $i++){
								$contadorDel = "excluir".$i;
								if(isset($_POST[$contadorDel])){
									$sqlConsultaDelete = "SELECT * FROM comissoesAnexos WHERE codComissaoAnexo = ".$_POST[$contadorDel];
									$resultConsultaDelete = $conn->query($sqlConsultaDelete);
									$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
									
									$sqlDelete = "DELETE FROM comissoesAnexos WHERE codComissaoAnexo = ".$_POST[$contadorDel];
									$resultDelete = $conn->query($sqlDelete);
									if(file_exists("f/comissoesAnexo/".$dadosConsultaDelete['codAgrupadorComissao']."-".$dadosConsultaDelete['codComissaoAnexo']."-O.".$dadosConsultaDelete['extComissaoAnexo'])){
										unlink("f/comissoesAnexo/".$dadosConsultaDelete['codAgrupadorComissao']."-".$dadosConsultaDelete['codComissaoAnexo']."-O.".$dadosConsultaDelete['extComissaoAnexo']);								
									}
								
									if($resultDelete == 1){
										$noErros = "ok";
									}
								}
							}
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

					if($usuario == "A"){
?>				
						<div id="carregamento-upload" style="display:none;">
							<p class="texto">Carregando...</p>
						</div>
						<style>
							#carregamento-upload {width:300px; height:200px; position:fixed; z-index:100; left:50%; margin-left:-150px; top:50%; margin-top:-100px; background-color:#FFF; box-shadow:0px 0px 10px -3px #000; border:1px solid #ccc; border-radius:10px;}
							#carregamento-upload .texto {font-size:16px; color:#666; margin-top:65px; padding-top:50px; font-family:Arial; text-align:center; background:transparent url('<?php echo $configUrl;?>financeiro/comissoes/loading.gif') center top no-repeat;}
						</style>
						<script type="text/javascript">
							function loadingUpload(){
								if(document.getElementById("arquivo").value!=""){
									document.getElementById("carregamento-upload").style.display="block";
								}
							}
						</script>
						<form enctype="multipart/form-data" method="POST" action="<?php echo $configUrl;?>financeiro/comissoes/upload.php" onSubmit="return false loading()">
							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Observação:</label>Todas as extenções são permitdas;<br/>Tamanho recomendado está listado abaixo;<br/>Para cadastrar arquivos, clique em escolher arquivo e selecione um ou mais arquivos e clique em salvar;<br/>Os Arquivos são salvos automaticamente;<br/>Para excluir os arquivos, selecione o arquivo e clique no botão excluir;</p>
							<label class="label" style="font-size:15px; line-height:30px; font-weight:normal; float:left; "><strong>Extensão:</strong> Todas | <strong>Tamanho:</strong> Max 20MB<br/><input style="display:block; margin-right:20px; float:left; padding-top:5px; height:20px;" type="file" class="campo" id="arquivo" name="arquivo[]" multiple="multiple" required /></labeL>
							<p class="bloco-campo-float" style="padding-top:5px;"><label style="padding-bottom:5px;">Corretor ou Gerente: <span class="obrigatorio"> </span></label>
								<select class="campo" id="corretor" name="corretor" required style="width:230px; height:36px;">
									<option value="0">I - Niceto Imobiliária</option>
<?php
						$sqlUsuario = "SELECT U.nomeUsuario, U.codUsuario, CC.linhaComissaoCorretor FROM usuarios U inner join comissoesCorretores CC on U.codUsuario = CC.codUsuario inner join comissoes C on CC.codComissao WHERE C.codAgrupadorComissao = ".$url[6]." GROUP BY U.codUsuario, CC.linhaComissaoCorretor ORDER BY CC.linhaComissaoCorretor ASC";
						$resultUsuario = $conn->query($sqlUsuario);
						while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
									<option value="<?php echo $dadosUsuario['codUsuario'] ;?>" <?php echo $_SESSION['corretor'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuario['linhaComissaoCorretor'];?> - <?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
						}
?>					
								</select>
							</p>
							<div class="botao-expansivel" style="padding-top:32px;"><p class="esquerda-botao"></p><input class="botao" onClick="loadingUpload();" type="submit" name="salvar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div>						
							<input style="float:left;" type="hidden" value="<?php echo $url[6];?>" name="codAgrupadorComissao"/>
							<br class="clear"/>
						</form>
<!--
						Novo Upload de Imagens sem Flash
-->
<?php
					}
?>
						<br/>
						<br/>
						<form action="<?php echo $configUrlGer; ?>financeiro/comissoes/gerenciar-documentos/<?php echo $url[6]; ?>/1/" enctype="multipart/form-data" method="post">						
							<div class="lista-imagens">
<?php
					if($usuario != "A"){
						$filtraUsuarioComissoes = " and codUsuario = ".$_COOKIE['codAprovado'.$cookie]."";
					}
				
					$sqlRegistro = "SELECT count(codComissaoAnexo) registros FROM comissoesAnexos WHERE codAgrupadorComissao = ".$url[6].$filtraUsuarioComissoes."";
					$resultRegistro = $conn->query($sqlRegistro);
					$dadosRegistro = $resultRegistro->fetch_assoc();
					$registros = $dadosRegistro['registros'];
					
					  
					$pagina = $url[7];
					if($pagina == 1 || $pagina == "" ){
						$sqlConsulta = "SELECT * FROM comissoesAnexos WHERE codAgrupadorComissao = ".$url[6].$filtraUsuarioComissoes." ORDER BY codComissaoAnexo ASC LIMIT 0, 14";
						$somaLimite = "14";
						$pgInicio = "0";		
					}else{
						$somaLimite = $pagina * 14;
						$pgInicio = $somaLimite - 14;
						$sqlConsulta = "SELECT * FROM comissoesAnexos WHERE codAgrupadorComissao = ".$url[6].$filtraUsuarioComissoes." ORDER BY codComissaoAnexo ASC LIMIT ".$pgInicio.", 14";
					}

					$resultConsulta = $conn->query($sqlConsulta);
					$cont = 0;
					while($dadosAnexo = $resultConsulta->fetch_assoc()){
						$mostrando = $mostrando + 1;
						
						$sqlUsuario = "SELECT * FROM usuarios U inner join comissoesCorretores CC on U.codUsuario = CC.codUsuario inner join comissoes C on CC.codComissao = C.codComissao WHERE U.codUsuario = ".$dadosAnexo['codUsuario']." and C.codAgrupadorComissao = ".$url[6]." ORDER BY U.codUsuario ASC LIMIT 0,1";
						$resultUsuario = $conn->query($sqlUsuario);
						$dadosUsuario = $resultUsuario->fetch_assoc();
?>
        
								<p class="imagem" style="width:300px; height:170px; overflow:hidden; margin-left:20px; margin-right:20px; margin-top:30px; border:1px solid #ccc; padding:20px;"><a target="_blank" href="<?php echo $configUrlGer;?>f/comissoesAnexo/<?php echo $dadosAnexo['codAgrupadorComissao'].'-'.$dadosAnexo['codComissaoAnexo'].'-O.'.$dadosAnexo['extComissaoAnexo'];?>"><img src="<?php echo $configUrlGer;?>f/i/documento.gif" alt="Anexo Comissao"/></a><br/><strong style="word-break: break-all; display:block; padding-top:10px;"><?php echo $dadosAnexo['nomeComissaoAnexo'];?></strong><strong style="font-weight:normal; padding-bottom:10px; display:block; padding-top:10px;"><?php echo $dadosUsuario['nomeUsuario'] != "" ? $dadosUsuario['linhaComissaoCorretor']." - ".$dadosUsuario['nomeUsuario'] : 'I - Niceto Imobiliária';?></strong>
<?php
						if($filtraUsuarioComissoes == ""){
?>									
									<input type="checkbox" name="excluir<?php echo $cont;?>" value="<?php echo $dadosAnexo['codComissaoAnexo']; ?>" /> Excluir
<?php
						}
?>									
								</p>
				
<?php
						$cont = $cont + 1;
					}
?>
								<input type="hidden" name="cont" value="<?php echo $cont; ?>" />
								<br class="clear"/>
<?php
					if($cont > 0 && $filtraUsuarioComissoes == ""){
?>			
								<p class="bloco-campo"><input class="apagar" type="submit" style="margin-top:26px; background-color:#31625E; padding:5px; border:none; color:#FFF;" name="apagar" title="Apagar Imagens" value="Excluir" />
<?php
					}
?>	

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
					$area = "financeiro/comissoes/gerenciar-documentos/".$url[6];
					include('f/conf/paginacao-imagens.php');
				}
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
