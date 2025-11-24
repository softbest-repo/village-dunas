<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "contratos";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlNomeContrato = "SELECT * FROM contratos WHERE codContrato = '".$url[6]."' LIMIT 0,1";
				$resultNomeContrato = $conn->query($sqlNomeContrato);
				$dadosNomeContrato = $resultNomeContrato->fetch_assoc();

				$sqlCliente = "SELECT * FROM clientes WHERE codCliente = '".$dadosNomeContrato['codCliente']."' ORDER BY codCliente DESC LIMIT 0,1";
				$resultCliente = $conn->query($sqlCliente);
				$dadosCliente = $resultCliente->fetch_assoc();				
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Comercial</p>
						<p class="flexa"></p>
						<p class="nome-lista">Contratos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista">Cliente</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosCliente['nomeCliente'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno">
						<tr class="tr-interno">
						<script>
							function confirmaEstornar(id, cod){
								if(id == "C"){
									var resultado = confirm("Você deseja estornar a comissão deste contrato? Fazendo isso todos os movimentos cadastros da conta serão apagados!");
									if(resultado == true){
										location.href="<?php echo $configUrl; ?>comercial/contratos/ativacao-c/<?php echo $dadosNomeContrato['codContrato'];?>/";
									}
								}else{
									var resultado = confirm("Você deseja estornar a venda desse contrato? Fazendo isso todos os movimentos cadastros da conta serão apagados!");
									if(resultado == true){
										location.href="<?php echo $configUrl; ?>comercial/contratos/ativacao/<?php echo $dadosNomeContrato['codContrato'];?>/";
									}
									
								}
							}					
						</script>

<?php
				if($dadosNomeContrato['statusCContrato'] == "F"){
?>
							<td class="botoes-interno" style="width:115px; text-align:center;"><a style="cursor:pointer;" onClick="confirmaEstornar('C', <?php echo $url[6];?>)" title='Deseja estornar o contrato ?' ><img src='<?php echo $configUrl; ?>f/i/dinheiro-estorno.gif' alt="icone"><br/><span style="font-size:12px; display:block;">Estornar Comissão</span></a></td>
<?php
				}
?>
<?php
				if($dadosNomeContrato['statusContrato'] == "F"){
?>
							<td class="botoes-interno" style="width:115px; text-align:center;"><a style="cursor:pointer;" onClick="confirmaEstornar('V', <?php echo $url[6];?>)" title='Deseja estornar o contrato ?' ><img src='<?php echo $configUrl; ?>f/i/dinheiro-estorno.gif' alt="icone"><span style="font-size:12px; display:block;">Estornar Venda</span></a></td>
<?php
				}
				
				if($dadosNomeContrato['statusContrato'] == "T" && $dadosNomeContrato['statusCContrato'] == "T"){
?>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeContrato['codContrato'] ?>, "<?php echo htmlspecialchars($dadosNomeContrato['nomeContrato']) ?>");' title='Deseja excluir o contrato ?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
<?php
				}
