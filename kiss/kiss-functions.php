<?php
/**
* kiss-functions.php
* Funções gerais do kiss
*/

/**
* function debug
* Para debug
*/
function debug($var){
	echo'<pre>';
	if(is_array($var)){
		print_r($var);
	}else{
		var_dump($var);
	}
	echo'</pre>';
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
    return $protocol . "://" . $host . $port . $_SERVER['REQUEST_URI'];
}