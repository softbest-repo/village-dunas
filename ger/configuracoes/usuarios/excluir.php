<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "usuarios";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($url[4] != ""){
									
					$sqlCola = "SELECT * FROM usuarios WHERE codUsuario = '".$url[6]."'";
					$resultCola = $conn->query($sqlCola);
					$dadosCola = $resultCola->fetch_assoc();
				
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Excluindo...</p>";
					echo "</div>";			
			
					$sqlDel =  "DELETE FROM usuariosImagens WHERE codUsuario = ".$url[6];
					$resultDel = $conn->query($sqlDel);		
					
					$sql =  "DELETE FROM usuarios WHERE codUsuario = ".$url[6];
					$result = $conn->query($sql);
						
					if($result == 1){
						$_SESSION['nome'] = $dadosCola['nomeUsuario'];
						$_SESSION['exclusao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."configuracoes/usuarios/'>";
					}
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."configuracoes/usuarios/'>";
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
