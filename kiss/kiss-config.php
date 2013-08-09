<?php
/**
* kiss-config.php
* Arquivo de configurações
*/

/**
 * PHP inicia seus scripts com ob_start para gzip
 * Evitamos isso para não ocorrer erros
 */
if(ob_get_level()) ob_get_clean();


error_reporting( E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_ERROR | E_WARNING | E_PARSE | E_USER_ERROR | E_USER_WARNING | E_RECOVERABLE_ERROR );
