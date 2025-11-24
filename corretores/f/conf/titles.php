<?php
	if($url[2] == ""){
		$title = $nomeEmpresa;
		$description = "";
	}else
	if($url[2] == "loteamentos"){
		$title = "Loteamentos | ".$nomeEmpresa;
		
		if($url[3] != ""){		
			if($url[3] == "destaques"){
				$title = "Lotes em Destaque - Loteamentos | ".$nomeEmpresa;				
			}else{
				$sqlLoteamento = "SELECT nomeLoteamento, descricaoLoteamento FROM loteamentos WHERE urlLoteamento = '".$url[3]."' LIMIT 0,1";
				$resultLoteamento = $conn->query($sqlLoteamento);
				$dadosLoteamento = $resultLoteamento->fetch_assoc();

				$title = $dadosLoteamento['nomeLoteamento']." - Loteamentos | ".$nomeEmpresa;
				$description = strip_tags($dadosLoteamento['descricaoLoteamento']);
			}
		}
	}else		
	if($url[2] == "login"){
		$title = "Login - ".$nomeEmpresa;
		$description = "";
	}else
	if($url[2] == "minha-conta"){
		$title = "Minha Conta - ".$nomeEmpresa;
		$description = "";
		
		if($url[3] == "minhas-reservas"){
			$title = "Reservas - Minha Conta - ".$nomeEmpresa;
			$description = "";			
		}
		
		if($url[3] == "minhas-vendas"){
			$title = "Vendas - Minha Conta - ".$nomeEmpresa;
			$description = "";			
		}
				
		if($url[3] == "editar-dados"){
			$title = "Meus dados - Minha Conta - ".$nomeEmpresa;
			$description = "";			
		}
				
		if($url[3] == "negociacoes"){
			$title = "Negociações - Minha Conta - ".$nomeEmpresa;
			$description = "";			
		}
	}else
	if($url[2] == "informativos"){
		$title = "Informações Importantes - ".$nomeEmpresa;
		$description = "";
	}else	
	if($url[2] == "esqueci-minha-senha"){
		$title = "Esqueci minha Senha - ".$nomeEmpresa;
		$description = "";
	}else{
		$title = "Página não encontrada | ".$nomeEmpresa;
		$description = "Utilize os menu acima para navegar pelo site";
	}
		
	$keywords = $keywordsConfig; 
?>

