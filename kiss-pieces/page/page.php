<?php
namespace page;

function init(){
	global $request;

	$pageLocal = pageLocal();

	echo file_get_contents($pageLocal);
}

function pageLocal(){
	if($request['url'][1]==NULL){
		$page = 0;
	}else{
		$page = $request['url'][1] + 0;
	}

	if(file_exists(SITE_PATH.'page/'.$page.'.kiss')){
		$kissPageLocal = SITE_PATH.'page/'.$page.'.kiss';
	}else if(file_exists(SITE_PATH.'page/'.$page.DIRECTORY_SEPARATOR.$page.'.kiss')){
		$kissPageLocal = SITE_PATH.'page/'.$page.DIRECTORY_SEPARATOR.$page.'.kiss';
	}

	return $kissPageLocal;
}