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
	if(isset($_POST['cheguei'])){
		$sqlInsere = "INSERT INTO usuariosLogins VALUES(0, ".$_COOKIE['codAprovado'.$cookie].", '".date('Y-m-d H:i:s')."')";
		$resultInsere = $conn->query($sqlInsere);
	}
?>
			<script type="text/javascript">
				function trocaBackground(cod){
<?php
	if(validaAcesso($conn, "banners") == "ok" || validaAcesso($conn, "quemSomos") == "ok" || validaAcesso($conn, "servicos") == "ok" || validaAcesso($conn, "relatorios") == "ok" || validaAcesso($conn, "informacoes") == "ok"){
?>
					document.getElementById('trocaBackground-1').style.background="transparent url('<?php echo $configUrl;?>f/i/default/menu-default/menu-inativo.gif') left top no-repeat";
<?php
	}

	if(validaAcesso($conn, "usuarios") == "ok" || validaAcesso($conn, "filiais") == "ok" || validaAcesso($conn, "clientes") == "ok" || validaAcesso($conn, "fornecedores") == "ok" || validaAcesso($conn, "proprietarios") == "ok" || validaAcesso($conn, "cidades") == "ok" || validaAcesso($conn, "bairros") == "ok" || validaAcesso($conn, "caracteristicas") == "ok" || validaAcesso($conn, "tipoImovel") == "ok" || validaAcesso($conn, "quadras") == "ok" || validaAcesso($conn, "lotes") == "ok" || validaAcesso($conn, "imoveis") == "ok" || validaAcesso($conn, "tipoCompromisso") == "ok"){
?>
					document.getElementById('trocaBackground-2').style.background="transparent url('<?php echo $configUrl;?>f/i/default/menu-default/menu-inativo.gif') left top no-repeat";
<?php
	}
	
	if(validaAcesso($conn, "compromissos") == "ok" || validaAcesso($conn, "leads") == "ok" || validaAcesso($conn, "negociacoes") == "ok" || validaAcesso($conn, "contratos") == "ok"){	
?>					
					document.getElementById('trocaBackground-3').style.background="transparent url('<?php echo $configUrl;?>f/i/default/menu-default/menu-inativo.gif') left top no-repeat";
<?php
	}

	if(validaAcesso($conn, "contas-pagar") == "ok" || validaAcesso($conn, "contas-receber") == "ok" || validaAcesso($conn, "bancos") == "ok" || validaAcesso($conn, "cheques") == "ok" || validaAcesso($conn, "bancosConta") == "ok" || validaAcesso($conn, "recibos") == "ok" || validaAcesso($conn, "comissoes") == "ok" || validaAcesso($conn, "tipoPagamento") == "ok"){	
?>
					document.getElementById('trocaBackground-4').style.background="transparent url('<?php echo $configUrl;?>f/i/default/menu-default/menu-inativo.gif') left top no-repeat";
<?php
	}

	if(validaAcesso($conn, "vendas-despesas") == "ok" || validaAcesso($conn, "movimentacoes") == "ok" || validaAcesso($conn, "fornecedores") == "ok" || validaAcesso($conn, "despesas") == "ok" || validaAcesso($conn, "imoveis") == "ok" || validaAcesso($conn, "corretores") == "ok"){		
?>					
					document.getElementById('trocaBackground-5').style.background="transparent url('<?php echo $configUrl;?>f/i/default/menu-default/menu-inativo.gif') left top no-repeat";
<?php
	}
?>					
					document.getElementById('trocaBackground-'+cod).style.background="transparent url('<?php echo $configUrl;?>f/i/default/menu-default/menu-ativo.gif') left bottom no-repeat";
				}
			</script>
			<div id="topo">
				<div id="topo-esq" style="width:460px;">
					<p class="slogan"><a style="display:table; padding-top:4px;" title="<?php echo $nomeEmpresa;?>" href="<?php echo $configUrl;?>"><img style="padding-left:14px;" src="<?php echo $configUrlGer;?>f/i/comp.png" height="55"/></a></p>
					<div id="menu" style="width:760px; margin-top:0px;">