?>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir o contrato?")){
									window.location='<?php echo $configUrlGer; ?>comercial/contratos/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a href="<?php echo $configUrl;?>comercial/contratos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['clientes'])){
				
					$sqlPegaCliente = "SELECT * FROM clientes WHERE nomeCliente = '".$_POST['clientes']."' ORDER BY codCliente DESC LIMIT 0,1";
					$resultPegaCliente = $conn->query($sqlPegaCliente);
					$dadosPegaCliente = $resultPegaCliente->fetch_assoc();

					if($dadosPegaCliente['codCliente'] != ""){
																															
						$valorVenda = str_replace(".", "", $_POST['valor-venda']);																														
						$valorVenda = str_replace(".", "", $valorVenda);																														
						$valorVenda = str_replace(",", ".", $valorVenda);																														

						$valorComissao = str_replace(".", "", $_POST['valor-comissao']);																														
						$valorComissao = str_replace(".", "", $valorComissao);																														
						$valorComissao = str_replace(",", ".", $valorComissao);		
							
						$sqlUpdate = "UPDATE contratos SET codUsuario = ".$_POST['corretor'].",  codCliente = '".$dadosPegaCliente['codCliente']."', valorContrato = '".$valorVenda."', valorComissao = '".$valorComissao."', dataContrato = '".data($_POST['data-venda'])."', observacaoContrato = '".$_POST['observacao']."' WHERE codContrato = ".$url[6];
						$resultUpdate = $conn->query($sqlUpdate);

						if($resultUpdate == 1){
														
							if($_POST['total-imoveis'] >= 1){

								$sqlDelete = "DELETE FROM contratosImoveis WHERE codContrato = ".$url[6]."";
								$resultDelete = $conn->query($sqlDelete);

								for($i=0; $i<=$_POST['total-imoveis']; $i++){
									if($_POST['imovel'.$i] != ""){

										$num_com_zeros = str_pad($_POST['imovel'.$i], 4, "0", STR_PAD_LEFT);
										
										$sqlImovel = "SELECT * FROM imoveis WHERE statusImovel = 'T' and codigoImovel = '".$num_com_zeros."' ORDER BY codImovel DESC LIMIT 0,1";
										$resultImovel = $conn->query($sqlImovel);
										$dadosImovel = $resultImovel->fetch_assoc();
										
										if($dadosImovel['codImovel'] != ""){
											$sqlInsere = "INSERT INTO contratosImoveis VALUES(0, ".$url[6].", ".$dadosImovel['codImovel'].")";
											$resultInsere = $conn->query($sqlInsere);
										}
										
									}									
								}
							}

							$_SESSION['nome'] = $_POST['titulo'];
							$_SESSION['alteracao'] = "ok";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/contratos/'>";
						}else{
							$erroData = "<p class='erro'>Problemas ao alterar contrato!</p>";
						}
					}else{
						$erroData = "<p class='erro'>O Cliente <strong>".$_POST['clientes']."</strong> não foi encontrado.</p>";
						$_SESSION['clientes'] = "";
						$_SESSION['imovel'] = $_POST['imovel'];
						$_SESSION['valor-venda'] = $_POST['valor-venda'];
						$_SESSION['data-venda'] = $_POST['data-venda'];				
						$_SESSION['observacoes'] = $_POST['observacoes'];	
						echo "<script>carregaImovel();</script>";
					}									
					
				}else{
					$sqlContrato = "SELECT C.codUsuario, CL.nomeCliente, C.valorContrato, C.valorComissao, C.dataContrato, C.observacaoContrato FROM contratos C inner join clientes CL on C.codCliente = CL.codCliente WHERE C.codContrato = ".$url[6]." LIMIT 0,1";
					$resultContrato = $conn->query($sqlContrato);
					$dadosContrato = $resultContrato->fetch_assoc();
										
					$_SESSION['clientes'] = $dadosContrato['nomeCliente'];
					$_SESSION['corretor'] = $dadosContrato['codUsuario'];
					$_SESSION['valor-venda'] = number_format($dadosContrato['valorContrato'], 2, ",", ".");
					$_SESSION['valor-comissao'] = number_format($dadosContrato['valorComissao'], 2, ",", ".");
					$_SESSION['data-venda'] = data($dadosContrato['dataContrato']);
					$_SESSION['observacao'] = $dadosContrato['observacaoContrato'];
				}

				if($erroData != "" || $erro == "sim" || $erro == "ok"){
?>
						<div class="area-erro">
<?php
					echo $erroData;
					if($erro == "sim" || $erro == "ok"){
						include('f/conf/mostraErro.php');
					}
?>
						</div>
<?php
				}
				
