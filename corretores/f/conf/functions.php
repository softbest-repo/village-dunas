<?php
	function sentence_case($string) { 
		$sentences = preg_split('/([.?!]+)/', $string, -1, PREG_SPLIT_NO_EMPTY|PREG_SPLIT_DELIM_CAPTURE); 
		$new_string = ''; 
		foreach ($sentences as $key => $sentence) { 
			$new_string .= ($key & 1) == 0? 
				ucfirst(strtolower(trim($sentence))) : 
				$sentence.' '; 
		} 
		return trim($new_string); 
	} 

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
			'host' => "smtp.softbest.com.br",
			'port' => "587",
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

	function formata_data_extenso($strDate){
		// Array com os dia da semana em português;
		$arrDaysOfWeek = array('Domingo', 'Segunda-feira', 'Terça-feira', 'Quarta-feira', 'Quinta-feira', 'Sexta-feira', 'Sábado');
		// Descobre o dia da semana
		$intDayOfWeek = date('w',strtotime($strDate));
		return $arrDaysOfWeek[$intDayOfWeek];
	}

?>
	
