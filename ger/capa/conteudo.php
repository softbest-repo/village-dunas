				<div id="dados-conteudo">
<?php
$codUsuario = $_COOKIE['codAprovado'.$cookie];
$sqlNovosImoveis = "SELECT i.codImovel, i.nomeImovel, i.precoImovel, b.nomeBairro, c.nomeCidade, i.quartosImovel, i.banheirosImovel, i.suiteImovel, i.garagemImovel, i.metragemImovel, t.nomeTipoImovel, i.dataCadastroImovel FROM imoveis i LEFT JOIN tipoImovel t ON i.codTipoImovel = t.codTipoImovel LEFT JOIN cidades c ON i.codCidade = c.codCidade LEFT JOIN bairros b ON i.codBairro = b.codBairro WHERE DATE(i.dataCadastroImovel) <= CURDATE() AND NOT EXISTS (SELECT 1 FROM imoveisNotifica n WHERE n.codImovel = i.codImovel AND n.codUsuario = $codUsuario) ORDER BY i.dataCadastroImovel DESC LIMIT 10";
$resultNovosImoveis = $conn->query($sqlNovosImoveis);
if ($resultNovosImoveis === false) {
    echo '<div style="color:red; font-weight:bold;">Erro ao buscar novos imóveis: ' . htmlspecialchars($conn->error) . '</div>';
} else {
    $novosImoveis = [];
    if ($resultNovosImoveis->num_rows > 0) {
        while ($row = $resultNovosImoveis->fetch_assoc()) {
            if (date('Y-m-d', strtotime($row['dataCadastroImovel'])) <= date('Y-m-d')) {
                $novosImoveis[] = $row;
            }
        }
    }
    $imoveisParaExibir = [];
    foreach ($novosImoveis as $imovel) {
        $codImovel = intval($imovel['codImovel']);
        if (!empty($codUsuario)) {
            $codUsuarioInt = intval($codUsuario);
            $sqlVerifica = "SELECT 1 FROM imoveisNotifica WHERE codImovel = $codImovel AND codUsuario = $codUsuarioInt LIMIT 1";
        } else {
            $sqlVerifica = "SELECT 1 FROM imoveisNotifica WHERE codImovel = $codImovel LIMIT 1";
        }
        $resultVerifica = $conn->query($sqlVerifica);
        if ($resultVerifica && $resultVerifica->num_rows == 0) {
            if (!empty($codUsuario)) {
                $sqlInsere = "INSERT INTO imoveisNotifica (codImovelNotifica, codImovel, codUsuario) VALUES (0, $codImovel, $codUsuarioInt)";
                $conn->query($sqlInsere);
            }
            $imoveisParaExibir[] = $imovel;
        }
    }
    if (count($imoveisParaExibir) > 0) {
        ob_start();
        echo '<div style="max-height:350px;overflow-y:auto;">';
        foreach ($imoveisParaExibir as $imovel) {
            $sqlImagem = "SELECT * FROM imoveisImagens WHERE codImovel = ".$imovel['codImovel']." ORDER BY ordenacaoImovelImagem ASC LIMIT 0,1";
            $resultImagem = $conn->query($sqlImagem);
            $dadosImagem = $resultImagem ? $resultImagem->fetch_assoc() : null;
            if ($dadosImagem && !empty($dadosImagem['codImovelImagem'])) {
                $foto = $configUrlGer.'f/imoveis/'.$dadosImagem['codImovel'].'-'.$dadosImagem['codImovelImagem'].'-W.webp';
            } else {
                $foto = $configUrlGer.'f/i/sem-foto.gif';
            }
            $link = $configUrlGer . 'cadastros/imoveis/alterar/' . $imovel['codImovel']."/";
            $infoItens = [];
            if (!empty($imovel['quartosImovel']) && $imovel['quartosImovel'] > 0) {
                $infoItens[] = $imovel['quartosImovel'] . ' quarto' . ($imovel['quartosImovel'] > 1 ? 's' : '');
            }
            if (!empty($imovel['banheirosImovel']) && $imovel['banheirosImovel'] > 0) {
                $infoItens[] = $imovel['banheirosImovel'] . ' banheiro' . ($imovel['banheirosImovel'] > 1 ? 's' : '');
            }
            if (!empty($imovel['suiteImovel']) && $imovel['suiteImovel'] > 0) {
                $infoItens[] = $imovel['suiteImovel'] . ' suíte' . ($imovel['suiteImovel'] > 1 ? 's' : '');
            }
            if (!empty($imovel['garagemImovel']) && $imovel['garagemImovel'] > 0) {
                $infoItens[] = $imovel['garagemImovel'] . ' vaga' . ($imovel['garagemImovel'] > 1 ? 's' : '');
            }
            ?>
            <div class="swal-imovel-card">
                <img src="<?php echo htmlspecialchars($foto); ?>" alt="Foto Imóvel" class="swal-imovel-img">
                <div class="swal-imovel-info-bloco">
                    <div class="swal-imovel-nome"><?php echo htmlspecialchars($imovel['nomeImovel']); ?></div>
                    <div class="swal-imovel-tipo"><?php echo htmlspecialchars($imovel['nomeTipoImovel']); ?></div>
                    <?php if (count($infoItens) > 0): ?>
                        <div class="swal-imovel-info"><?php echo implode(', ', $infoItens); ?></div>
                    <?php endif; ?>
                    <?php if (!empty($imovel['metragemImovel']) && $imovel['metragemImovel'] > 0): ?>
                        <div class="swal-imovel-info"><?php echo $imovel['metragemImovel']; ?>m²</div>
                    <?php endif; ?>
                    <div class="swal-imovel-preco">Valor: R$ <?php echo number_format($imovel['precoImovel'], 2, ',', '.'); ?></div>
                    <div class="swal-imovel-local"><?php echo htmlspecialchars($imovel['nomeBairro']) . ' - ' . htmlspecialchars($imovel['nomeCidade']); ?></div>
                    <a href="<?php echo $link; ?>" style="color: #fff;" target="_blank" class="swal-imovel-link">Ver detalhes</a>
                </div>
            </div>
            <?php
        }
        echo '</div>';
        $htmlImoveis = ob_get_clean();
    ?>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-novos-imoveis {
            border-radius: 16px !important;
            box-shadow: 0 8px 32px rgba(36,83,124,0.15) !important;
            background: #f8fafc !important;
            padding: 0 !important;
        }
        .swal2-novos-imoveis .swal2-title {
            color: #24537c !important;
            font-size: 1.7rem !important;
            font-weight: bold !important;
            margin-bottom: 18px !important;
        }
        .swal-imovel-card {
            display: flex;
            align-items: flex-start;
            margin-bottom: 15px;
            border-bottom: 1px solid #e3e8ee;
            padding-bottom: 10px;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(36,83,124,0.04);
            padding: 10px;
            transition: box-shadow 0.2s;
        }
        .swal-imovel-card:hover {
            box-shadow: 0 4px 16px rgba(36,83,124,0.10);
        }
        .swal-imovel-img {
            width: 140px;
            height: 105px;
            object-fit: cover;
            border-radius: 6px;
            margin-right: 22px;
            border: 1px solid #e3e8ee;
            background: #f5f5f5;
            flex-shrink: 0;
        }
        .swal-imovel-info-bloco {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            text-align: left;
            width: 100%;
        }
        .swal-imovel-nome {
            font-weight: bold;
            font-size: 17px;
            color: #24537c;
            margin-bottom: 2px;
            text-align: left;
        }
        .swal-imovel-tipo {
            color: #1e88e5;
            font-size: 14px;
            margin-bottom: 2px;
            text-align: left;
        }
        .swal-imovel-info {
            color: #444;
            font-size: 13px;
            margin-bottom: 1px;
            text-align: left;
        }
        .swal-imovel-preco {
            color: #388e3c;
            font-size: 15px;
            font-weight: bold;
            margin-bottom: 2px;
            text-align: left;
        }
        .swal-imovel-local {
            color: #666;
            font-size: 13px;
            margin-bottom: 2px;
            text-align: left;
        }
        .swal-imovel-link {
            color: #fff;
            background: #1e88e5;
            font-size: 13px;
            text-decoration: none;
            padding: 5px 12px;
            border-radius: 5px;
            font-weight: 500;
            transition: background 0.2s;
            display: inline-block;
            margin-top: 4px;
            text-align: left;
        }
        .swal-imovel-link a {
            color: #fff;
            display:block;
        }
        .swal-imovel-link:hover {
            background: #1565c0;
        }
        .swal2-actions {
            padding-bottom: 18px !important;
        }
        @media (max-width: 600px) {
            .swal2-novos-imoveis {
                width: 98vw !important;
                min-width: unset !important;
                max-width: 98vw !important;
            }
            .swal-imovel-card {
                flex-direction: column;
                align-items: flex-start;
            }
            .swal-imovel-img {
                margin-bottom: 8px;
                margin-right: 0;
                width: 100%;
                height: 180px;
            }
            .swal-imovel-info-bloco {
                width: 100%;
            }
        }
    </style>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Novos Imóveis Disponíveis!',
                html: <?php echo json_encode($htmlImoveis); ?>,
                icon: 'info',
                confirmButtonText: 'OK',
                width: 650,
                background: '#f8fafc',
                showCloseButton: true,
                scrollbarPadding: false,
                customClass: {
                    popup: 'swal2-novos-imoveis'
                }
            });
        });
    </script>
    <?php
    }
}
?>

