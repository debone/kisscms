<?php
/** 
* kiss-piece.php
* Gerenciador de peças do kiss
*/

function kissPieces(){
	global $request, $piece;

	//Juntamos as peças
	pieceGlue();
}

/**
 * Encontra a peça e insere seus dados
 */
function pieceGlue(){
	global $request,$piece;
	//Encontrar a peça
	if(file_exists(ABS_PATH.'kiss-pieces'.DIRECTORY_SEPARATOR.$piece.DIRECTORY_SEPARATOR.$piece.'.php')){
		require_once(ABS_PATH.'kiss-pieces'.DIRECTORY_SEPARATOR.$piece.DIRECTORY_SEPARATOR.$piece.'.php');
		$func = $piece.'\\init';
		$func();
	}

	$verbFunc = $piece.'\\'.$request['verb'];
	if(function_exists($verbFunc)){
		$verbFunc();
	}
}