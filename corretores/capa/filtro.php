					          	
<?php 
    if(isset($_POST['cidadeFiltroSite'])){
        if($_POST['cidadeFiltroSite'] != ""){
            $_SESSION['cidadeFiltroSite'] = $_POST['cidadeFiltroSite'];
        }else{
            $_SESSION['cidadeFiltroSite'] = "";
        }
    }
    
    if($_SESSION['cidadeFiltroSite'] != ""){
        $filtraCidade = " and L.codCidade = ".$_SESSION['cidadeFiltroSite']."";
    }
    
    if(isset($_POST['loteamentoFiltroSite'])){
        if($_POST['loteamentoFiltroSite'] != ""){
            $_SESSION['loteamentoFiltroSite'] = $_POST['loteamentoFiltroSite'];
        }else{
            $_SESSION['loteamentoFiltroSite'] = "";
        }
    }
    
    if($_SESSION['loteamentoFiltroSite'] != ""){
        $filtraLoteamento = " and L.codLoteamento = ".$_SESSION['loteamentoFiltroSite']."";
    }
?>                  
                    <div id="repete-filtros">
						<div id="conteudo-filtros">
                            <div id="filtros">
                                <p class="titulo">Filtrar Loteamentos</p>
                               <div id="linha"></div>
								<form id="alteraFiltro" action="<?php echo $configUrl;?>loteamentos/" method="post" style="  display: flex; gap: 8px;">								
									<script>
										function carregaLoteamentos(cidade){
											var $tg = jQuery.noConflict();
											$tg.post("<?php echo $configUrl;?>carrega-loteamentos.php", {codCidade: cidade}, function(data){
												$tg("#carrega-loteamento").html(data);
											});																
										}									
									</script>
									<p class="bloco-campo-float">
										<select class="campo" id="cidadeFiltroSite" name="cidadeFiltroSite" onChange="carregaLoteamentos(this.value);">
											<option value="">Cidades</option>
											<option value="">Todos</option>
<?php
	$sqlCidades = "SELECT * FROM cidades C inner join loteamentos L on C.codCidade = L.codCidade GROUP BY C.codCidade ORDER BY C.codCidade ASC";
	$resultCidades = $conn->query($sqlCidades);
	while($dadosCidades = $resultCidades->fetch_assoc()){
?>
											<option value="<?php echo $dadosCidades['codCidade'];?>" <?php echo $_SESSION['cidadeFiltroSite'] == $dadosCidades['codCidade'] ? '/SELECTED/' : '';?>><?php echo $dadosCidades['nomeCidade'];?> / <?php echo $dadosCidades['estadoCidade'];?></option>
<?php
	}
?>
										</select>
									</p>
									<div id="carrega-loteamento" style="float:left;">
<?php
	if($_SESSION['cidadeFiltroSite']  != ""){
?>										
										<p class="bloco-campo-float">
											<select class="campo" id="loteamentoFiltroSite" name="loteamentoFiltroSite">
												<option value="">Loteamentos</option>
												<option value="">Todos</option>
<?php
		$sqlLoteamentos = "SELECT * FROM loteamentos WHERE statusLoteamento =  'T' and codCidade = ".$_SESSION['cidadeFiltroSite']." ORDER BY codLoteamento ASC";
		$resultLoteamentos = $conn->query($sqlLoteamentos);
		while($dadosLoteamentos = $resultLoteamentos->fetch_assoc()){
?>
												<option value="<?php echo $dadosLoteamentos['codLoteamento'];?>" <?php echo $_SESSION['loteamentoFiltroSite'] == $dadosLoteamentos['codLoteamento'] ? '/SELECTED/' : '';?>><?php echo $dadosLoteamentos['nomeLoteamento'];?></option>
<?php
		}
?>
											</select>
										</p>
<?php
	}else{
?>
										<p class="bloco-campo-float">
											<select class="campo" id="loteamentoFiltroSite" name="loteamentoFiltroSite">
												<option value="">Loteamentos</option>
												<option value="">Todos</option>
<?php
		$sqlLoteamentos = "SELECT * FROM loteamentos WHERE statusLoteamento =  'T' ORDER BY codLoteamento ASC";
		$resultLoteamentos = $conn->query($sqlLoteamentos);
		while($dadosLoteamentos = $resultLoteamentos->fetch_assoc()){
?>
												<option value="<?php echo $dadosLoteamentos['codLoteamento'];?>" <?php echo $_SESSION['loteamentoFiltroSite'] == $dadosLoteamentos['codLoteamento'] ? '/SELECTED/' : '';?>><?php echo $dadosLoteamentos['nomeLoteamento'];?></option>
<?php
		}
?>
											</select>
										</p>
<?php
	}
?>
									</div>	
									
									<p class="botao-filtrar"><input type="submit" name="filtrar" value="" /></p>
									
									<br class="clear"/>
								</form>						
							</div>
							<br class="clear"/>
						</div>
					</div>