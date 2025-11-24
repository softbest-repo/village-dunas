<?php
ob_start();
session_start();
include('f/conf/config.php');
include('f/conf/controleAcesso.php');

setcookie("loginAprovado".$cookie, "", time()+14400,"/");
setcookie("codAprovado".$cookie, "", time()+14400,"/");

$sqlDeleta = "DELETE FROM controleAcesso WHERE codControle = ".$_COOKIE['controleAprovado'.$cookie];
$resultDeleta = $conn->query($sqlDeleta);

setcookie("controleAprovado".$cookie, "", time()+14400,"/");
echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login.php'>";
?>
