<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "recibos";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlNomePagamento = "SELECT codRecibo, nomeRecibo, statusRecibo FROM recibos WHERE codRecibo = '".$url[6]."' LIMIT 0,1";
				$resultNomePagamento = $conn->query($sqlNomePagamento);
				$dadosNomePagamento = $resultNomePagamento->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Recibos</p>
						<p class="flexa"></p>
						<p class="nome-lista">Alterar</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomePagamento['nomeRecibo'] ;?></p>
						<br class="clear" />
					</div>
					<table class="tabela-interno" >
<?php
				if($dadosNomePagamento['statusRecibo'] == "T"){
					$status = "status-ativo";
					$statusIcone = "ativado";
					$statusPergunta = "desativar";
				}else{
					$status = "status-desativado";
					$statusIcone = "desativado";
					$statusPergunta = "ativar";
				}		
?>	
						<tr class="tr-interno">
							<td class="botoes-interno"><a href='<?php echo $configUrl; ?>financeiro/recibos/ativacao/<?php echo $dadosNomePagamento['codRecibo'] ?>/' title='Deseja <?php echo $statusPergunta ?> o recibo <?php echo $dadosNomePagamento['nomeRecibo'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone"></a></td>
							<td class="botoes-interno"><a href='javascript: confirmaExclusao(<?php echo $dadosNomePagamento['codRecibo'] ?>, "<?php echo htmlspecialchars($dadosNomePagamento['nomeRecibo']) ?>");' title='Deseja excluir o recibo <?php echo $dadosNomePagamento['nomeRecibo'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir-branco.gif' alt="icone"></a></td>
						</tr>
						<script>
							function confirmaExclusao(cod, nome){

								if(confirm("Deseja excluir o recibo "+nome+"?")){
									window.location='<?php echo $configUrlGer; ?>financeiro/recibos/excluir/'+cod+'/';
								}
							}
						</script>
					</table>	
					<div class="botao-consultar"><a title="Consultar Recibos" href="<?php echo $configUrl;?>financeiro/recibos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if(isset($_POST['alterar'])){
					$confereObrigatorio = array($_POST['valor-impre'], $_POST['descricao']);
					$nomesConfereObrigatorio = array('Valor', 'Descrição');
					include ('f/conf/verificaObrigatorio.php');
					
					if($erro != "ok"){
					
						include ('f/conf/criaUrl.php');
						$urlCategoria = criaUrl($_POST['nome']);
					
						if($_POST['status'] == 'T'){
							$ativar = 'T';
						}else{
							$ativar = 'F';
						}

						$valor = str_replace(".", "", $_POST['valor-impre']);
						$valor = str_replace(".", "", $valor);
						$valor = str_replace(",", ".", $valor);			
															
						$sql = "UPDATE recibos SET tipoRecibo = '".$_POST['tipo']."', nomeRecibo = '".$_POST['nome-impre']."', cpfRecibo = '".$_POST['cpf-impre']."', dataRecibo = '".data($_POST['data-impre'])."', valorRecibo = '".$valor."', descricaoRecibo = '".$_POST['descricao']."' WHERE codRecibo = '".$url[6]."'";
						$result = $conn->query($sql); 
						
						if($result == 1){
							$_SESSION['alteracao'] = "ok";
							$_SESSION['nome'] = $_POST['nome-impre'];
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."financeiro/recibos/'>";
						}else{
							$erroData = "<p class='erro'>Problemas ao alterar recibo!</p>";
						}
					}else{
						$erroAtiva = "ok";
						$_SESSION['descricao'] = $_POST['descricao'];
					}
				}else{
					$sql = "SELECT * FROM recibos WHERE codRecibo = ".$url[6];
					$result = $conn->query($sql);
					$dadosRecibo = $result->fetch_assoc();
					$_SESSION['tipo'] = $dadosRecibo['tipoRecibo'];
					$_SESSION['nome-impre'] = $dadosRecibo['nomeRecibo'];
					$_SESSION['cpf-impre'] = $dadosRecibo['cpfRecibo'];
					$_SESSION['data-impre'] = data($dadosRecibo['dataRecibo']);
					$_SESSION['valor-impre'] = number_format($dadosRecibo['valorRecibo'], 2, ",", ".");
					$_SESSION['descricao'] = $dadosRecibo['descricaoRecibo'];
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
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>
						<script>
							function habilitaCampo(){
								document.getElementById("tipo1").disabled = false;
								document.getElementById("tipo2").disabled = false;
								document.getElementById("nome-impre").disabled = false;
								document.getElementById("cpf-impre").disabled = false;
								document.getElementById("data-impre").disabled = false;
								document.getElementById("valor-impre").disabled = false;
								document.getElementById("descricao").disabled = false;
								document.getElementById("alterar").disabled = false;
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
 
						<form action="<?php echo $configUrlGer; ?>financeiro/recibos/alterar/<?php echo $url[6] ;?>/" method="post">

							<p class="bloco-campo"><label>Tipo Recibo: </label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-right:25px; margin-top:5px; cursor:pointer;"><input type="radio" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="cursor:pointer;" onClick="trocaLabel('P');" <?php echo $_SESSION['tipo'] == 'P' ? 'checked' : '';?> id="tipo1" name="tipo" value="P"/>Pago</label>
								<label class="label" style="float:left; font-size:16px; font-weight:normal; margin-top:5px; cursor:pointer;"><input type="radio" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="cursor:pointer;" id="tipo2" name="tipo" onClick="trocaLabel('R');" <?php echo $_SESSION['tipo'] == 'R' ? 'checked' : '';?> value="R"/>Recebido</label>
								<br class="clear"/>
							</p>
																
							<p class="bloco-campo-float"><label>Nome: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="nome-impre" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="nome-impre" style="width:205px;" value="<?php echo $_SESSION['nome-impre']; ?>" /></p>

							<p class="bloco-campo-float"><label>CPF / CNPJ: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="cpf-impre" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="cpf-impre" style="width:180px;" value="<?php echo $_SESSION['cpf-impre']; ?>" onKeyDown="mascaraMutuario(this,cpfCnpj);" onKeyPress="mascaraMutuario(this,cpfCnpj);" onKeyUp="mascaraMutuario(this,cpfCnpj);"/></p>

							<p class="bloco-campo-float"><label>Data: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="data-impre" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="data-impre" style="width:100px;" value="<?php echo $_SESSION['data-impre']; ?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data);"/></p>

							<p class="bloco-campo-float"><label>Valor: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="text" id="valor-impre" required <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="valor-impre" style="width:100px;" value="<?php echo $_SESSION['valor-impre']; ?>" onKeyUp="moeda(this);"/></p>

							<br class="clear"/>

							<p class="bloco-campo"><label>Referente a:<span class="obrigatorio"> * </span></label>
							<textarea class="desabilita campo" id="descricao" required name="descricao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="text" style="width:663px; height:150px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>


							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" id="alterar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="submit" name="alterar" title="Alterar" value="Alterar" /><p class="direita-botao"></p></div></p>						
							<br class="clear"/>
						</form>
					</div>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['descricao'] = "";
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
