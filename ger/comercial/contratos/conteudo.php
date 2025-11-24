<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "contratos";
			if(validaAcesso($conn, $area) == "ok"){

				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Contrato cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Contrato alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Status do Contrato alterado com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Contrato excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['estornar'] == "ok"){
					$erroConteudo = "<p class='erro'>Contrato estornado com sucesso!</p>";
					$_SESSION['estornar'] = "";
					$_SESSION['nome'] = "";
				}

				if(isset($_POST['corretorFiltro'])){
					if($_POST['corretorFiltro'] != ""){
						$_SESSION['corretorFiltro'] = $_POST['corretorFiltro'];
					}else{
						$_SESSION['corretorFiltro'] = "";
					}
				}
				
				if($_SESSION['corretorFiltro'] != ""){
					$filtraUsuario = " and C.codUsuario = '".$_SESSION['corretorFiltro']."'";
				}
								
				if(isset($_POST['statusFiltroContrato'])){
					if($_POST['statusFiltroContrato'] != ""){
						$_SESSION['statusFiltroContrato'] = $_POST['statusFiltroContrato'];
					}else{
						$_SESSION['statusFiltroContrato'] = "";
					}
				}
				
				if($_SESSION['statusFiltroContrato'] != ""){
					$filtraStatus = " and C.statusContrato = '".$_SESSION['statusFiltroContrato']."'";
				}
										
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Comercial</p>
						<p class="flexa"></p>
						<p class="nome-lista">Contratos</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
							<script>
								function abreCadastrar(){
									var $rf = jQuery.noConflict();
									if(document.getElementById("cadastrar").style.display=="none"){
										document.getElementById("botaoFechar").style.display="block";
										$rf("#cadastrar").slideDown(250);
									}else{
										document.getElementById("botaoFechar").style.display="none";
										$rf("#cadastrar").slideUp(250);
									}
								}

								function mascaraMutuario(o,f){
									v_obj=o
									v_fun=f
									setTimeout('execmascara()',1)
								}
								 
								function execmascara(){
									v_obj.value=v_fun(v_obj.value)
								}
								 
								function cpfCnpj(v){
								 
									//Remove tudo o que não é dígito
									v=v.replace(/\D/g,"")
								 
									if (v.length <= 13) { //CPF
								 
										//Coloca um ponto entre o terceiro e o quarto dígitos
										v=v.replace(/(\d{3})(\d)/,"$1.$2")
								 
										//Coloca um ponto entre o terceiro e o quarto dígitos
										//de novo (para o segundo bloco de números)
										v=v.replace(/(\d{3})(\d)/,"$1.$2")
								 
										//Coloca um hífen entre o terceiro e o quarto dígitos
										v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2")
								 
									} else { //CNPJ
								 
										//Coloca ponto entre o segundo e o terceiro dígitos
										v=v.replace(/^(\d{2})(\d)/,"$1.$2")
								 
										//Coloca ponto entre o quinto e o sexto dígitos
										v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3")
								 
										//Coloca uma barra entre o oitavo e o nono dígitos
										v=v.replace(/\.(\d{3})(\d)/,".$1/$2")
								 
										//Coloca um hífen depois do bloco de quatro dígitos
										v=v.replace(/(\d{4})(\d)/,"$1-$2")
								 
									}
								 
									return v
								 
								}								
							</script>
							<script type="text/javascript">
								function alteraStatus(status){
									document.getElementById("filtroStatus").submit();
								}
							</script>
							<form id="filtroStatus" name="filtro" action="<?php echo $configUrl;?>comercial/contratos/" method="post" >
								<p class="nome-clientes-filtro" style="width:210px;"><label class="label">Cliente:</label>
								<input type="text" style="width:190px;" name="clientes" onKeyUp="buscaAvancada();" id="buscaNome" autocomplete="off" value="<?php echo $_SESSION['nome-clientes-filtro'];?>" /></p>
								<input style="display:none;" type="text" size="16" name="teste" value="" />

								<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> </span></label>
									<select class="campo" id="corretorFiltro" name="corretorFiltro" style="width:200px; padding:6px; margin-right:0px;" onChange="alteraStatus();">
										<option value="">Todos</option>
<?php
				$sqlUsuario = "SELECT nomeUsuario, codUsuario FROM usuarios WHERE statusUsuario = 'T' and codUsuario != 4 ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
										<option value="<?php echo $dadosUsuario['codUsuario'] ;?>" <?php echo $_SESSION['corretorFiltro'] == $dadosUsuario['codUsuario'] ? '/SELECTED/' : '';?>><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
}
?>					
									</select>
									<br class="clear"/>
								</p>	
								
								<div class="botao-novo"><a onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Contrato</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:none; margin-left:0px;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-Cliente">X</div><div class="direita-novo"></div></a></div>
								<br class="clear" />
							</form>
						</div>
					</div>			
