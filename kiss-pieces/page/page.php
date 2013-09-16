<?php
namespace page;

function init($config){
	$config['output'] = 'html';

	return $config;
}

function get($output){
	global $r, $pageLocal;

	$pageLocal = pageLocal($r['url'][1]);

	if($pageLocal !== ''){
		$data = map($pageLocal);
		$tplName = (isset($data['template'])) ? $data['template'] : 'page';
		$output .= r('template/'.$tplName, array('data'=>http_build_query($data)));
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
			fwrite($f,$r['parameters']['page']);
			fclose($f);
		}
	}else{
		if($f = fopen(SITE_PATH.'page/'.$page.'.kiss','w+')){
			fwrite($f,$r['parameters']['page']);
			fclose($f);
		}
	}
}

function delete(){
	global $r;

	$page = $r['url'][1];

	if($pg = pageLocal($page)){
		unlink($pg);
	}
}

function pageLocal($page){
	if($page == NULL || !is_numeric($page)){
		//TODO Tratar erros 404 e fazer aliases
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
}

function head(){
	global $css;

	$content = '<html>';
	$content .= '<head>';
	$content .= '<title>KISSCMS</title>';
	$content .= '<meta charset="utf-8">';

	if(is_array($css)){
		$content .= '<style>'; 
		foreach($css as $piece=>$code){
			$content .= "/* ".$piece." CSS */\n";
			$content .= $code."\n";
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
		foreach($js as $piece=>$code){
			$content .= "/* ".$piece." JS */\n";
			$content .= $code."\n";
		}
		$content .= '</script>';
	}

	$content .= '</body></html>';
	return $content;
}

function map($pageLocal){
	$data = array();
	$var = '';
	if($f = fopen($pageLocal,'r')){
		while(!feof($f)){
			$line = trim(fgets($f));
			if($line[0] === '$'){
				$var = substr(trim($line),1);
				$data[$var] = '';
			}elseif($var!=='' && $line!==''){
				$data[$var] .= $line;
			}
		}
	}

	return $data;
}

function quit($output){
	$o = head();
	
	$o .= $output;
	
	$o .= footer();

	return $o;
}