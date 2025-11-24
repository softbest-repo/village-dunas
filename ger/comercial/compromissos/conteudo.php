<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "compromissos";
			if(validaAcesso($conn, $area) == "ok"){
					
				if($_SESSION['cadastro'] == "ok"){
					$erroConteudo = "<p class='erro'>Compromisso <strong>".$_SESSION['nome']."</strong> cadastrado com sucesso!</p>";
					$_SESSION['cadastro'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['alteracao'] == "ok"){
					$erroConteudo = "<p class='erro'>Compromisso <strong>".$_SESSION['nome']."</strong> alterado com sucesso!</p>";
					$_SESSION['alteracao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['ativacao'] == "ok"){
					$erroConteudo = "<p class='erro'>Compromisso <strong>".$_SESSION['nome']."</strong> ".$_SESSION['acao']." com sucesso!</p>";
					$_SESSION['ativacao'] = "";
					$_SESSION['nome'] = "";
				}else
				if($_SESSION['exclusao'] == "ok"){
					$erroConteudo = "<p class='erro'>Compromisso <strong>".$_SESSION['nome']."</strong> excluído com sucesso!</p>";
					$_SESSION['exclusao'] = "";
					$_SESSION['nome'] = "";
				}else	
				if($_SESSION['erroC'] == "ok"){
					$erroConteudo = "<p class='erro'>Compromisso não cadastrado pois não foi selecionado um usuário!</p>";
					$_SESSION['erroC'] = "";
					$_SESSION['nome'] = "";
				}	

				if(isset($_POST['dia-filtro-compromissos'])){
					$_SESSION['dia-filtro-compromissos'] = $_POST['dia-filtro-compromissos'];
					$_SESSION['mes-filtro-compromissos'] = $_POST['mes-filtro-compromissos'];
					$_SESSION['ano-filtro-compromissos'] = $_POST['ano-filtro-compromissos'];
					$_SESSION['tipo-filtro-compromissos'] = $_POST['tipo-filtro-compromissos'];
					$_SESSION['colaborador-filtro-compromissos'] = $_POST['colaborador-filtro-compromissos'];
				}
	
				if($_SESSION['dia-filtro-compromissos'] == ""){
					$_SESSION['dia-filtro-compromissos'] = "";
				}
				if($_SESSION['mes-filtro-compromissos'] == ""){
					$_SESSION['mes-filtro-compromissos'] = "";
				}
				if($_SESSION['ano-filtro-compromissos'] == ""){
					$_SESSION['ano-filtro-compromissos'] = date("Y");
				}
				
				if($_SESSION['dia-filtro-compromissos'] != "" && $_SESSION['dia-filtro-compromissos'] != "T"){
					$filtraDia = " and date_format(C.dataCompromisso, '%d') = '".$_SESSION['dia-filtro-compromissos']."'";
				}
				if($_SESSION['mes-filtro-compromissos'] != "" && $_SESSION['mes-filtro-compromissos'] != "T"){
					$filtraMes = " and date_format(C.dataCompromisso, '%m') = '".$_SESSION['mes-filtro-compromissos']."'";
				}
				if($_SESSION['ano-filtro-compromissos'] != "" && $_SESSION['ano-filtro-compromissos'] != "T"){
					$filtraAno = " and date_format(C.dataCompromisso, '%Y') = '".$_SESSION['ano-filtro-compromissos']."'";
				}
				if($_SESSION['tipo-filtro-compromissos'] != "" && $_SESSION['tipo-filtro-compromissos'] != "T"){
					$filtraTipo = " and C.codTipoCompromisso = ".$_SESSION['tipo-filtro-compromissos']."";
				}
				if($_SESSION['colaborador-filtro-compromissos'] != "" && $_SESSION['colaborador-filtro-compromissos'] != "T"){
					$filtraUsuario = " and CU.codUsuario = ".$_SESSION['colaborador-filtro-compromissos']."";
				}
?>

				<div id="filtro">
					<div id="localizacao-filtro">
						<p class="nome-lista">Comercial</p>
						<p class="flexa"></p>
						<p class="nome-lista">Compromissos</p>
						<br class="clear"/>
					</div>
					
					<div class="demoTarget">
						<div id="formulario-filtro">
							<script>
								function enviar(){
									document.filtro.submit(); 
								}
							</script>
							<script>
								function abreCadastrar(){
									var $rf = jQuery.noConflict();
									if(document.getElementById("cadastrar").style.display=="none"){
										document.getElementById("botaoFechar").style.display="block";
										$rf("#cadastrar").slideDown(250);
									}else{
										document.getElementById("botaoFechar").style.display="none";
										$rf("#cadastrar").slideUp(250);
									}
								}
							</script>
							<form name="filtro" action="<?php echo $configUrl;?>comercial/compromissos/" method="post" >																																	
								<p><label class="label">Dia:</label>	
									<select id="default-usage-select" class="campo" name="dia-filtro-compromissos" style="width:80px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="01" <?php echo $_SESSION['dia-filtro-compromissos'] == '01' ? '/SELECTED/' : '';?>>01</option>
										<option value="02" <?php echo $_SESSION['dia-filtro-compromissos'] == '02' ? '/SELECTED/' : '';?>>02</option>
										<option value="03" <?php echo $_SESSION['dia-filtro-compromissos'] == '03' ? '/SELECTED/' : '';?>>03</option>
										<option value="04" <?php echo $_SESSION['dia-filtro-compromissos'] == '04' ? '/SELECTED/' : '';?>>04</option>
										<option value="05" <?php echo $_SESSION['dia-filtro-compromissos'] == '05' ? '/SELECTED/' : '';?>>05</option>
										<option value="06" <?php echo $_SESSION['dia-filtro-compromissos'] == '06' ? '/SELECTED/' : '';?>>06</option>
										<option value="07" <?php echo $_SESSION['dia-filtro-compromissos'] == '07' ? '/SELECTED/' : '';?>>07</option>
										<option value="08" <?php echo $_SESSION['dia-filtro-compromissos'] == '08' ? '/SELECTED/' : '';?>>08</option>
										<option value="09" <?php echo $_SESSION['dia-filtro-compromissos'] == '09' ? '/SELECTED/' : '';?>>09</option>
										<option value="10" <?php echo $_SESSION['dia-filtro-compromissos'] == '10' ? '/SELECTED/' : '';?>>10</option>
										<option value="11" <?php echo $_SESSION['dia-filtro-compromissos'] == '11' ? '/SELECTED/' : '';?>>11</option>
										<option value="12" <?php echo $_SESSION['dia-filtro-compromissos'] == '12' ? '/SELECTED/' : '';?>>12</option>
										<option value="13" <?php echo $_SESSION['dia-filtro-compromissos'] == '13' ? '/SELECTED/' : '';?>>13</option>
										<option value="14" <?php echo $_SESSION['dia-filtro-compromissos'] == '14' ? '/SELECTED/' : '';?>>14</option>
										<option value="15" <?php echo $_SESSION['dia-filtro-compromissos'] == '15' ? '/SELECTED/' : '';?>>15</option>
										<option value="16" <?php echo $_SESSION['dia-filtro-compromissos'] == '16' ? '/SELECTED/' : '';?>>16</option>
										<option value="17" <?php echo $_SESSION['dia-filtro-compromissos'] == '17' ? '/SELECTED/' : '';?>>17</option>
										<option value="18" <?php echo $_SESSION['dia-filtro-compromissos'] == '18' ? '/SELECTED/' : '';?>>18</option>
										<option value="19" <?php echo $_SESSION['dia-filtro-compromissos'] == '19' ? '/SELECTED/' : '';?>>19</option>
										<option value="20" <?php echo $_SESSION['dia-filtro-compromissos'] == '20' ? '/SELECTED/' : '';?>>20</option>
										<option value="21" <?php echo $_SESSION['dia-filtro-compromissos'] == '21' ? '/SELECTED/' : '';?>>21</option>
										<option value="22" <?php echo $_SESSION['dia-filtro-compromissos'] == '22' ? '/SELECTED/' : '';?>>22</option>
										<option value="23" <?php echo $_SESSION['dia-filtro-compromissos'] == '23' ? '/SELECTED/' : '';?>>23</option>
										<option value="24" <?php echo $_SESSION['dia-filtro-compromissos'] == '24' ? '/SELECTED/' : '';?>>24</option>
										<option value="25" <?php echo $_SESSION['dia-filtro-compromissos'] == '25' ? '/SELECTED/' : '';?>>25</option>
										<option value="26" <?php echo $_SESSION['dia-filtro-compromissos'] == '26' ? '/SELECTED/' : '';?>>26</option>
										<option value="27" <?php echo $_SESSION['dia-filtro-compromissos'] == '27' ? '/SELECTED/' : '';?>>27</option>
										<option value="28" <?php echo $_SESSION['dia-filtro-compromissos'] == '28' ? '/SELECTED/' : '';?>>28</option>
										<option value="29" <?php echo $_SESSION['dia-filtro-compromissos'] == '29' ? '/SELECTED/' : '';?>>29</option>
										<option value="30" <?php echo $_SESSION['dia-filtro-compromissos'] == '30' ? '/SELECTED/' : '';?>>30</option>
										<option value="31" <?php echo $_SESSION['dia-filtro-compromissos'] == '31' ? '/SELECTED/' : '';?>>31</option>
									</select>
								</p>
								<p><label class="label">Mês:</label>
									<select id="default-usage-select2" class="campo" name="mes-filtro-compromissos" style="width:105px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="01" <?php echo $_SESSION['mes-filtro-compromissos'] == '01' ? '/SELECTED/' : '';?>>Janeiro</option>
										<option value="02" <?php echo $_SESSION['mes-filtro-compromissos'] == '02' ? '/SELECTED/' : '';?>>Fevereiro</option>
										<option value="03" <?php echo $_SESSION['mes-filtro-compromissos'] == '03' ? '/SELECTED/' : '';?>>Março</option>
										<option value="04" <?php echo $_SESSION['mes-filtro-compromissos'] == '04' ? '/SELECTED/' : '';?>>Abril</option>
										<option value="05" <?php echo $_SESSION['mes-filtro-compromissos'] == '05' ? '/SELECTED/' : '';?>>Maio</option>
										<option value="06" <?php echo $_SESSION['mes-filtro-compromissos'] == '06' ? '/SELECTED/' : '';?>>Junho</option>
										<option value="07" <?php echo $_SESSION['mes-filtro-compromissos'] == '07' ? '/SELECTED/' : '';?>>Julho</option>
										<option value="08" <?php echo $_SESSION['mes-filtro-compromissos'] == '08' ? '/SELECTED/' : '';?>>Agosto</option>
										<option value="09" <?php echo $_SESSION['mes-filtro-compromissos'] == '09' ? '/SELECTED/' : '';?>>Setembro</option>
										<option value="10" <?php echo $_SESSION['mes-filtro-compromissos'] == '10' ? '/SELECTED/' : '';?>>Outubro</option>
										<option value="11" <?php echo $_SESSION['mes-filtro-compromissos'] == '11' ? '/SELECTED/' : '';?>>Novembro</option>
										<option value="12" <?php echo $_SESSION['mes-filtro-compromissos'] == '12' ? '/SELECTED/' : '';?>>Dezembro</option>
									</select>
								</p>
								<p><label class="label">Ano:</label>
									<select id="default-usage-select3" class="campo" name="ano-filtro-compromissos" style="width:80px; margin-right:0px;">
										<option value="T">Todos</option>
										<option value="2011" <?php echo $_SESSION['ano-filtro-compromissos'] == '2011' ? '/SELECTED/' : '';?>>2011</option>
										<option value="2012" <?php echo $_SESSION['ano-filtro-compromissos'] == '2012' ? '/SELECTED/' : '';?>>2012</option>
										<option value="2013" <?php echo $_SESSION['ano-filtro-compromissos'] == '2013' ? '/SELECTED/' : '';?>>2013</option>
										<option value="2014" <?php echo $_SESSION['ano-filtro-compromissos'] == '2014' ? '/SELECTED/' : '';?>>2014</option>
										<option value="2015" <?php echo $_SESSION['ano-filtro-compromissos'] == '2015' ? '/SELECTED/' : '';?>>2015</option>
										<option value="2016" <?php echo $_SESSION['ano-filtro-compromissos'] == '2016' ? '/SELECTED/' : '';?>>2016</option>
										<option value="2017" <?php echo $_SESSION['ano-filtro-compromissos'] == '2017' ? '/SELECTED/' : '';?>>2017</option>
										<option value="2018" <?php echo $_SESSION['ano-filtro-compromissos'] == '2018' ? '/SELECTED/' : '';?>>2018</option>
										<option value="2019" <?php echo $_SESSION['ano-filtro-compromissos'] == '2019' ? '/SELECTED/' : '';?>>2019</option>
										<option value="2020" <?php echo $_SESSION['ano-filtro-compromissos'] == '2020' ? '/SELECTED/' : '';?>>2020</option>
										<option value="2021" <?php echo $_SESSION['ano-filtro-compromissos'] == '2021' ? '/SELECTED/' : '';?>>2021</option>
										<option value="2022" <?php echo $_SESSION['ano-filtro-compromissos'] == '2022' ? '/SELECTED/' : '';?>>2022</option>
										<option value="2023" <?php echo $_SESSION['ano-filtro-compromissos'] == '2023' ? '/SELECTED/' : '';?>>2023</option>
										<option value="2024" <?php echo $_SESSION['ano-filtro-compromissos'] == '2024' ? '/SELECTED/' : '';?>>2024</option>
										<option value="2025" <?php echo $_SESSION['ano-filtro-compromissos'] == '2025' ? '/SELECTED/' : '';?>>2025</option>
										<option value="2026" <?php echo $_SESSION['ano-filtro-compromissos'] == '2026' ? '/SELECTED/' : '';?>>2026</option>
										<option value="2027" <?php echo $_SESSION['ano-filtro-compromissos'] == '2027' ? '/SELECTED/' : '';?>>2027</option>
										<option value="2028" <?php echo $_SESSION['ano-filtro-compromissos'] == '2028' ? '/SELECTED/' : '';?>>2028</option>
										<option value="2029" <?php echo $_SESSION['ano-filtro-compromissos'] == '2029' ? '/SELECTED/' : '';?>>2029</option>
										<option value="2030" <?php echo $_SESSION['ano-filtro-compromissos'] == '2030' ? '/SELECTED/' : '';?>>2030</option>
									</select>
								</p>
								
								<p><label class="label">Tipo:</label>							
									<select id="default-usage-select4" class="campo" style="width:150px; margin-right:0px;" name="tipo-filtro-compromissos">
										<option value="T">Todos</option>
<?php
				$sqlTipoCompromisso = "SELECT nomeTipoCompromisso, codTipoCompromisso FROM tipoCompromisso WHERE statusTipoCompromisso = 'T' ORDER BY nomeTipoCompromisso ASC, codTipoCompromisso ASC";
				$resultTipoCompromisso = $conn->query($sqlTipoCompromisso);
				while($dadosTipoCompromisso = $resultTipoCompromisso->fetch_assoc()){
?>
										<option value="<?php echo $dadosTipoCompromisso['codTipoCompromisso'];?>" <?php echo $_SESSION['tipo-filtro-compromissos'] == $dadosTipoCompromisso['codTipoCompromisso'] ? '/SELECTED/' : '';?> ><?php echo $dadosTipoCompromisso['nomeTipoCompromisso'];?></option>
<?php
				}
?>

									</select>
								</p>							
								<p class="botao-filtrar"><input type="button" name="filtrar" value="Filtrar" onClick="enviar()" /></p>

								<div class="botao-novo" style="margin-left:0px;"><a title="Novo Compromisso" onClick="abreCadastrar()"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Compromisso</div><div class="direita-novo"></div></a></div>
								<div class="botao-novo" style="display:<?php echo $url[5] == 1 ? 'block' : 'none';?>; margin-left:15px;" id="botaoFechar"><a title="Fechar" onClick="abreCadastrar();"><div class="esquerda-novo"></div><div class="conteudo-novo" id="conteudo-novo-cliente">X</div><div class="direita-novo"></div></a></div>

								<br class="clear" />
								<br/>
							</form>
						</div>
					</div>
<?php
				if(isset($_POST['cadastrar'])){

					$quebraEnviar = explode("-", $_POST['codUsuario']);
					
					if($quebraEnviar[0] == "0"){
						$enviar = "0";
					}else
					if($quebraEnviar[0] == ""){
						$enviar = "V";
					}else{
						$enviar = "Erro";
					}
					
					if($enviar != "Erro"){
										
						$sql = "INSERT INTO compromissos VALUES(0, 0, ".$_POST['codTipoCompromisso'].", 1, '".$enviar."', ".$_COOKIE['codAprovado'.$cookie].", '".$_POST['nome']."', '".date("Y-m-d")."', '".$_POST['data']."', '".$_POST['hora']."', '".$_POST['descricao']."', 'T')";
						$result = $conn->query($sql);

						$sqlCompromisso = "SELECT * FROM compromissos ORDER BY codCompromisso DESC LIMIT 0,1";
						$resultCompromisso = $conn->query($sqlCompromisso);
						$dadosCompromisso = $resultCompromisso->fetch_assoc();
						
						if($enviar == "V"){
							if($_POST['quanti-usuarios'] >= 1){
								for($i=1; $i<=$_POST['quanti-usuarios']; $i++){
									if($_POST['usuario-envio'.$i] != ""){
										
										$sqlInsere = "INSERT INTO compromissosUsuario VALUES(0, ".$dadosCompromisso['codCompromisso'].", ".$_POST['usuario-envio'.$i].")";
										$resultInsere = $conn->query($sqlInsere);
										
									}
								}
							}
						}else{
							$sqlInsere = "INSERT INTO compromissosUsuario VALUES(0, ".$dadosCompromisso['codCompromisso'].", ".$_COOKIE['codAprovado'.$cookie].")";
							$resultInsere = $conn->query($sqlInsere);						
						}
										
						if($result == 1){	
							$_SESSION['cadastro'] = "ok";
							$_SESSION['nome'] = $_POST['nome'];
							$_SESSION['codUsuario'] = "";
							$_SESSION['codTipoCompromisso'] = "";
							$_SESSION['data'] = "";
							$_SESSION['hora'] = "";
							echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/compromissos/'>";					
						}else{
							$erroData = "<p class='erro'>Problemas ao cadastrar compromisso!</p>";
						}
					}else{
						$_SESSION['erroC'] = "ok";
						$_SESSION['nome'] = "";
						$_SESSION['codUsuario'] = "";
						$_SESSION['codTipoCompromisso'] = "";
						$_SESSION['data'] = "";
						$_SESSION['hora'] = "";						
						echo "<meta HTTP-EQUIV='Refresh' CONTENT='0;URL=".$configUrlGer."comercial/compromissos/'>";					
					}
				}else{
					$_SESSION['nome'] = "";
					$_SESSION['codUsuario'] = "";
					$_SESSION['codTipoCompromisso'] = "";
					$_SESSION['data'] = "";
					$_SESSION['hora'] = "";
				}
?>					
					<div id="cadastrar" style="display:none; margin-left:30px; margin-top:30px; margin-bottom:30px;">															
						<div class="botao-novo" style="margin-left:0px; margin-top:-20px; margin-bottom:20px;"><a title="Novo Tipo Compromisso" href="<?php echo $configUrlGer;?>comercial/tipoCompromisso/1/"><div class="esquerda-novo"></div><div class="conteudo-novo">Novo Tipo Compromisso</div><div class="direita-novo"></div></a></div>
						<br class="clear"/>

<?php
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
						<p class="obrigatorio">Campos obrigatórios *</p>
						<br/>					

						<form name="cadastro" action="<?php echo $configUrlGer; ?>comercial/compromissos/" method="post">
							<p class="bloco-campo-float"><label>Título: <span class="obrigatorio"> * </span></label>
							<input type="text" class="campo" style="width:270px;" name="nome" id="nome" required value="<?php echo $_SESSION['nome'];?>" /></p>

							<p class="bloco-campo-float"><label>Usuário: <span class="obrigatorio"> * </span></label>
								<script>
									function enviaCol(cod){
										var quebraCol = cod.split("-");
										var cod = quebraCol[0];
										document.getElementById("colaborador").value = cod;
										
									}
								</script>
								<input id="colaborador" class="oculto" name="mostraCol" value="<?php echo $_SESSION['colaborador'];?>" />
								<select id="codUsuario" style="width:285px;" class="campo campo-select" required name="codUsuario" onClick="selecionaUsuarios(this.value);" onChange="javascript:enviaCol(this.value);">
									<option value="">Selecione</option>
<?php
	if($usuario != "C"){
?>
									<option value="0">Todos</option>
<?php
	}
				$sqlUsuario = "SELECT codUsuario, nomeUsuario FROM usuarios WHERE statusUsuario = 'T'".$filtraUsuario." and codUsuario != 1 ORDER BY nomeUsuario ASC";
				$resultUsuario = $conn->query($sqlUsuario);
				while($dadosUsuario = $resultUsuario->fetch_assoc()){
?>
									<option class="options" id="option-<?php echo $dadosUsuario['codUsuario'];?>" value="<?php echo $dadosUsuario['codUsuario'];?>-<?php echo $dadosUsuario['nomeUsuario'];?>" <?php echo $dadosUsuario['codUsuario'] == $_SESSION['codUsuario'] ? '/SELECTED/' : '';?> ><?php echo $dadosUsuario['nomeUsuario'];?></option>
<?php
				}
?>
								</select>							
							</p>
	
							<script type="text/javascript">
								function selecionaUsuarios(cod){
									var $tt = jQuery.noConflict();
									if(cod != ""){
										$tt("#codUsuario").removeAttr("required");
										var quebraCod = cod.split("-");
										if(quebraCod[0] == "0"){
											document.getElementById("guarda-usuarios").innerHTML="";
											document.getElementById("quanti-usuarios").value=0;
											document.getElementById("confere").value=0;
											document.getElementById("guarda-usuarios").style.display="none";
											$tt(".options").removeAttr("disabled");
										}else{
											document.getElementById("guarda-usuarios").style.display="block";
											var somaConf = document.getElementById("confere").value;
											var somaConf = parseInt(somaConf) + 1;
											var somaCod = document.getElementById("quanti-usuarios").value;
											var somaCod = parseInt(somaCod) + 1;
											var novadiv = document.createElement("div");
											novadiv.setAttribute("id", "bloco-usuario"+somaCod);							
											document.getElementById("guarda-usuarios").appendChild(novadiv);	
																	
											document.getElementById("bloco-usuario"+somaCod).innerHTML += "<p style='font-size:16px; font-weight:bold; color:#718B8F; float:left;'>"+quebraCod[1]+"</p><p id='x"+somaCod+"' style='width:14px; padding:3px; border-radius:100%; cursor:pointer; background-color:#718B8F; padding-top:4px; font-size:13px; text-align:center; padding-right:4px; color:#FFF; font-weight:bold; margin-top:-2px; float:right;'>X</p><br class='clear'/><input type='hidden' value='"+quebraCod[0]+"' name='usuario-envio"+somaCod+"' id='usuario-envio"+somaCod+"'/>";
											document.getElementById("quanti-usuarios").value=somaCod;						
											document.getElementById("confere").value=somaConf;						
											document.getElementById("x"+somaCod).setAttribute("onClick", "deletaUsuario("+somaCod+", "+quebraCod[0]+")");										
											document.getElementById("option-"+quebraCod[0]).disabled=true;
											document.getElementById("codUsuario").value="";

										}
									}else{
										var somaCod = document.getElementById("quanti-usuarios").value;
										if(somaCod == "0" || somaCod == ""){
											document.getElementById("guarda-usuarios").innerHTML="";
											document.getElementById("quanti-usuarios").value=0;
											document.getElementById("confere").value=0;
											document.getElementById("guarda-usuarios").style.display="none";
											$tt(".options").removeAttr("disabled");										
											$tt("#codUsuario").attr("required", "required");										
										}										
									}
									
								}
								
								function deletaUsuario(cod, codUsuario){
									var $dd = jQuery.noConflict();
									var somaConf = document.getElementById("confere").value;
									var somaConf = somaConf - 1;
									document.getElementById("confere").value=somaConf;						
									$dd("#bloco-usuario"+cod).remove();
									$dd("#option-"+codUsuario).removeAttr("disabled");										
									if(somaConf == 0){
										document.getElementById("guarda-usuarios").innerHTML="";
										document.getElementById("quanti-usuarios").value=0;
										document.getElementById("guarda-usuarios").style.display="none";
										$dd(".options").removeAttr("disabled");										
										$dd("#codUsuario").attr("required", "required");																				
									}
								}
							</script>
							<style>
								#guarda-usuarios div {margin-left:10px; margin-right:10px; padding-top:8px; padding-bottom:5px; border-bottom:1px solid #ccc;}
							</style>
							<div id="guarda-usuarios" style="display:none; position:absolute; margin-left:610px; margin-top:20px; max-height:140px; overflow-y:auto; min-width:200px; min-height:100px; background-color:#f5f5f5; border:1px solid #ccc;">

							</div>
							
							<input type="hidden" value="0" name="quanti-usuarios" id="quanti-usuarios"/>	
							<input type="hidden" value="0" id="confere"/>
							
							<br class="clear" />
							
							<p class="bloco-campo-float"><label>Tipo Compromisso: <span class="obrigatorio"> * </span></label>
								<select id="codTipoCompromisso" style="width:251px;" required class="campo campo-select" name="codTipoCompromisso">
									<option value="" >Selecione</option>
<?php
				$sqlTipoCompromisso = "SELECT codTipoCompromisso, nomeTipoCompromisso FROM tipoCompromisso WHERE statusTipoCompromisso = 'T' ORDER BY nomeTipoCompromisso ASC";
				$resultTipoCompromisso = $conn->query($sqlTipoCompromisso);
				while($dadosTipoCompromisso = $resultTipoCompromisso->fetch_assoc()){
?>
									<option value="<?php echo $dadosTipoCompromisso['codTipoCompromisso'];?>" <?php echo $dadosTipoCompromisso['codTipoCompromisso'] == $_SESSION['codTipoCompromisso'] ? '/SELECTED/' : '';?> ><?php echo $dadosTipoCompromisso['nomeTipoCompromisso'];?></option>
<?php
				}
?>
								</select>
							
							</p>
							<SCRIPT language="javascript">
								function AbreCalendario(largura,altura,formulario,campo,tmpx) {
									if(document.getElementById("colaborador").value == ""){
										alert("Selecione o usuário");
									}else{
										var colaborador = document.getElementById("colaborador").value;
										vertical   = (screen.height/2) - (altura/2);
										horizontal = (screen.width/2) - (largura/2);
										var jan = window.open('<?php echo $configUrl;?>comercial/compromissos/calendario.php?colaborador='+colaborador+'&formulario='+formulario+'&campo='+campo+'&tmpx='+tmpx,'','toolbar=0,location=0,directories=0,status=1,menubar=0,scrollbars=yes,resizable=0,copyhistory=0,screenX='+screen.width+',screenY='+screen.height+',top='+vertical+',left='+horizontal+',width='+largura+',height='+altura);
										jan.focus();
									}
								}
							</SCRIPT>

							<p class="bloco-campo-float"><label>Data: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="date" id="data" required name="data" style="width:135px; height:16px;" id="data" value="<?php echo $_SESSION['data']; ?>"/></p>
		
							<p class="bloco-campo-float"><label>Horário: <span class="obrigatorio"> * </span></label>
							<input class="campo" type="time" style="width:140px; height:16px;" required name="hora" id="hora" value="<?php echo $_SESSION['hora']; ?>"/></p>

							<br class="clear" />

							<p class="bloco-campo"><label>Descrição: <span class="obrigatorio"></span></label>
							<textarea class="campo desabilita" name="descricao" style="width:562px; height:120px;" ><?php echo $_SESSION['descricao']; ?></textarea></p>
		
							<p class="bloco-campo"><div class="botao-expansivel"><p class="esquerda-botao"></p><input class="botao" type="submit" name="cadastrar" title="Salvar Compromisso" value="Salvar" /><p class="direita-botao"></p></div></p>						
							
							<br class="clear"/>
						</form>					
					</div>
					
				</div>
				<div id="dados-conteudo">
					<div id="consultas">
<?php
				if($erroConteudo != ""){
?>
						<div class="area-erro">
<?php
					echo $erroConteudo;
?>
						</div>
<?php
				}

				$sqlConta = "SELECT count(DISTINCT C.codCompromisso) registros FROM compromissos C inner join compromissosUsuario CU on C.codCompromisso = CU.codCompromisso WHERE C.codCompromisso != 0 and (C.codCadUsuario = ".$_COOKIE['codAprovado'.$cookie]." or CU.codUsuario = ".$_COOKIE['codAprovado'.$cookie]." or C.codUsuario = '0') ".$filtraDia.$filtraMes.$filtraAno.$filtraTipo."";				
				$resultConta = $conn->query($sqlConta);
				$dadosConta = $resultConta->fetch_assoc();
				$registros = $dadosConta['registros'];
				
				if($registros >= 1){				
?>
						<table class="tabela-menus" >
							<tr class="titulo-tabela" border="none">
								<th class="canto-esq">Hora</th>
								<th>Criado por</th>
								<th>Compromisso para</th>
								<th>Título</th>
								<th>Tipo</th>
								<th>Status</th>
								<th>Alterar</th>
								<th class="canto-dir">Excluir</th>
							</tr>	

<?php
					if($url[5] == 1 || $url[5] == ""){
						$pagina = 1;
						$sqlCompromisso = "SELECT DISTINCT C.* FROM compromissos C inner join compromissosUsuario CU on C.codCompromisso = CU.codCompromisso WHERE C.codCompromisso != 0 and (C.codCadUsuario = ".$_COOKIE['codAprovado'.$cookie]." or CU.codUsuario = ".$_COOKIE['codAprovado'.$cookie]." or C.codUsuario = '0') ".$filtraDia.$filtraMes.$filtraAno.$filtraTipo." ORDER BY C.dataCompromisso DESC, C.horaCompromisso ASC, C.codCompromisso DESC LIMIT 0,30";
					}else{
						$pagina = $url[5];
						$paginaFinal = $pagina * 30;
						$paginaInicial = $paginaFinal - 30;
						$sqlCompromisso = "SELECT DISTINCT C.* FROM compromissos C inner join compromissosUsuario CU on C.codCompromisso = CU.codCompromisso WHERE C.codCompromisso != 0 and (C.codCadUsuario = ".$_COOKIE['codAprovado'.$cookie]." or CU.codUsuario = ".$_COOKIE['codAprovado'.$cookie]." or C.codUsuario = '0') ".$filtraDia.$filtraMes.$filtraAno.$filtraTipo." ORDER BY C.dataCompromisso DESC, C.horaCompromisso ASC, C.codCompromisso DESC LIMIT LIMIT ".$paginaInicial.",30";
					}		

					$resultCompromisso = $conn->query($sqlCompromisso);
					while($dadosCompromisso = $resultCompromisso->fetch_assoc()){
						$mostrando++;

						if($dadosCompromisso['statusCompromisso'] == "T"){
							$status = "status-ativo";
							$statusIcone = "ativado";
							$statusPergunta = "desativar";
						}else{
							$status = "status-desativado";
							$statusIcone = "desativado";
							$statusPergunta = "ativar";
						}
						
						$sqlTipoCompromisso = "SELECT * FROM tipoCompromisso WHERE codTipoCompromisso = ".$dadosCompromisso['codTipoCompromisso']." LIMIT 0,1";
						$resultTipoCompromisso = $conn->query($sqlTipoCompromisso);
						$dadosTipoCompromisso = $resultTipoCompromisso->fetch_assoc();
						
						$enviado = "";
						
						if($dadosCompromisso['codUsuario'] == "0"){
							$enviado = "Todos";
						}else{
							$sqlCompromissoUsuario = "SELECT * FROM compromissosUsuario WHERE codCompromisso = ".$dadosCompromisso['codCompromisso']."";
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

						$sqlCriadorUsuario = "SELECT nomeUsuario FROM usuarios WHERE codUsuario = ".$dadosCompromisso['codCadUsuario']." ORDER BY nomeUsuario ASC";
						$resultCriadorUsuario = $conn->query($sqlCriadorUsuario);
						$dadosCriadorUsuario = $resultCriadorUsuario->fetch_assoc();
						
						if($guardaData != $dadosCompromisso['dataCompromisso']){
							$guardaData = $dadosCompromisso['dataCompromisso'];
?>
							<tr class="linha-data">
								<td style="background-color:<?php echo $guardaData < date('Y-m-d') ? '#629A9A' : '#3a6d6d';?>; height:50px; color:#FFFFFF; font-size:24px; font-weight:bold;" colspan="1"><?php echo data($guardaData);?></td>
								<td style="background-color:<?php echo $guardaData < date('Y-m-d') ? '#629A9A' : '#3a6d6d';?>; height:50px; color:#FFFFFF; font-size:24px; font-weight:bold;" colspan="7"><?php echo diaSemana($guardaData);?></td>
							</tr>
<?php
						}
?>
							<tr class="tr">
								<td class="dez"><a style="font-size:20px;" href='<?php echo $configUrlGer; ?>comercial/compromissos/alterar/<?php echo $dadosCompromisso['codCompromisso'] ?>/' title='Veja os detalhes do compromisso <?php echo $dadosCompromisso['nomeCompromisso'] ?>'><?php echo $dadosCompromisso['horaCompromisso'];?></a></td>
								<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>comercial/compromissos/alterar/<?php echo $dadosCompromisso['codCompromisso'] ?>/' title='Veja os detalhes do compromisso <?php echo $dadosCompromisso['nomeCompromisso'] ?>'><?php echo $dadosCriadorUsuario['nomeUsuario'];?></a></td>
								<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>comercial/compromissos/alterar/<?php echo $dadosCompromisso['codCompromisso'] ?>/' title='Veja os detalhes do compromisso <?php echo $dadosCompromisso['nomeCompromisso'] ?>'><?php echo $enviado;?></a></td>
								<td class="trinta" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>comercial/compromissos/alterar/<?php echo $dadosCompromisso['codCompromisso'] ?>/' title='Veja os detalhes do compromisso <?php echo $dadosCompromisso['nomeCompromisso'] ?>'><?php echo $dadosCompromisso['nomeCompromisso'];?></a></td>
								<td class="vinte" style="text-align:center;"><a href='<?php echo $configUrlGer; ?>comercial/compromissos/alterar/<?php echo $dadosCompromisso['codCompromisso'] ?>/' title='Veja os detalhes do compromisso <?php echo $dadosCompromisso['nomeCompromisso'] ?>'><?php echo $dadosTipoCompromisso['nomeTipoCompromisso'];?></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>comercial/compromissos/ativacao/<?php echo $dadosCompromisso['codCompromisso'] ?>/' title='Deseja desativar o compromisso <?php echo $dadosCompromisso['nomeCompromisso'] ?>?' ><img src="<?php echo $configUrl; ?>f/i/default/corpo-default/<?php echo $status ?>.gif" alt="icone"></a></td>
								<td class="botoes"><a href='<?php echo $configUrl; ?>comercial/compromissos/alterar/<?php echo $dadosCompromisso['codCompromisso'] ?>/' title='Deseja alterar o compromisso <?php echo $dadosCompromisso['nomeCompromisso'] ?>?' ><img src="<?php echo $configUrl;?>f/i/default/corpo-default/icones-alterar.gif" alt="icone" /></a></td>
								<td class="botoes"><a href='javascript: confirmaExclusao(<?php echo $dadosCompromisso['codCompromisso'] ?>, "<?php echo htmlspecialchars($dadosCompromisso['nomeCompromisso']) ?>");' title='Deseja excluir o compromisso <?php echo $dadosCompromisso['nomeCompromisso'] ?>?' ><img src='<?php echo $configUrl; ?>f/i/default/corpo-default/excluir.gif' alt="icone"></a></td>
							</tr>
<?php
					}
?>
							<script>
								function confirmaExclusao(cod, nome){

									if(confirm("Deseja excluir o compromisso "+nome+"?")){
										window.location='<?php echo $configUrlGer; ?>comercial/compromissos/excluir/'+cod+'/';
									}
								}
							</script>	
						</table>	
<?php
				}
?>						
						<br class="clear" />
<?php
				$regPorPagina = 30;
				$area = "comercial/compromissos";
				include ('f/conf/paginacao.php');		
?>
					</div>
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
