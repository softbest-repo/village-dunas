<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "imoveisS";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($url[4] != ""){
					
					$sqlCons = "SELECT nomeImovel, lancamentoImovel FROM imoveis WHERE codImovel = ".$url[6]." LIMIT 0,1";
					$resultCons = $conn->query($sqlCons);
					$dadosCons = $resultCons->fetch_assoc();
					
					echo "<div id='filtro'>";
						echo "<p style='margin:20px; font-size:20px;'>Aguarde...</p>";
					echo "</div>";
					
					if($dadosCons['lancamentoImovel'] == "T"){
						$alteraCapa = "F";
						$_SESSION['acao'] = "não será mostrado como lançamento";
					}else{
						$alteraCapa = "T";
						$_SESSION['acao'] = "será mostrado como lançamento";
					}
					
					$sql =  "UPDATE imoveis SET lancamentoImovel = '".$alteraCapa."' WHERE codImovel = ".$url[6];
					$result = $conn->query($sql);
					
					if($result == 1){
						$_SESSION['nome'] = $dadosCons['nomeImovel'];
						$_SESSION['lancamento'] = "ok";
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
