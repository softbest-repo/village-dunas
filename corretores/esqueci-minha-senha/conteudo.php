<?php
	if($_POST['email'] != ""){
		$sqlEsqueci = "SELECT * FROM corretores WHERE emailCorretor = '".$_POST['email']."' LIMIT 0,1";
		$resultEsqueci = $conn->query($sqlEsqueci);
		$dadosEsqueci = $resultEsqueci->fetch_assoc(); 
		
		if($dadosEsqueci['codCorretor'] != ""){
			if($dadosEsqueci['statusCorretor'] == 'T'){

				require 'vendor/autoload.php';

				$token = $_POST['token'];
				$action = $_POST['action'];
				
				$url = 'https://www.google.com/recaptcha/api/siteverify';
				$data = array(
					'secret' => $chaveSecreta,
					'response' => $token
				);
				  
				// call curl to POST request
				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt($ch, CURLOPT_POST, true);
				curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
				$response = curl_exec($ch);
				curl_close($ch);
				$arrResponse = json_decode($response, true);
				  
				if($arrResponse["success"] == true && $arrResponse["score"] >= 0.5){
								
					$assunto = "Sua senha recuperada";

					$sqlEmail = "SELECT * FROM emails WHERE statusEmail = 'T' LIMIT 0,1";
					$resultEmail = $conn->query($sqlEmail);
					$dadosEmail = $resultEmail->fetch_assoc();

					$emailRemetente = $dadosEmail['enderecoEmail'];
					$senhaRemetente = $dadosEmail['senhaEmail'];

					$mailer = new PHPMailer\PHPMailer\PHPMailer();
					$mailer->IsSMTP();
					$mailer->SMTPDebug = 0;
					$mailer->Port = 587;			 
					$mailer->Host = $hostEmail;
					$mailer->SMTPAuth = true;
					$mailer->Username = $emailRemetente;
					$mailer->Password = $senhaRemetente;
					$mailer->IsHTML(true);
					$mailer->CharSet = 'utf-8';

					$nomeRemetente = $nomeEmpresaMenor;
					$nomeDestino = $nomeEmpresaMenor;
					$emailDestino = $dadosEsqueci['emailCorretor'];
					
					$nomeCorretor = $dadosEsqueci['nomeCorretor'];
					$emailCorretor = $dadosEsqueci['emailCorretor'];
					$senhaCorretor = $dadosEsqueci['senhaCorretor'];

					include ('corpo-email-esqueci.php');

					$mailer->setFrom($emailRemetente, $nomeRemetente);
					$mailer->AddAddress($emailDestino, $nomeDestino);
					$mailer->Subject = $assunto;
					$mailer->Body = $conteudoEmailCliente;
					$mailer->Send();
					$mailer->ClearAllRecipients();
					$mailer->ClearAttachments();
					
					$backgroundColor = "background-color:#00b816;";
					$erro = "<p class='erro'>Sua senha foi recuperada com sucesso e enviada ao seu e-mail!</p>";
					
					$_SESSION['email'] = "";
					
				}else{
					$erro = "<p class='erro'>Problemas ao verificar Captcha, atualize a página e tente novamente!</p>";
					$_SESSION['email'] = $_POST['email'];
				}		
				
			}else{
				$backgroundColor = "background-color:#FF0000;";
				$erro = "<p class='erro'>Sua conta foi desativada, para mais informações entre em contato!</p>";
				$_SESSION['email'] = $_POST['email'];
			}
		}else{
			$backgroundColor = "background-color:#FF0000;";
			$_SESSION['email'] = $_POST['email'];
			$erro = "<p class='erro'>Seu e-mail não consta em nossos registros!</p>";
		}
	}
?>
				<div id="conteudo-interno">
					<div id="bloco-titulo">
						<p class="botao-topo" style="margin-top:8px;"><a href="<?php echo $configUrl;?>login/"> Voltar para o Login</a></p>
						<p class="titulo">Esqueci minha Senha</p>
					</div>
					<div id="conteudo-esqueci-minha-senha">
						<div id="erro" style="<?php echo $backgroundColor;?> <?php echo $erro == "" ? 'display:none;' : 'display:table;';?>"><?php echo $erro;?></div>
						<p class="titulo-area">Digite seu e-mail para recuperar a sua senha</p>
						<div id="alinha">
							<form id="targetForm" name="esqueci" action="<?php echo $configUrl;?>esqueci-minha-senha/" method="post">
								<div id="form">
									<p class="campo-padrao"><input class="input" type="email" placeholder="E-mail" required value="<?php echo $_SESSION['email'];?>" id="email" name="email" /></p>	
														
									<p class="campo-enviar">
										<input class="botao" type="submit" value="Recuperar minha Senha" name="recuperar" />
									</p>
								</div>
								<script>
									var $tg = jQuery.noConflict();
									$tg('#targetForm').submit(function(event) {
										event.preventDefault();
										var email = $tg('#email').val();
								  
										grecaptcha.ready(function() {
											grecaptcha.execute('<?php echo $chaveSite;?>', {action: 'action_form'}).then(function(token) {
												$tg('#targetForm').prepend('<input type="hidden" name="token" value="' + token + '">');
												$tg('#targetForm').prepend('<input type="hidden" name="action" value="action_form">');
												$tg('#targetForm').unbind('submit').submit();
											});
										});
								  });
							  </script>	
							</form>
						</div>
					</div>
				</div>	
