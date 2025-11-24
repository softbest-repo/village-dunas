<?php 
	include ('../../f/conf/config.php');
	
	$codigoImovel = $_GET['codigoImovel'];

	$num_com_zeros = str_pad($codigoImovel, 4, "0", STR_PAD_LEFT);
	
	$sqlImovel = "SELECT * FROM imoveis I inner join cidades C on I.codCidade = C.codCidade inner join bairros B on I.codBairro = B.codBairro inner join tipoImovel TI on I.codTipoImovel = TI.codTipoImovel left join quadras Q on I.quadraImovel = Q.codQuadra left join lotes L on I.loteImovel = L.codLote WHERE I.statusImovel = 'T' and I.codigoImovel = ".$num_com_zeros." ORDER BY codImovel DESC LIMIT 0,1";
	$resultImovel = $conn->query($sqlImovel);
	if($resultImovel->num_rows > 0){
		$dadosImovel = $resultImovel->fetch_assoc();
		$data[] = $dadosImovel;
	}else{
		echo "Imóvel não encontrado";
	}
	
	header('Content-Type: application/json');
	echo json_encode($data);	
?>
