<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "permissoes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){
?>
				<script>
					function selecionaCheck(){
						document.getElementById("input1").style.display="block"; 
						document.getElementById("input2").style.display="none"; 
					   for (i=0;i<document.formPermissao.elements.length;i++) 
						  if(document.formPermissao.elements[i].type == "checkbox")	
							 document.formPermissao.elements[i].checked=1 
					} 
					
					function descelecionaCheck(){ 
						document.getElementById("input1").style.display="none"; 
						document.getElementById("input2").style.display="block"; 	
					   for (i=0;i<document.formPermissao.elements.length;i++) 
						  if(document.formPermissao.elements[i].type == "checkbox")	
							 document.formPermissao.elements[i].checked=0 
					} 
				</script>
<?php
				$sqlUsuario = "SELECT codUsuario, nomeUsuario FROM usuarios WHERE codUsuario = ".$url[6]." LIMIT 0,1";
				$resultUsuario = $conn->query($sqlUsuario);
				$dadosUsuario = $resultUsuario->fetch_assoc();
				
				if(isset($_POST['salvar'])){
					$sqlDeletaPermissoes = "DELETE FROM areaUsuario WHERE codUsuario = ".$url[6];
					$resultDeletaPermissoes = $conn->query($sqlDeletaPermissoes);
					
					for($i=0; $i<$_POST['totalItens']; $i++){
						$id_post = "acesso-".$i;
						if($_POST[$id_post] != ""){
							$sqlInserePermicao = "INSERT INTO areaUsuario VALUES (0, ".$url[6].", ".$_POST[$id_post].")";
							$resultInserePermicao = $conn->query($sqlInserePermicao);
						}
					}
					$erroPermissao = "<p class='erro'><strong>Permissões cadastradas com sucesso!</strong></p>";
				}	
?>
				<div id="filtro">			
					<div id="localizacao-filtro">
						<p class="nome-lista">Configurações</p>
						<p class="flexa"></p>
						<p class="nome-lista">Permissões</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosUsuario['nomeUsuario'];?></p>
						<br class="clear" />
					</div>
					<div class="botao-novo"><a title="Voltar para configurações" href="<?php echo $configUrl;?>configuracoes/permissoes/"><div class="esquerda-novo"></div><div class="conteudo-novo"><< Voltar</div><div class="direita-novo"></div></a></div>
					<br class="clear" />					
				</div>
				<div id="dados-conteudo">
<?php
				if($erroPermissao != ""){
?>
					<div class="area-erro">
					<?php echo $erroPermissao;?>
					</div>
<?php
					$erroPermissao = "";
				}
?>
					<div id="permicoes">
						<p class="titulo-area-sistema">Áreas sistema:</p>
						<p style="float:left; color:#718B8F; margin-bottom:20px; margin-right:5px; font-weight:bold;">Selecionar Todos:</p> 
						<div style="float:left;"><p style="display:none; cursor:pointer;" id="input1" onClick="descelecionaCheck()"><img src="<?php echo $configUrl;?>f/i/selecionado.png"/></p><p style="cursor:pointer;" id="input2" onClick="selecionaCheck()"><img  src="<?php echo $configUrl;?>f/i/descelecionado.png"/></p></div>
						<br class="clear"/>		
						<form name="formPermissao" action="<?php echo $configUrl;?>configuracoes/permissoes/detalhes/<?php echo $url[6];?>/" method="post" >
							<div id="permissoes-atendimento" style="width:270px; height:370px;">
								<p class="area-permicao">Site:</p>
<?php		
				$numero = 1;
				
				$sqlAreasAtendimento = "SELECT * FROM areasAcesso WHERE codMenuAreaAcesso = 1 and statusAreaAcesso = 'T' ORDER BY codAreaAcesso ASC";
				$resultAreasAtendimento = $conn->query($sqlAreasAtendimento);
				while($dadosAreasAtendimento = $resultAreasAtendimento->fetch_assoc()){

					$sqlAreaCadastrada = "SELECT * FROM areaUsuario WHERE codUsuario = ".$url[6];
					$resultAreaCadastrada = $conn->query($sqlAreaCadastrada);
					while($dadosAreaCadastrada = $resultAreaCadastrada->fetch_assoc()){	
						if($dadosAreasAtendimento['codAreaAcesso'] == $dadosAreaCadastrada['codAreaAcesso']){
							$check = $dadosAreasAtendimento['codAreaAcesso'];
						}
					}
?>								
								<div class="bloco-permissoes">
									<p class="nome-area"><label><input type="checkbox" name="acesso-<?php echo $numero;?>" value="<?php echo $dadosAreasAtendimento['codAreaAcesso'];?>"  <?php echo $check == $dadosAreasAtendimento['codAreaAcesso'] ? '/checked/' : '';?>/> <?php echo $dadosAreasAtendimento['nomeAreaAcesso'];?></label></p>
								</div>
<?php
					$numero++;
				}
