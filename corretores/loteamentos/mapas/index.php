<?php
	ob_start();
	session_start();
	
	include('../../f/conf/config.php');
	
	if(isset($_GET['loteamento'])){
		$loteamento = $_GET['loteamento'];
	}

	$_SESSION['voltaMapa'] = $loteamento;
			
	if($_COOKIE['codAprovado'.$cookie] != ""){

		if($loteamento != ""){
			if($loteamento == 9){
				$mapa = "mapa-belmar.jpg";
				$sizeCircle = 15;
				$fontSize = "16px";
			}else
			if($loteamento == 25){
				$mapa = "mapa-xangrila.jpg";
				$sizeCircle = 12;
				$fontSize = "15px";
			}else
			if($loteamento == 32){
				$mapa = "mapa-portofino.jpg";
				$sizeCircle = 30;
				$fontSize = "20px";
			}else
			if($loteamento == 37){
				$mapa = "mapa-capao-bonito.png";
				$sizeCircle = 15;
				$fontSize = "16px";
			}
			
			$sqlLoteamento = "SELECT * FROM loteamentos WHERE codLoteamento = ".$loteamento." ORDER BY codLoteamento LIMIT 0,1";
			$resultLoteamento = $conn->query($sqlLoteamento);
			$dadosLoteamento = $resultLoteamento->fetch_assoc();
			
			$sqlLotes = "SELECT L.*, Q.* FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra WHERE L.codLoteamento = ".$dadosLoteamento['codLoteamento']." ORDER BY L.codLote ASC";
			$resultLotes = $conn->query($sqlLotes);
			while($dadosLotes = $resultLotes->fetch_assoc()){
				
				$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = ".$dadosLotes['codLote']." and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
				$resultReservas = $conn->query($sqlReservas);
				$dadosReservas = $resultReservas->fetch_assoc();
				
				$chaveLote = $dadosLotes['nomeQuadra'].$dadosLotes['nomeLote']; 	
				
				if($ddosLoteamento['vendidoLote'] == "T"){
					$status[$chaveLote] = "V";
				}else
				if($dadosReservas['codLoteReserva'] == ""){
					$status[$chaveLote] = "D";
				}else
				if($dadosReservas['statusLoteReserva'] != ""){
					$status[$chaveLote] = "R";
				}else{
					$status[$chaveLote] = "V";
				}
			
			}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $dadosLoteamento['nomeLoteamento'];?> - <?php echo $nomeEmpresa;?></title>
	<link rel="shortcut icon" href="<?php echo $configUrl;?>f/i/icon.png" />    
	<script src="https://code.jquery.com/jquery-1.11.3.js"></script>
    <script src="https://d3js.org/d3.v7.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            overflow: hidden; /* Impede rolagem */
            display: flex;
            justify-content: center; /* Centraliza horizontalmente */
            align-items: flex-start; /* Alinha no topo verticalmente */
            height: 100vh; /* Altura da viewport */
            font-family:Sans-serif;
        }
        
        svg {
            cursor:drag;
            border: 1px solid #ccc; /* Apenas para visualização */
            width: 100%; /* Largura total */
            height: 100vh; /* Altura total da tela */
            cursor:move;
        }    
    </style>
</head>
<body>		
    <svg id="canvas"></svg>
    
    <script>
        const svg = d3.select("#canvas");
        let imgWidth, imgHeight;
        const imgUrl = "<?php echo $mapa;?>";
        const img = new Image();
        img.src = imgUrl;
        img.onload = () => {
            imgWidth = img.width;
            imgHeight = img.height;

            const screenWidth = window.innerWidth;
            const initialScale = Math.min(screenWidth / imgWidth, 1);
            const minScale = initialScale;

            svg.attr("width", screenWidth)
               .attr("height", window.innerHeight);

            const g = svg.append("g")
                .attr("transform", `translate(${(screenWidth - imgWidth * initialScale) / 2}, 0) scale(${initialScale})`); // Ajuste inicial no topo

            g.append("image")
                .attr("xlink:href", imgUrl)
                .attr("width", imgWidth)
                .attr("height", imgHeight)
                .attr("preserveAspectRatio", "xMinYMin meet")
                .attr("x", 0)
                .attr("y", 0);

            const areas = [
<?php
			$sqlLotesCoords = "SELECT * FROM lotesCoords WHERE codLoteamento = ".$dadosLoteamento['codLoteamento']." ORDER BY codLoteCoord ASC";
			$resultLotesCoords = $conn->query($sqlLotesCoords);
			while($dadosLotesCoords = $resultLotesCoords->fetch_assoc()){

				$sqlLotes = "SELECT L.*, Q.* FROM lotes L inner join quadras Q on L.codQuadra = Q.codQuadra WHERE L.statusLote = 'T' and L.nomeLote = '".$dadosLotesCoords['lote']."' and Q.nomeQuadra = '".$dadosLotesCoords['quadra']."' and L.codLoteamento = ".$dadosLotesCoords['codLoteamento']." ORDER BY L.codLote ASC";
				$resultLotes = $conn->query($sqlLotes);
				$dadosLotes = $resultLotes->fetch_assoc();
				
				if($dadosLotes['codLote'] != ""){
						
					$sqlReservas = "SELECT * FROM lotesReservas WHERE codLote = '".$dadosLotes['codLote']."' and dataOutLoteReserva IS NULL ORDER BY codLoteReserva DESC LIMIT 0,1";
					$resultReservas = $conn->query($sqlReservas);
					$dadosReservas = $resultReservas->fetch_assoc();
					
					$chaveLote = $dadosLotes['nomeQuadra'].$dadosLotes['nomeLote']; 	
					
					if($dadosLotes['vendidoLote'] == "T"){
						$status = "V";
						$corretor = 0;
					}else
					if($dadosReservas['codLoteReserva'] == ""){
						$status = "D";
						$corretor = 0;
					}else
					if($dadosReservas['statusLoteReserva'] != ""){
						$status = "R";
						$corretor = $dadosReservas['codCorretor'];
					}else{
						$status = "V";
						$corretor = 0;
					}
					$existe = "T";		
				}else{
					$status = "V";
					$existe = "F";
					$corretor = 0;
				}
				
				$libera = "";

				if($dadosReservas['codLoteReserva'] == ""){
				
					$sqlUltima = "SELECT * FROM lotesReservas WHERE codCorretor = '".$_COOKIE['codAprovado'.$cookie]."' and codLote = '".$dadosLotes['codLote']."' ORDER BY codLoteReserva DESC LIMIT 0,1";
					$resultUltima = $conn->query($sqlUltima);
					$dadosUltima = $resultUltima->fetch_assoc();
					
					if($dadosUltima['codLoteReserva'] != ""){
					
						$dateTime = new DateTime($dadosUltima['dataOutLoteReserva']);
						$dateTime->modify('+24 hours');
						$dataLibera = $dateTime->format('Y-m-d H:i:s');
						
						if($dataLibera <= date('Y-m-d')){
							$libera = "";
						}else{
							$libera = $dataLibera;
						}	
					}					
				}				
				
				if($existe == "T"){
?>
                {cod: "<?php echo $dadosLotesCoords['quadra'].$dadosLotesCoords['lote'];?>", coords: [<?php echo $dadosLotesCoords['x1'].", ".$dadosLotesCoords['y1'].", ".$dadosLotesCoords['x2'].", ".$dadosLotesCoords['y2'];?>, 38, 2188, 191], href:"javascript: chamaLote('<?php echo $dadosLotesCoords['lote'];?>', '<?php echo $dadosLotesCoords['quadra'];?>', <?php echo $dadosLotesCoords['codLoteamento'];?>, '<?php echo $status;?>', <?php echo $corretor;?>, '<?php echo $libera;?>')", status: "<?php echo $status != '' ? $status : 'V';?>", numero: "<?php echo $dadosLotesCoords['lote'];?>" },
<?php
				}else{
?>
                {cod: "<?php echo $dadosLotesCoords['quadra'].$dadosLotesCoords['lote'];?>", coords: [<?php echo $dadosLotesCoords['x1'].", ".$dadosLotesCoords['y1'].", ".$dadosLotesCoords['x2'].", ".$dadosLotesCoords['y2'];?>, 38, 2188, 191], href:"javascript: chamaLote(0, 0, 0, '', 0, '')", status: "V", numero: "<?php echo $dadosLotesCoords['lote'];?>" },
<?php			
				}		
			}	
?>                
            ];
            

			areas.forEach(area => {
				const [x1, y1, x2, y2] = area.coords;

				const centerX = (x1 + x2) / 2;
				const centerY = (y1 + y2) / 2;

				let fillColor;
				if (area.status === 'D') {
					fillBackColor = "#91b16c";
					fillColor = "#FFF";
				} else if (area.status === 'V') {
					fillBackColor = "#FF0000";
					fillColor = "#FFF";
				} else if (area.status === 'R') {
					fillBackColor = "yellow";
					fillColor = "#000";
				}

				const linkGroup = g.append("a")
					.attr("href", area.href)  // Define o link para o lote

				linkGroup.append("rect")
					.attr("x", x1)
					.attr("y", y1)
					.attr("width", x2 - x1)
					.attr("height", y2 - y1)
					.attr("fill", "transparent") // Retângulo transparente
					.attr("cursor", "pointer"); // Mostra que o retângulo é clicável
                
				linkGroup.append("circle")
					.attr("cx", centerX)
					.attr("cy", centerY)
					.attr("r", <?php echo $sizeCircle;?>)
					.attr("fill", fillBackColor);

				linkGroup.append("text")
					.attr("x", centerX)
					.attr("y", centerY + 1)
					.attr("text-anchor", "middle")
					.attr("dominant-baseline", "middle")
					.attr("fill", fillColor)
					.attr("font-size", "<?php echo $fontSize;?>")
					.text(area.numero);
			});

			const zoom = d3.zoom()
				.scaleExtent([0.45, 10])
				.on("zoom", (event) => {
					const transform = event.transform;

					g.attr("transform", `translate(${transform.x}, ${transform.y}) scale(${transform.k})`);
				});

			d3.select("svg")
				.call(zoom);

            svg.call(zoom).call(zoom.transform, d3.zoomIdentity.translate((screenWidth - imgWidth * initialScale) / 2, 0).scale(initialScale)); // Define a transformação inicial

            window.addEventListener('resize', () => {
                const newWidth = window.innerWidth;
                const newHeight = window.innerHeight;

                svg.attr("width", newWidth).attr("height", newHeight);

                const newTranslateX = (newWidth - imgWidth * initialScale) / 2;
                const newTranslateY = 0;
                svg.call(zoom.transform, d3.zoomIdentity.translate(newTranslateX, newTranslateY).scale(initialScale));
                g.attr("transform", `translate(${newTranslateX}, ${newTranslateY}) scale(${initialScale})`);
            });
        };       
        
        function chamaLote(lote, quadra, loteamento, status, corretor, tempo){
			var $tg = jQuery.noConflict();
			if(lote != 0 && quadra != 0 && loteamento != 0 && status != "V"){
				$tg.post("<?php echo $configUrl;?>loteamentos/seleciona-lote.php", {lote: lote, quadra: quadra, loteamento: loteamento}, function(data){
					perguntaNotifica(data.trim(), status, corretor, tempo);
				});				
			}else{
				if(status == "V"){
					Swal.fire('Aviso', 'Este lote já foi vendido!', 'warning');
				}else{
					Swal.fire('Aviso', 'Lote indisponível!', 'warning');
				}
			}
		}
								
												function buscaLoteData(codLote) {
												  return fetch('<?php echo $configUrl;?>loteamentos/busca-lote.php', {
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

												let countdownInterval = null; // Variável global para o intervalo

												function startCountdown(targetDate, callback) {
													let targetTime = new Date(targetDate).getTime();

													// Limpa qualquer contagem regressiva anterior antes de iniciar uma nova
													if (countdownInterval) {
														clearInterval(countdownInterval);
													}

													countdownInterval = setInterval(() => {
														// Obtém o tempo atual
														let now = new Date().getTime();

														// Calcula o tempo restante
														let timeLeft = targetTime - now;

														if (timeLeft <= 0) {
															clearInterval(countdownInterval); // Para o intervalo quando o tempo acabar
															countdownInterval = null; // Reseta a variável
															callback("00:00:00"); // Define o valor final para 00:00:00
														} else {
															// Converte o tempo restante para horas, minutos e segundos
															let hours = Math.floor(timeLeft / (1000 * 60 * 60));
															let minutes = Math.floor((timeLeft % (1000 * 60 * 60)) / (1000 * 60));
															let seconds = Math.floor((timeLeft % (1000 * 60)) / 1000);

															// Formata a contagem regressiva
															let countdownString = `${padZero(hours)}:${padZero(minutes)}:${padZero(seconds)}`;

															// Chama o callback para atualizar o valor da variável
															callback(countdownString);
														}
													}, 1000);
												}

												function stopCountdown() {
													if (countdownInterval) {
														clearInterval(countdownInterval); // Para o intervalo
														countdownInterval = null; // Reseta a variável
													}
												}

												// Função auxiliar para adicionar zeros à esquerda
												function padZero(num) {
													return num < 10 ? `0${num}` : num;
												}
																		
												function perguntaNotifica(codLote, status, corretor, tempo) {
													const countdownValue = "";
													if(status == "V"){
														Swal.fire('Aviso', 'Este lote já foi vendido!', 'warning');
													}else{													
														stopCountdown();
														  var corretorLogado = <?php echo $_COOKIE['codAprovado'.$cookie];?>;
														  buscaLoteData(codLote).then((data) => {
															if (data) {
															  Swal.fire({
																title: '<span style="color:#243468; font-size:20px;">Informações do Lote</span>',
																html: `
																<div class="swal-custom-popup">
																  <div style="display: flex; justify-content: space-between;">
																	<div style="width: 48%; border-right: 1px solid #ccc; text-align:left; padding-right: 20px;">
																	  <p style="border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;">
																		<strong style="font-size:16px; color:#243468; font-weight:600;">Lote:</strong> ${data.nomeLote} 
																	  </p>
																	  <p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#243468; font-weight:600;">Quadra: </strong>${data.nomeQuadra}</p>
																	  <p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#243468; font-weight:600;">Bairro: </strong>${data.bairro}</p>
																	  <p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#243468; font-weight:600;">Posição Solar:</strong> ${data.posicaoSolar}</p>
																	  <p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#243468; font-weight:600;">Área m²: </strong>${data.frenteFundo}</p>
																	  ${data.obs ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;"><strong style="font-size:15px; color:#243468; font-weight:600;">Observação: </strong>${data.obs}</p>` : ''}
																	</div>
																	<div style="width: 48%; padding-left: 20px; text-align:left;">
																	  ${data.desconto > 0 ? `<p style="border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;">
																		<strong style="font-size:15px; color:#243468; font-weight:600;">Valor total:</strong> ${data.valor}
																	  </p>
																	  <p style="padding-bottom:5px; margin-bottom:5px;">
																		<strong style="font-size:15px; color:#243468; font-weight:600;">Valor a vista:</strong> <span style="font-size:15px;">${data.valorVista} (- ${data.desconto}%)</span>
																	  </p>` : ''}
																	  ${data.desconto == 0 ? `<p style="border-bottom:1px solid #ccc; padding-bottom:5px; margin-bottom:5px;">
																		<strong style="font-size:16px; color:#243468; font-weight:600;">Valor a vista:</strong> ${data.valor}
																	  </p>` : ''}
																	  ${data.entrada ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#243468; font-weight:600;">Entrada:</strong> R$ ${data.entrada}
																	  </p>` : ''}
																	  
																	  ${parseFloat(data.taxa.trim()) > 0 ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#243468; font-weight:600;">Taxa:</strong> ${data.taxa}%
																	  </p>` : ''}
																	  
																	  ${data.parcelas ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#243468; font-weight:600;">Parcelas:</strong> ${data.parcelas}
																	  </p>` : ''}
																	  
																	  ${data.valor_parcela ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#243468; font-weight:600;">Valor da Parcela:</strong> ${data.valor_parcela}
																	  </p>` : ''}
																	  
																		${data.reforcos ? `<p style="margin:0; padding:0; font-size:15px; padding-bottom:10px;">
																		<strong style="font-size:15px; color:#243468; font-weight:600;">Reforços Anuais:</strong> ${data.reforcos}
																	  </p>` : ''}																	  
																	</div>					
																  </div>
																  <br/>
																  <p>
																	${data.unido == 'T' ? `<strong style="color:#FF0000; font-size:16px;">Este lote possui união com um ou mais lotes!</strong><br/><br/>` : ''}																	  
																	${data.taxa ? `Faça uma nova simulação abaixo:<br/>
																	<a target='_blank' style='color:#243468; text-decoration:underline; display:block;' href='https://www.idinheiro.com.br/calculadoras/calculadora-financiamento-price/'>
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
																cancelButtonText: tempo != "" ? 'Reservar em 00:00:00' : (status === "R" && corretor === corretorLogado) ? 'Cancelar Reserva' : (status === "D" ? 'Fazer Reserva' : 'Reservado'),
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
																  if(tempo != ""){
																	cancelButton.style.backgroundColor = '#ccc';
																	cancelButton.style.color = '#000';
																	cancelButton.style.cursor = 'pointer';
																	cancelButton.disabled = false;																  
																  }else
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
																	if(tempo != ""){
																		bloqueado(tempo);
																	}else{
																		reservarLote(codLote); // Chama a função de reserva, exceto se o status for 'R'
																	}
																}
															  });
															  
																if(tempo != ""){
																	startCountdown(tempo, function(countdownValue) {
																		regressivo = countdownValue;
																		document.querySelector('.swal2-cancel').textContent = "Reservar em "+regressivo;
																	});
																}														  
															}
														});
													}
												}		

												function bloqueado(tempo) {
													var $tgs = jQuery.noConflict();

													Swal.fire({
														title: 'Reserva de Lote',
														allowOutsideClick: false,
														html: '<p class="texto" style="font-size:15px; text-align:center;">Você não pode realizar a reserva deste lote pois você realizou uma recentemente! Aguarde o tempo abaixo para reservar novamente</p><p class="countdown" style="margin-top:20px; font-size:20px; font-weight:bold;">Disponível em 00:00:00</p>'
													});

													startCountdown(tempo, function(countdownValue) {
														regressivo = countdownValue;
														console.log("Contagem regressiva:", regressivo); // Exibe a contagem a cada segundo
														// Você pode atualizar o HTML com a variável 'regressivo'
														document.querySelector('.countdown').textContent = "Disponível em "+regressivo;
													});														
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
													location.href="<?php echo $configUrl.'loteamentos/'.$url[3].'/';?>";
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

    <p class="sombra" style="display:none;"></p>
	<form id="formContrato" action="<?php echo $configUrl;?>minha-conta/negociacoes/" method="post" target="_parent">
		<input type="hidden" value="" name="loteContrato" id="loteContrato"/>
	</form>	

</body>
</html>
<?php
		}else{
			echo "Adicione um loteamento a url!";
		}
	}else{
		echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrl."login/'>";		
	}
?>