<?php
	$area = "usuarios";
	if(validaAcesso($conn, $area) == "ok" && $filtraUsuario == ""){	
?>						
						<div id="bloco-compromissos">
							<p class="frase" style="color:#24537c;">Check-in Diário</p>							
							<div id="fundo-compromissos">
								<table style="width:100%;">
									<tr style="width:100%; background-color:#24537c;">
										<th style="width:25%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-left-radius:5px;">Corretor</th>
										<th style="width:15%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px;">Horário Check-in</th>
										<th style="width:15%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px;">Último Lead</th>
										<th style="width:10%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px;">Leads Aguardando</th>
										<th style="width:10%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px;">Leads Atendidos</th>
										<th style="width:10%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px;">Leads Recebidos</th>
										<th style="width:10%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:5px;">Excluir Check-in</th>
									</tr>
								</table>
								<div id="bloco-rola" style="width:100%; max-height:500px; overflow-y:auto;">
									<table style="width:100%;">
<?php		
			$sqlUsuariosLeads = "SELECT u.codUsuario, u.nomeUsuario, ul.dataUsuarioLogin, COUNT(ulds.codLead) AS totalLeadsRecebidos, SUM(CASE WHEN ulds.statusUsuarioLead = 'T' THEN 1 ELSE 0 END) AS totalLeadsAtendidos, SUM(CASE WHEN ulds.statusUsuarioLead = 'A' THEN 1 ELSE 0 END) AS totalLeadsEmAtendimento, (SELECT MAX(ulds2.dataUsuarioLead) FROM usuariosLeads ulds2 WHERE ulds2.codUsuario = u.codUsuario) AS ultimaInteracao FROM usuarios u INNER JOIN usuariosLogins ul ON u.codUsuario = ul.codUsuario LEFT JOIN usuariosLeads ulds ON u.codUsuario = ulds.codUsuario AND DATE(ulds.dataUsuarioLead) = CURDATE() WHERE ".$filtraUsuarioGerente." ul.dataUsuarioLogin >= CONCAT(CURDATE(), ' $limiteCheckin') AND ul.dataUsuarioLogin < CONCAT(DATE_ADD(CURDATE(), INTERVAL 1 DAY), ' $limiteCheckin') GROUP BY u.codUsuario, u.nomeUsuario, ul.dataUsuarioLogin ORDER BY ul.dataUsuarioLogin ASC";
			$resultUsuariosLeads = $conn->query($sqlUsuariosLeads);
			while($dadosUsuariosLeads = $resultUsuariosLeads->fetch_assoc()){
				$cont++;
				$contTodos++;
				
				if($cont == 1){
					$background = "#FFF;";
				}else{
					$cont = 0;
					$background = "#f5f5f5;";
				}
				
				$quebraLogin = explode(" ", $dadosUsuariosLeads['dataUsuarioLogin']);
				$quebraLead = explode(" ", $dadosUsuariosLeads['ultimaInteracao']);
				
				if($dadosUsuariosLeads['ultimaInteracao'] <= date('Y-m-d 07:59:59')){
					$leadInteracao = "--";
				}else{
					$leadInteracao = $quebraLead[1];
				}				
?>							
										<tr style="width:100%; background-color:<?php echo $background;?>">
											<th style="width:25%; border-left:1px solid #CCC; color:#31625E; font-weight:normal; font-size:18px; border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><?php echo $dadosUsuariosLeads['nomeUsuario'];?></th>
											<th style="width:15%; color:#31625E; font-weight:normal; border-bottom:1px solid #ccc; font-size:18px; border-right:1px solid #ccc; padding:6px;"><?php echo $quebraLogin[1];?></th>
											<th style="width:15%; color:#31625E; font-weight:normal; border-bottom:1px solid #ccc; font-size:18px; border-right:1px solid #ccc; padding:6px;"><?php echo $leadInteracao;?></th>
											<th style="width:10%; font-weight:normal; font-weight:bold; border-bottom:1px solid #ccc; font-size:18px; color:#31625E; border-right:1px solid #ccc; padding:6px;"><?php echo $dadosUsuariosLeads['totalLeadsEmAtendimento'];?></th>
											<th style="width:10%; font-weight:normal; font-weight:bold; border-bottom:1px solid #ccc; font-size:18px; color:#31625E; border-right:1px solid #ccc; padding:6px;"><?php echo $dadosUsuariosLeads['totalLeadsAtendidos'];?></th>
											<th style="width:10%; font-weight:normal; font-weight:bold; border-bottom:1px solid #ccc; font-size:18px; color:#31625E; border-right:1px solid #ccc; padding:6px;"><?php echo $dadosUsuariosLeads['totalLeadsRecebidos'];?></th>
											<th style="width:10%; font-weight:normal; font-weight:bold; border-bottom:1px solid #ccc; font-size:18px; color:#31625E; border-right:1px solid #ccc; padding:6px;">
												<button 
													class="btn-excluir-checkin" 
													data-codusuario="<?php echo $dadosUsuariosLeads['codUsuario'];?>"
													data-nomeUsuario="<?php echo $dadosUsuariosLeads['nomeUsuario'];?>"
													style="background-color:#FF0000; cursor:pointer; color:#FFF; font-size:13px; padding:3px 10px; border:none; border-radius:3px;">
													Excluir
												</button>
											</th>
										</tr>
<?php
			}
?>
									</table>
									<script>
										document.addEventListener('DOMContentLoaded', function () {
											const botoesExcluir = document.querySelectorAll('.btn-excluir-checkin');
											botoesExcluir.forEach(function(botao) {
												botao.addEventListener('click', function() {
													const codUsuario = this.getAttribute('data-codusuario');
													const nomeUsuario = this.getAttribute('data-nomeUsuario');
													Swal.fire({
														title: 'Tem certeza?',
														text: "Deseja realmente excluir o check-in do corretor "+nomeUsuario+"?",
														icon: 'warning',
														showCancelButton: true,
														confirmButtonColor: '#d33',
														cancelButtonColor: '#3085d6',
														confirmButtonText: 'Sim, excluir!',
														cancelButtonText: 'Cancelar'
													}).then((result) => {
														if (result.isConfirmed) {
															fetch('<?php echo $configUrlGer;?>excluir-checkin.php', {
																method: 'POST',
																headers: {
																	'Content-Type': 'application/x-www-form-urlencoded'
																},
																body: 'codUsuario=' + encodeURIComponent(codUsuario)
															})
															.then(response => response.json())
															.then(data => {
																if(data.status === 'ok'){
																	Swal.fire(
																		'Excluído!',
																		'Check-in excluído com sucesso.',
																		'success'
																	).then(() => {
																		location.reload();
																	});
																}else{
																	Swal.fire(
																		'Erro!',
																		data.mensagem || 'Não foi possível excluir o check-in.',
																		'error'
																	);
																}
															})
															.catch(() => {
																Swal.fire(
																	'Erro!',
																	'Ocorreu um erro ao tentar excluir.',
																	'error'
																);
															});
														}
													});
												});
											});
										});
									</script>
								</div>
<?php	
	if(date('H:i:s') < $limiteCheckin){
		$sqlFila = "SELECT codUsuario FROM fila WHERE loginFila >= CONCAT(CURDATE() - INTERVAL 1 DAY, ' ".$limiteCheckin."') AND loginFila < CONCAT(CURDATE(), ' ".$limiteCheckin."') ORDER BY envioFila ASC, loginFila ASC";
	}else{
		$sqlFila = "SELECT codUsuario FROM fila WHERE loginFila >= CONCAT(CURDATE(), ' ".$limiteCheckin."') AND loginFila < CONCAT(DATE_ADD(CURDATE(), INTERVAL 1 DAY), ' ".$limiteCheckin."') ORDER BY envioFila ASC, loginFila ASC";
	}

	$resultFila = $conn->query($sqlFila);
	$dadosFila = $resultFila->fetch_assoc();

	$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = '".$dadosFila['codUsuario']."' ORDER BY codUsuario ASC LIMIT 0,1";
	$resultUsuario = $conn->query($sqlUsuario);
	$dadosUsuario = $resultUsuario->fetch_assoc();
?>													
								<div id="total">
									<p class="total" style="color:#24537c;">Total de <?php echo $contTodos;?> corretor(es)(as)</p>
									<p class="total" style="color:#24537c; float:left;">Próximo corretor(a) a receber lead: <span style="font-weight:normal; font-size:16px;"><?php echo $dadosUsuario['nomeUsuario'];?></span></p>
									<br class="clear"/>
								</div>
							</div>
						</div>
						<br/>
<?php
	}
