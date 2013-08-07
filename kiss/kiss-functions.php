<?php
/**
* kiss-functions.php
* Funções gerais do kiss
*/

/**
* function d
* Para debug
*/
function d($var, $quit = 0){
	echo'<pre>';
	if(is_array($var)){
		print_r($var);
	}else{
		var_dump($var);
	}
	echo'</pre>';

	if($quit){
		exit();
	}
}

/**
* function fullUrl
* Mostra a URL completa quando chamado
*
* @return string
*  A URL completa
*/
function fullUrl(){
    $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $sp = strtolower($_SERVER["SERVER_PROTOCOL"]);
    $protocol = substr($sp, 0, strpos($sp, "/")) . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
    $host = (isset($_SERVER['HTTP_HOST']) && !empty($_SERVER['HTTP_HOST']))? $_SERVER['HTTP_HOST']:$_SERVER['SERVER_NAME'];
    return $protocol . "://" . $host . $port . $_SERVER['CONTEXT_PREFIX'];
}

/**
 * function absUrl
 * Monta uma url absoluto para a url requisitada
 */
function absUrl($url){
	return $_SERVER['CONTEXT_PREFIX'].'/'.implode('/',$url);
}

/**
*	function r()
*	Faz requisições REST internas
*
*	@param string $url
*		URL interno da requisição
*	@param array $data
*		Dados para envio POST
*	@param array $headers
*		Cabeçalhos para a requisição
*
*	@return
*		O resultado da requisição
*/

function r($url, $data=null, $headers=null){
	//Monta e limpa a Url base (Ex.: http://localhost/kiss)
	$url = fullUrl().'/'.$url;

	$ch = curl_init($url);

	$cookie = array();
	foreach ( $_COOKIE as $key => $value ) {
		$cookie[] = $key . '=' . $value;
	}

	$cookie = implode( '; ', $cookie );

	curl_setopt( $ch, CURLOPT_COOKIE, $cookie );

	if($headers && $headers!=''){
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	}
	if($data && $data!='' && is_array($data)){
		$fieldsString = '';
		foreach ($data as $k => $v) {
			$fields_string .= $key.'='.urlencode($value).'&';
		}
		rtrim($fields_string, '&');
		curl_setopt($ch, CURLOPT_POST, count($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}elseif($data && $data!='' && is_string($data)){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	$result = curl_exec($ch);

	curl_close($ch);

	return $result;
}