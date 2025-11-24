<?php
	ob_start();
	session_start();
	
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);
	
	include('../../f/conf/config.php');
	include('../../f/conf/functions.php');

	$buscaNome = $_GET['buscaNome'];
	$buscaNome = str_replace("-", " ", $buscaNome);
	$buscaNome = str_replace("-", " ", $buscaNome);
	$buscaNome = str_replace("-", " ", $buscaNome);
	$buscaNome = str_replace("-", " ", $buscaNome);
	$buscaNome = str_replace("-", " ", $buscaNome);
	$buscaNome = str_replace("-", " ", $buscaNome);
	$buscaNome = str_replace("'", "&#39;", $buscaNome);	
	$pedacosNome = explode(" ", $buscaNome);	
	$numeroNome = count($pedacosNome);
	$orderNome = explode(" ", $buscaNome);

	if($_SESSION['corretorFiltro'] != ""){
		$filtraUsuario = " and I.codUsuario = '".$_SESSION['corretorFiltro']."'";
	}			
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Codigo</th>
									<th>Corretor</th>
									<th>Cliente</th>
									<th>Imóvel</th>
									<th>Data Venda</th>
									<th>Valor Venda</th>
									<th>Valor Comissão</th>
									<th>Receber</th>
									<th>Contratos</th>
									<th>Docs</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>				
