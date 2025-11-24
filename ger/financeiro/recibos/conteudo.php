<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "recibos";
			if(validaAcesso($conn, $area) == "ok"){
				
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Recibo <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
					$_SESSION['cpf'] = "";
					$_SESSION['data-impre'] = "";
					$_SESSION['valor-impre'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Recibo <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Recibo <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}	
				
				$sqlRecibos = "SELECT * FROM recibos WHERE nomeRecibo = 'Recibo' ORDER BY codRecibo DESC";
				$resultRecibos = $conn->query($sqlRecibos);
				while($dadosRecibos = $resultRecibos->fetch_assoc()){
					
					$sqlUpdate = "UPDATE recibos SET nomeRecibo = 'Recibo ".$dadosRecibos['codRecibo']."' WHERE codRecibo = ".$dadosRecibos['codRecibo']."";
					$resultUpdtae = $conn->query($sqlUpdate);
					
				}
				
				$_SESSION['descricao'] = "";
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Recibos</p>
						<br class="clear" />
					</div>
					<div class="demoTarget">
						<div id="formulario-filtro">
<?php
				if(isset($_POST['imprimir'])){

					$valor = str_replace(".", "", $_POST['valor-impre']);
					$valor = str_replace(".", "", $valor);
					$valor = str_replace(",", ".", $valor);		
							
					$sqlInsere = "INSERT INTO recibos VALUES(0, '".$_POST['tipo']."', '".$_POST['nome-impre']."', '".$_POST['cpf-impre']."', '".data($_POST['data-impre'])."', '".$valor."', '".$_POST['descricao-impre']."', 'T')";
					$resultInsere = $conn->query($sqlInsere);
					
					if($resultInsere == 1){
						
						$sqlRecibo = "SELECT * FROM recibos WHERE codRecibo != '' ORDER BY codRecibo DESC LIMIT 0,1";
						$resultRecibo = $conn->query($sqlRecibo);
						$dadosRecibo = $resultRecibo->fetch_assoc();
						
						$_SESSION['cadastrado'] = $dadosRecibo['codRecibo'];

						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/recibos/'>";
					}
				}else{
					$_SESSION['tipo'] = "P";
					$_SESSION['nome-impre'] = "";
					$_SESSION['cpf-impre'] = "";
					$_SESSION['data-impre'] = data(date('Y-m-d'));
					$_SESSION['valor-impre'] = "";
					$_SESSION['descricao-impre'] = "";
				}	
?>
							<script>
								function enviar(){
									document.filtro.submit(); 
								}
								
								function abreCadastrar(){
									var $tg = jQuery.noConflict();
									$tg("#cadastrar-recibos").toggle("slow");
								}
								
								function imprimeRecibo(id, pg, cod){
									var printContents = document.getElementById(id).innerHTML;
									var originalContents = document.body.innerHTML;

									document.body.innerHTML = printContents;

									window.print();

									document.body.innerHTML = originalContents;
								}

								function moeda(z){  
									v = z.value;
									v=v.replace(/\D/g,"")  //permite digitar apenas números
									v=v.replace(/[0-9]{12}/,"inválido")   //limita pra máximo 999.999.999,99
									v=v.replace(/(\d{1})(\d{8})$/,"$1.$2")  //coloca ponto antes dos últimos 8 digitos
									v=v.replace(/(\d{1})(\d{5})$/,"$1.$2")  //coloca ponto antes dos últimos 5 digitos
									v=v.replace(/(\d{1})(\d{1,2})$/,"$1,$2")	//coloca virgula antes dos últimos 2 digitos
									z.value = v;
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

							<form name="filtro" action="<?php echo $configUrl;?>financeiro/recibos/" method="post" />

								<div class="botao-novo" style="margin-left:0px;"><a title="Nova Recibo" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Recibo</div><div class="direita-novo"></div></a></div>
							
								<br class="clear" />
							
								<div id="cadastrar-recibos" style="margin-top:20px; display:none;">

									<p class="bloco-campo"><label>Tipo Recibo: </label>
										<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-right:25px; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" onClick="trocaLabel('P');" <?php echo $_SESSION['tipo'] == 'P' ? 'checked' : '';?> name="tipo" value="P"/>Pago</label>
										<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-top:5px; cursor:pointer;"><input type="radio" style="cursor:pointer;" name="tipo" onClick="trocaLabel('R');" <?php echo $_SESSION['tipo'] == 'R' ? 'checked' : '';?> value="R"/>Recebido</label>
										<br class="clear"/>
									</p>
									
									<br class="clear"/>
							
									<p class="bloco-campo"><label>Nome: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="text" id="nome-impre" name="nome-impre" required style="width:205px;" value="<?php echo $_SESSION['nome']; ?>" /></p>

									<p class="bloco-campo"><label>CPF / CNPJ: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="text" id="cpf-impre" name="cpf-impre" required style="width:180px;" value="<?php echo $_SESSION['cpf']; ?>" onKeyDown="mascaraMutuario(this,cpfCnpj);" onKeyPress="mascaraMutuario(this,cpfCnpj);" onKeyUp="mascaraMutuario(this,cpfCnpj);"/></p>

									<p class="bloco-campo"><label>Data: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="text" id="data-impre" name="data-impre" required style="width:100px;" value="<?php echo $_SESSION['data-impre']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

									<p class="bloco-campo"><label>Valor: <span class="obrigatorio"> * </span></label>
									<input class="campo" type="text" id="valor-impre" name="valor-impre" required style="width:100px;" value="<?php echo $_SESSION['valor-impre']; ?>" onKeyUp="moeda(this);"/></p>
								
									<br class="clear"/>
								
									<p class="bloco-campo"><label>Referente a:<span class="obrigatorio"> * </span></label>
									<textarea class="desabilita campo" id="descricao-impre" name="descricao-impre" required type="text" style="width:663px; height:150px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>
									
									<br class="clear"/>
									
									<div class="botao-expansivel"><p class="esquerda-botao" style="margin-right:0px;"></p><input id="alterar" class="botao" type="submit" name="imprimir" title="Imprimir" value="Imprimir"/><p class="direita-botao"></p><br class="clear"/></div>													
									
								</div>
							
							</form>							
						</div>
					</div>			
				</div>
				<div id="dados-conteudo">
					<div id="consultas">
						<div class="area-erro" id="erro-area" style="<?php echo $erroConteudo != "" ? 'display:block;' : 'display:none;';?>"><?php echo $erroConteudo;?></div>
<?php
				$sqlConta = "SELECT count(codRecibo) registros, nomeRecibo FROM recibos WHERE codRecibo != ''";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($dadosConta['nomeRecibo'] != ""){
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Nome</th>
								<th>Data</th>
								<th>Imprimir</th>
								<th>Anexo</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>					
<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlRecibo = "SELECT * FROM recibos ORDER BY statusRecibo ASC, codRecibo DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlRecibo = "SELECT * FROM recibos ORDER BY statusRecibo ASC, codRecibo DESC LIMIT ".$paginaInicial.",30";
					}		

					$resultRecibo = $conn->query($sqlRecibo);
					while($dadosRecibo = $resultRecibo->fetch_assoc()){
						$mostrando++;
						
						if($dadosRecibo['statusRecibo'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}		
?>
							<tr class="tr">
								<td class="sessenta"><a href='<?php echo $configUrlGer; ?>financeiro/recibos/alterar/<?php echo $dadosRecibo['codRecibo'] ?>/' title='Veja os detalhes do recibo <?php echo $dadosRecibo['nomeRecibo'] ?>'><?php echo $dadosRecibo['nomeRecibo'];?></a></td>
								<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>financeiro/recibos/alterar/<?php echo $dadosRecibo['codRecibo'] ?>/' title='Veja os detalhes do recibo <?php echo $dadosRecibo['nomeRecibo'] ?>'><?php echo data($dadosRecibo['dataRecibo']);?></a></td>
								<td class="botao" style="text-align:center;"><a title='Deseja imprimir o recibo <?php echo $dadosRecibo['nomeRecibo'] ?>'><img onClick="imprimeRecibo('imprime-requisicao<?php echo $dadosRecibo['codRecibo'];?>', 'imprime.html', <?php echo $dadosRecibo['codRecibo'];?>);" style="cursor:pointer;" src="<?php echo $configUrlGer;?>f/i/icon-impressora2.png" alt="Imprimir"/></a></td>
								<div id="conteudo-imprimir<?php echo $dadosRecibo['codRecibo'];?>" style="width:900px; margin-top:-100px; display:none; min-height:500px; position:absolute; z-index:1; left:50%; margin-left:-450px; box-shadow:0px 0px 20px #528585; border-radius:10px; background-color:#FFFFFF;">
									<div id="conteudo-scroll" style="width:900px; height:500px; overflow-y:auto;">
										<div id="imprime-requisicao<?php echo $dadosRecibo['codRecibo'];?>" style="width:800px; padding-top:20px; padding-bottom:20px; margin:0 45px auto;">
											<div style="width:800px; margin:0 auto;">
												<script type="text/javascript">
													function imprime() {
														var oJan;
														oJan.window.print();
													}
																					
													function tiraBotao() {
														document.getElementById("botao-imprimir<?php echo $dadosRecibo['codRecibo'];?>").style.display="none";									 
													}								
												</script>
												<p style="display:none; margin: auto; margin-bottom:20px;" id="botao-imprimir<?php echo $dadosRecibo['codRecibo'];?>"><input type="submit" value="Imprimir" onClick="tiraBotao(); imprime(window.print());"/></p>
												<div id="topo-requisicao" style="width:800px; border-bottom:2px solid #000000;">	
													<p style="display:table; margin:0 auto; padding-bottom:10px;"><img src="<?php echo $configUrlGer;?>f/i/comp.png" height="80"/></p>
													<div style="display:table; margin:0 auto;">
														<div style="display:table; margin:0 auto;">
															<p style="font-size:13px; padding:0px; margin:0px; font-family:Arial; float:left; margin-right:30px; margin-bottom:5px;"><?php echo $cnpjImobiliaria;?></p>
															<p style="font-size:13px; padding:0px; margin:0px; font-family:Arial; float:left; margin-bottom:5px;"><?php echo $telefoneImobiliaria;?></p>
															<br style="clear:both;"/>
														</div>
														<p style="text-align:center; font-size:13px; padding:0px; margin:0px; font-family:Arial;"><?php echo $cidadeEstadoImobiliaria;?></p>
													</div>
													<br class="clear"/>
												</div>
												<div id="conteudo-requisicao" style="width:800px; position:relative; overflow-y:auto; margin-top:40px;">
													<div id="mostra-dados" style="width:100%;">
														<p style="text-align:center; font-size:20px; margin-top:20px; font-family:Arial; font-weight:bold; position:absolute; right:0;" id="insere-valor">R$ <?php echo number_format($dadosRecibo['valorRecibo'], 2, ",", ".");?></p>
														<p style="text-align:center; font-size:18px; font-family:Arial; font-weight:bold;">R E C I B O</p>
<?php
						if($dadosRecibo['tipoRecibo'] == "R"){
?>														
														<div style="padding-top:20px; padding-top:40px; font-family:Arial; font-size:18px; text-align:center;" id="dados-insere">Recebemos de <?php echo $dadosRecibo['nomeRecibo'];?>, com inscrição no CPF/CNPJ <?php echo $dadosRecibo['cpfRecibo'];?>, na data de <?php echo data($dadosRecibo['dataRecibo']);?>, o valor de R$ <?php echo number_format($dadosRecibo['valorRecibo'], 2, ",", ".");?>, referente a <?php echo $dadosRecibo['descricaoRecibo'];?></div>
														<p style="text-align:center; padding-top:60px;">________________________________________</p>
														<p style="text-align:center; padding:0px; font-family:Arial; margin:0px;" id="insere-nome"><?php echo $razaoImobiliaria;?></p>
														<p style="text-align:center; padding:0px; font-family:Arial; padding-top:7px; margin:0px;" id="insere-data"><?php echo data($dadosRecibo['dataRecibo']);?></p>
<?php
						}else{
?>
														<div style="padding-top:20px; padding-top:40px; font-family:Arial; font-size:18px; text-align:center;" id="dados-insere">Recebi de <?php echo $razaoImobiliaria;?>, com inscrição no CNPJ <?php echo $cnpjImobiliaria;?>, na data de <?php echo data($dadosRecibo['dataRecibo']);?>, o valor de R$ <?php echo number_format($dadosRecibo['valorRecibo'], 2, ",", ".");?>, referente a <?php echo $dadosRecibo['descricaoRecibo'];?></div>
														<p style="text-align:center; padding-top:60px;">________________________________________</p>
														<p style="text-align:center; padding:0px; font-family:Arial; margin:0px;" id="insere-nome"><?php echo $dadosRecibo['nomeRecibo'] != "Recibo ".$dadosRecibo['codRecibo'] ? $dadosRecibo['nomeRecibo'] : '';?></p>
														<p style="text-align:center; padding:0px; font-family:Arial; padding-top:7px; margin:0px;" id="insere-cpf"><?php echo $dadosRecibo['cpfRecibo'];?></p>
														<p style="text-align:center; padding:0px; font-family:Arial; padding-top:7px; margin:0px;" id="insere-data"><?php echo data($dadosRecibo['dataRecibo']);?></p>

<?php
						}
?>
													</div>
												</div>
											</div>
										</div>
									</div>	
								</div>	
								<td class="botoes" style="padding:0px;"><a href='<?php echo $configUrl; ?>financeiro/recibos/gerenciar-documentos/<?php echo $dadosRecibo['codRecibo'] ?>/' title='Deseja cadastrar anexo para o recibo <?php echo $dadosRecibo['nomeRecibo'] ?>?' ><img src="<?php echo $configUrl;?>f/i/geren-documentos.png" alt="icone"/></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>financeiro/recibos/ativacao/<?php echo $dadosRecibo['codRecibo'] ?>/' title='Deseja <?php echo $statusPergunta ?> o recibo <?php echo $dadosRecibo['nomeRecibo'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>financeiro/recibos/alterar/<?php echo $dadosRecibo['codRecibo'] ?>/' title='Deseja alterar o recibo <?php echo $dadosRecibo['nomeRecibo'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosRecibo['codRecibo'] ?>, "<?php echo htmlspecialchars($dadosRecibo['nomeRecibo']) ?>");' title='Deseja excluir o recibo <?php echo $dadosRecibo['nomeRecibo'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
							</tr>
<?php
					}
?>
							<script>
								function confirmaExclusao(cod, nome){
									if(confirm("Deseja excluir o recibo "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>financeiro/recibos/excluir/'+cod+'/';
									}
								}
							 </script>							 
						</table>	
<?php
				}
				
				$regPorPagina = 30;
				$area = "financeiro/recibos";
				include ('f/conf/paginacao.php');		
?>							
					</div>
				</div>
<?php
				if($_SESSION['cadastrado'] != ""){
?>					
				<script type="text/javascript">
					setTimeout("imprimeRecibo('imprime-requisicao', 'imprime.html', <?php echo $_SESSION['cadastrado'];?>), 100");			
				</script>					
<?php					
					$_SESSION['cadastrado'] = "";
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