?>
<?php
	$area = "compromissos";
	if(validaAcesso($conn, $area) == "ok"){	
?>						
						<div id="bloco-compromissos">
							<p class="frase">Compromissos</p>							
							<div id="fundo-compromissos">
								<table style="width:100%;">
									<tr style="width:100%; background-color:#2E8B57;">
										<th style="width:15%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-left-radius:5px;">Data</th>
										<th style="width:15%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px;">Usuário(s)</th>
										<th style="width:25%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px;">Título</th>
										<th style="width:25%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:5px;">Tipo Compromisso</th>
										<th style="width:10%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:5px;">Status</th>
									</tr>
								</table>
								<div id="bloco-rola" style="width:100%; max-height:500px; overflow-y:auto;">
									<table style="width:100%;">
<?php
		$cont = 0;
		$contTodos = 0;
		
		$sqlCompromissos = "SELECT DISTINCT C.* FROM compromissos C inner join compromissosUsuario CU on C.codCompromisso = CU.codCompromisso WHERE C.dataCompromisso >= '".date('Y-m-d')."' and C.statusCompromisso = 'T' and (CU.codUsuario = ".$_COOKIE['codAprovado'.$cookie]." or C.codUsuario = '0') ORDER BY C.dataCompromisso ASC, C.horaCompromisso ASC, C.codCompromisso ASC LIMIT 0,20";
		$resultCompromissos = $conn->query($sqlCompromissos);
		while($dadosCompromissos = $resultCompromissos->fetch_assoc()){
			
			$sqlTipoCompromisso = "SELECT * FROM tipoCompromisso WHERE codTipoCompromisso = '".$dadosCompromissos['codTipoCompromisso']."' LIMIT 0,1";
			$resultTipoCompromisso = $conn->query($sqlTipoCompromisso);
			$dadosTipoCompromisso = $resultTipoCompromisso->fetch_assoc();
			
			$enviado = "";

			if($dadosCompromissos['statusCompromisso'] == "T"){
				$status = "status-ativo";
				$statusIcone = "ativado";
				$statusPergunta = "desativar";
			}else{
				$status = "status-desativado";
				$statusIcone = "desativado";
				$statusPergunta = "ativar";
			}	
						
			if($dadosCompromissos['codUsuario'] == "0"){
				$enviado = "Todos";
			}else{
				$sqlCompromissoUsuario = "SELECT * FROM compromissosUsuario WHERE codCompromisso = ".$dadosCompromissos['codCompromisso']."";
				$resultCompromissoUsuario = $conn->query($sqlCompromissoUsuario);
				while($dadosCompromissoUsuario = $resultCompromissoUsuario->fetch_assoc()){
					
					$sqlUsuario = "SELECT nomeUsuario FROM usuarios WHERE codUsuario = ".$dadosCompromissoUsuario['codUsuario']." ORDER BY nomeUsuario ASC";
					$resultUsuario = $conn->query($sqlUsuario);
					$dadosUsuario = $resultUsuario->fetch_assoc();
					
					if($enviado == ""){	
						$enviado = $dadosUsuario['nomeUsuario'];	
					}else{
						$enviado .= ", ".$dadosUsuario['nomeUsuario'];
					}
				}						
			}
			
			$cont++;
			$contTodos++;
			
			if($cont == 1){
				$background = "#FFF;";
			}else{
				$cont = 0;
				$background = "#f5f5f5;";
			}
?>							
										<tr style="width:100%; background-color:<?php echo $background;?>">
											<th style="width:15%; border-left:1px solid #CCC; color:#31625E; font-weight:normal; border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><?php echo data($dadosCompromissos['dataCompromisso']);?><br/><?php echo $dadosCompromissos['horaCompromisso'];?></th>
											<th style="width:15%; color:#31625E; font-weight:normal; border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><?php echo $enviado;?></th>
											<th style="width:25%; border-bottom:1px solid #ccc; color:#31625E; font-weight:normal;  border-right:1px solid #ccc; padding:6px;"><?php echo $dadosCompromissos['nomeCompromisso'];?></th>
											<th style="width:25%; font-weight:normal; border-bottom:1px solid #ccc; color:#31625E; border-right:1px solid #ccc; padding:6px;"><?php echo $dadosTipoCompromisso['nomeTipoCompromisso'];?></th>
											<th style="width:10%; font-weight:normal; border-bottom:1px solid #ccc; <?php echo $corTexto;?> border-right:1px solid #ccc; padding:6px;"><a title="Deseja <?php echo $statusPergunta;?> o compromisso <?php echo $dadosCompromissos['nomeCompromisso'];?>" href="<?php echo $configUrlGer;?>comercial/compromissos/ativacao/<?php echo $dadosCompromissos['codCompromisso'];?>/?capa=ok"><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>-branco.gif" alt="icone" width="30"/></a></th>
										</tr>
<?php
		}
?>
									</table>
								</div>	
								<div id="total">
									<p class="botao"><a title="Acessar Compromissos" href="<?php echo $configUrlGer;?>comercial/compromissos/">Acessar Compromissos</a></p>
									<p class="total">Total de <?php echo $contTodos;?> compromissos(s)</p>
									<br class="clear"/>
								</div>
							</div>
						</div>
<?php
	}
