<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "relatorios";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Informações alteradas com sucesso!</p>";
					$_SESSION['alteracao'] = "";
				}	
				
				$sqlNomePagamento = "SELECT * FROM informacoes WHERE codInformacao = 1 LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Site</p>
						<p class="flexa"></p>
						<p class="nome-lista">Relatórios de Acessos</p>
						<br class="clear" />
					</div>
				</div>
				<div id="dados-conteudo">					
					<div id="consulta">
						<style>
							iframe {border:1px solid #ccc;}
						</style>
						<?php echo $dadosNomePagamento['analyticsInformacao'];?>						
					</div>
				</div>
<?php
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
