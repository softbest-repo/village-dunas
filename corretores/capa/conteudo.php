<?php
	$_SESSION['quadraFiltroSite'] = "";
	$_SESSION['loteFiltroSite'] = "";
	$_SESSION['bairroFiltroSite'] = "";
	$_SESSION['posicaoFiltroSite'] = "";
	$_SESSION['valor1'] = "";				
	$_SESSION['valor2'] = "";				
	$_SESSION['statusFiltroSite'] = "";
	$_SESSION['ordenarFiltro'] = "";	
?>
			<div id="repete-conteudo">

				<div id="mostra-loteamentos">
					<p class="titulo">Confira os nossos Empreendimentos</p>
					<div id="conteudo-centro">
<?php
	$sqlLotes = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join lotesImagens LI on L.codLote = LI.codLote WHERE L.statusLote = 'T' and L.destaqueLote = 'T' and L.vendidoLote = 'F' GROUP BY L.codLote ORDER BY rand()";
	$resultLotes = $conn->query($sqlLotes);
	$dadosLotes = $resultLotes->fetch_assoc();
	
	if($dadosLotes['codLote'] != ""){
?>						
						<div id="bloco-loteamento">
							<a href="<?php echo $configUrl;?>loteamentos/destaques/">
								<style>
									.imagem-carrossel {
									  position: absolute;
									  width: 100%;
									  opacity: 0;
									  transition: opacity 1s ease-in-out;
									}

									.imagem-carrossel.active {
									  opacity: 1;
									}								
								</style>
								<div class="carousel">
									<div class="carousel-container">

<?php
		$cont = 0;
		
		$sqlImagem = "SELECT * FROM lotesImagens LI inner join lotes L on LI.codLote = L.codLote WHERE L.statusLote = 'T' and L.destaqueLote = 'T' and L.vendidoLote = 'F' GROUP BY LI.codLote ORDER BY LI.capaLoteImagem ASC, LI.codLoteImagem ASC";
		$resultImagem = $conn->query($sqlImagem);
		while($dadosImagem = $resultImagem->fetch_assoc()){
			
			$cont++;
?>
										<p class="imagem-carrossel <?php echo $cont == 1 ? 'active' : '';?>" style="width:100%; height:330px; background:transparent url('<?php echo $configUrlGer.'f/lotes/'.$dadosImagem['codLote'].'-'.$dadosImagem['codLoteImagem'].'-W.webp';?>') center center no-repeat; background-size:cover, 100%;"></p>
<?php
		}
?>
									</div>
								</div>
								<script style="text/javascript">
									const items = document.querySelectorAll('.imagem-carrossel');
									let currentIndex = 0;

									function moveCarousel() {
									  items[currentIndex].classList.remove('active');

									  currentIndex = (currentIndex + 1) % items.length;

									  items[currentIndex].classList.add('active');
									}

									setInterval(moveCarousel, 5000);								
								</script>
								<div class="dados-loteamento" style="z-index:50;">
									<div class="alinha-centro">
										<p class="nome-loteamento">Lotes em Destaque</p>
										<div class="dados-exibe">
											<p class="lotes-disponiveis">Oportunidades</p>								
											<p class="botao-confira">Confira</p>
										</div>
									</div>	
								</div>
							</a>
						</div>
<?php
	}

	$sqlLoteamentos = "SELECT * FROM loteamentos L inner join loteamentosImagens LI on L.codLoteamento = LI.codLoteamento WHERE L.statusLoteamento = 'T' GROUP BY L.codLoteamento ORDER BY L.codOrdenacaoLoteamento ASC";
	$resultLoteamentos = $conn->query($sqlLoteamentos);
	while($dadosLoteamentos = $resultLoteamentos->fetch_assoc()){
		
		$sqlImagem = "SELECT * FROM loteamentosImagens WHERE codLoteamento = ".$dadosLoteamentos['codLoteamento']." ORDER BY capaLoteamentoImagem ASC, codLoteamentoImagem ASC LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();

		$sqlLotes = "SELECT COUNT(codLote) total FROM lotes WHERE codLoteamento = ".$dadosLoteamentos['codLoteamento']." and vendidoLote = 'F' and statusLote = 'T'";
		$resultLotes = $conn->query($sqlLotes);
		$dadosLotes = $resultLotes->fetch_assoc();
		
		if($dadosLoteamentos['breveLoteamento'] == "F"){
			if($dadosLoteamentos['linkLoteamento'] != ""){
				$link = $dadosLoteamentos['linkLoteamento'];
				$target = "target='_blank'";
			}else{
				$link = $configUrl."loteamentos/".$dadosLoteamentos['urlLoteamento']."/";
				$target = "";
			}
		}else{
			if($dadosLoteamentos['linkLoteamento'] != ""){
				$link = $dadosLoteamentos['linkLoteamento'];
				$target = "target='_blank'";
			}else{
				$link = "";
				$target = "";			
			}
		}
?>						
						<div id="bloco-loteamento">
							<a <?php echo $target;?> href="<?php echo $link;?>" style="background:transparent url('<?php echo $configUrlGer.'f/loteamentos/'.$dadosImagem['codLoteamento'].'-'.$dadosImagem['codLoteamentoImagem'].'-W.webp';?>') center center no-repeat; background-size:cover, 100%;">
								<div class="dados-loteamento">
									<div class="alinha-centro">
										<p class="nome-loteamento"><?php echo $dadosLoteamentos['nomeLoteamento'];?></p>
										<div class="dados-exibe">
<?php
		if($dadosLoteamentos['breveLoteamento'] == "F"){
			if($dadosLoteamentos['linkLoteamento'] != ""){
				if($dadosLoteamentos['tipoLoteamento'] == "T"){
?>											
											<p class="lotes-disponiveis">Lotes Disponíveis</p>
<?php
				}else
				if($dadosLoteamentos['tipoLoteamento'] == "A"){
?>											
											<p class="lotes-disponiveis">Apartamentos Disponíveis</p>
<?php
				}
			}else{
				if($dadosLoteamentos['tipoLoteamento'] == "T"){
?>			
											<p class="lotes-disponiveis"><span><?php echo $dadosLotes['total'];?></span> Lote<?php echo $dadosLotes['total'] != 0 && $dadosLotes['total'] != 1 ? 's' : '';?> <?php echo $dadosLotes['total'] != 0 && $dadosLotes['total'] != 1 ? 'Disponíveis' : 'Disponível';?></p>								
<?php
				}else{
?>
											<p class="lotes-disponiveis"><span><?php echo $dadosLotes['total'];?></span> Apartamento<?php echo $dadosLotes['total'] != 0 && $dadosLotes['total'] != 1 ? 's' : '';?> <?php echo $dadosLotes['total'] != 0 && $dadosLotes['total'] != 1 ? 'Disponíveis' : 'Disponível';?></p>								
<?php
				}
			}
?>
											<p class="botao-confira">Confira</p>
<?php			
		}else{
?>
											<p class="lotes-disponiveis"><span><?php echo $dadosLoteamentos['lotesLoteamento'];?></span> Lote<?php echo $dadosLoteamentos['lotesLoteamento'] != 0 && $dadosLoteamentos['lotesLoteamento'] != 1 ? 's' : '';?> <?php echo $dadosLoteamentos['lotesLoteamento'] != 0 && $dadosLoteamentos['lotesLoteamento'] != 1 ? 'Disponíveis' : 'Disponível';?></p>								
											<p class="botao-confira" style="background-color:#FF0000; color:#FFF;">Em Breve</p>
<?php
		}
?>
										</div>
									</div>	
								</div>
							</a>
						</div>
<?php
	}
?>						
					</div>
				</div>
			</div>
