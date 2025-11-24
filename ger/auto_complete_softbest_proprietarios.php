<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('f/conf/config.php');
	include('f/conf/validaAcesso.php');

	$cont = 0;

	$value = $_POST['value'];

	$sqlAutoComplete = "SELECT DISTINCT nomeProprietario, codProprietario FROM proprietarios where locate('".$value."',nomeProprietario) > 0".$filtraUsuario." order by locate('".$value."',nomeProprietario) LIMIT 0,1";
	$resultAutoComplete = $conn->query($sqlAutoComplete);
	$dadosAutoComplete = $resultAutoComplete->fetch_assoc();
	
	if($dadosAutoComplete['codProprietario'] != ""){
		
		$sqlAutoComplete = "SELECT DISTINCT nomeProprietario, codProprietario FROM proprietarios where locate('".$value."',nomeProprietario) > 0".$filtraUsuario." order by locate('".$value."',nomeProprietario) LIMIT 0,5";
		$resultAutoComplete = $conn->query($sqlAutoComplete);
		while($dadosAutoComplete = $resultAutoComplete->fetch_assoc()){
			
			$cont++;
			
			$word = $dadosAutoComplete['nomeProprietario'];
			$wordClean = $dadosAutoComplete['nomeProprietario'];
			$word = preg_replace('/(' . $value . ')/i', '<strong>$1</strong>', $word);
			
			echo '<p class="item sec'.$cont.'" onMouseOver="mouseOverAutoComplete('.$cont.');" onClick="executaClick('.$dadosAutoComplete['codProprietario'].');" style="float:none; margin-right:0px;"><input type="hidden" class="val'.$cont.'" value="'.$wordClean.'" id="autocomplete_'.$dadosAutoComplete['codProprietario'].'"/>'.$word.'</p>';
		
		}

	}		
	
	if($cont == 0){
?>
		<p class="item" style="float:none; margin-right:0px; font-weight:bold;"><?php echo $value;?><span class="icone-novo" onMouseOver="mouseOverNovoItem();" onClick="novoItem('<?php echo $value;?>', 'proprietarioss');">+ Novo Proprietario</span></p>		
<?php
	}
?>
		<input type="hidden" value="<?php echo $cont;?>" id="total_autocomplete_softbest"/>
		<input type="hidden" value="0" id="atual_autocomplete_softbest"/>
		<input type="hidden" value="proprietarios" id="id_autocomplete_softbest"/>
		<input type="hidden" value="1" id="executando_autocomplete_softbest"/>
