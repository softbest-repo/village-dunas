
<?php echo $url[2];
	if($url[2] == ""){
		$fade =  'class="wow animate__animated animate__fadeInDown"';
	}
?>
				<div id="repete-topo" <?php echo $fade; ?>>
					<div id="conteudo-topo">
						<div id="bloco-topo">
							<div id="filtro-topo">
<?php 
	include('capa/filtro.php'); 
?>
							</div>
							<div id="repete-logo">
								<div id="conteudo-logo">
									<div id="logo-topo">
										<p class="logo"><a href="<?php echo $configUrl;?>"><img style="display:block;" src="<?php echo $configUrl;?>f/i/quebrado/logot.png" width="240"/></a></p>
									</div>
								</div>	
							</div>
<?php
	if($_COOKIE['codAprovado'.$cookie] == ""){
?>							
							<div id="login">
								<a href="<?php echo $configUrl;?>login/">
									<div id="bloco-login">
										<p class="login">Faça seu Login</p>
										<p class="imagem"><img style="display:block;" src="<?php echo $configUrl;?>f/i/quebrado/usuario.png" width="35"/></p>
									</div>
								</a>
							</div>
<?php
	}else{
		$sqlCorretor = "SELECT * FROM corretores WHERE codCorretor = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY codCorretor ASC LIMIT 0,1";
		$resultCorretor = $conn->query($sqlCorretor);
		$dadosCorretor = $resultCorretor->fetch_assoc();

?>							
							<div id="logado">
								<div id="bloco-logado">
									<div style="display: grid; align-content: center;">
										<p class="logado">Olá,  <strong><?php echo $dadosCorretor['nomeCorretor'];?></strong></p>
										<div style="display:flex; gap:15px; ">
											<p class="minha-conta"><a  href="<?php echo $configUrl;?>minha-conta/editar-dados/">Meus Dados</a></p>
											<p class="menu-usuario"><a href="<?php echo $configUrl;?>sair.php">Sair</a></p>
										</div>
									</div>
									<a href="<?php echo $configUrl;?>minha-conta/">
										<p class="imagem"><img style="display:block;" src="<?php echo $configUrl;?>f/i/quebrado/usuario.png" width="35"/></p>
									</a>
								</div>
							</div>
							<div id="menu">
								<p id="titulo-menu" onclick="abreMenu()">Menu</p>
								<div id="mostra-menu">
									<p class='minha-conta' ><a href="<?php echo $configUrl;?>minha-conta/negociacoes/">Negociações</a></p>
									<p class='minha-conta' ><a href="<?php echo $configUrl;?>minha-conta/minhas-vendas/">Vendas</a></p>
									<p class='minha-conta' ><a href="<?php echo $configUrl;?>minha-conta/minhas-reservas/">Reservas</a></p>
									<p class='informativos'><a href="<?php echo $configUrl;?>informativos/">Informações</a></p>
								</div>
							</div>		
<?php
	}
?>	
						</div>
					</div>
				</div>			

<script>
function abreMenu() {
    var menu = document.getElementById("menu");
    menu.classList.toggle("aberto");
}
</script>