<?php
				if($_POST['cadastrar'] != ""){

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
																																
						$insertContrato = "INSERT INTO contratos VALUES(0, ".$_POST['corretor'].", '".$dadosPegaCliente['codCliente']."', '".$valorVenda."', '".$valorComissao."', '".data($_POST['data-venda'])."', '".$_POST['observacao']."', 'T', 'T')";
						$resultContrato = $conn->query($insertContrato);					
														
						if($resultContrato == 1){
							
							$sqlContrato = "SELECT * FROM contratos ORDER BY codContrato DESC LIMIT 0,1";
							$resultContrato = $conn->query($sqlContrato);
							$dadosContrato = $resultContrato->fetch_assoc();
							
							if($_POST['total-imoveis'] >= 1){
								for($i=0; $i<=$_POST['total-imoveis']; $i++){
									if($_POST['imovel'.$i] != ""){

										$num_com_zeros = str_pad($_POST['imovel'.$i], 4, "0", STR_PAD_LEFT);
										
										$sqlImovel = "SELECT * FROM imoveis WHERE statusImovel = 'T' and codigoImovel = '".$num_com_zeros."' ORDER BY codImovel DESC LIMIT 0,1";
										$resultImovel = $conn->query($sqlImovel);
										$dadosImovel = $resultImovel->fetch_assoc();
										
										if($dadosImovel['codImovel'] != ""){
											$sqlInsere = "INSERT INTO contratosImoveis VALUES(0, ".$dadosContrato['codContrato'].", ".$dadosImovel['codImovel'].")";
											$resultInsere = $conn->query($sqlInsere);
										}
										
									}									
								}
							}
							
							$_SESSION['cadastro'] = "ok";
							$_SESSION['clientes'] = "";
							$_SESSION['corretor'] = "";
							$_SESSION['valor-venda'] = "";
							$_SESSION['data-venda'] = "";
							$_SESSION['observacoes'] = "";						
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/contratos/'>";
						}else{
							$erroData = "<p class='erro'>Problemas ao cadastrar contrato!</p>";
							$_SESSION['clientes'] = "";
							$_SESSION['corretor'] = "";
							$_SESSION['valor-venda'] = "";
							$_SESSION['data-venda'] = "";						
							$_SESSION['observacoes'] = "";						
							$display = "none";
						}

					}else{
						$erroData = "<p class='erro'>O Cliente <strong>".$_POST['clientes']."</strong> não foi encontrado.</p>";
						$_SESSION['clientes'] = "";
						$_SESSION['corretor'] = $_POST['corretor'];
						$_SESSION['valor-venda'] = $_POST['valor-venda'];
						$_SESSION['data-venda'] = $_POST['data-venda'];				
						$_SESSION['observacoes'] = $_POST['observacoes'];
						echo "<script>carregaImovel();</script>";
						$display = "block";			
					}						

				}else{
					$_SESSION['clientes'] = "";
					$_SESSION['corretor'] = "";
					$_SESSION['valor-venda'] = "";
					$_SESSION['data-venda'] = data(date('Y-m-d'));
					$_SESSION['observacoes'] = "";
					$display = "none";	
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
					<div id="cadastrar" style="display:<?php echo $display;?>; margin-left:30px; margin-top:30px; margin-bottom:30px;">															
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<form name="formcontratos" action="<?php echo $configUrlGer; ?>comercial/contratos/" method="post">

							<p class="bloco-campo-float"><label>Corretor: <span class="obrigatorio"> </span></label>
								<select class="campo" id="corretor" name="corretor" style="width:200px; padding:6px; margin-right:0px;">
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
								<input class="campo" type="text" name="clientes" required style="width:239px;" value="<?php echo $_SESSION['clientes']; ?>" onClick="auto_complete(this.value, 'clientes_c', event);" onKeyUp="auto_complete(this.value, 'clientes_c', event);" onBlur="fechaAutoComplete('clientes_c');" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest_clientes_c" /></p>
								
								<div id="exibe_busca_autocomplete_softbest_clientes_c" class="auto_complete_softbest" style="display:none;">

								</div>
							</div>	

							<p class="bloco-campo-float"><label>Valor Venda: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="valor-venda" id="valor-venda" required style="width:120px;" value="" onKeyup="moeda(this);"/></p>

							<p class="bloco-campo-float"><label>Valor Comissão: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" name="valor-comissao" id="valor-comissao" required style="width:120px;" value="" onKeyup="moeda(this);"/></p>

							<p class="bloco-campo-float"><label>Data da Venda: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="data-venda" required name="data-venda" style="width:110px;" value="<?php echo $_SESSION['data-venda']; ?>"  onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

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
									fetch('busca-imovel.php?codigoImovel=' + cod)
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
										<div id="bloco-imovel1">
											
											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Código: <span class="obrigatorio"> * </span></label>
											<input class="campo" type="text" id="imovel1" name="imovel1" required style="width:100px;" onKeyup="carregaImovel(this.value, 1);" value="" /></p>

											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Quadra: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="quadra1" readonly style="width:120px;" value="" /></p>

											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Lote: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="lote1" readonly style="width:120px;" value="" /></p>
											
											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Bairro / Cidade: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="bairro1" readonly style="width:220px;" value="" /></p>

											<p class="bloco-campo-float" style="margin-bottom:0px;"><label>Tipo Imóvel: <span class="obrigatorio"> </span></label>
											<input class="campo" type="text" id="tipo-imovel1" readonly style="width:120px;" value="" /></p>

											<br class="clear"/>
											
										</div>			
									</div>				
									
									<div class="botao-consultar" onClick="novoImovel();" style="margin-left:820px; margin-top:-31px; margin-bottom:0px; position:absolute;"><div class="esquerda-consultar"></div><div class="conteudo-consultar">+</div><div class="direita-consultar"></div></div>					
								</fieldset>
								
								<input type="hidden" value="1" name="total-imoveis" id="total-imoveis"/>									

							</div>
							

							<br class="clear"/>
							
							<p class="bloco-campo"><label>Observação: <span class="obrigatorio"> </span></label>
							<textarea id="observacao" class="campo desabilita" name="observacao" type="text" style="width:875px; height:80px; padding:10px;" ><?php echo $_SESSION['observacao']; ?></textarea></p>
														
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Contrato" value="Salvar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
				<div id="dados-conteudo">
					<div id="consultas">
<?php	
				if($erroConteudo != ""){
?>
						<div class="area-erro">
<?php
					echo $erroConteudo;	
?>
						</div>
<?php
				}
?>
						<script type="text/javascript">
							function buscaAvancada(area){
								var $AGD = jQuery.noConflict();
								var buscaNome = $AGD("#buscaNome").val();
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");
								buscaNome = buscaNome.replace(" ", "-");

								$AGD("#busca-carregada").load("<?php echo $configUrl;?>comercial/contratos/busca-contrato.php?buscaNome="+buscaNome);
								if(buscaNome == ""){
									document.getElementById("paginacao").style.display="block";
								}else{
									document.getElementById("paginacao").style.display="none";
								}
							}	

							function imprimeRecibo(id, pg, cod) {
								var printContents = document.getElementById(id).innerHTML;
								var originalContents = document.body.innerHTML;

								document.body.innerHTML = printContents;

								window.print();

								document.body.innerHTML = originalContents;
							}							
						</script>
						<div id="busca-carregada">
<?php										
				$sqlConta = "SELECT count(C.codContrato) registros, C.codContrato FROM contratos C inner join clientes CO on C.codCliente = CO.codCliente WHERE C.codContrato != ''".$filtraStatus.$filtraUsuario;
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['codContrato'] != ""){
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
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlContrato = "SELECT * FROM contratos C inner join clientes CO on C.codCliente = CO.codCliente WHERE C.codContrato != ''".$filtraStatus.$filtraUsuario." ORDER BY C.dataContrato DESC, C.codContrato DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlContrato = "SELECT * FROM contratos C inner join clientes CO on C.codCliente = CO.codCliente WHERE C.codContrato != ''".$filtraStatus.$filtraUsuario." ORDER BY C.dataContrato DESC, C.codContrato DESC LIMIT ".$paginaInicial.",30";
					}		

					$resultContrato = $conn->query($sqlContrato);
					while($dadosContrato = $resultContrato->fetch_assoc()){
						$mostrando++;

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
							</table>	
							<script type="text/javascript">
								function confirmaExclusao(cod, nome){
									if(confirm("Deseja excluir o contrato do cliente "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>comercial/contratos/excluir/'+cod+'/';
									}
								}							 
							</script> 							
<?php
				}
?>
						</div>
<?php				
				$regPorPagina = 30;
				$area = "comercial/contratos";
				include ('f/conf/paginacao.php');		
?>							
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
?>
<?php
		}else{
			echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."controle-acesso.php'>";
		}

	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login.php'>";
	}
?>
