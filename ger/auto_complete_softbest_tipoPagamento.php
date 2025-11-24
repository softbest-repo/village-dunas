<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('f/conf/config.php');
	include('f/conf/conexao.php');

	$value = $_POST['value'];
	
	$cont = 0;
	
	$sqlAutoComplete = "SELECT * FROM tipoPagamento where locate('".$value."',nomeTipoPagamento) > 0 group by nomeTipoPagamento order by locate('".$value."',nomeTipoPagamento) limit 10";
	$resultAutoComplete = $conn->query($sqlAutoComplete);
	while($dadosAutoComplete = $resultAutoComplete->fetch_assoc()){
		
		$cont++;
		
		$word = $dadosAutoComplete['nomeTipoPagamento'];
		$wordClean = $dadosAutoComplete['nomeTipoPagamento'];
		$word = preg_replace('/(' . $value . ')/i', '<strong>$1</strong>', $word);
		
		echo '<p class="item sec'.$cont.'" onMouseOver="mouseOverAutoComplete('.$cont.');" onClick="executaClick('.$dadosAutoComplete['codTipoPagamento'].');" style="float:none; margin-right:0px;"><input type="hidden" class="val'.$cont.'" value="'.$wordClean.'" id="autocomplete_'.$dadosAutoComplete['codTipoPagamento'].'"/>'.$word.'</p>';
	
	}
?>
		<input type="hidden" value="<?php echo $cont;?>" id="total_autocomplete_softbest"/>
		<input type="hidden" value="0" id="atual_autocomplete_softbest"/>
		<input type="hidden" value="tipoPagamento" id="id_autocomplete_softbest"/>
