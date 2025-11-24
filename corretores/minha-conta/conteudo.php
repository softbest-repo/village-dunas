<?php
	if($_COOKIE['codAprovado'.$cookie] != ""){

		$sqlCorretor = "SELECT * FROM corretores WHERE codCorretor = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY codCorretor ASC LIMIT 0,1";
		$resultCorretor = $conn->query($sqlCorretor);
		$dadosCorretor = $resultCorretor->fetch_assoc();		
?>
							<div id="conteudo-interno">
								<div id="bloco-titulo">
									<p class="titulo">Minha Conta</p>
								</div>
								<div id="erro" style="<?php echo $backgroundColor;?> <?php echo $erro == "" ? 'display:none;' : 'display:table;';?>"><?php echo $erro;?></div>
								<div id="conteudo-conta">
									<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>									
									<div id="mostra-conta">
<?php
		if($url[3] == "" || $url[3] == "minhas-reservas"){
?>										
										<div id="minhas-reservas">
											<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
											
<?php
			$sqlReservas = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join cidades C on LO.codCidade = C.codCidade inner join lotesReservas R on L.codLote = R.codLote WHERE L.statusLote = 'T' and R.codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and R.dataOutLoteReserva IS NULL GROUP BY L.codLote ORDER BY R.dataInLoteReserva DESC, R.dataOutLoteReserva ASC LIMIT 0,1";
			$resultReservas = $conn->query($sqlReservas);
			$dadosReservas = $resultReservas->fetch_assoc();
			
			if($dadosReservas['codLote'] != ""){
?>
											<table id="tabela-lotes">
												<tr class="tr-titulo">
													<th>Loteamento</th>
													<th>Quadra</th>
													<th>Lote(s)</th>
													<th>Área m²</th>
													<th>Posição Solar</th>
													<th>Valor</th>
													<th>Tempo Restante</th>
												</tr>
<?php
				$cont = 0;
				$contCor = 0;
				$sqlReservas = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join cidades C on LO.codCidade = C.codCidade inner join lotesReservas R on L.codLote = R.codLote WHERE L.statusLote = 'T' and R.codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and R.dataOutLoteReserva IS NULL GROUP BY L.codLote ORDER BY R.dataInLoteReserva DESC, R.dataOutLoteReserva ASC";
				$resultReservas = $conn->query($sqlReservas);
				while($dadosReservas = $resultReservas->fetch_assoc()){
					
					$cont++;

					$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosReservas['codLote']." or codUnido = ".$dadosReservas['codLote']." ORDER BY codLote ASC LIMIT 0,1";
					$resultUniao = $conn->query($sqlUniao);
					$dadosUniao = $resultUniao->fetch_assoc();
					
					if($dadosUniao['codLote'] != ""){
						$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosUniao['codLote']." ORDER BY codLote ASC";
						$resultUniao = $conn->query($sqlUniao);
						while($dadosUniao = $resultUniao->fetch_assoc()){
							$sqlContrato = "SELECT * FROM contratos WHERE (codLote = ".$dadosUniao['codUnido']." or codLote = ".$dadosUniao['codLote'].") and tipoContrato = 'AA' ORDER BY codContrato DESC LIMIT 0,1";
							$resultContrato = $conn->query($sqlContrato);
							$dadosContrato = $resultContrato->fetch_assoc();
							
							if($dadosContrato['codContrato'] != ""){
								$diasReservaSql = 6;
								break;
							}else{
								$diasReservaSql = $diasReserva;
							}
						}
					
						$frase = "Unido";
					}else{

						$sqlContrato = "SELECT * FROM contratos WHERE codLote = ".$dadosReservas['codLote']." and tipoContrato = 'AA' ORDER BY codContrato DESC LIMIT 0,1";
						$resultContrato = $conn->query($sqlContrato);
						$dadosContrato = $resultContrato->fetch_assoc();

						if($dadosContrato['codContrato'] != ""){
							$diasReservaSql = 6;
						}else{
							$diasReservaSql = $diasReserva;
						}
												
						$frase = "";
					}
								
					if($cont == 2){
						$cont = 0;
						$backgroundColor = "background-color:#f5f5f5;";
					}else{
						$backgroundColor = "background-color:#e2e2e2;";
					}
					
					$data_inicio = new DateTime($dadosReservas['dataInLoteReserva']);
					$data_fim = clone $data_inicio;
					$data_fim->modify('+'.$diasReservaSql.' days');
					$data_atual = new DateTime();
					$dateInterval = $data_atual->diff($data_fim);
					$dateInterval = $dateInterval->days + 1;

					if($dadosReservas['statusLoteReserva'] == "C"){
						$acaba = "Congelado";
					}else															
					if($dateInterval == 1){
						$acaba = "1 dia";
					}else
					if($dateInterval == 2){
						$acaba = "2 dias";
					}else{
						$acaba = $dateInterval." dias";
					}

					if($dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
						$acoes = "Reserva <span style='font-weight:normal; font-size:13px;'>(".$acaba.")</span>";
					}else{								
						$acoes = "Reservado <span style='font-weight:normal; font-size:13px;'>(".$acaba.")</span>";
					}		

					$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosReservas['codLote']." or codUnido = ".$dadosReservas['codLote']." ORDER BY codLote ASC LIMIT 0,1";
					$resultUniao = $conn->query($sqlUniao);
					$dadosUniao = $resultUniao->fetch_assoc();
					
					if($dadosUniao['codLote'] != ""){
						$frase = "Unido";
					}else{
						
						$frase = "";
					}
					if($contCor == 0){
						$backgroundColor = "background-color:#e2e2e2;";
						$contCor++;
					}else{
						$backgroundColor = "background-color:#e0fff8;";
						$contCor = 0;
					}
					
					
					
?>												
												<tr class="tr-lista" style="<?php echo $backgroundColor;?>">
													<td style="text-align:left;"><?php echo $dadosReservas['nomeLoteamento'];?> - <?php echo $dadosReservas['nomeCidade'];?> / <?php echo $dadosReservas['estadoCidade'];?></td>
													<td><?php echo $dadosReservas['nomeQuadra'];?></td>
													<td><?php echo $dadosReservas['nomeLote'];?><span style="display:block; font-size:12px; color:#002c23; text-decoration:underline;"><?php echo $frase;?></span></td>
													<td><?php echo $dadosReservas['frenteLote'];?> <?php echo $dadosReservas['frenteLote'] != "" ? 'x' : '';?> <?php echo $dadosReservas['fundosLote'];?> <?php echo $dadosReservas['frenteLote'] != "" ? '=' : '';?> <?php echo $dadosReservas['areaLote'];?>m²</td>
													<td><?php echo $dadosReservas['posicaoLote'];?></td>
													<td>R$ <?php echo number_format($dadosReservas['precoLote'], 2, ",", ".");?></td>
													<td class="restante" onClick="perguntaNotifica(<?php echo $dadosReservas['codLote'];?>, 'R', <?php echo $dadosReservas['codCorretor'];?>);"><?php echo $acaba;?></td>
												</tr>
<?php
				}
?>
											</table>
<?php
			}else{
?>
											<p class="msg">Nenhuma reserva encontrada!</p>
<?php				
			}
?>
											<p class="fundo-acoes" style="display:none;" onClick="fechaPopup();"></p>
											<div id="popup-acoes" style="display:none;">
											</div>
											<script>
												function perguntaNotifica(codLote, status, corretor) {
													if(status == "V"){
														Swal.fire('Aviso', 'Este lote já foi vendido!', 'warning');
													}else{
													  var corretorLogado = <?php echo $_COOKIE['codAprovado'.$cookie];?>;
													  buscaLoteData(codLote).then((data) => {
														if (data) {
														  Swal.fire({
															title: '<span style="color:#002c23; font-size:21px;">Informações do Lote</span>',
															html: `
															<div class="swal-custom-popup">
															  <div style="display: flex; justify-content: space-between;">
																<div style="width: 48%; border-right: 1px solid #ccc; text-align:left; padding-right: 20px;">
																  <p style="border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;">
																	<strong style="font-size:17px; color:#002c23; font-weight:600;">Lote:</strong> ${data.nomeLote} 
																  </p>
																  <p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;"><strong style="font-size:16px; color:#002c23; font-weight:600;">Quadra: </strong>${data.nomeQuadra}</p>
																  <p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;"><strong style="font-size:16px; color:#002c23; font-weight:600;">Bairro: </strong>${data.bairro}</p>
																  <p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;"><strong style="font-size:16px; color:#002c23; font-weight:600;">Posição Solar:</strong> ${data.posicaoSolar}</p>
																  <p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;"><strong style="font-size:16px; color:#002c23; font-weight:600;">Área m²: </strong>${data.frenteFundo}</p>
																  ${data.obs ? `<p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;"><strong style="font-size:16px; color:#002c23; font-weight:600;">Observação: </strong>${data.obs}</p>` : ''}
																</div>
																<div style="width: 48%; padding-left: 20px; text-align:left;">
																  ${data.desconto > 0 ? `<p style="border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;">
																	<strong style="font-size:17px; color:#002c23; font-weight:600;">Valor total:</strong> ${data.valor}
																  </p>
																  <p style="padding-bottom:5px; margin-bottom:5px;">
																	<strong style="font-size:16px; color:#002c23; font-weight:600;">Valor a vista:</strong> ${data.valorVista} (- ${data.desconto}%)
																  </p>` : ''}
																  ${data.desconto == 0 ? `<p style="border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;">
																	<strong style="font-size:16px; color:#002c23; font-weight:600;">Valor a vista:</strong> ${data.valor}
																  </p>` : ''}
																  ${data.entrada ? `<p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;">
																	<strong style="font-size:16px; color:#002c23; font-weight:600;">Entrada:</strong> R$ ${data.entrada}
																  </p>` : ''}
																  
																  ${parseFloat(data.taxa.trim()) > 0 ? `<p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;">
																	<strong style="font-size:16px; color:#002c23; font-weight:600;">Taxa:</strong> ${data.taxa}%
																  </p>` : ''}
																  
																  ${data.parcelas ? `<p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;">
																	<strong style="font-size:16px; color:#002c23; font-weight:600;">Parcelas:</strong> ${data.parcelas}
																  </p>` : ''}
																  
																  ${data.valor_parcela ? `<p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;">
																	<strong style="font-size:16px; color:#002c23; font-weight:600;">Valor da Parcela:</strong> ${data.valor_parcela}
																  </p>` : ''}
																
																	${data.reforcos ? `<p style="margin:0; padding:0; font-size:16px; padding-bottom:10px;">
																	<strong style="font-size:16px; color:#002c23; font-weight:600;">Reforços Anuais:</strong> ${data.reforcos}
																	</p>` : ''}																  
																</div>					
															  </div>
															  <br/>
															  <p>
																${data.unido == 'T' ? `<strong style="color:#FF0000;">Este lote possui união com um ou mais lotes!</strong><br/><br/>` : ''}
																${data.taxa ? `Faça uma nova simulação abaixo:<br/>
																<a target='_blank' style='color:#002c23; text-decoration:underline; display:block;' href='https://www.idinheiro.com.br/calculadoras/calculadora-financiamento-price/'>
																  Acessar Calculadora
																</a>` : ''}
																 ${status === "R" && corretor === corretorLogado || status === "D" ? `
																<br/>
																A conta para o sinal de arras você poderá visualizar<br/>clicando no botão <strong>Realizar Contrato</strong>!` : ''}
															  </p>
															</div>`,
															iconHtml: '<i class="fas fa-draw-polygon" style="font-size: 50px; color:green;"></i>',
															showCloseButton: true,
															showCancelButton: true,
															confirmButtonText: 'Fechar',
															cancelButtonText: (status === "R" && corretor === corretorLogado) ? 'Cancelar Reserva' : (status === "D" ? 'Fazer Reserva' : 'Reservado'),
															buttonsStyling: false,
															customClass: {
															  popup: 'swal-custom-popup',
															  confirmButton: 'btn-confirmar',
															  cancelButton: 'btn-reservar',
															},
															width: '680px',
															padding: '20px',
															didOpen: () => {
															  const cancelButton = Swal.getCancelButton();

															  // Se o status for 'R' e o corretor for o mesmo do cookie, muda o estilo do botão
															  if (status === "R" && corretor === corretorLogado) {
																cancelButton.style.backgroundColor = '#FFD700';
																cancelButton.style.color = '#000';
																cancelButton.style.cursor = 'pointer';
																cancelButton.disabled = false;

																// Adiciona a função 'cancelarReserva' ao botão de cancelar reserva
																cancelButton.addEventListener('click', () => cancelarReserva(codLote));
															  } else if (status === "R") {
																cancelButton.style.backgroundColor = '#FFD700';
																cancelButton.style.color = '#000';
																cancelButton.style.cursor = 'not-allowed';
																cancelButton.disabled = true;
															  }

															  // Oculta o botão "Fazer Contrato" se o status for 'R'
															  if (status !== "R" || (status === "R" && corretor === corretorLogado)) {
																Swal.getCancelButton().insertAdjacentHTML('afterend', `
																  <button id="fazer-contrato" class="btn-reservar swal2-styled" style="margin-left: 10px;">Realizar Contrato</button>
																`);

																document.getElementById('fazer-contrato').addEventListener('click', () => {
																  fazerContrato(codLote);
																});
															  }
															}
														  }).then((result) => {
															if (result.isConfirmed) {
															  // Ação para o botão "Fechar"
															} else if (result.dismiss === Swal.DismissReason.cancel && status !== "R") {
															  reservarLote(codLote); // Chama a função de reserva, exceto se o status for 'R'
															}
														  });
														}
													  });
													}
												}		

												function reservarLote(codLote) {
													var $tgs = jQuery.noConflict();

													Swal.fire({
														title: 'Reservando Lote...',
														text: 'Por favor, aguarde...',
														allowOutsideClick: false,
														didOpen: () => {
															Swal.showLoading();
														}
													});

													$tgs.post("<?php echo $configUrl;?>loteamentos/cadastra-reserva.php", { codLote: codLote }, function (data) {
														if (data.trim() == "ok") {
															Swal.fire({
																icon: 'success',
																title: 'Reserva realizada com sucesso!',
																showConfirmButton: false,
																timer: 3000
															});

															setTimeout("carregaPagina()", 3000);
														} else {
															if(data.trim() == "erro login"){
																Swal.fire({
																	icon: 'error',
																	title: 'Erro',
																	text: 'Você não está logado, clique em OK e faça o seu login!',
																	confirmButtonText: 'OK'
																}).then((result) => {
																	if (result.isConfirmed) {
																		window.location.href = '<?php echo $configUrl;?>login'; // Insira o link desejado aqui
																	}
																});					
															}else{

																Swal.fire({
																	icon: 'error',
																	title: 'Erro',
																	text: 'Não foi possível realizar a reserva.'
																});
															}
														}
													});
												}

												function carregaPagina(){
													location.href="<?php echo $configUrl.'minha-conta/'.$url[3].'/';?>";
												}
																							
												function fazerContrato(codLote) {
													document.getElementById("loteContrato").value=codLote;
													document.getElementById("formContrato").submit();
												}

												function cancelarReserva(codLote){
													var $tgsh = jQuery.noConflict();

													Swal.fire({
														title: 'Cancelando Reserva...',
														text: 'Por favor, aguarde...',
														allowOutsideClick: false,
														didOpen: () => {
															Swal.showLoading();
														}
													});		
														
													$tgsh.post("<?php echo $configUrl;?>loteamentos/cancela-reserva.php", {codLote: codLote}, function(data){
														if(data.trim() == "ok"){
															Swal.fire({
																icon: 'success',
																title: 'Reserva cancelada com sucesso!',
																showConfirmButton: false,
																timer: 3000
															});					
															setTimeout("carregaPagina()", 3000);
														}else{
															Swal.fire({
																icon: 'error',
																title: 'Erro',
																text: 'Não foi possível cancelar a reserva.'
															});
														}
													});															
												}		

												// Estilo CSS para os botões
												const style = document.createElement('style');
												style.textContent = `
												  .btn-confirmar {
													background-color: #FF0000; /* Cor de fundo do botão "Fechar" */
													color: white; /* Cor do texto */
													border: none; /* Sem borda */
													border-radius: 5px; /* Bordas arredondadas */
													padding: 10px 20px; /* Padding */
													margin:10px;
													cursor: pointer; /* Cursor em forma de mão */
													font-size: 16px; /* Tamanho da fonte */
												  }

												  .btn-confirmar:hover {
													background-color: #fd4545; /* Cor de fundo ao passar o mouse */
												  }

												  .btn-reservar {
													background-color: #421717; /* Cor de fundo */
													color: white; /* Cor do texto */
													border: none; /* Sem borda */
													border-radius: 5px; /* Bordas arredondadas */
													padding: 10px 20px; /* Padding */
													margin:10px;
													cursor: pointer; /* Cursor em forma de mão */
													font-size: 16px; /* Tamanho da fonte */
												  }

												  .btn-reservar:hover {
													background-color: #462222; /* Cor de fundo ao passar o mouse */
												  }

												  .swal2-cancel {
													background-color: #91b16c; /* Cor de fundo do botão "Fazer Contrato" */
													color: white; /* Cor do texto */
													border: none; /* Sem borda */
													border-radius: 5px; /* Bordas arredondadas */
													padding: 10px 20px; /* Padding */
													margin:10px;
													cursor: pointer; /* Cursor em forma de mão */
													font-size: 16px; /* Tamanho da fonte */
												  }

												  .swal2-cancel:hover {
													background-color: #acbd98; /* Cor de fundo ao passar o mouse */
												  }
												`;
												document.head.appendChild(style); 


												function buscaLoteData(codLote) {
												  return fetch('<?php echo $configUrl;?>loteamentos/busca-lote-mapa.php', {
													method: 'POST',
													headers: {
													  'Content-Type': 'application/x-www-form-urlencoded'
													},
													body: 'codLote=' + encodeURIComponent(codLote)
												  })
												  .then(response => response.json())
												  .then(data => {
													if (data.success) {
													  return data;
													} else {
													  Swal.fire('Erro', 'Não foi possível obter os dados do lote.', 'error');
													  return null;
													}
												  })
												  .catch(error => {
													console.error('Erro:', error);
													Swal.fire('Erro', 'Ocorreu um erro ao buscar os dados.', 'error');
												  });
												}			
											</script>
											<form id="formContrato" action="<?php echo $configUrl;?>minha-conta/negociacoes/" method="post">
												<input type="hidden" value="" name="loteContrato" id="loteContrato"/>
											</form>											
										</div>
<?php
		}else
		if($url[3] == "minhas-vendas"){
?>										
										<div id="minhas-reservas">
<?php
			$sqlReservas = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join cidades C on LO.codCidade = C.codCidade WHERE L.statusLote = 'T' and L.vendidoLote = 'T' and L.codCorretor = ".$_COOKIE['codAprovado'.$cookie]." GROUP BY L.codLote ORDER BY LO.nomeLoteamento ASC, Q.nomeQuadra ASC, L.nomeLote ASC, L.codLote DESC LIMIT 0,1";
			$resultReservas = $conn->query($sqlReservas);
			$dadosReservas = $resultReservas->fetch_assoc();
			
			if($dadosReservas['codLote'] != ""){
?>
											<table id="tabela-lotes">
												<tr class="tr-titulo">
													<th>Loteamento</th>
													<th>Quadra</th>
													<th>Lote(s)</th>
													<th>Área m²</th>
													<th>Posição Solar</th>
													<th>Valor</th>
													<th>Status</th>
												</tr>
<?php
				$cont = 0;
				$contCor = 0;;
				$sqlReservas = "SELECT * FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join cidades C on LO.codCidade = C.codCidade WHERE L.statusLote = 'T' and L.vendidoLote = 'T' and L.codCorretor = ".$_COOKIE['codAprovado'.$cookie]." GROUP BY L.codLote ORDER BY LO.nomeLoteamento ASC, Q.nomeQuadra ASC, L.nomeLote ASC, L.codLote DESC";
				$resultReservas = $conn->query($sqlReservas);
				while($dadosReservas = $resultReservas->fetch_assoc()){
					$cont++;
					
					if($cont == 2){
						$cont = 0;
						$backgroundColor = "background-color:#f5f5f5;";
					}else{
						$backgroundColor = "background-color:#e6e6e6;";
					}						

					$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosReservas['codLote']." or codUnido = ".$dadosReservas['codLote']." ORDER BY codLote ASC LIMIT 0,1";
					$resultUniao = $conn->query($sqlUniao);
					$dadosUniao = $resultUniao->fetch_assoc();
					
					if($dadosUniao['codLote'] != ""){
						$frase = "Unido";
					}else{
						$frase = "";
					}
					if($contCor == 0){
						$backgroundColor = "background-color:#e2e2e2;";
						$contCor++;
					}else{
						$backgroundColor = "background-color:#e0fff8;";
						$contCor = 0;
					}				
?>												
												<tr class="tr-lista" style="<?php echo $backgroundColor;?>">
													<td style="text-align:left;"><?php echo $dadosReservas['nomeLoteamento'];?> - <?php echo $dadosReservas['nomeCidade'];?> / <?php echo $dadosReservas['estadoCidade'];?></td>
													<td><?php echo $dadosReservas['nomeQuadra'];?></td>
													<td><?php echo $dadosReservas['nomeLote'];?><span style="display:block; font-size:12px; color:#002c23; text-decoration:underline;"><?php echo $frase;?></span></td>
													<td><?php echo $dadosReservas['frenteLote'];?> <?php echo $dadosReservas['frenteLote'] != "" ? 'x' : '';?> <?php echo $dadosReservas['fundosLote'];?> <?php echo $dadosReservas['frenteLote'] != "" ? '=' : '';?> <?php echo $dadosReservas['areaLote'];?>m²</td>
													<td><?php echo $dadosReservas['posicaoLote'];?></td>
													<td>R$ <?php echo number_format($dadosReservas['precoLote'], 2, ",", ".");?></td>
													<td class="vendido">Vendido</td>
												</tr>
<?php
				}
?>
											</table>
<?php
			}else{
?>
											<p class="msg">Nenhuma venda encontrada!</p>
<?php				
			}
?>
										</div>
<?php
		}else
		if($url[3] == "editar-dados"){
			
			if($_POST['nome'] != ""){
				
				$sqlUpdate = "UPDATE corretores SET nomeCorretor = '".$_POST['nome']."', codImobiliaria = '".$_POST['imobiliaria']."', celularCorretor = '".$_POST['celular']."', creciCorretor = '".$_POST['creci']."', cpfCorretor = '".$_POST['cpf']."', emailCorretor = '".$_POST['email']."', senhaCorretor = '".$_POST['senha']."' WHERE codCorretor = ".$_COOKIE['codAprovado'.$cookie]."";
				$resultUpdate = $conn->query($sqlUpdate);
				
				if($resultUpdate == 1){
					$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Alterou seus dados', '".date('Y-m-d H:i:s')."', 'T')";
					$resultHistorico = $conn->query($sqlHistorico);	

					$erro = "<p class='erro'>Corretor alterado com sucesso!</p>";
					$backgroundColor = "background-color:#00b816;";										
				}else{
					$erro = "<p class='erro'>Problemas ao alterar corretor!</p>";
					$backgroundColor = "background-color:#FF0000;";					
				}
			
			}
		
			$sqlCorretor = "SELECT * FROM corretores WHERE codCorretor = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY codCorretor ASC LIMIT 0,1";
			$resultCorretor = $conn->query($sqlCorretor);
			$dadosCorretor = $resultCorretor->fetch_assoc();
?>
										<div id="editar-dados">
											<div id="erro" style="<?php echo $backgroundColor;?> <?php echo $erro == "" ? 'display:none;' : 'display:table;';?>"><?php echo $erro;?></div>
											<form action="<?php echo $configUrl;?>minha-conta/editar-dados/" method="post">
												<p class="campo campo-nome"><label>Nome: </label><br/><input type="text" value="<?php echo $dadosCorretor['nomeCorretor'];?>" placeholder="Nome" name="nome" required /></p>
												<p class="campo campo-imobiliaria campo-select"><label>Imobiliária:</label><br/>
													<select class="select" style="width:353px; margin-right:0px; height:33px;" name="imobiliaria">
														<option value="">Todos</option>
<?php
						$sqlImobiliaria = "SELECT * FROM imobiliarias WHERE statusImobiliaria = 'T' ORDER BY nomeImobiliaria ASC";
						$resultImobiliaria = $conn->query($sqlImobiliaria);
						while($dadosImobiliaria = $resultImobiliaria->fetch_assoc()){										
?>
														<option value="<?php echo $dadosImobiliaria['codImobiliaria'];?>" <?php echo $dadosImobiliaria['codImobiliaria'] == $dadosCorretor['codImobiliaria'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosImobiliaria['nomeImobiliaria']);?></option>	
<?php
						}
?>												   </select>
												</p>	
												<br class="clear"/>
												<p class="campo campo-celular"><label>Celular: </label><br/><input type="text" value="<?php echo $dadosCorretor['celularCorretor'];?>" style="width:206px;" placeholder="Celular" name="celular" required onKeyDown="Mascara(this,novoTelefone);" onKeyPress="Mascara(this,novoTelefone);" onKeyUp="Mascara(this,novoTelefone);" /></p>
												<p class="campo campo-celular"><label>CPF: </label><br/><input type="text" value="<?php echo $dadosCorretor['cpfCorretor'];?>" style="width:206px;" placeholder="CPF" name="cpf" required onKeyDown="Mascara(this,Cpf);" onKeyPress="Mascara(this,Cpf);" onKeyUp="Mascara(this,Cpf);" /></p>
												<p class="campo campo-creci"><label>CRECI: </label><br/><input type="text" value="<?php echo $dadosCorretor['creciCorretor'];?>" style="width:206px;" placeholder="CRECI" name="creci" required /></p>
												<br class="clear"/>
												<p class="campo campo-email"><label>E-mail: </label><br/><input type="email" value="<?php echo $dadosCorretor['emailCorretor'];?>" placeholder="E-mail" name="email" required /></p>
												<p class="campo campo-senha"><label>Senha: </label><br/><input type="password" value="<?php echo $dadosCorretor['senhaCorretor'];?>" placeholder="Senha"  name="senha" required /></p>
												<br class="clear"/>
												<p class="botao-entrar"><input type="submit" value="Alterar" name="alterar"/></p>
											</form>										
										</div>
<?php			
		}else
		if($url[3] == "negociacoes"){
			
			if($url[4] == ""){
			
				if($_POST['loteamentoNegociao'] != ""){
					$sqlInsere = "INSERT INTO contratos VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", '".date('Y-m-d')."', ".$_POST['lote'].", 'RIC', '', '', NULL, '', '', '', '', '', '', '', NULL, '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', '', 'T')";
					$resultInsere = $conn->query($sqlInsere);
					
					if($resultInsere == 1){

						$sqlLote = "SELECT nomeLote, codLoteamento, nomeQuadra FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra WHERE codLote = ".$_POST['lote']." ORDER BY codLote DESC LIMIT 0,1";
						$resultLote = $conn->query($sqlLote);
						$dadosLote = $resultLote->fetch_assoc();
						
						$sqlLoteamento = "SELECT nomeLoteamento FROM loteamentos WHERE codLoteamento = ".$dadosLote['codLoteamento']." ORDER BY codLoteamento DESC LIMIT 0,1";
						$resultLoteamento = $conn->query($sqlLoteamento);
						$dadosLoteamento = $resultLoteamento->fetch_assoc();
		
						$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Negociação criada para o loteamento ".$dadosLoteamento['nomeLoteamento'].", quadra ".$dadosLote['nomeQuadra'].", lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
						$resultHistorico = $conn->query($sqlHistorico);	

						$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$_POST['lote']." or codUnido = ".$_POST['lote']." ORDER BY codLote ASC LIMIT 0,1";
						$resultUniao = $conn->query($sqlUniao);
						$dadosUniao = $resultUniao->fetch_assoc();
						
						if($dadosUniao['codLoteUnido'] != ""){
							$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosUniao['codLote']." ORDER BY codLote ASC";
							$resultUniao = $conn->query($sqlUniao);
							while($dadosUniao = $resultUniao->fetch_assoc()){
								
								$codLoteMaster = $dadosUniao['codLote'];

								$sqlReserva = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosUniao['codUnido']." and codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and dataOutLoteReserva IS NULL LIMIT 0,1";
								$resultReserva = $conn->query($sqlReserva);
								$dadosReserva = $resultReserva->fetch_assoc();

								if($dadosReserva['codLoteReserva'] == ""){
									$sqlInsere = "INSERT INTO lotesReservas VALUES(0, ".$dadosUniao['codUnido'].", ".$_COOKIE['codAprovado'.$cookie].", '".date('Y-m-d H:i:s')."', NULL, 'A')";
									$resultInsere = $conn->query($sqlInsere);							
									
									if($resultInsere == 1){
										$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', '".$_COOKIE['codAprovado'.$cookie]."', '".$dadosUniao['codUnido']."', 'RR', 'T', 2)";
										$resultInsere = $conn->query($sqlInsere);								

										$sqlLote = "SELECT nomeLote, codLoteamento, nomeQuadra FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra WHERE codLote = ".$dadosUniao['codUnido']." ORDER BY codLote DESC LIMIT 0,1";
										$resultLote = $conn->query($sqlLote);
										$dadosLoteS = $resultLote->fetch_assoc();

										$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Reserva realizada para o loteamento ".$dadosLoteamento['nomeLoteamento'].", quadra ".$dadosLote['nomeQuadra'].", lote ".$dadosLoteS['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
										$resultHistorico = $conn->query($sqlHistorico);	
									}
								}
							}	
							
							if($codLoteMaster != ""){
								$sqlReserva = "SELECT * FROM lotesReservas WHERE codLote = ".$codLoteMaster." and codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and dataOutLoteReserva IS NULL LIMIT 0,1";
								$resultReserva = $conn->query($sqlReserva);
								$dadosReserva = $resultReserva->fetch_assoc();

								if($dadosReserva['codLoteReserva'] == ""){
									$sqlInsere = "INSERT INTO lotesReservas VALUES(0, ".$codLoteMaster.", ".$_COOKIE['codAprovado'.$cookie].", '".date('Y-m-d H:i:s')."', NULL, 'A')";
									$resultInsere = $conn->query($sqlInsere);							
									
									if($resultInsere == 1){
										$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', '".$_COOKIE['codAprovado'.$cookie]."', '".$codLoteMaster."', 'RR', 'T', 2)";
										$resultInsere = $conn->query($sqlInsere);								

										$sqlLote = "SELECT nomeLote, codLoteamento, nomeQuadra FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra WHERE codLote = ".$codLoteMaster." ORDER BY codLote DESC LIMIT 0,1";
										$resultLote = $conn->query($sqlLote);
										$dadosLoteS = $resultLote->fetch_assoc();

										$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Reserva realizada para o loteamento ".$dadosLoteamento['nomeLoteamento'].", quadra ".$dadosLote['nomeQuadra'].", lote ".$dadosLoteS['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
										$resultHistorico = $conn->query($sqlHistorico);	
									}
								}		
							}
									
						}else{
							$sqlReserva = "SELECT * FROM lotesReservas WHERE codLote = ".$_POST['lote']." and codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and dataOutLoteReserva IS NULL LIMIT 0,1";
							$resultReserva = $conn->query($sqlReserva);
							$dadosReserva = $resultReserva->fetch_assoc();
							
							if($dadosReserva['codLoteReserva'] == ""){
								$sqlInsere = "INSERT INTO lotesReservas VALUES(0, ".$_POST['lote'].", ".$_COOKIE['codAprovado'.$cookie].", '".date('Y-m-d H:i:s')."', NULL, 'A')";
								$resultInsere = $conn->query($sqlInsere);							
								
								if($resultInsere == 1){
									$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', '".$_COOKIE['codAprovado'.$cookie]."', '".$_POST['lote']."', 'RR', 'T', 2)";
									$resultInsere = $conn->query($sqlInsere);								

									$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Reserva realizada para o loteamento ".$dadosLoteamento['nomeLoteamento'].", quadra ".$dadosLote['nomeQuadra'].", lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
									$resultHistorico = $conn->query($sqlHistorico);	
								}
							}	
						}						

						$erro = "<p class='erro'>Negociação inserida com sucesso!</p>";
						$backgroundColor = "background-color:#00b816;";		
						
						$sqlContrato = "SELECT * FROM contratos WHERE codCorretor = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY codContrato DESC LIMIT 0,1";
						$resultContrato = $conn->query($sqlContrato);
						$dadosContrato = $resultContrato->fetch_assoc();								
						
						if($dadosContrato['codContrato'] != ""){
							$_SESSION['abre-intencao'] = $dadosContrato['codContrato'];
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/negociacoes/'>";
						}
					}else{
						$_SESSION['erro'] = "<p class='erro'>Problemas ao cadastrar negociação!</p>";
						$_SESSION['erroCor'] = "background-color:#FF0000;";					

						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/negociacoes/'>";
					}
				}else
				if($_POST['loteContrato'] != ""){
					$cadastra = "ok";
					
					$sqlLote = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join quadras Q on L.codQuadra = Q.codQuadra WHERE L.codLote = ".$_POST['loteContrato']." ORDER BY codLote DESC LIMIT 0,1";
					$resultLote = $conn->query($sqlLote);
					$dadosLote = $resultLote->fetch_assoc();
					
					$_SESSION['loteamentoNegociao'] = $dadosLote['codLoteamento'];
					$_SESSION['quadra'] = $dadosLote['codQuadra'];
					$_SESSION['lote'] = $dadosLote['codLote'];
				}
?>
										<div id="contratos">
											<div id="erro" style="<?php echo $_SESSION['erroCor'];?> <?php echo $_SESSION['erro'] == "" ? 'display:none;' : 'display:table;';?>"><?php echo $erro;?></div>
<?php
				$_SESSION['erro'] = "";
				$_SESSION['erroCor'] = "";
?>											
											<script type="text/javascript">
												function abreNovoContrato(){
													var $gb = jQuery.noConflict();
													if(document.getElementById("bloco-novo").style.display=="none"){
														$gb("#bloco-novo").slideDown();
													}else{
														$gb("#bloco-novo").slideUp();
													}
												}
											</script>
											<p class="novo" onClick="abreNovoContrato();">Nova Negociação</p>										
											<div id="bloco-novo" style="<?php echo $cadastra != "" ? 'display:table;' : 'display:none;';?>">
												<form id="formContrato" action="<?php echo $configUrl;?>minha-conta/negociacoes/" method="post" onSubmit="perguntaNotifica(); return false">
																									
													<p class="campo bloco-campo"><label>Loteamentos: *</label>
														<select class="selectLoteamento form-control campo" id="idSelectLoteamento" name="loteamentoNegociao" style="width:400px; display: none;">
															<optgroup label="Selecione">
															<option value="">Todos</option>	
<?php
					$sqlLoteamentos = "SELECT * FROM loteamentos L inner join cidades C on L.codCidade = C.codCidade inner join lotes LO on L.codLoteamento = LO.codLoteamento WHERE LO.statusLote = 'T' and L.linkLoteamento = '' and L.statusLoteamento = 'T' and LO.vendidoLote = 'F' GROUP BY L.codLoteamento ORDER BY L.nomeLoteamento ASC";
					$resultLoteamentos = $conn->query($sqlLoteamentos);
					while($dadosLoteamentos = $resultLoteamentos->fetch_assoc()){
											
						$sqlLotes = "SELECT * FROM lotes WHERE codLoteamento = ".$dadosLoteamentos['codLoteamento']." ORDER BY codLote ASC";
						$resultLotes = $conn->query($sqlLotes);
						while($dadosLotes = $resultLotes->fetch_assoc()){

							$libera = "nao";
													
							$sqlReservas1 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." ORDER BY codLoteReserva DESC LIMIT 0,1";
							$resultReservas1 = $conn->query($sqlReservas1);
							$dadosReservas1 = $resultReservas1->fetch_assoc();
							
							if($dadosReservas1['codLoteReserva'] != ""){
								
								$sqlReservas2 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NOT NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
								$resultReservas2 = $conn->query($sqlReservas2);
								$dadosReservas2 = $resultReservas2->fetch_assoc();
								
								if($dadosReservas2['codLoteReserva'] != ""){
									$libera = "ok";
									break;
								}else{
									$sqlReservas2 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
									$resultReservas2 = $conn->query($sqlReservas2);
									$dadosReservas2 = $resultReservas2->fetch_assoc();
									
									if($dadosReservas2['codLoteReserva'] != "" && $dadosReservas2['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
										$libera = "ok";
										break;
									}								
								}						
							
							}else{
								$libera = "ok";
							}
						
						}

						if($libera == "ok"){				
?>
															<option value="<?php echo trim($dadosLoteamentos['codLoteamento']);?>" <?php echo $dadosLoteamentos['codLoteamento'] == $_SESSION['loteamentoNegociao'] ? '/SELECTED/' : ''; ?> ><?php echo $dadosLoteamentos['nomeLoteamento'];?> - <?php echo $dadosLoteamentos['nomeCidade'];?>/<?php echo $dadosLoteamentos['estadoCidade'];?></option>	
<?php	
						}
					}				
?>
														</select>										
													</p>

													<script>
														var $rfg = jQuery.noConflict();
														
														$rfg(".selectLoteamento").select2({
															placeholder: "Todos",
															multiple: false									
														});	

														$rfg(".selectLoteamento").on("select2:select", function (e) {
															var loteamentoSeleciona = document.getElementById("idSelectLoteamento").value;

															$rfg.post("<?php echo $configUrl;?>minha-conta/carrega-quadras.php", {codLoteamento: loteamentoSeleciona}, function(data){
																$rfg("#carrega-quadras").html(data);
															});							
															
															$rfg.post("<?php echo $configUrl;?>minha-conta/carrega-lotes.php", {codLoteamento: loteamentoSeleciona, codQuadra: 0}, function(data){
																$rfg("#carrega-lotes").html(data);
															});	
														});															
													</script>	
													<script>
														function perguntaNotifica() {
														  Swal.fire({
															title: 'Você reservando esse lote<br/>para uma venda!',
															html: "1º passo: você irá regidir a intenção de compra após ser clicado no botão 'OK'!<br/><br/> 2º passo: seu cliente irá despositar o sinal de arras na conta informada no conteúdo desta área ou no arquivo de edição da intenção de compra!<br/><br/>3º passo: você irá anexar a intenção de compra assinada, comprovante de pagamento do sinal de arras, comprovante de residência, documentos de identidade do(s) comprador(es), caso tenha, os documentos do cônjuge e algum documento adicional!<br/><br/>5º passo: aguardar a nossa equipe que entrará em contato com você para finalizar a venda!",
															icon: 'warning',
															showCancelButton: true,
															confirmButtonColor: '#3085d6',
															confirmButtonText: 'OK'
														  }).then((result) => {
															if (result.isConfirmed) {
															  setTimeout(enviaForm, 1000);
															}
														  });
														}
														
														function avisoReserva() {
														  Swal.fire({
															title: 'Erro ao acessar página!',
															html: "Você precisa reservar o lote novamente!",
															icon: 'warning',
															confirmButtonColor: '#FF0000',
															confirmButtonText: 'Fechar'
														  });
														}
														
														function enviaForm(){
															document.getElementById("formContrato").submit();
														}																												
													</script>
													<div id="carrega-quadras">
<?php
					if($_SESSION['loteamentoNegociao'] != ""){
?>
														<p class="campo bloco-campo"><label>Quadra: *</label>
															<select class="selectQuadra form-control campo" id="idSelectQuadra" name="quadra" style="width:400px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
						$sqlQuadrasLote = "SELECT * FROM quadras Q inner join lotes L on Q.codQuadra = L.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE LO.codLoteamento = ".$_SESSION['loteamentoNegociao']." and LO.statusLoteamento = 'T' and L.statusLote = 'T' and L.vendidoLote = 'F' GROUP BY Q.codQuadra ORDER BY Q.nomeQuadra ASC";
						$resultQuadrasLote = $conn->query($sqlQuadrasLote);
						while($dadosQuadrasLote = $resultQuadrasLote->fetch_assoc()){
							
							$sqlLotes = "SELECT * FROM lotes WHERE codLoteamento = ".$dadosQuadrasLote['codLoteamento']." and codQuadra = ".$dadosQuadrasLote['codQuadra']." ORDER BY codLote ASC";
							$resultLotes = $conn->query($sqlLotes);
							while($dadosLotes = $resultLotes->fetch_assoc()){

								$libera = "nao";
														
								$sqlReservas1 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." ORDER BY codLoteReserva DESC LIMIT 0,1";
								$resultReservas1 = $conn->query($sqlReservas1);
								$dadosReservas1 = $resultReservas1->fetch_assoc();
								
								if($dadosReservas1['codLoteReserva'] != ""){
									
									$sqlReservas2 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NOT NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
									$resultReservas2 = $conn->query($sqlReservas2);
									$dadosReservas2 = $resultReservas2->fetch_assoc();
									
									if($dadosReservas2['codLoteReserva'] != ""){
										$libera = "ok";
										break;
									}else{
										$sqlReservas2 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
										$resultReservas2 = $conn->query($sqlReservas2);
										$dadosReservas2 = $resultReservas2->fetch_assoc();
										
										if($dadosReservas2['codLoteReserva'] != "" && $dadosReservas2['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
											$libera = "ok";
											break;
										}								
									}						
								
								}else{
									$libera = "ok";
								}
							
							}

							if($libera == "ok"){										
?>
																<option value="<?php echo trim($dadosQuadrasLote['codQuadra']);?>" <?php echo trim($dadosQuadrasLote['codQuadra']) == $_SESSION['quadra'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosQuadrasLote['nomeQuadra']);?></option>	
<?php
							}
						}
?>
															</select>									
														</p>
<?php
					}else{
?>
														<p class="campo bloco-campo"><label>Quadra: *</label>
															<select class="selectQuadra form-control campo" id="idSelectQuadra" name="quadra" style="width:400px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
						$sqlQuadrasLote = "SELECT * FROM quadras Q inner join lotes L on Q.codQuadra = L.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE LO.statusLoteamento = 'T' and L.statusLote = 'T' and L.vendidoLote = 'F' GROUP BY Q.codQuadra ORDER BY Q.nomeQuadra ASC";
						$resultQuadrasLote = $conn->query($sqlQuadrasLote);
						while($dadosQuadrasLote = $resultQuadrasLote->fetch_assoc()){
							
							$sqlLotes = "SELECT * FROM lotes WHERE codLoteamento = ".$dadosQuadrasLote['codLoteamento']." and codQuadra = ".$dadosQuadrasLote['codQuadra']." ORDER BY codLote ASC";
							$resultLotes = $conn->query($sqlLotes);
							while($dadosLotes = $resultLotes->fetch_assoc()){

								$libera = "nao";
														
								$sqlReservas1 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." ORDER BY codLoteReserva DESC LIMIT 0,1";
								$resultReservas1 = $conn->query($sqlReservas1);
								$dadosReservas1 = $resultReservas1->fetch_assoc();
								
								if($dadosReservas1['codLoteReserva'] != ""){
									
									$sqlReservas2 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NOT NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
									$resultReservas2 = $conn->query($sqlReservas2);
									$dadosReservas2 = $resultReservas2->fetch_assoc();
									
									if($dadosReservas2['codLoteReserva'] != ""){
										$libera = "ok";
										break;
									}else{
										$sqlReservas2 = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
										$resultReservas2 = $conn->query($sqlReservas2);
										$dadosReservas2 = $resultReservas2->fetch_assoc();
										
										if($dadosReservas2['codLoteReserva'] != "" && $dadosReservas2['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){
											$libera = "ok";
											break;
										}								
									}						
								
								}else{
									$libera = "ok";
								}
							
							}

							if($libera == "ok"){										
?>
																<option value="<?php echo trim($dadosQuadrasLote['codQuadra']);?>" <?php echo trim($dadosQuadrasLote['codQuadra']) == $_SESSION['quadra'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosQuadrasLote['nomeQuadra']);?></option>	
<?php
							}
						}
?>
															</select>										
														</p>
<?php
					}
					
					if($_SESSION['loteamentoNegociao'] != ""){
						$codLoteamento = $_SESSION['loteamentoNegociao'];
					}else{
						$codLoteamento = 0;
					}
?>
														<script>
															var $rfs = jQuery.noConflict();
															
															$rfs(".selectQuadra").select2({
																placeholder: "Todos",
																multiple: false									
															});	

															$rfs(".selectQuadra").on("select2:select", function (e) {
																var quadraSeleciona = document.getElementById("idSelectQuadra").value;

																$rfs.post("<?php echo $configUrl;?>minha-conta/carrega-lotes.php", {codLoteamento: <?php echo $codLoteamento;?>, codQuadra: quadraSeleciona}, function(data){
																	$rfs("#carrega-lotes").html(data);
																});							
															});																															
														</script>									
													</div>	
													<div id="carrega-lotes">
<?php
				if($_SESSION['loteamentoNegociao'] != ""){
					if($_SESSION['quadra'] != ""){
?>														
														<p class="campo bloco-campo"><label>Lote: * </label>
															<select class="selectLote form-control campo" id="idSelectLote" name="lote" style="width:400px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
						$sqlLotesLote = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.codQuadra = ".$_SESSION['quadra']." and L.codLoteamento = ".$_SESSION['loteamentoNegociao']." and L.vendidoLote = 'F' GROUP BY L.codLote ORDER BY L.nomeLote ASC";
						$resultLotesLote = $conn->query($sqlLotesLote);
						while($dadosLotesLote = $resultLotesLote->fetch_assoc()){	

							$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotesLote['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
							$resultReservas = $conn->query($sqlReservas);
							$dadosReservas = $resultReservas->fetch_assoc();

							if($dadosReservas['codLoteReserva'] == "" || $dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){											
?>
																<option value="<?php echo trim($dadosLotesLote['codLote']);?>" <?php echo trim($dadosLotesLote['codLote']) == $_SESSION['lote'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLote['nomeLote']);?></option>	
<?php
							}
						}
?>
															</select>										
														</p>
<?php
					}else{
?>
														<p class="campo bloco-campo"><label>Lote: * </label>
															<select class="selectLote form-control campo" id="idSelectLote" name="lote" style="width:400px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
						$sqlLotesLote = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.codLoteamento = ".$_SESSION['loteamentoNegociao']." and L.vendidoLote = 'F' GROUP BY L.codLote ORDER BY L.nomeLote ASC";
						$resultLotesLote = $conn->query($sqlLotesLote);
						while($dadosLotesLote = $resultLotesLote->fetch_assoc()){	

							$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotesLote['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
							$resultReservas = $conn->query($sqlReservas);
							$dadosReservas = $resultReservas->fetch_assoc();

							if($dadosReservas['codLoteReserva'] == "" || $dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){										
?>
																<option value="<?php echo $dadosLotesLote['codLote'];?>" <?php echo $dadosLotesLote['codLote'] == $_SESSION['lote'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLote['nomeLote']);?></option>	
<?php
							}
						}
?>
															</select>										
														</p>
<?php	
					}
				}else{
					if($_SESSION['quadra'] != ""){
?>
														<p class="campo bloco-campo"><label>Lote: * </label>
															<select class="selectLote form-control campo" id="idSelectLote" name="lote" style="width:400px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
						$sqlLotesLote = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.codQuadra = ".$_SESSION['quadra']." and L.vendidoLote = 'F' GROUP BY L.codLote ORDER BY L.nomeLote ASC";
						$resultLotesLote = $conn->query($sqlLotesLote);
						while($dadosLotesLote = $resultLotesLote->fetch_assoc()){		

							$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotesLote['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
							$resultReservas = $conn->query($sqlReservas);
							$dadosReservas = $resultReservas->fetch_assoc();

							if($dadosReservas['codLoteReserva'] == "" || $dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){									
?>
																<option value="<?php echo trim($dadosLotesLote['codLote']);?>" <?php echo trim($dadosLotesLote['codLote']) == $_SESSION['lote'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLote['nomeLote']);?></option>	
<?php
							}
						}
?>
															</select>										
														</p>
<?php
					}else{
?>
														<p class="campo bloco-campo"><label>Lote: * </label>
															<select class="selectLote form-control campo" id="idSelectLote" name="lote" style="width:400px; display: none;">
																<optgroup label="Selecione">
																<option value="">Todos</option>	
<?php
						$sqlLotesLote = "SELECT * FROM lotes L inner join loteamentos LO on L.codLoteamento = LO.codLoteamento WHERE L.statusLote = 'T' and L.vendidoLote = 'F' GROUP BY L.codLote ORDER BY L.nomeLote ASC";
						$resultLotesLote = $conn->query($sqlLotesLote);
						while($dadosLotesLote = $resultLotesLote->fetch_assoc()){	

							$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotesLote['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
							$resultReservas = $conn->query($sqlReservas);
							$dadosReservas = $resultReservas->fetch_assoc();

							if($dadosReservas['codLoteReserva'] == "" || $dadosReservas['codCorretor'] == $_COOKIE['codAprovado'.$cookie]){										
?>
																<option value="<?php echo $dadosLotesLote['codLote'];?>" <?php echo $dadosLotesLote['codLote'] == $_SESSION['lote'] ? '/SELECTED/' : ''; ?> ><?php echo trim($dadosLotesLote['nomeLote']);?></option>	
<?php
							}
						}
?>
															</select>										
														</p>
<?php
					}
				}
?>
								
														<script>
															var $rfh = jQuery.noConflict();
															
															$rfh(".selectLote").select2({
																placeholder: "Selecione",
																multiple: false									
															});																	
														</script>														
													</div>
													
													<p class="bloco-cadastratar"><input type="submit" value="Cadastrar" name="cadastrar"/></p>
												</form>
											</div>
											<div id="mostra-contratos">
												<script type="text/javascript">
													function carregaImprimir(contrato){
														var $tg = jQuery.noConflict();
														$tg("#carrega-imprimir").fadeIn(250);
														$tg.post("<?php echo $configUrl;?>minha-conta/pega-contrato.php", {codContrato: contrato}, function(data){
															$tg("#carrega-imprimir").html(data);
														});																
													}
													
													function fechaImprimir(){
														var $tsg = jQuery.noConflict();
														$tsg("#carrega-imprimir").fadeOut(250, function(){
															$tsg("#carrega-imprimir").html("");
														});
														
													}
												</script>
												<div id="carrega-imprimir" style="display:none;">
													
												</div>
												<script type="text/javascript">
													function salvaContrato(contrato){
														var $rt = jQuery.noConflict();	
														
														var texto = tinymce.get("textarea-contrato").getContent();
																	
														var caracteres = texto.length;
														var textoGuardado = document.getElementById("guardado-contrato").value;																																
																					
														$rt.post("<?php echo $configUrl;?>minha-conta/salva-contrato.php", {codContrato: contrato, textoContrato: texto}, function(data){	
															if(caracteres <= 310){
																tinymce.get("textarea-contrato").insertContent(textoGuardado);
															}
															alert("Documento Salvo!");
														});								
													}				
												</script>													
												
<?php
				$sqlContratos = "SELECT * FROM contratos CO inner join lotes L on CO.codLote = L.codLote inner join quadras Q on L.codQuadra = Q.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join cidades C on LO.codCidade = C.codCidade WHERE CO.codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and CO.statusContrato = 'T' GROUP BY CO.codContrato ORDER BY CO.dataContrato DESC LIMIT 0,1";
				$resultContratos = $conn->query($sqlContratos);
				$dadosContratos = $resultContratos->fetch_assoc();
				
				if($dadosContratos['codContrato'] != ""){
?>
												<table id="tabela-lotes">
													<tr class="tr-titulo">
														<th>Loteamento</th>
														<th>Quadra</th>
														<th>Lote(s)</th>
														<th>Valor</th>
														<th>Conta para depósito Sinal de Arras</th>
														<th>Status</th>
														<th>Intenção de Compra</th>
														<th>Anexar Arquivos</th>
													</tr>
<?php
					$cont = 0;
					$contCor == 0;
					$sqlContratos = "SELECT * FROM contratos CO inner join lotes L on CO.codLote = L.codLote inner join quadras Q on L.codQuadra = Q.codQuadra inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join cidades C on LO.codCidade = C.codCidade WHERE CO.codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and CO.statusContrato = 'T' GROUP BY CO.codContrato ORDER BY CO.dataContrato DESC";
					$resultContratos = $conn->query($sqlContratos);
					while($dadosContratos = $resultContratos->fetch_assoc()){
						$cont++;
						
						$sqlLote = "SELECT * FROM lotes WHERE codLote = ".$dadosContratos['codLote']." LIMIT 0,1";
						$resultLote = $conn->query($sqlLote);
						$dadosLote = $resultLote->fetch_assoc();
												
						$sqlReserva = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosContratos['codLote']." and codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
						$resultReserva = $conn->query($sqlReserva);
						$dadosReserva = $resultReserva->fetch_assoc();
						
						if($dadosContratos['tipoContrato'] != "F" && $dadosReserva['codLoteReserva'] == "" && $dadosLote['vendidoLote'] == "F"){
							$tipoC = "<span style='color:#FF0000;'><strong style='color:#FF0000;'>Travado</strong><br/>Faça a reserva do lote novamente!</span>";
						}else
						if($dadosContratos['tipoContrato'] == "RIC"){
							$tipoC = "Redigir Intenção<br/>de Compra";
						}else
						if($dadosContratos['tipoContrato'] == "AA"){
							$tipoC = "Anexar Arquivos";
						}else
						if($dadosContratos['tipoContrato'] == "CC"){
							$tipoC = "Contrato em Confecção<br/>Aguarde...";
						}else
						if($dadosContratos['tipoContrato'] == "CP"){
							$tipoC = "Contrato Pronto";
						}else{
							$tipoC = "Finalizado";
						}

						$sqlAnexos = "SELECT * FROM contratosAnexos WHERE codContrato = ".$dadosContratos['codContrato']." and tipoContratoAnexo = 99 ORDER BY dataContratoAnexo DESC, tipoContratoAnexo ASC";
						$resultAnexos = $conn->query($sqlAnexos);
						$dadosAnexos = $resultAnexos->fetch_assoc();
													
						$sqlLoteamento = "SELECT * FROM loteamentos WHERE codLoteamento = ".$dadosContratos['codLoteamento']." LIMIT 0,1";
						$resultLoteamento = $conn->query($sqlLoteamento);
						$dadosLoteamento = $resultLoteamento->fetch_assoc();
						
						if($dadosLote['codConta'] != 0){
							$sqlConta = "SELECT * FROM contas WHERE codConta = ".$dadosLote['codConta']." ORDER BY codConta ASC LIMIT 0,1";
							$resultConta = $conn->query($sqlConta);
							$dadosConta = $resultConta->fetch_assoc();	
						}else{
							$sqlConta = "SELECT * FROM contas WHERE codConta = ".$dadosLoteamento['codConta']." ORDER BY codConta ASC LIMIT 0,1";
							$resultConta = $conn->query($sqlConta);
							$dadosConta = $resultConta->fetch_assoc();			
						}
						
						$sqlUniaoMaster = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosLote['codLote']." or codUnido = ".$dadosLote['codLote']." ORDER BY codLote ASC LIMIT 0,1";
						$resultUniaoMaster = $conn->query($sqlUniaoMaster);
						$dadosUniaoMaster = $resultUniaoMaster->fetch_assoc();
						
						if($dadosUniaoMaster['codLoteUnido'] != ""){
							$sqlUniao = "SELECT * FROM lotesUnidos LU inner join lotes L on LU.codLote = L.codLote WHERE L.codLote = ".$dadosUniaoMaster['codLote']." ORDER BY LU.codLoteUnido ASC";
							$resultUniao = $conn->query($sqlUniao);
							$dadosUniao = $resultUniao->fetch_assoc();
							
							$lote = $dadosUniao['nomeLote'];
							$precoLote = $dadosUniao['precoLote'];
							
							$sqlUniao = "SELECT * FROM lotesUnidos LU inner join lotes L on LU.codUnido = L.codLote WHERE LU.codLote = ".$dadosUniaoMaster['codLote']." ORDER BY LU.codLote ASC";
							$resultUniao = $conn->query($sqlUniao);
							while($dadosUniao = $resultUniao->fetch_assoc()){
								$lote .= ", ".$dadosUniao['nomeLote'];
								$precoLote = $precoLote + $dadosUniao['precoLote'];
							}
						
						}else{
							$lote = $dadosLote['nomeLote'];
							$precoLote = $dadosLote['precoLote'];
						}
						if($contCor == 0){
							$backgroundColor = "background-color:#e2e2e2;";
							$contCor++;
						}else{
							$backgroundColor = "background-color:#e0fff8;";
							$contCor = 0;
						}
?>												
													<tr class="tr-lista" style="<?php echo $backgroundColor;?>">
														<td style="text-align:left; width:25%; font-size:15px;"><?php echo $dadosContratos['nomeLoteamento'];?> - <?php echo $dadosContratos['nomeCidade'];?> / <?php echo $dadosContratos['estadoCidade'];?></td>
														<td style="width:5%; font-size:15px; text-align:center;"><?php echo $dadosContratos['nomeQuadra'];?></td>
														<td style="width:5%; font-size:15px; text-align:center;"><strong style="font-size:15px;"><?php echo $lote;?></strong></td>
														<td style="width:8%; font-size:15px; text-align:center;">R$ <?php echo number_format($dadosContratos['valorInIntencao'] != '0.00' ? $dadosContratos['valorInIntencao'] : $precoLote, 2, ",", ".");?></td>
														<td style="width:30%; font-size:15px; text-align:left; color:"><strong style="font-size:15px; color:#002c23; <?php echo $dadosConta['pixConta'] == "" ? 'display:none;' : '';?>">Chave Pix:</strong> <?php echo $dadosConta['pixConta'];?><br style="<?php echo $dadosConta['pixConta'] == "" ? 'display:none;' : '';?>"/><strong style="font-size:15px; color:#002c23; <?php echo $dadosConta['nomeConta'] == "" ? 'display:none;' : '';?>">Razão Social:</strong> <?php echo $dadosConta['nomeConta'];?><br style="<?php echo $dadosConta['nomeConta'] == "" ? 'display:none;' : '';?>"/><strong style="font-size:15px; color:#002c23; <?php echo $dadosConta['agenciaConta'] == "" ? 'display:none;' : '';?>">Agência:</strong> <?php echo $dadosConta['agenciaConta'];?> <span style="<?php echo $dadosConta['agenciaConta'] == "" ? 'display:none;' : '';?>">|</span> <strong style="font-size:15px; color:#002c23; <?php echo $dadosConta['contaConta'] == "" ? 'display:none;' : '';?>">Conta:</strong> <?php echo $dadosConta['contaConta'];?><br style="<?php echo $dadosConta['agenciaConta'] == "" && $dadosConta['contaConta'] == "" ? 'display:none;' : '';?>"/><strong style="font-size:15px; color:#002c23; <?php echo $dadosConta['bancoConta'] == "" ? 'display:none;' : '';?>">Banco:</strong> <?php echo $dadosConta['bancoConta'];?> <span style="<?php echo $dadosConta['bancoConta'] == "" ? 'display:none;' : '';?>">|</span> <strong style="font-size:15px; color:#002c23; <?php echo $dadosConta['cnpjConta'] == "" ? 'display:none;' : '';?>">CNPJ:</strong> <?php echo $dadosConta['cnpjConta'];?></td>
<?php
						if($dadosContratos['tipoContrato'] == "CP" && $dadosAnexos['codContratoAnexo'] != ""){
?>
														<td style="width:10%; font-size:15px; text-align:center;"><?php echo $tipoC;?><br/><a download="<?php echo $dadosAnexos['nomeContratoAnexo'];?>" href="<?php echo $configUrlGer.'f/contratosAnexo/'.$dadosAnexos['codContrato'].'-'.$dadosAnexos['codContratoAnexo'].'-O.'.$dadosAnexos['extContratoAnexo'];?>"><strong style="color:#002c23; font-size:15px; text-decoration:underline;">Baixar Contrato</strong></a></td>
<?php
						}else{
?>
														<td style="width:10%; font-size:15px; text-align:center;"><?php echo $tipoC;?></td>
<?php							
						}
						
						if($dadosContratos['tipoContrato'] != "F" && $dadosReserva['codLoteReserva'] == "" && $dadosLote['vendidoLote'] == "F"){
?>
														<td style="padding:5px; cursor:pointer; font-size:15px; text-align:center;" onClick="avisoReserva();"><img src="<?php echo $configUrl;?>f/i/quebrado/editar.svg" width="40"/></td>
														<td style="padding:5px; cursor:pointer; font-size:15px; text-align:center;" onClick="avisoReserva();"><a><img src="<?php echo $configUrl;?>f/i/quebrado/arquivo-anexo.svg" width="42"/></a></td>
<?php
						}else{
?>														
														<td style="padding:5px; cursor:pointer; font-size:15px; text-align:center;" onClick="carregaImprimir(<?php echo $dadosContratos['codContrato'];?>);"><img src="<?php echo $configUrl;?>f/i/quebrado/editar.svg" width="40"/></td>
														<td style="padding:5px; cursor:pointer; font-size:15px; text-align:center;"><a href="<?php echo $configUrl;?>minha-conta/negociacoes/<?php echo $dadosContratos['codContrato'];?>/"><img src="<?php echo $configUrl;?>f/i/quebrado/arquivo-anexo.svg" width="42"/></a></td>
<?php
						}
?>
													</tr>
<?php
					}
?>
												</table>											
<?php
				}else{
?>
												<p class="msg">Nenhum contrato encontrado!</p>
<?php				
				}
?>												
											</div>
										</div>
<?php				
				if($_SESSION['abre-intencao'] != "" && $_POST['loteamentoNegociao'] == ""){
					echo "<script>setTimeout('carregaImprimir(".$_SESSION['abre-intencao'].")', 1000);</script>";
					$_SESSION['abre-intencao']= "";
				}
			}else{
				
				$sqlContrato = "SELECT * FROM contratos C inner join lotes L on C.codLote = L.codLote inner join loteamentos LO on L.codLoteamento = LO.codLoteamento inner join quadras Q on L.codQuadra = Q.codQuadra WHERE C.codContrato = ".$url[4]." and C.codCorretor = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY C.codContrato DESC LIMIT 0,1";
				$resultContrato = $conn->query($sqlContrato);
				$dadosContrato = $resultContrato->fetch_assoc();
				
				if($dadosContrato['codContrato'] != ""){

					if($_SESSION['erro'] != ""){
						echo $_SESSION['erro'];
						$_SESSION['erro'] = "";
					}
										
					if($url[6] != ""){
						$sqlConsultaAnexo = "SELECT * FROM contratosAnexos WHERE codContratoAnexo = ".$url[6]." and codContrato = ".$dadosContrato['codContrato']." ORDER BY codContrato DESC LIMIT 0,1";
						$resultConsultaAnexo = $conn->query($sqlConsultaAnexo);
						$dadosConsultaAnexo = $resultConsultaAnexo->fetch_assoc();
						
						$sqlDelete = "DELETE FROM contratosAnexos WHERE codContratoAnexo = ".$url[6]." and codContrato = ".$dadosContrato['codContrato']."";
						$resultDelete = $conn->query($sqlDelete);
						
						if($resultDelete == 1){

							$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Anexo ".$dadosConsultaAnexo['nomeContratoAnexo']." excluído na negociação do loteamento ".$dadosLoteamento['nomeLoteamento'].", quadra ".$dadosContrato['nomeQuadra'].", lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
							$resultHistorico = $conn->query($sqlHistorico);	
														
							if(file_exists($_SERVER['DOCUMENT_ROOT'].$urlUpload."/f/contratosAnexo/".$dadosConsultaAnexo['codContrato']."-".$dadosConsultaAnexo['codContratoImagem']."-O.".$dadosConsultaAnexo['extContratoImagem'])){
								unlink($_SERVER['DOCUMENT_ROOT'].$urlUpload."/f/contratosAnexo/".$dadosConsultaAnexo['codContrato']."-".$dadosConsultaAnexo['codContratoImagem']."-O.".$dadosConsultaAnexo['extContratoImagem']);
							}
							
							$_SESSION['erro'] = "<p class='erro-sucesso'>Anexo <strong>".$dadosConsultaAnexo['nomeContratoAnexo']."</strong> foi excluído com sucesso!</p>";

							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/negociacoes/".$url[4]."/'>";
						}
					}
					
					if(isset($_POST['salvarAnexos'])){
						$pastaDestino = $_SERVER['DOCUMENT_ROOT'].$urlUpload.'/f/contratosAnexo/';
						$codContrato = $url[4];
						$tiposArquivos = ['intencao', 'cpf', 'cpfConjuge', 'residencia', 'certidao', 'sinal', 'adicional'];
						$extensoesPermitidas = ['pdf', 'docx', 'png', 'jpg', 'jpeg'];
						$tamanhoMaximo = 5 * 1024 * 1024;
						
						$codigoTiposArquivos = [
							'intencao' => 1,
							'cpf' => 2,
							'cpfConjuge' => 3,
							'residencia' => 4,
							'certidao' => 5,
							'sinal' => 6,
							'adicional' => 7
						];
						
						$_SESSION['erro'] = "";

						foreach ($tiposArquivos as $tipo) {
							if (!empty($_FILES[$tipo]['tmp_name'][0])) {
								foreach ($_FILES[$tipo]['tmp_name'] as $index => $tmp_name) {

									if (!is_uploaded_file($tmp_name)) {
										continue;
									}

									$file_name = $_FILES[$tipo]['name'][$index];
									$file_type = $_FILES[$tipo]['type'][$index];
									$file_size = $_FILES[$tipo]['size'][$index];
									$ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

									if ($file_size > $tamanhoMaximo) {
										$_SESSION['erro'] .= "<p class='erro-lista'>Erro: o arquivo <strong>$file_name</strong> excede o tamanho máximo permitido de 5 MB.</p>";
										continue;
									}

									if (!in_array($ext, $extensoesPermitidas)) {
										$_SESSION['erro'] .= "<p class='erro-lista'>Erro: extensão do arquivo inválida para o arquivo <strong>$file_name</strong>. Apenas PDF, DOCX, PNG, JPG, e JPEG são permitidos.</p>";
										continue;
									}

									$codigoTipo = $codigoTiposArquivos[$tipo];

									$sqlContrato = "INSERT INTO contratosAnexos VALUES (0, $codContrato, '$file_name', '".date('Y-m-d')."', $codigoTipo, '$ext')";
									$resultContrato = $conn->query($sqlContrato);    
									
									if($resultContrato == 1){
										$entra = "ok";
									}

									$sqlPegaContrato = "SELECT codContratoAnexo FROM contratosAnexos ORDER BY codContratoAnexo DESC LIMIT 1";
									$resultPegaContrato = $conn->query($sqlPegaContrato);
									$dadosPegaContrato = $resultPegaContrato->fetch_assoc();
										
									$codContratoAnexo = $dadosPegaContrato['codContratoAnexo'];
										
									move_uploaded_file($tmp_name, $pastaDestino.$codContrato."-".$codContratoAnexo."-O.".$ext);
											
									chmod($pastaDestino.$codContrato."-".$codContratoAnexo."-O.".$ext, 0755);                       
								}
							}
						}

						$sqlLote = "SELECT * FROM lotes WHERE codLote = ".$dadosContrato['codLote']." ORDER BY codLote DESC LIMIT 0,1";
						$resultLote = $conn->query($sqlLote);
						$dadosLote = $resultLote->fetch_assoc();
						
						$sqlLoteamento = "SELECT nomeLoteamento FROM loteamentos WHERE codLoteamento = ".$dadosLote['codLoteamento']." ORDER BY codLoteamento DESC LIMIT 0,1";
						$resultLoteamento = $conn->query($sqlLoteamento);
						$dadosLoteamento = $resultLoteamento->fetch_assoc();
						
						if($_SESSION['erro'] == ""){					
							$sqlMovimentacao = "SELECT * FROM movimentacoes WHERE codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and codLote = ".$dadosContrato['codLote']." and nomeMovimentacao = 'VI' ORDER BY codMovimentacao DESC LIMIT 0,1";
							$resultMovimentacao = $conn->query($sqlMovimentacao);
							$dadosMovimentacao = $resultMovimentacao->fetch_assoc();
						
							if($dadosMovimentacao['codMovimentacao'] == ""){
								$sqlInsere = "INSERT INTO movimentacoes VALUES(0, 0, '".date('Y-m-d H:i:s')."', ".$_COOKIE['codAprovado'.$cookie].", ".$dadosContrato['codLote'].", 'VI', 'T', 1)";
								$resultInsere = $conn->query($sqlInsere);
							}

							$sqlUpdate = "UPDATE contratos SET tipoContrato = 'CC' WHERE codContrato = ".$url[4]."";
							$resultUpdate = $conn->query($sqlUpdate);	

							$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosLote['codLote']." or codUnido = ".$dadosLote['codLote']." ORDER BY codLote ASC LIMIT 0,1";
							$resultUniao = $conn->query($sqlUniao);
							$dadosUniao = $resultUniao->fetch_assoc();
							
							if($dadosUniao['codLote'] != ""){
								$sqlUniao = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosUniao['codLote']." ORDER BY codLote ASC";
								$resultUniao = $conn->query($sqlUniao);
								while($dadosUniao = $resultUniao->fetch_assoc()){
									$sqlUpdate = "UPDATE lotesReservas SET statusLoteReserva = 'C' WHERE (codLote = ".$dadosUniao['codUnido']." or codLote = ".$dadosUniao['codLote'].") and codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and dataOutLoteReserva IS NULL";
									$resultUpdate = $conn->query($sqlUpdate);
								}
							}else{				
								$sqlUpdate = "UPDATE lotesReservas SET statusLoteReserva = 'C' WHERE codLote = ".$dadosContrato['codLote']." and codCorretor = ".$_COOKIE['codAprovado'.$cookie]." and dataOutLoteReserva IS NULL";
								$resultUpdate = $conn->query($sqlUpdate);
							}
						}
						
						if($entra == "ok"){
							$sqlHistorico = "INSERT INTO historico VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", 'Anexo(s) adicionado(s) para a negociação do loteamento ".$dadosLoteamento['nomeLoteamento'].", quadra ".$dadosContrato['nomeQuadra'].", lote ".$dadosLote['nomeLote']."', '".date('Y-m-d H:i:s')."', 'T')";
							$resultHistorico = $conn->query($sqlHistorico);											
						}	
						
						if($_SESSION['erro'] == ""){
							$_SESSION['erro'] = "<p class='erro-sucesso'>Anexos cadastrados com sucesso!</p>";
						}	

						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."minha-conta/negociacoes/".$url[4]."/'>";							   
					}

					$sqlUniaoMaster = "SELECT * FROM lotesUnidos WHERE codLote = ".$dadosContrato['codLote']." or codUnido = ".$dadosContrato['codLote']." ORDER BY codLote ASC LIMIT 0,1";
					$resultUniaoMaster = $conn->query($sqlUniaoMaster);
					$dadosUniaoMaster = $resultUniaoMaster->fetch_assoc();
					
					if($dadosUniaoMaster['codLoteUnido'] != ""){
						$sqlUniao = "SELECT * FROM lotesUnidos LU inner join lotes L on LU.codLote = L.codLote WHERE L.codLote = ".$dadosUniaoMaster['codLote']." ORDER BY LU.codLoteUnido ASC";
						$resultUniao = $conn->query($sqlUniao);
						$dadosUniao = $resultUniao->fetch_assoc();
						
						$lote = $dadosUniao['nomeLote'];
						
						$sqlUniao = "SELECT * FROM lotesUnidos LU inner join lotes L on LU.codUnido = L.codLote WHERE LU.codLote = ".$dadosUniaoMaster['codLote']." ORDER BY LU.codLote ASC";
						$resultUniao = $conn->query($sqlUniao);
						while($dadosUniao = $resultUniao->fetch_assoc()){
							$lote .= ", ".$dadosUniao['nomeLote'];
						}
					
					}else{
						$lote = $dadosLote['nomeLote'];
					}					
?>
										<div id="cadastra-anexo">
											<p class="botao-topo"><a href="<?php echo $configUrl;?>minha-conta/negociacoes/">Ver todos os Contratos</a></p>
											<p class="titulo">Você esta cadastrando anexos para o(s) Lote(s): <strong><?php echo $lote;?></strong> - Quadra: <strong><?php echo $dadosContrato['nomeQuadra'];?></strong> - Loteamento: <strong><?php echo $dadosContrato['nomeLoteamento'];?></strong></p>
											<div id="erro" style="<?php echo $backgroundColor;?> <?php echo $erro == "" ? 'display:none;' : 'display:table;';?>"><?php echo $erro;?></div>											
											<div id="bloco-anexo">
												<form id="formAnexo" enctype="multipart/form-data" method="POST" action="<?php echo $configUrl;?>minha-conta/negociacoes/<?php echo $url[4];?>/">
													<label class="label"><strong>Extensão:</strong> pdf, docx, png, jpg, jpeg | <strong>Tamanho:</strong> máximo 5MB</label>
<?php
					$sqlConsultaAnexo = "SELECT * FROM contratosAnexos WHERE codContrato = ".$dadosContrato['codContrato']." and tipoContratoAnexo != 99 ORDER BY codContrato DESC";
					$resultConsultaAnexo = $conn->query($sqlConsultaAnexo);
					while($dadosConsultaAnexo = $resultConsultaAnexo->fetch_assoc()){
						$tipoAnexo[$dadosConsultaAnexo['tipoContratoAnexo']] = "ok";
					}				
?>
													<p class="selecao">
														<label class="<?php echo $tipoAnexo[1] == "ok" ? 'nobgr' : 'obgr';?>"><?php echo $tipoAnexo[1] == "ok" ? 'cadastrado' : 'obrigatório';?></label>
														<label class="titulo-selecao">Intenção de venda assinada:</label>
														<input type="file" class="campo" id="intencao" name="intencao[]" <?php echo $tipoAnexo[1] == "ok" ? '' : 'required';?> />
														<br class="clear"/>
													</p>	
													
													<p class="selecao">
														<label class="<?php echo $tipoAnexo[2] == "ok" ? 'nobgr' : 'obgr';?>"><?php echo $tipoAnexo[2] == "ok" ? 'cadastrado' : 'obrigatório';?></label>
														<label class="titulo-selecao">CPF e RG ou CNH:</label>
														<input type="file" class="campo" id="cpf" name="cpf[]" <?php echo $tipoAnexo[2] == "ok" ? '' : 'required';?>/>
														<br class="clear"/>
													</p>	
													
<?php
					if($dadosContrato['conjugeIntencao'] != ""){
?>													
													<p class="selecao">
														<label class="<?php echo $tipoAnexo[3] == "ok" ? 'nobgr' : 'obgr';?>"><?php echo $tipoAnexo[3] == "ok" ? 'cadastrado' : 'obrigatório';?></label>
														<label class="titulo-selecao">CPF e RG ou CNH - Cônjuge ou 2º Comprador(a):</label>
														<input type="file" class="campo" id="cpfConjuge" name="cpfConjuge[]" <?php echo $tipoAnexo[3] == "ok" ? '' : 'required';?>/>
														<br class="clear"/>
													</p>	
<?php
					}
?>													
													<p class="selecao">
														<label class="nobgr"><?php echo $tipoAnexo[4] == "ok" ? 'cadastrado' : 'opcional';?></label>
														<label class="titulo-selecao">Comprovante de residência:</label>
														<input type="file" class="campo" id="residencia" name="residencia[]"/>
														<br class="clear"/>
													</p>
													
													<p class="selecao">
														<label class="nobgr"><?php echo $tipoAnexo[5] == "ok" ? 'cadastrado' : 'opcional';?></label>
														<label class="titulo-selecao">Certidão de estado cívil:</label>
														<input type="file" class="campo" id="certidao" name="certidao[]"/>
														<br class="clear"/>
													</p>
													
													<p class="selecao">
														<label class="<?php echo $tipoAnexo[6] == "ok" ? 'nobgr' : 'obgr';?>"><?php echo $tipoAnexo[6] == "ok" ? 'cadastrado' : 'obrigatório';?></label>
														<label class="titulo-selecao">Comprovante do sinal de arras:</label>
														<input type="file" class="campo" id="sinal" name="sinal[]" <?php echo $tipoAnexo[6] == "ok" ? '' : 'required';?>/>
														<br class="clear"/>
													</p>
													
													<p class="selecao">
														<label class="nobgr">opcional</label>
														<label class="titulo-selecao">Documento adicional:</label>
														<input type="file" class="campo" id="adicional" name="adicional[]"/>
														<br class="clear"/>
													</p>
													
													<input class="botao-salvar" type="submit" value="Salvar Anexos" name="salvarAnexos"/>
												</form>	
											</div>											
											<div id="mostra-anexos">
<?php
					$sqlAnexos = "SELECT * FROM contratosAnexos WHERE codContrato = ".$dadosContrato['codContrato']." and tipoContratoAnexo != 99 ORDER BY dataContratoAnexo DESC LIMIT 0,1";
					$resultAnexos = $conn->query($sqlAnexos);
					$dadosAnexos = $resultAnexos->fetch_assoc();
					
					if($dadosAnexos['codContratoAnexo'] != ""){
?>
												<table id="tabela-lotes">
													<tr class="tr-titulo">
														<th>Nome do Anexo</th>
														<th>Tipo do Anexo</th>
														<th>Data do Anexo</th>
														<th>Baixar Anexo</th>
														<th>Excluir Anexo</th>
													</tr>
<?php
						$cont = 0;
						
						$sqlAnexos = "SELECT * FROM contratosAnexos WHERE codContrato = ".$dadosAnexos['codContrato']." and tipoContratoAnexo != 99 ORDER BY dataContratoAnexo DESC, tipoContratoAnexo ASC";
						$resultAnexos = $conn->query($sqlAnexos);
						while($dadosAnexos = $resultAnexos->fetch_assoc()){
							$cont++;
							
							if($cont == 2){
								$cont = 0;
								$backgroundColor = "background-color:#f5f5f5;";
							}else{
								$backgroundColor = "background-color:#e6e6e6;";
							}
							
							if($dadosAnexos['tipoContratoAnexo'] == 1){
								$tipo = "Intenção de venda assinada";
							}else
							if($dadosAnexos['tipoContratoAnexo'] == 2){
								$tipo = "CPF e RG ou CNH";
							}else
							if($dadosAnexos['tipoContratoAnexo'] == 3){
								$tipo = "CPF e RG ou CNH - Cônjuge ou 2º Comprador(a)";
							}else
							if($dadosAnexos['tipoContratoAnexo'] == 4){
								$tipo = "Comprovante de residência";
							}else
							if($dadosAnexos['tipoContratoAnexo'] == 5){
								$tipo = "Certidão de estado cívil";
							}else
							if($dadosAnexos['tipoContratoAnexo'] == 6){
								$tipo = "Comprovante do sinal de arras";
							}else
							if($dadosAnexos['tipoContratoAnexo'] == 7){
								$tipo = "Documento adicional";
							}
?>												
													<tr class="tr-lista" style="<?php echo $backgroundColor;?>">
														<td><?php echo $dadosAnexos['nomeContratoAnexo'];?></td>
														<td><?php echo $tipo;?></td>
														<td style="text-align:center;"><?php echo data($dadosAnexos['dataContratoAnexo']);?></td>
														<td class="botao"><a target="_blank" href="<?php echo $configUrlGer.'f/contratosAnexo/'.$dadosAnexos['codContrato'].'-'.$dadosAnexos['codContratoAnexo'].'-O.'.$dadosAnexos['extContratoAnexo'];?>">Baixar Anexo</a></td>
														<td style="padding:0px; cursor:pointer;"><a onClick="confirmarExclusao(<?php echo $dadosAnexos['codContratoAnexo'];?>, '<?php echo $dadosAnexos['nomeContratoAnexo'];?>');"><img style="display:table; margin:0 auto;" src="<?php echo $configUrl;?>f/i/quebrado/excluir.svg" width="35"/></a></td>
													</tr>
<?php
						}
?>
												</table>
												<script type="text/javascript">
													function confirmarExclusao(cod, nome) {
														const confirmar = confirm("Você realmente deseja excluir o anexo "+nome+"?");												
														if (confirmar){
															window.location.href = "<?php echo $configUrl.'minha-conta/negociacoes/'.$url[4].'/excluir/"+cod+"/';?>";
														}
													}
												</script>																							
<?php
					}else{
?>
												<p class="msg">Nenhum anexo encontrado!</p>
<?php				
					}
?>
											</div>
										</div>
<?php
				}
			}
		}
?>
									</div>
								</div>
							</div>
<?php
	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login/'>";
	}
?>
