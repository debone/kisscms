<?php 
namespace template;

function main(){
	global $r;

	$tpl = $r['url'][1];
	$data = array();

	parse_str($r['parameters']['data'], $data);

	$output['html'] = template($tpl,$data);

	return $output;
}

function tplLocal($tpl){
	$tplLocal = '';
	if(file_exists(ABS_PATH.'site'.DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.$tpl.'.tpl')){
		$tplLocal = ABS_PATH.'site'.DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.$tpl.'.tpl';
	}elseif(file_exists(ABS_PATH.'site'.DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.$tpl.DIRECTORY_SEPARATOR.$tpl.'.tpl')){
		$tplLocal = ABS_PATH.'site'.DIRECTORY_SEPARATOR.'tpl'.DIRECTORY_SEPARATOR.$tpl.DIRECTORY_SEPARATOR.$tpl.'.tpl';
	}

	return $tplLocal;
}

function template($tplName, $data){
	//Se o template existe e o local dele
	if($tplLocal = tplLocal($tplName)){

		//Inclui o template e pega o conteúdo processado pelo php
		ob_start();
		require_once($tplLocal);
		$tpl = ob_get_contents();
		ob_end_clean();

		//Faz a compilação das variaveis do template com os dados que estão na pagina
		foreach($data as $k => $v){
			if(strpos($tpl,$k)!==false){
				$tpl = str_replace('['.$k.']', $v, $tpl);
			}
		}
	}

	return $tpl;
}