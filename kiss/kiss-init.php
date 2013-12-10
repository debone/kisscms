<?php
/**
* kiss-init.php
* Iniciação do CMS
*/

//Inclusão de arquivos
require(KISS_PATH.'kiss-functions.php');
require(KISS_PATH.'kiss-session.php');
require(KISS_PATH.'kiss-pieces.php');

function kissInit(){
	global $r,$piece;

	// Nível de recursão do KISS
	$r['recursion'] = parseRecursion();

	checkKiss();

	// Verbo da requisição (GET,POST,PUT,DELETE)
	$r['verb'] = parseVerb();

	// URL da requisição (/page/2034)
	$r['url'] = parseUrl();

	// Peça 
	$piece = $r['url'][0];

	// Parametros da requisição (GET,POST,JSON)
	$r['parameters'] = parseParameters();

	// Formato da requisição (HTTP, JSON)
	$r['format'] = parseFormat();


	// Função principal
	kissMain();
}

/**
 * Ao inicializar o sistema precisamos verificar se está tudo ok
 * Principalmente na primeira execução 
 */
function checkKiss(){
	if(file_exists(ABS_PATH.".htaccess")){

	}

	//Evita recursão infinita
	if($r['recursion'] > RECURSION_KISS){
		//TODO Log de erro/Fatal
		exit();
	}
}

/**
 * Faz a análise do verbo da requisição
 * @return string Verbo da requisição
 */
function parseVerb(){
	return $_SERVER['REQUEST_METHOD'];
}

/**
 * Faz a análise da URL da requisição
 * O KISS utiliza a url como caminhos para as peças
 * @return array Blocos de url para utilização das peças 
 */
function parseUrl(){
	//Separa o diretório da requisição
	$dir = str_replace('index.php', '', $_SERVER['PHP_SELF']);
	$r = str_replace($dir, '', $_SERVER['REQUEST_URI']);
	
	//$r = r('aliases',array())
	//d(r(NS_KISS,array('url'=>$r)));
	//d(NS_KISS);

	//Separa os caminhos em blocos
	$r = array_filter(explode('/', $r));

	/**
	 * Cascading para peça
	 * $r['url'][0] é sempre uma peça
	 * 0. Teste rápido se é um (int) -> Não precisa de mais testes, é uma página (x)
	 * 1. Checar se existe uma peça com o mesmo nome (x)
	 * 2. Checar se existe um alias para o nome 
	 * 3. Checar se existe uma pagina com o nome 
	 * 4. Erro 404
	 */
	$piece = $r[0];
/*
	d($piece);
	d(filePath($piece.'.php', 'kiss-pieces'));*/
	$path = filePath($piece.'.php', 'kiss-pieces', ABS_PATH);

	if(is_int($piece) || empty($path)){
		array_unshift($r, 'page');
	}
	
	return $r;
}


function parseParameters(){
	$parameters = array();

	// Parametros da requisição GET
	if(isset($_SERVER['QUERY_STRING'])){
		$parameters = $_GET;
	}

	// Parametros das requisições PUT/POST
	// (Sobrepõe as requisições GET)
	$body = file_get_contents("php://input");
	$contentType = false;

	// Checa o tipo do input
	if(isset($_SERVER['CONTENT_TYPE'])){
		$contentType = $_SERVER['CONTENT_TYPE'];
	}

	if(strstr($contentType, "application/json")){
		// Decodifica o JSON para $parameters
		$bodyParams = json_decode($body);
		if($bodyParams){
			foreach ($bodyParams as $paramName => $paramValue) {
				$parameters[$paramName] = $paramValue;
			}
		}
	}else if(strstr($contentType, "application/x-www-form-urlencoded")){
		// Decodifica o POST para $parameters
		parse_str($body, $postVars);

		foreach($postVars as $field => $value){
			$parameters[$field] = $value;
		}
	}

	if(isset($_POST)){
		foreach($_POST as $field => $value){
			$parameters[$field] = $value;
		}	
	}

	return $parameters;
}

function parseFormat(){
	$format = '';

	if(isset($_SERVER['CONTENT_TYPE'])){
		$contentType = $_SERVER['CONTENT_TYPE'];
	}

	if(strstr($contentType, "application/json")){
		$format = 'json';
	}else if(strstr($contentType, "application/x-www-form-urlencoded")){
		$format = 'http';
	}

	return $format;
}

function parseRecursion(){
	global $r;

	if(!empty($r['parameters']['recursion'])){
		$rec = $r['parameters']['recursion'];
		//TODO Remover parametro
	}else{
		$rec = 0;
	}

	return $rec;
}

/**
 * [kissMain description]
 * @return [type] [description]
 */
function kissMain(){
	global $r;
	/**
	 * TODO
	 * Leitor de aliases e erros 404
	 */

	if(function_exists('xdebug_start_trace'))
		xdebug_start_trace(LOG_PATH.'xdebug'.$r['recursion']);

	$output = kissPieces();

	if(function_exists('xdebug_stop_trace'))
		xdebug_stop_trace();

	echo $output;
}