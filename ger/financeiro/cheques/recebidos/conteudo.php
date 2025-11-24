<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "cheques";
			if(validaAcesso($conn, $area) == "ok"){

				if(isset($_POST['nome-filtro-clientes'])){
					$_SESSION['dia-filtro-clientes'] = $_POST['dia-filtro-clientes'];
					$_SESSION['mes-filtro-clientes'] = $_POST['mes-filtro-clientes'];
					$_SESSION['ano-filtro-clientes'] = $_POST['ano-filtro-clientes'];
					$_SESSION['nome-filtro-clientes'] = $_POST['nome-filtro-clientes'];
					$_SESSION['situacao-clientes'] = $_POST['situacao-clientes'];
				}
	
				if($_SESSION['dia-filtro-clientes'] == ""){
					$_SESSION['dia-filtro-clientes'] = "";
				}

				if($_SESSION['mes-filtro-clientes'] == ""){
					$_SESSION['mes-filtro-clientes'] = date("m");
				}

				if($_SESSION['ano-filtro-clientes'] == ""){
					$_SESSION['ano-filtro-clientes'] = date("Y");
				}

				if($_SESSION['dia-filtro-clientes'] != "" && $_SESSION['dia-filtro-clientes'] != "T"){
					$filtraDia = " and date_format(C.bomparaCheque, '%d') = '".$_SESSION['dia-filtro-clientes']."'";
				}
				if($_SESSION['mes-filtro-clientes'] != "" && $_SESSION['mes-filtro-clientes'] != "T"){
					$filtraMes = " and date_format(C.bomparaCheque, '%m') = '".$_SESSION['mes-filtro-clientes']."'";
				}
				if($_SESSION['ano-filtro-clientes'] != "" && $_SESSION['ano-filtro-clientes'] != "T"){
					$filtraAno = " and date_format(C.bomparaCheque, '%Y') = '".$_SESSION['ano-filtro-clientes']."'";
				}

				if($_SESSION['nome-filtro-clientes'] != "" && $_SESSION['nome-filtro-clientes'] != "T"){
					$filtraCliente = " and CL.nomeCliente = '".$_SESSION['nome-filtro-clientes']."'";
				}
				
				if($_SESSION['situacao-clientes'] != ""){
					if($_SESSION['situacao-clientes'] == "pagos"){
						$condicao = "and C.statusCheque = 'F'";
					}else
					if($_SESSION['situacao-clientes'] == "aguardando"){
						$condicao = "and  C.statusCheque = 'T'";
					}else
					if($_SESSION['situacao-clientes'] == "T"){
						$condicao = "and C.statusCheque != ''";
					}else
					if($_SESSION['situacao-clientes'] == "vencidos"){
						$condicao = "and C.statusCheque = 'T' and C.paraCheque <= '".date("Y-m-d")."'";
					}
				}else{
					$condicao = "and C.statusCheque = 'T'";
					$_SESSION['situacao-clientes'] = "aguardando";
				}	

					if($_POST['conta'] != ""){
						$sqlUpdate = "UPDATE contasParcial SET contaPagamentoConta = '".$_POST['conta']."' WHERE codContaParcial = ".$_POST['cod']."";
						$resultUpdate = $conn->query($sqlUpdate);
					}			
?>
				<div id="filtro">									
					<div id="localizacao-filtro">
						<p class="nome-lista">Financeiro</p>
						<p class="flexa"></p>
						<p class="nome-lista">Cheques</p>
						<p class="flexa"></p>
						<p class="nome-lista">A receber</p>
						<br class="clear"/>
					</div>
					<br class="clear" />
				
					<div class="botao-novo-desativado" style="margin-top:0px; margin-bottom:10px; margin-left:25px;"><div class="esquerda-novo"></div><div class="conteudo-novo">Cheques a receber</div><div class="direita-novo"></div></div>
					<div class="botao-novo" style="margin-top:0px; margin-left:15px; margin-bottom:10px;"><a title="Cheques a pagar" href="<?php echo $configUrl;?>financeiro/cheques/pagos/"><div class="esquerda-novo"></div><div class="conteudo-novo">Cheques a pagar</div><div class="direita-novo"></div></a></div>
				
					<br class="clear" />					
					<div id="demoTarget">
						<div id="formulario-filtro">
							<form id="filtro-interno" name="filtro1" action="<?php echo $configUrl;?>financeiro/cheques/recebidos/" method="post" >
								<p><label class="label">Situação:</label>
									<select class="campo" name="situacao-clientes" style="width:120px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="vencidos" <?php echo $_SESSION['situacao-clientes'] == 'vencidos' ? '/SELECTED/' : '';?>>Vencidos</option>
										<option value="aguardando" <?php echo $_SESSION['situacao-clientes'] == 'aguardando' ? '/SELECTED/' : '';?>>A vencer</option>
										<option value="pagos" <?php echo $_SESSION['situacao-clientes'] == 'pagos' ? '/SELECTED/' : '';?>>Recebidos</option>
									</select>
								</p>
								
								<p><label class="label">Dia:</label>	
									<select class="campo" id="default-usage-select" name="dia-filtro-clientes" style="width:80px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="01" <?php echo $_SESSION['dia-filtro-clientes'] == '01' ? '/SELECTED/' : '';?>>01</option>
										<option value="02" <?php echo $_SESSION['dia-filtro-clientes'] == '02' ? '/SELECTED/' : '';?>>02</option>
										<option value="03" <?php echo $_SESSION['dia-filtro-clientes'] == '03' ? '/SELECTED/' : '';?>>03</option>
										<option value="04" <?php echo $_SESSION['dia-filtro-clientes'] == '04' ? '/SELECTED/' : '';?>>04</option>
										<option value="05" <?php echo $_SESSION['dia-filtro-clientes'] == '05' ? '/SELECTED/' : '';?>>05</option>
										<option value="06" <?php echo $_SESSION['dia-filtro-clientes'] == '06' ? '/SELECTED/' : '';?>>06</option>
										<option value="07" <?php echo $_SESSION['dia-filtro-clientes'] == '07' ? '/SELECTED/' : '';?>>07</option>
										<option value="08" <?php echo $_SESSION['dia-filtro-clientes'] == '08' ? '/SELECTED/' : '';?>>08</option>
										<option value="09" <?php echo $_SESSION['dia-filtro-clientes'] == '09' ? '/SELECTED/' : '';?>>09</option>
										<option value="10" <?php echo $_SESSION['dia-filtro-clientes'] == '10' ? '/SELECTED/' : '';?>>10</option>
										<option value="11" <?php echo $_SESSION['dia-filtro-clientes'] == '11' ? '/SELECTED/' : '';?>>11</option>
										<option value="12" <?php echo $_SESSION['dia-filtro-clientes'] == '12' ? '/SELECTED/' : '';?>>12</option>
										<option value="13" <?php echo $_SESSION['dia-filtro-clientes'] == '13' ? '/SELECTED/' : '';?>>13</option>
										<option value="14" <?php echo $_SESSION['dia-filtro-clientes'] == '14' ? '/SELECTED/' : '';?>>14</option>
										<option value="15" <?php echo $_SESSION['dia-filtro-clientes'] == '15' ? '/SELECTED/' : '';?>>15</option>
										<option value="16" <?php echo $_SESSION['dia-filtro-clientes'] == '16' ? '/SELECTED/' : '';?>>16</option>
										<option value="17" <?php echo $_SESSION['dia-filtro-clientes'] == '17' ? '/SELECTED/' : '';?>>17</option>
										<option value="18" <?php echo $_SESSION['dia-filtro-clientes'] == '18' ? '/SELECTED/' : '';?>>18</option>
										<option value="19" <?php echo $_SESSION['dia-filtro-clientes'] == '19' ? '/SELECTED/' : '';?>>19</option>
										<option value="20" <?php echo $_SESSION['dia-filtro-clientes'] == '20' ? '/SELECTED/' : '';?>>20</option>
										<option value="21" <?php echo $_SESSION['dia-filtro-clientes'] == '21' ? '/SELECTED/' : '';?>>21</option>
										<option value="22" <?php echo $_SESSION['dia-filtro-clientes'] == '22' ? '/SELECTED/' : '';?>>22</option>
										<option value="23" <?php echo $_SESSION['dia-filtro-clientes'] == '23' ? '/SELECTED/' : '';?>>23</option>
										<option value="24" <?php echo $_SESSION['dia-filtro-clientes'] == '24' ? '/SELECTED/' : '';?>>24</option>
										<option value="25" <?php echo $_SESSION['dia-filtro-clientes'] == '25' ? '/SELECTED/' : '';?>>25</option>
										<option value="26" <?php echo $_SESSION['dia-filtro-clientes'] == '26' ? '/SELECTED/' : '';?>>26</option>
										<option value="27" <?php echo $_SESSION['dia-filtro-clientes'] == '27' ? '/SELECTED/' : '';?>>27</option>
										<option value="28" <?php echo $_SESSION['dia-filtro-clientes'] == '28' ? '/SELECTED/' : '';?>>28</option>
										<option value="29" <?php echo $_SESSION['dia-filtro-clientes'] == '29' ? '/SELECTED/' : '';?>>29</option>
										<option value="30" <?php echo $_SESSION['dia-filtro-clientes'] == '30' ? '/SELECTED/' : '';?>>30</option>
										<option value="31" <?php echo $_SESSION['dia-filtro-clientes'] == '31' ? '/SELECTED/' : '';?>>31</option>
									</select>
								</p>
								<p><label class="label">Mês:</label>
									<select class="campo" id="default-usage-select2" name="mes-filtro-clientes" style="width:105px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="01" <?php echo $_SESSION['mes-filtro-clientes'] == '01' ? '/SELECTED/' : '';?>>Janeiro</option>
										<option value="02" <?php echo $_SESSION['mes-filtro-clientes'] == '02' ? '/SELECTED/' : '';?>>Fevereiro</option>
										<option value="03" <?php echo $_SESSION['mes-filtro-clientes'] == '03' ? '/SELECTED/' : '';?>>Março</option>
										<option value="04" <?php echo $_SESSION['mes-filtro-clientes'] == '04' ? '/SELECTED/' : '';?>>Abril</option>
										<option value="05" <?php echo $_SESSION['mes-filtro-clientes'] == '05' ? '/SELECTED/' : '';?>>Maio</option>
										<option value="06" <?php echo $_SESSION['mes-filtro-clientes'] == '06' ? '/SELECTED/' : '';?>>Junho</option>
										<option value="07" <?php echo $_SESSION['mes-filtro-clientes'] == '07' ? '/SELECTED/' : '';?>>Julho</option>
										<option value="08" <?php echo $_SESSION['mes-filtro-clientes'] == '08' ? '/SELECTED/' : '';?>>Agosto</option>
										<option value="09" <?php echo $_SESSION['mes-filtro-clientes'] == '09' ? '/SELECTED/' : '';?>>Setembro</option>
										<option value="10" <?php echo $_SESSION['mes-filtro-clientes'] == '10' ? '/SELECTED/' : '';?>>Outubro</option>
										<option value="11" <?php echo $_SESSION['mes-filtro-clientes'] == '11' ? '/SELECTED/' : '';?>>Novembro</option>
										<option value="12" <?php echo $_SESSION['mes-filtro-clientes'] == '12' ? '/SELECTED/' : '';?>>Dezembro</option>
									</select>
								</p>
								<p><label class="label">Ano:</label>
									<select class="campo" id="default-usage-select3" name="ano-filtro-clientes" style="width:80px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="2011" <?php echo $_SESSION['ano-filtro-clientes'] == '2011' ? '/SELECTED/' : '';?>>2011</option>
										<option value="2012" <?php echo $_SESSION['ano-filtro-clientes'] == '2012' ? '/SELECTED/' : '';?>>2012</option>
										<option value="2013" <?php echo $_SESSION['ano-filtro-clientes'] == '2013' ? '/SELECTED/' : '';?>>2013</option>
										<option value="2014" <?php echo $_SESSION['ano-filtro-clientes'] == '2014' ? '/SELECTED/' : '';?>>2014</option>
										<option value="2015" <?php echo $_SESSION['ano-filtro-clientes'] == '2015' ? '/SELECTED/' : '';?>>2015</option>
										<option value="2016" <?php echo $_SESSION['ano-filtro-clientes'] == '2016' ? '/SELECTED/' : '';?>>2016</option>
										<option value="2017" <?php echo $_SESSION['ano-filtro-clientes'] == '2017' ? '/SELECTED/' : '';?>>2017</option>
										<option value="2018" <?php echo $_SESSION['ano-filtro-clientes'] == '2018' ? '/SELECTED/' : '';?>>2018</option>
										<option value="2019" <?php echo $_SESSION['ano-filtro-clientes'] == '2019' ? '/SELECTED/' : '';?>>2019</option>
										<option value="2020" <?php echo $_SESSION['ano-filtro-clientes'] == '2020' ? '/SELECTED/' : '';?>>2020</option>
										<option value="2021" <?php echo $_SESSION['ano-filtro-clientes'] == '2021' ? '/SELECTED/' : '';?>>2021</option>
										<option value="2022" <?php echo $_SESSION['ano-filtro-clientes'] == '2022' ? '/SELECTED/' : '';?>>2022</option>
										<option value="2023" <?php echo $_SESSION['ano-filtro-clientes'] == '2023' ? '/SELECTED/' : '';?>>2023</option>
										<option value="2024" <?php echo $_SESSION['ano-filtro-clientes'] == '2024' ? '/SELECTED/' : '';?>>2024</option>
										<option value="2025" <?php echo $_SESSION['ano-filtro-clientes'] == '2025' ? '/SELECTED/' : '';?>>2025</option>
										<option value="2026" <?php echo $_SESSION['ano-filtro-clientes'] == '2026' ? '/SELECTED/' : '';?>>2026</option>
										<option value="2027" <?php echo $_SESSION['ano-filtro-clientes'] == '2027' ? '/SELECTED/' : '';?>>2027</option>
										<option value="2028" <?php echo $_SESSION['ano-filtro-clientes'] == '2028' ? '/SELECTED/' : '';?>>2028</option>
										<option value="2029" <?php echo $_SESSION['ano-filtro-clientes'] == '2029' ? '/SELECTED/' : '';?>>2029</option>
										<option value="2030" <?php echo $_SESSION['ano-filtro-clientes'] == '2030' ? '/SELECTED/' : '';?>>2030</option>
									</select>
								</p>
								
								<div id="auto_complete_softbest" style="width:235px; float:left; margin-bottom:15px;">
									<p class="bloco-campo" style="margin-bottom:0px;"><label>Filtrar Cliente: <span class="obrigatorio"> </span></label>
									<input class="campo" type="text" name="nome-filtro-clientes" required style="width:220px;" value="<?php echo $_SESSION['nome-filtro-clientes']; ?>" onClick="auto_complete(this.value, 'clientes', event);" onKeyUp="auto_complete(this.value, 'clientes', event);" onBlur="fechaAutoComplete('clientes');" onkeydown="if (getKey(event) == 13) return false;" autocomplete="off" id="busca_autocomplete_softbest_clientes" /></p>
									<br class="clear"/>
									
									<div id="exibe_busca_autocomplete_softbest_clientes" class="auto_complete_softbest" style="width:234px; display:none;">

									</div>
								</div>									
								
								<p class="botao-filtrar" style="margin-top:18px;"><input type="button" name="filtrar" value="Filtrar" onClick="enviar()" /></p>
								<br class="clear" />
							</form>
						</div>
					</div>
					<script>
						function enviar(){
							if (document.getElementById("default-usage-select").value != 'T' & document.getElementById("default-usage-select2").value == 'T' & document.getElementById("default-usage-select3").value != 'T'){
								alert ("Por favor digite o Mês.");
							}else{		
								document.filtro1.submit(); 	
							}
						}
					 </script>
				</div>
				<div id="dados-conteudo">
<?php
				if($msgConta != ""){
					echo $msgConta;
				}

				$sqlConta = "SELECT count(C.codCheque) registros FROM cheques C inner join contasParcial CP on C.codContaParcial = CP.codContaParcial inner join contas CA on CP.codConta = CA.codConta inner join clientes CL on CA.codCliente = CL.codCliente WHERE C.areaCheque = 'R' ".$condicao.$filtraDia.$filtraMes.$filtraAno.$filtraCliente."";
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($registros >= 1){	
?>		
					<table style="width:100%;">
						<tr class="titulo-tabela">
							<th class="canto-esq">Cliente</th>
							<th>Conta Pagamento</th>
							<th>Número</th>
							<th>Vencimento</th>
							<th>Pagamento</th>
							<th>Valor</th>
							<th class="canto-dir">Baixa</th>
						</tr>
<?php
				}
				
				if($url[6] == 1 || $url[6] == ""){
					$pagina = 1;
					$sqlCheque1 = "SELECT C.*, CP.*, CA.*, CL.nomeCliente FROM cheques C inner join contasParcial CP on C.codContaParcial = CP.codContaParcial inner join contas CA on CP.codConta = CA.codConta inner join clientes CL on CA.codCliente = CL.codCliente WHERE C.areaCheque = 'R' ".$condicao.$filtraDia.$filtraMes.$filtraAno.$filtraCliente." ORDER BY C.statusCheque ASC, C.bomparaCheque ASC LIMIT 0,30";
				}else{
					$pagina = $url[6];
					$paginaFinal = $pagina * 30;
					$paginaInicial = $paginaFinal - 30;
					$sqlCheque1 = "SELECT C.*, CP.*, CA.*, CL.nomeCliente FROM cheques C inner join contasParcial CP on C.codContaParcial = CP.codContaParcial inner join contas CA on CP.codConta = CA.codConta inner join clientes CL on CA.codCliente = CL.codCliente WHERE C.areaCheque = 'R' ".$condicao.$filtraDia.$filtraMes.$filtraAno.$filtraCliente." ORDER BY C.statusCheque ASC, C.bomparaCheque ASC LIMIT ".$paginaInicial.",30";
				}
				
				$resultCheque1 = $conn->query($sqlCheque1);
				$cont = 1;
				while($dadosCheque1 = $resultCheque1->fetch_assoc()){
					$mostrando = $mostrando + 1;
					
					if($dadosCheque1['statusCheque'] == "F"){
						$totalChequesPagos = $totalChequesPagos + $dadosCheque1['valorContaParcial'];
					}
					
					if($dadosCheque1['statusCheque'] == "T"){
						$totalChequesReceber = $totalChequesReceber + $dadosCheque1['valorContaParcial'];
					}
					
					$totalCheques = $totalCheques + $dadosCheque1['valorContaParcial'];
					
					$sqlBancoConta = "SELECT nomeBancoConta FROM bancosConta WHERE codBancoConta = ".$dadosCheque1['codBancoConta']." LIMIT 0,1";
					$resultBancoConta = $conn->query($sqlBancoConta);
					$dadosBancoConta = $resultBancoConta->fetch_assoc();

					if($dadosCheque1['statusCheque'] == "F"){
						$corCheque = "";
					}else
					if($dadosCheque1['statusCheque'] == "T" && $dadosCheque1['paraCheque'] <= date("Y-m-d")){
						$corCheque = "class='cheque-vermelho'";
					}else{
						$corCheque = "class='cheque-preto'";
					}	
?>
						<tr class="tr">
							<td class="td-vinte" style="width:25%;"><a <?php echo $corCheque;?> href="<?php echo $configUrl;?>financeiro/cheques/recebidos/detalhes/<?php echo $dadosCheque1['codCheque'];?>/" title="Ver os detalhes do cheque"><?php echo $dadosCheque1['nomeCliente'];?></a></td>
							<td class="td-dez">

								<form style="display:table; margin:0 auto;" id="formConta<?php echo $cont;?>" action="<?php echo $configUrl;?>financeiro/cheques/recebidos/" method="post">
									<input type="hidden" name="codMovimento" value="<?php echo $dadosCheque1['codMovimento'];?>" />
									<select class="campo" name="contaFinanceiro" onChange="executaForm(<?php echo $dadosCheque1['codContaParcial'];?>);"  id="conta<?php echo $dadosCheque1['codContaParcial'];?>"style="padding:5px; width:200px;">
<?php
					$sqlBanco = "SELECT codBanco, nomeBanco FROM bancos ORDER BY nomeBanco ASC";
					$resultBanco = $conn->query($sqlBanco);
					while($dadosBanco = $resultBanco->fetch_assoc()){
?>
										<option value="<?php echo $dadosBanco['codBanco'];?>"  <?php echo $dadosBanco['codBanco'] == $dadosCheque1['contaPagamentoConta'] ? '/SELECTED/' : '';?> ><?php echo $dadosBanco['nomeBanco'];?></option>
<?php
					}
?>
									</select>
										
								</form>
							</td>
							<td><a <?php echo $corCheque;?> href="<?php echo $configUrl;?>financeiro/cheques/recebidos/detalhes/<?php echo $dadosCheque1['codCheque'];?>/" title="Ver os detalhes do cheque"><?php echo $dadosCheque1['numeroCheque'];?></a></td>
							<td><a <?php echo $corCheque;?> href="<?php echo $configUrl;?>financeiro/cheques/recebidos/detalhes/<?php echo $dadosCheque1['codCheque'];?>/" title="Ver os detalhes do cheque"><?php echo data($dadosCheque1['bomparaCheque']);?></a></td>
<?php
					if($dadosCheque1['statusCheque'] == "F"){
?>								
							<td class="vinte" style="text-align:center;"><a <?php echo $corCheque;?> href="<?php echo $configUrl;?>financeiro/cheques/recebidos/detalhes/<?php echo $dadosCheque1['codCheque'];?>/" title="Ver os detalhes do cheque"><?php echo data($dadosCheque1['dataDescontoCheque']);?></a></td>
<?php
					}else{
?>
							<td class="vinte" style="text-align:center;"><a <?php echo $corCheque;?> href="<?php echo $configUrl;?>financeiro/cheques/recebidos/detalhes/<?php echo $dadosCheque1['codCheque'];?>/" title="Ver os detalhes do cheque">Aguardando</a></td>
<?php
					}
?>								
							<td class="vinte" style="width:15%; text-align:center;"><a <?php echo $corCheque;?> href="<?php echo $configUrl;?>financeiro/cheques/recebidos/detalhes/<?php echo $dadosCheque1['codCheque'];?>/" title="Ver os detalhes do cheque">R$: <?php echo number_format($dadosCheque1['valorContaParcial'], 2, ",", ".");?></a></td>
<?php
					if($dadosCheque1['statusCheque'] == "T"){
?>						
							<td class="botao"><a <?php echo $corCheque;?> href="<?php echo $configUrl.'financeiro/cheques/recebidos/baixa/'.$dadosCheque1['codCheque'].'/';?>" title="Dar Baixa"><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icone-dinheiro-confirmado.gif" alt="pagar" /></a></td>
<?php
					}else{
?>							
							<td class="botao"><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icone-dinheiro-confirmado-inativo.gif" alt="pagar" /></td>
<?php
					}			
?>				
						</tr>
						<form id="form" action="<?php echo $configUrl;?>financeiro/cheques/recebidos/" method="post">	
							<input type="hidden" value="" id="manda-cod" name="cod"/>
							<input type="hidden" value="" id="manda-conta" name="conta"/>
						</form>		
						<script>		 
							function executaForm(cod){
								document.getElementById("manda-cod").value=cod;
								var pegaValue = document.getElementById("conta"+cod).value;
								document.getElementById("manda-conta").value=pegaValue;
								document.getElementById("form").submit();
							}						
						</script>							
<?php
					$cont++;
				}
	
				if($totalChequesReceber == ""){
					$totalChequesReceber = "0";
				}
				if($totalChequesPagos == ""){
					$totalChequesPagos = "0";
				}
?>
					</table>
<?php
				if($registros >= 1){	
?>
					<div id="coluna-baixo">
						<div id="cancelar-confirmar">

						</div>
						<div id="total-compra">
							<p class="total-titulo">Total cheques a receber:</p>
							<p class="total">R$ <?php echo number_format($totalChequesReceber, 2, ",", ".");?></p>
						</div>	
						<br class="clear" />
						<div id="total-compra">
							<p class="total-titulo">Total cheques recebidos:</p>
							<p class="total">R$ <?php echo number_format($totalChequesPagos, 2, ",", ".");?></p>
						</div>	
						<br class="clear" />
						<div id="total-compra">
							<p class="total-titulo">Total cheques:</p>
							<p class="total">R$ <?php echo number_format($totalCheques, 2, ",", ".");?></p>
						</div>	
						<br class="clear" />
					</div>
<?php
				}
			
				$regPorPagina = 30;
				$area = "financeiro/cheques/recebidos";
				include ('f/conf/paginacao.php');
?>
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
