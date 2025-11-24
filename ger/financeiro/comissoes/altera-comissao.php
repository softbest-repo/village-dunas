<?php 
	session_start();
	
	include ('../../f/conf/config.php');
	include ('../../f/conf/controleAcesso.php');

	$codComissao = isset($_POST['codComissao']) ? intval($_POST['codComissao']) : 0;
	$codComissaoCorretor = isset($_POST['codComissaoCorretor']) ? intval($_POST['codComissaoCorretor']) : 0;
	
	$tipoAltera = $_POST['tipoAltera'];
	$comissaoAltera = $_POST['comissaoAltera'];
	$comissaoAltera = str_replace(".", "", $comissaoAltera);
	$comissaoAltera = str_replace(",", ".", $comissaoAltera);
	$corretorAltera = $_POST['corretorAltera'];
	$observacaoAltera = $_POST['observacaoAltera'];
	
	if ($codComissao > 0 && $codComissaoCorretor >= 0) {
		
		$sqlComissao = "SELECT * FROM comissoes WHERE codComissao = ".$codComissao." ORDER BY codComissao DESC LIMIT 0,1";
		$resultComissao = $conn->query($sqlComissao);
		$dadosComissao = $resultComissao->fetch_assoc();

		$sqlBairro = "SELECT * FROM bairros WHERE codBairro = ".$dadosComissao['codBairro']." LIMIT 0,1";
		$resultBairro = $conn->query($sqlBairro);
		$dadosBairro = $resultBairro->fetch_assoc();				
		
		$sqlQuadra = "SELECT * FROM quadras WHERE codQuadra = ".$dadosComissao['codQuadra']." LIMIT 0,1";
		$resultQuadra = $conn->query($sqlQuadra);
		$dadosQuadra = $resultQuadra->fetch_assoc();				
		
		$sqlLote = "SELECT * FROM lotes WHERE codLote = ".$dadosComissao['codLote']." LIMIT 0,1";
		$resultLote = $conn->query($sqlLote);
		$dadosLote = $resultLote->fetch_assoc();				

		if($dadosComissao['negociacaoComissao'] == "V"){
			if($dadosComissao['tipoImovelComissao'] != ""){
				$background = "background:#60c6ff;";
				$corBolinha = "background-color:#60c6ff;";
				$corBola = "color:#60c6ff;";	
			}else{
				$background = "background:#4ee900;";
				$corBolinha = "background-color:#4ee900;";
				$corBola = "color:#4ee900;";
			}
		}else{
			$background = "background:#ff7070;";
			$corBolinha = "background-color:#ff7070;";
			$corBola = "color:#ff7070;";	
		}	
								
		if($dadosComissao['codComissao'] != ""){
		
			$sqlCorretor = "SELECT * FROM comissoesCorretores WHERE codComissaoCorretor = ".$codComissaoCorretor." ORDER BY codComissaoCorretor DESC LIMIT 0,1";
			$resultCorretor = $conn->query($sqlCorretor);
			$dadosCorretor = $resultCorretor->fetch_assoc();
				
			if($dadosCorretor['codComissaoCorretor'] != ""){
				
				$quebraUsuario = explode("-", $corretorAltera);
				
				$sqlUpdate = "UPDATE comissoesCorretores SET codUsuario = '".$quebraUsuario[1]."', valorComissaoCorretor = '".$comissaoAltera."', linhaComissaoCorretor = '".$tipoAltera."', obsComissaoCorretor = '".$observacaoAltera."' WHERE codComissaoCorretor = ".$codComissaoCorretor."";
				$resultUpdate = $conn->query($sqlUpdate);						

				$sqlCorretor = "SELECT * FROM comissoesCorretores WHERE codComissaoCorretor = ".$codComissaoCorretor." ORDER BY codComissaoCorretor DESC LIMIT 0,1";
				$resultCorretor = $conn->query($sqlCorretor);
				$dadosCorretor = $resultCorretor->fetch_assoc();	

				if($dadosCorretor['statusComissaoCorretor'] == "T"){
					$status = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$status = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}
					
				$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosCorretor['codUsuario']." ORDER BY codUsuario ASC LIMIT 0,1";
				$resultUsuario = $conn->query($sqlUsuario);
				$dadosUsuario = $resultUsuario->fetch_assoc();
											
				if($dadosCorretor['linhaComissaoCorretor'] == "IN"){
					$linha = "Indicação";
				}else
				if($dadosCorretor['linhaComissaoCorretor'] == "CV"){
					$linha = "Corretor Venda";
				}else
				if($dadosCorretor['linhaComissaoCorretor'] == "CA"){
					$linha = "Corretor Agenciamento";
				}									
?>
										<td class="vinte" style="width:7%; padding:0px; position:relative;"><a style="padding:0px; text-decoration:none; position:relative; display:block;"><span style="width:45px; height:45px; display:block; margin:0 auto; border-radius:100%; <?php echo $corBola;?> position:relative; border:1px solid #ccc;"><span style="position:absolute; top:50%; font-size:20px; left:50%; font-family:Impact; transform:translate(-50%, -50%);"><?php echo $dadosComissao['codAgrupadorComissao'];?></span></span><span style="position:absolute; top:10px; left:10px; opacity:0.1; cursor:pointer;" onMouseover="mouseIn(<?php echo $dadosCorretor['codComissaoCorretor'];?>);" onMouseout="mouseOut(<?php echo $dadosCorretor['codComissaoCorretor'];?>);" id="editar<?php echo $dadosCorretor['codComissaoCorretor'];?>" onClick="cadastraAltera(<?php echo $dadosComissao['codComissao'];?>, <?php echo $dadosCorretor['codComissaoCorretor'];?>);"><img src="<?php echo $configUrlGer;?>f/i/icone-editar.svg" width="25"/></span></a></td>
										<td class="vinte" style="width:10%; padding:0px;"><a style="text-decoration:none;"><?php echo $linha;?></a></td>
										<td class="vinte" style="width:10%; padding:0px;"><a style="text-decoration:none;">R$ <?php echo number_format($dadosCorretor['valorComissaoCorretor'], 2, ",", ".");?></a></td>
										<td class="vinte" style="width:20%; padding:0px;" colspan="2"><a style="display:block; text-decoration:none;"><?php echo $dadosUsuario['nomeUsuario'];?></a></td>
										<td class="vinte" style="width:20%; padding:0px;" colspan="3"><a style="display:block; text-decoration:none;"><?php echo $dadosCorretor['obsComissaoCorretor'];?></a></td>
										<td class="botoes" style="width:5%; padding:0px;"><a href='<?php echo $configUrl; ?>financeiro/comissoes/gerenciar-documentos/<?php echo $dadosComissao['codAgrupadorComissao'] ?>/' title='Deseja cadastrar anexo para a comissão do corretor <?php echo $dadosCorretor['nomeUsuario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone" height="50"/></a></td>
<?php
				if($usuario == "A"){
?>
										<td class="botoes" style="width:5%; padding:0px; cursor:pointer;"><input type="hidden" value="<?php echo $dadosCorretor['statusComissaoCorretor'];?>" id="status<?php echo $dadosCorretor['codComissaoCorretor'];?>"/><a onClick="ativacao(<?php echo $dadosCorretor['codComissaoCorretor'];?>, '<?php echo $statusPergunta ?>');" title='Deseja <?php echo $statusPergunta ?> a comissão do corretor <?php echo $dadosClientes['nomeCliente'] ?>?' ><img id="imgStatus<?php echo $dadosCorretor['codComissaoCorretor'];?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone" height="50"></a></td>
										<td class="botoes" style="width:5%; padding:0px;"><a href='javascript: confirmaExclusaoCorretor(<?php echo $dadosCorretor['codComissaoCorretor'] ?>, "<?php echo htmlspecialchars($dadosUsuario['nomeUsuario']) ?>");' title='Deseja excluir a comissão do corretor <?php echo $dadosUsuario['nomeUsuario'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone" height="50"></a></td>
<?php
				}else{
?>										
										<td class="botoes" style="width:5%; padding:0px;"><a><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone" height="50"></a></td>
										<td class="dez" style="width:5%; padding:0px; text-align:center;"><a>--</a></td>
<?php
				}

			}
		}else{
			echo "erro";
		}

	}else{
		echo "erro";
	}

	$conn->close();
?>
