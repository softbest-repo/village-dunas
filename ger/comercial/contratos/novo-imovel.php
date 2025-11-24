<?php
	$id = $_POST['id'];
?>
											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Código: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="imovel<?php echo $id;?>" name="imovel<?php echo $id;?>" style="width:100px;" onKeyup="carregaImovel(this.value, <?php echo $id;?>);" value="<?php echo $_SESSION['imovel']; ?>" /></p>

											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Quadra: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="quadra<?php echo $id;?>" readonly style="width:120px;" value="" /></p>

											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Lote: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="lote<?php echo $id;?>" readonly style="width:120px;" value="" /></p>
											
											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Bairro / Cidade: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="bairro<?php echo $id;?>" readonly style="width:220px;" value="" /></p>

											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Tipo Imóvel: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="tipo-imovel<?php echo $id;?>" readonly style="width:120px;" value="" /></p>

											<br class="clear"/>