?>
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
						<script>
							function habilitaCampo(){
								document.getElementById("busca_autocomplete_softbest_clientes_c").disabled = false;
								document.getElementById("corretor").disabled = false;
								document.getElementById("valor-venda").disabled = false;
								document.getElementById("valor-comissao").disabled = false;
								document.getElementById("data-venda").disabled = false;
								document.getElementById("observacao").disabled = false;
								document.getElementById("alterar").disabled = false;
<?php
				$cont = 0;
				
				$sqlImoveis = "SELECT * FROM contratosImoveis CI inner join imoveis I on CI.codImovel = I.codImovel inner join quadras Q on I.quadraImovel = Q.codQuadra inner join lotes L on I.loteImovel = L.codLote inner join tipoImovel TI on I.codTipoImovel = TI.codTipoImovel inner join bairros B on I.codBairro = B.codBairro inner join cidades C on I.codCidade = C.codCidade WHERE CI.codContrato = ".$url[6]." ORDER BY CI.codContratoImovel ASC";
				$resultImoveis = $conn->query($sqlImoveis);
				while($dadosImoveis = $resultImoveis->fetch_assoc()){
					$cont++;
?>
								document.getElementById("imovel"+<?php echo $cont;?>).disabled = false;
								document.getElementById("quadra"+<?php echo $cont;?>).disabled = false;
								document.getElementById("lote"+<?php echo $cont;?>).disabled = false;
								document.getElementById("bairro"+<?php echo $cont;?>).disabled = false;
								document.getElementById("tipo-imovel"+<?php echo $cont;?>).disabled = false;
<?php
				}
?>
							}
						</script>						
						<script>
							function moeda(z){  
								v = z.value;
								v=v.replace(/\D/g,"")  //permite digitar apenas números
								v=v.replace(/[0-9]{12}/,"inválido")   //limita pra máximo 999.999.999,99
								v=v.replace(/(\d{1})(\d{8})$/,"$1.$2")  //coloca ponto antes dos últimos 8 digitos
								v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")  //coloca ponto antes dos últimos 5 digitos
								v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2")	//coloca virgula antes dos últimos 2 digitos
								z.value = v;
							}
						</script>									
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<form name="formcontratos" action="<?php echo $configUrlGer; ?>comercial/contratos/alterar/<?php echo $url[6];?>/" method="post">
													
							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> </span></label>
								<select class="campo" id="corretor" name="corretor" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:200px; padding:6px; margin-right:0px;">
									<option value="">Todos</option>
<?php
				$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4 ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
									<option value="<?php echo $dadosUsuario['codUsuario'] ;?>" <?php echo $_SESSION['corretor'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
}
?>					
								</select>
							</p>
								
							<div id="auto_complete_softbest" style="width:255px; float:left; margin-bottom:15px; margin-right:10px;">
								<p class="bloco-campo" style="margin-bottom:0px;"><label>Cliente: <span class="obrigatorio"> * </span></label>
								<input class="campo" type="text" name="clientes" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required style="width:239px;" value="<?php echo $_SESSION['clientes']; ?>" onClick="auto_complete(this.value, 'clientes_c', event);" onKeyUp="auto_complete(this.value, 'clientes_c', event);" onBlur="fechaAutoComplete('clientes_c');" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest_clientes_c" /></p>
								
								<div id="exibe_busca_autocomplete_softbest_clientes_c" class="auto_complete_softbest" style="display:none;">

								</div>
							</div>	

							<p class="bloco-campo-float"><label>Valor Venda: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="valor-venda" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="valor-venda" required style="width:120px;" value="<?php echo $_SESSION['valor-venda'];?>" onKeyup="moeda(this);"/></p>

							<p class="bloco-campo-float"><label>Valor Comissão: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="valor-comissao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="valor-comissao" required style="width:120px;" value="<?php echo $_SESSION['valor-comissao'];?>" onKeyup="moeda(this);"/></p>

							<p class="bloco-campo-float"><label>Data da Venda: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="data-venda" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required name="data-venda" style="width:110px;" value="<?php echo $_SESSION['data-venda']; ?>"  onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

							<br class="clear"/>
							
							<script>
								function novoImovel(){
									var $tgf = jQuery.noConflict();
									var totalImoveis = document.getElementById("total-imoveis").value;
									var somaNovo = parseInt(totalImoveis) + 1;
									
									$tgf.post("<?php echo $configUrl;?>comercial/contratos/novo-imovel.php", {id: somaNovo}, function(data){
										var novaDiv = document.createElement('div');
										novaDiv.id = 'bloco-imovel'+somaNovo;
										novaDiv.innerHTML = data;
										
										document.getElementById("carrega-imovel").appendChild(novaDiv);
										document.getElementById("bloco-imovel"+somaNovo).style.marginTop="15px";
										
										document.getElementById("total-imoveis").value = somaNovo;
									});
								}	
						
							   function carregaImovel(cod, id) {
									fetch('<?php echo $configUrl;?>comercial/contratos/busca-imovel.php?codigoImovel=' + cod)
										.then(response => response.json())
										.then(data => {
											if (data.length > 0) {
												data.forEach(imovel => {
													document.getElementById("quadra"+id).value=imovel.nomeQuadra;
													document.getElementById("lote"+id).value=imovel.nomeLote;
													document.getElementById("bairro"+id).value=imovel.nomeBairro+" - "+imovel.nomeCidade+" / "+imovel.estadoCidade;
													document.getElementById("tipo-imovel"+id).value=imovel.nomeTipoImovel;
												});
											} else {
												alert('Nenhum imóvel encontrado.');
											}
										})
										.catch(error => console.error('Error fetching data:', error));
								}
							</script>							
							
							<div id="mostra-imoveis">
								<fieldset id="cadastra-compromisso" style="float:left; border:1px solid #ccc; padding:15px; padding-right:70px; margin-bottom:20px; margin-top:5px; border-radius:5px;"> 
								  
								   <legend style="color:#336666; font-weight:bold; font-size:16px;">Selecione um ou mais Imóveis</legend>

									<div id="carrega-imovel">
