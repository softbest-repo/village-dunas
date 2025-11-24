<?php
	function data($data){
		$data_nova = implode(preg_match("~\/~", $data) == 0 ? "/" : "-", array_reverse(explode(preg_match("~\/~", $data) == 0 ? "-" : "/", $data)));
		return $data_nova;
	}
	
	function ValidaData($data){
		$Vdata = explode("/", $data); // fatia a string $dat em pedados, usando / como referência
		$d = $Vdata[0];
		$m = $Vdata[1];
		$y = $Vdata[2];
		
		$res = checkdate($m,$d,$y);
		return  $res;
		
	}
	
	function geraParcelas($numParcelas, $venc_parcelas) {
		$meses = array();
		$venc_parcelas = implode("-", array_reverse(explode("/",$venc_parcelas)));
		$venc_parcelas = strtotime($venc_parcelas);
		for ($i=0; $i<=$numParcelas - 1; $i++) {
			$meses[$i] = date("Y-m-d", mktime(0,0,0,date("m",$venc_parcelas) + $i, date("d",$venc_parcelas), date("Y",$venc_parcelas)));
			return $meses[$i];
		}
	}
	
	function adicionaZero($preco){
		$valor = explode('.', $preco);
		$caracteresConteudo = strlen($valor[1]);
		if($caracteresConteudo == 1){
			return "0";	
		}else
		if($caracteresConteudo == 0){
			return ".00";
		}else
		if($caracteresConteudo == 2){
			return "";
		}else{
			return "";
		}
	}
		
	function ValidaEmail($email){
	   $mail_correcto = 0;
	   //verifico umas coisas
	   if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
			if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
				//vejo se tem caracter .
				if (substr_count($email,".")>= 1){
					//obtenho a terminação do dominio
					$term_dom = substr(strrchr ($email, '.'),1);
					//verifico que a terminação do dominio seja correcta
					 if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
						//verifico que o de antes do dominio seja correcto
						$antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
						$caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
						if ($caracter_ult != "@" && $caracter_ult != "."){
						   $mail_correcto = 1;
						}
					}
				}
			}
		}

		if ($mail_correcto){
		   return 1;
		}else{
		   return 0;
	    }
	}


	define("STR_REDUCE_LEFT", 1);
	define("STR_REDUCE_RIGHT", 2);
	define("STR_REDUCE_CENTER", 4);

	/*
	*    function str_reduce (str $str, int $max_length [, str $append [, int $position [, bool $remove_extra_spaces ]]])
	*
	*    @return string
	*
	*    Reduz uma string sem cortar palavras ao meio. Pode-se reduzir a string pela
	*    extremidade direita (padrão da função), esquerda, ambas ou pelo centro. Por
	*    padrão, serão adicionados três pontos (...) à parte reduzida da string, mas
	*    pode-se configurar isto através do parâmetro $append.
	*    Mantenha os créditos da função.
	*
	*    @autor: Carlos Reche
	*    @data:  Jan 21, 2005
	*/
	function str_reduce($str, $max_length, $append = NULL, $position = STR_REDUCE_RIGHT, $remove_extra_spaces = true)
	{
		if (!is_string($str))
		{
			echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "() expects parameter 1 to be string.";
			return false;
		}
		else if (!is_int($max_length))
		{
			echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "() expects parameter 2 to be integer.";
			return false;
		}
		else if (!is_string($append)  &&  $append !== NULL)
		{
			echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "() expects optional parameter 3 to be string.";
			return false;
		}
		else if (!is_int($position))
		{
			echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "() expects optional parameter 4 to be integer.";
			return false;
		}
		else if (($position != STR_REDUCE_LEFT)  &&  ($position != STR_REDUCE_RIGHT)  &&
				 ($position != STR_REDUCE_CENTER)  &&  ($position != (STR_REDUCE_LEFT | STR_REDUCE_RIGHT)))
		{
			echo "<br /><strong>Warning</strong>: " . __FUNCTION__ . "(): The specified parameter '" . $position . "' is invalid.";
			return false;
		}


		if ($append === NULL)
		{
			$append = "...";
		}


		$str = html_entity_decode($str);


		if ((bool)$remove_extra_spaces)
		{
			$str = preg_replace("/\s+/s", " ", trim($str));
		}


		if (strlen($str) <= $max_length)
		{
			return htmlentities($str);
		}


		if ($position == STR_REDUCE_LEFT)
		{
			$str_reduced = preg_replace("/^.*?(\s.{0," . $max_length . "})$/s", "\\1", $str);

			while ((strlen($str_reduced) + strlen($append)) > $max_length)
			{
				$str_reduced = preg_replace("/^\s?[^\s]+(\s.*)$/s", "\\1", $str_reduced);
			}

			$str_reduced = $append . $str_reduced;
		}


		else if ($position == STR_REDUCE_RIGHT)
		{
			$str_reduced = preg_replace("/^(.{0," . $max_length . "}\s).*?$/s", "\\1", $str);

			while ((strlen($str_reduced) + strlen($append)) > $max_length)
			{
				$str_reduced = preg_replace("/^(.*?\s)[^\s]+\s?$/s", "\\1", $str_reduced);
			}

			$str_reduced .= $append;
		}


		else if ($position == (STR_REDUCE_LEFT | STR_REDUCE_RIGHT))
		{
			$offset = ceil((strlen($str) - $max_length) / 2);

			$str_reduced = preg_replace("/^.{0," . $offset . "}|.{0," . $offset . "}$/s", "", $str);
			$str_reduced = preg_replace("/^[^\s]+|[^\s]+$/s", "", $str_reduced);

			while ((strlen($str_reduced) + (2 * strlen($append))) > $max_length)
			{
				$str_reduced = preg_replace("/^(.*?\s)[^\s]+\s?$/s", "\\1", $str_reduced);

				if ((strlen($str_reduced) + (2 * strlen($append))) > $max_length)
				{
					$str_reduced = preg_replace("/^\s?[^\s]+(\s.*)$/s", "\\1", $str_reduced);
				}
			}

			$str_reduced = $append . $str_reduced . $append;
		}


		else if ($position == STR_REDUCE_CENTER)
		{
			$pattern = "/^(.{0," . floor($max_length / 2) . "}\s)|(\s.{0," . floor($max_length / 2) . "})$/s";

			preg_match_all($pattern, $str, $matches);

			$begin_chunk = $matches[0][0];
			$end_chunk   = $matches[0][1];

			while ((strlen($begin_chunk) + strlen($append) + strlen($end_chunk)) > $max_length)
			{
				$end_chunk = preg_replace("/^\s?[^\s]+(\s.*)$/s", "\\1", $end_chunk);

				if ((strlen($begin_chunk) + strlen($append) + strlen($end_chunk)) > $max_length)
				{
					$begin_chunk = preg_replace("/^(.*?\s)[^\s]+\s?$/s", "\\1", $begin_chunk);
				}
			}

			$str_reduced = $begin_chunk . $append . $end_chunk;
		}


		return htmlentities($str_reduced);
	}

	function parametros($usuario, $senha){
		$params =
			array (
			'auth' => true,
			'host' => "ssl://smtp.gmail.com",
			'port' => "465",
			'username' => $usuario,
			'password' => $senha);
			
		return $params;
	}
	
	function topoEmail($nomeRemetente, $emailRemetente, $nomeDestino, $emailDestino, $assunto){
		$headers =
			array (
				'From' => $nomeRemetente." <".$emailRemetente.">",
				'To' => $nomeDestino." <".$emailDestino.">",
				'Subject' => $assunto,
				'Content-Type' => "text/html; charset=utf-8",
				'MIME-Version' => '1.0');
		
		return $headers;
	}
	
	function topoEmailOculto($nomeRemetente, $emailRemetente, $nomeDestino, $emailDestino, $assunto){
		$headers =
			array (
				'From' => $nomeRemetente." <".$emailRemetente.">",
				'Bcc' => $nomeDestino." <".$emailDestino.">",
				'Subject' => $assunto,
				'Content-Type' => "text/html; charset=utf-8",
				'MIME-Version' => '1.0');
		
		return $headers;
	}
	
	function diaSemana($data){
		$rs = strftime('%w',strtotime($data));
		switch($rs) {
			case "0": $s = "Domingo"; break;
			case "1": $s = "Segunda-feira"; break;
			case "2": $s = "Terça-feira"; break;
			case "3": $s = "Quarta-feira"; break;
			case "4": $s = "Quinta-feira"; break;
			case "5": $s = "Sexta-feira"; break;
			case "6": $s = "Sábado"; break;
		}
		return $s;
	}
	
	function CalcHora($hora1,$hora2) {
		$calc1=strtotime($hora2);
		$calc2=strtotime($hora1);
		$total=$calc1-$calc2;
		$H=round(($total/60)/60,4);
		$h=explode('.',$H);
		$M='0'.'.'.$h[1];
		$h=$h[0];
		$m=$M*60;
		$m=explode('.',$m);
		$s='0'.'.'.$m[1];
		$s=round($s*60);
		$m=$m[0];	
		if($h<0) $h=$h*(-1);
		if($h>=0 && $h<=9) $h='0'.$h;
		if($m>=0 && $m<=9) $m='0'.$m;
		if($s>=0 && $s<=9) $s='0'.$s;

		$resposta=$h.':'.$m.':'.$s;

		return $resposta;

	}

	function somaHora($hora01, $hora02){
		
		$times = array(
		  $hora01,
		  $hora02,
		);

		$seconds = 0;

		foreach ( $times as $time ){
		   list( $g, $i, $s ) = explode( ':', $time );
		   $seconds += $g * 3600;
		   $seconds += $i * 60;
		   $seconds += $s;
		}

		$hours = floor( $seconds / 3600 );
		$seconds -= $hours * 3600;
		$minutes = floor( $seconds / 60 );
		$seconds -= $minutes * 60;
		
		$contHora = strlen($hours);
		if($contHora < 2){
			$hours = "0".$hours;	
		}
		
		$contMinuto = strlen($minutes);
		if($contMinuto < 2){
			$minutes = "0".$minutes;	
		}
		
		$contSegundo = strlen($seconds);
		if($contSegundo < 2){
			$seconds = "0".$seconds;	
		}
		
/*
		return "{$hours}:{$minutes}:{$seconds}";
*/
		return "{$hours}:{$minutes}";

	}
	
	
	function somaDia($dias, $mes, $dia, $ano){
		$dataFinal = mktime(24*$dias, 0, 0, $mes, $dia, $ano);
		$dataFormatada = date('d/m/Y',$dataFinal);
		return $dataFormatada;
	}

//~ Mascara Valor
		function mask($val, $mask){
		 $maskared = '';
		 $k = 0;
			for($i = 0; $i<=strlen($mask)-1; $i++){
				if($mask[$i] == '#'){
					if(isset($val[$k]))$maskared .= $val[$k++];
				}else{
					if(isset($mask[$i]))$maskared .= $mask[$i];
				}
			}
			return $maskared;
		}			
?>
	
