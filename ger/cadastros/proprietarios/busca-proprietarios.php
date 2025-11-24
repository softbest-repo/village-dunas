<?php
	include('../../f/conf/config.php');
	include('../../f/conf/controleAcesso.php');

	$busca = $_GET['busca'];
			
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);
	$busca = str_replace("-", " ", $busca);


	$busca = str_replace("'", "&#39;", $busca);	
	$pedacos = explode(" ", $busca);	
	$numero = count($pedacos);
	
	$order = explode(" ", $busca);
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq" >Nome</th>
									<th>Corretor</th>
									<th>Cidade / Estado</th>
									<th>Telefone</th>
									<th>Foto</th>
									<th>Documentos</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>					
<?php
	if($numero >= 1){
		$sqlProprietarios = "SELECT * FROM proprietarios WHERE codProprietario != ''".$filtraUsuario." and nomeProprietario LIKE '%".$order[0]."%' and nomeProprietario LIKE '%".$order[1]."%' and nomeProprietario LIKE '%".$order[2]."%' and nomeProprietario LIKE '%".$order[3]."%' and nomeProprietario LIKE '%".$order[4]."%' ORDER BY locate('".$order[0]."',nomeProprietario), locate('".$order[1]."',nomeProprietario), locate('".$order[2]."',nomeProprietario), locate('".$order[3]."',nomeProprietario), locate('".$order[4]."',nomeProprietario) LIMIT 0,30";		
	}
	
	if($busca == ""){
		$sqlProprietarios = "SELECT * FROM proprietarios WHERE nomeProprietario != ''".$filtraUsuario." ORDER BY statusProprietario ASC, CASE WHEN codProprietario = 0 THEN codProprietario ELSE nomeProprietario END ASC";
	}
	$resultProprietarios = $conn->query($sqlProprietarios);
	while($dadosProprietarios = $resultProprietarios->fetch_assoc()){
				
		if($dadosProprietarios['statusProprietario'] == "T"){
			$status = "status-ativo";
			$statusIcone = "ativado";
			$statusPergunta = "desativar";
		}else{
			$status = "status-desativado";
			$statusIcone = "desativado";
			$statusPergunta = "ativar";
		}		

		$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosProprietarios['codUsuario']." LIMIT 0,1";
		$resultUsuario = $conn->query($sqlUsuario);
		$dadosUsuario = $resultUsuario->fetch_assoc();	
		
		$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosProprietarios['codEstado']." LIMIT 0,1";
		$resultEstado = $conn->query($sqlEstado);
		$dadosEstado = $resultEstado->fetch_assoc();	
		
		$sqlCidade = "SELECT * FROM cidade WHERE codCidade = ".$dadosProprietarios['codCidade']." LIMIT 0,1";
		$resultCidade = $conn->query($sqlCidade);
		$dadosCidade = $resultCidade->fetch_assoc();	

		$sqlImagem = "SELECT * FROM proprietariosImagens WHERE codProprietario = ".$dadosProprietarios['codProprietario']." LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();	
		
		$aniversario = explode("-", $dadosProprietarios['nascimentoProprietario']);
		$novaData = $aniversario[2]."/".$aniversario[1];		
	
		if($dadosProprietarios['codProprietario'] == 0){
?>
								<tr class="tr">
									<td class="trinta" colspan="9" style="font-weight:bold;"><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosProprietarios['nomeProprietario'];?></a></td>
								</tr>
<?php
		}else{
?>
								<tr class="tr">
									<td class="trinta"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> padding-right:10px; cursor:pointer;" title="Clique para ver o numero" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosProprietarios['nomeProprietario'];?></a></td>
									<td class="vinte" style="text-align:center;"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> padding-right:10px; cursor:pointer;" title="Clique para ver o numero" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosUsuario['nomeUsuario'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosCidade['nomeCidade'];?> / <?php echo $dadosEstado['siglaEstado'];?></a></td>
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>'><?php echo $dadosProprietarios['telefoneProprietario'] != "" ? $dadosProprietarios['telefoneProprietario'] : $dadosProprietarios['celularProprietario'];?> <?php echo $dadosProprietarios['telefoneProprietario'] == "" && $dadosProprietarios['celularProprietario'] == "" ? '--' : '';?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/foto/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Deseja cadastrar fotos para o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?'><img style="margin-left:-8px; <?php echo $dadosImagem['codProprietario'] == "" ? 'display:none;' : '';?>" src="<?php echo $configUrlGer.'f/proprietarios/'.$dadosImagem['codProprietario'].'-'.$dadosImagem['codProprietarioImagem'].'-P.'.$dadosImagem['extProprietarioImagem'];?>" alt="icone" height="60"/><img style="<?php echo $dadosImagem['codProprietario'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl;?>f/i/gerenciar-imagens.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/gerenciar-documentos/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Deseja cadastrar documentos para o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/ativacao/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Deseja <?php echo $statusPergunta ?> o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/proprietarios/alterar/<?php echo $dadosProprietarios['codProprietario'] ?>/' title='Deseja alterar o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosProprietarios['codProprietario'] ?>, "<?php echo htmlspecialchars($dadosProprietarios['nomeProprietario']) ?>");' title='Deseja excluir o proprietário <?php echo $dadosProprietarios['nomeProprietario'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
		}

	}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o proprietário "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/proprietarios/excluir/'+cod+'/';
										}
									  }
								</script>
								 
							</table>	