<?php
	$cont = 0;
	
	$sqlImoveis = "SELECT * FROM contratosImoveis CI inner join imoveis I on CI.codImovel = I.codImovel inner join quadras Q on I.quadraImovel = Q.codQuadra inner join lotes L on I.loteImovel = L.codLote inner join tipoImovel TI on I.codTipoImovel = TI.codTipoImovel inner join bairros B on I.codBairro = B.codBairro inner join cidades C on I.codCidade = C.codCidade WHERE CI.codContrato = ".$url[6]." ORDER BY CI.codContratoImovel ASC";
	$resultImoveis = $conn->query($sqlImoveis);
	while($dadosImoveis = $resultImoveis->fetch_assoc()){
		$cont++;
?>
										<div id="bloco-imovel<?php echo $cont;?>" style="<?php echo $cont >= 2 ? 'margin-top:15px;' : '';?>">
											
											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Código: <span class="obrigatorio"> <?php echo $cont == 1 ? '*' : '';?> </span></label>
											<input class="campo" type="text" id="imovel<?php echo $cont;?>" <?php echo $cont == 1 ? 'required' : '';?> <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="imovel<?php echo $cont;?>" required style="width:100px;" onKeyup="carregaImovel(this.value, 1);" value="<?php echo $dadosImoveis['codigoImovel'];?>" /></p>

											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Quadra: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="quadra<?php echo $cont;?>" readonly style="width:120px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $dadosImoveis['nomeQuadra'];?>" /></p>

											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Lote: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="lote<?php echo $cont;?>" readonly style="width:120px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $dadosImoveis['nomeLote'];?>" /></p>
											
											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Bairro / Cidade: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="bairro<?php echo $cont;?>" readonly style="width:220px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $dadosImoveis['nomeBairro'];?> - <?php echo $dadosImoveis['nomeCidade'];?> / <?php echo $dadosImoveis['estadoCidade'];?>" /></p>

											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Tipo Imóvel: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="tipo-imovel<?php echo $cont;?>" readonly style="width:120px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="<?php echo $dadosImoveis['nomeTipoImovel'];?>" /></p>

											<br class="clear"/>
											
										</div>			
<?php
	}
?>
									</div>				
									
									<div class="botao-consultar" onClick="novoImovel();" style="margin-left:820px; margin-top:-31px; margin-bottom:0px; position:absolute;"><div class="esquerda-consultar"></div><div class="conteudo-consultar">+</div><div class="direita-consultar"></div></div>					
								</fieldset>
								
								<input type="hidden" value="<?php echo $cont;?>" name="total-imoveis" id="total-imoveis"/>									

							</div>
							

							<br class="clear"/>
							
							<p class="bloco-campo"><label>Observação: <span class="obrigatorio"> </span></label>
							<textarea id="observacao" class="campo desabilita" name="observacao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="text" style="width:875px; height:80px; padding:10px;" ><?php echo $_SESSION['observacao']; ?></textarea></p>
																									
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="botao" type="submit" name="alterar" title="Alterar" value="Alterar" onClick="verificaDados();"/><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
			}else{
?>	
				<div id="filtro">
					<div id="erro-permicao">	
<?php
				echo "<p><strong>Você não tem permissão para acessar essa área!</strong></p>";
				echo "<p>Para mais informações entre em contato com o administrador!</p>";
?>	
					</div>
				</div>
<?php
			}

		}else{
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."controle-acesso.php'>";
		}

	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login.php'>";
	}
?>
