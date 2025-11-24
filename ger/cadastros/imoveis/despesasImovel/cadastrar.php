<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
		
			$area = "loteamentos";
			if(validaAcesso($conn, $area) == "ok"){
?>		
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Loteamentos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Loteamentos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Despesas Loteamento</p>
						<p class="flexa"></p>
						<p class="nome-lista">Cadastrar</p>
						<br class="clear" />
					</div>		
					<div class="botao-consultar" style="float:left;"><a title="Consultar Despesas Loteamento" href="<?php echo $configUrl;?>cadastros/loteamentos/alterar/<?php echo $url[7];?>/#despesasLoteamentoImovel"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
					<br class="clear"/>
				</div>
				<div id="dados-conteudo">

				</div>
<?php
				if(isset($_POST['cadastrar-novo']) || $erro == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['tipo'] = "";
					$_SESSION['data'] = "";
					$_SESSION['valor'] = "";
					$_SESSION['status'] = "";
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
