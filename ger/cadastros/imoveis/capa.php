<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "imoveisS";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($url[4] != ""){
					
					$sqlCons = "SELECT nomeImovel, capaImovel FROM imoveis WHERE codImovel = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'>Aguarde...</p>";
					echo "</div>";
					
					if($dadosCons['capaImovel'] == "T"){
						$sql2 =  "UPDATE imoveis SET codOrdenacaoImovel = 0 WHERE codImovel = ".$url[6];
						$result2 = $conn->query($sql2);
						
						$cont = 0;
						
						$sqlPrimeira = "SELECT codImovel FROM imoveis WHERE statusImovel = 'T' and capaImovel = 'T' and codImovel != ".$url[6]." ORDER BY codOrdenacaoImovel ASC";
						$resultPrimeira = $conn->query($sqlPrimeira);
						while($dadosPrimeira = $resultPrimeira->fetch_assoc()){
							
							$cont++;
							
							$sqlUpdate = "UPDATE imoveis SET codOrdenacaoImovel = ".$cont." WHERE codImovel = ".$dadosPrimeira['codImovel']."";
							$resultUpdate = $conn->query($sqlUpdate);
							
						}
				
						$alteraCapa = "F";
						$_SESSION['acao'] = "não aparecerá mais na capa";
					}else{
						$sqlUltima = "SELECT codOrdenacaoImovel FROM imoveis WHERE statusImovel = 'T' and capaImovel = 'T' ORDER BY codOrdenacaoImovel DESC";
						$resultUltima = $conn->query($sqlUltima);
						$dadosUltimo = $resultUltima->fetch_assoc();
												
						$ordenacao = $dadosUltimo['codOrdenacaoImovel'] + 1;
						
						$sql2 =  "UPDATE imoveis SET codOrdenacaoImovel = ".$ordenacao." WHERE codImovel = ".$url[6];
						$result2 = $conn->query($sql2);

						$alteraCapa = "T";
						$_SESSION['acao'] = "aparecerá na capa";
					}
									
					$sql =  "UPDATE imoveis SET capaImovel = '".$alteraCapa."' WHERE codImovel = ".$url[6];
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeImovel'];
						$_SESSION['capa'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/imoveis/'>";
					}
				
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/imoveis/'>";
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
