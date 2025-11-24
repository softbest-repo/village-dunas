<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('f/conf/config.php');

	$value = $_POST['value'];
	
	$cont = 0;
	
	$sqlAutoComplete = "SELECT * FROM leads L inner join conversas C on L.codConversa = C.codConversa where locate('".$value."',C.nome) > 0 group by C.nome order by locate('".$value."',C.nome) limit 10";
	$resultAutoComplete = $conn->query($sqlAutoComplete);
	while($dadosAutoComplete = $resultAutoComplete->fetch_assoc()){
		
		$cont++;
		
		$word = $dadosAutoComplete['nome'];
		$wordClean = $dadosAutoComplete['nome'];
		$word = preg_replace('/(' . $value . ')/i', '<strong>$1</strong>', $word);
		
		echo '<p class="item sec'.$cont.'" onMouseOver="mouseOverAutoComplete('.$cont.');" onClick="executaClick('.$dadosAutoComplete['codLead'].');" style="float:none; margin-right:0px;"><input type="hidden" class="val'.$cont.'" value="'.$wordClean.'" id="autocomplete_'.$dadosAutoComplete['codLead'].'"/>'.$word.'</p>';
	
	}
?>
		<input type="hidden" value="<?php echo $cont;?>" id="total_autocomplete_softbest"/>
		<input type="hidden" value="0" id="atual_autocomplete_softbest"/>
		<input type="hidden" value="leads" id="id_autocomplete_softbest"/>
