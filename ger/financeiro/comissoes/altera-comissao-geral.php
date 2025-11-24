<?php
session_start();

include ('../../f/conf/config.php');
include ('../../f/conf/controleAcesso.php');

// Recebe os dados do POST
$codComissao = isset($_POST['codComissao']) ? intval($_POST['codComissao']) : 0;
$contrato = isset($_POST['data']) ? trim($_POST['contrato']) : '';
$data = isset($_POST['data']) ? trim($_POST['data']) : '';
$valorImovel = isset($_POST['valorImovel']) ? trim($_POST['valorImovel']) : '';
$valorComissao = isset($_POST['valorComissao']) ? trim($_POST['valorComissao']) : '';
$cidade = isset($_POST['cidade']) ? trim($_POST['cidade']) : '';
$bairro = isset($_POST['bairro']) ? trim($_POST['bairro']) : '';
$quadra = isset($_POST['quadra']) ? trim($_POST['quadra']) : '';
$lote = isset($_POST['lote']) ? trim($_POST['lote']) : '';

// Retirado item área

if ($codComissao > 0) {
    $sqlComissao = "SELECT * FROM comissoes WHERE codComissao = $codComissao LIMIT 1";
    $resultComissao = $conn->query($sqlComissao);
    $dadosComissao = $resultComissao->fetch_assoc();

    if ($dadosComissao && isset($dadosComissao['codComissao'])) {
        $sqlUpdate = "UPDATE comissoes SET codContrato = '".$contrato."', dataComissao = '".$data."', valorImovelComissao = '".str_replace(",", ".", str_replace(".", "",$valorImovel))."', imobiliariaComissao = '".str_replace(",", ".", str_replace(".", "", subject: $valorComissao))."', codCidade = '".$cidade."', codBairro = '".$bairro."', codQuadra = '".$quadra."', codLote = '".$lote."' WHERE codComissao = '".$codComissao."'";
		$resultUpdate = $conn->query($sqlUpdate);

        if ($resultUpdate == 1) {
            echo "ok";
        } else {
            echo "erro";
        }
    } else {
        echo "erro";
    }
} else {
    echo "erro";
}

$conn->close();
