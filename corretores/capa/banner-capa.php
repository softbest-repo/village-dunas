<?php
	$sqlBanner = "SELECT * FROM banners B inner join bannersImagens BI on B.codBanner = BI.codBanner WHERE B.statusBanner = 'T' ORDER BY B.codOrdenacaoBanner ASC";
	$resultBanner = $conn->query($sqlBanner);
	$dadosBanner = $resultBanner->fetch_assoc();
	
	if($dadosBanner['codBanner'] != ""){
?>
				<div id="repete-banner">
					<div id="conteudo-banner">
						<div id="bloco-banner">	
							<div class="owl-carrossel">
								<div class="row">
									<div class="large-12 columns">
										<div class="loop owl-carousel bannerCapa owl-loaded owl-drag">
<?php
		$cont = 0;
		
		$sqlBanner = "SELECT * FROM banners WHERE statusBanner = 'T' ORDER BY codOrdenacaoBanner ASC";
		$resultBanner = $conn->query($sqlBanner);
		while($dadosBanner = $resultBanner->fetch_assoc()){
					
			$sqlImagem = "SELECT * FROM bannersImagens WHERE codBanner = '".$dadosBanner['codBanner']."' ORDER BY codBannerImagem ASC LIMIT 0,1";
			$resultImagem = $conn->query($sqlImagem);
			$dadosImagem = $resultImagem->fetch_assoc();
			
			if($dadosImagem['extBannerImagem'] != ""){

				$cont++;
				
				if($dadosImagem['extBannerImagem'] != "mp4" && $dadosImagem['extBannerImagem'] != "MP4"){
					
					if($dadosBanner['linkBanner'] != ""){
					
						if($dadosBanner['novaAbaBanner'] == "S"){
							$target = "target='_blank'";
						}else{
							$target = "";
						}
?>			
											<li class="imagem"><a class="imagem-banner" <?php echo $target;?> title="<?php echo $dadosBanner['nomeBanner'];?>" href="<?php echo $dadosBanner['linkBanner'];?>"><img style="display:block;" src="<?php echo $configUrlGer.'f/banners/'.$dadosImagem['codBanner'].'-'.$dadosImagem['codBannerImagem'].'-W.webp';?>" width="100%"/></a></li>
<?php	
					}else{
?>	
											<li class="imagem-banner"><a target="_blank" rel="lightbox[roadtrip]" href="<?php echo $configUrlGer.'f/banners/'.$dadosImagem['codBanner'].'-'.$dadosImagem['codBannerImagem'].'-W.webp';?>"><img style="display:block;" src="<?php echo $configUrlGer.'f/banners/'.$dadosImagem['codBanner'].'-'.$dadosImagem['codBannerImagem'].'-W.webp';?>" width="100%"/></a></li>
<?php
					}
				}else{
?>
											<li class="imagem-banner">	
												<video id="video" class="vid" disablePictureInPicture controlsList="nodownload" style="min-width: 100%; min-height: 100%; width: 100%; display:block;" src="<?php echo $configUrlGer.'f/banners/'.$dadosImagem['codBanner'].'-'.$dadosImagem['codBannerImagem'].'-O.'.$dadosImagem['extBannerImagem'];?>" type="video/mp4" loop muted autoplay ></video>
											</li>
<?php				
				}
			}
		}
?>		
										</div>
									</div>
								</div>
							</div>
							<script>
								var $rfg = jQuery.noConflict();
								var owl = $rfg('.bannerCapa');
								owl.owlCarousel({
									autoplay:true,
									speed: 1500,
									autoplayTimeout: 15000,
									smartSpeed: 1000,										
									fluidSpeed: 1000,										
									items:1,
									loop:true,
									videoHeight:930,
									lazyLoad: true,
									lazyLoad: true,
									autoWidth:false,
									autoplayHoverPause:false,
									margin:25,
									nav: false,
									dots: false
								});
							</script>										
						</div>	
					</div>																									
				</div>
<?php
	}
?>
