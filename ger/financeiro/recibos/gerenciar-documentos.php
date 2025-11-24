<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "recibos";
			if(validaAcesso($conn, $area) == "ok"){
				
				$_SESSION['nome'] = "";
				$sqlNomeRecibo = "SELECT * FROM recibos WHERE codRecibo = '".$url[6]."'";
				$resultNomeRecibo = $conn->query($sqlNomeRecibo);
				$dadosNomeRecibo = $resultNomeRecibo->fetch_assoc();			
?>	
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Recibos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Gerenciar Documentos</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeRecibo['nomeRecibo'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomeRecibo['statusRecibo'] == "T"){
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
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>financeiro/recibos/alterar/<?php echo $dadosNomeRecibo['codRecibo'] ?>/' title='Deseja alterar o documento <?php echo $dadosNomeRecibo['nomeRecibo'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar-branco.gif" alt="icone" /></a></td>
						</tr>
					</table>	
					<div class="botao-consultar"><a title="Consultar Recibos" href="<?php echo $configUrl;?>financeiro/recibos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">

<?php
				if(isset($_POST['apagar'])){
					
					if($_POST['cont'] >  0){
						
						for($i=0; $i<=$_POST['cont']; $i++){
							$contadorDel = "excluir".$i;
							if(isset($_POST[$contadorDel])){
								$sqlConsultaDelete = "SELECT * FROM recibosAnexos WHERE codReciboAnexo = ".$_POST[$contadorDel];
								$resultConsultaDelete = $conn->query($sqlConsultaDelete);
								$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();
								
								$sqlDelete = "DELETE FROM recibosAnexos WHERE codReciboAnexo = ".$_POST[$contadorDel];
								$resultDelete = $conn->query($sqlDelete);
								if(file_exists("f/recibosAnexo/".$dadosConsultaDelete['codRecibo']."-".$dadosConsultaDelete['codReciboAnexo']."-O.".$dadosConsultaDelete['extReciboAnexo'])){
									unlink("f/recibosAnexo/".$dadosConsultaDelete['codRecibo']."-".$dadosConsultaDelete['codReciboAnexo']."-O.".$dadosConsultaDelete['extReciboAnexo']);								
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
?>				
						<div id="carregamento-upload" style="display:none;">
							<p class="texto">Carregando...</p>
						</div>
						<style>
							#carregamento-upload {width:300px; height:200px; position:fixed; z-index:100; left:50%; margin-left:-150px; top:50%; margin-top:-100px; background-color:#FFF; box-shadow:0px 0px 10px -3px #000; border:1px solid #ccc; border-radius:10px;}
							#carregamento-upload .texto {font-size:16px; color:#666; margin-top:65px; padding-top:50px; font-family:Arial; text-align:center; background:transparent url('<?php echo $configUrl;?>financeiro/recibos/loading.gif') center top no-repeat;}
						</style>
						<script type="text/javascript">
							function loadingUpload(){
								if(document.getElementById("arquivo").value!=""){
									document.getElementById("carregamento-upload").style.display="block";
								}
							}
						</script>
						<form enctype="multipart/form-data" method="POST" action="<?php echo $configUrl;?>financeiro/recibos/upload.php" onSubmit="return false loading()">
							<p class="aviso" style="color:#718B8F; margin-bottom:20px; font-size:15px;"><label style="color:#FF0000;">Observação:</label>Todas as extenções são permitdas;<br/>Tamanho recomendado está listado abaixo;<br/>Para cadastrar arquivos, clique em escolher arquivo e selecione um ou mais arquivos e clique em salvar;<br/>Os Arquivos são salvos automaticamente;<br/>Para excluir os arquivos, selecione o arquivo e clique no botão excluir;</p>
							<label class="label" style="font-size:15px; line-height:30px; font-weight:normal;"><strong>Extensão:</strong> Todas | <strong>Tamanho:</strong> Max 20MB<br/><input style="display:block; margin-right:20px; float:left; padding-top:5px; height:27px;" type="file" class="campo" id="arquivo" name="arquivo[]" multiple="multiple" required /></labeL>
							<div class="botao-expansivel" style="padding-top:3px;"><p class="esquerda-botao"></p><input class="botao" onClick="loadingUpload();" type="submit" name="salvar" title="Salvar" value="Salvar" /><p class="direita-botao"></p></div>						
							<input style="float:left;" type="hidden" value="<?php echo $url[6];?>" name="codRecibo"/>
							<br class="clear"/>
						</form>
<!--
						Novo Upload de Imagens sem Flash
-->
						<br/>
						<br/>
						<form action="<?php echo $configUrlGer; ?>financeiro/recibos/gerenciar-documentos/<?php echo $url[6]; ?>/1/" enctype="multipart/form-data" method="post">						
							<div class="lista-imagens">
<?php
				$sqlRegistro = "SELECT count(codReciboAnexo) registros FROM recibosAnexos WHERE codRecibo = ".$url[6];
				$resultRegistro = $conn->query($sqlRegistro);
				$dadosRegistro = $resultRegistro->fetch_assoc();
				$registros = $dadosRegistro['registros'];
				
				  
				$pagina = $url[7];
				if($pagina == 1 || $pagina == "" ){
					$sqlConsulta = "SELECT * FROM recibosAnexos WHERE codRecibo = ".$url[6]." ORDER BY codReciboAnexo ASC LIMIT 0, 14";
					$somaLimite = "14";
					$pgInicio = "0";		
				}else{
					$somaLimite = $pagina * 14;
					$pgInicio = $somaLimite - 14;
					$sqlConsulta = "SELECT * FROM recibosAnexos WHERE codRecibo = ".$url[6]." ORDER BY codReciboAnexo ASC LIMIT ".$pgInicio.", 14";
				}

				$resultConsulta = $conn->query($sqlConsulta);
				$cont = 0;
				while($dadosAnexo = $resultConsulta->fetch_assoc()){
					$mostrando = $mostrando + 1;
?>
        
								<p class="imagem" style="width:200px; height:170px; overflow:hidden; margin-left:20px; margin-right:20px; margin-top:30px;"><a target="_blank" href="<?php echo $configUrlGer;?>f/recibosAnexo/<?php echo $dadosAnexo['codRecibo'].'-'.$dadosAnexo['codReciboAnexo'].'-O.'.$dadosAnexo['extReciboAnexo'];?>"><img src="<?php echo $configUrlGer;?>f/i/documento.gif" alt="Anexo Recibo"/></a><br/><br/><strong><?php echo $dadosAnexo['nomeReciboAnexo'];?></strong><br/><br/>
								<input type="checkbox" name="excluir<?php echo $cont;?>" value="<?php echo $dadosAnexo['codReciboAnexo']; ?>" /> Excluir</p>
				
<?php
					$cont = $cont + 1;
				}
?>
								<input type="hidden" name="cont" value="<?php echo $cont; ?>" />
								<br class="clear"/>
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
				
				$regPorPag = 14;
				$area = "financeiro/recibos/gerenciar-recibos/".$url[6];
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
