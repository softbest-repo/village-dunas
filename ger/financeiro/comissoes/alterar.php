<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "comissoes";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlNomeComissao = "SELECT * FROM comissoes WHERE codComissao = '".$url[6]."'".$filtraUsuarioPlanilha." LIMIT 0,1";
				$resultNomeComissao = $conn->query($sqlNomeComissao);
				$dadosNomeComissao = $resultNomeComissao->fetch_assoc();
				
				if($dadosNomeComissao['codComissao'] == "" || $usuario == "C" || $usuario == "CP"){
				
					echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/comissoes/'>";
				
				}else{			

					$sqlCorretor = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosNomeComissao['codCorretorComissao']." LIMIT 0,1";
					$resultCorretor = $conn->query($sqlCorretor);
					$dadosCorretor = $resultCorretor->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Controle de Comissões</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista">Corretor: <?php echo $dadosCorretor['nomeUsuario'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno">
						<tr class="tr-interno">
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomeComissao['codComissao'] ?>, "<?php echo htmlspecialchars($dadosCorretor['nomeUsuario']) ?>");' title='Deseja excluir a comissão do corretor <?php echo $dadosCorretor['nomeUsuario'];?> ?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir a comissão do corretor "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>financeiro/comissoes/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a href="<?php echo $configUrl;?>financeiro/comissoes/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
					if(isset($_POST['cidades'])){

						$sqlComissaoCheck = "SELECT codComissao FROM comissoes WHERE codBairro = ".$_POST['bairro']." and codQuadra = ".$_POST['quadras']." and codLote = ".$_POST['lotes']." and codComissao != ".$url[6]." ORDER BY codComissao DESC LIMIT 0,1";
						$resultComissaoCheck = $conn->query($sqlComissaoCheck);
						$dadosComissaoCheck = $resultComissaoCheck->fetch_assoc();
						
						if($dadosComissaoCheck['codComissao'] == ""){	
																																											
							$valorImovel = str_replace(".", "", $_POST['valor-imovel']);																														
							$valorImovel = str_replace(".", "", $valorImovel);																														
							$valorImovel = str_replace(",", ".", $valorImovel);																														
							
							$valorImobiliaria = str_replace(".", "", $_POST['comissao-imobiliaria']);																														
							$valorImobiliaria = str_replace(".", "", $valorImobiliaria);																														
							$valorImobiliaria = str_replace(",", ".", $valorImobiliaria);	
							
							$valorComissao = str_replace(".", "", $_POST['valor-comissao']);																														
							$valorComissao = str_replace(".", "", $valorComissao);																														
							$valorComissao = str_replace(",", ".", $valorComissao);	
							
							$valorAG = str_replace(".", "", $_POST['comissao-ag']);																														
							$valorAG = str_replace(".", "", $valorAG);																														
							$valorAG = str_replace(",", ".", $valorAG);	
																				
							$sqlUpdate = "UPDATE comissoes SET codCidade = '".$_POST['cidades']."', codBairro = '".$_POST['bairro']."', codQuadra = '".$_POST['quadras']."', codLote = '".$_POST['lotes']."', dataComissao = '".$_POST['data']."', valorImovelComissao = '".$valorImovel."', imobiliariaComissao = '".$valorImobiliaria."', obsImobiliariaComissao = '".$_POST['obs-imobiliaria']."', pagaComissao = '".$_POST['comissao-paga']."', codCorretorComissao = '".$_POST['corretor-venda']."', corretorComissao = '".$valorComissao."', obsCorretorComissao = '".$_POST['obs-corretor-venda']."', codCorretorAGComissao = '".$_POST['corretor-ag']."', corretorAGComissao = '".$valorAG."', obsCorretorAGComissao = '".$_POST['obs-corretor-ag']."', observacaoComissao = '".$_POST['observacao']."' WHERE codComissao = ".$url[6];
							$resultUpdate = $conn->query($sqlUpdate);

							if($resultUpdate == 1){
								$_SESSION['nome'] = $_POST['titulo'];
								$_SESSION['alteracao'] = "ok";
								echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/comissoes/'>";
							}else{
								$erroData = "<p class='erro'>Problemas ao alterar comissão!</p>";
							}
						}else{
							$erroData = "<p class='erro'>A Comissão que você esta tentando adicionar ja foi incluída!</p>";
							$_SESSION['cidades'] = $_POST['cidades'];
							$_SESSION['bairro'] = $_POST['bairro'];
							$_SESSION['quadras'] = $_POST['quadras'];
							$_SESSION['lotes'] = $_POST['lotes'];
							$_SESSION['data'] = $_POST['data'];
							$_SESSION['valor-imovel'] = $_POST['valor-imovel'];
							$_SESSION['comissao-imobiliaria'] = $_POST['comissao-imobiliaria'];
							$_SESSION['corretor-venda'] = $_POST['corretor-venda'];
							$_SESSION['valor-comissao'] = $_POST['valor-comissao'];
							$_SESSION['obs-corretor-venda'] = $_POST['obs-corretor-venda'];
							$_SESSION['corretor-ag'] = $_POST['corretor-ag'];
							$_SESSION['comissao-ag'] = $_POST['comissao-ag'];
							$_SESSION['obs-corretor-ag'] = $_POST['obs-corretor-ag'];
							$_SESSION['observacao'] = $_POST['observacao'];					
							$_SESSION['arquivoVenda'] = $_FILE['arquivoVenda'];					
							$_SESSION['arquivoAgenciador'] = $_FILE['arquivoAgenciador'];					
							$display = "block";
						}							
					}else{
						$sqlComissao = "SELECT * FROM comissoes WHERE codComissao = ".$url[6]." LIMIT 0,1";
						$resultComissao = $conn->query($sqlComissao);
						$dadosComissao = $resultComissao->fetch_assoc();
																					
						$_SESSION['cidades'] = $dadosComissao['codCidade'];
						$_SESSION['bairro'] = $dadosComissao['codBairro'];
						$_SESSION['quadras'] = $dadosComissao['codQuadra'];
						$_SESSION['lotes'] = $dadosComissao['codLote'];
						$_SESSION['data'] = $dadosComissao['dataComissao'];
						$_SESSION['valor-imovel'] = number_format($dadosComissao['valorImovelComissao'], 2, ",", ".");
						$_SESSION['comissao-imobiliaria'] = number_format($dadosComissao['imobiliariaComissao'], 2, ",", ".");
						$_SESSION['obs-imobiliaria'] = $dadosComissao['obsImobiliariaComissao'];
						$_SESSION['comissao-paga'] = $dadosComissao['pagaComissao'];
						$_SESSION['corretor-venda'] = $dadosComissao['codCorretorComissao'];
						$_SESSION['valor-comissao'] = number_format($dadosComissao['corretorComissao'], 2, ",", ".");
						$_SESSION['obs-corretor-venda'] = $dadosComissao['obsCorretorComissao'];
						$_SESSION['corretor-ag'] = $dadosComissao['codCorretorAGComissao'];
						$_SESSION['comissao-ag'] = number_format($dadosComissao['corretorAGComissao'], 2, ",", ".");
						$_SESSION['obs-corretor-ag'] = $dadosComissao['obsCorretorAGComissao'];
						$_SESSION['observacao'] = $dadosComissao['observacaoComissao'];
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
				
					if($dadosNomeComissao['statusComissao'] == "T"){
?>
						<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
<?php
					}
?>
						<script>
							function habilitaCampo(){
								document.getElementById("cidades").disabled = false;
								document.getElementById("bairro").disabled = false;
								document.getElementById("quadras").disabled = false;
								document.getElementById("lotes").disabled = false;
								document.getElementById("data").disabled = false;
								document.getElementById("valor-imovel").disabled = false;
								document.getElementById("comissao-imobiliaria").disabled = false;
								document.getElementById("obs-imobiliaria").disabled = false;
								document.getElementById("comissao-paga1").disabled = false;
								document.getElementById("comissao-paga2").disabled = false;
								document.getElementById("corretor-venda").disabled = false;
								document.getElementById("valor-comissao").disabled = false;
								document.getElementById("obs-corretor-venda").disabled = false;								
								document.getElementById("corretor-ag").disabled = false;								
								document.getElementById("comissao-ag").disabled = false;								
								document.getElementById("obs-corretor-ag").disabled = false;								
								document.getElementById("observacao").disabled = false;								
								document.getElementById("alterar").disabled = false;
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
						<form name="formcomissoes" action="<?php echo $configUrlGer; ?>financeiro/comissoes/alterar/<?php echo $url[6];?>/" method="post">

							<script type="text/javascript">
								function carregaBairro(cod){
									var $tgf = jQuery.noConflict();
									$tgf.post("<?php echo $configUrl;?>financeiro/comissoes/carrega-bairro.php", {codCidade: cod}, function(data){
										$tgf("#carrega-bairro").html(data);
										$tgf("#sel-padrao").css("display", "none");																									
									});
								}
							</script>
							
							<p class="bloco-campo-float"><label>Cidade: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="cidades" name="cidades" style="width:260px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required onChange="carregaBairro(this.value);">
									<option value="">Selecione</option>
<?php
					$sqlCidade = "SELECT nomeCidade, codCidade FROM cidades WHERE statusCidade = 'T' ORDER BY nomeCidade ASC";
					$resultCidade = $conn->query($sqlCidade);
					while($dadosCidade = $resultCidade->fetch_assoc()){
?>
									<option value="<?php echo $dadosCidade['codCidade'] ;?>" <?php echo $_SESSION['cidades'] == $dadosCidade['codCidade'] ? '/SELECTED/' : '';?>><?php echo $dadosCidade['nomeCidade'] ;?></option>
<?php
					}
?>					
								</select>
							</p>
							
<?php
					if($_SESSION['cidades'] == ""){
?>													
							<div id="sel-padrao">
								<p class="bloco-campo-float"><label class="label">Bairro: <span class="obrigatorio"> * </span></label>
									<select id="bairro" class="campo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="bairro" style="width:310px;">
										<option id="option" value="">Selecione uma cidade primeiro</option>
									</select>
									<br class="clear"/>
								</p>
							</div>
<?php
					}
?>													
							<div id="carrega-bairro">
<?php
					if($_SESSION['cidades'] != ""){
?>
								<p class="bloco-campo-float"><label class="label">Bairro: <span class="obrigatorio"> * </span></label>
									<select class="campo" name="bairro" style="width:310px;" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="bairro" required onChange="carregaQuadra();">
										<option value="" style="color:#FFF;">Selecione</option>

<?php
						$sqlBairro = "SELECT * FROM bairros WHERE statusBairro = 'T' and codCidade = ".$_SESSION['cidades']." ORDER BY nomeBairro ASC";
						$resultBairro = $conn->query($sqlBairro);
						while($dadosBairro = $resultBairro->fetch_assoc()){			
?>
										<option value="<?php echo $dadosBairro['codBairro']; ?>" <?php echo $dadosBairro['codBairro'] == $_SESSION['bairro'] ? '/SELECTED/' : ''; ?>><?php echo $dadosBairro['nomeBairro']; ?></option>
<?php
						}
?>
									</select>
								</p>
<?php
					}
?>
							</div>

							<p class="bloco-campo-float"><label>Quadra: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="quadras" name="quadras" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:100px;" required >
									<option value="">Selecione</option>
<?php
					$sqlQuadra = "SELECT nomeQuadra, codQuadra FROM quadras ORDER BY nomeQuadra ASC";
					$resultQuadra = $conn->query($sqlQuadra);
					while($dadosQuadra = $resultQuadra->fetch_assoc()){
?>
									<option value="<?php echo $dadosQuadra['codQuadra'] ;?>" <?php echo $_SESSION['quadras'] == $dadosQuadra['codQuadra'] ? '/SELECTED/' : '';?>><?php echo $dadosQuadra['nomeQuadra'] ;?></option>
<?php
					}
?>					
								</select>
							</p>

							<p class="bloco-campo-float"><label>Lote: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="lotes" name="lotes" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:100px;" required >
									<option value="">Selecione</option>
<?php
					$sqlLote = "SELECT nomeLote, codLote FROM lotes ORDER BY nomeLote ASC";
					$resultLote = $conn->query($sqlLote);
					while($dadosLote = $resultLote->fetch_assoc()){
?>
									<option value="<?php echo $dadosLote['codLote'] ;?>" <?php echo $_SESSION['lotes'] == $dadosLote['codLote'] ? '/SELECTED/' : '';?>><?php echo $dadosLote['nomeLote'] ;?></option>
<?php
					}
?>					
								</select>
							</p>
							
							<br class="clear"/>

							<p class="bloco-campo-float"><label>Data: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="date" name="data" id="data" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> required style="width:110px; height:16px;" value="<?php echo $_SESSION['data'];?>" onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);"/></p>	
							
							<p class="bloco-campo-float"><label>Valor do Imóvel: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="valor-imovel" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="valor-imovel" required style="width:120px;" value="<?php echo $_SESSION['valor-imovel'];?>" onKeyup="moeda(this);"/></p>	
							
							<p class="bloco-campo-float"><label>Comissão Imobiliária: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="comissao-imobiliaria" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="comissao-imobiliaria" required style="width:160px;" value="<?php echo $_SESSION['comissao-imobiliaria'];?>" onKeyup="moeda(this);"/></p>	

							<p class="bloco-campo-float"><label>OBS Imobiliária: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" name="obs-imobiliaria" id="obs-imobiliaria" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:178px;" value="<?php echo $_SESSION['obs-imobiliaria'];?>"/></p>	

							<p class="bloco-campo-float"><label>Comissão Paga? <span class="obrigatorio"> </span></label>
							<label style="float:left; margin-top:10px; font-weight:normal; margin-right:20px;"><input type="radio" name="comissao-paga" id="comissao-paga1" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> value="S" <?php echo $_SESSION['comissao-paga'] == "S" ? 'checked' : '';?> /> Sim </label> <label style="float:left; margin-top:10px; font-weight:normal;"><input type="radio" name="comissao-paga" id="comissao-paga2" value="N" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> <?php echo $_SESSION['comissao-paga'] == "N" || $_SESSION['comissao-paga'] == "" ? 'checked' : '';?> /> Não </label></p>	
							
							<br class="clear"/>
							
							<p class="bloco-campo-float"><label>Corretor Venda: <span class="obrigatorio"> * </span></label>
								<select class="campo" id="corretor-venda" name="corretor-venda" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:200px;" required >
									<option value="">Selecione</option>
<?php
					$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios ORDER BY nomeUsuario ASC";
					$resultUsuario = $conn->query($sqlUsuario);
					while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
									<option value="<?php echo $dadosUsuario['codUsuario'] ;?>" <?php echo $_SESSION['corretor-venda'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
					}
?>					
								</select>
							</p>
														
							<p class="bloco-campo-float"><label>Comissão Venda: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="valor-comissao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="valor-comissao" required style="width:150px;" value="<?php echo $_SESSION['valor-comissao'];?>" onKeyup="moeda(this);"/></p>	
							
							<p class="bloco-campo-float"><label>OBS Corretor Venda: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" name="obs-corretor-venda" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="obs-corretor-venda" style="width:400px;" value="<?php echo $_SESSION['obs-corretor-venda'];?>"/></p>	
							
							<br class="clear"/>
							
							<p class="bloco-campo-float"><label>Corretor AG: <span class="obrigatorio"> </span></label>
								<select class="campo" id="corretor-ag" name="corretor-ag" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:200px;" >
									<option value="">Selecione</option>
<?php
					$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios ORDER BY nomeUsuario ASC";
					$resultUsuario = $conn->query($sqlUsuario);
					while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
									<option value="<?php echo $dadosUsuario['codUsuario'] ;?>" <?php echo $_SESSION['corretor-ag'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
					}
?>					
								</select>
							</p>
														
							<p class="bloco-campo-float"><label>Comissão AG: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" name="comissao-ag" id="comissao-ag" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:150px;" value="<?php echo $_SESSION['comissao-ag'];?>" onKeyup="moeda(this);"/></p>	
							
							<p class="bloco-campo-float"><label>OBS Corretor AG: <span class="obrigatorio"> </span></label>
							<input class="campo" type="text" name="obs-corretor-ag" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="obs-corretor-ag" style="width:400px;" value="<?php echo $_SESSION['obs-corretor-ag'];?>"/></p>	
							
							<br class="clear"/>
																												
							<p class="bloco-campo"><label>Observação Geral: <span class="em" style="font-weight:normal;">Somente para o Admin</span></label>
							<textarea id="observacao" class="campo desabilita" name="observacao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="text" style="width:780px; height:80px; padding:10px;" ><?php echo $_SESSION['observacao']; ?></textarea></p>
																		
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> class="botao" type="submit" name="alterar" title="Alterar" value="Alterar" onClick="verificaDados();"/><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
					if(isset($_POST['funcionario'])){
						
					}else{
						
						echo "<script>carregaContrato2(".$dadosComissao['codContrato'].");</script>";
					}
				}

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
