<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "cheques";
			if(validaAcesso($conn, $area) == "ok"){

				$sqlNomeCheque = "SELECT * FROM cheques WHERE codCheque = '".$url[7]."'";
				$resultNomeCheque = $conn->query($sqlNomeCheque);
				$dadosNomeCheque = $resultNomeCheque->fetch_assoc();
?>
				<div id="localizacao-topo">
					<div id="conteudo-localizacao-topo">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Cheques</p>
						<p class="flexa"></p>
						<p class="nome-lista">A receber</p>
						<p class="flexa"></p>
						<p class="nome-lista">Detalhes</p>
						<p class="flexa"></p>
						<p class="nome-lista"><?php echo $dadosNomeCheque['nomeCheque'] ;?></p>
						<br class="clear" />
					</div>
<?php
				if($dadosNomeCheque['statusCheque'] == 'F'){
?>					
					<table class="tabela-interno" >
						<tr class="tr-interno">
						<td class="botoes-interno"><a href='<?php echo $configUrl; ?>financeiro/cheques/recebidos/baixa/<?php echo $dadosNomeCheque['codCheque'];?>/' title='Deseja estornar ?' ><img src='<?php echo $configUrl; ?>f/i/dinheiro-estorno.gif' alt="icone"></a></td>
						</tr>
					</table>
<?php
				}
?>					
					<div class="botao-consultar"><a title="Consultar cheques" href="<?php echo $configUrl;?>financeiro/cheques/recebidos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>					
					<br class="clear" />
				</div>
				<div id="dados-conteudo">
					<div id="cadastrar">
<?php
				if($dadosNomeCheque['statusCheque'] == 'F'){
?>						
						<p class="frase" style="padding-bottom:20px; padding-top:20px; font-weight:bold; color:#718B8F; font-size:18px;">Cheque recebido em <strong style="font-size:18px; color:#000;"><?php echo data($dadosNomeCheque['dataDescontoCheque']);?></strong></p>
<?php
				}
				
				if($_POST['paraCheque'] != "" || $_POST['descricao'] != ""){

					$sqlBancos = "SELECT codBancoConta FROM bancosConta WHERE codigoBancoConta = ".$_POST['numeroBancoCheque']." LIMIT 0,1";
					$resultBancos = $conn->query($sqlBancos);
					$dadosBancos = $resultBancos->fetch_assoc();

					$sqlUpdate = "UPDATE cheques SET codBancoConta = '".$dadosBancos['codBancoConta']."', nBancoCheque = '".$_POST['numeroBancoCheque']."', nomeCheque = '".$_POST['nomeCheque']."', agenciaCheque = '".$_POST['agenciaCheque']."', contaCheque = '".$_POST['contaCheque']."', numeroCheque = '".$_POST['numeroCheque']."', bomparaCheque = '".data($_POST['paraCheque'])."', descricaoCheque = '".$_POST['descricao']."' WHERE codCheque = ".$url[7]."";
					$resultUpdate = $conn->query($sqlUpdate);
					
					if($resultUpdate == 1){
						$erroData = "<p class='erro'>Cheque alterado com sucesso!</p>";
					}
					
				}	
				
				$sqlInformacoes = "SELECT C.*, CL.*, CP.*, CO.* FROM cheques C inner join contasParcial CP on C.codContaParcial = CP.codContaParcial inner join contas CO on CP.codConta = CO.codConta inner join clientes CL on CO.codCliente = CL.codCliente WHERE C.codCheque = ".$url[7];
				$resultInformacoes = $conn->query($sqlInformacoes);
				$dadosInformacoes = $resultInformacoes->fetch_assoc();	
				
				$_SESSION['cliente'] = $dadosInformacoes['nomeCliente'];	
				$_SESSION['bancoCheque'] = $dadosInformacoes['codBancoConta'];	
				$_SESSION['numeroBancoCheque'] = $dadosInformacoes['nBancoCheque'];	
				$_SESSION['nomeCheque'] = $dadosInformacoes['nomeCheque'];	
				$_SESSION['agenciaCheque'] = $dadosInformacoes['agenciaCheque'];	
				$_SESSION['contaCheque'] = $dadosInformacoes['contaCheque'];	
				$_SESSION['numeroCheque'] = $dadosInformacoes['numeroCheque'];	
				$_SESSION['paraCheque'] = data($dadosInformacoes['bomparaCheque']);	
				
				if($erroData != "" || $erro == "sim" || $erro == "ok"){
?>
						<div class="area-erro">
<?php
					echo $erroData;
?>
						</div>
<?php
				}	
?>
						<form action="<?php echo $configUrl;?>financeiro/cheques/recebidos/detalhes/<?php echo $url[7];?>/" method="post">	
<?php
				if($dadosInformacoes['baixaConta'] == 'T'){
?>
							<div class="botao-editar"><a title="Editar" href="javascript:habilitaCampo();"><div class="esquerda-editar"></div><div class="conteudo-editar">Editar</div><div class="direita-editar"></div></a></div>					
<?php
				}
?>				
							<script type="text/javascript">
								function habilitaCampo(){
									document.getElementById("bancoChequeAvista").disabled = false;
									document.getElementById("numeroBancoCheque").disabled = false;
									document.getElementById("nomeCheque").disabled = false;
									document.getElementById("agenciaCheque").disabled = false;
									document.getElementById("contaCheque").disabled = false;
									document.getElementById("numeroCheque").disabled = false;
									document.getElementById("paraCheque").disabled = false;
									document.getElementById("descricao").disabled = false;
									document.getElementById("alterar").disabled = false;
								}
							 </script>								
							<div id="form-cheque">
								<p class="bloco-campo-float"><label>Banco:</label>
									<select class="campo" id="bancoChequeAvista" name="banco" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> onChange="insereBanco(this.value);" style="width:222px;">
										<option value="">Selecione</option>
<?php
				$sqlBancoConta = "SELECT * FROM bancosConta WHERE statusBancoConta = 'T' ORDER BY nomeBancoConta ASC";
				$resultBancoConta = $conn->query($sqlBancoConta);
				while($dadosBancoConta = $resultBancoConta->fetch_assoc()){
?>
										<option value="<?php echo $dadosBancoConta['codigoBancoConta'];?>" <?php echo $dadosBancoConta['codBancoConta'] == $_SESSION['bancoCheque'] ? '/SELECTED/' : '';?> ><?php echo $dadosBancoConta['nomeBancoConta'];?></option>
<?php
				}
?>
									</select>
								</p>
								
								<script type="text/javascript">
									function insereBanco(value){
										document.getElementById("numeroBancoCheque").value=value;
									}
								</script>						
								
								<p class="bloco-campo-float"><label>Nº Banco:</label>
								<input class="campo" size="10" id="numeroBancoCheque" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> readonly type="text" name="numeroBancoCheque" value="<?php echo $_SESSION['numeroBancoCheque'];?>" onKeyDown="Mascara(this,Integer);" onKeyPress="Mascara(this,Integer);" onKeyUp="Mascara(this,Integer)"/></p>

								<p class="bloco-campo-float"><label>Nome:</label>
								<input class="campo" size="37" id="nomeCheque" type="text" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="nomeCheque" value="<?php echo $_SESSION['nomeCheque'];?>" /></p>
								
								<br class="clear"/>

								<p class="bloco-campo-float"><label>Agência:</label>
								<input class="campo" type="text" id="agenciaCheque" size="14" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="agenciaCheque" value="<?php echo $_SESSION['agenciaCheque'];?>" /></p>

								<p class="bloco-campo-float"><label>Conta:</label>
								<input class="campo" type="text" id="contaCheque" size="22" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="contaCheque" value="<?php echo $_SESSION['contaCheque'];?>" /></p>

								<p class="bloco-campo-float"><label>Número:</label>
								<input class="campo" type="text" id="numeroCheque" size="17" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="numeroCheque" value="<?php echo $_SESSION['numeroCheque'];?>" /></p>

								<p class="bloco-campo-float"><label>Bom para:</label>
								<input class="campo" type="text" id="paraCheque" size="11" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="paraCheque" value="<?php echo $_SESSION['paraCheque'];?>" onKeyDown="Mascara(this,Data);" onKeyPress="Mascara(this,Data);" onKeyUp="Mascara(this,Data)"/></p>

								<br class="clear" />
							</div>					 

							<p class="bloco-campo-float"><label>Cliente:</label>
							<input class="campo" size="44" type="text" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> name="cliente" value="<?php echo $_SESSION['cliente'];?>" /></p>

							<p class="bloco-campo-float"><label>Conta: <span class="obrigatorio"> </span></label>
								<select class="campo" id="tipo" name="tipo" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> style="width:150px; ">
									<option value="">Selecione</option>
<?php
				$sqlBanco = "SELECT * FROM bancos WHERE statusBanco = 'T' ORDER BY nomeBanco ASC";
				$resultBanco = $conn->query($sqlBanco);
				while($dadosBanco = $resultBanco->fetch_assoc()){
?>
									<option value="<?php echo $dadosBanco['codBanco'] ;?>" <?php echo $dadosInformacoes['contaPagamentoConta'] == $dadosBanco['codBanco'] ? '/SELECTED/' : '';?>><?php echo $dadosBanco['nomeBanco'];?></option>
<?php	
}
?>					
								</select>
								<br class="clear"/>
							</p>

							<p class="bloco-campo-float"><label>Valor Total:</label>
							<input style="width:120px;" class="campo" type="text" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> id="valor2" name="valor2" value="<?php echo number_format($dadosInformacoes['valorContaParcial'], 2, ",", "."); ?>" onKeyDown="Mascara(this,Valor);" onKeyPress="Mascara(this,Valor);" onKeyUp="Mascara(this,Valor);"/></p>
							
							<br class="clear"/>
							
							<p class="bloco-campo"><label>Observação:<span class="obrigatorio"> </span></label>
							<textarea class="campo desabilita" id="descricao" name="descricao" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?> type="text" style="width:645px; height:100px;" ><?php echo $dadosInformacoes['descricaoCheque']; ?></textarea></p>

	
							<div class="botao-expansivel" style="margin-top:27px;"><p class="esquerda-botao"></p><input class="botao" type="submit" id="alterar" name="enviar" <?php echo $erroAtiva == "ok" ? "" : "disabled='disabled'";?>  title="Alterar Cheque" value="Alterar"/><p class="direita-botao"></p></div>						
	
						</form>
					<br/>
				</div>
<?php
				if($_SESSION['erro'] == "ok"){
					$_SESSION['nome'] = "";
					$_SESSION['nome-colaboradores-filtro'] = "";
					$_SESSION['codNomeAnexo'] = "";
					$_SESSION['nomeAnexo'] = "";
					$_SESSION['tipoProcesso'] = "";
					$_SESSION['bnome-clientes-filtro'] = "";
					$_SESSION['parteAdversa-filtro-processo'] = "";
					$_SESSION['dataProtocolo'] = "";
					$_SESSION['dataCadastro'] = "";
					$_SESSION['cidade'] = "";
					$_SESSION['estado'] = "";
					$_SESSION['valor'] = "";
					$_SESSION['valorEscritorio'] = "";
					$_SESSION['site'] = "";
					$_SESSION['numero'] = "";
					$_SESSION['probabilidade'] = "";
					$_SESSION['status'] = "";
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
