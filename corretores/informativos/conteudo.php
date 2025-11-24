<?php
	if($_COOKIE['codAprovado'.$cookie] != ""){
?>
							<div id="conteudo-interno">
								<div id="bloco-titulo">
									<p class="titulo">⚠ Informações Importantes ⚠</p>
								</div>
								<div id="conteudo-informativos">
<?php
		$sqlInformativos = "SELECT * FROM informativos WHERE statusInformativo = 'T' ORDER BY codOrdenacaoInformativo ASC";
		$resultInformativos = $conn->query($sqlInformativos);
		while($dadosInformativos = $resultInformativos->fetch_assoc()){
?>			
									<div id="bloco-informativo">
										<p class="nome-informativo">➔ <?php echo $dadosInformativos['nomeInformativo'];?></p>
										<div class="descricao-informativo" style="padding-left:20px;"><?php echo $dadosInformativos['descricaoInformativo'];?></div>
									</div>
<?php
		}
?>
								</div>
							</div>
<?php
	}else{
		$_SESSION['voltar'] = $arquivoRetornar;
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login/'>";			
	}
?>
