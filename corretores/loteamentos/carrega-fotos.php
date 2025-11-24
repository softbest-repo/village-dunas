<?php
	include('../f/conf/config.php');
	include('../f/conf/criaUrl.php');
	
	$codLote = $_POST['codLote'];

	$sql = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra WHERE L.codLote = ".$codLote." and L.statusLote = 'T' ORDER BY L.codLote ASC";
	$result = $conn->query($sql);
	$dadosLote = $result->fetch_assoc();
	
	$sqlBairro = "SELECT * FROM bairros WHERE codBairro = ".$dadosLote['codBairro']." ORDER BY codBairro ASC LIMIT 0,1";
	$resultBairro = $conn->query($sqlBairro);
	$dadosBairro = $resultBairro->fetch_assoc();
	
	$sqlLoteamento = "SELECT * FROM loteamentos L inner join cidades C on L.codCidade = C.codCidade WHERE L.statusLoteamento = 'T' and L.codLoteamento = '".$dadosLote['codLoteamento']."' ORDER BY L.codLoteamento ASC LIMIT 0,1";
	$resultLoteamento = $conn->query($sqlLoteamento);
	$dadosLoteamento = $resultLoteamento->fetch_assoc();	
?>
												<div id="alinha-fotos">													
													<p class="fechar" onClick="fechaFotos();">X</p>
													<p class="titulo-lote">Lote nº <?php echo $dadosLote['nomeLote'];?></p>
													<p class="titulo-loteamento">Quadra <?php echo $dadosLote['nomeQuadra'];?>, <?php echo $dadosBairro['nomeBairro'];?></p>
													<p class="titulo-cidade"><?php echo $dadosLoteamento['nomeCidade'];?> / <?php echo $dadosLoteamento['estadoCidade'];?></p>
													<br/>
													<div class="owl-estampas">
														<div class="row">
															<div class="large-12 columns">
																<div class="loop owl-carousel fotos-lotes owl-loaded owl-drag">										
<?php
		$sqlLotesImagens = "SELECT * FROM lotesImagens WHERE codLote = ".$codLote." ORDER BY codLoteImagem ASC";
		$resultLotesImagens = $conn->query($sqlLotesImagens);
		while($dadosLotesImagens = $resultLotesImagens->fetch_assoc()){
?>														
																	<p class="imagem"><a rel="lightbox[roadtrip]" href="<?php echo $configUrlGer.'f/lotes/'.$dadosLotesImagens['codLote'].'-'.$dadosLotesImagens['codLoteImagem'].'-O.'.$dadosLotesImagens['extLoteImagem'];?>" style="width:100%; height:400px; display:block; background:transparent url('<?php echo $configUrlGer.'f/lotes/'.$dadosLotesImagens['codLote'].'-'.$dadosLotesImagens['codLoteImagem'].'-W.webp';?>') center center no-repeat; background-size:cover, 100%;"></a><span style="position:absolute; bottom:10px; left:50%; transform:translateX(-50%);"><a style="display:block; color:#FFF; background-color:#FF0000; font-size:12px; border-radius:5px; padding:1px 15px;" download="lote-<?php echo $dadosLote['nomeLote'];?>-quadra-<?php echo $dadosLote['nomeQuadra'];?>-<?php echo criaUrl($dadosBairro['nomeBairro']);?>-<?php echo $dadosLotesImagens['codLoteImagem'];?>.<?php echo $dadosLotesImagens['extLoteImagem'];?>" href="<?php echo $configUrlGer.'f/lotes/'.$dadosLotesImagens['codLote'].'-'.$dadosLotesImagens['codLoteImagem'].'-O.'.$dadosLotesImagens['extLoteImagem'];?>">Baixar Foto</a></span></p>
<?php
		}
?>
																</div>
															</div>
														</div>
													</div>
													<script>
														var $rfgs = jQuery.noConflict();
														var owl = $rfgs('.fotos-lotes');
														owl.owlCarousel({
															autoplay:false,
															speed: 1500,
															autoplayTimeout: 15000,
															smartSpeed: 1000,										
															fluidSpeed: 1000,										
															items:3,
															loop:false,
															autoWidth:false,
															autoplayHoverPause:false,
															margin:20,
															nav: true,
															dots: false							
														});
													</script>
												</div>
