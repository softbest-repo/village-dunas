<?php
	include('../f/conf/config.php');
	
	$codLoteamento = $_POST['codLoteamento'];
?>
												<p class="fechar" onClick="fechaMapa();">X</p>
												<iframe src="<?php echo $configUrl;?>loteamentos/mapas/index.php?loteamento=<?php echo $codLoteamento;?>" width="100%" height="100%" style="border: 1px solid #000;">
													Seu navegador não suporta iframes.
												</iframe>
