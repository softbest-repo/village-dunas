<?php 
	session_start();
	
	include ('../../f/conf/config.php');

	$codComissao = isset($_POST['codComissao']) ? intval($_POST['codComissao']) : 0;
	$codComissaoCorretor = isset($_POST['codComissaoCorretor']) ? intval($_POST['codComissaoCorretor']) : 0;
	
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
			
			if($codComissaoCorretor == 0){
			
				$sqlComissaoCorreto = "INSERT INTO comissoesCorretores VALUES(0, ".$dadosComissao['codComissao'].", 0, '0.00', '', 'CV', 'T')";
				$resultComissaoCorreto = $conn->query($sqlComissaoCorreto);

				$sqlCorretor = "SELECT * FROM comissoesCorretores WHERE codComissao = ".$dadosComissao['codComissao']." and codUsuario = 0 and valorComissaoCorretor = '0.00' and statusComissaoCorretor = 'T' ORDER BY codComissaoCorretor DESC LIMIT 0,1";
				$resultCorretor = $conn->query($sqlCorretor);
				$dadosCorretor = $resultCorretor->fetch_assoc();			
			}else{

				$sqlCorretor = "SELECT * FROM comissoesCorretores WHERE codComissaoCorretor = ".$codComissaoCorretor." ORDER BY codComissaoCorretor DESC LIMIT 0,1";
				$resultCorretor = $conn->query($sqlCorretor);
				$dadosCorretor = $resultCorretor->fetch_assoc();
								
			}
				
			if($dadosCorretor['codComissaoCorretor'] != ""){
				
				if($codComissaoCorretor != 0){
					$_SESSION['tipoAltera'] = $dadosCorretor['linhaComissaoCorretor'];
					$_SESSION['comissaoAltera'] = number_format($dadosCorretor['valorComissaoCorretor'], 2, ",", ".");
					$_SESSION['corretorAltera'] = $dadosCorretor['codUsuario'];
					$_SESSION['observacaoAltera'] = $dadosCorretor['obsComissaoCorretor'];

					if($dadosCorretor['statusComissaoCorretor'] == "T"){
						$status = "status-ativo";
						$statusIcone = "ativado";
						$statusPergunta = "desativar";
					}else{
						$status = "status-desativado";
						$statusIcone = "desativado";
						$statusPergunta = "ativar";
					}
				}else{
					$_SESSION['tipoAltera'] = "";
					$_SESSION['comissaoAltera'] = "";
					$_SESSION['corretorAltera'] = "";
					$_SESSION['observacaoAltera'] = "";					
				}					
				
				if($codComissaoCorretor == 0){
?>
									<tr class="tr" style="height:20px;" id="linhaComissao<?php echo $dadosComissao['codComissao'].$dadosCorretor['codComissaoCorretor'];?>">
<?php
				}
?>									
										<td class="vinte" style="width:7%; padding:0px; position:relative;"><a style="padding:0px; text-decoration:none; position:relative;"><span style="width:45px; height:45px; display:block; margin:0 auto; border-radius:100%; <?php echo $corBola;?> position:relative; border:1px solid #ccc;"><span style="position:absolute; top:50%; font-size:20px; left:50%; font-family:Impact; transform:translate(-50%, -50%);"><?php echo $dadosComissao['codAgrupadorComissao'];?></span></span><span style="position:absolute; top:10px; left:10px; opacity:0.5; cursor:pointer;" id="editar<?php echo $dadosCorretores['codComissaoCorretor'];?>" onClick="alteraComissao(<?php echo $dadosComissao['codComissao'];?>, <?php echo $dadosCorretor['codComissaoCorretor'];?>);"><img src="<?php echo $configUrlGer;?>f/i/verifica.svg" width="22"/></span></a></td>
										<td class="vinte" style="width:10%; padding:0px;">
											<a>
												<select class="campo" id="tipoAltera<?php echo $dadosCorretor['codComissaoCorretor'];?>" style="width:90%; border:1px solid #FF0000;">
													<option value="">Tipo Comissão</option>
													<option value="IN" <?php echo $_SESSION['tipoAltera'] == "IN" ? '/SELECTED/' : '';?> >Indicação</option>					
													<option value="CV" <?php echo $_SESSION['tipoAltera'] == "CV" ? '/SELECTED/' : '';?> >Corretor Venda</option>					
													<option value="CA" <?php echo $_SESSION['tipoAltera'] == "CA" ? '/SELECTED/' : '';?> >Corretor Agenciamento</option>					
												</select>
											</a>
										</td>
										<td class="vinte" style="width:10%; padding:0px;">
											<a>
												<input type="text" class="campo" id="comissaoAltera<?php echo $dadosCorretor['codComissaoCorretor'];?>" placeholder="Comissão" style="width:90%; max-width:175px; border:1px solid #FF0000;" value="<?php echo $_SESSION['comissaoAltera'];?>" onKeyup="moeda(this);"/>
											</a>
										</td>
										<td class="vinte" style="width:20%; padding:0px;" colspan="2">
											<a>
												<select class="campo" id="corretorAltera<?php echo $dadosCorretor['codComissaoCorretor'];?>" style="width:90%; max-width:370px; border:1px solid #FF0000;">
													<option value="">Corretor</option>
<?php
					$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario != '' ORDER BY nomeUsuario ASC";
					$resultUsuario = $conn->query($sqlUsuario);
					while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
													<option value="<?php echo $dadosUsuario['tipoUsuario'];?>-<?php echo $dadosUsuario['codUsuario'];?>" <?php echo $_SESSION['corretorAltera'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?> ><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
					}
?>					
												</select>
											</a>
										</td>
										<td class="vinte" style="width:10%; padding:0px;" colspan="3">
											<a>
												<input type="text" class="campo" id="observacaoAltera<?php echo $dadosCorretor['codComissaoCorretor'];?>" placeholder="Observação" style="width:90%; max-width:350px; border:1px solid #FF0000;" value="<?php echo $_SESSION['observacaoAltera'];?>"/>
											</a>
										</td>
<?php
				if($codComissaoCorretor != 0){
?>
										<td class="botoes" style="width:5%; padding:0px;"><a href='<?php echo $configUrl; ?>financeiro/comissoes/gerenciar-documentos/<?php echo $dadosComissao['codAgrupadorComissao'] ?>/' title='Deseja cadastrar anexo para a comissão do corretor <?php echo $dadosCorretor['nomeUsuario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone" height="50"/></a></td>
										<td class="botoes" style="width:5%; padding:0px; cursor:pointer;"><input type="hidden" value="<?php echo $dadosCorretor['statusComissaoCorretor'];?>" id="status<?php echo $dadosCorretor['codComissaoCorretor'];?>"/><a onClick="ativacao(<?php echo $dadosCorretor['codComissaoCorretor'];?>, '<?php echo $statusPergunta ?>');" title='Deseja <?php echo $statusPergunta ?> a comissão do corretor <?php echo $dadosClientes['nomeCliente'] ?>?' ><img id="imgStatus<?php echo $dadosCorretor['codComissaoCorretor'];?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone" height="50"></a></td>
										<td class="botoes" style="width:5%; padding:0px;"><a href='javascript: confirmaExclusaoCorretor(<?php echo $dadosCorretor['codComissaoCorretor'] ?>, "<?php echo htmlspecialchars($dadosUsuario['nomeUsuario']) ?>");' title='Deseja excluir a comissão do corretor <?php echo $dadosUsuario['nomeUsuario'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone" height="50"></a></td>
<?php			
				}else{
?>
										<td class="dez" style="width:5%; padding:0px; text-align:center;"><a>--</a></td>
										<td class="dez" style="width:5%; padding:0px; text-align:center;"><a>--</a></td>
										<td class="dez" style="width:5%; padding:0px; text-align:center;"><a>--</a></td>
<?php					
				}

				if($codComissaoCorretor == 0){
?>
									</tr>
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
