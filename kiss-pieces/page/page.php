<?php
namespace page;

function init(){
	global $r;
}

function get($output){
	global $r, $pageLocal;

	$pageLocal = pageLocal($r['url'][1]);

	if($pageLocal !== ''){
		$output .= file_get_contents($pageLocal);
		pieceRoute(array(
			'edit'
		));
	}else{
		$output .= r('richtext', array('piece'=>'page', 'action'=>absUrl($r['url']), 'content'=>''));
	}

	return $output;
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

function delete(){
	global $r;

	$page = $r['url'][1];

	if($pg = pageLocal($page)){
		unlink($pg);
	}

	d('Deletar pagina!');
}

function pageLocal($page){
	global $r;

	if($page == NULL){
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

function head(){
	global $css;

	$content = '<html>';
	$content .= '<head>';
	$content .= '<title>KISSCMS</title>';
	$content .= '<meta charset="utf-8">';

	if(is_array($css)){
		$content .= '<style>'; 
		foreach($css as $code){
			$content .= $code;
		}
		$content .= '</style>';
	}

	$content .= '</head><body>';

	return $content;
}

function footer(){
	global $js;
	$content = '';

	if(is_array($js)){
		$content .= '<script>';
		foreach($js as $code){
			$content .= $code;
		}
		$content .= '</script>';
	}

	$content .= '</body></html>';
	return $content;
}

function quit($output){
	$o = head();
	
	$o .= $output;
	
	$o .= footer();

	return $o;
}