<?php
// Script para excluir o check-in do corretor

// Permitir apenas requisições POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Método não permitido.'
    ]);
    exit;
}

// Incluir configuração do banco de dados
include('f/conf/config.php');

// Receber o código do usuário
$codUsuario = isset($_POST['codUsuario']) ? intval($_POST['codUsuario']) : 0;

if ($codUsuario <= 0) {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Código do usuário inválido.'
    ]);
    exit;
}

$sql = "DELETE FROM usuariosLogins WHERE codUsuario = $codUsuario AND dataUsuarioLogin >= CONCAT(CURDATE(), ' 00:00:00') AND dataUsuarioLogin < CONCAT(DATE_ADD(CURDATE(), INTERVAL 1 DAY), ' 00:00:00')";

if ($conn->query($sql) === TRUE) {

    $sqlUpdateFila = "UPDATE fila SET loginFila = NULL WHERE codUsuario = $codUsuario AND loginFila IS NOT NULL";
    $conn->query($sqlUpdateFila);

    echo json_encode([
        'status' => 'ok',
        'mensagem' => 'Check-in excluído com sucesso.'
    ]);
} else {
    echo json_encode([
        'status' => 'erro',
        'mensagem' => 'Erro ao excluir o check-in: ' . $conn->error
    ]);
}
exit;
