<?php
ob_start();
session_start();
date_default_timezone_set('America/Sao_Paulo');
include ('f/conf/config.php');
		
	$sqlVerifica = "SELECT * FROM controleAcesso WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]." and dataControle = '".date("Y-m-d")."'";
	$resultVerifica = $conn->query($sqlVerifica);
	$dadosVerifica = $resultVerifica->fetch_assoc();

	if($dadosVerifica['codControle'] != ""){
	
		if(isset($_POST['acessar'])){
			$sqlDeleta = "DELETE FROM controleAcesso WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie];
			$resultDeleta = $conn->query($sqlDeleta);

			$sqlInsere = "INSERT INTO controleAcesso VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", '".date("Y-m-d")."')";
			$resultInsere = $conn->query($sqlInsere);
			
			$sqlConsulta = "SELECT codControle FROM controleAcesso WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]." and dataControle = '".date("Y-m-d")."' LIMIT 0,1";
			$resultConsulta = $conn->query($sqlConsulta);
			$dadosConsulta = $resultConsulta->fetch_assoc();
			
			setcookie("controleAprovado".$cookie, $dadosConsulta['codControle'], time()+39600,"/");
			
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."'>";			
			
		}else
		if(isset($_POST['acessar2'])){
			setcookie("loginAprovado".$cookie, "", time()+14400,"/");
			setcookie("codAprovado".$cookie, "", time()+14400,"/");
			
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login.php'>";
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
					<p style="color:#FFFFFF; font-size:18px; padding-top:15px; text-align:center; font-weight:bold;">Esse usuário está sendo utilizado em outra máquina, você deseja acessar mesmo assim?</p>
				</div>
				<div id="fundo-login" style="padding-top:20px; position:absolute; top:50%; margin-top:20px;">
					<div style="width:306px; margin:0 auto;">
						<div style="width:80px; margin:0 auto; float:left;">
							<form action="<?php echo $configUrl;?>controle-acesso.php" name="formulario" method="post" >
								<div style="float:none; margin-right:0px;" class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="acessar" title="Acessar sistema" value="Acessar" /><p class="direita-botao" style="margin-right:0px;"></p></div>
							</form>
						</div>
						<div style="width:206px; padding-left:20px; margin:0 auto; float:left; display:block;">
							<form action="<?php echo $configUrl;?>controle-acesso.php" name="formulario2" method="post" >
								<div style="float:none; margin-right:0px;" class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="acessar2" title="Acessar com outro usuário" value="Acessar com outro usuário" /><p class="direita-botao" style="margin-right:0px;"></p></div>
							</form>
						</div>
						<br class="clear" />
					</div>
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
	$sqlInsere = "INSERT INTO controleAcesso VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", '".date("Y-m-d")."')";
	$resultInsere = $conn->query($sqlInsere);
	
	$sqlConsulta = "SELECT codControle FROM controleAcesso WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]." and dataControle = '".date("Y-m-d")."' LIMIT 0,1";
	$resultConsulta = $conn->query($sqlConsulta);
	$dadosConsulta = $resultConsulta->fetch_assoc();
	
	setcookie("controleAprovado".$cookie, $dadosConsulta['codControle'], time()+39600,"/");
	
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."'>";
}

	$conn->close();
?>
