<?php
	ob_start();
	session_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include ('../../f/conf/config.php');
	include ('../../f/conf/functions.php');
	
	$codNegociacaoAnexo = $_GET['codNegociacaoAnexo'];		
	$codNegociacao = $_GET['codNegociacao'];		
	
	$sqlConsultaDelete = "SELECT * FROM negociacoesAnexos WHERE codNegociacaoAnexo = ".$codNegociacaoAnexo;
	$resultConsultaDelete = $conn->query($sqlConsultaDelete);
	$dadosConsultaDelete = $resultConsultaDelete->fetch_assoc();

	$sqlDelete = "DELETE FROM negociacoesAnexos WHERE codNegociacaoAnexo = ".$codNegociacaoAnexo;
	$resultDelete = $conn->query($sqlDelete);
?>		
									<table class="tabela-menus" style="width:727px; margin-top:10px;">	
										<tr class="titulo-tabela" border="none" style="height:25px;">
											<th class="canto-esq" style="font-size:13px; height:25px; text-align:left; padding-left:20px;">Usuário | Data</th>
											<th style="font-size:13px; height:25px; text-align:left; padding-left:20px;">Anexo</th>
											<th class="canto-dir" style="font-size:13px; height:25px; text-align:center;">Excluir</th>
										</tr>																				
<?php	
	$cont = 0;
	
	$sqlAnexo = "SELECT * FROM negociacoesAnexos NA inner join usuarios U on NA.codUsuario = U.codUsuario WHERE NA.codNegociacao = ".$codNegociacao." ORDER BY NA.codNegociacaoAnexo DESC";	
	$resultAnexo = $conn->query($sqlAnexo);
	while($dadosAnexo = $resultAnexo->fetch_assoc()){
	
		$cont++;
		
		$replaceNome = str_replace(".".$dadosAnexo['extNegociacaoAnexo'], "", $dadosAnexo['nomeNegociacaoAnexo']);
?>
										<tr class="tr" style="background:#f5f5f5;">
											<td style="width:25%; text-align:left; padding-left:20px;"><strong><?php echo $dadosAnexo['nomeUsuario'];?></strong> | <?php echo data($dadosAnexo['dataNegociacaoAnexo']);?></td>
											<td style="width:65%; text-align:left; padding-left:20px;"><a target="_blank" download="<?php echo $replaceNome.".".$dadosAnexo['extNegociacaoAnexo'];?>" href="<?php echo $configUrlGer.'f/negociacoesAnexo/'.$dadosAnexo['codNegociacao'].'-'.$dadosAnexo['codNegociacaoAnexo'].'-O.'.$dadosAnexo['extNegociacaoAnexo'];?>"><?php echo $replaceNome.".".$dadosAnexo['extNegociacaoAnexo'];?></a></td>
											<td style="width:10%;"><span style="width:20px; height:19px; display:table; margin:0 auto; color:#FFF; padding-top:1px; cursor:pointer; text-align:center; background-color:#FF0000; border-radius:100%;" onClick="excluiAnexo(<?php echo $dadosAnexo['codNegociacaoAnexo'];?>)">X</span></td>
										</tr>
<?php
	}
?>
									</table>
<?php
	if($cont == 0){

?>
									<p class="msg" style="font-size:14px; padding-top:20px; padding-bottom:20px;">Nenhum anexo cadastrado</p>
<?php
	}
?>
