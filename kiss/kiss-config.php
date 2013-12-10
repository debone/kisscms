<?php
/**
* kiss-config.php
* Arquivo de configurações
*/

define("LOG_PATH", ABS_PATH.'log'.DIRECTORY_SEPARATOR);
define("SITE_PATH", ABS_PATH.'site'.DIRECTORY_SEPARATOR);


/**
 * PHP inicia seus scripts com ob_start para gzip
 * Evitamos isso para não ocorrer erros
 */
if(ob_get_level()) ob_get_clean();

error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );

//Naming piece
define("NS_KISS",'ns');

//Limite de recursao
define("RECURSION_KISS", 50);