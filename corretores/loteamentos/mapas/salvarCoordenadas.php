<?php
	include('../../f/conf/config.php');

	// Obtém os dados enviados pelo JavaScript
	$data = file_get_contents('php://input');
	$input = json_decode($data, true); // Decodifica o JSON em um array associativo

	$codLoteamento = $input['codLoteamento'];
	$areas = $input['areas'];

	if (!empty($areas)) {
		foreach ($areas as $area) {
			$lote = $area['numero']; // Número do lote
			$quadra = substr($area['cod'], 0, 2); // Quadra é derivada dos dois primeiros dígitos do 'cod'
			$x1 = $area['coords'][0];
			$y1 = $area['coords'][1];
			$x2 = $area['coords'][2];
			$y2 = $area['coords'][3];

			// Verifica se o lote já existe na tabela
			$sqlCheck = "SELECT * FROM lotesCoords WHERE lote = '$lote' AND quadra = '$quadra' AND codLoteamento = $codLoteamento";
			$resultCheck = $conn->query($sqlCheck);

			if ($resultCheck->num_rows == 0) {
				// Insere os dados na tabela lotesCoords
				$sqlInsert = "INSERT INTO lotesCoords (codLoteamento, lote, quadra, x1, y1, x2, y2) 
							  VALUES ($codLoteamento, '$lote', '$quadra', $x1, $y1, $x2, $y2)";
				if ($conn->query($sqlInsert) === TRUE) {
					echo "Coordenadas do lote $lote inseridas com sucesso.\n";
				} else {
					echo "Erro ao inserir coordenadas: " . $conn->error . "\n";
				}
			} else {
				echo "Coordenadas do lote $lote já existem.\n";
			}
		}
	} else {
		echo "Nenhum dado recebido.\n";
	}

	$conn->close();
?>
