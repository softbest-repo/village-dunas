<?php

include ('../../f/conf/config.php');

if (isset($_GET['proprietario'])) {
    $proprietario = trim($_GET['proprietario']);

    $sqlProprietario = "SELECT * FROM proprietarios WHERE TRIM(LOWER(nomeProprietario)) = TRIM(LOWER('".$proprietario."')) LIMIT 0,1";
    $resultProprietario = $conn->query($sqlProprietario);
    $dadosProprietario = $resultProprietario->fetch_assoc();
    
    if ($resultProprietario->num_rows > 0) {
        echo trim($dadosProprietario['celularProprietario']);
    } else {
        echo "Proprietário não encontrado.";
    }
}
?>