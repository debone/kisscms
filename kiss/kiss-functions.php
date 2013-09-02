<?php
/**
* kiss-functions.php
* Funções gerais do kiss
*/

global $d;

/**
* function d
* Para debug
*/
function d($var, $quit = 0){
	global $d;

	ob_start();
	$info = debug_backtrace();

	echo'<pre>';
	echo $info[0]['file'];
	echo '  ::  '.$info[0]['line'].'<br>';
	if(is_array($var)){
		print_r($var);
	}else{
		var_dump($var);
	}
	echo'</pre>';

	$d .= ob_get_clean();

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
	global $js, $css;
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
			$fieldsString .= $k.'='.urlencode($v).'&';
		}
		rtrim($fieldsString, '&');
		curl_setopt($ch, CURLOPT_POST, count($data));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);
	}elseif($data && $data!='' && is_string($data)){
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
	}

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	$result = curl_exec($ch);

	curl_close($ch);

	$resultArray = json_decode($result, true);

	if(is_array($resultArray)){
		$js[] = (isset($resultArray['js'])) ? $resultArray['js'] : '';
		$css[] = (isset($resultArray['css'])) ? $resultArray['css'] : '';
	}

	return (isset($resultArray['html'])) ? $resultArray['html'] : $result;
}