<?php
	if(validaAcesso($conn, "banners") == "ok" || validaAcesso($conn, "quemSomos") == "ok" || validaAcesso($conn, "servicos") == "ok" || validaAcesso($conn, "relatorios") == "ok" || validaAcesso($conn, "informacoes") == "ok"){
		?>
						<p class="<?php echo $url[3] == 'site' ? 'menu-site-ativo' : 'menu-site';?>"><a href="javascript:trocaBackground(1);"  id="trocaBackground-1" onClick="mostraItens(1)" >Site</a></p>
<?php
	}

	if(validaAcesso($conn, "usuarios") == "ok" || validaAcesso($conn, "filiais") == "ok" || validaAcesso($conn, "clientes") == "ok" || validaAcesso($conn, "fornecedores") == "ok" || validaAcesso($conn, "proprietarios") == "ok" || validaAcesso($conn, "cidades") == "ok" || validaAcesso($conn, "bairros") == "ok" || validaAcesso($conn, "caracteristicas") == "ok" || validaAcesso($conn, "tipoImovel") == "ok" || validaAcesso($conn, "quadras") == "ok" || validaAcesso($conn, "lotes") == "ok" || validaAcesso($conn, "imoveis") == "ok" || validaAcesso($conn, "tipoCompromisso") == "ok"){	
?>
						<p class="<?php echo $url[3] == 'cadastros' ? 'menu-cadastros-ativo' : 'menu-cadastros';?>"><a href="javascript:trocaBackground(2);"  id="trocaBackground-2" onClick="mostraItens(2)" >Cadastros</a></p>
<?php
	}

	if(validaAcesso($conn, "compromissos") == "ok" || validaAcesso($conn, "leads") == "ok" || validaAcesso($conn, "negociacoes") == "ok" || validaAcesso($conn, "contratos") == "ok"){		
?>						
						<p class="<?php echo $url[3] == 'corretores' || $url[3] == "" && $usuario == 'C' ? 'menu-corretores-ativo' : 'menu-corretores';?>"><a href="javascript:trocaBackground(3);"  id="trocaBackground-3" onClick="mostraItens(3)" >Corretores</a></p>
<?php
	}  
?>					
					</div>
				</div>
				<div id="topo-dir" style="width:600px;">
					<div id="icones-topo">
						<p class="icone-configuracoes" style="border-right:none;"><a href="<?php echo $configUrl;?>configuracoes/" title="" >Configurações</a></p>
						<br class="clear" />
					</div>
					<br class="clear" />
					<div id="dados-usuario-topo">
<?php
	$sqlImagemUsuario = "SELECT * FROM usuariosImagens WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]." ORDER BY codUsuarioImagem DESC LIMIT 0,1";
	$resultImagemUsuario = $conn->query($sqlImagemUsuario);
	$dadosImagemUsuario = $resultImagemUsuario->fetch_assoc();
	if($dadosImagemUsuario['codUsuario'] != ""){	
		$imagemUsuario = $configUrl."configuracoes/minha-foto/".$dadosImagemUsuario['codUsuario']."-".$dadosImagemUsuario['codUsuarioImagem']."-G.".$dadosImagemUsuario['extUsuarioImagem'];
	}else{
		$imagemUsuario = $configUrl."f/i/default/topo-default/avatar.gif";
	}
?>	

						<div id="imagem-cliente-topo">
							<a href="<?php echo $configUrl;?>configuracoes/minha-foto/" title="Alterar foto" ><img style="border-radius:5px;" src="<?php echo $imagemUsuario;?>" alt="" /></a>
						</div>
						<div id="dados-cliente-topo">
							<p class="nome-cliente"><?php echo $nomeEmpresaMenor;?></p>
							<p class="nome-usuario"><span class="titulo-usuario">Usuário:</span> <?php echo $_COOKIE['loginAprovado'.$cookie];?></p>
							<p class="icone-sair"><a href="<?php echo $configUrl;?>sair.php" title=""><span class="oculto">Sair</span></a></p>
						</div>
						<form style="float:right;" method="post">
<?php
	if($dadosUsuario['leadsUsuario'] == "S"){

		include('../wa/info.php');

		$sqlUsuarioLogin = "SELECT * FROM usuariosLogins WHERE codUsuario = ".$_COOKIE['codAprovado'.$cookie]." and DATE(dataUsuarioLogin) = '".date('Y-m-d')."' ORDER BY codUsuario DESC LIMIT 0,1";
		$resultUsuarioLogin = $conn->query($sqlUsuarioLogin);
		$dadosUsuarioLogin = $resultUsuarioLogin->fetch_assoc();
			
		if($dadosUsuarioLogin['codUsuarioLogin'] != ""){
			$quebraData = explode(" ", $dadosUsuarioLogin['dataUsuarioLogin']);
?>
							<input class="botao-cheguei" type="submit" name="cheguei" style="background-color:#ccc;" disabled="disabled" value="Check-in Realizado"/>
							<span class="chegou" style="text-align:center;"><?php echo data($quebraData[0]);?> ás <?php echo $quebraData[1];?></span>
<?php
		}else{

			if(date('H:i:s') >= "00:00:00" && date('H:i:s') <= $limiteCheckin){
?>						
							<input class="botao-cheguei" type="button" name="cheguei" disabled="disabled" style="background:#a9a9a9; cursor:auto; position:relative; z-index:100;" value="Check-in iniciára <?php echo str_replace(":00", "", $limiteCheckin);?>H"/>
<?php
			}

		}
	}