<?php
	$filtro = "";
	
	if($buscaNome != ""){
		$filtro = "(CL.nomeCliente LIKE '%".$orderNome[0]."%' and CL.nomeCliente LIKE '%".$orderNome[1]."%' and CL.nomeCliente LIKE '%".$orderNome[2]."%' and CL.nomeCliente LIKE '%".$orderNome[3]."%' and CL.nomeCliente LIKE '%".$orderNome[4]."%')";
		$ordenacao = "locate('".$orderNome[0]."',CL.nomeCliente), locate('".$orderNome[1]."',CL.nomeCliente), locate('".$orderNome[2]."',CL.nomeCliente), locate('".$orderNome[3]."',CL.nomeCliente), locate('".$orderNome[4]."',CL.nomeCliente),";
	}

	if($numeroNome >= 1){
		$sqlContrato = "SELECT * FROM contratos C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.codContrato != '' and ".$filtro." ORDER BY ".$ordenacao." C.dataContrato DESC, C.codContrato DESC LIMIT 0,30";		
	}
	
	if($buscaNome == ""){
		$sqlContrato = "SELECT * FROM contratos C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.codContrato != '' ORDER BY C.dataContrato DESC, C.codContrato DESC LIMIT 0,30";
	}
	
	$resultContrato = $conn->query($sqlContrato);
	while($dadosContrato = $resultContrato->fetch_assoc()){
		

		if($dadosContrato['statusContrato'] == "T"){
			$status = "icone-pagamento";
			$statusIcone = "ativado";
			$statusPergunta = "desativar";
		}else{
			$status = "icone-pagamento-inativo";
			$statusIcone = "desativado";
			$statusPergunta = "ativar";
		}
								
		$sqlContrato2 = "SELECT * FROM contratos WHERE codContrato = ".$dadosContrato['codContrato']." LIMIT 0,1";
		$resultContrato2 = $conn->query($sqlContrato2);
		$dadosContrato2 = $resultContrato2->fetch_assoc();
								
		$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosContrato2['codUsuario']." LIMIT 0,1";
		$resultUsuario = $conn->query($sqlUsuario);
		$dadosUsuario = $resultUsuario->fetch_assoc();
		
		$imoveis = "Código(s): ";
		
		$cont = 0;
		$sqlImoveis = "SELECT * FROM contratosImoveis CI inner join imoveis I on CI.codImovel = I.codImovel WHERE CI.codContrato = ".$dadosContrato['codContrato']." ORDER BY CI.codContrato ASC";
		$resultImoveis = $conn->query($sqlImoveis);
		while($dadosImoveis = $resultImoveis->fetch_assoc()){											
			$cont++;
			if($cont == 1){
				$imoveis .= $dadosImoveis['codigoImovel'];
			}else{
				$imoveis .= ", ".$dadosImoveis['codigoImovel'];
			}
		}				
?>
								<tr class="tr">
									<td class="dez" style="width:5%; padding:0px; text-align:center;"><a style="<?php echo $cor;?> font-size:16px; font-weight:bold;" href='<?php echo $configUrlGer; ?>comercial/contratos/alterar/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja ver os detalhes o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>?'>#<?php echo $dadosContrato['codContrato'];?></a></td>
									<td class="vinte" style="padding:0px; text-align:center;"><a style="<?php echo $cor;?>" href='<?php echo $configUrlGer; ?>comercial/contratos/alterar/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja ver os detalhes o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>?'><?php echo $dadosUsuario['nomeUsuario'];?></a></td>
									<td class="vinte" style="padding:0px; text-align:center;"><a style="<?php echo $cor;?>" href='<?php echo $configUrlGer; ?>comercial/contratos/alterar/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja ver os detalhes o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>?'><?php echo $dadosContrato['nomeCliente'];?></a></td>
									<td class="vinte" style="padding:0px;"><a style="display:block; text-align:center; <?php echo $cor;?>" href='<?php echo $configUrlGer; ?>comercial/contratos/alterar/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja ver os detalhes o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>'><?php echo $imoveis;?></td>
									<td class="dez"><a style="padding:0px; display:block; text-align:center; <?php echo $cor;?>" href='<?php echo $configUrlGer; ?>comercial/contratos/alterar/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja ver os detalhes o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>'><?php echo data($dadosContrato['dataContrato']);?></td>
									<td class="vinte" style="width:15%;"><a style="padding:0px; display:block; text-align:center; <?php echo $cor;?>" href='<?php echo $configUrlGer; ?>comercial/contratos/alterar/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja ver os detalhes o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>'>R$ <?php echo number_format($dadosContrato['valorContrato'], 2, ",", ".");?></td>
									<td class="vinte" style="width:15%;"><a style="padding:0px; display:block; text-align:center; <?php echo $cor;?>" href='<?php echo $configUrlGer; ?>comercial/contratos/alterar/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja ver os detalhes o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>'>R$ <?php echo number_format($dadosContrato['valorComissao'], 2, ",", ".");?></td>
									<td class="botoes">
										<form action="<?php echo $configUrlGer;?>financeiro/contas-receber/" method="post">
											<input type="hidden" value="<?php echo $dadosContrato['codContrato'];?>" name="codContrato"/>
											<input type="hidden" value="<?php echo $dadosContrato['nomeCliente'];?>" name="nomeCliente"/>
											<input type="hidden" value="<?php echo $dadosContrato['valorContrato'];?>" name="valorVenda"/>
<?php
						if($dadosContrato['statusContrato'] == "T"){
?>
											<input type="submit" value="" style="width:50px; height:42px; border:none; outline:none; cursor:pointer; background:transparent url('<?php echo $configUrl; ?>f/i/receber-dinheiro.svg') center center no-repeat; background-size:40px;" alt="icone"><span style="font-size:11px;">Venda</span>
<?php
						}else{
?>	
											<input type="button" value="" style="width:50px; height:42px; filter: grayscale(100%); border:none; outline:none; background:transparent url('<?php echo $configUrl; ?>f/i/receber-dinheiro.svg') center center no-repeat; background-size:40px;" alt="icone"><span style="font-size:11px;">Venda</span>
<?php
						}
?>
										</form>
									</td>

									<td class="botoes" style="padding:0px;"><a style="<?php echo $cor;?>" href='<?php echo $configUrl; ?>comercial/contratos/contratos/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja criar imprimir contratos do cliente <?php echo $dadosContrato['nomeCliente'] ?>?'><img style="padding-top:10px;" src="<?php echo $configUrl;?>f/i/registro-titulos2.png" alt="icone" width="50"/></a></td>
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>comercial/contratos/gerenciar-documentos/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja cadastrar documentos para o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>									
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>comercial/contratos/alterar/<?php echo $dadosContrato['codContrato'] ?>/' title='Deseja alterar o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
<?php
						if($dadosContrato['statusContrato'] == "T"){
?>
									<td class="botoes" style="padding:0px;"><a href='javascript: confirmaExclusao(<?php echo $dadosContrato['codContrato'] ?>, "<?php echo htmlspecialchars($dadosContrato['nomeCliente']) ?>");' title='Deseja excluir o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
<?php
						}else{
?>
									<td class="botoes" style="padding:0px;"><a title='Deseja excluir o contrato do cliente <?php echo $dadosContrato['nomeCliente'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
<?php
						}
?>
								</tr>
<?php
	}
?>
								<script type="text/javascript">
									function alteraCor(contrato){
										var $rt1 = jQuery.noConflict();

										$rt1("#valorCusto"+contrato).css("border", "1px solid #FF0000");
									}
									function alteraCusto(contrato, valor){
										var $rt = jQuery.noConflict();
										
										var valor = valor.replace(".", "");
										var valor = valor.replace(".", "");
										var valor = valor.replace(",", ".");		
																			
										$rt.post("<?php echo $configUrlGer;?>comercial/contratos/salva-custo.php", {codContrato: contrato, valorComissaoContrato: valor}, function(data){		
											$rt("#valorCusto"+contrato).css("border", "1px solid #0000FF");
										});											

									}
									
									function confirmaExclusao(cod, nome){
										if(confirm("Deseja excluir o contrato do cliente "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>comercial/contratos/excluir/'+cod+'/';
										}
									}							 

									function enviaForm(cod){
										document.getElementById("formContrato"+cod).submit();
									}
								</script> 
							</table>	
