<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "banners";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($url[5] != ""){
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Excluindo...</p>";
					echo "</div>";			

					$sqlCons = "SELECT nomeBanner FROM banners WHERE codBanner = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();

					$sql =  "DELETE FROM banners WHERE codBanner = ".$url[6];
					$result = $conn->query($sql);

					$sqlExcluiImagens = "SELECT * FROM bannersImagens WHERE codBanner = ".$url[6]." ORDER BY codBannerImagem ASC";
					$resultExcluiImagens = $conn->query($sqlExcluiImagens);
					while($dadosExcluiImagens = $resultExcluiImagens->fetch_assoc()){
						
						if(file_exists("f/banners/".$dadosExcluiImagens['codBanner']."-".$dadosExcluiImagens['codBannerImagem']."-O.".$dadosExcluiImagens['extBannerImagem'])){
							unlink("f/banners/".$dadosExcluiImagens['codBanner']."-".$dadosExcluiImagens['codBannerImagem']."-O.".$dadosExcluiImagens['extBannerImagem']);
							unlink("f/banners/".$dadosExcluiImagens['codBanner']."-".$dadosExcluiImagens['codBannerImagem']."-P.".$dadosExcluiImagens['extBannerImagem']);
							unlink("f/banners/".$dadosExcluiImagens['codBanner']."-".$dadosExcluiImagens['codBannerImagem']."-G.".$dadosExcluiImagens['extBannerImagem']);
						}
							
					}

					$sql =  "DELETE FROM bannersImagens WHERE codBanner = ".$url[6];
					$result = $conn->query($sql);
										
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeBanner'];
						$_SESSION['exclusao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."site/banners/'>";
					}

				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."site/banners/'>";
				}

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