?>								
								<br class="clear" />
							</div>
							<div id="permissoes-atendimento" style="width:270px; height:370px;">
								<p class="area-permicao">Cadastros:</p>
<?php						
				$sqlAreasAtendimento = "SELECT * FROM areasAcesso WHERE codMenuAreaAcesso = 2 and statusAreaAcesso = 'T' ORDER BY codAreaAcesso ASC";
				$resultAreasAtendimento = $conn->query($sqlAreasAtendimento);
				while($dadosAreasAtendimento = $resultAreasAtendimento->fetch_assoc()){

					$sqlAreaCadastrada = "SELECT * FROM areaUsuario WHERE codUsuario = ".$url[6];
					$resultAreaCadastrada = $conn->query($sqlAreaCadastrada);
					while($dadosAreaCadastrada = $resultAreaCadastrada->fetch_assoc()){	
						if($dadosAreasAtendimento['codAreaAcesso'] == $dadosAreaCadastrada['codAreaAcesso']){
							$check = $dadosAreasAtendimento['codAreaAcesso'];
						}
					}
?>								
								<div class="bloco-permissoes">
									<p class="nome-area"><label><input type="checkbox" name="acesso-<?php echo $numero;?>" value="<?php echo $dadosAreasAtendimento['codAreaAcesso'];?>"  <?php echo $check == $dadosAreasAtendimento['codAreaAcesso'] ? '/checked/' : '';?>/> <?php echo $dadosAreasAtendimento['nomeAreaAcesso'];?></label></p>
								</div>
<?php
					$numero++;
				}
?>								
								<br class="clear" />
							</div>
							<div id="permissoes-atendimento" style="width:270px; height:370px;">
								<p class="area-permicao">Comercial:</p>
<?php						
				$sqlAreasAtendimento = "SELECT * FROM areasAcesso WHERE codMenuAreaAcesso = 3 and statusAreaAcesso = 'T' ORDER BY codAreaAcesso ASC";
				$resultAreasAtendimento = $conn->query($sqlAreasAtendimento);
				while($dadosAreasAtendimento = $resultAreasAtendimento->fetch_assoc()){

					$sqlAreaCadastrada = "SELECT * FROM areaUsuario WHERE codUsuario = ".$url[6];
					$resultAreaCadastrada = $conn->query($sqlAreaCadastrada);
					while($dadosAreaCadastrada = $resultAreaCadastrada->fetch_assoc()){	
						if($dadosAreasAtendimento['codAreaAcesso'] == $dadosAreaCadastrada['codAreaAcesso']){
							$check = $dadosAreasAtendimento['codAreaAcesso'];
						}
					}
?>								
								<div class="bloco-permissoes">
									<p class="nome-area"><label><input type="checkbox" name="acesso-<?php echo $numero;?>" value="<?php echo $dadosAreasAtendimento['codAreaAcesso'];?>"  <?php echo $check == $dadosAreasAtendimento['codAreaAcesso'] ? '/checked/' : '';?>/> <?php echo $dadosAreasAtendimento['nomeAreaAcesso'];?></label></p>
								</div>
<?php
					$numero++;
				}
?>								
								<br class="clear" />
							</div>
							<div id="permissoes-atendimento" style="width:270px; height:370px;">
								<p class="area-permicao">Financeiro:</p>
