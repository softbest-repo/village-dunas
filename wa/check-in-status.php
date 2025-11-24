<?php
	include('info.php');	
	
    $codUsuario = $_GET['codUsuario'];
           
    if (isset($codUsuario) && !empty($codUsuario)) {        
		include('../f/conf/config.php');

        $sqlUsuario = "SELECT * FROM usuariosLogins WHERE codUsuario = $codUsuario AND DATE(dataUsuarioLogin) = CURDATE() ORDER BY codUsuarioLogin DESC LIMIT 1";
        $resultUsuario = $conn->query($sqlUsuario);
        
        if ($resultUsuario && $resultUsuario->num_rows > 0) {
            echo json_encode(['success' => true, 'message' => 'Check-in ja realizado hoje.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Nenhum check-in realizado hoje.']);
        }
        
        $conn->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Parâmetro codUsuario inválido.']);
    }
?>	
