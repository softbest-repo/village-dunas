<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "contratos";
			if(validaAcesso($conn, $area) == "ok"){

				if($url[5] != ""){
					$sqlCons = "SELECT * FROM contratos WHERE codContrato = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();
					
					echo "<p style='margin:20px; font-size:20px;'><img style='margin-right:10px;' src='".$configUrl."f/i/default/corpo-default/loading.gif' alt='Loading' />Estornando...</p>";
					
					$alteraStatus = "T";
					$_SESSION['acao'] = "extornada";
					
					$sqlConta = "SELECT * FROM contas WHERE codContrato = ".$url[6]."";
					$resultConta = $conn->query($sqlConta);
					while($dadosConta = $resultConta->fetch_assoc()){
						$sqlDeleta = "DELETE FROM contasParcial WHERE codConta = ".$dadosConta['codConta']."";
						$resultDelete = $conn->query($sqlDeleta);
					}
					
					$sqlDeleta = "DELETE FROM contas WHERE codContrato = ".$url[6]."";
					$resultDeleta = $conn->query($sqlDeleta);
			
					$sql =  "UPDATE contratos SET statusContrato = '".$alteraStatus."' WHERE codContrato = ".$url[6];
					$result = $conn->query($sql);
					if($result == 1){
						$_SESSION['nome'] = "";
						$_SESSION['ativacao'] = "ok";
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/contratos/'>";
					}
				}else{
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/contratos/'>";
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
