<?php
namespace richtext;

function main(){
	global $r;
	$p = $r['parameters'];

	$output['html'] = form($p['action'], $p['content']);

	$output['css'] = "body{background-color:#333;}";

	$output['js'] = "console.log('hello');";

	r('jstest');

	return $output;
}

function form($action='', $content=''){
	$content = <<<FORM
	<form method="post" action="$action">
		<textarea name="page">$content</textarea>
		<input type="submit">
		<input name="_method_delete" value="Deletar página" type="submit">
	</form>
FORM;
	return $content;
}