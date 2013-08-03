<?php
namespace page;

function init(){
	global $request;

	$pageLocal = pageLocal();

	if($pageLocal !== ''){
		echo file_get_contents($pageLocal);
	}else{
		echo r('richtext', array('piece'=>'page', 'action'=>implode('/',$request['url'])));
	}
}

function post(){
	d('GOT IT');
}

function pageLocal(){
	global $request;

	if($request['url'][1]==NULL || !is_integer($request['url'][1]+0)){
		$page = 0;
	}else{
		$page = $request['url'][1];
	}

	$kissPageLocal = '';

	if(file_exists(SITE_PATH.'page/'.$page.'.kiss')){
		$kissPageLocal = SITE_PATH.'page/'.$page.'.kiss';
	}else if(file_exists(SITE_PATH.'page/'.$page.DIRECTORY_SEPARATOR.$page.'.kiss')){
		$kissPageLocal = SITE_PATH.'page/'.$page.DIRECTORY_SEPARATOR.$page.'.kiss';
	}

	return $kissPageLocal;
}