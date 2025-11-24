<?php
	ob_start();
	session_start();

	include ('f/conf/config.php');
	include ('f/conf/functions.php');
	include ('f/conf/criaUrl.php');

	$url = explode("/", $aux.$_SERVER['REQUEST_URI']);

	$quebraUrl2 = explode("=", $url[2]);
	$quebraUrl3 = explode("=", $url[3]);
	$quebraUrl4 = explode("=", $url[4]);

	if($quebraUrl2[0] == "?fbclid" || $quebraUrl2[0] == "?gclid"){
		$url[2] = "";
	}
	if($quebraUrl3[0] == "?fbclid" || $quebraUrl3[0] == "?gclid" || $quebraUrl3[0] == "?numero"){
		$url[3] = "";
	}
	if($quebraUrl4[0] == "?fbclid" || $quebraUrl4[0] == "?gclid"){
		$url[4] = "";
	}

	include ('f/conf/titles.php');
	
	if($url[4] != ""){
		$arquivoRetornar = $url[2].'/'.$url[3].'/'.$url[4].'/';
			if(is_numeric($url[4])){
				if(file_exists($url[2].'/'.$url[3].'/conteudo.php')){
					$arquivo = $url[2].'/'.$url[3].'/conteudo.php';
				}else
					if(file_exists($url[2].'/'.$url[3].'/detalhes.php')){
						$arquivo = $url[2].'/'.$url[3].'/detalhes.php';
					}else
						if(file_exists($url[2].'/'.$url[3].'.php')){
							$arquivo = $url[2].'/'.$url[3].'.php';
						}else
							if(file_exists($url[2].'/conteudo.php')){
								$arquivo = $url[2].'/conteudo.php';
							}else{
								$arquivo = '404/conteudo.php';
							}
					
			}else
				if(file_exists($url[2].'/detalhes.php') && $url[2] == "imoveis"){
					$arquivo = $url[2].'/detalhes.php';
				}else
					if(file_exists($url[2].'/conteudo.php')){
						$arquivo = $url[2].'/conteudo.php';
					}else
						if(file_exists($url[2].'/'.$url[3].'/'.$url[4].'.php')){
							$arquivo = $url[2].'/'.$url[3].'/'.$url[4].'.php';
						}else{
							$arquivo = '404/conteudo.php';
						}
	}else
		if($url[3] != ""){
			$arquivoRetornar = $url[2].'/'.$url[3].'/';
			
			if(is_numeric($url[3])){
				if(file_exists($url[2].'/conteudo.php')){
					$arquivo = $url[2].'/conteudo.php';
				}else										
					if(file_exists($url[2].'/conteudo.php')){
						$arquivo = $url[2].'/conteudo.php';
					}
			}else	
				if($url[3] == "contato-whatsapp-enviado"){
					$arquivo = 'contato-whatsapp-enviado.php';
				}else															
				if(file_exists($url[2].'/'.$url[3].'/conteudo.php')){
					$arquivo = $url[2].'/'.$url[3].'/conteudo.php';																						
				}else
				if($url[3] == "destaques"){
					$arquivo = $url[2].'/detalhes-destaque.php';															
				}else
					if(file_exists($url[2].'/detalhes.php')){
						$arquivo = $url[2].'/detalhes.php';												
					}else								
						if(file_exists($url[2].'/'.$url[3].'.php')){
							$arquivo = $url[2].'/'.$url[3].'.php';
						}else
							if(file_exists($url[2].'/conteudo.php')){
								$arquivo = $url[2].'/conteudo.php';
							}else
								if($url[2] == "busca"){
									$arquivo = $url[2].'/conteudo.php';
								}else{
									$arquivo = '404/conteudo.php';
								}
				
		}else
			if($url[2] != ""){
				$arquivoRetornar = $url[2].'/';

				if($url[2] == "contato-whatsapp-enviado"){
					$arquivo = 'contato-whatsapp-enviado.php';
				}else								
				if(file_exists($url[2].'/conteudo.php')){
					$arquivo = $url[2].'/conteudo.php';
				}else
					if(file_exists($url[2].'.php')){
						$arquivo = $url[2].'.php';
					}else{
						$arquivo = '404/conteudo.php';
					}	
			}else
				if($url[2] == ""){
					$arquivoRetornar = "";
					
					$arquivo = 'capa/conteudo.php';
				}else{
					$arquivo = '404/conteudo.php';
				}							
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
  "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt" lang="pt">
	<head>
		<title><?php echo $title;?></title>
		<meta http-equiv="content-type" content="text/html;charset=utf-8" />
		<meta name="author" content="SoftBest" />
		<meta name="description" content="<?php echo $description;?>" />
		<meta name="keywords" content="<?php echo $keywords;?>" />
		<meta name="language" content="<?php echo $linguagem;?>"/>
		<meta name="city" content="<?php echo $cidade;?>"/>
		<meta name="state" content="<?php echo $estado;?>"/>
		<meta name="country" content="<?php echo $pais;?>"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">		
		<meta name="theme-color" content="#364349">
		<meta name="apple-mobile-web-app-status-bar-style" content="#364349">
		<meta name="msapplication-navbutton-color" content="#364349">		
