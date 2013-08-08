<?php
/**
*
*
*/

function kissSession(){
	session_start();

	$_SESSION['nome'] = "Joao";

	session_write_close();

	$_SESSION['filho'] = "Roberto";
}