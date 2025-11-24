<?php
	ob_start();
	
	include("f/conf/config.php");

	$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Logout realizado', '".date('Y-m-d H:i:s')."', 'T')";
	$resultHistorico = $conn->query($sqlHistorico);
							
	setcookie("codAprovado".$cookie, "", time()+0, "/");
	echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login/'>";
 
?>
