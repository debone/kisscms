<?php
namespace jstest;

function main(){
	global $r;

	d(r(NS_KISS,array('url'=>$r)));

	$output['js'] = "console.log('Jstest')";
	$output['css'] = "body{background-color:pink}";

	return $output;
}