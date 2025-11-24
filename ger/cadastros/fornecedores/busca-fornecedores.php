<?php
	ini_set('display_errors', '0');
	error_reporting(E_ALL | E_STRICT);

	include('../../f/conf/config.php');
	include('../../f/conf/validaAcesso.php');

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
	
	function formatCnpjCpf($value){

		$cnpj_cpf = preg_replace("/\D/", '', $value);
		
		  
		if(strlen($cnpj_cpf) >= 1){
			if(strlen($cnpj_cpf) <= 3){
				$formata = preg_replace("/(\d{3})/", "\$1.", $cnpj_cpf);
			}else
			if(strlen($cnpj_cpf) >= 4 && strlen($cnpj_cpf) <= 6){
				if(strlen($cnpj_cpf) >= 4 && strlen($cnpj_cpf) <= 5){				
					$formata = preg_replace("/(\d{3})/", "\$1.", $cnpj_cpf);
				}else{
					$formata = preg_replace("/(\d{3})(\d{3})/", "\$1.\$2.", $cnpj_cpf);
				}
			}else
			if(strlen($cnpj_cpf) >= 7 && strlen($cnpj_cpf) <= 9){
				if(strlen($cnpj_cpf) >= 7 && strlen($cnpj_cpf) <= 8){				
					$formata = preg_replace("/(\d{3})(\d{3})/", "\$1.\$2.", $cnpj_cpf);
				}else{
					$formata = preg_replace("/(\d{3})(\d{3})(\d{3})/", "\$1.\$2.\$3-", $cnpj_cpf);
				}
			}else
			if(strlen($cnpj_cpf) >= 10 && strlen($cnpj_cpf) <= 11){
				if(strlen($cnpj_cpf) >= 10 && strlen($cnpj_cpf) <= 10){				
					$formata = preg_replace("/(\d{3})(\d{3})(\d{3})/", "\$1.\$2.\$3-", $cnpj_cpf);
				}else{
					$formata = preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cnpj_cpf);
				}
			}else
			if(strlen($cnpj_cpf) >= 12 && strlen($cnpj_cpf) <= 14){
				if(strlen($cnpj_cpf) >= 12 && strlen($cnpj_cpf) <= 13){				
					$formata = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})/", "\$1.\$2.\$3/\$4-", $cnpj_cpf);
				}else{
					$formata = preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj_cpf);
				}
			}
			return $formata;
		} 

		return $value;
		
	}
?>
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Nome</th>
									<th>CPF/CNPJ</th>									
									<th>Cidade / UF</th>
									<th>Telefone</th>
									<th>Foto</th>
									<th>Documentos</th>
									<th>Status</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>				
