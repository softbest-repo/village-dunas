<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "contas-receber";
			if(validaAcesso($conn, $area) == "ok"){

				if($url[6] != ""){
				
					$sqlCons = "SELECT * FROM contas WHERE codConta = ".$url[6];
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();	

					$sqlConsP = "SELECT * FROM contasParcial WHERE codConta = ".$url[6];
					$resultConsP = $conn->query($sqlConsP);
					$dadosConsP = $resultConsP->fetch_assoc();						
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Aguarde...</p>";
					echo "</div>";
					
					if($dadosCons['baixaConta'] == "T"){
						if($dadosCons['statusConta'] == 'F' && $dadosCons['baixaConta'] == 'T'){
							$sqlDelete = "DELETE FROM cheques WHERE codContaParcial = '".$dadosConsP['codContaParcial']."'";
							$resultDelete = $conn->query($sqlDelete);	
					
							$sqlDelete = "DELETE FROM contasParcial WHERE codConta = ".$url[6]."";
							$resultDelete = $conn->query($sqlDelete);	
							$alteraBaixa = "T";
							$alteraStatus = "T";
						}else{
							$sqlDelete = "DELETE FROM cheques WHERE codContaParcial = '".$dadosConsP['codContaParcial']."'";
							$resultDelete = $conn->query($sqlDelete);	
					
							$sqlDelete = "DELETE FROM contasParcial WHERE codConta = ".$url[6]."";
							$resultDelete = $conn->query($sqlDelete);	
							
							$alteraBaixa = "F";
							$alteraStatus = "T";					
						}
						$_SESSION['acao'] = "foi dada como baixa";
					}else{
						$sqlDelete = "DELETE FROM cheques WHERE codContaParcial = '".$dadosConsP['codContaParcial']."'";
						$resultDelete = $conn->query($sqlDelete);	
							
						$sqlDelete = "DELETE FROM contasParcial WHERE codConta = ".$url[6]."";
						$resultDelete = $conn->query($sqlDelete);
										
						$alteraBaixa = "T";
						$alteraStatus = "T";
						$pagamento = "0000-00-00";
						$horario = "";
						$_SESSION['acao'] = "extornada";
						$_SESSION['extornar'] = "ok";
					}
					
					$sql =  "UPDATE contas SET baixaConta = '".$alteraBaixa."', statusConta = '".$alteraStatus."' WHERE codConta = ".$url[6];
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeConta'];
						if($_SESSION['extornar'] == "ok"){
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/contas-receber/alterar/".$url[6]."/'>";					
						}else{	
							$_SESSION['ativacaos'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/contas-receber/'>";
						}
					}
				
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/contas-receber/'>";
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