?>

					<p style="font-size:24px; color:#718B8F; font-weight:bold; text-align:center; padding-bottom:30px;">Cobranças e Pagamentos do Dia</p>
					<div id="col-esq-conteudo">
<?php	
	$_SESSION['agrupadorNovo'] = "";
	
	$area = "contas-receber";
	if(validaAcesso($conn, $area) == "ok"){	
?>	
						<div id="bloco-receber">
							<p class="frase">Contas a Receber</p>
							<div id="fundo-receber">
								<table style="width:100%;">
									<tr style="width:100%; background-color:#2E6193;">
										<th style="width:30%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-left-radius:5px;">Cliente</th>
										<th style="width:30%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:0px;">Tipo Pagamento</th>
										<th style="width:20%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:0px;">Vencimento</th>
										<th style="width:20%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:5px;">Valor</th>
									</tr>
<?php
	$cont = 0;
	$sqlContaReceber = "SELECT * FROM contas WHERE baixaConta = 'T' and statusConta = 'T' and areaPagamentoConta = 'R' and vencimentoConta <= '".date('Y-m-d')."' ORDER BY vencimentoConta ASC";
	$resultContaReceber = $conn->query($sqlContaReceber);
	while($dadosContaReceber = $resultContaReceber->fetch_assoc()){
		
		$cont++;
		
		if($cont == 1){
			$background = "#FFF;";
		}else{
			$cont = 0;
			$background = "#f5f5f5;";
		}

		$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$dadosContaReceber['codConta']."";
		$resultContaParcial = $conn->query($sqlContaParcial);
		$dadosContaParcial = $resultContaParcial->fetch_assoc();
		
		$valorReceber = $dadosContaReceber['vParcela'] - $dadosContaParcial['registros'];	
		
		$sqlCliente = "SELECT nomeCliente FROM clientes WHERE codCliente = ".$dadosContaReceber['codCliente']." LIMIT 0,1";
		$resultCliente = $conn->query($sqlCliente);
		$dadosCliente = $resultCliente->fetch_assoc();			
		
		$sqlTipoPagamento = "SELECT * FROM tipoPagamento WHERE codTipoPagamento = ".$dadosContaReceber['codTipoPagamento']." ORDER BY codTipoPagamento ASC LIMIT 0,1";
		$resultTipoPagamento = $conn->query($sqlTipoPagamento);
		$dadosTipoPagamento = $resultTipoPagamento->fetch_assoc();	
?>							
									<tr style="width:100%; background-color:<?php echo $background;?>">
										<td style="border-left:1px solid #CCC; border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><?php echo $dadosCliente['nomeCliente'];?></th>
										<td style="border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><?php echo $dadosTipoPagamento['nomeTipoPagamento'];?></th>
										<td style="border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><?php echo data($dadosContaReceber['vencimentoConta']);?></th>
										<td style="border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;">R$ <?php echo number_format($valorReceber,2, ",", ".");?></th>
									</tr>
<?php
		$valorTotal =  $valorTotal + $valorReceber;
	}
?>
								</table>							
								<div id="total">
									<p class="botao"><a title="Acessar Contas a Receber" href="<?php echo $configUrlGer;?>financeiro/contas-receber/">Acessar Contas a Receber</a></p>
									<p class="total">Total de R$ <?php echo number_format($valorTotal, 2);?></p>
									<br class="clear"/>
								</div>								
							</div>
						</div>
<?php
	}
	
	$area = "cheques";
	if(validaAcesso($conn, $area) == "ok"){	
?>						
						<div id="bloco-cheques-receber" style="max-height:359px; min-height:359px;">
							<p class="frase">Cheques a Receber</p>
							<div id="fundo-cheques">
								<table style="width:100%;">
									<tr style="width:100%; background-color:#00007d;">
										<th style="width:60%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-left-radius:5px;">Cliente</th>
										<th style="width:20%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:0px;">Bom para</th>
										<th style="width:20%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:5px;">Valor</th>
									</tr>
								</table>
								<div id="bloco-rola" style="width:100%; max-height:249px; overflow-y:auto;">
									<table style="width:100%;">
<?php
		$valorTotal = 0;
		$cont = 0;

		$sqlCheque1 = "SELECT * FROM cheques CH inner join contasParcial CP on CH.codContaParcial = CP.codContaParcial inner join contas C on CP.codConta = C.codConta WHERE CH.areaCheque = 'R' and CH.statusCheque = 'T' and CH.bomparaCheque <= '".date('Y-m-d')."' ORDER BY CH.bomparaCheque ASC LIMIT 0,30";
		$resultCheque1 =  $conn->query($sqlCheque1);
		while($dadosCheque1 = $resultCheque1->fetch_assoc()){
			
			$cont++;
			
			if($cont == 1){
				$background = "#FFF;";
			}else{
				$cont = 0;
				$background = "#f5f5f5;";
			}
			
			$valorPagar = $dadosCheque1['valorContaParcial'];
			
			$sqlCliente = "SELECT nomeCliente FROM clientes WHERE codCliente = ".$dadosCheque1['codCliente']." LIMIT 0,1";
			$resultCliente = $conn->query($sqlCliente);
			$dadosCliente = $resultCliente->fetch_assoc();

			if($dadosCheque1['statusCheque'] == "T" && $dadosCheque1['bomparaCheque'] <= date("Y-m-d")){
				$corCheque = "color:#FF0000;";
			}else{
				$corCheque = "color:#31625E;";
			}			
?>							
										<tr style="width:100%; background-color:<?php echo $background;?>">
											<th style="width:60%; border-left:1px solid #CCC; font-weight:normal; border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><a style="<?php echo $corCheque;?>" href="<?php echo $configUrl;?>financeiro/cheques/receber/detalhes/<?php echo $dadosCheque1['codCheque'];?>/"><?php echo $dadosCliente['nomeCliente'];?></a></th>
											<th style="width:20%; border-bottom:1px solid #ccc; font-weight:normal;  border-right:1px solid #ccc; padding:6px;"><a style="<?php echo $corCheque;?>" href="<?php echo $configUrl;?>financeiro/cheques/receber/detalhes/<?php echo $dadosCheque1['codCheque'];?>/"><?php echo data($dadosCheque1['bomparaCheque']);?></a></th>
											<th style="width:20%; border-bottom:1px solid #ccc; font-weight:normal;  border-right:1px solid #ccc; padding:6px;"><a style="<?php echo $corCheque;?>" href="<?php echo $configUrl;?>financeiro/cheques/receber/detalhes/<?php echo $dadosCheque1['codCheque'];?>/">R$ <?php echo number_format($valorPagar, 2, ",", ".");?></a></th>
										</tr>
<?php
			if($dadosCheque1['bomparaCheque'] <= date("Y-m-d")){
				$valorTotal =  $valorTotal + $valorPagar;
			}
		}
?>
									</table>
								</div>								
								<div id="total">
									<p class="botao"><a title="Acessar Cheques a Receber" href="<?php echo $configUrlGer;?>financeiro/cheques/recebidos/">Acessar Cheques a Receber</a></p>
									<p class="total">Total:  R$ <?php echo number_format($valorTotal, 2, ",", ".");?></p>
									<br class="clear"/>
								</div>	
							</div>						
						</div>
<?php
	}