<?php
	$filtro = "";
	
	if($buscaNome != "" && !is_numeric($buscaNome)){
		$filtro = "(nomeFornecedor LIKE '%".$orderNome[0]."%' and nomeFornecedor LIKE '%".$orderNome[1]."%' and nomeFornecedor LIKE '%".$orderNome[2]."%' and nomeFornecedor LIKE '%".$orderNome[3]."%' and nomeFornecedor LIKE '%".$orderNome[4]."%')";
		$ordenacao = "locate('".$orderNome[0]."',nomeFornecedor), locate('".$orderNome[1]."',nomeFornecedor), locate('".$orderNome[2]."',nomeFornecedor), locate('".$orderNome[3]."',nomeFornecedor), locate('".$orderNome[4]."',nomeFornecedor),";
	}

	if($buscaNome != "" && is_numeric($buscaNome)){
		$filtro = "(cpfFornecedor LIKE '%".formatCnpjCpf($orderNome[0])."%')";
		$ordenacao = "locate('".formatCnpjCpf($orderNome[0])."',cpfFornecedor),";
	}
		
	if($numeroNome >= 1){
		$sqlFornecedors = "SELECT * FROM fornecedores WHERE ".$filtro." ORDER BY ".$ordenacao." statusFornecedor ASC, nomeFornecedor ASC LIMIT 0,30";		
	}
	
	if($buscaNome == "" && $buscaLote == "" && $buscaQuadra == "" && $buscaBairro == ""){
		$sqlFornecedors = "SELECT * FROM fornecedores WHERE codFornecedor != '' ORDER BY statusFornecedor ASC, nomeFornecedor ASC";
	}
	
	$resultFornecedors = $conn->query($sqlFornecedors);
	while($dadosFornecedors = $resultFornecedors->fetch_assoc()){
				
		if($dadosFornecedors['statusFornecedor'] == "T"){
			$status = "status-ativo";
			$statusIcone = "ativado";
			$statusPergunta = "desativar";
		}else{
			$status = "status-desativado";
			$statusIcone = "desativado";
			$statusPergunta = "ativar";
		}	
		
		$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosFornecedors['codEstado']." LIMIT 0,1";
		$resultEstado = $conn->query($sqlEstado);
		$dadosEstado = $resultEstado->fetch_assoc();	
		
		$sqlCidade = "SELECT * FROM cidade WHERE codCidade = ".$dadosFornecedors['codCidade']." LIMIT 0,1";
		$resultCidade = $conn->query($sqlCidade);
		$dadosCidade = $resultCidade->fetch_assoc();	
		
		$sqlImagem = "SELECT * FROM fornecedoresImagens WHERE codFornecedor = ".$dadosFornecedors['codFornecedor']." LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();	
		
		$aniversario = explode("-", $dadosFornecedors['nascimentoFornecedor']);
		$novaData = $aniversario[2]."/".$aniversario[1];		
?>
								<tr class="tr">
									<td class="vinte"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> cursor:pointer;" title="Aniversariante" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo2.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Veja os detalhes do fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>'><?php echo $dadosFornecedors['nomeFornecedor'];?></a></td>
									<td class="vinte" style="padding:0px; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Veja os detalhes do proprietário <?php echo $dadosFornecedors['nomeFornecedor'] ?>'><?php echo $dadosFornecedors['cpfFornecedor'] != "" ? $dadosFornecedors['cpfFornecedor'] : '--';?></a></td>									
									<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Veja os detalhes do fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>'><?php echo $dadosCidade['nomeCidade'];?> / <?php echo $dadosEstado['siglaEstado'];?></a></td>
									<td class="vinte" style="width:15%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Veja os detalhes do fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>'><?php echo $dadosFornecedors['telefoneFornecedor'] != "" ? $dadosFornecedors['telefoneFornecedor'] : $dadosFornecedors['celularFornecedor'];?> <?php echo $dadosFornecedors['telefoneFornecedor'] == "" && $dadosFornecedors['celularFornecedor'] == "" ? '--' : '';?></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/foto/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Deseja cadastrar fotos para o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?'><img style="margin-left:-8px; <?php echo $dadosImagem['codFornecedor'] == "" ? 'display:none;' : '';?>" src="<?php echo $configUrlGer.'f/fornecedores/'.$dadosImagem['codFornecedor'].'-'.$dadosImagem['codFornecedorImagem'].'-P.'.$dadosImagem['extFornecedorImagem'];?>" alt="icone" height="60"/><img style="<?php echo $dadosImagem['codFornecedor'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl;?>f/i/gerenciar-imagens.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/gerenciar-documentos/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Deseja cadastrar documentos para o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/ativacao/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Deseja <?php echo $statusPergunta ?> o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/fornecedores/alterar/<?php echo $dadosFornecedors['codFornecedor'] ?>/' title='Deseja alterar o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosFornecedors['codFornecedor'] ?>, "<?php echo htmlspecialchars($dadosFornecedors['nomeFornecedor']) ?>");' title='Deseja excluir o fornecedor <?php echo $dadosFornecedors['nomeFornecedor'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
	}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o fornecedor "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/fornecedores/excluir/'+cod+'/';
										}
									  }
								</script>
								 
							</table>	
