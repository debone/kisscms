<?php
/** 
* kiss-piece.php
* Gerenciador de peças do kiss
*/

function kissPieces(){
	global $r, $piece;

	//Juntamos as peças
	return pieceGlue();
}

/**
 * Encontra a peça e insere seus dados
 */
function pieceGlue(){
	global $r, $piece, $js, $css;
	//Encontrar a peça
	if(file_exists(ABS_PATH.'kiss-pieces'.DIRECTORY_SEPARATOR.$piece.DIRECTORY_SEPARATOR.$piece.'.php')){
		require_once(ABS_PATH.'kiss-pieces'.DIRECTORY_SEPARATOR.$piece.DIRECTORY_SEPARATOR.$piece.'.php');
	}

	$funcInit = $piece.'\\init';
	$funcQuit = $piece.'\\quit';
	$funcMain = $piece.'\\main';

	$config = array();

	if(function_exists($funcInit)){
		$config = $funcInit($config);
	}

	$verbFunc = (!isset($r['parameters']['_method_delete'])) ?
				$piece.'\\'.$r['verb'] :
				$piece.'\\delete';

	$output = '';

	if(function_exists($verbFunc)){
		$output = $verbFunc($output);
	}elseif(function_exists($funcMain)){
		$output = $funcMain($output);
	}

	if(function_exists($funcQuit)){
		$output = $funcQuit($output);
	}

	//Ler opções do piece
	if(empty($config['output'])){
		//Padrão de retorno é JSON
		$output = json_encode($output);
	}//Retorna HTML

	return $output;
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