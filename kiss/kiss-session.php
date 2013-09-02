<?php
/**
*
*
*/

function s($key, $value = null){
	//Se o a sessao não foi iniciada, inicia
	if(!session_id()){
		session_start();
	}

	if($value==null){
		//Retorna o valor da chave pedida
		$return = $_SESSION[$key];
	}else{
		//Retorna true para a inserção/atualização do valor
		$return = 1;
		$_SESSION[$key] = $value;
	}

	//Fecha a leitura do arquivo para evitar locks de arquivos do SO
	session_write_close();

	return $return;
}