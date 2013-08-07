<?php
/** 
* kiss-piece.php
* Gerenciador de peças do kiss
*/

function kissPieces(){
	global $r, $piece;

	//Juntamos as peças
	pieceGlue();
}

/**
 * Encontra a peça e insere seus dados
 */
function pieceGlue(){
	global $r, $piece;
	//Encontrar a peça
	if(file_exists(ABS_PATH.'kiss-pieces'.DIRECTORY_SEPARATOR.$piece.DIRECTORY_SEPARATOR.$piece.'.php')){
		require_once(ABS_PATH.'kiss-pieces'.DIRECTORY_SEPARATOR.$piece.DIRECTORY_SEPARATOR.$piece.'.php');
		$func = $piece.'\\init';
		$func();
	}

	$verbFunc = $piece.'\\'.$r['verb'];
	if(function_exists($verbFunc)){
		$verbFunc();
	}
}

function pieceRoute($router){
	global $r, $piece;

	for ($i=count($r['url']); $i >= 0; $i--){
		for ($c=count($router), $j = 0; $j < $c; $j++){
			if($r['url'][$i] === $router[$j]){
				$func = $piece.'\\'.$router[$j];
				$func();
				return;
			} 
		}
	}

	//404?
}