<?php						
				$sqlAreasAtendimento = "SELECT * FROM areasAcesso WHERE codMenuAreaAcesso = 4 and statusAreaAcesso = 'T' ORDER BY codAreaAcesso ASC";
				$resultAreasAtendimento = $conn->query($sqlAreasAtendimento);
				while($dadosAreasAtendimento = $resultAreasAtendimento->fetch_assoc()){

					$sqlAreaCadastrada = "SELECT * FROM areaUsuario WHERE codUsuario = ".$url[6];
					$resultAreaCadastrada = $conn->query($sqlAreaCadastrada);
					while($dadosAreaCadastrada = $resultAreaCadastrada->fetch_assoc()){	
						if($dadosAreasAtendimento['codAreaAcesso'] == $dadosAreaCadastrada['codAreaAcesso']){
							$check = $dadosAreasAtendimento['codAreaAcesso'];
						}
					}
?>								
								<div class="bloco-permissoes">
									<p class="nome-area"><label><input type="checkbox" name="acesso-<?php echo $numero;?>" value="<?php echo $dadosAreasAtendimento['codAreaAcesso'];?>"  <?php echo $check == $dadosAreasAtendimento['codAreaAcesso'] ? '/checked/' : '';?>/> <?php echo $dadosAreasAtendimento['nomeAreaAcesso'];?></label></p>
								</div>
<?php
					$numero++;
				}
?>								
								<br class="clear" />
							</div>
							<div id="permissoes-atendimento" style="width:270px; height:370px;">
								<p class="area-permicao">Relatórios:</p>
<?php						
				$sqlAreasAtendimento = "SELECT * FROM areasAcesso WHERE codMenuAreaAcesso = 5 and statusAreaAcesso = 'T' ORDER BY codAreaAcesso ASC";
				$resultAreasAtendimento = $conn->query($sqlAreasAtendimento);
				while($dadosAreasAtendimento = $resultAreasAtendimento->fetch_assoc()){

					$sqlAreaCadastrada = "SELECT * FROM areaUsuario WHERE codUsuario = ".$url[6];
					$resultAreaCadastrada = $conn->query($sqlAreaCadastrada);
					while($dadosAreaCadastrada = $resultAreaCadastrada->fetch_assoc()){	
						if($dadosAreasAtendimento['codAreaAcesso'] == $dadosAreaCadastrada['codAreaAcesso']){
							$check = $dadosAreasAtendimento['codAreaAcesso'];
						}
					}
?>								
								<div class="bloco-permissoes">
									<p class="nome-area"><label><input type="checkbox" name="acesso-<?php echo $numero;?>" value="<?php echo $dadosAreasAtendimento['codAreaAcesso'];?>"  <?php echo $check == $dadosAreasAtendimento['codAreaAcesso'] ? '/checked/' : '';?>/> <?php echo $dadosAreasAtendimento['nomeAreaAcesso'];?></label></p>
								</div>
<?php
					$numero++;
				}
?>								
								<br class="clear" />
							</div>
							<div id="permissoes-site">
								<p class="area-permicao">Configurações:</p>
<?php
				$sqlAreasRelatorios = "SELECT * FROM areasAcesso WHERE codMenuAreaAcesso = 6 and statusAreaAcesso = 'T' ORDER BY codAreaAcesso ASC";
				$resultAreasRelatorios = $conn->query($sqlAreasRelatorios);
				while($dadosAreasRelatorios = $resultAreasRelatorios->fetch_assoc()){

					$sqlAreaCadastrada = "SELECT * FROM areaUsuario WHERE codUsuario = ".$url[6];
					$resultAreaCadastrada = $conn->query($sqlAreaCadastrada);
					while($dadosAreaCadastrada = $resultAreaCadastrada->fetch_assoc()){	
						if($dadosAreasRelatorios['codAreaAcesso'] == $dadosAreaCadastrada['codAreaAcesso']){
							$check = $dadosAreasRelatorios['codAreaAcesso'];
						}
					}
?>								
								<div class="bloco-permissoes">
									<p class="nome-area"><label><input type="checkbox" name="acesso-<?php echo $numero;?>" value="<?php echo $dadosAreasRelatorios['codAreaAcesso'];?>" <?php echo $check == $dadosAreasRelatorios['codAreaAcesso'] ? '/checked/' : '';?> /> <?php echo $dadosAreasRelatorios['nomeAreaAcesso'];?></label></p>
								</div>

<?php
					$numero++;
				}
		
				$totalItens = $numero;
?>								
								<br class="clear" />
							</div>
							<br class="clear"/>							
							<input type="hidden" name="totalItens" value="<?php echo $totalItens;?>" />
							<br/>
							<br/>
							<br/>
							<p class="bloco-campo"><div class="botao-expansivel"  style="margin-left:20px;"><p class="esquerda-botao"></p><input class="botao" type="submit" name="salvar" title="Salvar Permissões" value="Salvar Permissões" onClick="enviar()" /><p class="direita-botao"></p></div></p>						
							<br class="clear" />
						</form>
					</div>
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
