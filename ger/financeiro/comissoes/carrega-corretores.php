<?php 	
	session_start();

	include ('../../f/conf/config.php');
	include ('../../f/conf/functions.php');

	$negociacaoComissao = $_POST['negociacaoComissao'];
	$codCidade = $_POST['codCidade'];
	$codBairro = $_POST['codBairro'];
	$codQuadra = $_POST['codQuadra'];
	$codLote = $_POST['codLote'];
	$siglaTipo = $_POST['tipoImovel'];

	if($negociacaoComissao == "V"){
			
		$sqlImoveisConfere = "SELECT I.* FROM imoveis I inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$codQuadra."' and I.loteImovel = '".$codLote."' ORDER BY I.codImovel DESC LIMIT 0,1";
		$resultImoveisConfere = $conn->query($sqlImoveisConfere);
		$dadosImoveisConfere = $resultImoveisConfere->fetch_assoc();
								
		if($dadosImoveisConfere['codImovel'] == ""){			
			
			$sqlImoveisConfere = "SELECT I.* FROM imoveis I inner join imoveisLotes IL on I.codImovel = IL.codImovel inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$codQuadra."' and IL.nomeLote = '".$codLote."' ORDER BY I.codImovel DESC LIMIT 0,1";
			$resultImoveisConfere = $conn->query($sqlImoveisConfere);
			$dadosImoveisConfere = $resultImoveisConfere->fetch_assoc();
			
		}
		
		if($dadosImoveisConfere['codImovel'] != ""){
			
			if($dadosImoveisConfere['tipoVenda'] == "P"){
				$limite = 3;
				$tipoImovel = "proprio";
				$siglaTipoImovel = "P";
				$tipoImovelFrase = "Próprio";
				
				$comissaoImobiliaria = $dadosImoveisConfere['precoImovel'];
			}else{
				$limite = 3;
				$tipoImovel = "agenciado";
				$siglaTipoImovel = "A";
				$tipoImovelFrase = "Agenciado";
				
				$comissaoImobiliaria = 2.5 / 100 * $dadosImoveisConfere['precoImovel'];
			}
		}else{
			$siglaTipoImovel = $siglaTipo;
			if($siglaTipoImovel == "P"){
				$limite = 3;
				$tipoImovel = "proprio";
				$tipoImovelFrase = "Próprio";				
			}else{
				$limite = 3;
				$tipoImovel = "agenciado";
				$tipoImovelFrase = "Agenciado";				
			}
			
			$comissaoImobiliaria = "0.00";			
		}
?>
									<script>
										document.getElementById("tipoImovel").value="<?php echo $siglaTipoImovel;?>";
										document.getElementById("valor-imovel").value="<?php echo number_format($dadosImoveisConfere['precoImovel'], 2, ',', '.');?>";
										document.getElementById("obs-imobiliaria").value="Imóvel <?php echo $tipoImovelFrase;?>";
									</script>
									<input type="hidden" value="N" name="tipoCorretor" id="tipoCorretor"/>									
									<input type="hidden" value="V" name="tipoComissao" id="tipoComissao"/>									
									<input type="hidden" value="<?php echo $siglaTipoImovel;?>" name="imovelComissao" id="imovelComissao"/>									
									<input type="hidden" value="<?php echo $limite;?>" name="totalCorretores" id="totalCorretores"/>									

<?php			
		for($i=1; $i<=$limite; $i++){
			if($negociacaoComissao == "V"){
				if($i == 1){
					$tipo = "IN";
					$titulo1 = "Indicação";
					$titulo2 = "Comissão";
					$titulo3 = "OBS";
					$filtroSql = "";
				}else
				if($i == 2){
					$tipo = "CV";
					$titulo1 = "Corretor Venda";
					$titulo2 = "Comissão";
					$titulo3 = "OBS";
					$filtroSql = "";
				}else
				if($i == 3){
					$tipo = "CA";
					$titulo1 = "Corretor Agenciamento";
					$titulo2 = "Comissão";
					$titulo3 = "OBS";
					$filtroSql = "";
				}
			}else{
				$tipo = "CA";
				$titulo1 = "Corretor Agenciamento";
				$titulo2 = "Comissão";
				$titulo3 = "OBS";
				$filtroSql = "";			
			}
?>								
									<div id="bloco-<?php echo $tipo;?>">
										<p style="float:left; font-size:26px; margin-top:14px; margin-right:10px; margin-left:5px;">➥</p>
										
										<input type="hidden" value="<?php echo $tipo;?>" name="itemComissao<?php echo $i;?>" id="itemComissao<?php echo $i;?>"/>
										
										<p class="bloco-campo-float"><label><?php echo $titulo1;?>: <span class="obrigatorio"> <?php echo $i == 2 && $_SESSION['agrupadorNovo'] == "" ? '*' : '';?> </span></label>
											<select class="campo" id="corretor<?php echo $tipo;?>" name="corretor<?php echo $tipo;?>" style="width:250px;" <?php echo $i == 2 && $_SESSION['agrupadorNovo'] == "" ? 'required' : '';?> onChange="buscaComissao(this.value, 'V', '<?php echo $siglaTipoImovel;?>', '<?php echo $tipo;?>', ''); <?php echo $i == 1 ? 'atualizaComissao();' : '';?>" >
												<option value="">Selecione</option>
<?php
			$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario != ''".$filtroSql." ORDER BY nomeUsuario ASC";
			$resultUsuario = $conn->query($sqlUsuario);
			while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
												<option value="<?php echo $dadosUsuario['tipoUsuario'];?>-<?php echo $dadosUsuario['codUsuario'];?>"><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
			}
?>					
											</select>
										</p>
																
										<p class="bloco-campo-float"><label><?php echo $titulo2;?>: <span class="obrigatorio"> <?php echo $i == 2 && $_SESSION['agrupadorNovo'] == "" ? '*' : '';?> </span></label>
										<input class="campo" type="text" name="valor<?php echo $tipo;?>" id="valor<?php echo $tipo;?>" <?php echo $i == 2 && $_SESSION['agrupadorNovo'] == "" ? 'required' : '';?> style="width:190px;" value="" onKeyup="moeda(this);" onBlur="<?php echo $i == 1 ? 'atualizaComissaoInd();' : '';?>"/></p>	
										
										<p class="bloco-campo-float" style="margin-right:0px;"><label><?php echo $titulo3;?>: <span class="obrigatorio"> </span></label>
										<input class="campo" type="text" name="obs-corretor<?php echo $tipo;?>" id="obs-corretor<?php echo $tipo;?>" style="width:390px;" value=""/></p>	
									</div>	
<?php
		}
				
		if($tipoImovel == "agenciado"){
		
			$sqlUsuarioAgenciamento = "SELECT * FROM usuarios WHERE codUsuario = '".$dadosImoveisConfere['codUsuario']."' ORDER BY codUsuario ASC LIMIT 0,1";
			$resultUsuarioAgenciamento = $conn->query($sqlUsuarioAgenciamento);
			$dadosUsuarioAgenciamento = $resultUsuarioAgenciamento->fetch_assoc();
			
			if($dadosUsuarioAgenciamento['codUsuario'] != ""){
				
				$sqlComissaoCA = "SELECT * FROM comissoesValores WHERE tipoComissaoValor = 'V' and imovelComissaoValor = 'A' and linhaComissaoValor = 'CA' ORDER BY codComissaoValor ASC LIMIT 0,1";
				$resultComissaoCA = $conn->query($sqlComissaoCA);
				$dadosComissaoCA = $resultComissaoCA->fetch_assoc();
			
				if($dadosComissaoCA['defineComissaoValor'] == "V"){
					$comissaoCA = $dadosComissaoCA['valorComissaoValor'];
				}else
				if($dadosComissaoCA['defineComissaoValor'] == "P"){
					$comissaoCA = $dadosComissaoCA['porcentagemComissaoValor'] / 100 * $comissaoImobiliaria;
				}

				if($dadosComissaoCA['defineAComissaoValor'] != "N"){
					if($dadosComissaoCA['defineAComissaoValor'] == "V"){
						$acrescimoCA = $dadosComissaoCA['acrescimoVComissaoValor'];
					}else
					if($dadosComissaoCA['defineAComissaoValor'] == "P"){
						$acrescimoCA = $dadosComissaoCA['acrescimoPComissaoValor'] / 100 * $comissaoImobiliaria;
					}	
					
					$comissaoCA = $comissaoCA + $acrescimoCA;
				}					
?>
									<script>
										document.getElementById("corretorCA").value="C-<?php echo $dadosUsuarioAgenciamento['codUsuario'];?>";	
										document.getElementById("valorCA").value="<?php echo number_format($comissaoCA, 2, ',', '.');?>";											
									</script>
<?php				
			}
		}
	}else{
?>
									<script>
										document.getElementById("valor-imovel").value="";
										document.getElementById("obs-imobiliaria").value="Compra de Imóvel";
										document.getElementById("comissao-imobiliaria").value="0,00";
									</script>
									<input type="hidden" value="N" name="tipoCorretor" id="tipoCorretor"/>									
									<input type="hidden" value="C" name="tipoComissao" id="tipoComissao"/>									
									<input type="hidden" value="A" name="imovelComissao" id="imovelComissao"/>
									<input type="hidden" value="1" name="totalCorretores" id="totalCorretores"/>			
<?php
		for($i=1; $i<=1; $i++){
				
			if($i == 1){
				$tipo = "CA";
				$titulo1 = "Corretor Compra";
				$titulo2 = "Comissão";
				$titulo3 = "OBS";
				$filtroSql = "";
			}		
?>								
									<div id="bloco-<?php echo $tipo;?>">
										<p style="float:left; font-size:26px; margin-top:14px; margin-right:10px; margin-left:5px;">➥</p>
										
										<input type="hidden" value="<?php echo $tipo;?>" name="itemComissao<?php echo $i;?>" id="itemComissao<?php echo $i;?>"/>
										
										<p class="bloco-campo-float"><label><?php echo $titulo1;?>: <span class="obrigatorio"> <?php echo $i == 1 ? '*' : '';?> </span></label>
											<select class="campo" id="corretor<?php echo $tipo;?>" name="corretor<?php echo $tipo;?>" style="width:250px;" <?php echo $i == 1 ? 'required' : '';?> >
												<option value="">Selecione</option>
<?php
				$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario != ''".$filtroSql." ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
												<option value="<?php echo $dadosUsuario['tipoUsuario'];?>-<?php echo $dadosUsuario['codUsuario'];?>"><?php echo $dadosUsuario['nomeUsuario'] ;?></option>
<?php
				}
?>					
											</select>
										</p>
																
										<p class="bloco-campo-float"><label><?php echo $titulo2;?>: <span class="obrigatorio"> <?php echo $i == 1 ? '*' : '';?> </span></label>
										<input class="campo" type="text" name="valor<?php echo $tipo;?>" id="valor<?php echo $tipo;?>" <?php echo $i == 1 ? 'required' : '';?> style="width:190px;" value="" onKeyup="moeda(this);"/></p>	
										
										<p class="bloco-campo-float" style="margin-right:0px;"><label><?php echo $titulo3;?>: <span class="obrigatorio"> </span></label>
										<input class="campo" type="text" name="obs-corretor<?php echo $tipo;?>" id="obs-corretor<?php echo $tipo;?>" style="width:390px;" value=""/></p>	
									</div>	
<?php
		}			
	}
?>