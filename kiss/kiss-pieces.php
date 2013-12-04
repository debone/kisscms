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
	
	//Incluir a peça
	require_once(filePath($piece.'.php', 'kiss-pieces', ABS_PATH));

	$funcInit = $piece.'\\init';
	$funcMain = $piece.'\\main';
	$funcQuit = $piece.'\\quit';

	/**
	 * Array de configurações da peça
	 * @var array
	 *
	 * $config['output'] 'JSON', 'HTML' Formata o output da peça para a saída
	 * TODO $config['dependency'] Define as dependências do peça em relação a outras
	 * TODO $config['']
	 */
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

	//Ler opções da peça sobre a saída
	if(empty($config['output'])){
		//Padrão de retorno JSON
		//Inclui o nome do modulo + recursao para js e css
		$output['piece'] = $piece.$r['recursion'];
		//Faz o merge com os outros js e css de recursões
		$output['js'] = array_merge((array)$js, array($output['piece']=>$output['js']));
		$output['css'] = array_merge((array)$css, array($output['piece']=>$output['css']));
		//Deixa o output em branco para o html caso a peça mantenha sem html
		$output['html'] = (empty($output['html'])) ? '': $output['html'];
		$output = json_encode($output);
	}//Se não, retorna HTML

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