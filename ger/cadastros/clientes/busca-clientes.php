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
	
	$buscaLote = $_GET['buscaLote'];
	$buscaLote = str_replace("-", " ", $buscaLote);
	$buscaLote = str_replace("'", "&#39;", $buscaLote);	
	$pedacosLote = explode(" ", $buscaLote);	
	$numeroLote = count($pedacosLote);
	$orderLote = explode(" ", $buscaLote);
	
	$buscaQuadra = $_GET['buscaQuadra'];
	$buscaQuadra = str_replace("-", " ", $buscaQuadra);
	$buscaQuadra = str_replace("'", "&#39;", $buscaQuadra);	
	$pedacosQuadra = explode(" ", $buscaQuadra);	
	$numeroQuadra = count($pedacosQuadra);
	$orderQuadra = explode(" ", $buscaQuadra);
	
	$buscaBairro = $_GET['buscaBairro'];
	$buscaBairro = str_replace("-", " ", $buscaBairro);
	$buscaBairro = str_replace("-", " ", $buscaBairro);
	$buscaBairro = str_replace("-", " ", $buscaBairro);
	$buscaBairro = str_replace("'", "&#39;", $buscaBairro);	
	$pedacosBairro = explode(" ", $buscaBairro);	
	$numeroBairro = count($pedacosBairro);
	$orderBairro = explode(" ", $buscaBairro);
	
	$dataAtual = date('Y-m-d');
	$dataMenor = date('Y-m-d', strtotime('-7 days', strtotime($dataAtual)));

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
									<th>Corretor</th>
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
		$filtro = "(nomeCliente LIKE '%".$orderNome[0]."%' and nomeCliente LIKE '%".$orderNome[1]."%' and nomeCliente LIKE '%".$orderNome[2]."%' and nomeCliente LIKE '%".$orderNome[3]."%' and nomeCliente LIKE '%".$orderNome[4]."%')";
		$ordenacao = "locate('".$orderNome[0]."',nomeCliente), locate('".$orderNome[1]."',nomeCliente), locate('".$orderNome[2]."',nomeCliente), locate('".$orderNome[3]."',nomeCliente), locate('".$orderNome[4]."',nomeCliente),";
	}

	if($buscaNome != "" && is_numeric($buscaNome)){
		$filtro = "(cpfCliente LIKE '%".formatCnpjCpf($orderNome[0])."%')";
		$ordenacao = "locate('".formatCnpjCpf($orderNome[0])."',cpfCliente),";
	}
		
	if($numeroNome >= 1 || $numeroLote >= 1 || $numeroQuadra >= 1 || $numeroBairro >= 1){
		$sqlClientes = "SELECT * FROM clientes WHERE codCliente != '' and ".$filtro." ORDER BY ".$ordenacao." statusCliente ASC, nomeCliente ASC LIMIT 0,30";		
	}
	
	if($buscaNome == "" && $buscaLote == "" && $buscaQuadra == "" && $buscaBairro == ""){
		$sqlClientes = "SELECT * FROM clientes WHERE codCliente != '' ORDER BY statusCliente ASC, nomeCliente ASC";
	}
	$resultClientes = $conn->query($sqlClientes);
	while($dadosClientes = $resultClientes->fetch_assoc()){
				
		if($dadosClientes['statusCliente'] == "T"){
			$status = "status-ativo";
			$statusIcone = "ativado";
			$statusPergunta = "desativar";
		}else{
			$status = "status-desativado";
			$statusIcone = "desativado";
			$statusPergunta = "ativar";
		}		

		$sqlUsuario = "SELECT * FROM usuarios WHERE statusUsuario = 'T' and codUsuario = ".$dadosClientes['codUsuario']."";
		$resultUsuario = $conn->query($sqlUsuario);
		$dadosUsuario = $resultUsuario->fetch_assoc();

		$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosClientes['codEstado']."";
		$resultEstado = $conn->query($sqlEstado);
		$dadosEstado = $resultEstado->fetch_assoc();
	
		$sqlCidade = "SELECT * FROM cidade WHERE codCidade = ".$dadosClientes['codCidade']."";
		$resultCidade = $conn->query($sqlCidade);
		$dadosCidade = $resultCidade->fetch_assoc();
							
		$sqlImagem = "SELECT * FROM clientesImagens WHERE codCliente = ".$dadosClientes['codCliente']." LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();	
		
		$aniversario = explode("-", $dadosClientes['nascimentoCliente']);
		$novaData = $aniversario[2]."/".$aniversario[1];		
?>
								<tr class="tr">
									<td class="vinte" style="padding:0px;"><img style="<?php echo $novaData == date('d/m') ? '' : 'display:none;';?> padding-right:10px; cursor:pointer;" title="Clique para ver o numero" src="<?php echo $configUrl;?>f/i/default/corpo-default/icon-bolo2.png" alt="Aniversário" /><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosClientes['nomeCliente'];?></a></td>
									<td class="vinte" style="padding:0px; width:13%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosClientes['cpfCliente'];?></a></td>
									<td class="vinte" style="padding:0px; width:15%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosUsuario['nomeUsuario'];?></a></td>
									<td class="vinte" style="padding:0px; width:15%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosCidade['nomeCidade'];?> / <?php echo $dadosEstado['siglaEstado'];?></a></td>
									<td class="vinte" style="padding:0px; width:10%; text-align:center;"><a href='<?php echo $configUrlGer; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Veja os detalhes do cliente <?php echo $dadosClientes['nomeCliente'] ?>'><?php echo $dadosClientes['telefoneCliente'] != "" ? $dadosClientes['telefoneCliente'] : $dadosClientes['celularCliente'];?> <?php echo $dadosClientes['telefoneCliente'] == "" && $dadosClientes['celularCliente'] == "" ? '--' : '';?></a></td>
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>cadastros/clientes/foto/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja cadastrar fotos para o cliente <?php echo $dadosClientes['nomeCliente'] ?>?'><img style="margin-left:-8px; <?php echo $dadosImagem['codCliente'] == "" ? 'display:none;' : '';?>" src="<?php echo $configUrlGer.'f/clientes/'.$dadosImagem['codCliente'].'-'.$dadosImagem['codClienteImagem'].'-P.'.$dadosImagem['extClienteImagem'];?>" alt="icone" height="60"/><img style="<?php echo $dadosImagem['codCliente'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl;?>f/i/gerenciar-imagens.gif" alt="icone" /></a></td>
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>cadastros/clientes/gerenciar-documentos/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja cadastrar documentos para o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>cadastros/clientes/ativacao/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja <?php echo $statusPergunta ?> o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>cadastros/clientes/alterar/<?php echo $dadosClientes['codCliente'] ?>/' title='Deseja alterar o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes" style="padding:0px;"><a href='javascript: confirmaExclusao(<?php echo $dadosClientes['codCliente'] ?>, "<?php echo htmlspecialchars($dadosClientes['nomeCliente']) ?>");' title='Deseja excluir o cliente <?php echo $dadosClientes['nomeCliente'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
	}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o cliente "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/clientes/excluir/'+cod+'/';
										}
									  }
								</script>
								 
							</table>	
