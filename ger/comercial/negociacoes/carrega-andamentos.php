<?php
	ob_start();
	session_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');
	include ('../../f/conf/functions.php');
	
	$codNegociacao = $_GET['codNegociacao'];		
?>		
									<table class="tabela-menus" style="width:727px; margin-top:10px;">	
										<tr class="titulo-tabela" border="none" style="height:25px;">
											<th class="canto-esq" style="font-size:13px; height:25px; text-align:left; padding-left:20px;">Usuário | Data</th>
											<th class="canto-dir" style="font-size:13px; height:25px; text-align:left; padding-left:20px;">Descrição</th>
										</tr>																				
<?php	
	$cont = 0;
	
	$sqlDecorrer = "SELECT ND.*, CO.nomeUsuario FROM negociacaoDecorrer ND inner join usuarios CO on ND.codUsuario = CO.codUsuario WHERE ND.codNegociacao = ".$codNegociacao." ORDER BY ND.codDecorrer DESC";	
	$resultDecorrer = $conn->query($sqlDecorrer);
	while($dadosDecorrer = $resultDecorrer->fetch_assoc()){
		
		$cont++;
		
		$descricaoDecorrer = str_replace("\r\n", "<br/>", $dadosDecorrer['mensagemDecorrer']);
?>
										<tr class="tr" style="background:#f5f5f5;">
											<td style="width:25%; text-align:left; padding-left:20px;"><strong><?php echo $dadosDecorrer['nomeUsuario'];?></strong> | <?php echo data($dadosDecorrer['dataDecorrer']);?></td>
											<td style="width:75%; text-align:left; padding-left:20px;"><?php echo $descricaoDecorrer;?></td>
										</tr>
<?php
	}
?>
									</table>
<?php
	if($cont == 0){

?>
									<p class="msg" style="font-size:14px; padding-top:20px; padding-bottom:20px;">Nenhum andamento cadastrado</p>
<?php
	}
?>
