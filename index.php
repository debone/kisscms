<?php
/**
* index.php
* Arquivo de entrada
* Toda requisição dentro dessa pasta que não for arquivo passa aqui
*/

/**
 * Absolute path of KISS
 */
define("ABS_PATH", __DIR__.DIRECTORY_SEPARATOR);

define("KISS_PATH", ABS_PATH.'kiss'.DIRECTORY_SEPARATOR);

require(KISS_PATH."kiss-config.php");

require(KISS_PATH."kiss-init.php");

ob_start();

kissInit();


ob_end_flush();

global $r;
//Se estivermos de volta para o nível zero de recursão e existir alguma informação
//de debug devemos colocar ela na página 
if(!$r['recursion'] && is_file(LOG_PATH.'debug.log') && $f=fopen(LOG_PATH.'debug.log','r')){
	echo '<hr><br><span style="font-weight:600">DEBUG</span>';
	while(!feof($f)){
		echo trim(fgets($f)).'<br>';
	}
	fclose($f);
	unlink(LOG_PATH.'debug.log');
}