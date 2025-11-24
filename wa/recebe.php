<?php
    include('info.php');

    // Webhook de verificação do Meta
    $tokenCheck = $tokenRecebe;
    $tokenRecebido = $_GET['hub_challenge'] ?? '';
    $tokenVerificacion = $_GET['hub_verify_token'] ?? '';

    if ($tokenCheck === $tokenVerificacion) {
        echo $tokenRecebido;
        exit;
    }


    $input = file_get_contents('php://input');
    $data = json_decode($input, true);

    // Verifica se há erro no JSON
    if (json_last_error() !== JSON_ERROR_NONE || !isset($data['entry'])) {
        http_response_code(400); // Bad request
        exit;
    }

    foreach ($data['entry'] as $entry) {
        $idWa = $entry['id'] ?? '';

        foreach ($entry['changes'] as $change) {
            $value = $change['value'] ?? [];

            $produto = $value['messaging_product'] ?? '';
            $contatos = $value['contacts'] ?? [];
            $mensagens = $value['messages'] ?? [];

            foreach ($mensagens as $message) {
                $id = $message['id'] ?? '';
                $dataM = $message['timestamp'] ?? '';
                $tipo = $message['type'] ?? '';
                $texto = '';

                // Trata diferentes tipos de mensagem
                if ($tipo === "button" && isset($message['button']['text'])) {
                    $texto = $message['button']['text'];
                } elseif ($tipo === "text" && isset($message['text']['body'])) {
                    $texto = $message['text']['body'];
                } elseif ($tipo === "audio" && isset($message['audio']['id'])) {
                    $texto = '[Áudio recebido: ' . $message['audio']['id'] . ']';
                } elseif ($tipo === "image" && isset($message['image']['id'])) {
                    $texto = '[Imagem recebida: ' . $message['image']['id'] . ']';
                } elseif ($tipo === "sticker" && isset($message['sticker']['id'])) {
                    $texto = '[Figurinha recebida: ' . $message['sticker']['id'] . ']';
                }

                // Identifica contato relacionado à mensagem
                $numero = $contatos[0]['wa_id'] ?? '';
                $nome = $contatos[0]['profile']['name'] ?? '';

                // Verifica se é originado por anúncio
                if (isset($message['referral'])) {
                    $isAd = "T";
                    $sourceUrl = $message['referral']['source_url'] ?? null;
                } else {
                    $isAd = "F";
                    $sourceUrl = null;
                }

                // Processa mensagem se for válida
                if (!empty($idWa) && !empty($numero) && $numero != $numeroWhats && $numero != $numeroWhats2) {
                    include('../f/conf/config.php');

                    // Evita duplicidade
                    $sqlCheck = "SELECT id FROM logWhats WHERE json_recebido = ? LIMIT 1";
                    $stmtCheck = $conn->prepare($sqlCheck);
                    $stmtCheck->bind_param('s', $input);
                    $stmtCheck->execute();
                    $stmtCheck->store_result();

                    if ($stmtCheck->num_rows === 0) {
                        $sqlInsert = "INSERT INTO logWhats (json_recebido, status) VALUES (?, 'T')";
                        $stmtInsert = $conn->prepare($sqlInsert);
                        $stmtInsert->bind_param('s', $input);
                        $stmtInsert->execute();
                        $logId = $stmtInsert->insert_id;

                        chamarCurl($configUrl . "wa/executa.php");
                    }

                    $conn->close();
                }
            }
        }
    }

    http_response_code(200);

    function chamarCurl($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_exec($ch);
        curl_close($ch);
    }
?>
