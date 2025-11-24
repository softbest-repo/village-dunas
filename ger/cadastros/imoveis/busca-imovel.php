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
									<th class="canto-esq">Código</th>
									<th>Título do Anúncio</th>
									<th>Tipo imóvel</th>
									<th>Bairro / Cidade</th>
									<th>Lote / Quadra</th>
									<th>Preço</th>
									<th>Ordenar</th>
									<th>Capa</th>
									<th>Destaques</th>
									<th>Status</th>
									<th>Imagens</th>
									<th>Anexos</th>
									<th>Alterar</th>
									<th class="canto-dir">Excluir</th>
								</tr>							
<?php
	if($numero >= 1){
		$sqlImovel = "SELECT * FROM imoveis WHERE (codigoImovel LIKE '%".$order[0]."%') or (nomeImovel LIKE '%".$order[0]."%' and nomeImovel LIKE '%".$order[1]."%' and nomeImovel LIKE '%".$order[2]."%' and nomeImovel LIKE '%".$order[3]."%' and nomeImovel LIKE '%".$order[4]."%') or (enderecoImovel LIKE '%".$order[0]."%' and enderecoImovel LIKE '%".$order[1]."%' and enderecoImovel LIKE '%".$order[2]."%' and enderecoImovel LIKE '%".$order[3]."%' and enderecoImovel LIKE '%".$order[4]."%') ORDER BY locate('".$order[0]."',codigoImovel), locate('".$order[0]."',nomeImovel), locate('".$order[1]."',nomeImovel), locate('".$order[2]."',nomeImovel), locate('".$order[3]."',nomeImovel), locate('".$order[4]."',nomeImovel), locate('".$order[0]."',enderecoImovel), locate('".$order[1]."',enderecoImovel), locate('".$order[2]."',enderecoImovel), locate('".$order[3]."',enderecoImovel), locate('".$order[4]."',enderecoImovel) LIMIT 0,30";
	}
	
	if($busca == ""){
		$sqlImovel = "SELECT * FROM imoveis WHERE codImovel != '' ORDER BY statusImovel ASC, destaqueImovel ASC, capaImovel ASC, codigoImovel DESC";
	}
	function verificarCor($dataImovel) {
		$dataImovel = new DateTime($dataImovel);
		$hoje = new DateTime();
		$intervalo = $dataImovel->diff($hoje);
		$meses = $intervalo->y * 12 + $intervalo->m;

		if ($meses < 3) {
			return "background:rgb(0, 128, 0); color:#FFF;"; // Verde
		} elseif ($meses >= 3 && $meses < 6) {
			return "background:rgb(205, 220, 57);"; // Amarelo
		} elseif ($meses >= 6 && $meses < 12) {
			return "background:rgb(243, 157, 0);"; // Laranja
		} else {
			return "background:rgb(255, 0, 0); color:#FFF;"; // Vermelho
		}
	}
		
	$resultImovel = $conn->query($sqlImovel);
	while($dadosImovel = $resultImovel->fetch_assoc()){
				
		if($dadosImovel['statusImovel'] == "T"){
			$status = "status-ativo";
			$statusIcone = "ativado";
			$statusPergunta = "desativar";
		}else{
			$status = "status-desativado";
			$statusIcone = "desativado";
			$statusPergunta = "ativar";
		}					

		if($dadosImovel['capaImovel'] == "T"){
			$capa = "capa-ativo";
			$capaIcone = "ativado";
			$capaPergunta = "desativar";
		}else{
			$capa = "capa-desativado";
			$statusIcone = "desativado";
			$capaPergunta = "ativar";
		}	
		
		if($dadosImovel['destaqueImovel'] == "T"){
			$destaque = "destaque-ativado";
			$destaqueIcone = "ativado";
			$destaquePergunta = "retirar o imóvel ";
		}else{
			$destaque = "destaque-desativado";
			$destaqueIcone = "desativado";
			$destaquePergunta = "colocar o ";
		}		
		
		if($dadosImovel['tipoCImovel'] == 'V'){
			$comercial = "Venda";
		}else{
			$comercial = "Aluguel";
		}
				
		$sqlCidade = "SELECT * FROM cidades WHERE statusCidade = 'T' and codCidade = '".$dadosImovel['codCidade']."' and codCidade = '".$dadosImovel['codCidade']."' ORDER BY codCidade DESC LIMIT 0,1";
		$resultCidade = $conn->query($sqlCidade);
		$dadosCidade = $resultCidade->fetch_assoc();
		
		$sqlBairro = "SELECT * FROM bairros WHERE statusBairro = 'T' and codBairro = '".$dadosImovel['codBairro']."' ORDER BY codBairro DESC LIMIT 0,1";
		$resultBairro = $conn->query($sqlBairro);
		$dadosBairro = $resultBairro->fetch_assoc();
		
		$sqlTipo = "SELECT * FROM tipoImovel WHERE statusTipoImovel = 'T' and codTipoImovel = '".$dadosImovel['codTipoImovel']."' ORDER BY codTipoImovel DESC LIMIT 0,1";
		$resultTipo = $conn->query($sqlTipo);
		$dadosTipo = $resultTipo->fetch_assoc();		
		
		$sqlImagem = "SELECT * FROM imoveisImagens WHERE codImovel = '".$dadosImovel['codImovel']."' ORDER BY ordenacaoImovelImagem ASC, codImovelImagem ASC LIMIT 0,1";
		$resultImagem = $conn->query($sqlImagem);
		$dadosImagem = $resultImagem->fetch_assoc();	

		$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$dadosImovel['codUsuario']."' LIMIT 0,1";
		$resultUsuario = $conn->query($sqlUsuario);
		$dadosUsuario = $resultUsuario->fetch_assoc();

		if($filtraUsuario == ""){										
?>
								<tr class="tr">
									<td class="dez" style="width:8%; text-align:center; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>"><a style="padding:0px; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['codigoImovel'];?><br/><span style="font-weight:bold; font-size:11px;"><?php echo $dadosUsuario['nomeUsuario'];?></span><br/><span style="font-size:10px; line-height:13px; display:block;"><?php echo date('d/m/Y', strtotime(substr($dadosImovel['alteracaoImovel'], 0, 10))); ?></span></a></td>
									<td class="trinta" style="text-align:left;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['nomeImovel'];?></a></td>
									<td class="dez" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosTipo['nomeTipoImovel'];?><br/><?php echo $comercial;?></a></td>
									<td class="trinta" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosBairro['nomeBairro'];?><br/><?php echo $dadosCidade['nomeCidade'];?></a></td>
									<td class="vinte" style="width:10%; text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>Quadra: <?php echo $dadosImovel['quadraImovel'];?><br/>Lote: <?php echo $dadosImovel['loteImovel'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>R$ <?php echo number_format($dadosImovel['precoImovel'], 2, ",", ".");?></a></td>
<?php
			if($dadosImovel['capaImovel'] == "T"){
?>
									<td class="dez" style="text-align:center;"><input type="number" class="campo" style="width:30px; text-align:center; border:1px solid #0000FF; outline:none;" value="<?php echo $dadosImovel['codOrdenacaoImovel'];?>" onClick="alteraCor(<?php echo $dadosImovel['codImovel'];?>);" onBlur="alteraOrdem(<?php echo $dadosImovel['codImovel'];?>, this.value);" id="codOrdena<?php echo $dadosImovel['codImovel'];?>"/></td>
<?php
			}else{
?>									  
									<td class="vinte" style="width:10%; padding:0px; text-align:center;">--</td>
<?php
			}
?>

									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/capa/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja <?php echo $capaPergunta ?> <?php echo $dadosImovel['nomeImovel'] ?> na capa do site?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $capa ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/destaque/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja <?php echo $destaquePergunta ?> <?php echo $dadosImovel['nomeImovel'] ?> do site ?' ><img src="<?php echo $configUrl; ?>f/i/<?php echo $destaque ?>.png" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/ativacao/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja <?php echo $statusPergunta ?> o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/imagens/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja gerenciar imagens do imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img style="<?php echo $dadosImagem['codImovelImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/imoveis/'.$dadosImagem['codImovel'].'-'.$dadosImagem['codImovelImagem'].'-W.webp';?>" height="50"/><img style="<?php echo $dadosImagem['codImovelImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/imoveis/anexos/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja cadastrar anexos para o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja alterar o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='javascript: confirmaExclusao(<?php echo $dadosImovel['codImovel'] ?>, "<?php echo htmlspecialchars($dadosImovel['nomeImovel']) ?>");' title='Deseja excluir o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
		}else{
			if($_COOKIE['codAprovado'.$cookie] == $dadosImovel['codUsuario']){
?>
								<tr class="tr">
									<td class="dez" style="width:8%; text-align:center; font-weight:bold; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>"><a style="padding:0px; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['codigoImovel'];?></a></td>
									<td class="trinta" style="text-align:left;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['nomeImovel'];?></a></td>
									<td class="dez" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosTipo['nomeTipoImovel'];?><br/><?php echo $comercial;?></a></td>
									<td class="trinta" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosBairro['nomeBairro'];?><br/><?php echo $dadosCidade['nomeCidade'];?></a></td>
									<td class="vinte" style="width:10%; text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>Quadra: <?php echo $dadosImovel['quadraImovel'];?><br/>Lote: <?php echo $dadosImovel['loteImovel'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>R$ <?php echo number_format($dadosImovel['precoImovel'], 2, ",", ".");?></a></td>
									<td class="dez" style="width:10%; padding:0px; text-align:center;">--</td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;"><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $capa ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;"><img src="<?php echo $configUrl; ?>f/i/<?php echo $destaque ?>.png" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/ativacao/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja <?php echo $statusPergunta ?> o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/imagens/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja gerenciar imagens do imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img style="<?php echo $dadosImagem['codImovelImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/imoveis/'.$dadosImagem['codImovel'].'-'.$dadosImagem['codImovelImagem'].'-W.webp';?>" height="50"/><img style="<?php echo $dadosImagem['codImovelImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></a></td>
									<td class="botoes"><a href='<?php echo $configUrl; ?>cadastros/imoveis/anexos/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja cadastrar anexos para o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja alterar o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='javascript: confirmaExclusao(<?php echo $dadosImovel['codImovel'] ?>, "<?php echo htmlspecialchars($dadosImovel['nomeImovel']) ?>");' title='Deseja excluir o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
								</tr>
<?php
			}else{
?>
								<tr class="tr">
									<td class="dez" style="width:8%; text-align:center; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>"><a style="padding:0px; <?php echo verificarCor($dadosImovel['alteracaoImovel']);?>" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['codigoImovel'];?></a></td>
									<td class="trinta" style="text-align:left;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosImovel['nomeImovel'];?></a></td>
									<td class="dez" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosTipo['nomeTipoImovel'];?><br/><?php echo $comercial;?></a></td>
									<td class="trinta" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'><?php echo $dadosBairro['nomeBairro'];?><br/><?php echo $dadosCidade['nomeCidade'];?></a></td>
									<td class="vinte" style="width:10%; text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>Quadra: <?php echo $dadosImovel['quadraImovel'];?><br/>Lote: <?php echo $dadosImovel['loteImovel'];?></a></td>
									<td class="vinte" style="text-align:center;"><a style="padding:0px;" href='<?php echo $configUrlGer; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Veja os detalhes do imóvel <?php echo $dadosImovel['nomeImovel'] ?>'>R$ <?php echo number_format($dadosImovel['precoImovel'], 2, ",", ".");?></a></td>
									<td class="vinte" style="width:10%; padding:0px; text-align:center;">--</td>
									<td class="botoes" style="width:5%;"><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $capa ?>.gif" alt="icone"></td>
									<td class="botoes" style="width:5%;"><img src="<?php echo $configUrl; ?>f/i/<?php echo $destaque ?>.png" alt="icone"></td>
									<td class="botoes" style="width:5%;"><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></td>
									<td class="botoes" style="width:5%;"><img style="<?php echo $dadosImagem['codImovelImagem'] == "" ? 'display:none;' : 'padding-top:5px;';?>" src="<?php echo $configUrlGer.'f/imoveis/'.$dadosImagem['codImovel'].'-'.$dadosImagem['codImovelImagem'].'-W.webp';?>" height="50"/><img style="<?php echo $dadosImagem['codImovelImagem'] != "" ? 'display:none;' : '';?>" src="<?php echo $configUrl; ?>f/i/default/corpo-default/gerenciar-imagens.gif" alt="icone"></td>
									<td class="botoes"><a><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
									<td class="botoes" style="width:5%;"><a style="padding:0px;" href='<?php echo $configUrl; ?>cadastros/imoveis/alterar/<?php echo $dadosImovel['codImovel'] ?>/' title='Deseja alterar o imóvel <?php echo $dadosImovel['nomeImovel'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
									<td class="dez" style="width:5%; text-align:center;">--</td>
								</tr>
<?php			
			
			}
		}
	}
?>
								<script>
									 function confirmaExclusao(cod, nome){

										if(confirm("Deseja excluir o imóvel "+nome+"?")){
											window.location='<?php echo $configUrlGer; ?>cadastros/imoveis/excluir/'+cod+'/';
										}
									  }
								</script>
								 
							</table>	
