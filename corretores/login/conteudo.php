<?php
	if($_COOKIE['codAprovado'.$cookie] == ""){

		if(isset($_POST['entrar'])){
			
			$contLogou = "";
			
			$sqlConsultaLogin = "SELECT * FROM corretores ORDER BY codCorretor DESC";
			$resultConsultaLogin = $conn->query($sqlConsultaLogin);
			while($dadosConsultaLogin = $resultConsultaLogin->fetch_assoc()){
			
				if(strtolower(trim($dadosConsultaLogin['emailCorretor'])) == strtolower(trim($_POST['emailLogin'])) && trim($dadosConsultaLogin['senhaCorretor']) == trim($_POST['senhaLogin'])){
					
					if($dadosConsultaLogin['statusCorretor'] == 'T'){
						setcookie("codAprovado".$cookie, $dadosConsultaLogin['codCorretor'], time()+86400, "/");		
						
						$contLogou = "ok";
						
						$sqlHistorico = "INSERT INTO historico VALUES(0, ".$dadosConsultaLogin['codCorretor'].", 'Login realizado', '".date('Y-m-d H:i:s')."', 'T')";
						$resultHistorico = $conn->query($sqlHistorico);
						
						if($_SESSION['voltaMapa'] != ""){
							$voltaMapa = $_SESSION['voltaMapa'];
							$_SESSION['voltaMapa'] = "";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."loteamentos/mapas/index.php?loteamento=".$voltaMapa."'>";								
						}else
						if($_SESSION['voltar'] != ""){
							$voltar = $_SESSION['voltar'];
							$_SESSION['voltar'] = "";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl.$voltar."'>";						
						}else{
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."'>";
						}
						break;
					}else{
						$contLogou = "status";
						break;						
					}
				}
			}
			
			if($contLogou == "ok"){
				$erro = "<p class='erro'>Login realizado com sucesso. Aguarde...</p>";
				$backgroundColor = "background-color:#00b816;";
				$_SESSION['emailLogin'] = "";
				$_SESSION['senhaLogin'] = "";
			}else
			if($contLogou == ""){
				$_SESSION['emailLogin'] = $_POST['emailLogin'];
				$_SESSION['senhaLogin'] = $_POST['senhaLogin'];
				$erro = "<p class='erro'>E-mail ou Senha incorretos!</p>";			
				$backgroundColor = "background-color:#FF0000;";
			}else
			if($contLogou == "status"){
				$erro = "<p class='erro'>Seu cadastro está desativado! Entre em contato conosco!</p>";
				$backgroundColor = "background-color:#FF0000;";
				$_SESSION['emailLogin'] = "";
				$_SESSION['senhaLogin'] = "";			
			}
		}else{
			$_SESSION['emailLogin'] = "";
			$_SESSION['senhaLogin'] = "";
		}
?>
							<div id="conteudo-interno">
								<div id="bloco-titulo">
									<p class="titulo">Login</p>
								</div>
								<div id="erro" style="<?php echo $backgroundColor;?> <?php echo $erro == "" ? 'display:none;' : 'display:table;';?>"><?php echo $erro;?></div>
								<div id="conteudo-login">
									<div id="mostra-login">
										<form action="<?php echo $configUrl;?>login/" method="post">
											<p class="campo-email"><input type="email" value="" placeholder="E-mail" name="emailLogin" required/></p>
											<p class="campo-senha"><input type="password" value="" placeholder="Senha"  name="senhaLogin" required/></p>
											<p class="botao-entrar"><input type="submit" value="Entrar" name="entrar"/></p>
											<p class="esqueci-minha-senha"><a href="<?php echo $configUrl;?>esqueci-minha-senha/">Esqueci Minha Senha</a></p>
										</form>
									</div>
								</div>
							</div>
<?php
	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/'>";
	}
?>
