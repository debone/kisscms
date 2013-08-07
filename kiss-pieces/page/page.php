<?php
namespace page;

function init(){
	global $r;
}

function get(){
	global $r, $pageLocal;
	$pageLocal = pageLocal($r['url'][1]);

	if($pageLocal !== ''){
		echo file_get_contents($pageLocal);
		pieceRoute(array(
			'edit'
		));
	}else{
		echo r('richtext', array('piece'=>'page', 'action'=>absUrl($r['url']), 'content'=>''));
		d('Criar pagina');
	}
}

function post(){
	global $r;

	$page = $r['url'][1];

	if($pg = pageLocal($page)){
		if($f = fopen($pg,'r+')){
			d('Editada!');
			fwrite($f,$r['parameters']['page']);
			fclose($f);
		}
	}else{
		if($f = fopen(SITE_PATH.'page/'.$page.'.kiss','w+')){
			d('Criada!');
			fwrite($f,$r['parameters']['page']);
			fclose($f);
		}
	}
	d('Salvar página');
}

function pageLocal($page){
	global $r;

	if($page ==NULL || !is_integer($page+0)){
		$page = 0;
	}

	$kissPageLocal = '';

	if(file_exists(SITE_PATH.'page/'.$page.'.kiss')){
		$kissPageLocal = SITE_PATH.'page/'.$page.'.kiss';
	}else if(file_exists(SITE_PATH.'page/'.$page.DIRECTORY_SEPARATOR.$page.'.kiss')){
		$kissPageLocal = SITE_PATH.'page/'.$page.DIRECTORY_SEPARATOR.$page.'.kiss';
	}

	return $kissPageLocal;
}

function edit(){
	global $r, $pageLocal;
	echo r('richtext', array(
		'piece'=>'page', 
		'action'=>absUrl($r['url']), 
		'content' => file_get_contents($pageLocal)
	));
	d('Editar pagina');
}