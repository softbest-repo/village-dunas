<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
				
			$area = "imoveisS";
			if(validaAcesso($conn, $area) == "ok"){

				if($url[5] != ""){
					$sqlCons = "SELECT nomeDespesaImovel, statusDespesaImovel FROM despesasImovel WHERE codDespesaImovel = ".$url[8]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();
					
					echo "<div id='filtro'>";
					if($dadosCons['statusDespesaImovel'] == "T"){
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Desativando...</p>";
					}else{
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Ativando...</p>";
					}
					echo "</div>";
					
					if($dadosCons['statusDespesaImovel'] == "T"){
						$alteraStatus = "F";
						$_SESSION['acao'] = "desativada";
					}else{
						$alteraStatus = "T";
						$_SESSION['acao'] = "extornada";
						
						$sqlConta = "SELECT * FROM contas WHERE codDespesaImovel = ".$url[8]."";
						$resultConta = $conn->query($sqlConta);
						while($dadosConta = $resultConta->fetch_assoc()){
							$sqlDeleta = "DELETE FROM contasParcial WHERE codConta = ".$dadosConta['codConta']."";
							$resultDelete = $conn->query($sqlDeleta);
						}
						
						$sqlDeleta = "DELETE FROM contas WHERE codDespesaImovel = ".$url[8]."";
						$resultDeleta = $conn->query($sqlDeleta);
					}
					
					$sql =  "UPDATE despesasImovel SET statusDespesaImovel = '".$alteraStatus."' WHERE codDespesaImovel = ".$url[8];
					$result = $conn->query($sql);
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeDespesaImovel'];
						$_SESSION['ativacao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/imoveis/alterar/".$url[7]."/#despesasImovel'>";
					}
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."cadastros/imoveis/alterar/".$url[7]."/#despesasImovel'>";
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