<?php
	if($arquivo != "404/conteudo.php"){
?>
		<meta name="robots" content="index,follow"/>	
<?php
	}else{
?>
		<meta name="robots" content="noindex">
<?php
	}
?>
		
		<link rel="canonical" href="<?php echo $dominio;?>/<?php echo $arquivoRetornar;?>" />	
		<link rel="shortcut icon" href="<?php echo $configUrl;?>f/i/icon.png" />
		<link rel="stylesheet" type="text/css" href="<?php echo $configUrl;?>f/c/estilo.css" media="all" title="Layout padrão" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">		   
	
		<script src="https://www.google.com/recaptcha/api.js?render=<?php echo $chaveSite;?>"></script>
		<script type="text/javascript" src="<?php echo $configUrl;?>f/j/js/jquery.js"></script>			
		<script type="text/javascript" src="<?php echo $configUrl;?>f/j/js/mascaras.js"></script>						
<?php
	if($url[2] == "loteamentos" && $url[3] != "" || $url[2] == "minha-conta" && $url[3] == "negociacoes"){
?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" />
		<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js"></script>
		<script>
		lightbox.option({
		  'resizeDuration': 200,
		  'wrapAround': true
		  })
		</script>
		
		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.theme.default.min.css">
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/jquery.min.js"></script>
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/owl.carousel.js"></script>			
<?php
	}
	
	if($url[2] == ""){
?>
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/css/lightbox.css" />
		<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.7.1/js/lightbox.min.js"></script>
		<script>
		lightbox.option({
		  'resizeDuration': 200,
		  'wrapAround': true
		  })
		</script>
		
		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.carousel.min.css">
		<link rel="stylesheet" href="<?php echo $configUrl;?>f/j/owlcarousel/assets/owl.theme.default.min.css">
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/jquery.min.js"></script>
		<script src="<?php echo $configUrl;?>f/j/owlcarousel/owl.carousel.js"></script>	
<?php		
	}

	if($configUrlSeg != ""){
?>		
		 <script>
		  var ua = navigator.userAgent.toLowerCase();

		  var uMobile = '';

		  //Lista de dispositivos que Ã© possÃ­vel acessar
		  uMobile = '';
		  uMobile += 'iphone;ipod;ipad;windows phone;android;iemobile 8';

		  //Separa os itens em arrays
		  v_uMobile = uMobile.split(';');

		  //verifica se vocÃª estÃ¡ acessando pelo celular
		  var boolMovel = false;
		  for (i=0;i<=v_uMobile.length;i++)
		  {
		  if (ua.indexOf(v_uMobile[i]) != -1)
		  {
		  boolMovel = true;
		  }
		  }

		  if (boolMovel == true)
		  {
		   location.href="<?php echo $configUrlSeg.$arquivoRetornar.$ancora;?>";	  			  
		  }else{
		  }
		 </script>							
<?php
	}
?>

		<link href="<?php echo $configUrl;?>f/c/select2.min.css" rel="stylesheet" />
		<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>
		
		<meta property="og:title" content="<?php echo $title;?>"/>
		<meta property="og:image" content="<?php echo $configUrl;?>f/i/comp.png"/>
		<meta property="og:description" content="<?php echo $description;?>"/>
		<meta property="og:url" content="<?php echo $configUrl.$arquivoRetornar;?>"/>
		<link href="<?php echo $configUrl;?>f/i/comp.png" rel="image_src" />

<?php 
	 	$dominio = "http://".$_SERVER['SERVER_NAME']."/sanFerreira/";	
?>

		<style type="text/css">	
			@font-face {
				font-family: 'MacklinSans';
				src: url('<?php echo $dominio; ?>f/i/fonte/MacklinSans-Light.otf') format('opentype');
				font-weight: 100 300;
				font-style: normal;
			}
			@font-face {
				font-family: 'MacklinSans';
				src: url('<?php echo $dominio; ?>f/i/fonte/MacklinSans-Medium.otf') format('opentype');
				font-weight: 400 600;
				font-style: normal;
			}
			@font-face {
				font-family: 'MacklinSans';
				src: url('<?php echo $dominio; ?>f/i/fonte/MacklinSans-Bold.otf') format('opentype');
				font-weight: 700 900;
				font-style: normal;
			}
			*{ font-family: 'MacklinSans', cursive;  }
		</style>		
	</head>

		<div id="tudo">
			<p class="fundo"></p>
			<p class="fundo-2"></p>	
			<div id="topo">
<?php
	include('capa/topo.php');
?>
			</div>
			<div id="conteudo">
<?php
	if($url[2] == ""){
		include('capa/banner-capa.php');
	}

	include($arquivo);
?>
			</div>			
			<div id="rodape">
<?php
	include('capa/rodape.php');
?>				
			</div>		
			<script type="text/javascript" src="<?php echo $configUrl;?>f/j/js/wow.min.js"></script>			
			<script>
				new WOW().init();
			</script>						
		</div>
	</body>
</html>
<?php
	$conn->close();
?>
