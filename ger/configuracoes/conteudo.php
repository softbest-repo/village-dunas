<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "preferencias";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){

				echo "<div id='filtro'>";
					echo "<p style='margin:20px; font-size:20px;'>Aguarde...</p>";
				echo "</div>";
				
				echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."configuracoes/minha-foto/'>";

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
