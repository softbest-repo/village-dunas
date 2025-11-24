<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "imoveisS";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($url[5] != ""){
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Excluindo...</p>";
					echo "</div>";			

					$sqlCons = "SELECT nomeImovel FROM imoveis WHERE codImovel = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();

					$sqlExcluiImagens = "SELECT * FROM imoveisImagens WHERE codImovel = ".$url[6]." ORDER BY codImovelImagem ASC";
					$resultExcluiImagens = $conn->query($sqlExcluiImagens);
					while($dadosExcluiImagens = $resultExcluiImagens->fetch_assoc()){
						
						if(file_exists("f/imoveis/".$dadosExcluiImagens['codImovel']."-".$dadosExcluiImagens['codImovelImagem']."-O.".$dadosExcluiImagens['extImovelImagem'])){
							unlink("f/imoveis/".$dadosExcluiImagens['codImovel']."-".$dadosExcluiImagens['codImovelImagem']."-O.".$dadosExcluiImagens['extImovelImagem']);
							unlink("f/imoveis/".$dadosExcluiImagens['codImovel']."-".$dadosExcluiImagens['codImovelImagem']."-MD.".$dadosExcluiImagens['extImovelImagem']);
							unlink("f/imoveis/".$dadosExcluiImagens['codImovel']."-".$dadosExcluiImagens['codImovelImagem']."-W.webp");
						}
							
					}

					$sql =  "DELETE FROM imoveisImagens WHERE codImovel = ".$url[6];
					$result = $conn->query($sql);
										
					$sql =  "DELETE FROM imoveis WHERE codImovel = ".$url[6];
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeImovel'];
						$_SESSION['exclusaos'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."cadastros/imoveis/'>";
					}
				
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."cadastros/imoveis/'>";
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
