<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "compromissos";
			if(validaAcesso($conn, $area) == "ok"){

				if($url[4] != ""){
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'>Excluindo...</p>";
					echo "</div>";			

					$sqlCons = "SELECT * FROM compromissos WHERE codCompromisso = ".$url[6];
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();

					$sqlTipoCompromisso = "SELECT nomeTipoCompromisso FROM tipoCompromisso WHERE codTipoCompromisso = ".$dadosCons['codTipoCompromisso']." LIMIT 0,1";
					$resultTipoCompromisso = $conn->query($sqlTipoCompromisso);
					$dadosTipoCompromisso = $resultTipoCompromisso->fetch_assoc();

					$sql =  "DELETE FROM compromissos WHERE codCompromisso = ".$url[6];
					$result = $conn->query($sql);
				
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeCompromisso'];
						$_SESSION['exclusao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."comercial/compromissos/'>";
					}
				
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."comercial/compromissos/'>";
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