?>
						
					</div>
					<div id="col-dir-conteudo">
<?php
	$area = "contas-pagar";
	if(validaAcesso($conn, $area) == "ok"){	
?>	
						<div id="bloco-pagar">
							<p class="frase">Contas a Pagar</p>
							<div id="fundo-pagar">
								<table style="width:100%;">
									<tr style="width:100%; background-color:#FF0000;">
										<th style="width:30%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-left-radius:5px;">Cliente</th>
										<th style="width:30%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:0px;">Tipo Pagamento</th>
										<th style="width:20%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:0px;">Vencimento</th>
										<th style="width:20%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:5px;">Valor</th>
									</tr>
<?php
		$valorTotal = 0;
		$cont = 0;
		$sqlContaPagar = "SELECT * FROM contas WHERE baixaConta = 'T' and statusConta = 'T' and areaPagamentoConta = 'P' and vencimentoConta <= '".date('Y-m-d')."' ORDER BY vencimentoConta ASC";
		$resultContaPagar = $conn->query($sqlContaPagar);
		while($dadosContaPagar = $resultContaPagar->fetch_assoc()){
			
			$cont++;
			
			if($cont == 1){
				$background = "#FFF;";
			}else{
				$cont = 0;
				$background = "#f5f5f5;";
			}

			$sqlContaParcial = "SELECT SUM(valorContaParcial) registros FROM contasParcial WHERE codConta = ".$dadosContaPagar['codConta']."";
			$resultContaParcial = $conn->query($sqlContaParcial);
			$dadosContaParcial = $resultContaParcial->fetch_assoc();
			
			$valorPagar = $dadosContaPagar['vParcela'] - $dadosContaParcial['registros'];
			
			$sqlFornecedor = "SELECT nomeFornecedor FROM fornecedores WHERE codFornecedor = ".$dadosContaPagar['codFornecedor']." LIMIT 0,1";
			$resultFornecedor = $conn->query($sqlFornecedor);
			$dadosFornecedor = $resultFornecedor->fetch_assoc();			
?>							
									<tr style="width:100%; background-color:<?php echo $background;?>">
										<td style="border-left:1px solid #CCC; border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><?php echo $dadosFornecedor['nomeFornecedor'];?></th>
										<td style="border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><?php echo $dadosContaPagar['nomeConta'];?></th>
										<td style="border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><?php echo data($dadosContaPagar['vencimentoConta']);?></th>
										<td style="border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;">R$ <?php echo number_format($valorPagar,2, ",", ".");?></th>
									</tr>
<?php
			$valorTotal =  $valorTotal + $valorPagar;
		}
?>
								</table>							
								<div id="total">
									<p class="botao"><a title="Acessar Contas a Receber" href="<?php echo $configUrlGer;?>financeiro/contas-pagar/">Acessar Contas a Pagar</a></p>
									<p class="total">Total de R$ <?php echo number_format($valorTotal, 2);?></p>
									<br class="clear"/>
								</div>	
							</div>						
						</div>
<?php
	}
	
	$area = "cheques";
	if(validaAcesso($conn, $area) == "ok"){	
?>						
						<div id="bloco-cheques-pagar" style="max-height:359px; min-height:359px;">
							<p class="frase">Cheques a Pagar</p>
							<div id="fundo-cheques">
								<table style="width:100%;">
									<tr style="width:100%; background-color:#8a0000;">
										<th style="width:60%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-left-radius:5px;">Fornecedor</th>
										<th style="width:20%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:0px;">Bom para</th>
										<th style="width:20%; padding:5px; padding-top:8px; padding-bottom:8px; color:#FFF; font-size:15px; border-top-right-radius:5px;">Valor</th>
									</tr>
								</table>
								<div id="bloco-rola" style="width:100%; max-height:249px; overflow-y:auto;">
									<table style="width:100%;">
<?php
		$valorTotal = 0;
		$cont = 0;

		$sqlCheque1 = "SELECT * FROM cheques CH inner join contasParcial CP on CH.codContaParcial = CP.codContaParcial inner join contas C on CP.codConta = C.codConta WHERE CH.areaCheque = 'P' and CH.statusCheque = 'T' and CH.bomparaCheque <= '".date('Y-m-d')."' ORDER BY CH.bomparaCheque ASC LIMIT 0,30";
		$resultCheque1 =  $conn->query($sqlCheque1);
		while($dadosCheque1 = $resultCheque1->fetch_assoc()){
			
			$cont++;
			
			if($cont == 1){
				$background = "#FFF;";
			}else{
				$cont = 0;
				$background = "#f5f5f5;";
			}

			
			$valorPagar = $dadosCheque1['valorContaParcial'];
			
			$sqlFornecedor = "SELECT nomeFornecedor FROM fornecedores WHERE codFornecedor = ".$dadosCheque1['codFornecedor']." LIMIT 0,1";
			$resultFornecedor = $conn->query($sqlFornecedor);
			$dadosFornecedor = $resultFornecedor->fetch_assoc();

			if($dadosCheque1['statusCheque'] == "T" && $dadosCheque1['bomparaCheque'] <= date("Y-m-d")){
				$corCheque = "color:#FF0000;";
			}else{
				$corCheque = "color:#31625E;";
			}			
?>							
										<tr style="width:100%; background-color:<?php echo $background;?>">
											<th style="width:60%; border-left:1px solid #CCC; font-weight:normal; border-bottom:1px solid #ccc; border-right:1px solid #ccc; padding:6px;"><a style="<?php echo $corCheque;?>" href="<?php echo $configUrl;?>financeiro/cheques/pagar/detalhes/<?php echo $dadosCheque1['codCheque'];?>/"><?php echo $dadosFornecedor['nomeFornecedor'];?></a></th>
											<th style="width:20%; border-bottom:1px solid #ccc; font-weight:normal;  border-right:1px solid #ccc; padding:6px;"><a style="<?php echo $corCheque;?>" href="<?php echo $configUrl;?>financeiro/cheques/pagar/detalhes/<?php echo $dadosCheque1['codCheque'];?>/"><?php echo data($dadosCheque1['bomparaCheque']);?></a></th>
											<th style="width:20%; border-bottom:1px solid #ccc; font-weight:normal;  border-right:1px solid #ccc; padding:6px;"><a style="<?php echo $corCheque;?>" href="<?php echo $configUrl;?>financeiro/cheques/pagar/detalhes/<?php echo $dadosCheque1['codCheque'];?>/">R$ <?php echo number_format($valorPagar, 2, ",", ".");?></a></th>
										</tr>
<?php
			if($dadosCheque1['bomparaCheque'] <= date("Y-m-d")){
				$valorTotal =  $valorTotal + $valorPagar;
			}
		}
?>
									</table>
								</div>								
								<div id="total">
									<p class="botao"><a title="Acessar Cheques a Pagar" href="<?php echo $configUrlGer;?>financeiro/cheques/pagos/">Acessar Cheques a Pagar</a></p>
									<p class="total">Total: R$ <?php echo number_format($valorTotal, 2, ",", ".");?></p>
									<br class="clear"/>
								</div>	
							</div>						
						</div>
<?php
	}
?>						
						<br class="clear"/>
					</div>
					<br class="clear"/>
				</div>
