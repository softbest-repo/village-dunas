<?php 
	include ('../../f/conf/config.php');
	include ('../../f/conf/functions.php');

	$codCidade = $_POST['codCidade'];
	$codBairro = $_POST['codBairro'];
	$codQuadra = $_POST['codQuadra'];
	$codLote = $_POST['codLote'];
	$liberaDup = $_POST['liberaDup'];

	$sqlComissao = "SELECT * FROM comissoes WHERE statusComissao = 'T' and codCidade = '".$codCidade."' and codBairro = '".$codBairro."' and codQuadra = '".$codQuadra."' and codLote = '".$codLote."' ORDER BY codComissao DESC LIMIT 0,1";
	$resultComissao = $conn->query($sqlComissao);
	$dadosComissao = $resultComissao->fetch_assoc();
	
	if($dadosComissao['codComissao'] == "" || $liberaDup == "T"){
					
		$sqlImoveisConfere = "SELECT I.* FROM imoveis I inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$codQuadra."' and I.loteImovel = '".$codLote."' ORDER BY I.codImovel DESC LIMIT 0,1";
		$resultImoveisConfere = $conn->query($sqlImoveisConfere);
		$dadosImoveisConfere = $resultImoveisConfere->fetch_assoc();
								
		if($dadosImoveisConfere['codImovel'] == ""){			
			
			$sqlImoveisConfere = "SELECT I.* FROM imoveis I inner join imoveisLotes IL on I.codImovel = IL.codImovel inner join usuarios U on I.codUsuario = U.codUsuario WHERE I.statusImovel = 'T' and I.codCidade = '".$codCidade."' and I.codBairro = '".$codBairro."' and I.quadraImovel = '".$codQuadra."' and IL.nomeLote = '".$codLote."' ORDER BY I.codImovel DESC LIMIT 0,1";
			$resultImoveisConfere = $conn->query($sqlImoveisConfere);
			$dadosImoveisConfere = $resultImoveisConfere->fetch_assoc();
			
		}
		
		if($dadosImoveisConfere['codImovel'] != ""){	
			if($dadosImoveisConfere['tipoVenda'] == "A"){	
				echo "A";
			}else{
				echo "P";				
			}
		}else{
			echo "erro";
		}
	}else{
		echo "existe-".data($dadosComissao['dataComissao']);
	}
?>
