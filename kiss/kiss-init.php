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
	global $r;

	//Checar se está tudo ok
	checkKiss();

	// Verbo da requisição (GET,POST,PUT,DELETE)
	$r['verb'] = parseVerb();

	// URL da requisição (/page/2034)
	$r['url'] = parseUrl();

	// Parametros da requisição (GET,POST,JSON)
	$r['parameters'] = parseParameters();

	// Formato da requisição (HTTP, JSON)
	$r['format'] = parseFormat();

	// Função principal
	kissMain();
}

function checkKiss(){
	if(file_exists(ABS_PATH.".htaccess")){

	}
}

function parseVerb(){
	return $_SERVER['REQUEST_METHOD'];
}

function parseUrl(){
	$r = str_replace($_SERVER['CONTEXT_PREFIX'].'/', '', $_SERVER['REQUEST_URI']);
	return array_filter(explode('/', $r));
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

/**
 * [kissMain description]
 * @return [type] [description]
 */
function kissMain(){
	global $r, $piece;
	/**
	 * TODO
	 * Leitor de aliases e erros 404
	 */
	if($r['url'][0] === NULL){
		$piece = 'page';
	}else{
		$piece = $r['url'][0];
	}

	kissSession();
	
	$output = kissPieces();
	echo $output;
}