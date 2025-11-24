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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>site/balnearioGaivota/alterar/<?php echo $dadosNomeBalnearioGaivota['codBalnearioGaivota'] ?>/' title='Deseja alterar <?php echo $dadosNomeBalnearioGaivota['nomeBalnearioGaivota'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
						</tr>
					</table>	
					<div class="botao-consultar"><a title="Consultar Balneário Gaivota" href="<?php echo $configUrl;?>site/balnearioGaivota/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['apagar'])){
				
					if($_POST['cont'] >  0){
						
						for($i=0; $i<=$_POST['cont']; $i++){
							$contadorDel = "excluir".$i;
							if(isset($_POST[$contadorDel])){
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
				}

				if($_POST['cod-imagem'] !=  ""){
					$sqlUpdate = "UPDATE balnearioGaivotaImagens SET capaBalnearioGaivotaImagem = 'F' WHERE codBalnearioGaivota = ".$url[6]." and tipoBalnearioGaivotaImagem = 'I'";
					$resultUpdate = $conn->query($sqlUpdate);
					
					$sqlUpdateCapa = "UPDATE balnearioGaivotaImagens SET capaBalnearioGaivotaImagem = 'T' WHERE codBalnearioGaivotaImagem = ".$_POST['cod-imagem']."";
					$resultUpdateCapa = $conn->query($sqlUpdateCapa);
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
							#carregamento-upload .texto {font-size:16px; color:#666; margin-top:65px; padding-top:50px; font-family:Arial; text-align:center; background:transparent url('<?php echo $configUrlGer;?>site/balnearioGaivota/loading.gif') center top no-repeat;}
						</style>
						<script type="text/javascript">
							function loadingUpload(){
								if(document.getElementById("arquivo").value!=""){
									document.getElementById("carregamento-upload").style.display="block";
								}
							}
						</script>
						<form enctype="multipart/form-data" method="POST" action="<?php echo $configUrlGer;?>site/balnearioGaivota/upload.php" onSubmit="return false loading()">
							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Obs:</label>As extensões permitidas estão listadas abaixo;<br/>Tamanho recomendado está listado abaixo;<br/>Para cadastrar imagens, clique em escolher arquivo e selecione uma ou mais imagens e clique em salvar;<br/>As imagens são salvas automaticamente;<br/>Para excluir as imagens, selecione a imagem e clique no botão excluir;</p>
							<label class="label" style="font-size:15px; line-height:30px; font-weight:normal;"><strong>Extensão:</strong> png,jpg ou jpeg | <strong>Tamanho:</strong> 1000 x 600<br/><input style="display:block; margin-right:20px; float:left;" type="file" class="campo" id="arquivo" name="arquivo[]" multiple="multiple" required /></labeL>
							<div class="botao-expansivel" style="padding-top:5px;"><p class="esquerda-botao"></p><input class="botao" onClick="loadingUpload();" type="submit" name="salvar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div>						
							<input style="float:left;" type="hidden" value="<?php echo $url[6];?>" name="codBalnearioGaivota"/>
							<br class="clear"/>
						</form>
<!--
						Novo Upload de Imagens sem Flash
-->
						<br/>
						<br/>
						<form action="<?php echo $configUrlGer; ?>site/balnearioGaivota/imagens/<?php echo $url[6]; ?>/" enctype="multipart/form-data" method="post">
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT * FROM balnearioGaivotaImagens WHERE codBalnearioGaivota = ".$url[6]." and tipoBalnearioGaivotaImagem = 'I'";
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = mysqli_num_rows($resultRegistro);
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM balnearioGaivotaImagens WHERE codBalnearioGaivota = ".$url[6]." and tipoBalnearioGaivotaImagem = 'I' ORDER BY capaBalnearioGaivotaImagem ASC, codBalnearioGaivotaImagem ASC LIMIT 0, 30";
					$somaLimite = "30";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 30;
					$pgInicio = $somaLimite - 30;
					$sqlConsulta = "SELECT * FROM balnearioGaivotaImagens WHERE codBalnearioGaivota = ".$url[6]." and tipoBalnearioGaivotaImagem = 'I' ORDER BY capaBalnearioGaivotaImagem ASC, codBalnearioGaivotaImagem ASC LIMIT ".$pgInicio.", 30";
				}

				$resultConsulta = $conn->query($sqlConsulta);
				$cont = 0;
				while($dadosImagem = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;
?>
        
								<div class="imagem-sem" style="width:180px; float:left; margin-right:20px; margin-bottom:20px; height:160px;"><p class="imagem-pequena" style="width:180px; height:134px; overflow:hidden; margin-bottom:10px;"><img id="imagem-imovel<?php echo $contImagem;?>" src="<?php echo $configUrlGer; ?>f/balnearioGaivota/<?php echo $dadosImagem['codBalnearioGaivota'].'-'.$dadosImagem['codBalnearioGaivotaImagem'].'-P.'.$dadosImagem['extBalnearioGaivotaImagem'];?>" alt="Imagem BalnearioGaivota" width="180"/></p>
								<label class="excluir" style="float:left; cursor:pointer;"><input style="cursor:pointer;" type="checkbox" name="excluir<?php echo $cont; ?>" value="<?php echo $dadosImagem['codBalnearioGaivotaImagem']; ?>" /> Excluir</label>				
								<label class="capa" style="float:right; cursor:pointer;">Capa <input style="cursor:pointer;" type="radio" onClick="capaSubmit(<?php echo $dadosImagem['codBalnearioGaivotaImagem'];?>);" name="capa" value="<?php echo $dadosImagem['codBalnearioGaivotaImagem']; ?>" <?php echo $dadosImagem['capaBalnearioGaivotaImagem'] == 'T' ? 'checked' : '';?>/></label><br class="clear"/></div>				
				
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
					</div>
					<br class="clear" />
					<br/>
 <?php
				if($erro == "ok"){
					$_SESSION['erroDados'] = ""; 
					
					
				}
				
				$regPorPag = 30;
				$area = "site/balnearioGaivota/imagens/".$url[6];
				include('f/conf/paginacao-imagens.php');
?>
					<script>
						function capaSubmit(cod){
							document.getElementById("cod-imagem").value=cod;
							document.getElementById("submit2").submit();
						}
					</script>
					<form id="submit2" action="<?php echo $configUrlGer; ?>site/balnearioGaivota/imagens/<?php echo $url[6]; ?>/1/" method="post">
						<input type="hidden" value="" name="cod-imagem" id="cod-imagem"/>
						<input type="hidden" value="<?php echo $url[6];?>" name="cod-imovel" id="cod-imovel"/>
					</form>
				</div>
				<script>
					function ativeFlash(){
						if(document.getElementById("file_upload").style.width=="120px"){
							document.getElementById("bloco-flash").style.display="none";
						}else{
							document.getElementById("bloco-flash").style.display="block";
						}
					}	
				</script>				
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
