<?php
	include('../../f/conf/config.php');
	include('../../f/conf/functions.php');

	function floorp($val, $precision)
	{
		$mult = pow(10, $precision);
		return floor($val * $mult) / $mult;
	}
	
	$saldo = $_POST['saldo'];
	$parcela = $_POST['parcela'];
	$Vparcela = $_POST['Vparcela'];
	$vencimento = $_POST['vencimento'];
	$tipoPagamento = $_POST['tipoPagamento'];
	
	$dataInicio = "";
	$data = $vencimento;

	$saldo = str_replace(".", "", $saldo);
	$saldo = str_replace(".", "", $saldo);
	$saldo = str_replace(",", ".", $saldo);
	
	$Vparcela = str_replace(".", "", $Vparcela);
	$Vparcela = str_replace(".", "", $Vparcela);
	$Vparcela = str_replace(",", ".", $Vparcela);

	$VparcelRedonda = $Vparcela;

	$dimParc = $parcela - 1;
	$multiParc = $dimParc * $Vparcela;
	$dimSaldo = $saldo - $multiParc;
		
	for ($i = 1; $i <= $parcela; $i++) {
		$mesSoma = $i - 1;
		if ($dataInicio == "") {
			$dataInicio = $data;
			$dataAnterior = $data;
		} else {
			$date = DateTime::createFromFormat('d/m/Y', $data);
			if ($date) {
				$date->modify('+'.$mesSoma.' month');
				$dataInicio = $date->format('d/m/Y');
				
				$quebraDataAnterior = explode("/", $dataAnterior);
				if($quebraDataAnterior[1] == "01"){
					$quebraDataInicio = explode("/", $dataInicio);
					if($quebraDataInicio[1] == "03"){
						$ano = $quebraDataInicio[2];
						if(($ano % 4 == 0 && $ano % 100 != 0) || $ano % 400 == 0){
							$dataInicio = "29/02/".$quebraDataInicio[2];
						}else{
							$dataInicio = "28/02/".$quebraDataInicio[2];
						}
					}
				}

				$quebraDataInicio = explode("/", $dataInicio);
				if($quebraDataAnterior[0] == 31){
					$mes = $quebraDataAnterior[1] + 1;
					if($mes == 4 || $mes == 6 || $mes == 9 || $mes == 11){
						$date2 = DateTime::createFromFormat('d/m/Y', $dataInicio);
						if($date2){
							$date2->modify('-1 day');
							$dataInicio = $date2->format('d/m/Y');					
						}
					}
				}

				$dataAnterior = $dataInicio;
			}
		}
			
		if($i == $parcela){
			$VparcelRedonda = $dimSaldo;
		}				
?>
		<div id="parcela-<?php echo $i;?>" style="border:1px solid #ccc; background-color:#fBfBfB; padding:10px; margin-top:<?php echo $i == 1 ? '0px' : '20px';?>;">
			<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Nº: <span class="obrigatorio"> * </span></label>
			<input style="width:20px;" class="campo" type="text" name="parcela<?php echo $i;?>" required readonly id="parcela<?php echo $i;?>" value="<?php echo $i;?>"/></p>
			
			<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Vencimento:</label>
			<input class="campo" type="text" required id="vencimento<?php echo $i;?>" readonly name="vencimento<?php echo $i;?>" style="width:120px;" value="<?php echo $dataInicio;?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data)"/></p>
			
			<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Valor:</label>
			<input style="width:100px;" required class="campo" type="text" id="valor<?php echo $i;?>" readonly name="valor<?php echo $i;?>" value="<?php echo number_format($VparcelRedonda, 2, ",", ".");?>" onKeyUp="moedaDois(this);"/></p>

			<p class="bloco-campo" style="margin-bottom:0px;"><label>Meio de Pagamento: <span class="obrigatorio"> * </span></label>
				<select class="campo" required onChange="alteraMeio(this.value, <?php echo $i;?>);" id="tipo-pagamento<?php echo $i;?>" name="tipo-pagamento<?php echo $i;?>" style="width:217px;">
					<option value="">Selecione</option>
					<option value="PI" <?php echo $tipoPagamento == "PI" ? '/SELECTED/' : '';?>>Pix</option>
					<option value="D" <?php echo $tipoPagamento == "D" ? '/SELECTED/' : '';?>>Dinheiro</option>
					<option value="C" <?php echo $tipoPagamento == "C" ? '/SELECTED/' : '';?>>Cartão</option>
					<option value="CH" <?php echo $tipoPagamento == "CH" ? '/SELECTED/' : '';?>>Cheque</option>
					<option value="B" <?php echo $tipoPagamento == "B" ? '/SELECTED/' : '';?>>Boleto</option>
					<option value="TD" <?php echo $tipoPagamento == "TD" ? '/SELECTED/' : '';?>>Transf/Depósito</option>
					<option value="P" <?php echo $tipoPagamento == "P" ? '/SELECTED/' : '';?>>Permuta</option>
				</select>
			</p>
						
			<div id="form-cheque<?php echo $i;?>" style="display:<?php echo $tipoPagamento == "CH" ? 'block' : 'none';?>;">
				
				<br/>
				
				<p class="titulo-cheques" style="font-size:16px; color:#718B8F; text-decoration:underline; font-weight:bold; padding-bottom:10px;">Cheque</p>
				
				<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Banco:</label>
					<select class="campo" id="bancoChequeAvista<?php echo $i;?>" name="banco<?php echo $i;?>" onChange="insereBanco(this.value, <?php echo $i;?>);" style="width:170px;">
						<option value="">Selecione</option>
<?php 
		$sqlBancoConta = "SELECT * FROM bancosConta WHERE statusBancoConta = 'T' ORDER BY nomeBancoConta ASC"; 
		$resultBancoConta = $conn->query($sqlBancoConta);
		while($dadosBancoConta = $resultBancoConta->fetch_assoc()){
?>
						<option value='<?php echo $dadosBancoConta['codigoBancoConta'];?>' <?php echo $dadosBancoConta['codBancoConta'] == $_SESSION['bancoCheque'] ? '/SELECTED/' : '';?>><?php echo $dadosBancoConta['nomeBancoConta'];?></option>
<?php 
		} 
?>
					</select>
				</p>
				
				<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Nº Banco:</label>
				<input class="campo" size="10" id="numeroBancoCheque<?php echo $i;?>" readonly type="text" name="numeroBancoCheque<?php echo $i;?>" value="" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer)"/></p>
				
				<p class="bloco-campo" style="margin-bottom:0px;"><label>Nome:</label>
				<input class="campo" style="width:221px;" id="nomeCheque<?php echo $i;?>" type="text" name="nomeCheque<?php echo $i;?>" value="" /></p>
				
				<br class="clear" />
				
				<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Agência:</label>
				<input class="campo" type="text" id="agenciaCheque<?php echo $i;?>" style="width:113px;" name="agenciaCheque<?php echo $i;?>" value="" /></p>
				
				<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Conta:</label>
				<input class="campo" type="text" id="contaCheque<?php echo $i;?>" style="width:113px;" name="contaCheque<?php echo $i;?>" value="" /></p>
				
				<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Nº Cheque:</label>
				<input class="campo" type="text" id="numeroCheque<?php echo $i;?>" style="width:111px;" name="numeroCheque<?php echo $i;?>" value="" /></p>
				
				<p class="bloco-campo" style="margin-bottom:0px;"><label>Bom para:</label>
				<input class="campo" type="text" id="paraCheque<?php echo $i;?>" style="width:112px;" name="paraCheque<?php echo $i;?>" value="" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data)"/></p>
			</div>		
		</div>		
<?php
	}
?>		
