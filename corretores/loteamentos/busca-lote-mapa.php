<?php 
	ob_start();

	if ($_SERVER['REQUEST_METHOD'] === 'POST') {
		
		include ('../f/conf/config.php');
	
		$codLote = $_POST['codLote'];

		function calcularParcela($valorFinanciado, $taxa, $parcelas) {
			if ($taxa == "0.00") {
				$parcela = $valorFinanciado / $parcelas;
			} else {
				$taxa = $taxa / 100;
				$parcela = ($valorFinanciado * $taxa) / (1 - pow(1 + $taxa, -$parcelas));
			}
			
			return $parcela;
		}

		function calcularParcelaComReforco($valorFinanciado, $taxaPercent, $parcelas, $valorReforco, $qtdReforcos) {
			$i = $taxaPercent / 100;
			
			// meses em que caem os reforços (de 12 em 12)
			$mesesReforcos = [];
			for ($k = 1; $k <= $qtdReforcos; $k++) {
				$mesesReforcos[] = $k * 12;
			}
		
			// valor presente dos reforços
			$pvReforcos = 0;
			foreach ($mesesReforcos as $m) {
				$pvReforcos += $valorReforco / pow(1 + $i, $m);
			}
		
			// fator de anuidade (parcela mensal sem reforço)
			$fator = 0;
			for ($t = 1; $t <= $parcelas; $t++) {
				$fator += 1 / pow(1 + $i, $t);
			}
		
			// resolve PMT
			$pmt = ($valorFinanciado - $pvReforcos) / $fator;
		
			return $pmt;
		}		

		$sqlLote = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra WHERE L.codLote = ".$conn->real_escape_string($codLote)." ORDER BY L.codLote ASC LIMIT 1";
		$resultLote = $conn->query($sqlLote);
		$dadosLote = $resultLote->fetch_assoc();

		$sqlLoteamento = "SELECT * FROM loteamentos WHERE statusLoteamento = 'T' AND codLoteamento = '".$conn->real_escape_string($dadosLote['codLoteamento'])."' ORDER BY codLoteamento ASC LIMIT 1";
		$resultLoteamento = $conn->query($sqlLoteamento);
		$dadosLoteamento = $resultLoteamento->fetch_assoc();
				
		if ($resultLote->num_rows > 0) {
			
			if($dadosLote['entradaLote'] == "0.00" && $dadosLote['entradaELote'] == "0"){
				if($dadosLoteamento['entradaLoteamento'] == "0.00" && $dadosLoteamento['entradaELoteamento'] == "0"){
					$entrada = 0;
				}else{
					if($dadosLoteamento['tipoELoteamento'] == "P"){
						$entrada = ($dadosLote['precoLote'] * $dadosLoteamento['entradaELoteamento']) / 100;
					}else{
						$entrada = $dadosLoteamento['entradaLoteamento'];
					}
				}
			}else{
				if($dadosLote['tipoELote'] == "P"){
					$entrada = ($dadosLote['precoLote'] * $dadosLote['entradaELote']) / 100;
				}else{
					$entrada = $dadosLote['entradaLote'];
				}
			}
			
			if($dadosLote['taxaLote'] == "0.00"){
				$taxa = $dadosLoteamento['taxaLoteamento'];
			}else{
				$taxa = $dadosLote['taxaLote'];
			}
			
			if($dadosLote['parcelasLote'] == "0" || $dadosLote['parcelasLote'] == ""){
				$parcelas = ($dadosLoteamento['parcelasLoteamento'] != "0") ? $dadosLoteamento['parcelasLoteamento'] : "0";
			}else{
				$parcelas = $dadosLote['parcelasLote'];
			}
			
			if($dadosLote['descontoLote'] == "0"){
				$desconto = ($dadosLoteamento['descontoLoteamento'] != "0") ? $dadosLoteamento['descontoLoteamento'] : "0";
				$valorVista = $desconto / 100 * $dadosLote['precoLote'];
				$valorVista = $dadosLote['precoLote'] - $valorVista;
				$valorVista = "R$ ".number_format($valorVista, 2, ",", ".");
			}else{
				if($dadosLote['descontoLote'] > 0){
					$desconto = $dadosLote['descontoLote'];
					$valorVista = $desconto / 100 * $dadosLote['precoLote'];
					$valorVista = $dadosLote['precoLote'] - $valorVista;
					$valorVista = "R$ ".number_format($valorVista, 2, ",", ".");
				}else{
					$desconto = 0;
					$valorVista = 0;					
				}
			}
						
			if($dadosLote['precoLote'] != "0.00"){
				$preco = "R$ ".number_format($dadosLote['precoLote'], 2, ",", ".");
				$valorFinanciado = $dadosLote['precoLote'] - $entrada;
			}else{
				$preco = "Consulte";
				$valorFinanciado = "";
			}
			
			if (strpos($parcelas, ",") !== false) {
				$parcelasArray = explode(",", $parcelas);
			} else {
				$parcelasArray = [$parcelas];
			}
			$parcelasString = "";
			$contaArray = count($parcelasArray);

			$parcelasFormatadas = [];
			foreach ($parcelasArray as $parcela) {
				$parcelasFormatadas[] = $parcela . "x";
			}

			$parcelasStringNumero = implode(", ", $parcelasFormatadas);
			
			if ($entrada != "0.00" && !empty($parcelas) && $valorFinanciado != "0.00") {
				foreach ($parcelasArray as $parcela) {
					if($dadosLoteamento['reforcoLoteamento'] != "0.00"){
						if($parcela == 12){
							$reforco = 1;
						}else
						if($parcela == 24){
							$reforco = 2;
						}else
						if($parcela == 36){
							$reforco = 3;
						}else
						if($parcela == 48){
							$reforco = 4;
						}else
						if($parcela == 60){
							$reforco = 5;
						}else
						if($parcela == 72){
							$reforco = 6;
						}else
						if($parcela == 90){
							$reforco = 7;
						}else
						if($parcela == 108){
							$reforco = 9;
						}else
						if($parcela == 120){
							$reforco = 10;
						}
						$taxaReforco = $dadosLoteamento['reforcoLoteamento'];
						$valorReforco = $taxaReforco / 100 * $dadosLote['precoLote'];
						$parcelaReforco = $valorReforco / $reforco;	
						$valorParcela = calcularParcelaComReforco($valorFinanciado, $taxa, $parcela, $parcelaReforco, $reforco);

						if($contaArray == 1){
							$parcelasString = "R$ ".number_format($valorParcela, 2, ",", ".");
						}else{
							$parcelasString .= "<br/>R$ ".number_format($valorParcela, 2, ",", ".")." (".$parcela."x)";												
						}

						if($contaArray == 1){
							$parcelasString2 = "<br/>".$reforco." reforço(s) de R$ ".number_format($parcelaReforco, 2, ",", ".");
						}else{
							$parcelasString2 .= "<br/>".$reforco." reforço(s) de R$ ".number_format($parcelaReforco, 2, ",", ".")." (".$parcela."x)";					
						}
					}else{
						$valorParcela = calcularParcela($valorFinanciado, $taxa, $parcela);

						if($contaArray == 1){
							$parcelasString = "R$ ".number_format($valorParcela, 2, ",", ".");
						}else{
							$parcelasString .= "<br/>R$ ".number_format($valorParcela, 2, ",", ".")." (".$parcela."x)";						
						}

						$parcelasString2 = "";
					}

				}
				$entrada = number_format($entrada, 2, ",", ".");
				$taxa = number_format($taxa, 2, ",", ".");
			} else {
				$entrada = "";
				$taxa = "";
				$parcelas = "";
				$calculaParcelas = "";
				$parcelasStringNumero = "";
			}
			
			if($dadosLote['frenteLote'] != ""){
				$frenteFundo = $dadosLote['frenteLote']."x ".$dadosLote['fundosLote']." = ".$dadosLote['areaLote']."m²";
			}else{
				$frenteFundo = $dadosLote['areaLote']."m²";
			}
			$posicaoSolar = ($dadosLote['posicaoLote'] != "") ? $dadosLote['posicaoLote'] : '-';

			$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosLote['codLote']." or codUnido = ".$dadosLote['codLote']." ORDER BY codLote ASC LIMIT 0,1";
			$resultUniao = $conn->query($sqlUniao);
			$dadosUniao = $resultUniao->fetch_assoc();
			
			if($dadosUniao['codLote'] != ""){
				$unido = "T";
			}else{
				$unido = "F";
			}
			
			echo json_encode([
				'success' => true,
				'obs' => $dadosLote['obsLote'],
				'nomeLote' => $dadosLote['nomeLote'],
				'nomeQuadra' => $dadosLote['nomeQuadra'],
				'bairro' => $dadosLoteamento['nomeLoteamento'],
				'frenteFundo' => $frenteFundo,
				'posicaoSolar' => $posicaoSolar,
				'valor' => $preco,
				'valorVista' => $valorVista,
				'desconto' => $desconto,
				'entrada' => $entrada,
				'taxa' => "0.00",
				'unido' => $unido,
				'parcelas' => $parcelasStringNumero,
				'reforcos' => $parcelasString2,
				'valor_parcela' => $parcelasString
			]);
		} else {
			echo json_encode(['success' => false, 'message' => 'Lote não encontrado.']);
		}

		$conn->close();
	}
