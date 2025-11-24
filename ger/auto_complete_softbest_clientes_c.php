<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('f/conf/config.php');
	include('f/conf/conexao.php');

	$value = $_POST['value'];
	
	$cont = 0;
	
	$sqlAutoComplete = "SELECT * FROM clientes where locate('".$value."',nomeCliente) > 0 group by nomeCliente order by locate('".$value."',nomeCliente) limit 10";
	$resultAutoComplete = $conn->query($sqlAutoComplete);
	while($dadosAutoComplete = $resultAutoComplete->fetch_assoc()){
		
		$cont++;
		
		$word = $dadosAutoComplete['nomeCliente'];
		$wordClean = $dadosAutoComplete['nomeCliente'];
		$word = preg_replace('/(' . $value . ')/i', '<strong>$1</strong>', $word);
		
		echo '<p class="item sec'.$cont.'" onMouseOver="mouseOverAutoComplete('.$cont.');" onClick="executaClick('.$dadosAutoComplete['codCliente'].');" style="float:none; margin-right:0px;"><input type="hidden" class="val'.$cont.'" value="'.$wordClean.'" id="autocomplete_'.$dadosAutoComplete['codCliente'].'"/>'.$word.'</p>';
	
	}
	
	if($cont == 0){
?>
		<p class="item" style="float:none; margin-right:0px; font-weight:bold;"><?php echo $value;?><span class="icone-novo" onMouseOver="mouseOverNovoItem();" onClick="novoItem('<?php echo $value;?>', 'clientes_c');">+ Novo Cliente</span></p>		
<?php
	}
?>
		<input type="hidden" value="<?php echo $cont;?>" id="total_autocomplete_softbest"/>
		<input type="hidden" value="0" id="atual_autocomplete_softbest"/>
		<input type="hidden" value="clientes_c" id="id_autocomplete_softbest"/>