?>		
				</form>
						<br class="clear"/>
					  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
						<script>
						  document.getElementById('btnCheckIn').addEventListener('click', () => {
							Swal.fire({
							  title: 'Enviando solicitação...',
							  text: 'Realize o check-in clicando na mensagem enviada ao seu WhatsApp!',
							  allowOutsideClick: false,
							  didOpen: () => {
								Swal.showLoading();

								fetch('<?php echo $configUrlSite;?>wa/check-in.php?codUsuario=<?php echo $_COOKIE["codAprovado".$cookie];?>', {
								  method: 'GET',
								  headers: {
									'Content-Type': 'application/json'
								  }
								})
								.then(response => response.json())
								.then(data => {
								  if (data.success) {
									verificarStatusCheckIn();
								  } else {
									Swal.fire({
									  title: 'Erro!',
									  text: data.message || 'Houve um problema ao enviar o check-in.',
									  icon: 'error',
									  confirmButtonText: 'Tentar novamente'
									});
								  }
								})
								.catch(error => {
								  Swal.fire({
									title: 'Erro!',
									text: 'Falha na conexão com o servidor.',
									icon: 'error',
									confirmButtonText: 'Tentar novamente'
								  });
								});
							  }
							});
						  });

						  // Função para verificar status do check-in
						  function verificarStatusCheckIn() {
							const interval = setInterval(() => {
							  fetch('<?php echo $configUrlSite;?>wa/check-in-status.php?codUsuario=<?php echo $_COOKIE["codAprovado".$cookie];?>', {
								method: 'GET',
								headers: {
								  'Content-Type': 'application/json'
								}
							  })
							  .then(response => response.json())
							  .then(data => {
								if (data.success) {
									clearInterval(interval); // Para o polling
									Swal.fire({
									  title: 'Check-in realizado com sucesso!',
									  icon: 'success',
									  confirmButtonText: 'Ok'
									}).then(() => {
									  location.reload(); // Atualiza a página após o usuário clicar em "Ok"
									});
								}							 
								})
							  .catch(error => {
								clearInterval(interval); // Para o polling em caso de erro
								Swal.fire({
								  title: 'Erro!',
								  text: 'Falha ao verificar o status do check-in.',
								  icon: 'error',
								  confirmButtonText: 'Tentar novamente'
								});
							  });
							}, 5000); // Intervalo de 5 segundos entre cada verificação
						  }
						</script>
					</div>
				</div>
				<br class="clear" />
				<div id="barra-menu">
					<div id="menu-dinamico">
						<div id="site" <?php echo $url[3] == "" ? "style='display:none;'" : "";?>>
							<ul>
								<li style="<?php echo validaAcesso($conn, "banners") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "banners" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/banners/">Banners Capa</a></li>
								<li style="<?php echo validaAcesso($conn, "quemSomos") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "quemSomos" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/quemSomos/">Quem Somos</a></li>				
								<li style="<?php echo validaAcesso($conn, "servicos") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "servicos" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/servicos/">Serviços</a></li>				
								<li style="<?php echo validaAcesso($conn, "relatorios") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "relatorios" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/relatorios/">Relatórios de Acessos</a></li>
								<li style="<?php echo validaAcesso($conn, "informacoes") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "informacoes" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/informacoes/">Informações</a></li>
							</ul>
						</div>			
						<div id="cadastros" <?php echo $url[3] == "" ? "style='display:none;'" : "";?>>
							<ul>
								<li style="<?php echo validaAcesso($conn, "usuarios") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "usuarios" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/usuarios/">Usuários</a></li>					
								<li style="<?php echo validaAcesso($conn, "clientes") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "clientes" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/clientes/">Clientes</a></li>					
								<li style="<?php echo validaAcesso($conn, "fornecedores") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "fornecedores" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/fornecedores/">Fornecedores</a></li>					
								<li style="<?php echo validaAcesso($conn, "proprietarios") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "proprietarios" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/proprietarios/">Proprietários</a></li>					
								<li style="<?php echo validaAcesso($conn, "cidades") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "cidades" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/cidades/">Cidades</a></li>
								<li style="<?php echo validaAcesso($conn, "bairros") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "bairros" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/bairros/">Bairros</a></li>
								<li style="<?php echo validaAcesso($conn, "caracteristicas") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "caracteristicas" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/caracteristicas/">Características</a></li>								
								<li style="<?php echo validaAcesso($conn, "tipoImovel") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "tipoImovel" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/tipoImovel/">Tipo Imóvel</a></li>								
								<li style="<?php echo validaAcesso($conn, "quadras") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "quadras" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/quadras/">Quadras</a></li>
								<li style="<?php echo validaAcesso($conn, "lotes") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "lotes" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/lotes/">Lotes</a></li>
								<li style="<?php echo validaAcesso($conn, "imoveisS") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "imoveis" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/imoveis/">Imóveis</a></li>
								<li style="<?php echo validaAcesso($conn, "negociacoes") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "tipoCompromisso" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/tipoCompromisso/">Tipo Compromisso</a></li>
							</ul>
						</div>			
						<div id="corretores" <?php echo $url[3] == "corretores" || $url[3] == "" && $usuario == "C" ? "style='display:block;'" : "style='display:none;'";?>>
							<ul>
								<li style="<?php echo validaAcesso($conn, "compromissos") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "corretores" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>corretores/corretores/">Corretores</a></li>								
							</ul>
						</div>								
					</div>
					<div id="menu-normal">
						<div id="site" <?php echo $url[3] == "site" ? "style='display:block;'" : "style='display:none;'";?>>
							<ul>
								<li style="<?php echo validaAcesso($conn, "banners") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "banners" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/banners/">Banners Capa</a></li>
								<li style="<?php echo validaAcesso($conn, "quemSomos") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "quemSomos" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/quemSomos/">Quem Somos</a></li>				
								<li style="<?php echo validaAcesso($conn, "servicos") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "servicos" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/servicos/">Serviços</a></li>				
								<li style="<?php echo validaAcesso($conn, "relatorios") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "relatorios" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/relatorios/">Relatórios de Acessos</a></li>
								<li style="<?php echo validaAcesso($conn, "informacoes") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "informacoes" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>site/informacoes/">Informações</a></li>
							</ul>
						</div>			
						<div id="cadastros" <?php echo $url[3] == "cadastros" ? "style='display:block;'" : "style='display:none;'";?>>
							<ul>
								<li style="<?php echo validaAcesso($conn, "usuarios") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "usuarios" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/usuarios/">Usuários</a></li>					
								<li style="<?php echo validaAcesso($conn, "clientes") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "clientes" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/clientes/">Clientes</a></li>					
								<li style="<?php echo validaAcesso($conn, "fornecedores") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "fornecedores" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/fornecedores/">Fornecedores</a></li>					
								<li style="<?php echo validaAcesso($conn, "proprietarios") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "proprietarios" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/proprietarios/">Proprietários</a></li>					
								<li style="<?php echo validaAcesso($conn, "cidades") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "cidades" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/cidades/">Cidades</a></li>
								<li style="<?php echo validaAcesso($conn, "bairros") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "bairros" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/bairros/">Bairros</a></li>
								<li style="<?php echo validaAcesso($conn, "caracteristicas") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "caracteristicas" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/caracteristicas/">Características</a></li>								
								<li style="<?php echo validaAcesso($conn, "tipoImovel") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "tipoImovel" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/tipoImovel/">Tipo Imóvel</a></li>								
								<li style="<?php echo validaAcesso($conn, "quadras") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "quadras" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/quadras/">Quadras</a></li>
								<li style="<?php echo validaAcesso($conn, "lotes") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "lotes" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/lotes/">Lotes</a></li>
								<li style="<?php echo validaAcesso($conn, "imoveisS") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "imoveis" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/imoveis/">Imóveis</a></li>
								<li style="<?php echo validaAcesso($conn, "negociacoes") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "tipoCompromisso" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>cadastros/tipoCompromisso/">Tipo Compromisso</a></li>								
							</ul>
						</div>			
						<div id="corretores" <?php echo $url[3] == "corretores" || $url[3] == "" && $usuario == "C" ? "style='display:block;'" : "style='display:none;'";?>>
							<ul>
								<li style="<?php echo validaAcesso($conn, "compromissos") == "" ? 'display:none;' : '';?>"><a <?php echo $url[4] == "corretores" ? "class='ativo'" : "";?> href="<?php echo $configUrl;?>corretores/corretores/">Corretores</a></li>								
							</ul>
						</div>												
					</div>
				</div>
			</div>
