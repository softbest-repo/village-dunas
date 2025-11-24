<?php
include('../../f/conf/config.php'); // Ajuste o caminho do seu config

if (isset($_GET['valorDesempenho']) && isset($_GET['descricaoDesempenho'])) {
    $valores = $_GET['valorDesempenho'];
    $descricoes = $_GET['descricaoDesempenho'];
    $ok = true;
    foreach ($valores as $i => $valor) {
        $valorInt = intval($valor);
        $descricao = trim($conn->real_escape_string($descricoes[$i]));
        if ($valorInt > 0 && $descricao != '') {
            $sql = "INSERT INTO desempenhos (valorDesempenho, descricaoDesempenho) VALUES ($valorInt, '$descricao')";
            if (!$conn->query($sql)) {
                $ok = false;
            }
        }
    }
    if ($ok) {
        echo json_encode(['status' => 'sucesso']);
    } else {
        echo json_encode(['status' => 'erro', 'msg' => 'Erro ao inserir dados']);
    }
} else {
    echo json_encode(['status' => 'erro', 'msg' => 'Dados não enviados']);
}

?>
