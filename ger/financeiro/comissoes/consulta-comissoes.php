<?php 
	include ('../../f/conf/config.php');

	$codUsuario = isset($_GET['codUsuario']) ? intval($_GET['codUsuario']) : 0;
	
	if ($codUsuario > 0) {
		$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ? ORDER BY codUsuario ASC LIMIT 1";
		$stmtUsuario = $conn->prepare($sqlUsuario);
		$stmtUsuario->bind_param("i", $codUsuario);
		$stmtUsuario->execute();
		$resultUsuario = $stmtUsuario->get_result();
		$dadosUsuario = $resultUsuario->fetch_assoc();
		
		$codCorretorLitoral = "";
		$codGerente = "";			

		if (!empty($dadosUsuario)) {

			$tipo = isset($_GET['tipo']) ? $_GET['tipo'] : "";
			$imovel = isset($_GET['imovel']) ? $_GET['imovel'] : "";
			$linha = isset($_GET['linha']) ? $_GET['linha'] : "";
			$comissao = isset($_GET['comissao']) ? $_GET['comissao'] : "";
			$comissaoImobiliaria = isset($_GET['comissao']) ? $_GET['comissao'] : "";
			$comissaoCorretor = isset($_GET['comissaoCorretor']) ? $_GET['comissaoCorretor'] : "";
			$tipoCorretor = isset($_GET['tipoCorretor']) ? $_GET['tipoCorretor'] : "";
			$valorImovel = isset($_GET['valorImovel']) ? $_GET['valorImovel'] : "";
			
			$estrutura = "N";
						
			$sqlComissao = "SELECT * FROM comissoesValores WHERE tipoComissaoValor = ? AND imovelComissaoValor = ? AND vendedorComissaoValor = ? AND linhaComissaoValor = ? AND estruturaComissaoValor = ? ORDER BY codComissaoValor ASC LIMIT 1";
			$stmtComissao = $conn->prepare($sqlComissao);
			$stmtComissao->bind_param("sssss", $tipo, $imovel, $tipoCorretor, $linha, $estrutura);
			$stmtComissao->execute();
			$resultComissao = $stmtComissao->get_result();
			$dadosComissao = $resultComissao->fetch_assoc();
		
			if ($dadosComissao['defineComissaoValor'] == "V") {
				$comissao = $dadosComissao['valorComissaoValor'];
			} else {
				$comissao = $dadosComissao['porcentagemComissaoValor'] / 100 * $comissao;
			}

			echo json_encode([
				'comissao' => number_format($comissao, 2, ',', '.')
			]);

		} else {
			echo json_encode(['erro' => 'Usuário não encontrado']);
		}

		$stmtUsuario->close();
	} else {
		echo json_encode(['erro' => 'Código de usuário inválido']);
	}

	$conn->close();
?>
