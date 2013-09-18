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
	$d = '';
	ob_start();
	$info = debug_backtrace();

	echo'<pre>';
	echo $info[0]['file'];
	echo '  ::  '.$info[0]['line'].'<br>';
/*	if(is_array($var)){
		print_r($var);
	}else{*/
		var_dump($var);
	//}
	echo'</pre>';

	$d .= ob_get_clean();

	if($f = fopen(LOG_PATH.'debug.log','a+')){
		fwrite($f,$d);
		fclose($f);
	}

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
 * Faz uma busca no caminho passado e na pasta, retorna o caminho completo se existir
 * @return [type] [description]
 */
function filePath($file, $folder, $PATH = SITE_PATH){
	$local = '';
	$fileName = pathinfo($file, PATHINFO_FILENAME);
	$fileExt = pathinfo($file, PATHINFO_EXTENSION);
	if(file_exists($PATH.$folder.DIRECTORY_SEPARATOR.$fileName.'.'.$fileExt)){
		$local = $PATH.$folder.DIRECTORY_SEPARATOR.$fileName.'.'.$fileExt;
	}else if(file_exists($PATH.$folder.DIRECTORY_SEPARATOR.$fileName.DIRECTORY_SEPARATOR.$fileName.'.'.$fileExt)){
		$local = $PATH.$folder.DIRECTORY_SEPARATOR.$fileName.DIRECTORY_SEPARATOR.$fileName.'.'.$fileExt;
	}
	return $local;
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
	global $r, $js, $css;
	//Monta e limpa a Url base (Ex.: http://localhost/kiss)
	$url = fullUrl().'/'.$url;

	$ch = curl_init($url);

	$cookie = array();
	foreach ( $_COOKIE as $key => $value ) {
		$cookie[] = $key . '=' . $value;
	}

	$cookie = implode( '; ', $cookie );

	curl_setopt( $ch, CURLOPT_COOKIE, $cookie );

	$headers[] = "Connection: close";

	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	if(!empty($data) && is_string($data)){
		$data = array($data);
	}

	$data['recursion'] = $r['recursion'] + 1;
	
	$fieldsString = http_build_query($data);

	curl_setopt($ch, CURLOPT_POST, count($data));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $fieldsString);

	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );

	curl_setopt( $ch, CURLOPT_VERBOSE, TRUE);
	$fp = fopen(LOG_PATH.'curl'.$r['recursion'].'.log','w+');
	curl_setopt( $ch, CURLOPT_STDERR, $fp);

	curl_setopt($ch, CURLOPT_IPRESOLVE, CURL_IPRESOLVE_V4 );

	$result = curl_exec($ch);

	curl_close($ch);

	$resultArray = json_decode($result, true);

	if(is_array($resultArray)){
		$js = (isset($resultArray['js'])) ? $resultArray['js'] : '';
		$css = (isset($resultArray['css'])) ? $resultArray['css'] : '';
	}

	return (isset($resultArray['html'])) ? $resultArray['html'] : $result;
}