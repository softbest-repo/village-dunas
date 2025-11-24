<?php
ob_start();
session_start();
date_default_timezone_set('America/Sao_Paulo');
include ('f/conf/config.php');
if($_COOKIE['loginAprovado'.$cookie] == ""){
	
	if(date("H:i:s") < "12:00:00"){
		$turno = "manha";
	}else
	if(date("H:i:s") > "12:00:00"){
		$turno = "tarde";
	}else
	if(date("H:i:s") > "18:00:00"){
		$turno = "extra";
	}
			
	if($turno == "manha"){
		$saida = "12:00:00";
	}else{
		$saida = "18:00:00";
	}
	
	if(isset($_POST['entrar'])){
		$sqlLogin = "SELECT codUsuario, nomeUsuario, sobrenomeUsuario, usuarioUsuario, senhaUsuario FROM usuarios WHERE statusUsuario = 'T'";
		$resultLogin = $conn->query($sqlLogin);
		while($dadosLogin = $resultLogin->fetch_assoc()){
			if($dadosLogin['usuarioUsuario'] == $_POST['usuarioLogin'] && $dadosLogin['senhaUsuario'] == base64_encode($_POST['senhaLogin'])){
				setcookie("loginAprovado".$cookie, $dadosLogin['nomeUsuario'], time()+39600,"/");
				setcookie("codAprovado".$cookie, $dadosLogin['codUsuario'], time()+39600,"/");
				
				$codUsuario = $dadosLogin['codUsuario'];
				
				$sqlSeleciona = "SELECT * FROM usuarioPonto WHERE diaPonto = ".date("d")." and mesPonto = ".date("m")." and anoPonto = ".date("Y")." and codUsuario = ".$codUsuario;
				$resultSeleciona = $conn->query($sqlSeleciona);
				$dadosSeleciona = $resultSeleciona->fetch_assoc();
				if($dadosSeleciona['codPonto'] != ""){
					$sqlTurno = "SELECT * FROM pontoTurno WHERE codPonto = ".$dadosSeleciona['codPonto']." and tipoTurno = '".$turno."'";
					$resultTurno = $conn->query($sqlTurno);
					$dadosTurno = $resultTurno->fetch_assoc();
					if($dadosTurno['codTurno'] != ""){
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."controle-acesso.php'>";
					}else{
						$sqlCadastraTurno = "INSERT INTO pontoTurno VALUES (0, ".$dadosSeleciona['codPonto'].", '".date("H:i:s")."', '".$saida."', '".$turno."')";
						$resultCadastraTurno = $conn->query($sqlCadastraTurno);
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."controle-acesso.php'>";
					}
					
							
				}else{
					$sqlPonto = "INSERT INTO usuarioPonto VALUES (0, ".$codUsuario.", ".date("d").", ".date("m").", ".date("Y").")";
					$resultPonto = $conn->query($sqlPonto);
					
					$sqlSelecionaNovo = "SELECT * FROM usuarioPonto WHERE diaPonto = ".date("d")." and mesPonto = ".date("m")." and anoPonto = ".date("Y")." and codUsuario = ".$codUsuario;
					$resultSelecionaNovo = $conn->query($sqlSelecionaNovo);
					$dadosSelecionaNovo = $resultSelecionaNovo->fetch_assoc();
					if($dadosSelecionaNovo['codPonto'] != ""){
						$sqlCadastraTurno = "INSERT INTO pontoTurno VALUES (0, ".$dadosSelecionaNovo['codPonto'].", '".date("H:i:s")."', '".$saida."', '".$turno."')";
						$resultCadastraTurno = $conn->query($sqlCadastraTurno);
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."controle-acesso.php'>";
					}
				}
				$paraLoop = "ok";
				
			}else{
				$erroLogin = "<p style='font-size:16px; text-align:center; padding-top:20px; color:red;'>Usuário ou Senha incorretos!</p>";
			}
			if($paraLoop == "ok"){
				$erroLogin = "";
				break;
			}
		}
		
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
  
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>Login | <?php echo $nomeEmpresa;?></title>
        <link rel="shortcut icon" href="<?php echo $configUrl;?>f/i/icon.png" />
        
        <link rel="stylesheet" href="<?php echo $configUrl; ?>f/c/estilo-3.css" type="text/css"/>

		<!--[if lte IE 6]>
			<link href="<?php echo $configUrl;?>f/c/IE6.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		
		<!--[if lte IE 7]>
			<link href="<?php echo $configUrl;?>f/c/IE7.css" type="text/css" rel="stylesheet" />
		<![endif]-->
		
   </head>
    <body style="overflow-y:hidden;" style="overflow-x:hidden;">
		<div id="tudo-login">
			<div id="centro-login" style="position:absolute; height:100%;">
				<p class="logo-login" style="width:525px; height:275px; position:absolute; top:50%; left:50%; margin-top:-325px; margin-left:-262.5px;"><span class="oculto">Logo Sistema</span></p>
				<div id="barra-login" style="position:absolute; top:50%; margin-top:-34px;">
					<div id="dados-barra-login">
						<form action="<?php echo $configUrl;?>login.php" method="post">
							<p class="campo-login"><input type="text" name="usuarioLogin" size="10" tabindex="1" value="" /></p>
							<p class="botao-entrar"><input type="submit" name="entrar" tabindex="3" value="Entrar" /></p>
							<p class="campo-login"><input type="password" name="senhaLogin" size="10" tabindex="2" value="" /></p>
							<br class="clear" />
						</form>
					</div>
				</div>
				<div id="fundo-login" style="position:absolute; top:50%; margin-top:20px;">
<?php
	if($erroLogin != ""){
		echo $erroLogin;
	}
?>
				</div>
			</div>
			<div id="base-login">
				<div class="dados-login" style="width:235px;">
					<p class="nome-rodape-login">SoftBest Marketing Digital</p>
					<br/>
					<p class="link-rodape-login"><a href="http://www.softbest.com.br/" title="www.softbest.com.br" target="blank">www.softbest.com.br</a></p>
				</div>
				<p class="direitos-login" style="text-align:center;">Copyright <?php echo date('Y');?> - Todos os direitos reservados - SoftBest</p>
			</div>
		</div>
    </body>
</html>
<?php
	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."'>";
	}
	
	$conn->close();	
?>
