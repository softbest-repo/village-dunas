<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('f/conf/config.php');
	include('f/conf/conexao.php');

	$value = $_POST['value'];
	
	$cont = 0;
	
	$sqlAutoComplete = "SELECT * FROM fornecedores where locate('".$value."',nomeFornecedor) > 0 group by nomeFornecedor order by locate('".$value."',nomeFornecedor) limit 10";
	$resultAutoComplete = $conn->query($sqlAutoComplete);
	while($dadosAutoComplete = $resultAutoComplete->fetch_assoc()){
		
		$cont++;
		
		$word = $dadosAutoComplete['nomeFornecedor'];
		$wordClean = $dadosAutoComplete['nomeFornecedor'];
		$word = preg_replace('/(' . $value . ')/i', '<strong>$1</strong>', $word);
		
		echo '<p class="item sec'.$cont.'" onMouseOver="mouseOverAutoComplete('.$cont.');" onClick="executaClick('.$dadosAutoComplete['codFornecedor'].');" style="float:none; margin-right:0px;"><input type="hidden" class="val'.$cont.'" value="'.$wordClean.'" id="autocomplete_'.$dadosAutoComplete['codFornecedor'].'"/>'.$word.'</p>';
	
	}
?>
		<input type="hidden" value="<?php echo $cont;?>" id="total_autocomplete_softbest"/>
		<input type="hidden" value="0" id="atual_autocomplete_softbest"/>
		<input type="hidden" value="fornecedores" id="id_autocomplete_softbest"/>
