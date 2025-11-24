<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "compromissos";
			if(validaAcesso($conn, $area) == "ok"){

				if($url[4] != ""){
					
					$sqlCons = "SELECT nomeCompromisso, statusCompromisso FROM compromissos WHERE codCompromisso = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();
				
					echo "<div id='filtro'>";
				
					if($dadosCons['statusCompromisso'] == "T"){
						echo "<p style='margin:20px; font-size:20px;'>Desativando...</p>";
					}else{
						echo "<p style='margin:20px; font-size:20px;'>Ativando...</p>";
					}		
					
					echo "</div>";
					
					if($dadosCons['statusCompromisso'] == "T"){
						$alteraStatus = "F";
						$_SESSION['acao'] = "desativado";
					}else{
						$alteraStatus = "T";
						$_SESSION['acao'] = "ativado";
					}
					
					$sql =  "UPDATE compromissos SET statusCompromisso = '".$alteraStatus."' WHERE codCompromisso = ".$url[6];
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeCompromisso'];
						$_SESSION['ativacao'] = "ok";
						if($_GET['capa'] == "ok"){
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."/#bloco-compromissos'>";							
						}else{
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/compromissos/'>";
						}
					}
			
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/compromissos/'>";
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
