<?php
/**
* index.php
* Arquivo de entrada
* Toda requisição dentro dessa pasta que não for arquivo passa aqui
*/

define("ABS_PATH", __DIR__.DIRECTORY_SEPARATOR);
define("KISS_PATH", ABS_PATH.'kiss'.DIRECTORY_SEPARATOR);
define("SITE_PATH", ABS_PATH.'site'.DIRECTORY_SEPARATOR);

require(KISS_PATH."kiss-config.php");

require(KISS_PATH."kiss-init.php");

ob_start();

kissInit();

global $request;

ob_end_flush();

global $d;

if(isset($d)){
	echo '<hr><br><span style="font-weight:600">DEBUG</span>';
	echo $d;
}