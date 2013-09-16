<?php
/**
* index.php
* Arquivo de entrada
* Toda requisição dentro dessa pasta que não for arquivo passa aqui
*/

define("ABS_PATH", __DIR__.DIRECTORY_SEPARATOR);
define("KISS_PATH", ABS_PATH.'kiss'.DIRECTORY_SEPARATOR);
define("SITE_PATH", ABS_PATH.'site'.DIRECTORY_SEPARATOR);

xdebug_start_trace(ABS_PATH.'xdebug');

require(KISS_PATH."kiss-config.php");

require(KISS_PATH."kiss-init.php");

ob_start();

kissInit();

global $r;

ob_end_flush();

if(!$r['recursion'] && is_file(ABS_PATH.'debug.log') && $f=fopen(ABS_PATH.'debug.log','r')){
	echo '<hr><br><span style="font-weight:600">DEBUG</span>';
	while(!feof($f)){
		echo trim(fgets($f)).'<br>';
	}
	fclose($f);
	unlink(ABS_PATH.'debug.log');
}