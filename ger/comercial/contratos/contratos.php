<?php
	if($_COOKIE['loginAprovado'.$cookie] != ""){

		if(controleUsuario($conn) == "tem usuario"){
			
			$area = "contratos";
			if(validaAcesso($conn, $area) == "ok"){	

				$sqlNomeContrato = "SELECT * FROM contratos WHERE codContrato = '".$url[6]."' LIMIT 0,1";
				$resultNomeContrato = $conn->query($sqlNomeContrato);
				$dadosNomeContrato = $resultNomeContrato->fetch_assoc();

				$sqlCliente = "SELECT * FROM clientes WHERE codCliente = '".$dadosNomeContrato['codCliente']."' ORDER BY codCliente DESC LIMIT 0,1";
				$resultCliente = $conn->query($sqlCliente);
				$dadosCliente = $resultCliente->fetch_assoc();						

				$sqlImovel = "SELECT * FROM imoveis I inner join contratosImoveis CI on I.codImovel = CI.codImovel WHERE CI.codContrato = '".$dadosNomeContrato['codContrato']."' ORDER BY I.codImovel DESC LIMIT 0,1";
				$resultImovel = $conn->query($sqlImovel);
				$dadosImovel = $resultImovel->fetch_assoc();
				
 				$sqlUsuario = "SELECT * FROM usuarios WHERE codUsuario = ".$dadosImovel['codUsuario']." LIMIT 0,1";
				$resultUsuario = $conn->query($sqlUsuario);
				$dadosUsuario = $resultUsuario->fetch_assoc();						
?>
					<div id="localizacao-topo">
						<div id="conteudo-localizacao-topo">
							<p class="nome-lista">Comercial</p>
							<p class="flexa"></p>
							<p class="nome-lista">Contratos</p>
							<p class="flexa"></p>
							<p class="nome-lista">Cliente</p>
							<p class="flexa"></p>
							<p class="nome-lista"><?php echo $dadosCliente['nomeCliente'] ;?></p>
							<br class="clear" />
						</div>
						<table class="tabela-interno">
							<div class="botao-consultar"><a title="Consultar Opções" href="<?php echo $configUrl;?>comercial/contratos/"><div class="esquerda-consultar"></div><div class="conteudo-consultar">Consultar</div><div class="direita-consultar"></div></a></div>												
						</table>	
					</div>
					<script type="text/javascript">
						function imprimeRequisicao(id, pg) {
							 var oPrint, oJan;
							 var $r = jQuery.noConflict();
							 $r("#conteudo-imprimir").fadeOut("slow");
							 $r(".botao-alterar").css("display", "none");
							document.getElementById("botao-imprimir").style.display="table";
							 oPrint = window.document.getElementById(id).innerHTML;
							 oJan = window.open(pg);
							 // Adiciona a tag <title> à janela aberta
								var customTitle = "<title>Nome Personalizado do PDF</title>";
								oJan.document.write("<html><head>" + customTitle + "</head><body>" + oPrint + "</body></html>");  
							 oJan.history.go();
							 location.href="<?php echo $configUrl;?>comercial/contratos/contratos/<?php echo $url[6];?>/";
						}						

						function fechaArquivo(){
							var $rr = jQuery.noConflict();
							$rr("#conteudo-imprimir").fadeOut("slow");
						}
						
						function abrirImprimir(documento){
							var $ee = jQuery.noConflict();
							location.href="#topo";
							$ee("#conteudo-imprimir").fadeIn("slow");
							$ee(".fecha-docs").fadeOut(50);
							$ee(".bloco-campo-altera").css("display", "none");
							$ee("#campo-altera"+documento).fadeIn("slow");
							$ee("#"+documento).fadeIn("slow");
						}
						
						function colocaValue(cod){
							var $rc = jQuery.noConflict();
							pegaValue = document.getElementById("value-altera"+cod).value;
							document.getElementById("altera"+cod).innerHTML=pegaValue;
							$rc("#campo-altera"+cod).fadeOut("slow");
						}
						
						function cadastraContrato(cod){
							var $re = jQuery.noConflict();
							$re(".bloco-campo-altera").css("display", "none");
							$re("#campo-altera"+cod).fadeIn("slow");
							document.getElementById("value-altera"+cod).focus()
						}						
					</script>
<?php
	$sqlCidade = "SELECT * FROM cidade WHERE codCidade = ".$dadosCliente['codCidade']." LIMIT 0,1";
	$resultCidade = $conn->query($sqlCidade);
	$dadosCidade = $resultCidade->fetch_assoc();

	$sqlCidades = "SELECT * FROM cidades WHERE codCidade = ".$dadosImovel['codCidade']." LIMIT 0,1";
	$resultCidades = $conn->query($sqlCidades);
	$dadosCidades = $resultCidades->fetch_assoc();
	
	$cidadeImovel = $dadosCidades['nomeCidade']." / SC";

	$sqlBairro = "SELECT * FROM bairros WHERE codBairro = ".$dadosImovel['codBairro']." LIMIT 0,1";
	$resultBairro = $conn->query($sqlBairro);
	$dadosBairro = $resultBairro->fetch_assoc();
	
	$sqlEstado = "SELECT * FROM estado WHERE codEstado = ".$dadosCliente['codEstado']." LIMIT 0,1";
	$resultEstado = $conn->query($sqlEstado);
	$dadosEstado = $resultEstado->fetch_assoc();
	
	if($dadosCidades['nomeCidade'] == "Balneário Arroio do Silva"){
		$forum = "Araranguá / SC";
	}else
	if($dadosCidades['nomeCidade'] == "Araranguá"){
		$forum = "Araranguá / SC";
	}else
	if($dadosCidades['nomeCidade'] == "Sombrio"){
		$forum = "Sombrio / SC";
	}else
	if($dadosCidades['nomeCidade'] == "Balneário Gaivota"){
		$forum = "Sombrio / SC";
	}else
	if($dadosCidades['nomeCidade'] == "Passo de Torres"){
		$forum = "Santa Rosa do Sul / SC";
	}else
	if($dadosCidades['nomeCidade'] == "Santa Rosa do Sul"){
		$forum = "Santa Rosa do Sul / SC";
	}

	function valorPorExtenso($value, $uppercase = 0) {
		if (strpos($value, ",") > 0) {
			$value = str_replace(".", "", $value);
			$value = str_replace(",", ".", $value);
		}
	 
		$singular = ["centavo", "real", "mil", "milhão", "bilhão", "trilhão", "quatrilhão"];
		$plural = ["centavos", "reais", "mil", "milhões", "bilhões", "trilhões", "quatrilhões"];
	 
		$c = ["", "cem", "duzentos", "trezentos", "quatrocentos", "quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos"];
		$d = ["", "dez", "vinte", "trinta", "quarenta", "cinquenta", "sessenta", "setenta", "oitenta", "noventa"];
		$d10 = ["dez", "onze", "doze", "treze", "quatorze", "quinze", "dezesseis", "dezesete", "dezoito", "dezenove"];
		$u = ["", "um", "dois", "três", "quatro", "cinco", "seis", "sete", "oito", "nove"];
	 
		$z = 0;
	 
		$value = number_format($value, 2, ".", ".");
		$integer = explode(".", $value);
		$cont = count($integer);
	 
		for ($i = 0; $i < $cont; $i++)
			for ($ii = strlen($integer[$i]); $ii < 3; $ii++)
				$integer[$i] = "0" . $integer[$i];
	 
		$fim = $cont - ($integer[$cont - 1] > 0 ? 1 : 2);
		$rt = '';
		for ($i = 0; $i < $cont; $i++) {
			$value = $integer[$i];
			$rc = (($value > 100) && ($value < 200)) ? "cento" : $c[$value[0]];
			$rd = ($value[1] < 2) ? "" : $d[$value[1]];
			$ru = ($value > 0) ? (($value[1] == 1) ? $d10[$value[2]] : $u[$value[2]]) : "";
	 
			$r = $rc . (($rc && ($rd || $ru)) ? " e " : "") . $rd . (($rd &&
					$ru) ? " e " : "") . $ru;
			$t = $cont - 1 - $i;
			$r .= $r ? " " . ($value > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($value == "000"
			)
				$z++;
			elseif ($z > 0)
				$z--;
			if (($t == 1) && ($z > 0) && ($integer[0] > 0))
				$r .= ( ($z > 1) ? " de " : "") . $plural[$t];
			if ($r)
				$rt = $rt . ((($i > 0) && ($i <= $fim) &&
						($integer[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " e ") : " ") . $r;
		}
	 
	 return trim($rt ? $rt : "zero");
	}

	function metragemPorExtenso($valor=0) {
		$singular = array("centavo", "", "mil", "milhão", "bilhão", "trilhão", "quatrilhão");
		$plural = array("centavos", "", "mil", "milhões", "bilhões", "trilhões","quatrilhões");

		$c = array("", "cem", "duzentos", "trezentos", "quatrocentos","quinhentos", "seiscentos", "setecentos", "oitocentos", "novecentos");
		$d = array("", "dez", "vinte", "trinta", "quarenta", "cinquenta","sessenta", "setenta", "oitenta", "noventa");
		$d10 = array("dez", "onze", "doze", "treze", "quatorze", "quinze","dezesseis", "dezesete", "dezoito", "dezenove");
		$u = array("", "um", "dois", "três", "quatro", "cinco", "seis","sete", "oito", "nove");

		$z=0;
		
		$quebraValor = explode(",", $valor);
		if($quebraValor[1] != "" && $quebraValor[1] != "00"){
			$confere = " e meio";
		}else{
			$confere = "";
		}
		
		$valor = number_format($valor, 2, ".", ".");
		$inteiro = explode(".", $valor);
		for($i=0;$i<count($inteiro);$i++)
			for($ii=strlen($inteiro[$i]);$ii<3;$ii++)
				$inteiro[$i] = "0".$inteiro[$i];

		// $fim identifica onde que deve se dar junção de centenas por "e" ou por "," 😉
		$fim = count($inteiro) - ($inteiro[count($inteiro)-1] > 0 ? 1 : 2);
		for ($i=0;$i<count($inteiro);$i++) {
			$valor = $inteiro[$i];
			$rc = (($valor > 100) && ($valor < 200)) ? "" : $c[$valor[0]];
			$rd = ($valor[1] < 2) ? "" : $d[$valor[1]];
			$ru = ($valor > 0) ? (($valor[1] == 1) ? $d10[$valor[2]].$confere : $u[$valor[2]].$confere) : "";

			$r = $rc.(($rc && ($rd || $ru)) ? " e " : "").$rd.(($rd && $ru) ? " e " : "").$ru;
			$t = count($inteiro)-1-$i;
			$r .= $r ? " ".($valor > 1 ? $plural[$t] : $singular[$t]) : "";
			if ($valor == "000")$z++; elseif ($z > 0) $z--;
			if (($t==1) && ($z>0) && ($inteiro[0] > 0)) $r .= (($z>1) ? " " : "").$plural[$t]; 
			if ($r) $rt = $rt . ((($i > 0) && ($i <= $fim) && ($inteiro[0] > 0) && ($z < 1)) ? ( ($i < $fim) ? ", " : " ") : " ") . $r;
		}

		return($rt ? $rt : "zero");
	}

	function numeroPorExtenso($numero) {
		$unidades = ['', 'um', 'dois', 'três', 'quatro', 'cinco', 'seis', 'sete', 'oito', 'nove'];
		$dezenas = ['', 'dez', 'vinte', 'trinta', 'quarenta', 'cinquenta', 'sessenta', 'setenta', 'oitenta', 'noventa'];
		$especiais = [10 => 'dez', 11 => 'onze', 12 => 'doze', 13 => 'treze', 14 => 'quatorze', 15 => 'quinze', 16 => 'dezesseis', 17 => 'dezessete', 18 => 'dezoito', 19 => 'dezenove'];
		$centenas = ['', 'cento', 'duzentos', 'trezentos', 'quatrocentos', 'quinhentos', 'seiscentos', 'setecentos', 'oitocentos', 'novecentos'];

		if ($numero == 100) {
			return 'cem';
		}

		$texto = '';

		if ($numero >= 100) {
			$texto .= $centenas[intval($numero / 100)] . ' ';
			$numero %= 100;
		}

		if ($numero >= 10 && $numero <= 19) {
			$texto .= $especiais[$numero] . ' ';
		} else {
			if ($numero >= 20) {
				$texto .= $dezenas[intval($numero / 10)] . ' e ';
				$numero %= 10;
			}
			if ($numero > 0) {
				$texto .= $unidades[$numero] . ' ';
			}
		}

		return trim($texto);
	}

	function metrosPorExtenso($medida) {
		$parteInteira = floor($medida);
		$parteDecimal = fmod($medida, 1);

		$extenso = numeroPorExtenso($parteInteira);
		if ($parteDecimal > 0) {
			$extenso .= ' vírgula ' . numeroPorExtenso(round($parteDecimal * 100));
		}

		return $extenso . ' metros';
	}

	function dimensoesPorExtenso($largura, $comprimento) {
		$larguraExtenso = metrosPorExtenso($largura);
		$comprimentoExtenso = metrosPorExtenso($comprimento);

		return "$larguraExtenso de largura por $comprimentoExtenso de comprimento";
	}	
	
	function mesPortugues($mesData){

		if($mesData == "January"){
			$mesData = "Janeiro";
		}else
		if($mesData == "February"){
			$mesData = "Fevereiro";
		}else
		if($mesData == "March"){
			$mesData = "Março";
		}else
		if($mesData == "April"){
			$mesData = "Abril";
		}else
		if($mesData == "May"){
			$mesData = "Maio";
		}else
		if($mesData == "June"){
			$mesData = "Junho";
		}else
		if($mesData == "July"){
			$mesData = "Julho";
		}else
		if($mesData == "August"){
			$mesData = "Agosto";
		}else
		if($mesData == "September"){
			$mesData = "Setembro";
		}else
		if($mesData == "October"){
			$mesData = "Outubro";
		}else
		if($mesData == "November"){
			$mesData = "Novembro";
		}else
		if($mesData == "December"){
			$mesData = "Dezembro";
		}
		
		return $mesData;
		
	}	
							
	if($dadosCliente['sexoCliente'] == "M"){
		$sexo = "M";
	}else{
		$sexo = "S";
	}
	if($dadosCliente['civilCliente'] == "S"){
		if($sexo == "M"){
			$civil = "Solteiro";
		}else{
			$civil = "Solteira";
		}
	}else
	if($dadosCliente['civilCliente'] == "C"){
		if($sexo == "M"){
			$civil = "Casado";
			$civilFrase = "casado";
		}else{
			$civil = "Casada";
			$civilFrase = "casada";
		}
	}else
	if($dadosCliente['civilCliente'] == "D"){
		if($sexo == "M"){
			$civil = "Divorciado";
		}else{
			$civil = "Divorciada";
		}
	}else
	if($dadosCliente['civilCliente'] == "V"){
		if($sexo == "M"){
			$civil = "Viúvo";
		}else{
			$civil = "Viúva";
		}
	}else
	if($dadosCliente['civilCliente'] == "U"){
		if($sexo == "M"){
			$civil = "União Estável";
		}else{
			$civil = "União Estável";
		}
	}
	
	$valorContrato = number_format($dadosNomeContrato['valorContrato'], 2, ",", ".")." (".trim(valorPorExtenso($dadosNomeContrato['valorContrato'])).")";
	$valorContrato2 = number_format($dadosNomeContrato['valorContrato'], 2, ",", ".");

	$nomeCliente = trim($dadosCliente['nomeCliente']);
	$nacionalidade = trim($dadosCliente['nacionalidadeCliente']);
	$civil = trim($civil);
	$profissao = trim($dadosCliente['profissaoCliente']);
	if($dadosCliente['tipoCliente'] == "F"){
		$cpf = "CPF nº ".trim($dadosCliente['cpfCliente']);
		$cpf2 = "CPF: ".trim($dadosCliente['cpfCliente']);
	}else{
		$cpf = "CNPJ nº ".trim($dadosCliente['cpfCliente']);		
		$cpf2 = "CNPJ: ".trim($dadosCliente['cpfCliente']);		
	}
	$rg = trim($dadosCliente['rgCliente']);
	$emissor = trim($dadosCliente['emissorCliente']);
	$endereco = trim($dadosCliente['enderecoCliente']).", nº ".trim($dadosCliente['numeroCliente']).", bairro ".trim($dadosCliente['bairroCliente']).", cidade de ".trim($dadosCidade['nomeCidade'])."/".trim($dadosEstado['siglaEstado'])." (".trim($dadosCliente['cepCliente']).")";
	$endereco2 = trim($dadosCliente['enderecoCliente']).", nº ".trim($dadosCliente['numeroCliente']).", bairro ".trim($dadosCliente['bairroCliente']).", cidade de ".trim($dadosCidade['nomeCidade'])."/".trim($dadosEstado['siglaEstado'])."";
	$cep = trim($dadosCliente['cepCliente']);
	$telefone = $dadosCliente['telefoneCliente'] != "" ? trim($dadosCliente['telefoneCliente']) : trim($dadosCliente['celularCliente']);
	$telefone2 = trim($dadosCliente['telefoneCliente']);
	$celular = trim($dadosCliente['celularCliente']);
	$email = trim($dadosCliente['emailCliente']);
	$nomeConjugue = trim($dadosCliente['nomeConjugueCliente']);
	$nacionalidadeConjugue = trim($dadosCliente['nacionalidadeConjugueCliente']);
	$profissaoConjugue = trim($dadosCliente['profissaoConjugueCliente']);
	$cpfConjugue = trim($dadosCliente['cpfConjugueCliente']);
	$rgConjugue = trim($dadosCliente['rgConjugueCliente']);
	$emissorConjugue = trim($dadosCliente['emissorConjugueCliente']);
	if($dadosCliente['civilCliente'] == "C" || $dadosCliente['civilCliente'] == "U"){
		$conjugue = $civilFrase." com <strong>".$nomeConjugue."</strong>, ".$nacionalidadeConjugue.", ".$profissaoConjugue.", CPF nº ".$cpfConjugue.", RG nº ".$rgConjugue." ".$emissorConjugue.", residentes e domiciliados";
	}else{
		$conjugue = "residente e domiciliado";
	}
	
	$dataCartorio = $dadosNomeContrato['dataCartorioContrato'];
	$quebraDataCartorio = explode("-", $dataCartorio);
	
	$dataHoje = $quebraDataCartorio[2]." de ".mesPortugues(strftime('%B', strtotime($dataCartorio)))." de ".$quebraDataCartorio[0];
	$dataHoje2 = date('d')." de ".mesPortugues(strftime('%B', strtotime(date('Y-m-d'))))." de ".date('Y');
	$endereco = trim($dadosImovel['enderecoImovel']);
	$lote = trim($dadosImovel['loteImovel']);
	$quadra = trim($dadosImovel['quadraImovel']);
	$matricula = trim($dadosImovel['matriculaImovel']);
	if($dadosImovel['frenteImovel'] == ""){
		$frente = 1;
	}else{
		$frente = str_replace(",", ".", $dadosImovel['frenteImovel']);
	}
	if($dadosImovel['fundoImovel'] == ""){
		$fundo = 1;
	}else{
		$fundo = str_replace(",", ".", $dadosImovel['fundoImovel']);
	}
	$bairro = trim($dadosBairro['nomeBairro']);
	$cidade = trim($dadosCidades['nomeCidade']);
	$estado = trim($dadosCidades['estadoCidade']);
	$rua = trim($dadosImovel['enderecoImovel']);
	$area = trim($dadosImovel['metragemImovel']);
		
	$_SESSION['contratoArras'] = "";
	$_SESSION['contratoArrasComissao'] = "";
?>					
					<style>
						* {list-style:disc;}
						h1 {color:#000; font-weight:bold;}
						h2 {color:#000; font-weight:bold;}
						h3 {color:#000; font-weight:bold;}
					</style>
					<script type="text/javascript">
						var editors = document.querySelectorAll('.textarea');
						editors.forEach(function(editor) {
							CKEDITOR.replace(editor.id);
						});

						function cadastraContrato(cod, codExt){
							var $rt = jQuery.noConflict();	
							
							var cod = cod;
							var contrato = "<?php echo $url[6];?>";
							var editor = CKEDITOR.instances["textarea-"+codExt];
							var editorData = editor.getData();

							var texto = editorData;
										
							var caracteres = texto.length;
							var textoGuardado = document.getElementById("guardado-"+codExt).value;																																
														
							$rt.post("<?php echo $configUrlGer;?>comercial/contratos/salva-contrato.php", {codContrato: contrato, codContratoItem: cod, textoContratoItem: texto}, function(data){		
								if(caracteres <= 310){
									editor.setData(textoGuardado);
								}
								alert("Documento Salvo!");
							});								
						}				
					</script>					
					<div id="conteudo-imprimir" style="width:900px; margin-top:-100px; min-height:700px; display:none; position:absolute; z-index:1; left:50%; margin-left:-450px; box-shadow:0px 0px 20px #528585; border-radius:10px; background-color:#FFFFFF;">
						<div id="conteudo-scroll" style="width:900px; height:730px; overflow-y:auto; overflow-x:hidden;">
							<p class="botao-fechar" onClick="fechaArquivo();" style="width:25px; color:#FFFFFF; padding:1px; padding-top:2px; text-align: center; cursor: pointer; position: absolute; z-index:1; background-color:#718B8F; border-radius:235px; font-size:20px; margin-left:892px; margin-top:-15px;">X</p>
							<div id="imprime-requisicao" style="width:852px; padding-top:50px; padding-bottom:20px; margin:0 20px auto;">
								<div id="conteudo-requisicao" style="width:852px; overflow-y:auto;">
									<script type="text/javascript">
										function imprime() {
											var oJan;
											oJan.window.print();
										}
																		
										function tiraBotao() {
											document.getElementById("botao-imprimir").style.display="none";									 
										}								
									</script>
									<p style="display:none; margin: auto; margin-bottom:20px;" id="botao-imprimir"><input type="submit" value="Imprimir" onClick="tiraBotao(); imprime(window.print());"/></p>
									<div id="mostra-dados" style="width:100%; height:100%;">
										<div class="fecha-docs" id="contratoArras" style="display:none; height:100%;">
											<p id="botao-alterar-contratoArras" class="botao-alterar" onClick="cadastraContrato(1, 'contratoArras');" style="width:135px; text-align:center; position:absolute; cursor:pointer; padding:6px 20px; margin-top:-34px; margin-left:340px; border-radius:15px; background-color:#666; color:#FFF;">Salvar Alteração</p>
<?php
	$sqlContratoItem = "SELECT * FROM contratosItens WHERE codContrato = ".$url[6]." and codContratoItem = 1 LIMIT 0,1";
	$resultContratoItem = $conn->query($sqlContratoItem);
	$dadosContratoItem = $resultContratoItem->fetch_assoc();
	
	if($dadosContratoItem['codContratoItem'] != ""){
?>
											<div id="campo-contratoArras" style="width:850px; height:100%; position:relative;">
												<textarea class="campo textarea" id="textarea-contratoArras" type="text" style="width:850px; height:100%; position:relative;" ><?php echo $dadosContratoItem['textoContratoItem'];?></textarea>
												<textarea class="campo" id="guardado-contratoArras" type="text" style="display:none;"><?php echo $_SESSION['contratoArras'];?></textarea>
											</div>
<?php
	}else{
?>			
											<div id="campo-contratoArras" style="width:850px; height:100%; position:relative;">									
												<textarea class="campo textarea" id="textarea-contratoArras" type="text" style="width:850px; height:100%; position:relative;" ><?php echo $_SESSION['contratoArras']; ?></textarea>
												<textarea class="campo" id="guardado-contratoArras" type="text" style="display:none;"><?php echo $_SESSION['contratoArras']; ?></textarea>
											</div>
<?php
	}
?>

										</div>
										<div class="fecha-docs" id="contratoArrasComissao" style="display:none; height:100%;">
											<p id="botao-alterar-contratoArrasComissao" class="botao-alterar" onClick="cadastraContrato(1, 'contratoArrasComissao');" style="width:135px; text-align:center; position:absolute; cursor:pointer; padding:6px 20px; margin-top:-34px; margin-left:340px; border-radius:15px; background-color:#666; color:#FFF;">Salvar Alteração</p>
<?php
	$sqlContratoItem = "SELECT * FROM contratosItens WHERE codContrato = ".$url[6]." and codContratoItem = 2 LIMIT 0,1";
	$resultContratoItem = $conn->query($sqlContratoItem);
	$dadosContratoItem = $resultContratoItem->fetch_assoc();
	
	if($dadosContratoItem['codContratoItem'] != ""){
?>
											<div id="campo-contratoArrasComissao" style="width:850px; height:100%; position:relative;">
												<textarea class="campo textarea" id="textarea-contratoArrasComissao" type="text" style="width:850px; height:100%; position:relative;" ><?php echo $dadosContratoItem['textoContratoItem'];?></textarea>
												<textarea class="campo" id="guardado-contratoArrasComissao" type="text" style="display:none;"><?php echo $_SESSION['contratoArrasComissao'];?></textarea>
											</div>
<?php
	}else{
?>			
											<div id="campo-contratoArrasComissao" style="width:850px; height:100%; position:relative;">									
												<textarea class="campo textarea" id="textarea-contratoArrasComissao" type="text" style="width:850px; height:100%; position:relative;" ><?php echo $_SESSION['contratoArrasComissao']; ?></textarea>
												<textarea class="campo" id="guardado-contratoArrasComissao" type="text" style="display:none;"><?php echo $_SESSION['contratoArrasComissao']; ?></textarea>
											</div>
<?php
	}
?>

										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
					<div id="dados-conteudo">
						<div id="consultas">		
							<table class="tabela-menus" >
								<tr class="titulo-tabela" border="none">
									<th class="canto-esq">Contrato</th>
									<th class="canto-dir">Imprimir</th>
								</tr>					
								<tr class="tr">
									<td class="oitenta" style="text-align:center;">Contrato 1</td>
									<td class="vinte" style="text-align:center; cursor:pointer;" onClick="abrirImprimir('contratoArras');"><img src="<?php echo $configUrl;?>f/i/icon-impressora2.png" width="50"/></td>
								</tr>
								<tr class="tr">
									<td class="oitenta" style="text-align:center;">Contrato 2</td>
									<td class="vinte" style="text-align:center; cursor:pointer;" onClick="abrirImprimir('contratoArrasComissao');"><img src="<?php echo $configUrl;?>f/i/icon-impressora2.png" width="50"/></td>
								</tr>
							</table>							
						</div>					
					</div>
					<script>
						CKEDITOR.config.height = 600;
						CKEDITOR.config.width = 'auto';										
						CKEDITOR.config.contentsCss = 'data:text/css;charset=utf-8,' + encodeURIComponent(`
							body {
								line-height: 1.4 !important; /* Ajuste o valor conforme necessário */
								font-family:Sans-serif;
								font-size:13px;
							}
						`);
					</script>
<?php
			}else{
?>	
				<div id="filtro">
					<div id="erro-permicao">	
<?php
				echo "<p><strong>Vocês não tem permissão para acessar essa área!</strong></p>";
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
