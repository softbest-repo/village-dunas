<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "comissoes";
			if(validaAcesso($conn, $area) == "ok"){

				if($url[4] != ""){
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Excluindo...</p>";
					echo "</div>";			

					$sqlCons = "SELECT * FROM comissoesCorretores WHERE codComissaoCorretor = ".$url[6].$filtraUsuarioPlanilha." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();

					if($dadosCons['codComissao'] == "" || $usuario == "G" || $usuario == "C" || $usuario == "CP"){
					
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/comissoes/'>";
					
					}else{	
				
						$sql =  "DELETE FROM comissoesCorretores WHERE codComissaoCorretor = ".$url[6];
						$result = $conn->query($sql);
						if($result == 1){
							$_SESSION['nome'] = "";
							$_SESSION['exclusao'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."financeiro/comissoes/'>";
						}
						
					}
						
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."financeiro/comissoes/'>";
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
