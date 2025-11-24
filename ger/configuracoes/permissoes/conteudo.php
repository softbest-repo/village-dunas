<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if($controleUsuario == "tem usuario"){
			
			$area = "permissoes";
			include('f/conf/validaAcesso.php');
			if($validaAcesso == "ok"){
?>
				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Configurações</p>
						<p class="flexa"></p>
						<p class="nome-lista">Permissões</p>
						<br class="clear" />
					</div>
				</div>
				<div id="dados-conteudo">
					<div id="col-esq-pref" style="width:20%;">
						<p class="titulo-menu-pref">Alterar preferências</p>
						<p class="<?php echo $url[4] == 'minha-foto' ? 'menu-pref-foto-ativo' : 'menu-pref-foto' ;?>"><a href="<?php echo $configUrl;?>configuracoes/minha-foto/" title="Minha foto" >Minha foto</a></p>
						<p class="<?php echo $url[4] == 'email' ? 'menu-pref-email-ativo' : 'menu-pref-email' ;?>"><a href="<?php echo $configUrl;?>configuracoes/email/" title="Email" >Email</a></p>
						<p class="<?php echo $url[4] == 'permissoes' ? 'menu-pref-permissoes-ativo' : 'menu-pref-permissoes' ;?>"><a href="<?php echo $configUrl;?>configuracoes/permissoes/" title="Permissões" >Permissões</a></p>
						<p class="<?php echo $url[4] == 'usuarios' ? 'menu-pref-usuarios-ativo' : 'menu-pref-usuarios' ;?>"><a href="<?php echo $configUrl;?>cadastros/usuarios/" title="Usuários">Usuários</a></p>
					</div>
					<div id="consultas" style="float:left; width:76%;">
						<div class="botao-novo" style="margin-bottom:20px;"><a title="Novo E-mail" href="<?php echo $configUrl;?>cadastros/usuarios/"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Usuário</div><div class="direita-novo"></div></a></div>	
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Usuário</th>
								<th>Tipo Usuário</th>
								<th>Filial</th>
								<th class="canto-dir">Gerenciar permissões</th>
							</tr>					
<?php
				$sqlCol = "SELECT * FROM usuarios WHERE codUsuario != 4 ORDER BY statusUsuario ASC, nomeUsuario ASC";
				$resultCol = $conn->query($sqlCol);
				while($dadosCol = $resultCol->fetch_assoc()){
					
					$sqlFilial = "SELECT * FROM filiais WHERE codFilial = ".$dadosCol['codFilial']." ORDER BY nomeFilial ASC";
					$resultFilial = $conn->query($sqlFilial);
					$dadosFilial = $resultFilial->fetch_assoc();					
?>
							<tr class="tr">
								<td class="td-ciquenta" style="width:40%;"><a href='<?php echo $configUrlGer; ?>configuracoes/permissoes/detalhes/<?php echo $dadosCol['codUsuario'] ?>/' title='Gerenciar permissões do colaborador <?php echo $dadosCol['nomeUsuario'] ?>'><?php echo $dadosCol['nomeUsuario'];?></a></td>
								<td class="td-ciquenta" style="width:20%; text-align:center;"><a href='<?php echo $configUrlGer; ?>configuracoes/permissoes/detalhes/<?php echo $dadosCol['codUsuario'] ?>/' title='Gerenciar permissões do colaborador <?php echo $dadosCol['nomeUsuario'] ?>'><?php echo $dadosCol['tipoUsuario'] == "A" ? 'Administrador' : 'Corretor';?></a></td>
								<td class="td-ciquenta" style="width:20%; text-align:center;"><a href='<?php echo $configUrlGer; ?>configuracoes/permissoes/detalhes/<?php echo $dadosCol['codUsuario'] ?>/' title='Gerenciar permissões do colaborador <?php echo $dadosCol['nomeUsuario'] ?>'><?php echo $dadosFilial['nomeFilial'];?></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>configuracoes/permissoes/detalhes/<?php echo $dadosCol['codUsuario'] ?>/' title='Gerenciar permissões do colaborador <?php echo $dadosCol['nomeUsuario'] ?>' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/icones-permicoes.gif" alt="icone"></a></td>
							</tr>
<?php
				}
?>
						</table>	
					</div>
					<br class="clear"/>
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
