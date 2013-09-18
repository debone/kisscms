<?php
namespace jstest;

function main(){
	global $r;

	$output['js'] = "console.log('Jstest')";
	$output['css'] = "body{background-color:pink}";

	return $output;
}