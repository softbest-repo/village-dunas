<?php
	function criaUrl($text) {
	    $text = strtolower(trim($text));
		$utf8 = array(
			'/[áàâãªä]/u'   =>   'a',
			'/[ÁÀÂÃÄ]/u'    =>   'A',
			'/[ÍÌÎÏ]/u'     =>   'I',
			'/[íìîï]/u'     =>   'i',
			'/[éèêë]/u'     =>   'e',
			'/[ÉÈÊË]/u'     =>   'E',
			'/[óòôõºö]/u'   =>   'o',
			'/[ÓÒÔÕÖ]/u'    =>   'O',
			'/[úùûü]/u'     =>   'u',
			'/[ÚÙÛÜ]/u'     =>   'U',
			'/ç/'           =>   'c',
			'/Ç/'           =>   'C',
			'/ñ/'           =>   'n',
			'/Ñ/'           =>   'N',
			'/–/'           =>   '', // UTF-8 hyphen to "normal" hyphen
			'/[’‘‹›‚]/u'    =>   ' ', // Literally a single quote
			'/[“”«»„]/u'    =>   ' ', // Double quote
			'/ /'           =>   '-', // nonbreaking space (equiv. to 0x160)
		);
		$text = preg_replace(array_keys($utf8), array_values($utf8), $text);
		$text = preg_replace('/[ -]+/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('/' , '-' , $text);
		$text = str_replace('?' , '' , $text);
		$text = str_replace('?' , '' , $text);
		$text = str_replace('?' , '' , $text);
		$text = str_replace('?' , '' , $text);
		$text = str_replace('?' , '' , $text);
		$text = str_replace('?' , '' , $text);
		$text = str_replace('"' , '' , $text);
		$text = str_replace('"' , '' , $text);
		$text = str_replace('"' , '' , $text);
		$text = str_replace('"' , '' , $text);
		$text = str_replace('"' , '' , $text);
		$text = str_replace('"' , '' , $text);
		$text = strtolower(trim($text));		
		return $text;
	}	

	function preparaNome($str) {
		return trim(htmlspecialchars($str, ENT_QUOTES));
	}
?>
	
